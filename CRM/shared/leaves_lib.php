<?php
// The logged-in user's own leave requests: list, add, and edit while still pending.
// Used by shared/my_leaves.php (JSON) and the leave portal pages (initial render).

function crm_my_leaves(PDO $conn, $userId, array $query, $rowsPerPage = 7) {
    $where = ['user_id = ?'];
    $params = [$userId];
    if (($search = trim($query['search'] ?? '')) !== '') {
        $where[] = '(reason LIKE ? OR status LIKE ? OR start_date LIKE ? OR end_date LIKE ?)';
        array_push($params, "%$search%", "%$search%", "%$search%", "%$search%");
    }
    if (($status = trim($query['status'] ?? '')) !== '') {
        $where[] = 'status = ?';
        $params[] = $status;
    }
    if (($date = trim($query['date'] ?? '')) !== '') {
        $where[] = 'start_date <= ? AND end_date >= ?';
        array_push($params, $date, $date);
    }
    $whereSql = implode(' AND ', $where);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM leaves WHERE $whereSql");
    $stmt->execute($params);
    $total = (int) $stmt->fetchColumn();
    $totalPages = max(1, (int) ceil($total / $rowsPerPage));
    $page = min($totalPages, max(1, (int) ($query['page'] ?? 1)));
    $offset = ($page - 1) * $rowsPerPage;

    $stmt = $conn->prepare("SELECT id, reason, start_date AS startDate, end_date AS endDate, status
                            FROM leaves WHERE $whereSql ORDER BY id DESC LIMIT $offset, $rowsPerPage");
    $stmt->execute($params);

    return [
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'pagination' => ['page' => $page, 'totalPages' => $totalPages, 'totalRecords' => $total, 'rowsPerPage' => $rowsPerPage],
    ];
}

/** Returns an error message, or null when the dates/reason are usable. */
function crm_leave_input_error($reason, $start, $end) {
    if ($reason === '' || $start === '' || $end === '') {
        return 'All fields are required.';
    }
    $s = DateTime::createFromFormat('Y-m-d', $start);
    $e = DateTime::createFromFormat('Y-m-d', $end);
    if (!$s || !$e || $s->format('Y-m-d') !== $start || $e->format('Y-m-d') !== $end) {
        return 'Invalid date format.';
    }
    if ($e < $s) {
        return 'End date cannot be before start date.';
    }
    return null;
}

function crm_add_leave(PDO $conn, $userId, $reason, $start, $end) {
    if ($error = crm_leave_input_error($reason, $start, $end)) {
        return ['status' => 'error', 'message' => $error];
    }
    $conn->prepare("INSERT INTO leaves (user_id, reason, start_date, end_date, status) VALUES (?, ?, ?, ?, 'pending')")
         ->execute([$userId, $reason, $start, $end]);
    require_once __DIR__ . '/../config/notify.php';
    crm_notify_leave_requested($conn, $userId, $start, $end, $reason);
    return ['status' => 'success', 'message' => 'Leave request submitted successfully.'];
}

function crm_update_leave(PDO $conn, $userId, $leaveId, $reason, $start, $end) {
    if ($error = crm_leave_input_error($reason, $start, $end)) {
        return ['status' => 'error', 'message' => $error];
    }
    $stmt = $conn->prepare("UPDATE leaves SET reason = ?, start_date = ?, end_date = ?
                            WHERE id = ? AND user_id = ? AND status = 'pending'");
    $stmt->execute([$reason, $start, $end, $leaveId, $userId]);
    if ($stmt->rowCount() === 0) {
        // Either nothing changed or the leave isn't this user's pending request.
        $check = $conn->prepare("SELECT COUNT(*) FROM leaves WHERE id = ? AND user_id = ? AND status = 'pending'");
        $check->execute([$leaveId, $userId]);
        if (!$check->fetchColumn()) {
            return ['status' => 'error', 'message' => 'Leave not found or cannot be edited.'];
        }
    }
    return ['status' => 'success', 'message' => 'Leave request updated successfully'];
}
