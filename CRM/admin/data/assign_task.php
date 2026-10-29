<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');


header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['assigned_to'], $input['task'], $input['due_date']) || trim($input['task']) === ''
        || !DateTime::createFromFormat('Y-m-d', $input['due_date'])) {
        throw new Exception('Missing required fields');
    }
    $decoded = $auth;
    $assigned_by = $decoded->id;

    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("INSERT INTO tasks (assigned_to, assigned_by, task, due_date, date_added, status, date_of_completion) VALUES (:assigned_to, :assigned_by, :task, :due_date, NOW(), 'Pending', NULL)");
    $stmt->bindValue(':assigned_to', $input['assigned_to']);
    $stmt->bindValue(':assigned_by', $assigned_by);
    $stmt->bindValue(':task', $input['task']);
    $stmt->bindValue(':due_date', $input['due_date']);
    $stmt->execute();
    require_once __DIR__ . '/../../config/notify.php';
    $emailed = crm_notify_task_assigned($conn, $input['assigned_to'], $assigned_by, $input['task'], $input['due_date']) > 0;
    echo json_encode(['success' => true, 'email_sent' => $emailed]);
} catch (Exception $e) {
    error_log('ASSIGN TASK ERROR: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} 