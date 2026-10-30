<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');



header('Content-Type: application/json');

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Get parameters from POST
    $search = isset($_POST['search']) ? trim($_POST['search']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;
    $rowsPerPage = min(100, max(1, (int) ($_POST['rowsPerPage'] ?? 7)));

    // Build SQL
    $sql = "SELECT l.id, u.name, u.role, u.sub_role, l.reason, l.start_date, l.end_date, l.status
            FROM leaves l
            JOIN users u ON l.user_id = u.id
            WHERE 1=1";
    $params = [];

    if ($status !== '') {
        $sql .= " AND l.status = :status";
        $params[':status'] = $status;
    }
    if ($date !== '') {
        $sql .= " AND (l.start_date = :date OR l.end_date = :date)";
        $params[':date'] = $date;
    }
    if ($search !== '') {
        $sql .= " AND (LOWER(u.name) LIKE :search OR LOWER(l.reason) LIKE :search)";
        $params[':search'] = '%' . strtolower($search) . '%';
    }

    // Count total records
    $count_sql = "SELECT COUNT(*) FROM leaves l JOIN users u ON l.user_id = u.id WHERE 1=1";
    $count_params = [];
    if ($status !== '') {
        $count_sql .= " AND l.status = :status";
        $count_params[':status'] = $status;
    }
    if ($date !== '') {
        $count_sql .= " AND (l.start_date = :date OR l.end_date = :date)";
        $count_params[':date'] = $date;
    }
    if ($search !== '') {
        $count_sql .= " AND (LOWER(u.name) LIKE :search OR LOWER(l.reason) LIKE :search)";
        $count_params[':search'] = '%' . strtolower($search) . '%';
    }

    $count_stmt = $conn->prepare($count_sql);
    foreach ($count_params as $key => $val) {
        $count_stmt->bindValue($key, $val);
    }
    $count_stmt->execute();
    $totalRecords = $count_stmt->fetchColumn();
    $totalPages = ceil($totalRecords / $rowsPerPage);
    $offset = ($page - 1) * $rowsPerPage;

    $sql .= " ORDER BY l.id DESC LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', $rowsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'role' => $row['role'],
            'sub_role' => $row['sub_role'],
            'reason' => $row['reason'],
            'startDate' => $row['start_date'],
            'endDate' => $row['end_date'],
            'status' => $row['status'],
        ];
    }

    echo json_encode([
        'status' => 'success',
        'data' => $data,
        'pagination' => [
            'page' => $page,
            'totalPages' => $totalPages,
            'totalRecords' => intval($totalRecords),
            'rowsPerPage' => $rowsPerPage
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to load leave data.'
    ]);
} 