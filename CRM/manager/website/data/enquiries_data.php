<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');



// Get pagination parameters
$page = max(1, (int) ($_GET['page'] ?? 1));
$rowsPerPage = min(100, max(1, (int) ($_GET['rowsPerPage'] ?? 5)));
$startIndex = ($page - 1) * $rowsPerPage;

try {
    // Reconnect to the database
    // Include database configuration
    $databasePath = __DIR__ . '/../../../config/database.php';
    if (!file_exists($databasePath)) {
        throw new Exception('Database configuration file not found at: ' . $databasePath);
    }
    
    require_once $databasePath;
    
    // Create database connection
    $database = new Database();
    $pdo = $database->getConnection();
    
    if (!$pdo) {
        throw new Exception('Failed to connect to database');
    }
    
    // First, get total count for pagination
    $countStmt = $pdo->query("SELECT COUNT(*) as total FROM leads WHERE added_by IS NULL");
    $totalEnquiries = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalEnquiries / $rowsPerPage);
    
    // Then get paginated results
    $stmt = $pdo->prepare("SELECT 
                            lead_id as id,
                            name,
                            email,
                            product as interested_product,
                            quantity,
                            status
                          FROM leads 
                          WHERE added_by IS NULL
                          ORDER BY lead_id DESC
                          LIMIT :limit OFFSET :offset");
    
    $stmt->bindValue(':limit', $rowsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $startIndex, PDO::PARAM_INT);
    $stmt->execute();
    
    $enquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $response = [
        'enquiries' => $enquiries,
        'pagination' => [
            'page' => $page,
            'totalPages' => $totalPages,
            'totalEnquiries' => (int)$totalEnquiries
        ]
    ];
    
    echo json_encode($response);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => crm_public_error($e)
    ]);
}
?>