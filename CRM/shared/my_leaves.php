<?php
// JSON endpoint for the logged-in user's own leaves (any role).
//   GET, or POST without action      -> paginated list (page, search, status, date)
//   POST action=addLeave             -> reason, startDate, endDate
//   POST action=updateLeave          -> leave_id, reason, startDate, endDate (pending only)
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/leaves_lib.php';
$auth = crm_require_api(['Admin', 'Manager', 'Employee']);
header('Content-Type: application/json');

try {
    $conn = (new Database())->getConnection();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || in_array($_POST['action'] ?? '', ['', 'getLeaves'], true)) {
        echo json_encode(crm_my_leaves($conn, $auth->id, $_POST + $_GET));
        exit;
    }

    $reason = trim($_POST['reason'] ?? '');
    $start = trim($_POST['startDate'] ?? '');
    $end = trim($_POST['endDate'] ?? '');
    switch ($_POST['action'] ?? '') {
        case 'addLeave':
            echo json_encode(crm_add_leave($conn, $auth->id, $reason, $start, $end));
            break;
        case 'updateLeave':
            echo json_encode(crm_update_leave($conn, $auth->id, (int) ($_POST['leave_id'] ?? 0), $reason, $start, $end));
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Unknown action.']);
    }
} catch (Exception $e) {
    error_log('my_leaves: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Could not process the leave request.']);
}
