<?php
// JSON feed for the admin dashboard: headline counts, chart series and recent activity.
require_once __DIR__ . '/../../config/auth.php';
crm_require_api('Admin');

header('Content-Type: application/json');

$months = max(1, min(24, (int) ($_GET['months'] ?? 6)));

try {
    $conn = (new Database())->getConnection();

    $scalar = function ($sql) use ($conn) {
        return (int) $conn->query($sql)->fetchColumn();
    };
    // [label => count] for a GROUP BY query returning (label, total).
    $grouped = function ($sql, array $params = []) use ($conn) {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $out = [];
        foreach ($stmt->fetchAll(PDO::FETCH_NUM) as [$label, $total]) {
            $out[$label === null || $label === '' ? 'unset' : $label] = (int) $total;
        }
        return $out;
    };
    // Zero-filled monthly series ending this month: ['labels' => [...], 'values' => [...]].
    $monthly = function ($table, $dateColumn, $where = '1=1') use ($conn, $months) {
        $start = date('Y-m-01', strtotime('-' . ($months - 1) . ' months'));
        $stmt = $conn->prepare("SELECT DATE_FORMAT($dateColumn, '%Y-%m') AS ym, COUNT(*) FROM $table
                                WHERE $dateColumn >= ? AND $where GROUP BY ym");
        $stmt->execute([$start]);
        $counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $series = ['labels' => [], 'values' => []];
        for ($i = $months - 1; $i >= 0; $i--) {
            $ts = strtotime(date('Y-m-01') . " -$i months");
            $series['labels'][] = date('M Y', $ts);
            $series['values'][] = (int) ($counts[date('Y-m', $ts)] ?? 0);
        }
        return $series;
    };

    $activeUser = "(status = 'active' OR status IS NULL)";

    $totals = [
        'employees' => $scalar("SELECT COUNT(*) FROM users WHERE role = 'Employee' AND $activeUser"),
        'managers' => $scalar("SELECT COUNT(*) FROM users WHERE role = 'Manager' AND $activeUser"),
        'leads' => $scalar('SELECT COUNT(*) FROM leads'),
        'open_leads' => $scalar("SELECT COUNT(*) FROM leads WHERE status <> 'closed'"),
        'vendors' => $scalar('SELECT COUNT(*) FROM vendor'),
        'product_enquiries' => $scalar('SELECT COALESCE(SUM(enquiries_count), 0) FROM products'),
        'contact_submissions' => $scalar('SELECT COUNT(*) FROM contact_submits'),
        'pending_contacts' => $scalar("SELECT COUNT(*) FROM contact_submits WHERE LOWER(status) = 'pending'"),
        'job_applicants' => $scalar('SELECT COUNT(*) FROM job_applicants'),
        'open_jobs' => $scalar('SELECT COUNT(*) FROM careers WHERE deadline >= CURDATE()'),
        'pending_leaves' => $scalar("SELECT COUNT(*) FROM leaves WHERE status = 'pending'"),
        'open_tasks' => $scalar("SELECT COUNT(*) FROM tasks WHERE status <> 'completed' OR status IS NULL"),
        'overdue_tasks' => $scalar("SELECT COUNT(*) FROM tasks WHERE status <> 'completed' AND due_date < CURDATE()"),
    ];

    $charts = [
        'staff_by_department' => $grouped("SELECT sub_role, COUNT(*) FROM users
                                           WHERE role <> 'Admin' AND $activeUser GROUP BY sub_role"),
        'leads_by_status' => $grouped('SELECT status, COUNT(*) FROM leads GROUP BY status'),
        'leads_by_response' => $grouped("SELECT response, COUNT(*) FROM leads WHERE status <> 'new' GROUP BY response"),
        'tasks_by_status' => $grouped('SELECT status, COUNT(*) FROM tasks GROUP BY status'),
        'tasks_by_department' => array_map(function ($row) {
            return ['department' => $row['department'], 'completed' => (int) $row['completed'],
                    'in_progress' => (int) $row['in_progress'], 'pending' => (int) $row['pending']];
        }, $conn->query("SELECT COALESCE(u.sub_role, 'unassigned') AS department,
                                                      SUM(t.status = 'completed') AS completed,
                                                      SUM(t.status = 'in progress') AS in_progress,
                                                      SUM(t.status = 'pending' OR t.status IS NULL) AS pending
                                               FROM tasks t LEFT JOIN users u ON u.id = t.assigned_to
                                               GROUP BY department ORDER BY department")->fetchAll(PDO::FETCH_ASSOC)),
        'leaves_by_status' => $grouped('SELECT status, COUNT(*) FROM leaves GROUP BY status'),
        'applicants_by_status' => $grouped('SELECT status, COUNT(*) FROM job_applicants GROUP BY status'),
        'leads_per_month' => $monthly('leads', 'added_on'),
        'applicants_per_month' => $monthly('job_applicants', 'date_applied'),
        'contacts_per_month' => $monthly('contact_submits', 'added_on'),
    ];

    $recent = [
        'leads' => $conn->query("SELECT l.lead_id, l.name, l.product, l.status, l.added_on, u.name AS added_by
                                 FROM leads l LEFT JOIN users u ON u.id = l.added_by
                                 ORDER BY l.added_on DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC),
        'pending_leaves' => $conn->query("SELECT lv.id, u.name, u.sub_role, lv.start_date, lv.end_date, lv.reason
                                          FROM leaves lv JOIN users u ON u.id = lv.user_id
                                          WHERE lv.status = 'pending' ORDER BY lv.start_date LIMIT 5")->fetchAll(PDO::FETCH_ASSOC),
        'top_products' => $conn->query("SELECT product_name, enquiries_count FROM products
                                        ORDER BY enquiries_count DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC),
    ];

    echo json_encode(['success' => true, 'totals' => $totals, 'charts' => $charts, 'recent' => $recent]);
} catch (Exception $e) {
    error_log('Admin dashboard data error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to load dashboard data']);
}
