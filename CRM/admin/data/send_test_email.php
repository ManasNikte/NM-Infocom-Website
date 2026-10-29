<?php
// Admin tool: send a test email to the signed-in admin to check the SMTP settings in .env.
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');
require_once __DIR__ . '/../../../config/mailer.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'POST only']);
    exit;
}
$conn = (new Database())->getConnection();
$stmt = $conn->prepare('SELECT name, email FROM users WHERE id = ?');
$stmt->execute([$auth->id]);
$me = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$me || !filter_var($me['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Your account has no valid email address.']);
    exit;
}
$when = (new DateTime('now', new DateTimeZone('Asia/Kolkata')))->format('j M Y, g:i A') . ' IST';
$server = nm_config('SMTP_HOST') . ':' . nm_config('SMTP_PORT', 587);
$e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
$result = nm_send_mail($me['email'], $me['name'], 'NM INFOCOM CRM: test email',
    nm_mail_template('Email is working', '<p>This test was sent from the CRM at <b>' . $e($when) . '</b> through <b>' . $e($server) . '</b>.</p>'
        . '<p>New-user credentials, task and leave notifications will be delivered the same way.</p>'),
    "Email is working.\n\nThis test was sent from the CRM at $when through $server.\n");
echo json_encode($result === true
    ? ['success' => true, 'message' => 'Test email sent to ' . $me['email'] . '. Check the inbox (and spam folder).']
    : ['success' => false, 'message' => $result]);
