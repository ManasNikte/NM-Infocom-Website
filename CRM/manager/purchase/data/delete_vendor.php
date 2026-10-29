<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$vendor_id = $_POST['vendor_id'] ?? null;
if (!$vendor_id) {
    echo json_encode(['success' => false, 'message' => 'Missing vendor_id']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("DELETE FROM vendor WHERE id = ?");
    $stmt->execute([$vendor_id]);
    echo json_encode(['success' => true, 'message' => 'Vendor deleted successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 