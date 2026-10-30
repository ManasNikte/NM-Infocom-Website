<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api('Employee', 'purchase');
$conn = getDBConnection();

// JWT decode setup

$user_id = null;
if ($auth) {
    try {
        $decoded = $auth;
        $user_id = $decoded->id ?? null;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
        exit;
    }
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No token provided.']);
    exit;
}

function format_date($date) {
    if (!$date) return '-';
    $d = date_create($date);
    return $d ? date_format($d, 'd-m-Y') : $date;
}

function map_vendor_row($row) {
    return [
        'vendor_id' => 'V' . str_pad($row['id'], 3, '0', STR_PAD_LEFT),
        'supplier_name' => $row['supplier_name'],
        'product_category' => $row['product_category'],
        'contact_number' => $row['contact_number'],
        'email' => $row['email'],
        'address' => $row['address'],
        'previous_deal' => ucfirst($row['previous_deal']),
        'remarks' => $row['remarks'],
        'date_added' => format_date($row['date_added']),
        'date_modified' => $row['last_modified'] ? date('d-m-Y', strtotime($row['last_modified'])) : '-',
    ];
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action) {
    header('Content-Type: application/json'); // this file is also included by the vendors page itself
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add_vendor') {
    $vendor = is_array($_POST['vendor'] ?? null) ? $_POST['vendor'] : [];
    if (trim($vendor['supplier_name'] ?? '') === '' || !in_array(strtolower(trim($vendor['previous_deal'] ?? '')), ['yes', 'no'], true)) {
        echo json_encode(['success' => false, 'message' => 'Supplier name and previous deal (Yes/No) are required.']);
        exit;
    }
    $sql = "INSERT INTO vendor (supplier_name, product_category, contact_number, email, address, previous_deal, remarks, date_added, last_modified, added_by) VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute([
        $vendor['supplier_name'],
        $vendor['product_category'],
        $vendor['contact_number'],
        $vendor['email'],
        $vendor['address'],
        strtolower(trim($vendor['previous_deal'])),
        $vendor['remarks'],
        $user_id
    ]);
    echo json_encode(['success' => $success, 'message' => $success ? 'New vendor added successfully' : 'Error adding vendor']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update_vendor') {
    $vendor = is_array($_POST['vendor'] ?? null) ? $_POST['vendor'] : [];
    if (trim($vendor['supplier_name'] ?? '') === '' || !in_array(strtolower(trim($vendor['previous_deal'] ?? '')), ['yes', 'no'], true)) {
        echo json_encode(['success' => false, 'message' => 'Supplier name and previous deal (Yes/No) are required.']);
        exit;
    }
    $id = intval(ltrim($vendor['vendor_id'], 'V'));
    $sql = "UPDATE vendor SET supplier_name=?, product_category=?, contact_number=?, email=?, address=?, previous_deal=?, remarks=?, last_modified=NOW() WHERE id=? AND added_by=?";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute([
        $vendor['supplier_name'],
        $vendor['product_category'],
        $vendor['contact_number'],
        $vendor['email'],
        $vendor['address'],
        strtolower(trim($vendor['previous_deal'])),
        $vendor['remarks'],
        $id,
        $user_id
    ]);
    echo json_encode(['success' => $success, 'message' => $success ? 'Vendor updated successfully' : 'Error updating vendor']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete_vendor') {
    $id = intval(ltrim($_POST['vendor_id'], 'V'));
    $sql = "DELETE FROM vendor WHERE id=? AND added_by=?";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute([$id, $user_id]);
    echo json_encode(['success' => $success, 'message' => $success ? 'Vendor deleted successfully' : 'Error deleting vendor']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add_remark') {
    $id = intval(ltrim($_POST['vendor_id'], 'V'));
    $remark = $_POST['remark'];
    $sql = "UPDATE vendor SET remarks=?, last_modified=NOW() WHERE id=? AND added_by=?";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute([$remark, $id, $user_id]);
    echo json_encode(['success' => $success, 'message' => $success ? 'Remark added successfully' : 'Error adding remark']);
    exit;
}

$search = isset($_GET['searchInput']) ? trim($_GET['searchInput']) : '';
$status = isset($_GET['status']) ? strtolower(trim($_GET['status'])) : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$entries_per_page = 6;
$offset = ($page - 1) * $entries_per_page;

$where = [];
$params = [];

$where[] = "added_by = ?";
$params[] = $user_id;

if ($search !== '') {
    $where[] = "(supplier_name LIKE ? OR product_category LIKE ? OR contact_number LIKE ? OR email LIKE ? OR address LIKE ? OR remarks LIKE ? OR id LIKE ?)";
    $searchTerm = "%$search%";
    for ($i = 0; $i < 7; $i++) {
        $params[] = $searchTerm;
    }
}
if ($status === 'yes' || $status === 'no') {
    $where[] = "previous_deal = ?";
    $params[] = $status;
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Count total entries
$count_sql = "SELECT COUNT(*) as cnt FROM vendor $where_sql";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->execute($params);
$total_entries = $count_stmt->fetchColumn();
$count_stmt = null;

$total_pages = ceil($total_entries / $entries_per_page);

// Fetch paginated data
$entries_per_page = (int)$entries_per_page;
$offset = (int)$offset;
$data_sql = "SELECT * FROM vendor $where_sql ORDER BY id DESC LIMIT $entries_per_page OFFSET $offset";
$data_stmt = $conn->prepare($data_sql);
$data_stmt->execute($params);
$vendors = $data_stmt->fetchAll();
$data_stmt = null;
$vendors = array_map('map_vendor_row', $vendors);

// Output JSON for AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $vendors,
        'pagination' => [
            'current_page' => (int)$page,
            'total_pages' => (int)$total_pages,
            'entries_per_page' => (int)$entries_per_page,
            'total_entries' => (int)$total_entries,
            'showing_start' => (int)($offset + 1),
            'showing_end' => (int)min($offset + $entries_per_page, $total_entries)
        ]
    ]);
    exit;
}

if (!isset($includeOnly)) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $vendors,
        'pagination' => [
            'current_page' => (int)$page,
            'total_pages' => (int)$total_pages,
            'entries_per_page' => (int)$entries_per_page,
            'total_entries' => (int)$total_entries,
            'showing_start' => (int)($offset + 1),
            'showing_end' => (int)min($offset + $entries_per_page, $total_entries)
        ]
    ]);
    exit;
}