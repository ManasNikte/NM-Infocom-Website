<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api('Employee', 'sales');
// Decode JWT to get user id
$user_id = $auth->id;

// Connect to DB
$db = new Database();
$conn = $db->getConnection();

// Filtering and search
$where = 'WHERE assigned_to = ?';
$params = [$user_id];

if (!empty($_GET['search'])) {
    $search = '%' . strtolower(trim($_GET['search'])) . '%';
    $where .= " AND (LOWER(name) LIKE ? OR LOWER(contact) LIKE ? OR LOWER(product) LIKE ? OR LOWER(CAST(lead_id AS CHAR)) LIKE ? OR LOWER(CAST(quantity AS CHAR)) LIKE ? OR LOWER(email) LIKE ? OR LOWER(status) LIKE ? OR LOWER(response) LIKE ? OR LOWER(remarks) LIKE ?)";
    for ($i = 0; $i < 9; $i++) $params[] = $search;
}

if (!empty($_GET['status'])) {
    $status = strtolower($_GET['status']);
    if (in_array($status, ['positive', 'negative', 'confused', 'completed'])) {
        $where .= " AND LOWER(response) = ?";
        $params[] = $status;
    } else {
        $where .= " AND LOWER(status) = ?";
        $params[] = $status;
    }
}

// Add response filter support
if (!empty($_GET['response'])) {
    $response = strtolower($_GET['response']);
    $where .= " AND LOWER(response) = ?";
    $params[] = $response;
}

// Pagination
$entries_per_page = 6;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $entries_per_page;

// Count total entries
$count_sql = "SELECT COUNT(*) FROM leads $where";
$stmt = $conn->prepare($count_sql);
$stmt->execute($params);
$total_entries = $stmt->fetchColumn();
$total_pages = ceil($total_entries / $entries_per_page);
$stmt = null;

// Fetch paginated data
$sql = "SELECT * FROM leads $where ORDER BY lead_id DESC LIMIT $entries_per_page OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll();
$stmt = null;

// Map DB rows to expected structure
$paginated_leads = array_map(function($lead) {
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
        'added_by' => $lead['added_by'] ?? 'Admin'
    ];
}, $leads);

/** True when the lead exists and is assigned to this employee (an unchanged value updates 0 rows). */
function crm_owns_lead(PDO $conn, $leadId, $userId) {
    $q = $conn->prepare('SELECT COUNT(*) FROM leads WHERE lead_id = ? AND assigned_to = ?');
    $q->execute([$leadId, $userId]);
    return (bool) $q->fetchColumn();
}

// AJAX/POST actions
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    

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
        echo json_encode($stmt->rowCount() > 0 || $stmt->errorCode() === '00000' && crm_owns_lead($conn, $id, $user_id) ? ['success' => true, 'message' => 'Lead updated successfully'] : ['success' => false, 'message' => 'Lead not found']); exit;
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
        echo json_encode($stmt->rowCount() > 0 || $stmt->errorCode() === '00000' && crm_owns_lead($conn, $id, $user_id) ? ['success' => true, 'message' => 'Remarks updated successfully'] : ['success' => false, 'message' => 'Lead not found']); exit;
    }

    // Update status
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
        $id = intval(ltrim($_POST['lead_id'], 'L'));
        $status = strtolower(trim((string) ($_POST['status'] ?? '')));
        if (!in_array($status, ['new', 'connected', 'not connected', 'confused', 'closed'], true)) {
            echo json_encode(['success' => false, 'message' => 'Unknown status']); exit;
        }
        $stmt = $conn->prepare("UPDATE leads SET status=?, modified=NOW() WHERE lead_id=? AND assigned_to=?");
        $stmt->execute([
            $status,
            $id,
            $user_id
        ]);
        echo json_encode($stmt->rowCount() > 0 || $stmt->errorCode() === '00000' && crm_owns_lead($conn, $id, $user_id) ? ['success' => true, 'message' => 'Status updated successfully'] : ['success' => false, 'message' => 'Lead not found']); exit;
    }

    // Update response
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_response') {
        $id = intval(ltrim($_POST['lead_id'], 'L'));
        $response = strtolower(trim((string) ($_POST['response'] ?? '')));
        if ($response !== '' && !in_array($response, ['positive', 'negative'], true)) {
            echo json_encode(['success' => false, 'message' => 'Unknown response']); exit;
        }
        $response = $response ?: null;
        $stmt = $conn->prepare("UPDATE leads SET response=?, modified=NOW() WHERE lead_id=? AND assigned_to=?");
        $stmt->execute([
            $response,
            $id,
            $user_id
        ]);
        echo json_encode($stmt->rowCount() > 0 || $stmt->errorCode() === '00000' && crm_owns_lead($conn, $id, $user_id) ? ['success' => true, 'message' => 'Response updated successfully'] : ['success' => false, 'message' => 'Lead not found']); exit;
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