<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');

// Connect to the database

try {
    $db = new Database();
    $pdo = $db->getConnection();
} catch (Exception $e) {
    die(json_encode(['success' => false, 'message' => crm_public_error($e)]));
}

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
if (!$employee_id || strtolower($role) !== 'manager' || strtolower($sub_role) !== 'purchase') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

// Build base query with join to get added_by id and name
$sql = "SELECT l.*, u.id AS added_by_id, u.name AS added_by_name, u.role AS added_by_role, u.sub_role AS added_by_sub_role, v.supplier_name
        FROM leads l
        LEFT JOIN users u ON l.added_by = u.id
        LEFT JOIN vendor v ON l.vendor_id = v.id
        WHERE 1";
$params = [];

// Search filter
if (!empty($_GET['search'])) {
    $search = strtolower(trim((string)($_GET['search'] ?? '')));
    $searchLike = '%' . $search . '%';
    $searchNumeric = is_numeric($search);

    $sql .= " AND (";
    $conditions = [];
    $searchColumns = [
        'l.name',
        'l.contact',
        'l.product',
        'l.email',
        'l.assigned_to',
        'l.status',
        'l.response',
        'l.added_by'
    ];
    foreach ($searchColumns as $idx => $col) {
        $param = ":searchLike$idx";
        $conditions[] = "LOWER($col) LIKE $param";
        $params[$param] = $searchLike;
    }
    // Only search numeric columns if the search is numeric
    if ($searchNumeric) {
        $conditions[] = "l.lead_id = :searchNumLeadId";
        $conditions[] = "l.quantity = :searchNumQuantity";
        $params[':searchNumLeadId'] = $search;
        $params[':searchNumQuantity'] = $search;
    }
    $sql .= implode(' OR ', $conditions) . ")";
}

// Status filter - support multiple statuses (comma-separated)
if (!empty($_GET['status'])) {
    $status = strtolower($_GET['status']);
    if (strpos($status, ',') !== false) {
        // Multiple statuses
        $statuses = array_map('trim', explode(',', $status));
        $statusConditions = [];
        foreach ($statuses as $idx => $statusValue) {
            $param = ":status$idx";
            $statusConditions[] = "LOWER(l.status) = $param";
            $params[$param] = $statusValue;
        }
        $sql .= " AND (" . implode(' OR ', $statusConditions) . ")";
    } else {
        // Single status
        $sql .= " AND LOWER(l.status) = :status";
        $params[':status'] = $status;
    }
} else {
    // Default filter for purchase orders: only connected and completed
    $sql .= " AND (LOWER(l.status) = 'connected' OR LOWER(l.status) = 'closed')";
}
// Vendor filter
if (!empty($_GET['vendor_id'])) {
    $sql .= " AND l.vendor_id = :vendor_id";
    $params[':vendor_id'] = $_GET['vendor_id'];
}

// Response filter
if (!empty($_GET['response'])) {
    $response = strtolower($_GET['response']);
    $sql .= " AND LOWER(l.response) = :response_filter";
    $params[':response_filter'] = $response;
} else {
    // Default filter for purchase orders: only positive response
    $sql .= " AND LOWER(l.response) = 'positive'";
}

// Date filter
if (!empty($_GET['date'])) {
    $filterDate = date('Y-m-d', strtotime($_GET['date']));
    $sql .= " AND DATE(l.modified) = :filterDate";
    $params[':filterDate'] = $filterDate;
}

// Count total entries for pagination
$countSql = "SELECT COUNT(*) FROM (" . $sql . ") AS sub";
try {
    $stmt = $pdo->prepare($countSql);
    $stmt->execute($params);
    $total_entries = (int)$stmt->fetchColumn();
} catch (PDOException $e) {
    error_log('SQL: ' . $countSql);
    error_log('Params: ' . print_r($params, true));
    throw $e;
}

$entries_per_page = 6;
$total_pages = ceil($total_entries / $entries_per_page);
$current_page = isset($_GET['page']) ? max(1, min($total_pages, intval($_GET['page']))) : 1;
$offset = ($current_page - 1) * $entries_per_page;

// Add pagination to query
$sql .= " ORDER BY l.lead_id DESC LIMIT $offset, $entries_per_page";

try {
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => &$val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->execute();
    $leads = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('SQL: ' . $sql);
    error_log('Params: ' . print_r($params, true));
    throw $e;
}

// Add 'added_by_user' field to each lead
foreach ($leads as &$lead) {
    $lead['added_by_user'] = ($lead['added_by_id'] ?? $lead['added_by']) . ' - ' . ($lead['added_by_name'] ?? '');
}

// If it's an AJAX request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
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

// If it's a regular request without includeOnly flag
if (!isset($includeOnly)) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $leads,
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
