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

// Function to send JSON response
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit();
}

try {
    // Include database configuration
    $databasePath = __DIR__ . '/../../../config/database.php';
    if (!file_exists($databasePath)) {
        throw new Exception('Database configuration file not found at: ' . $databasePath);
    }
    
    require_once $databasePath;
    
    // Get request data
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    $requestData = [];
    
    // Handle JSON input
    if (strpos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents('php://input'), true) ?: [];
        $requestData = $input;
    } 
    // Handle form data
    else {
        $requestData = $_POST;
    }
    
    // Get action and review ID
    $action = $_REQUEST['action'] ?? $requestData['action'] ?? '';
    $reviewId = $_REQUEST['review_id'] ?? $requestData['review_id'] ?? '';
    
    // Log the request
    error_log('Request: ' . print_r([
        'method' => $_SERVER['REQUEST_METHOD'],
        'action' => $action,
        'review_id' => $reviewId,
        'post' => $_POST,
        'get' => $_GET,
        'input' => file_get_contents('php://input')
    ], true));
    
    if (empty($action) || empty($reviewId)) {
        throw new Exception('Missing required parameters: action and review_id');
    }
    
    // Initialize database connection
    $database = new Database();
    $pdo = $database->getConnection();
    
    if (!$pdo) {
        throw new Exception('Failed to connect to database');
    }
    
    // Process the action
    switch ($action) {
        case 'toggle_status':
            $response = toggleReviewStatus($pdo, $reviewId);
            sendResponse($response);
            break;
            
        case 'delete':
            $response = deleteReview($pdo, $reviewId);
            sendResponse($response);
            break;
            
        default:
            sendResponse([
                'success' => false, 
                'message' => 'Invalid action: ' . $action
            ], 400);
            break;
    }
    
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
                'line' => $e->getLine()
            ]
        ]
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function toggleReviewStatus($pdo, $reviewId) {
    // First, get the current status
    $stmt = $pdo->prepare("SELECT reviewer_status FROM reviews WHERE review_id = ?");
    $stmt->execute([$reviewId]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$review) {
        return ['success' => false, 'message' => 'Review not found'];
    }
    
    $currentStatus = $review['reviewer_status'];
    $newStatus = '';
    
    // Logic for status toggle:
    // - If pending: make it public
    // - If private: make it public  
    // - If public: make it private
    if ($currentStatus === 'pending') {
        $newStatus = 'public';
    } elseif ($currentStatus === 'private') {
        $newStatus = 'public';
    } elseif ($currentStatus === 'public') {
        $newStatus = 'private';
    } else {
        // Default: make it public
        $newStatus = 'public';
    }
    
    // Update the status
    $updateStmt = $pdo->prepare("UPDATE reviews SET reviewer_status = ? WHERE review_id = ?");
    $result = $updateStmt->execute([$newStatus, $reviewId]);
    
    if ($result) {
        return [
            'success' => true, 
            'message' => 'Status updated successfully',
            'old_status' => $currentStatus,
            'new_status' => $newStatus
        ];
    } else {
        return ['success' => false, 'message' => 'Failed to update status'];
    }
}

function deleteReview($pdo, $reviewId) {
    // Check if review exists
    $stmt = $pdo->prepare("SELECT review_id FROM reviews WHERE review_id = ?");
    $stmt->execute([$reviewId]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$review) {
        return ['success' => false, 'message' => 'Review not found'];
    }
    
    // Delete the review
    $deleteStmt = $pdo->prepare("DELETE FROM reviews WHERE review_id = ?");
    $result = $deleteStmt->execute([$reviewId]);
    
    if ($result) {
        return [
            'success' => true, 
            'message' => 'Review deleted successfully'
        ];
    } else {
        return ['success' => false, 'message' => 'Failed to delete review'];
    }
}
?> 