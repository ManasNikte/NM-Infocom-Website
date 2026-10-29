<?php
// Update the logged-in user's contact number and email (any role).
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager', 'Employee']);
header('Content-Type: application/json');

$contact = trim($_POST['contact'] ?? '');
$email = trim($_POST['email'] ?? '');
if (!$contact || !$email) {
    echo json_encode(['success' => false, 'message' => 'Contact and email are required.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    exit;
}
if (!preg_match('/^\+?\d{10,15}$/', $contact)) {
    echo json_encode(['success' => false, 'message' => 'Invalid contact number.']);
    exit;
}

try {
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE email = ? AND id <> ?');
    $stmt->execute([$email, $auth->id]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'That email is already used by another account.']);
        exit;
    }
    $conn->prepare('UPDATE users SET contact = ?, email = ? WHERE id = ?')->execute([$contact, $email, $auth->id]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log('update_profile: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Could not update profile.']);
}
