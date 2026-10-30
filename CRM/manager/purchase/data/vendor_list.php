<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');

header('Content-Type: application/json');

try {
    $db = new Database();
    $pdo = $db->getConnection();
    $stmt = $pdo->query('SELECT id, supplier_name FROM vendor ORDER BY supplier_name ASC');
    $vendors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'vendors' => $vendors]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => crm_public_error($e)]);
} 