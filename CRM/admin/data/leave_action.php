<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');



header('Content-Type: application/json');

$action = isset($_POST['action']) ? trim($_POST['action']) : '';
$leave_id = isset($_POST['leave_id']) ? intval($_POST['leave_id']) : 0;

if (!in_array($action, ['approve', 'reject']) || $leave_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters.']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();
    $new_status = $action === 'approve' ? 'approved' : 'rejected';
    $stmt = $conn->prepare('UPDATE leaves SET status = :status, action_by = :by WHERE id = :id');
    $stmt->bindValue(':status', $new_status);
    $stmt->bindValue(':by', $auth->id, PDO::PARAM_INT);
    $stmt->bindValue(':id', $leave_id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        require_once __DIR__ . '/../../config/notify.php';
        crm_notify_leave_decided($conn, $leave_id);
        echo json_encode(['status' => 'success', 'message' => 'Leave ' . $new_status . '.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Leave not found or already updated.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to update leave status.']);
} 