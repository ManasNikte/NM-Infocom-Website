<?php
// Account creation is admin-only; staff accounts are normally added from the Employee List.
require_once __DIR__ . '/auth.php';
crm_require_page('Admin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $dob = $_POST['dob'];
    $role = $_POST['role'];
    $sub_role = $_POST['sub_role'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate required fields
    if (empty($name) || empty($email) || empty($role) || empty($sub_role) || empty($password)) {
        die("All required fields must be filled.");
    }

    if (!in_array($role, ['Admin', 'Manager', 'Employee'], true)) {
        die("Invalid role.");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Get PDO connection
    $db = new Database();
    $conn = $db->getConnection();

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        die("Email already registered.");
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO users (name, contact, email, DOB, role, sub_role, password, status, date_added)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$name, $contact, $email, $dob, $role, $sub_role, $hashed_password])) {
        echo "User registered successfully.";
    } else {
        echo "Error: " . implode(" | ", $stmt->errorInfo());
    }
}
?>
