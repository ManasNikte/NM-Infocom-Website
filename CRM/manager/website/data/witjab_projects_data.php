<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/php-error.log');

require_once '../../../../config/db_connection.php';

try {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 3;
    $offset = ($page - 1) * $limit;
    
    // Get total count
    $totalQuery = "SELECT COUNT(*) as total FROM projects";
    $totalResult = $conn->query($totalQuery);
    $totalRows = $totalResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $limit);
    
    // Get paginated data
    $query = "SELECT * FROM projects ORDER BY id DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $projects = [];
    while ($row = $result->fetch_assoc()) {
        // Format dates
        $row['created_at'] = date('Y-m-d H:i:s', strtotime($row['created_at']));
        $row['updated_at'] = date('Y-m-d H:i:s', strtotime($row['updated_at']));
        
        // Ensure boolean values
        $row['colorful'] = (bool)$row['colorful'];
        $row['visibility'] = (bool)$row['visibility'];
        
        $projects[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $projects,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_records' => $totalRows,
            'per_page' => $limit
        ]
    ]);

} catch (Exception $e) {
    error_log("Error fetching projects: " . $e->getMessage());
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch projects'
    ]);
}

$conn->close();
?>