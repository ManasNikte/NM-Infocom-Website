<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api('Employee', 'purchase');
// Function to get months between two dates
function getMonthsInRange($start, $end) {
    $start    = (new DateTime($start))->modify('first day of this month');
    $end      = (new DateTime($end))->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period   = new DatePeriod($start, $interval, $end);
    $months = [];
    foreach ($period as $dt) {
        $months[] = $dt->format('F Y');
    }
    return $months;
}

if (!isset($_COOKIE['token'])) {
    http_response_code(401);
    echo json_encode(['success'=>false, 'error'=>'Not authenticated']);
    exit;
}
$payload = (array) $auth;
$user_id = $payload['id'] ?? 0;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(['success'=>false, 'error'=>'Invalid user in token']);
    exit;
}

$startDate = $_GET['start_date'] ?? date('Y-m-01', strtotime('-2 months'));
$endDate = $_GET['end_date'] ?? date('Y-m-t');

try {
    $db = new Database();
    $conn = $db->getConnection();

    $months = getMonthsInRange($startDate, $endDate);
    $monthCounts = array_fill_keys($months, 0);

    $sql = "SELECT DATE_FORMAT(date_added, '%M %Y') as month_label, COUNT(*) as count
            FROM vendor
            WHERE added_by = :user_id
              AND date_added >= :start_date
              AND date_added <= :end_date
            GROUP BY month_label
            ORDER BY MIN(date_added)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $user_id, ':start_date' => $startDate, ':end_date' => $endDate]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $label = $row['month_label'];
        if (isset($monthCounts[$label])) {
            $monthCounts[$label] = (int)$row['count'];
        }
    }

    $vendors_data = [
        'months' => array_keys($monthCounts),
        'values' => array_values($monthCounts)
    ];
    header('Content-Type: application/json');
    echo json_encode($vendors_data);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'error'=>'DB error: '.$e->getMessage()]);
    exit;
} 