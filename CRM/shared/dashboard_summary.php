<?php
// Headline numbers for the manager and employee dashboards (layout/dashboard_hero.php).
//   Manager  -> their department's employees, plus the manager's own tasks
//   Employee -> their own work
require_once __DIR__ . '/../config/auth.php';
$auth = crm_require_api(['Manager', 'Employee']);
header('Content-Type: application/json');

try {
    $conn = (new Database())->getConnection();
    $scalar = function ($sql, array $params = []) use ($conn) {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    };
    $dept = $auth->sub_role;
    $isManager = strtolower($auth->role) === 'manager';

    // Whose tasks / leaves / leads the numbers cover.
    if ($isManager) {
        $people = "SELECT id FROM users WHERE role = 'Employee' AND sub_role = ? AND (status = 'active' OR status IS NULL)";
        $peopleArgs = [$dept];
    } else {
        $people = 'SELECT ?';
        $peopleArgs = [$auth->id];
    }

    $tasks = function ($where) use ($scalar, $people, $peopleArgs) {
        return $scalar("SELECT COUNT(*) FROM tasks WHERE assigned_to IN ($people) AND $where", $peopleArgs);
    };
    $totals = [
        'tasks_pending' => $tasks("LOWER(status) = 'pending'"),
        'tasks_in_progress' => $tasks("LOWER(status) = 'in progress'"),
        'tasks_completed' => $tasks("LOWER(status) = 'completed'"),
        'tasks_overdue' => $tasks("LOWER(status) <> 'completed' AND due_date < CURDATE()"),
        'tasks_due_week' => $tasks("LOWER(status) <> 'completed' AND due_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY"),
        'leaves_pending' => $scalar("SELECT COUNT(*) FROM leaves WHERE status = 'pending' AND user_id IN ($people)", $peopleArgs),
        'my_leaves_pending' => $scalar("SELECT COUNT(*) FROM leaves WHERE status = 'pending' AND user_id = ?", [$auth->id]),
    ];
    $done = $totals['tasks_completed'];
    $all = $done + $totals['tasks_pending'] + $totals['tasks_in_progress'];
    $totals['completion_rate'] = $all ? (int) round($done * 100 / $all) : 0;

    if ($isManager) {
        $totals['team_size'] = $scalar("SELECT COUNT(*) FROM ($people) p", $peopleArgs);
        $totals['my_tasks_open'] = $scalar("SELECT COUNT(*) FROM tasks WHERE assigned_to = ? AND LOWER(status) <> 'completed'", [$auth->id]);
    }

    // Department-specific numbers. Marketing adds leads, sales works the ones assigned to them.
    if ($dept === 'marketing' || $dept === 'sales') {
        $column = $dept === 'marketing' ? 'added_by' : 'assigned_to';
        $owners = $isManager ? "SELECT id FROM users WHERE sub_role = ?" : 'SELECT ?';
        $ownerArgs = $isManager ? [$dept] : [$auth->id];
        $totals['leads_total'] = $scalar("SELECT COUNT(*) FROM leads WHERE $column IN ($owners)", $ownerArgs);
        $totals['leads_open'] = $scalar("SELECT COUNT(*) FROM leads WHERE $column IN ($owners) AND status <> 'closed'", $ownerArgs);
        $totals['leads_won'] = $scalar("SELECT COUNT(*) FROM leads WHERE $column IN ($owners) AND status = 'closed' AND response = 'positive'", $ownerArgs);
        $totals['leads_month'] = $scalar("SELECT COUNT(*) FROM leads WHERE $column IN ($owners) AND added_on >= DATE_FORMAT(CURDATE(), '%Y-%m-01')", $ownerArgs);
    } elseif ($dept === 'purchase') {
        $totals['vendors'] = $isManager
            ? $scalar('SELECT COUNT(*) FROM vendor')
            : $scalar('SELECT COUNT(*) FROM vendor WHERE added_by = ?', [$auth->id]);
        $totals['vendors_month'] = $isManager
            ? $scalar("SELECT COUNT(*) FROM vendor WHERE date_added >= DATE_FORMAT(CURDATE(), '%Y-%m-01')")
            : $scalar("SELECT COUNT(*) FROM vendor WHERE added_by = ? AND date_added >= DATE_FORMAT(CURDATE(), '%Y-%m-01')", [$auth->id]);
    } elseif ($dept === 'hr') {
        $totals['staff_active'] = $scalar("SELECT COUNT(*) FROM users WHERE role <> 'Admin' AND (status = 'active' OR status IS NULL)");
        $totals['open_jobs'] = $scalar('SELECT COUNT(*) FROM careers WHERE deadline >= CURDATE()');
        $totals['applicants'] = $scalar('SELECT COUNT(*) FROM job_applicants');
        $totals['applicants_new'] = $scalar("SELECT COUNT(*) FROM job_applicants WHERE status IS NULL OR status = '' OR LOWER(status) IN ('pending', 'new', 'applied')");
        $totals['company_leaves_pending'] = $scalar("SELECT COUNT(*) FROM leaves WHERE status = 'pending'");
    } elseif ($dept === 'website') {
        $totals['contacts_pending'] = $scalar("SELECT COUNT(*) FROM contact_submits WHERE LOWER(status) = 'pending'");
        $totals['contacts_total'] = $scalar('SELECT COUNT(*) FROM contact_submits');
        $totals['reviews_private'] = $scalar("SELECT COUNT(*) FROM reviews WHERE reviewer_status = 'private'");
        $totals['subscribers'] = $scalar("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'subscribed'");
        $totals['enquiries'] = $scalar('SELECT COALESCE(SUM(enquiries_count), 0) FROM products');
        $totals['products'] = $scalar('SELECT COUNT(*) FROM products');
    }

    echo json_encode(['success' => true, 'role' => $auth->role, 'department' => $dept, 'totals' => $totals]);
} catch (Exception $e) {
    error_log('dashboard_summary: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not load the dashboard summary']);
}
