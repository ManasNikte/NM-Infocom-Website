<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'sales');
// Decode JWT to get user id
$user_id = $auth->id;

// Connect to DB
$db = new Database();
$conn = $db->getConnection();

// Filtering and search
$where = 'WHERE 1';
$params = [];

// --- Stats Cards Logic ---
if (isset($_GET['stats']) && $_GET['stats'] == '1') {
    // New Leads
    $new_sql = "SELECT COUNT(*) FROM leads WHERE status = 'new'";
    $new_count = $conn->query($new_sql)->fetchColumn();
    // Leads Closed
    $closed_sql = "SELECT COUNT(*) FROM leads WHERE status = 'closed'";
    $closed_count = $conn->query($closed_sql)->fetchColumn();
    // Won
    $won_sql = "SELECT COUNT(*) FROM leads WHERE status = 'closed' AND response = 'positive'";
    $won_count = $conn->query($won_sql)->fetchColumn();
    // Lost
    $lost_sql = "SELECT COUNT(*) FROM leads WHERE status = 'closed' AND response = 'negative'";
    $lost_count = $conn->query($lost_sql)->fetchColumn();
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'stats' => [
            'new_leads' => (int)$new_count,
            'leads_closed' => (int)$closed_count,
            'won' => (int)$won_count,
            'lost' => (int)$lost_count
        ]
    ]);
    exit;
}

if (!empty($_GET['search'])) {
    $search = '%' . strtolower(trim($_GET['search'])) . '%';
    $where .= " AND (LOWER(l.name) LIKE ? OR LOWER(l.contact) LIKE ? OR LOWER(l.product) LIKE ? OR LOWER(CAST(l.lead_id AS CHAR)) LIKE ? OR LOWER(CAST(l.quantity AS CHAR)) LIKE ? OR LOWER(l.email) LIKE ? OR LOWER(l.status) LIKE ? OR LOWER(l.response) LIKE ? OR LOWER(l.remarks) LIKE ?)";
    for ($i = 0; $i < 9; $i++) $params[] = $search;
}

if (!empty($_GET['status'])) {
    $status = strtolower(trim($_GET['status']));
    $where .= " AND LOWER(l.status) = ?";
    $params[] = $status;
}

if (!empty($_GET['response'])) {
    $response = strtolower(trim($_GET['response']));
    $where .= " AND LOWER(l.response) = ?";
    $params[] = $response;
}

// Add assigned_to filter support
if (!empty($_GET['assigned_to'])) {
    $where .= " AND l.assigned_to = ?";
    $params[] = $_GET['assigned_to'];
}

// Pagination
$entries_per_page = 6;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $entries_per_page;

// Count total entries
$count_sql = "SELECT COUNT(*) FROM leads l $where";
$stmt = $conn->prepare($count_sql);
$stmt->execute($params);
$total_entries = $stmt->fetchColumn();
$total_pages = ceil($total_entries / $entries_per_page);
$stmt = null;

// Fetch paginated data
$sql = "SELECT l.*, u.name as assigned_to_name FROM leads l LEFT JOIN users u ON l.assigned_to = u.id $where ORDER BY l.lead_id DESC LIMIT $entries_per_page OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll();
$stmt = null;

// Map DB rows to expected structure
$paginated_leads = array_map(function($lead) {
    $assigned_to = $lead['assigned_to'] ?? '';
    $assigned_to_name = $lead['assigned_to_name'] ?? '';
    $assigned_to_display = $assigned_to ? $assigned_to . ($assigned_to_name ? ' - ' . $assigned_to_name : '') : '';
    return [
        'lead_id' => $lead['lead_id'],
        'name' => $lead['name'],
        'contact' => $lead['contact'],
        'email' => $lead['email'],
        'product' => $lead['product'],
        'quantity' => $lead['quantity'],
        'added_on' => date('d-m-y', strtotime($lead['added_on'])),
        'modified' => date('d-m-y', strtotime($lead['modified'])),
        'remarks' => $lead['remarks'],
        'status' => $lead['status'],
        'response' => $lead['response'],
        'added_by' => $lead['added_by'] ?? 'Admin',
        'assigned_to' => $assigned_to_display
    ];
}, $leads);

// AJAX/POST actions
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    
    // Lead edits go through data/update_*.php (shared/lead_update.php).

    // Pagination GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['page'])) {
        echo json_encode([
            'success' => true,
            'data' => $paginated_leads,
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
}

// If it's a regular request without includeOnly flag
if (!isset($includeOnly)) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $paginated_leads,
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
} else {
    // If included, set $salesResult for use in the parent file
    $salesResult = [
        'success' => true,
        'data' => $paginated_leads,
        'pagination' => [
            'current_page' => (int)$page,
            'total_pages' => (int)$total_pages,
            'entries_per_page' => (int)$entries_per_page,
            'total_entries' => (int)$total_entries,
            'showing_start' => (int)($offset + 1),
            'showing_end' => (int)min($offset + $entries_per_page, $total_entries)
        ]
    ];
}