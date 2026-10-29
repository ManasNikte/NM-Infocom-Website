<?php
// Task status counts for dashboard pie charts.
//   ?mine=1            -> the logged-in user's own tasks (any role)
//   (default)          -> employees in the logged-in manager's department
//   start_date/end_date (Y-m-d, optional) limit by date_added
require_once __DIR__ . '/../config/auth.php';
$mine = !empty($_GET['mine']);
$auth = crm_require_api($mine ? ['Admin', 'Manager', 'Employee'] : 'Manager');
header('Content-Type: application/json');

if ($mine) {
    $sql = 'SELECT LOWER(t.status), COUNT(*) FROM tasks t WHERE t.assigned_to = ?';
    $params = [$auth->id];
} else {
    $sql = "SELECT LOWER(t.status), COUNT(*) FROM tasks t JOIN users u ON t.assigned_to = u.id
            WHERE u.role = 'Employee' AND u.sub_role = ?";
    $params = [$auth->sub_role];
}
if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $sql .= ' AND t.date_added BETWEEN ? AND ?';
    array_push($params, $_GET['start_date'], $_GET['end_date']);
}

try {
    $stmt = (new Database())->getConnection()->prepare($sql . ' GROUP BY LOWER(t.status)');
    $stmt->execute($params);
    $byStatus = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    echo json_encode([
        'labels' => ['Completed', 'In Progress', 'Pending'],
        'values' => [
            'Completed' => (int) ($byStatus['completed'] ?? 0),
            'In Progress' => (int) ($byStatus['in progress'] ?? 0),
            'Pending' => (int) ($byStatus['pending'] ?? 0),
        ],
        'colors' => [
            'Completed' => ['#00c853', '#69f0ae'],
            'In Progress' => ['#2962ff', '#82b1ff'],
            'Pending' => ['#ffd600', '#ffff00'],
        ],
    ]);
} catch (Exception $e) {
    error_log('task_status: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not load task status']);
}
