<?php
// JSON feed for admin/departments.php: one department's staff and their workload.
require_once __DIR__ . '/../../config/auth.php';
crm_require_api('Admin');

header('Content-Type: application/json');

$departments = ['marketing', 'sales', 'purchase', 'website', 'hr'];
$dept = $_GET['dept'] ?? 'marketing';
if (!in_array($dept, $departments, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Unknown department']);
    exit;
}

try {
    $conn = (new Database())->getConnection();

    // One row per staff member with their task, lead, vendor and leave counts.
    $stmt = $conn->prepare("
        SELECT u.id, u.name, u.role, u.status, u.email, u.last_login,
               (SELECT COUNT(*) FROM tasks t WHERE t.assigned_to = u.id AND t.status = 'completed') AS tasks_completed,
               (SELECT COUNT(*) FROM tasks t WHERE t.assigned_to = u.id AND (t.status <> 'completed' OR t.status IS NULL)) AS tasks_open,
               (SELECT COUNT(*) FROM tasks t WHERE t.assigned_to = u.id AND t.status <> 'completed' AND t.due_date < CURDATE()) AS tasks_overdue,
               (SELECT COUNT(*) FROM leads l WHERE l.added_by = u.id) AS leads_added,
               (SELECT COUNT(*) FROM leads l WHERE l.assigned_to = u.id) AS leads_assigned,
               (SELECT COUNT(*) FROM leads l WHERE l.assigned_to = u.id AND l.status = 'closed' AND l.response = 'positive') AS leads_won,
               (SELECT COUNT(*) FROM vendor v WHERE v.added_by = u.id) AS vendors_added,
               (SELECT COUNT(*) FROM leaves lv WHERE lv.user_id = u.id AND lv.status = 'pending') AS leaves_pending
        FROM users u
        WHERE u.sub_role = ? AND u.role <> 'Admin'
        ORDER BY (u.status = 'active') DESC, u.role DESC, u.name");
    $stmt->execute([$dept]);
    $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countKeys = ['tasks_completed', 'tasks_open', 'tasks_overdue', 'leads_added', 'leads_assigned',
                  'leads_won', 'vendors_added', 'leaves_pending'];
    $totals = array_fill_keys($countKeys, 0) + ['active_staff' => 0, 'inactive_staff' => 0];
    foreach ($staff as &$member) {
        foreach ($countKeys as $key) {
            $member[$key] = (int) $member[$key];
            $totals[$key] += $member[$key];
        }
        $member['status'] = $member['status'] ?: 'active';
        $totals[$member['status'] === 'active' ? 'active_staff' : 'inactive_staff']++;
    }
    unset($member);

    $grouped = function ($sql) use ($conn, $dept) {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$dept]);
        $out = [];
        foreach ($stmt->fetchAll(PDO::FETCH_NUM) as [$label, $total]) {
            $out[$label === null || $label === '' ? 'unset' : $label] = (int) $total;
        }
        return $out;
    };

    $charts = [
        'tasks_by_status' => $grouped("SELECT t.status, COUNT(*) FROM tasks t JOIN users u ON u.id = t.assigned_to
                                       WHERE u.sub_role = ? GROUP BY t.status"),
        // Leads this department touched, either by creating them or being assigned them.
        'leads_by_status' => $grouped("SELECT l.status, COUNT(*) FROM leads l
                                       WHERE EXISTS (SELECT 1 FROM users u WHERE u.sub_role = ?
                                                     AND (u.id = l.added_by OR u.id = l.assigned_to))
                                       GROUP BY l.status"),
    ];

    echo json_encode(['success' => true, 'department' => $dept, 'departments' => $departments,
                      'totals' => $totals, 'charts' => $charts, 'staff' => $staff]);
} catch (Exception $e) {
    error_log('Admin department data error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to load department data']);
}
