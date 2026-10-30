<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$lead_id = isset($_POST['lead_id']) ? intval($_POST['lead_id']) : 0;
$vendor_id = isset($_POST['vendor_id']) ? intval($_POST['vendor_id']) : 0;

if (!$lead_id) {
    echo json_encode(['success' => false, 'message' => 'Missing lead.']);
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    if ($vendor_id) {
        $check = $pdo->prepare('SELECT COUNT(*) FROM vendor WHERE id = ?');
        $check->execute([$vendor_id]);
        if (!$check->fetchColumn()) {
            echo json_encode(['success' => false, 'message' => 'That vendor no longer exists.']);
            exit;
        }
    }
    // vendor_id 0 / empty = "-- No vendor --" (un-allot)
    $stmt = $pdo->prepare('UPDATE leads SET vendor_id = :vendor_id, modified = NOW() WHERE lead_id = :lead_id');
    $stmt->execute([':vendor_id' => $vendor_id ?: null, ':lead_id' => $lead_id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => $vendor_id ? 'Vendor allotted successfully.' : 'Vendor removed from the order.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => crm_public_error($e)]);
} 