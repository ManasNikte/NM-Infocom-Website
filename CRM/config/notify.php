<?php
// CRM email notifications (tasks and leaves). All best-effort: see nm_notify_users().
require_once __DIR__ . '/../../config/mailer.php';

function crm_user_name(PDO $conn, $id) {
    $stmt = $conn->prepare('SELECT name FROM users WHERE id = ?');
    $stmt->execute([(int) $id]);
    return (string) ($stmt->fetchColumn() ?: 'Your manager');
}

function crm_fmt_date($ymd) {
    $d = DateTime::createFromFormat('Y-m-d', substr((string) $ymd, 0, 10));
    return $d ? $d->format('j M Y') : (string) $ymd;
}

/** Tell an employee a task was assigned to them. */
function crm_notify_task_assigned(PDO $conn, $assigneeId, $assignerId, $task, $dueDate) {
    $e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
    $by = crm_user_name($conn, $assignerId);
    $due = crm_fmt_date($dueDate);
    $html = '<p><b>' . $e($by) . '</b> assigned you a new task:</p>'
        . '<blockquote style="margin:12px 0;padding:12px 16px;background:#f5f7fb;border-left:4px solid #2563eb;border-radius:6px">' . nl2br($e($task)) . '</blockquote>'
        . '<p>Due date: <b>' . $e($due) . '</b></p>';
    $text = "$by assigned you a new task:\n\n$task\n\nDue date: $due\n";
    return nm_notify_users($conn, [$assigneeId], 'New task: ' . mb_strimwidth($task, 0, 60, '…'), 'You have a new task', $html, $text);
}

/** Tell the requester their leave was approved or rejected. */
function crm_notify_leave_decided(PDO $conn, $leaveId) {
    $stmt = $conn->prepare('SELECT user_id, start_date, end_date, reason, status, action_by FROM leaves WHERE id = ?');
    $stmt->execute([(int) $leaveId]);
    if (!$leave = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return 0;
    }
    $e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
    $approved = $leave['status'] === 'approved';
    $range = crm_fmt_date($leave['start_date']) . ' – ' . crm_fmt_date($leave['end_date']);
    $by = $leave['action_by'] ? crm_user_name($conn, $leave['action_by']) : 'The administrator';
    $html = '<p>Your leave request for <b>' . $e($range) . '</b> was '
        . '<b style="color:' . ($approved ? '#059669' : '#dc2626') . '">' . ($approved ? 'approved' : 'rejected') . '</b> by ' . $e($by) . '.</p>'
        . '<p style="color:#64748b">Reason given: ' . $e($leave['reason']) . '</p>';
    $text = "Your leave request for $range was " . $leave['status'] . " by $by.\nReason given: " . $leave['reason'] . "\n";
    return nm_notify_users($conn, [$leave['user_id']], 'Leave ' . $leave['status'] . ': ' . $range,
                           $approved ? 'Leave approved' : 'Leave not approved', $html, $text);
}

/** Tell the approvers about a new leave request: department managers for employees, admins otherwise. */
function crm_notify_leave_requested(PDO $conn, $userId, $startDate, $endDate, $reason) {
    $stmt = $conn->prepare('SELECT name, role, sub_role FROM users WHERE id = ?');
    $stmt->execute([(int) $userId]);
    if (!$who = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return 0;
    }
    if ($who['role'] === 'Employee') {
        $q = $conn->prepare("SELECT id FROM users WHERE role = 'Manager' AND sub_role = ?");
        $q->execute([$who['sub_role']]);
    } else {
        $q = $conn->query("SELECT id FROM users WHERE role = 'Admin'");
    }
    $approvers = array_diff($q->fetchAll(PDO::FETCH_COLUMN), [(int) $userId]);
    $e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
    $range = crm_fmt_date($startDate) . ' – ' . crm_fmt_date($endDate);
    $html = '<p><b>' . $e($who['name']) . '</b> requested leave for <b>' . $e($range) . '</b>.</p>'
        . '<p style="color:#64748b">Reason: ' . $e($reason) . '</p><p>Review it in the Leave Portal.</p>';
    $text = $who['name'] . " requested leave for $range.\nReason: $reason\n\nReview it in the Leave Portal.\n";
    return nm_notify_users($conn, $approvers, 'Leave request from ' . $who['name'], 'New leave request', $html, $text);
}
