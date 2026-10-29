<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');
header('Content-Type: application/json');

function getMonthRange($offset = 0) {
    // $offset = 0 for current month, -1 for previous month
    $firstDay = date('Y-m-01', strtotime("$offset month"));
    $lastDay = date('Y-m-t', strtotime("$offset month"));
    return [$firstDay, $lastDay];
}

function getCount($conn, $query, $params = []) {
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Date ranges
    list($currStart, $currEnd) = getMonthRange(0);
    list($prevStart, $prevEnd) = getMonthRange(-1);

    // Jobs Added
    $jobs_curr = getCount($conn, "SELECT COUNT(*) FROM careers WHERE date_posted BETWEEN ? AND ?", [$currStart, $currEnd]);
    $jobs_prev = getCount($conn, "SELECT COUNT(*) FROM careers WHERE date_posted BETWEEN ? AND ?", [$prevStart, $prevEnd]);

    // Applicants
    $applicants_curr = getCount($conn, "SELECT COUNT(*) FROM job_applicants WHERE date_applied BETWEEN ? AND ?", [$currStart, $currEnd]);
    $applicants_prev = getCount($conn, "SELECT COUNT(*) FROM job_applicants WHERE date_applied BETWEEN ? AND ?", [$prevStart, $prevEnd]);

    // Shortlisted
    $shortlisted_curr = getCount($conn, "SELECT COUNT(*) FROM job_applicants WHERE status = 'Shortlisted' AND date_applied BETWEEN ? AND ?", [$currStart, $currEnd]);
    $shortlisted_prev = getCount($conn, "SELECT COUNT(*) FROM job_applicants WHERE status = 'Shortlisted' AND date_applied BETWEEN ? AND ?", [$prevStart, $prevEnd]);

    // Rejected
    $rejected_curr = getCount($conn, "SELECT COUNT(*) FROM job_applicants WHERE status = 'Rejected' AND date_applied BETWEEN ? AND ?", [$currStart, $currEnd]);
    $rejected_prev = getCount($conn, "SELECT COUNT(*) FROM job_applicants WHERE status = 'Rejected' AND date_applied BETWEEN ? AND ?", [$prevStart, $prevEnd]);

    // Helper for % change
    function percentChange($current, $previous) {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return round((($current - $previous) / $previous) * 100, 2);
    }

    $result = [
        'jobs_added' => [
            'count' => $jobs_curr,
            'percent_change' => percentChange($jobs_curr, $jobs_prev)
        ],
        'applicants' => [
            'count' => $applicants_curr,
            'percent_change' => percentChange($applicants_curr, $applicants_prev)
        ],
        'shortlisted' => [
            'count' => $shortlisted_curr,
            'percent_change' => percentChange($shortlisted_curr, $shortlisted_prev)
        ],
        'rejected' => [
            'count' => $rejected_curr,
            'percent_change' => percentChange($rejected_curr, $rejected_prev)
        ]
    ];

    echo json_encode(['success' => true, 'data' => $result]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} 