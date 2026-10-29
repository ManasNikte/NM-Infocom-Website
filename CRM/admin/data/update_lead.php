<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');

// Connect to the database

header('Content-Type: application/json');

$user_id = $auth->id;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$lead_id = $_POST['lead_id'] ?? null;
$name = $_POST['name'] ?? '';
$contact = $_POST['contact'] ?? '';
$email = $_POST['email'] ?? '';
$product = $_POST['product'] ?? '';
$quantity = $_POST['quantity'] ?? 1;
if (!$lead_id || !$name || !$contact || !$product) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare('UPDATE leads SET name = ?, contact = ?, email = ?, product = ?, quantity = ?, modified = NOW() WHERE lead_id = ?');
$success = $stmt->execute([$name, $contact, $email, $product, $quantity, $lead_id]);
if ($success) {
    echo json_encode(['success' => true, 'message' => 'Lead updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update lead']);
} 