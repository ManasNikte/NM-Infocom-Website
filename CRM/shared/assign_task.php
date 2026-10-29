<?php
// A manager assigns a task to an employee in their own department (admins: anyone).
// JSON body: {assigned_to, task, due_date}.
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager']);
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true) ?: [];
$assignee = (int) ($input['assigned_to'] ?? 0);
$task = trim($input['task'] ?? '');
$due = trim($input['due_date'] ?? '');
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$assignee || $task === '' || !DateTime::createFromFormat('Y-m-d', $due)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing or invalid fields']);
    exit;
}

try {
    $conn = (new Database())->getConnection();
    if (strtolower($auth->role) !== 'admin') {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE id = ? AND role = 'Employee' AND sub_role = ? AND status = 'active'");
        $stmt->execute([$assignee, $auth->sub_role]);
        if (!$stmt->fetchColumn()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'You can only assign tasks to active employees in your department']);
            exit;
        }
    }
    $conn->prepare("INSERT INTO tasks (assigned_to, assigned_by, task, due_date, date_added, status) VALUES (?, ?, ?, ?, CURDATE(), 'pending')")
         ->execute([$assignee, $auth->id, $task, $due]);
    require_once __DIR__ . '/../config/notify.php';
    $emailed = crm_notify_task_assigned($conn, $assignee, $auth->id, $task, $due) > 0;
    echo json_encode(['success' => true, 'email_sent' => $emailed]);
} catch (Exception $e) {
    error_log('assign_task: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Could not assign task']);
}
