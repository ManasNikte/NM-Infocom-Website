<?php
// Mark a staff member as fired. Admin and HR can act on anyone (except admins);
// other managers only on employees in their own department.
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager']);
header('Content-Type: application/json');

$targetId = (int) ($_POST['lead_id'] ?? $_POST['user_id'] ?? 0);
$reason = trim($_POST['reason'] ?? '');
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $targetId <= 0 || $reason === '') {
    echo json_encode(['success' => false, 'error' => 'Invalid input.']);
    exit;
}

try {
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare('SELECT role, sub_role FROM users WHERE id = ?');
    $stmt->execute([$targetId]);
    $target = $stmt->fetch(PDO::FETCH_ASSOC);

    $actor = strtolower($auth->role);
    $allowed = $target && $target['role'] !== 'Admin' && $targetId !== (int) $auth->id && (
        $actor === 'admin'
        || $auth->sub_role === 'hr'
        || ($target['role'] === 'Employee' && $target['sub_role'] === $auth->sub_role)
    );
    if (!$allowed) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'You do not have permission to fire this user.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET status = 'fired', date_of_resignation = CURDATE(), fire_reason = ? WHERE id = ?");
    $stmt->execute([$reason, $targetId]);
    echo json_encode($stmt->rowCount() > 0 ? ['success' => true] : ['success' => false, 'error' => 'No rows updated.']);
} catch (Exception $e) {
    error_log('fire_employee: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Failed to update user.']);
}
