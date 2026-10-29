<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'sales');
header('Content-Type: application/json');

$user_id = $auth->id;

$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare("SELECT id, name FROM users WHERE role = 'Employee' AND sub_role = 'sales' AND (status = 'active' OR status IS NULL)");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['success' => true, 'users' => $users]); 