<?php
// Tasks assigned to the logged-in user (manager dashboards' "My Tasks" table).
// GET page, search, status ('all' | 'pending' | 'in progress' | 'completed').
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager', 'Employee']);
header('Content-Type: application/json');

$perPage = 6;
$where = ['assigned_to = ?'];
$params = [$auth->id];
if (($status = $_GET['status'] ?? 'all') !== 'all' && $status !== '') {
    $where[] = 'status = ?';
    $params[] = $status;
}
if (($search = strtolower(trim($_GET['search'] ?? ''))) !== '') {
    $where[] = '(LOWER(task) LIKE ? OR LOWER(status) LIKE ? OR date_added LIKE ? OR due_date LIKE ? OR date_of_completion LIKE ? OR id = ?)';
    array_push($params, ...array_fill(0, 5, "%$search%"));
    $params[] = ctype_digit($search) ? (int) $search : -1;
}
$whereSql = implode(' AND ', $where);

try {
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE $whereSql");
    $stmt->execute($params);
    $total = (int) $stmt->fetchColumn();
    $pages = max(1, (int) ceil($total / $perPage));
    $page = min($pages, max(1, (int) ($_GET['page'] ?? 1)));
    $offset = ($page - 1) * $perPage;

    $stmt = $conn->prepare("SELECT id, task, date_added, due_date, date_of_completion, status FROM tasks
                            WHERE $whereSql ORDER BY date_added DESC LIMIT $offset, $perPage");
    $stmt->execute($params);
    $tasks = array_map(function ($r) {
        return [$r['id'], $r['task'], $r['date_added'], $r['due_date'], $r['date_of_completion'] ?: '-', ucfirst((string) $r['status'])];
    }, $stmt->fetchAll(PDO::FETCH_ASSOC));

    echo json_encode(['success' => true, 'data' => [
        'tasks' => $tasks,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $pages,
            'total_items' => $total,
            'items_per_page' => $perPage,
            'showing_start' => $total ? $offset + 1 : 0,
            'showing_end' => min($offset + $perPage, $total),
        ],
    ]]);
} catch (Exception $e) {
    error_log('my_tasks: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to load tasks. Please try again later.']);
}
