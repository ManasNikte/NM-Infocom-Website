<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api('Employee', 'purchase');
function getLastThreeMonthsRange() {
    $months = [];
    $start = (new DateTime('first day of -2 months'))->format('Y-m-01');
    $end = (new DateTime('last day of this month'))->format('Y-m-d');
    $period = new DatePeriod(
        new DateTime($start),
        new DateInterval('P1M'),
        (new DateTime($end))->modify('+1 day')
    );
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

$months = getLastThreeMonthsRange();
$monthCounts = array_fill_keys($months, 0);
$startDate = (new DateTime('first day of -2 months'))->format('Y-m-01');
$endDate = (new DateTime('last day of this month'))->format('Y-m-d');

try {
    $db = new Database();
    $conn = $db->getConnection();
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
    if(isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
        header('Content-Type: application/json');
        echo json_encode($vendors_data);
        exit;
    }
    return $vendors_data;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'error'=>crm_public_error($e)]);
    exit;
}