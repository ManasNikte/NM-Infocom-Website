<?php
// Change the logged-in user's password (any role).
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager', 'Employee']);
header('Content-Type: application/json');

$current = $_POST['currentpassword'] ?? '';
$new = $_POST['newpassword'] ?? '';
$confirm = $_POST['confirmpassword'] ?? '';
if (!$current || !$new || !$confirm) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}
if ($new !== $confirm) {
    echo json_encode(['success' => false, 'message' => 'New and confirm password do not match.']);
    exit;
}
if (strlen($new) < 8) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters.']);
    exit;
}

try {
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare('SELECT password FROM users WHERE id = ?');
    $stmt->execute([$auth->id]);
    $hash = $stmt->fetchColumn();
    if (!$hash || !password_verify($current, $hash)) {
        echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
        exit;
    }
    // Signs out every other session of this account; this browser gets a fresh token.
    // PHP's clock on both sides (crm_session_still_valid compares with strtotime), so DB/PHP timezones can't disagree.
    $newHash = password_hash($new, PASSWORD_DEFAULT);
    try {
        $conn->prepare('UPDATE users SET password = ?, tokens_valid_after = ? WHERE id = ?')->execute([$newHash, date('Y-m-d H:i:s'), $auth->id]);
    } catch (PDOException $e) {
        // tokens_valid_after missing (migration not run yet): still change the password.
        error_log('update_password: ' . $e->getMessage());
        $conn->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$newHash, $auth->id]);
    }
    $me = $conn->prepare('SELECT id, email, role, sub_role FROM users WHERE id = ?');
    $me->execute([$auth->id]);
    crm_issue_token($me->fetch(PDO::FETCH_ASSOC));
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log('update_password: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Could not update password.']);
}
