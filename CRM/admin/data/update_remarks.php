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
$remarks = $_POST['remarks'] ?? '';
if (!$lead_id) {
    echo json_encode(['success' => false, 'message' => 'Missing lead_id']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare('UPDATE leads SET remarks = ?, modified = NOW() WHERE lead_id = ?');
$success = $stmt->execute([$remarks, $lead_id]);
if ($success) {
    echo json_encode(['success' => true, 'message' => 'Remarks updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update remarks']);
} 