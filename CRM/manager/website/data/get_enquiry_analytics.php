<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');

try {
    $databasePath = __DIR__ . '/../../../config/database.php';
    if (!file_exists($databasePath)) {
        throw new Exception('Database configuration file not found at: ' . $databasePath);
    }
    require_once $databasePath;
    $database = new Database();
    $pdo = $database->getConnection();
    if (!$pdo) {
        throw new Exception('Failed to connect to database');
    }

    // Helper function for percentage change
    function percent_change($current, $previous) {
        if ($previous > 0) {
            return round((($current - $previous) / $previous) * 100);
        } elseif ($current > 0) {
            return 100;
        } else {
            return 0;
        }
    }

    // 1. Today's Enquiries & vs Yesterday
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE DATE(added_on) = CURDATE() AND added_by IS NULL");
    $stmt->execute();
    $today_count = (int)$stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE DATE(added_on) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND added_by IS NULL");
    $stmt->execute();
    $yesterday_count = (int)$stmt->fetchColumn();
    $today_percent = percent_change($today_count, $yesterday_count);

    // 2. This Week's Enquiries & vs Last Week
    // MySQL: WEEK() uses mode 0 (week starts on Sunday), so use YEARWEEK for unique week number
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE YEARWEEK(DATE(added_on), 1) = YEARWEEK(CURDATE(), 1) AND added_by IS NULL");
    $stmt->execute();
    $this_week_count = (int)$stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE YEARWEEK(DATE(added_on), 1) = YEARWEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1) AND added_by IS NULL");
    $stmt->execute();
    $last_week_count = (int)$stmt->fetchColumn();
    $week_percent = percent_change($this_week_count, $last_week_count);

    // 3. This Month's Enquiries & vs Last Month
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE YEAR(DATE(added_on)) = YEAR(CURDATE()) AND MONTH(DATE(added_on)) = MONTH(CURDATE()) AND added_by IS NULL");
    $stmt->execute();
    $this_month_count = (int)$stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE YEAR(DATE(added_on)) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(DATE(added_on)) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND added_by IS NULL");
    $stmt->execute();
    $last_month_count = (int)$stmt->fetchColumn();
    $month_percent = percent_change($this_month_count, $last_month_count);

    // 4. This Year's Enquiries & vs Last Year
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE YEAR(DATE(added_on)) = YEAR(CURDATE()) AND added_by IS NULL");
    $stmt->execute();
    $this_year_count = (int)$stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE YEAR(DATE(added_on)) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) AND added_by IS NULL");
    $stmt->execute();
    $last_year_count = (int)$stmt->fetchColumn();
    $year_percent = percent_change($this_year_count, $last_year_count);

    // Prepare response
    $response = [
        'success' => true,
        'data' => [
            'today' => [
                'count' => $today_count,
                'percent' => $today_percent
            ],
            'week' => [
                'count' => $this_week_count,
                'percent' => $week_percent
            ],
            'month' => [
                'count' => $this_month_count,
                'percent' => $month_percent
            ],
            'year' => [
                'count' => $this_year_count,
                'percent' => $year_percent
            ]
        ]
    ];
    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
