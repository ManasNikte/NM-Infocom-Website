<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');


header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Accept both JSON and form-urlencoded
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input || !isset($input['supplier_name'])) {
        // Try form data (from $.ajax data: {vendor: ...})
        if (isset($_POST['vendor'])) {
            $input = $_POST['vendor'];
        } else {
            throw new Exception('Missing required fields');
        }
    }

    $required = ['supplier_name', 'product_category', 'contact_number', 'email', 'address', 'previous_deal'];
    foreach ($required as $field) {
        if (!isset($input[$field]) || trim($input[$field]) === '') {
            throw new Exception('Missing required field: ' . $field);
        }
    }
    if (!in_array(strtolower(trim($input['previous_deal'])), ['yes', 'no'], true)) {
        throw new Exception('Previous deal must be Yes or No');
    }

    $decoded = $auth;
    $added_by = $decoded->id;

    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("INSERT INTO vendor (supplier_name, product_category, contact_number, email, address, previous_deal, remarks, date_added, last_modified, added_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
    $date_added = date('Y-m-d');
    $stmt->execute([
        $input['supplier_name'],
        $input['product_category'],
        $input['contact_number'],
        $input['email'],
        $input['address'],
        strtolower($input['previous_deal']),
        $input['remarks'] ?? null,
        $date_added,
        $added_by
    ]);
    echo json_encode(['success' => true, 'message' => 'Vendor added successfully']);
} catch (Exception $e) {
    error_log('ADD VENDOR ERROR: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => crm_public_error($e)]);
} 