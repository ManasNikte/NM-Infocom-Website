<?php
// Leave requests of the employees in the logged-in manager's department.
//   POST action=getLeaves (page, search, status, date, rowsPerPage) -> paginated list
//   POST action=approveLeave|rejectLeave (leave_id)                 -> decide a request
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api('Manager');
header('Content-Type: application/json');

$dept = $auth->sub_role;
$action = $_POST['action'] ?? '';

try {
    $conn = (new Database())->getConnection();

    if ($action === 'approveLeave' || $action === 'rejectLeave') {
        $leaveId = (int) ($_POST['leave_id'] ?? 0);
        $newStatus = $action === 'approveLeave' ? 'approved' : 'rejected';
        $stmt = $conn->prepare("UPDATE leaves l JOIN users u ON u.id = l.user_id
                                SET l.status = ?, l.action_by = ?
                                WHERE l.id = ? AND u.role = 'Employee' AND u.sub_role = ?");
        $stmt->execute([$newStatus, $auth->id, $leaveId, $dept]);
        if ($stmt->rowCount() > 0) {
            require_once __DIR__ . '/../config/notify.php';
            crm_notify_leave_decided($conn, $leaveId);
        }
        echo json_encode($stmt->rowCount() > 0
            ? ['status' => 'success', 'message' => "Leave $newStatus successfully."]
            : ['status' => 'error', 'message' => "Leave not found or already $newStatus."]);
        exit;
    }

    if ($action !== 'getLeaves') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        exit;
    }

    $where = ["u.role = 'Employee'", 'u.sub_role = ?'];
    $params = [$dept];
    if (($search = trim($_POST['search'] ?? '')) !== '') {
        $where[] = '(l.reason LIKE ? OR l.status LIKE ? OR l.start_date LIKE ? OR l.end_date LIKE ? OR u.name LIKE ?)';
        array_push($params, ...array_fill(0, 5, "%$search%"));
    }
    if (($status = trim($_POST['status'] ?? '')) !== '') {
        $where[] = 'l.status = ?';
        $params[] = $status;
    }
    if (($date = trim($_POST['date'] ?? '')) !== '') {
        $where[] = 'l.start_date <= ? AND l.end_date >= ?';
        array_push($params, $date, $date);
    }
    $whereSql = implode(' AND ', $where);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM leaves l JOIN users u ON l.user_id = u.id WHERE $whereSql");
    $stmt->execute($params);
    $total = (int) $stmt->fetchColumn();
    $rowsPerPage = max(1, min(50, (int) ($_POST['rowsPerPage'] ?? 7)));
    $totalPages = max(1, (int) ceil($total / $rowsPerPage));
    $page = min($totalPages, max(1, (int) ($_POST['page'] ?? 1)));
    $offset = ($page - 1) * $rowsPerPage;

    $stmt = $conn->prepare("SELECT l.id, u.name, l.reason, l.start_date AS startDate, l.end_date AS endDate, l.status
                            FROM leaves l JOIN users u ON l.user_id = u.id
                            WHERE $whereSql ORDER BY l.id DESC LIMIT $offset, $rowsPerPage");
    $stmt->execute($params);

    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'pagination' => ['page' => $page, 'totalPages' => $totalPages, 'totalRecords' => $total, 'rowsPerPage' => $rowsPerPage],
    ]);
} catch (Exception $e) {
    error_log('team_leaves: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Could not process leave request.']);
}
