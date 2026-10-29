<?php
/**
 * Create a CRM administrator from the command line (first-time setup, or account recovery).
 *
 *   php database/create_admin.php "Full Name" admin@example.com
 *
 * Prints a random temporary password; sign in and change it from My Profile.
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../config/database.php';

[$script, $name, $email] = $argv + [null, null, null];
if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "usage: php database/create_admin.php \"Full Name\" admin@example.com\n");
    exit(1);
}

$conn = getDBConnection();
$stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
$stmt->execute([strtolower($email)]);
if ($stmt->fetchColumn() > 0) {
    fwrite(STDERR, "A user with that email already exists.\n");
    exit(1);
}

$password = bin2hex(random_bytes(8));
$conn->prepare("INSERT INTO users (name, email, contact, role, sub_role, status, date_added, password)
                VALUES (?, ?, '', 'Admin', NULL, 'active', NOW(), ?)")
     ->execute([$name, strtolower($email), password_hash($password, PASSWORD_DEFAULT)]);

echo "Admin created.\n  Email:    " . strtolower($email) . "\n  Password: $password\nSign in at /CRM/index.html and change the password from My Profile.\n";
