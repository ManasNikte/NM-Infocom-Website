<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Include database configuration
    $databasePath = __DIR__ . '/../../../config/database.php';
    if (!file_exists($databasePath)) {
        throw new Exception('Database configuration file not found at: ' . $databasePath);
    }
    require_once $databasePath;
    $database = new Database();
    $pdo = $database->getConnection();
    if (!$pdo) {
        throw new Exception('Failed to connect to database');
    }

    // Handle POST actions (toggle_status, delete)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $reviewId = $_POST['review_id'] ?? '';
        if (empty($action) || empty($reviewId)) {
            throw new Exception('Missing required parameters: action and review_id');
        }
        if ($action === 'toggle_status') {
            $stmt = $pdo->prepare("SELECT reviewer_status FROM reviews WHERE id = ?");
            $stmt->execute([$reviewId]);
            $review = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$review) {
                echo json_encode(['success' => false, 'message' => 'Review not found']);
                exit;
            }
            $currentStatus = $review['reviewer_status'];
            $newStatus = ($currentStatus === 'pending' || $currentStatus === 'private') ? 'public' : 'private';
            $updateStmt = $pdo->prepare("UPDATE reviews SET reviewer_status = ?, updated_at = NOW() WHERE id = ?");
            $result = $updateStmt->execute([$newStatus, $reviewId]);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Status updated successfully',
                    'old_status' => $currentStatus,
                    'new_status' => $newStatus
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update status']);
            }
            exit;
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("SELECT id FROM reviews WHERE id = ?");
            $stmt->execute([$reviewId]);
            $review = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$review) {
                echo json_encode(['success' => false, 'message' => 'Review not found']);
                exit;
            }
            $deleteStmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
            $result = $deleteStmt->execute([$reviewId]);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Review deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete review']);
            }
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            exit;
        }
    }

    // GET: Fetch reviews (existing logic)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
    if ($perPage < 1) $perPage = 5;
    if ($perPage > 50) $perPage = 50;
    $offset = ($page - 1) * $perPage;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $status = isset($_GET['status']) ? trim($_GET['status']) : '';
    $query = "SELECT * FROM reviews WHERE 1=1";
    $countQuery = "SELECT COUNT(*) as total FROM reviews WHERE 1=1";
    $params = [];
    $countParams = [];
    if (!empty($search)) {
        $searchTerm = "%$search%";
        $query .= " AND (reviewer_name LIKE ? OR reviewer_email LIKE ? OR review_text LIKE ?)";
        $countQuery .= " AND (reviewer_name LIKE ? OR reviewer_email LIKE ? OR review_text LIKE ?)";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        $countParams = array_merge($countParams, [$searchTerm, $searchTerm, $searchTerm]);
    }
    if (!empty($status) && in_array($status, ['public', 'private', 'pending'])) {
        $query .= " AND reviewer_status = ?";
        $countQuery .= " AND reviewer_status = ?";
        $params[] = $status;
        $countParams[] = $status;
    }
    $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $params = array_merge($params, [(int) $perPage, (int) $offset]);
    // Count query
    $countStmt = $pdo->prepare($countQuery);
    foreach ($countParams as $key => $value) {
        $countStmt->bindValue($key + 1, $value);
    }
    if (!$countStmt->execute()) {
        $errorInfo = $countStmt->errorInfo();
        throw new Exception("Count query failed: " . ($errorInfo[2] ?? 'Unknown error'));
    }
    $totalReviews = (int)$countStmt->fetchColumn();
    $totalPages = $perPage > 0 ? ceil($totalReviews / $perPage) : 1;
    // Main query
    $stmt = $pdo->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    if (!$stmt->execute()) {
        $errorInfo = $stmt->errorInfo();
        throw new Exception("Query execution failed: " . ($errorInfo[2] ?? 'Unknown error'));
    }
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response = [
        'success' => true,
        'reviews' => $reviews,
        'pagination' => [
            'page' => $page,
            'totalPages' => $totalPages,
            'totalReviews' => $totalReviews
        ]
    ];
    echo json_encode($response);
} catch (Exception $e) {
    error_log('[' . date('Y-m-d H:i:s') . '] Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
    http_response_code(500);
    $response = [
        'success' => false,
        'error' => [
            'message' => 'An error occurred while processing your request.',
            'debug' => [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'production') ? null : $e->getTraceAsString()
            ]
        ]
    ];
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
