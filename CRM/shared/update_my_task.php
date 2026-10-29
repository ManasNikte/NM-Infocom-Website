<?php
// Change the status of a task assigned to the logged-in user. POST task_id, new_status.
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager', 'Employee']);
header('Content-Type: application/json');

$taskId = (int) ($_POST['task_id'] ?? 0);
$newStatus = strtolower(trim($_POST['new_status'] ?? ''));
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$taskId || !in_array($newStatus, ['pending', 'in progress', 'completed'], true)) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

try {
    $stmt = (new Database())->getConnection()->prepare(
        'UPDATE tasks SET status = ?, date_of_completion = ' . ($newStatus === 'completed' ? 'NOW()' : 'NULL') .
        ' WHERE id = ? AND assigned_to = ?');
    $stmt->execute([$newStatus, $taskId, $auth->id]);
    echo json_encode($stmt->rowCount() > 0
        ? ['success' => true]
        : ['success' => false, 'error' => 'Task not found, not yours, or already has this status']);
} catch (Exception $e) {
    error_log('update_my_task: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Could not update task']);
}
