<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'hr');
header('Content-Type: application/json');

function getMonthRange($start, $end) {
    $startDate = new DateTime($start);
    $endDate = new DateTime($end);
    $months = [];
    while ($startDate <= $endDate) {
        $months[] = [
            'label' => $startDate->format('M Y'),
            'year' => $startDate->format('Y'),
            'month' => $startDate->format('m')
        ];
        $startDate->modify('+1 month');
    }
    return $months;
}

try {
    $db = new Database();
    $conn = $db->getConnection();
    // Get filter from GET params
    $start = isset($_GET['start']) ? $_GET['start'] : null;
    $end = isset($_GET['end']) ? $_GET['end'] : null;
    if ($start && $end) {
        $months = getMonthRange($start, $end);
    } else {
        // Default: latest 3 months
        $months = [];
        for ($i = 2; $i >= 0; $i--) {
            $dt = new DateTime("first day of -$i month");
            $months[] = [
                'label' => $dt->format('M Y'),
                'year' => $dt->format('Y'),
                'month' => $dt->format('m')
            ];
        }
    }
    $labels = [];
    $applicants = [];
    $shortlisted = [];
    $rejected = [];
    foreach ($months as $m) {
        $labels[] = $m['label'];
        // Applicants
        $stmt = $conn->prepare("SELECT COUNT(*) FROM job_applicants WHERE YEAR(date_applied) = ? AND MONTH(date_applied) = ?");
        $stmt->execute([$m['year'], $m['month']]);
        $applicants[] = (int)$stmt->fetchColumn();
        // Shortlisted
        $stmt = $conn->prepare("SELECT COUNT(*) FROM job_applicants WHERE status = 'Shortlisted' AND YEAR(date_applied) = ? AND MONTH(date_applied) = ?");
        $stmt->execute([$m['year'], $m['month']]);
        $shortlisted[] = (int)$stmt->fetchColumn();
        // Rejected
        $stmt = $conn->prepare("SELECT COUNT(*) FROM job_applicants WHERE status = 'Rejected' AND YEAR(date_applied) = ? AND MONTH(date_applied) = ?");
        $stmt->execute([$m['year'], $m['month']]);
        $rejected[] = (int)$stmt->fetchColumn();
    }
    echo json_encode([
        'labels' => $labels,
        'applicants' => $applicants,
        'shortlisted' => $shortlisted,
        'rejected' => $rejected
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => crm_public_error($e)]);
} 