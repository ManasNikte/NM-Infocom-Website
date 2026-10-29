<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');
header('Content-Type: application/json');

// Connect to DB
$db = new Database();
$pdo = $db->getConnection();

// Filters
$where = [];
$params = [];
if (!empty($_GET['search'])) {
    $search = '%' . strtolower(trim($_GET['search'])) . '%';
    $where[] = "(LOWER(full_name) LIKE ? OR LOWER(email) LIKE ? OR contact LIKE ? OR LOWER(location) LIKE ?)";
    $params = array_merge($params, [$search, $search, $search, $search]);
}
if (!empty($_GET['status'])) {
    $where[] = "LOWER(status) = ?";
    $params[] = strtolower($_GET['status']);
}
if (!empty($_GET['date'])) {
    $where[] = "DATE(date_applied) = ?";
    $params[] = date('Y-m-d', strtotime($_GET['date']));
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Pagination
$entries_per_page = 6;
$total_entries = 0;
$total_pages = 1;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $entries_per_page;

// Get total count
$count_sql = "SELECT COUNT(*) FROM job_applicants $where_sql";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_entries = (int)$stmt->fetchColumn();
$total_pages = $total_entries > 0 ? ceil($total_entries / $entries_per_page) : 1;

// Get paginated data
$sql = "SELECT id, job_id, full_name, email, contact, location, pdf_link, status, date_applied FROM job_applicants $where_sql ORDER BY date_applied DESC LIMIT $entries_per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output
echo json_encode([
    'success' => true,
    'data' => $applicants,
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
?>
