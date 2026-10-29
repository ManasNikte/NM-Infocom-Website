<?php
// Employees in the logged-in manager's department: paginated for layout/manager_emp_list.php,
// or every active one with ?all=1 (task assignment dropdowns).
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager']);
header('Content-Type: application/json');

// Admins may pass ?dept=; managers always see their own department.
$dept = strtolower($auth->role) === 'admin' ? ($_GET['dept'] ?? '') : $auth->sub_role;

$isAdmin = strtolower($auth->role) === 'admin';
$all = !empty($_GET['all']);
if ($isAdmin && $all && $dept === '') {
    // Admin task assignment: every manager and employee.
    $where = ["role IN ('Manager', 'Employee')"];
    $params = [];
} else {
    $where = ["role = 'Employee'", 'sub_role = ?'];
    $params = [$dept];
}
if (($search = trim($_GET['search'] ?? '')) !== '') {
    $where[] = '(name LIKE ? OR id LIKE ? OR email LIKE ?)';
    array_push($params, "%$search%", "%$search%", "%$search%");
}
if (($status = $_GET['status'] ?? '') !== '') {
    $where[] = 'LOWER(status) = ?';
    $params[] = strtolower($status);
}
if (($date = $_GET['date'] ?? '') !== '' && strtotime($date)) {
    $where[] = '(date_of_joining = ? OR date_of_resignation = ?)';
    $day = date('Y-m-d', strtotime($date));
    array_push($params, $day, $day);
}
if ($all) {
    $where[] = "(status = 'active' OR status IS NULL)";
}
$whereSql = implode(' AND ', $where);

try {
    $conn = (new Database())->getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE $whereSql");
    $stmt->execute($params);
    $total = (int) $stmt->fetchColumn();

    $perPage = $all ? max(1, $total) : 6;
    $pages = max(1, (int) ceil($total / $perPage));
    $page = min($pages, max(1, (int) ($_GET['page'] ?? 1)));
    $offset = ($page - 1) * $perPage;
    $orderBy = $all ? 'sub_role, role, name' : 'id DESC';

    $stmt = $conn->prepare("SELECT id, name, contact, email, DOB, role, sub_role, status, date_added,
                                   date_of_joining, date_of_resignation, fire_reason, resume
                            FROM users WHERE $whereSql ORDER BY $orderBy LIMIT $offset, $perPage");
    $stmt->execute($params);

    $fmt = function ($d) { return $d ? date('d-m-Y', strtotime($d)) : ''; };
    $rows = array_map(function ($u) use ($fmt) {
        return [
            'lead_id' => $u['id'],
            'name' => $u['name'],
            'contact' => $u['contact'],
            'email' => $u['email'],
            'dob' => $u['DOB'],
            'role' => $u['role'],
            'sub_role' => $u['sub_role'],
            'status' => $u['status'],
            'date_added' => $u['date_added'],
            'added_on' => $fmt($u['date_of_joining']),
            'modified' => $fmt($u['date_of_resignation']),
            'date_of_joining' => $u['date_of_joining'],
            'date_of_resignation' => $u['date_of_resignation'],
            'fire_reason' => $u['fire_reason'] ?? '',
            'resume_url' => $u['resume'] ?? '',
        ];
    }, $stmt->fetchAll(PDO::FETCH_ASSOC));

    echo json_encode([
        'success' => true,
        'scope' => $isAdmin && $all && $dept === '' ? 'all' : 'department',
        'data' => $rows,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $pages,
            'entries_per_page' => $perPage,
            'total_entries' => $total,
            'showing_start' => $total > 0 ? $offset + 1 : 0,
            'showing_end' => min($offset + $perPage, $total),
        ],
    ]);
} catch (Exception $e) {
    error_log('department_staff: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not load employees']);
}
