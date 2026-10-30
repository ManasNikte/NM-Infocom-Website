<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'sales');
// Function to get months between two dates (YYYY-MM)
function getMonthsInRange($start, $end) {
    $start    = (new DateTime($start))->modify('first day of this month');
    $end      = (new DateTime($end))->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period   = new DatePeriod($start, $interval, $end);
    $months = [];
    foreach ($period as $dt) {
        $months[] = $dt->format('Y-m');
    }
    return $months;
}

$startDate = $_GET['start_date'] ?? date('Y-m-01', strtotime('-2 months'));
$endDate = $_GET['end_date'] ?? date('Y-m-t');

// If no start_date/end_date provided, force exactly 3 months (including current)
if (!isset($_GET['start_date']) && !isset($_GET['end_date'])) {
    $months = [];
    for ($i = 2; $i >= 0; $i--) {
        $months[] = date('Y-m', strtotime("-{$i} month"));
    }
    $startDate = $months[0] . '-01'; // first day of two months ago
    $endDate = date('Y-m-t'); // last day of current month
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $months = getMonthsInRange($startDate, $endDate);
    $labels = array_map(function($ym) { return date('M y', strtotime($ym . '-01')); }, $months);
    $new = [];
    $in_progress = [];
    $won = [];
    $lost = [];

    foreach ($months as $ym) {
        // New
        $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'new' AND DATE(added_on) >= ? AND DATE(added_on) <= ?");
        $stmt->execute([$ym, $startDate, $endDate]);
        $new[] = (int)$stmt->fetchColumn();
        // In Progress
        $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE DATE_FORMAT(added_on, '%Y-%m') = ? AND (status = 'connected' OR status = 'not connected') AND DATE(added_on) >= ? AND DATE(added_on) <= ?");
        $stmt->execute([$ym, $startDate, $endDate]);
        $in_progress[] = (int)$stmt->fetchColumn();
        // Won
        $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'closed' AND response = 'positive' AND DATE(added_on) >= ? AND DATE(added_on) <= ?");
        $stmt->execute([$ym, $startDate, $endDate]);
        $won[] = (int)$stmt->fetchColumn();
        // Lost
        $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'closed' AND response = 'negative' AND DATE(added_on) >= ? AND DATE(added_on) <= ?");
        $stmt->execute([$ym, $startDate, $endDate]);
        $lost[] = (int)$stmt->fetchColumn();
    }

    $result = [
        'labels' => $labels,
        'datasets' => [
            [ 'label' => 'New', 'data' => $new, 'backgroundColor' => '#2979FF' ],
            [ 'label' => 'In Progress', 'data' => $in_progress, 'backgroundColor' => '#26C6DA' ],
            [ 'label' => 'Won', 'data' => $won, 'backgroundColor' => '#145a32' ],
            [ 'label' => 'Lost', 'data' => $lost, 'backgroundColor' => '#7b241c' ]
        ]
    ];
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'error'=>crm_public_error($e)]);
    exit;
} 