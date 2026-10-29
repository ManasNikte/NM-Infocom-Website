<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');
// Function to get last 3 months
function getLastThreeMonths() {
    $months = [];
    for ($i = 2; $i >= 0; $i--) {
        $months[] = date('F', strtotime("-{$i} month"));
    }
    return $months;
}

// Get user ID from JWT (simple base64 decode, no signature check)
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

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Get the last three months as YYYY-MM keys and display labels
    $months = [];
    $monthLabels = [];
    for ($i = 2; $i >= 0; $i--) {
        $key = date('Y-m', strtotime("-{$i} month"));
        $months[] = $key;
        $monthLabels[$key] = date('F Y', strtotime("-{$i} month"));
    }
    $monthCounts = array_fill_keys($months, 0);

    $startDate = date('Y-m-01', strtotime('-2 months'));
    $endDate = date('Y-m-t');

    $sql = "SELECT DATE_FORMAT(date_added, '%Y-%m') as ym, COUNT(*) as count
        FROM vendor
        WHERE date_added >= :start_date
          AND date_added <= :end_date
        GROUP BY ym
        ORDER BY ym";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ym = $row['ym'];
        if (isset($monthCounts[$ym])) {
            $monthCounts[$ym] = (int)$row['count'];
        }
    }

    // Prepare data for chart: labels and values
    $vendors_data = [
        'months' => array_values($monthLabels),
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
    echo json_encode(['success'=>false, 'error'=>'DB error: '.$e->getMessage()]);
    exit;
}