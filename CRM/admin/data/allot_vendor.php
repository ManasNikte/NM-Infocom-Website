<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$lead_id = isset($_POST['lead_id']) ? intval($_POST['lead_id']) : 0;
$vendor_id = isset($_POST['vendor_id']) ? intval($_POST['vendor_id']) : 0;

if (!$lead_id || !$vendor_id) {
    echo json_encode(['success' => false, 'message' => 'Missing lead_id or vendor_id.']);
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    $stmt = $pdo->prepare('UPDATE leads SET vendor_id = :vendor_id WHERE lead_id = :lead_id');
    $stmt->execute([':vendor_id' => $vendor_id, ':lead_id' => $lead_id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Vendor allotted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No rows updated.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
} 