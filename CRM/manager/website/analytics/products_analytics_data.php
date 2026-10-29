<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');

header('Content-Type: application/json');

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Today
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));

    // This month
    $monthStart = date('Y-m-01');
    $lastMonthStart = date('Y-m-01', strtotime('-1 month'));
    $lastMonthEnd = date('Y-m-t', strtotime('-1 month'));

    // This year
    $yearStart = date('Y-01-01');
    $lastYearStart = date('Y-01-01', strtotime('-1 year'));
    $lastYearEnd = date('Y-12-31', strtotime('-1 year'));

    // Helper function
    function getCount($conn, $start, $end) {
        $sql = "SELECT COUNT(*) FROM products WHERE date_added BETWEEN :start AND :end";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':start' => $start, ':end' => $end]);
        return (int)$stmt->fetchColumn();
    }

    // Products added today & yesterday
    $todayCount = getCount($conn, $today, $today);
    $yesterdayCount = getCount($conn, $yesterday, $yesterday);

    // Products added this month & last month
    $monthCount = getCount($conn, $monthStart, $today);
    $lastMonthCount = getCount($conn, $lastMonthStart, $lastMonthEnd);

    // Products added this year & last year
    $yearCount = getCount($conn, $yearStart, $today);
    $lastYearCount = getCount($conn, $lastYearStart, $lastYearEnd);

    // Discontinued products (product_status != 'active')
    $discontinuedCount = 0;
    $discontinuedSql = "SELECT COUNT(*) FROM products WHERE product_status != 'active'";
    $stmt = $conn->prepare($discontinuedSql);
    $stmt->execute();
    $discontinuedCount = (int)$stmt->fetchColumn();


    // Percentage helpers
    function percentChange($current, $previous) {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100);
    }

    echo json_encode([
        'success' => true,
        'today' => [
            'count' => $todayCount,
            'change' => percentChange($todayCount, $yesterdayCount)
        ],
        'month' => [
            'count' => $monthCount,
            'change' => percentChange($monthCount, $lastMonthCount)
        ],
        'year' => [
            'count' => $yearCount,
            'change' => percentChange($yearCount, $lastYearCount)
        ],
        'discontinued' => [
            'count' => $discontinuedCount,
            'change' => 0
        ]
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
finally {
    if (isset($conn)) {
        $conn = null;
    }
    
}
?>