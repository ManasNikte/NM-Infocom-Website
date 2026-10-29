<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once '../../../../config/db_connection.php';

try {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Get total count
    $totalQuery = "SELECT COUNT(*) as total FROM reviews";
    if (!empty($search)) {
        $totalQuery .= " WHERE name LIKE ? OR post LIKE ? OR company LIKE ? OR text LIKE ?";
    }
    $totalStmt = $conn->prepare($totalQuery);
    if (!empty($search)) {
        $searchParam = "%$search%";
        $totalStmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
    }
    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    $totalRows = $totalResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $limit);

    // Get paginated data
    $query = "SELECT * FROM reviews";
    if (!empty($search)) {
        $query .= " WHERE name LIKE ? OR post LIKE ? OR company LIKE ? OR text LIKE ?";
    }
    $query .= " ORDER BY id DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    if (!empty($search)) {
        $stmt->bind_param("ssssii", $searchParam, $searchParam, $searchParam, $searchParam, $limit, $offset);
    } else {
        $stmt->bind_param("ii", $limit, $offset);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    header('Content-Type: application/json');
    $json = json_encode([
        'success' => true,
        'data' => $reviews,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_records' => $totalRows,
            'per_page' => $limit
        ]
    ]);

    if ($json === false) {
        throw new Exception(json_last_error_msg());
    }

    echo $json;

} catch (Exception $e) {
    error_log("Error fetching reviews: " . $e->getMessage());
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch reviews: ' . $e->getMessage()
    ]);
}

$conn->close();
?>