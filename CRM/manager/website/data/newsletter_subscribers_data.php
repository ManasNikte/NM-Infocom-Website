<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once '../../../../config/db_connection.php';

try {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Get total count
    $totalQuery = "SELECT COUNT(*) as total FROM newsletter_subscribers";
    if (!empty($search)) {
        $totalQuery .= " WHERE email LIKE ? OR current_status LIKE ? OR unsubscribed_reason LIKE ?";
    }
    $totalStmt = $conn->prepare($totalQuery);
    if (!empty($search)) {
        $searchParam = "%$search%";
        $totalStmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
    }
    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    $totalRows = $totalResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $limit);

    // Get paginated data
    $query = "SELECT * FROM newsletter_subscribers";
    if (!empty($search)) {
        $query .= " WHERE email LIKE ? OR current_status LIKE ? OR unsubscribed_reason LIKE ?";
    }
    $query .= " ORDER BY id DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    if (!empty($search)) {
        $stmt->bind_param("sssii", $searchParam, $searchParam, $searchParam, $limit, $offset);
    } else {
        $stmt->bind_param("ii", $limit, $offset);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $subscribers = [];
    while ($row = $result->fetch_assoc()) {
        $subscribers[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $subscribers,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_records' => $totalRows,
            'per_page' => $limit
        ]
    ]);

} catch (Exception $e) {
    error_log("Error fetching subscribers: " . $e->getMessage());
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch subscribers'
    ]);
}

$conn->close();
?>
