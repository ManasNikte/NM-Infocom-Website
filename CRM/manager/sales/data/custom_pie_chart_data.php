<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'sales');
// Get user ID from JWT (simple base64 decode, no signature check)
if (!isset($_COOKIE['token'])) {
    http_response_code(401);
    echo json_encode(['success'=>false, 'error'=>'Not authenticated']);
    exit;
}
$payload = (array) $auth;
$user_id = $payload['id'] ?? 0;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(['success'=>false, 'error'=>'Invalid user in token']);
    exit;
}

// Get date filters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

try {
    $db = new Database();
    $conn = $db->getConnection();
    $counts = ['Completed'=>0, 'In Progress'=>0, 'Pending'=>0];
    $params = [];
    $where = "u.role = 'Employee' AND u.sub_role = 'sales'";
    $date_filter = '';
    if ($start_date && $end_date) {
        $date_filter = ' AND t.date_added >= :start_date AND t.date_added <= :end_date';
        $params[':start_date'] = $start_date . ' 00:00:00';
        $params[':end_date'] = $end_date . ' 23:59:59';
    }
    $sql = "SELECT t.status, COUNT(*) as count FROM tasks t JOIN users u ON t.assigned_to = u.id WHERE $where$date_filter GROUP BY t.status";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $status = strtolower($row['status']);
        if ($status === 'completed') $counts['Completed'] = (int)$row['count'];
        elseif ($status === 'in progress') $counts['In Progress'] = (int)$row['count'];
        elseif ($status === 'pending') $counts['Pending'] = (int)$row['count'];
    }
    $task_status_data = [
        'labels' => ['Completed', 'In Progress', 'Pending'],
        'values' => $counts,
        'colors' => [
            'Completed' => ['#00c853', '#69f0ae'],
            'In Progress' => ['#2962ff', '#82b1ff'],
            'Pending' => ['#ffd600', '#ffff00']
        ]
    ];
    if(isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
        header('Content-Type: application/json');
        echo json_encode($task_status_data);
        exit;
    }
    return $task_status_data;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'error'=>'DB error: '.$e->getMessage()]);
    exit;
} 