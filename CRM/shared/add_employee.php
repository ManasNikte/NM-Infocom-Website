<?php
// Create a user account and email them their login details.
// Admins can create any role; HR managers can create managers and employees.
// POST name, email, contact, role, sub_role (not for Admin), dob, date_of_joining, optional PDF "resume".
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/uploads.php';
require_once __DIR__ . '/../../config/mailer.php';
$auth = crm_require_api(['Admin', 'Manager'], 'hr');
header('Content-Type: application/json');

function add_user_fail($message) {
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    add_user_fail('Invalid request method.');
}

$name = trim($_POST['name'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$role = trim($_POST['role'] ?? '');
$subRole = trim($_POST['sub_role'] ?? '');
$dob = trim($_POST['dob'] ?? '');
$dateOfJoining = trim($_POST['date_of_joining'] ?? $_POST['added_on'] ?? '');

$allowedRoles = strtolower($auth->role) === 'admin' ? ['Admin', 'Manager', 'Employee'] : ['Manager', 'Employee'];
if (!in_array($role, $allowedRoles, true)) {
    add_user_fail('You cannot create a user with that role.');
}
if ($role === 'Admin') {
    $subRole = null; // admins belong to no department
} elseif (!in_array($subRole, ['marketing', 'sales', 'purchase', 'website', 'hr'], true)) {
    add_user_fail('Please choose a department.');
}
if ($name === '' || $contact === '' || $dob === '' || $dateOfJoining === '') {
    add_user_fail('All required fields must be filled.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    add_user_fail('Invalid email format.');
}

try {
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        add_user_fail('A user with this email already exists.');
    }

    $resume = null;
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $resume = 'uploads/resume/' . crm_store_upload($_FILES['resume'], 'resume', 'EMP_', CRM_PDF_TYPES, 5 * 1024 * 1024);
        } catch (RuntimeException $e) {
            add_user_fail('Resume: ' . crm_public_error($e));
        }
    }

    // 12 characters from an unambiguous alphabet (no 0/O, 1/l/I).
    $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
    $tempPassword = '';
    for ($i = 0; $i < 12; $i++) {
        $tempPassword .= $alphabet[random_int(0, strlen($alphabet) - 1)];
    }

    $conn->prepare("INSERT INTO users (name, contact, email, role, sub_role, DOB, resume, status, date_added, date_of_joining, password)
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW(), ?, ?)")
         ->execute([$name, $contact, $email, $role, $subRole, $dob, $resume, $dateOfJoining,
                    password_hash($tempPassword, PASSWORD_DEFAULT)]);

    $loginUrl = rtrim((string) nm_config('APP_URL', ''), '/') . '/CRM/index.html';
    if (!preg_match('#^https?://#', $loginUrl)) {
        $loginUrl = (crm_is_https() ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . crm_login_url();
    }
    $roleText = $role === 'Admin' ? 'Administrator' : $role . ' (' . ($subRole === 'hr' ? 'HR' : ucfirst($subRole)) . ')';
    $e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);

    $html = '<div style="font-family:Arial,Helvetica,sans-serif;max-width:560px;margin:0 auto;color:#1f2937">'
        . '<h2 style="color:#0b1430;margin:0 0 12px">Welcome to NM INFOCOM, ' . $e($name) . '</h2>'
        . '<p>An account has been created for you on the NM INFOCOM CRM as <b>' . $e($roleText) . '</b>.</p>'
        . '<table style="border-collapse:collapse;margin:16px 0;background:#f5f7fb;border-radius:8px">'
        . '<tr><td style="padding:10px 16px;color:#64748b">Sign-in page</td><td style="padding:10px 16px"><a href="' . $e($loginUrl) . '">' . $e($loginUrl) . '</a></td></tr>'
        . '<tr><td style="padding:10px 16px;color:#64748b">Email</td><td style="padding:10px 16px"><b>' . $e($email) . '</b></td></tr>'
        . '<tr><td style="padding:10px 16px;color:#64748b">Temporary password</td><td style="padding:10px 16px;font-family:monospace;font-size:16px"><b>' . $e($tempPassword) . '</b></td></tr>'
        . '</table>'
        . '<p>Please sign in and change this password right away from <b>My Profile → Update Password</b>.</p>'
        . '<p style="color:#64748b;font-size:13px">If you weren\'t expecting this email, contact your administrator.</p></div>';
    $text = "Welcome to NM INFOCOM, $name\n\nAn account has been created for you on the NM INFOCOM CRM as $roleText.\n\n"
        . "Sign-in page: $loginUrl\nEmail: $email\nTemporary password: $tempPassword\n\n"
        . "Please sign in and change this password right away from My Profile > Update Password.\n";

    $sent = nm_send_mail($email, $name, 'Your NM INFOCOM CRM login details', $html, $text);

    $response = ['success' => true, 'message' => 'User created.', 'email' => $email, 'email_sent' => $sent === true];
    if ($sent !== true) {
        // Email failed: hand the password to the admin once so they can pass it on securely.
        $response['email_error'] = $sent;
        $response['temp_password'] = $tempPassword;
    }
    echo json_encode($response);
} catch (Exception $ex) {
    error_log('add_employee: ' . $ex->getMessage());
    add_user_fail('Could not add the user.');
}
