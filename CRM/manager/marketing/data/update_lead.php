<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'marketing');


header('Content-Type: application/json');

$employee_id = null;
$role = null;
$sub_role = null;

try {
    $decoded = $auth;
    $employee_id = $decoded->id ?? null;
    $role = $decoded->role ?? null;
    $sub_role = $decoded->sub_role ?? null;
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid token.']);
    exit;
}
if (!$employee_id || strtolower($role) !== 'manager' || strtolower($sub_role) !== 'marketing') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$lead_id = $_POST['lead_id'] ?? null;
$name = $_POST['name'] ?? '';
$contact = $_POST['contact'] ?? '';
$email = $_POST['email'] ?? '';
$product = $_POST['product'] ?? '';
$quantity = $_POST['quantity'] ?? 1;

if (!$lead_id || !$name || !$contact || !$product) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    $stmt = $pdo->prepare("UPDATE leads SET name = ?, contact = ?, email = ?, product = ?, quantity = ?, modified = NOW() WHERE lead_id = ?");
    $success = $stmt->execute([$name, $contact, $email, $product, $quantity, $lead_id]);
    if ($success && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Lead updated successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'No changes made or lead not found.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} 