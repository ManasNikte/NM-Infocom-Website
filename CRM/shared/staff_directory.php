<?php
// Company-wide staff list for layout/staff_directory.php (admin and HR).
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'hr');

// Connect to the database

try {
    $db = new Database();
    $pdo = $db->getConnection();
} catch (Exception $e) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]));
}

// Build base query
$base_sql = "SELECT id, name, contact, email, DOB, resume, role, sub_role, status, date_added, date_of_joining, date_of_resignation, fire_reason, last_login FROM users";
// Admins see every account; HR sees managers and employees.
$where = strtolower($auth->role) === 'admin' ? ['1=1'] : ["role != 'admin'"];
$params = [];

// Search filter
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $search = strtolower(trim($_GET['search']));
    $where[] = "(LOWER(name) LIKE :searchLike1 OR LOWER(id) LIKE :searchLike2 OR LOWER(role) LIKE :searchLike3)";
    $params[':searchLike1'] = '%' . $search . '%';
    $params[':searchLike2'] = '%' . $search . '%';
    $params[':searchLike3'] = '%' . $search . '%';
}
// Status filter
if (isset($_GET['status']) && $_GET['status'] !== '') {
    $where[] = "LOWER(status) = :status";
    $params[':status'] = strtolower($_GET['status']);
}
// Role filter
if (isset($_GET['role']) && $_GET['role'] !== '') {
    $where[] = "LOWER(role) = :role";
    $params[':role'] = strtolower($_GET['role']);
}
// Sub Role filter
if (isset($_GET['sub_role']) && $_GET['sub_role'] !== '') {
    $where[] = "LOWER(sub_role) = :sub_role";
    $params[':sub_role'] = strtolower($_GET['sub_role']);
}
// Date filter (date_of_joining or date_of_resignation)
if (isset($_GET['date']) && $_GET['date'] !== '') {
    $filterDate = date('Y-m-d', strtotime($_GET['date']));
    $where[] = "(date_of_joining = :filterDate1 OR date_of_resignation = :filterDate2)";
    $params[':filterDate1'] = $filterDate;
    $params[':filterDate2'] = $filterDate;
}

// If includeOnly=1, show all active Employees and Managers (all sub_roles), ignore other filters
if (isset($_GET['includeOnly']) && $_GET['includeOnly'] == '1') {
    $where = ["(role = 'Employee' OR role = 'Manager')", "status = 'active'"];
    $params = [];
    $where_sql = ' WHERE ' . implode(' AND ', $where);
    $order_sql = ' ORDER BY id DESC';
    $data_sql = $base_sql . $where_sql . $order_sql;
    $stmt = $pdo->prepare($data_sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
    $leads = array_map(function($user) {
        return [
            'lead_id' => $user['id'],
            'name' => $user['name'],
            'contact' => $user['contact'],
            'email' => $user['email'],
            'dob' => $user['DOB'],
            'role' => $user['role'],
            'sub_role' => $user['sub_role'],
            'status' => $user['status'],
            'date_added' => $user['date_added'],
            'added_on' => $user['date_of_joining'] ? date('d-m-Y', strtotime($user['date_of_joining'])) : '',
            'modified' => $user['date_of_resignation'] ? date('d-m-Y', strtotime($user['date_of_resignation'])) : '',
            'date_of_joining' => $user['date_of_joining'],
            'date_of_resignation' => $user['date_of_resignation'],
            'fire_reason' => isset($user['fire_reason']) ? $user['fire_reason'] : '',
            'resume_url' => $user['resume'] ?? '',
            'last_login' => $user['last_login'] ?? ''
        ];
    }, $users);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $leads
    ]);
    exit;
}

$where_sql = $where ? (' WHERE ' . implode(' AND ', $where)) : '';
$order_sql = ' ORDER BY id DESC';

// Count total entries for pagination
$countSql = "SELECT COUNT(*) FROM users" . $where_sql;
$countStmt = $pdo->prepare($countSql);
foreach ($params as $key => $val) {
    $countStmt->bindValue($key, $val);
}
$countStmt->execute();
$total_entries = (int)$countStmt->fetchColumn();

$entries_per_page = 6;
$total_pages = $total_entries > 0 ? ceil($total_entries / $entries_per_page) : 1;
$current_page = isset($_GET['page']) ? max(1, min($total_pages, intval($_GET['page']))) : 1;
$offset = ($current_page - 1) * $entries_per_page;

// Add pagination to query (do NOT add LIMIT to count query)
$data_sql = $base_sql . $where_sql . $order_sql . " LIMIT $offset, $entries_per_page";
$stmt = $pdo->prepare($data_sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->execute();
$users = $stmt->fetchAll();

// Map DB fields to API fields
$leads = array_map(function($user) {
    return [
        'lead_id' => $user['id'],
        'name' => $user['name'],
        'contact' => $user['contact'],
        'email' => $user['email'],
        'dob' => $user['DOB'],
        'role' => $user['role'],
        'sub_role' => $user['sub_role'],
        'status' => $user['status'],
        'date_added' => $user['date_added'],
        'added_on' => $user['date_of_joining'] ? date('d-m-Y', strtotime($user['date_of_joining'])) : '',
        'modified' => $user['date_of_resignation'] ? date('d-m-Y', strtotime($user['date_of_resignation'])) : '',
        'date_of_joining' => $user['date_of_joining'],
        'date_of_resignation' => $user['date_of_resignation'],
        'fire_reason' => isset($user['fire_reason']) ? $user['fire_reason'] : '',
        'resume_url' => $user['resume'] ?? '',
        'last_login' => $user['last_login'] ?? ''
    ];
}, $users);

// Pagination settings
// (already handled above)

// If it's an AJAX request or a GET request, always return JSON
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $leads,
        'pagination' => [
            'current_page' => (int)$current_page,
            'total_pages' => (int)$total_pages,
            'entries_per_page' => (int)$entries_per_page,
            'total_entries' => (int)$total_entries,
            'showing_start' => $total_entries > 0 ? (int)($offset + 1) : 0,
            'showing_end' => (int)min($offset + $entries_per_page, $total_entries)
        ]
    ]);
    exit;
}
