<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');

// Only require the database config, do NOT redeclare getDBConnection()

// Use getDBConnection() from config/database.php

// Pagination settings
$entries_per_page = 6;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $entries_per_page;

// Search and filter
$where = [];
$params = [];

if (!empty($_GET['searchInput'])) {
    $search = '%' . strtolower(trim($_GET['searchInput'])) . '%';
    $where[] = '('
        . 'LOWER(id) LIKE :search1 OR '
        . 'LOWER(supplier_name) LIKE :search2 OR '
        . 'LOWER(product_category) LIKE :search3 OR '
        . 'LOWER(contact_number) LIKE :search4 OR '
        . 'LOWER(email) LIKE :search5 OR '
        . 'LOWER(address) LIKE :search6 OR '
        . 'LOWER(previous_deal) LIKE :search7 OR '
        . 'LOWER(remarks) LIKE :search8'
        . ')';
    $params[':search1'] = $search;
    $params[':search2'] = $search;
    $params[':search3'] = $search;
    $params[':search4'] = $search;
    $params[':search5'] = $search;
    $params[':search6'] = $search;
    $params[':search7'] = $search;
    $params[':search8'] = $search;
}
if (!empty($_GET['status']) && in_array(strtolower($_GET['status']), ['yes', 'no'])) {
    $where[] = 'LOWER(previous_deal) = :status';
    $params[':status'] = strtolower($_GET['status']);
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Get total count
$count_sql = "SELECT COUNT(*) FROM vendor $where_sql";
$stmt = getDBConnection()->prepare($count_sql);
$stmt->execute($params);
$total_entries = (int)$stmt->fetchColumn();
$total_pages = max(1, ceil($total_entries / $entries_per_page));
$current_page = min($current_page, $total_pages);
$offset = ($current_page - 1) * $entries_per_page;

// Get paginated data
$sql = "SELECT v.*, u.name AS added_by_name FROM vendor v LEFT JOIN users u ON v.added_by = u.id $where_sql ORDER BY v.id DESC LIMIT :offset, :limit";
$stmt = getDBConnection()->prepare($sql);
foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v);
}
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', (int)$entries_per_page, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

// Map DB fields to frontend fields
$vendors = array_map(function($row) {
    $added_by = $row['added_by'];
    $added_by_name = $row['added_by_name'];
    if ($added_by && $added_by_name) {
        $added_by_display = $added_by . ' - ' . $added_by_name;
    } elseif ($added_by_name) {
        $added_by_display = $added_by_name;
    } else {
        $added_by_display = $added_by;
    }
    return [
        'vendor_id' => $row['id'],
        'supplier_name' => $row['supplier_name'],
        'product_category' => $row['product_category'],
        'contact_number' => $row['contact_number'],
        'email' => $row['email'],
        'address' => $row['address'],
        'previous_deal' => ucfirst($row['previous_deal']),
        'remarks' => $row['remarks'],
        'date_added' => $row['date_added'] ? date('d-m-Y', strtotime($row['date_added'])) : '',
        'date_modified' => $row['last_modified'] ? date('d-m-Y', strtotime($row['last_modified'])) : '',
        'added_by' => $added_by_display,
    ];
}, $rows);

// AJAX/JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode([
            'success' => true,
            'data' => $vendors,
            'pagination' => [
                'current_page' => (int)$current_page,
                'total_pages' => (int)$total_pages,
                'entries_per_page' => (int)$entries_per_page,
                'total_entries' => (int)$total_entries,
                'showing_start' => (int)($offset + 1),
                'showing_end' => (int)min($offset + $entries_per_page, $total_entries)
            ]
        ]);
        exit;
    }
    // TODO: Implement POST actions (add, update, delete) with DB if needed
}

// If it's a regular request without includeOnly flag
if (!isset($includeOnly)) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $vendors,
        'pagination' => [
            'current_page' => (int)$current_page,
            'total_pages' => (int)$total_pages,
            'entries_per_page' => (int)$entries_per_page,
            'total_entries' => (int)$total_entries,
            'showing_start' => (int)($offset + 1),
            'showing_end' => (int)min($offset + $entries_per_page, $total_entries)
        ]
    ]);
    exit;
}
try {
    $conn = getDBConnection();
} catch (Exception $e) {
    die('DB Error: ' . $e->getMessage());
}