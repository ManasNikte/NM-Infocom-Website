<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$data = $_POST['vendor'] ?? [];

$required = ['vendor_id', 'supplier_name', 'product_category', 'contact_number', 'email', 'address', 'previous_deal'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'message' => 'Missing required field: ' . $field]);
        exit;
    }
}

try {
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("UPDATE vendor SET supplier_name=?, product_category=?, contact_number=?, email=?, address=?, previous_deal=?, remarks=?, last_modified=NOW() WHERE id=?");
    $stmt->execute([
        $data['supplier_name'],
        $data['product_category'],
        $data['contact_number'],
        $data['email'],
        $data['address'],
        strtolower($data['previous_deal']),
        $data['remarks'] ?? null,
        $data['vendor_id']
    ]);
    echo json_encode(['success' => true, 'message' => 'Vendor updated successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 