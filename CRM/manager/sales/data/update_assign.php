<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'sales');
header('Content-Type: application/json');

$user_id = $auth->id;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$lead_id = $_POST['lead_id'] ?? null;
$assigned_to = $_POST['assigned_to'] ?? null;
if (!$lead_id || !$assigned_to) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare('UPDATE leads SET assigned_to = ?, modified = NOW() WHERE lead_id = ?');
$success = $stmt->execute([$assigned_to, $lead_id]);
if ($success) {
    echo json_encode(['success' => true, 'message' => 'Lead assigned successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to assign lead']);
} 