<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'hr');
header('Content-Type: application/json');

function getMonthLabels($n = 3) {
    $labels = [];
    for ($i = $n - 1; $i >= 0; $i--) {
        $labels[] = date('M Y', strtotime("-$i month"));
    }
    return $labels;
}

function getMonthYearPairs($n = 3) {
    $pairs = [];
    for ($i = $n - 1; $i >= 0; $i--) {
        $pairs[] = [
            'year' => date('Y', strtotime("-$i month")),
            'month' => date('m', strtotime("-$i month"))
        ];
    }
    return $pairs;
}

try {
    $db = new Database();
    $conn = $db->getConnection();
    $labels = getMonthLabels(3);
    $pairs = getMonthYearPairs(3);
    $applicants = [];
    $shortlisted = [];
    $rejected = [];
    foreach ($pairs as $pair) {
        // Applicants
        $stmt = $conn->prepare("SELECT COUNT(*) FROM job_applicants WHERE YEAR(date_applied) = ? AND MONTH(date_applied) = ?");
        $stmt->execute([$pair['year'], $pair['month']]);
        $applicants[] = (int)$stmt->fetchColumn();
        // Shortlisted
        $stmt = $conn->prepare("SELECT COUNT(*) FROM job_applicants WHERE status = 'Shortlisted' AND YEAR(date_applied) = ? AND MONTH(date_applied) = ?");
        $stmt->execute([$pair['year'], $pair['month']]);
        $shortlisted[] = (int)$stmt->fetchColumn();
        // Rejected
        $stmt = $conn->prepare("SELECT COUNT(*) FROM job_applicants WHERE status = 'Rejected' AND YEAR(date_applied) = ? AND MONTH(date_applied) = ?");
        $stmt->execute([$pair['year'], $pair['month']]);
        $rejected[] = (int)$stmt->fetchColumn();
    }
    echo json_encode([
        'labels' => $labels,
        'applicants' => $applicants,
        'shortlisted' => $shortlisted,
        'rejected' => $rejected
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} 