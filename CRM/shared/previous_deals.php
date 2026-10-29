<?php
// Completed deals (closed leads with a positive response) fulfilled by one vendor.
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager', 'Employee'], 'purchase');
header('Content-Type: application/json');

$vendorId = (int) ($_GET['vendor_id'] ?? 0);
if ($vendorId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Vendor ID not provided', 'total_orders' => 0]);
    exit;
}

try {
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare("SELECT l.lead_id, l.product AS product_purchased, l.quantity,
                                   COALESCE(p.product_cost, 0) * l.quantity AS amount
                            FROM leads l
                            LEFT JOIN products p ON p.product_name = l.product
                            WHERE l.vendor_id = ? AND l.status = 'closed' AND l.response = 'positive'
                            ORDER BY l.modified DESC");
    $stmt->execute([$vendorId]);
    $deals = array_map(function ($d) {
        return ['lead_id' => (int) $d['lead_id'], 'product_purchased' => $d['product_purchased'],
                'quantity' => (int) $d['quantity'], 'amount' => (float) $d['amount']];
    }, $stmt->fetchAll(PDO::FETCH_ASSOC));

    echo json_encode($deals
        ? ['success' => true, 'data' => $deals, 'total_orders' => count($deals)]
        : ['success' => false, 'message' => 'No previous deals found', 'total_orders' => 0]);
} catch (Exception $e) {
    error_log('previous_deals: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Could not load deals', 'total_orders' => 0]);
}
