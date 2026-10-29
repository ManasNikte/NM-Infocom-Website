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
$status = $_POST['status'] ?? '';
if (!$lead_id || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare('UPDATE leads SET status = ?, modified = NOW() WHERE lead_id = ?');
$success = $stmt->execute([$status, $lead_id]);
if ($success) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
} 