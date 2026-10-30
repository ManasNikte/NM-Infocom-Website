<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api('Employee', 'marketing');


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Validate JWT and user
$employee_id = null;
$role = null;
$sub_role = null;

try {
    if ($auth) {
        $decoded = $auth;
        $employee_id = $decoded->id ?? null;
        $role = $decoded->role ?? null;
        $sub_role = $decoded->sub_role ?? null;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Invalid token.']);
    exit;
}
if (!$employee_id || strtolower($role) !== 'employee' || strtolower($sub_role) !== 'marketing') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

// Validate input data
$data = $_POST['lead'] ?? null;
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No lead data provided.']);
    exit;
}

$lead_id = trim($data['lead_id'] ?? '');
$name = trim($data['name'] ?? '');
$contact = trim($data['contact'] ?? '');
$email = trim($data['email'] ?? '');
$product = trim($data['product'] ?? '');
$quantity = isset($data['quantity']) && $data['quantity'] !== '' ? (int)$data['quantity'] : 1;

if ($lead_id === '' || $name === '' || $contact === '' || $product === '') {
    echo json_encode(['success' => false, 'message' => 'Lead ID, name, contact, and product are required.']);
    exit;
}
if (!preg_match('/^[0-9]{10,20}$/', $contact)) {
    echo json_encode(['success' => false, 'message' => 'Contact number must be 10-20 digits.']);
    exit;
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}
if ($quantity < 1) {
    echo json_encode(['success' => false, 'message' => 'Quantity must be at least 1.']);
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    $stmt = $pdo->prepare("UPDATE leads SET name=?, contact=?, email=?, product=?, quantity=?, modified=NOW() WHERE lead_id=? AND added_by=?");
    $stmt->execute([$name, $contact, $email ?: null, $product, $quantity, $lead_id, $employee_id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Lead updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No changes made or lead not found, or you do not have permission to edit this lead.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => crm_public_error($e)]);
} 