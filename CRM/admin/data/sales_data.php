<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');

// Connect to the database



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
$sql = "SELECT l.*, 
               u1.name as assigned_to_name, 
               u2.name as added_by_name, 
               v.id as vendor_id, v.supplier_name as vendor_name
        FROM leads l 
        LEFT JOIN users u1 ON l.assigned_to = u1.id 
        LEFT JOIN users u2 ON l.added_by = u2.id 
        LEFT JOIN vendor v ON l.vendor_id = v.id
        $where 
        ORDER BY l.lead_id DESC 
        LIMIT $entries_per_page OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll();
$stmt = null;

// Map DB rows to expected structure
$paginated_leads = array_map(function($lead) {
    $assigned_to = $lead['assigned_to'] ?? '';
    $assigned_to_name = $lead['assigned_to_name'] ?? '';
    $assigned_to_display = $assigned_to ? $assigned_to . ($assigned_to_name ? ' - ' . $assigned_to_name : '') : '';

    $added_by = $lead['added_by'] ?? '';
    $added_by_name = $lead['added_by_name'] ?? '';
    $added_by_display = $added_by ? $added_by . ($added_by_name ? ' - ' . $added_by_name : '') : '';

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
        'added_by' => $added_by_display ?: 'Admin',
        'assigned_to' => $assigned_to_display,
        'vendor_id' => $lead['vendor_id'],
        'supplier_name' => $lead['vendor_name'],
    ];
}, $leads);

// AJAX/POST actions
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    
    // Add new lead
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_lead') {
        $newLead = $_POST['lead'];
        if (empty($newLead['name']) || empty($newLead['contact']) || empty($newLead['product'])) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']); exit;
        }
        $stmt = $conn->prepare("INSERT INTO leads (name, contact, product, quantity, status, response, remarks, added_on, modified, added_by, assigned_to) VALUES (?, ?, ?, ?, 'connected', 'positive', 'Pending', NOW(), NOW(), ?, ?)");
        $stmt->execute([
            $newLead['name'] ?? '',
            $newLead['contact'] ?? '',
            $newLead['product'] ?? '',
            $newLead['quantity'] ?? 1,
            'Admin',
            $user_id
        ]);
        echo json_encode(['success' => true, 'message' => 'Lead added successfully']); exit;
    }

    // Update lead
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_lead') {
        $updatedLead = $_POST['lead'];
        if (empty($updatedLead['name']) || empty($updatedLead['contact']) || empty($updatedLead['product'])) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']); exit;
        }
        $id = intval(ltrim($updatedLead['lead_id'], 'L'));
        $stmt = $conn->prepare("UPDATE leads SET name=?, contact=?, email=?, product=?, quantity=?, modified=NOW() WHERE lead_id=? AND assigned_to=?");
        $stmt->execute([
            $updatedLead['name'],
            $updatedLead['contact'],
            $updatedLead['email'],
            $updatedLead['product'],
            $updatedLead['quantity'],
            $id,
            $user_id
        ]);
        echo json_encode(['success' => true, 'message' => 'Lead updated successfully']); exit;
    }

    // Delete lead
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_lead') {
        $id = intval(ltrim($_POST['lead_id'], 'L'));
        $stmt = $conn->prepare("DELETE FROM leads WHERE lead_id=? AND assigned_to=?");
        $stmt->execute([$id, $user_id]);
        echo json_encode(['success' => true, 'message' => 'Lead deleted successfully']); exit;
    }

    // Update remarks
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_remarks') {
        $id = intval(ltrim($_POST['lead_id'], 'L'));
        $stmt = $conn->prepare("UPDATE leads SET remarks=?, modified=NOW() WHERE lead_id=? AND assigned_to=?");
        $stmt->execute([
            $_POST['remarks'] ?? '',
            $id,
            $user_id
        ]);
        echo json_encode(['success' => true, 'message' => 'Remarks updated successfully']); exit;
    }

    // Update status
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
        $id = intval(ltrim($_POST['lead_id'], 'L'));
        $status = $_POST['status'] ?? '';
        $stmt = $conn->prepare("UPDATE leads SET status=?, modified=NOW() WHERE lead_id=? AND assigned_to=?");
        $stmt->execute([
            $status,
            $id,
            $user_id
        ]);
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']); exit;
    }

    // Update response
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_response') {
        $id = intval(ltrim($_POST['lead_id'], 'L'));
        $response = $_POST['response'] ?? '';
        $stmt = $conn->prepare("UPDATE leads SET response=?, modified=NOW() WHERE lead_id=? AND assigned_to=?");
        $stmt->execute([
            $response,
            $id,
            $user_id
        ]);
        echo json_encode(['success' => true, 'message' => 'Response updated successfully']); exit;
    }

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