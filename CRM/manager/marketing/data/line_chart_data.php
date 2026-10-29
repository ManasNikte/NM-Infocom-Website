<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'marketing');
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

    $startDate = date('Y-m-01 00:00:00', strtotime('-2 months'));
    $endDate = date('Y-m-t 23:59:59');

    $sql = "SELECT DATE_FORMAT(l.added_on, '%Y-%m') as ym, COUNT(*) as count
        FROM leads l
        JOIN users u ON l.added_by = u.id
        WHERE u.sub_role = 'marketing'
          AND l.added_on >= :start_date
          AND l.added_on <= :end_date
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
    $leads_data = [
        'months' => array_values($monthLabels),
        'values' => array_values($monthCounts)
    ];
    if(isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
        header('Content-Type: application/json');
        echo json_encode($leads_data);
        exit;
    }
    return $leads_data;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'error'=>'DB error: '.$e->getMessage()]);
    exit;
}