<?php
// Create a new lead (status 'new') owned by the logged-in user. POST lead[name, contact, email, product, quantity].
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager', 'Employee']);
if (strtolower($auth->role) !== 'admin' && !in_array($auth->sub_role, ['marketing', 'purchase'], true)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Only marketing and purchase staff can add leads.']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$employee_id = $auth->id;

// Validate input data
$data = $_POST['lead'] ?? null;
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No lead data provided.']);
    exit;
}

$name = trim($data['name'] ?? '');
$contact = trim($data['contact'] ?? '');
$email = trim($data['email'] ?? '');
$product = trim($data['product'] ?? '');
$quantity = isset($data['quantity']) && $data['quantity'] !== '' ? (int)$data['quantity'] : 1;

if ($name === '' || $contact === '' || $product === '') {
    echo json_encode(['success' => false, 'message' => 'Name, contact, and product are required.']);
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
    $stmt = $pdo->prepare("INSERT INTO leads (name, contact, email, product, quantity, added_on, modified, status, added_by) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), 'new', ?)");
    $stmt->execute([$name, $contact, $email ?: null, $product, $quantity, $employee_id]);
    echo json_encode(['success' => true, 'message' => 'Lead added successfully.']);
} catch (Exception $e) {
    error_log('add_lead: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Could not add lead.']);
} 