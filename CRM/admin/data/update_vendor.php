<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');

// Connect to the database

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

if (!in_array(strtolower(trim((string) $data['previous_deal'])), ['yes', 'no'], true)) {
    echo json_encode(['success' => false, 'message' => 'Previous deal must be Yes or No']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
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
        strtolower(trim($data['previous_deal'])),
        $data['remarks'] ?? null,
        (int) ltrim((string) $data['vendor_id'], 'Vv')
    ]);
    $found = $conn->prepare('SELECT COUNT(*) FROM vendor WHERE id = ?');
    $found->execute([(int) ltrim((string) $data['vendor_id'], 'Vv')]);
    echo json_encode($found->fetchColumn() ? ['success' => true, 'message' => 'Vendor updated successfully'] : ['success' => false, 'message' => 'Vendor not found']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => crm_public_error($e)]);
} 