<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../../data/public_form.php';
crm_security_headers();
crm_reject_cross_site();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.html');
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Failures go back to the sign-in page with a message code (see index.html).
$fail = function ($code) {
    header('Location: ../index.html?error=' . $code);
    exit();
};

if ($email === '' || $password === '') {
    $fail('missing');
}

// Brute-force protection: at most 10 failed attempts per IP every 15 minutes.
$failedAttempts = 0;
try {
    $stmt = getDBConnection()->prepare("SELECT COUNT(*) FROM form_submission_log
                                        WHERE form = 'login_failed' AND ip_hash = ? AND created_at >= NOW() - INTERVAL 15 MINUTE");
    $stmt->execute([public_form_ip_hash()]);
    $failedAttempts = (int) $stmt->fetchColumn();
} catch (Exception $e) {
    error_log('login rate limit: ' . $e->getMessage());
}
if ($failedAttempts >= 10) {
    $fail('locked');
}

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare('SELECT id, name, email, password, role, sub_role, status FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    public_form_record('login_failed');
    $fail('invalid');
}
if ($user['status'] !== null && strtolower($user['status']) !== 'active') {
    $fail('inactive');
}

// Landing page per role / sub_role, relative to CRM/config/.
$destinations = [
    'admin' => ['' => '../admin/dashboard.php'],
    'manager' => [
        'marketing' => '../manager/marketing/dashboard.php',
        'sales' => '../manager/sales/dashboard.php',
        'purchase' => '../manager/purchase/dashboard.php',
        'hr' => '../manager/HR/dashboard.php',
        'website' => '../manager/website/dashboard.php',
    ],
    'employee' => [
        'marketing' => '../employee/marketing/main.php',
        'sales' => '../employee/sales/main.php',
        'purchase' => '../employee/purchase/main.php',
    ],
];

$role = strtolower($user['role']);
$key = $role === 'admin' ? '' : (string) $user['sub_role'];
if (!isset($destinations[$role][$key])) {
    $fail('role');
}

$conn->prepare('UPDATE users SET last_login = NOW() WHERE id = ?')->execute([$user['id']]);
crm_issue_token($user);
header('Location: ' . $destinations[$role][$key]);
exit();
