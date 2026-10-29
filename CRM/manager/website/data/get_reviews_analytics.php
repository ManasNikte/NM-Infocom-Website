<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Include database configuration
    $databasePath = __DIR__ . '/../../../config/database.php';
    if (!file_exists($databasePath)) {
        throw new Exception('Database configuration file not found at: ' . $databasePath);
    }
    require_once $databasePath;
    
    // Initialize database connection
    $database = new Database();
    $pdo = $database->getConnection();
    if (!$pdo) {
        throw new Exception('Failed to connect to database');
    }
    
    // Get today's date in YYYY-MM-DD format
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    
    // 1. Get reviews added today
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM reviews WHERE DATE(created_at) = ?");
    $stmt->execute([$today]);
    $todayCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // 2. Get reviews added yesterday for percentage calculation
    $stmt->execute([$yesterday]);
    $yesterdayCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Calculate percentage change
    $percentageChange = 0;
    if ($yesterdayCount > 0) {
        $percentageChange = round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100);
    } elseif ($todayCount > 0) {
        $percentageChange = 100; // If no reviews yesterday but some today, show 100% increase
    }
    
    // 3. Get total reviews count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM reviews");
    $totalCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // 4. Get public reviews count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM reviews WHERE reviewer_status = 'public'");
    $publicCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // 5. Get private reviews count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM reviews WHERE reviewer_status = 'private'");
    $privateCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Prepare the response with all the data we've collected
    $response = [
        'success' => true,
        'data' => [
            'today' => [
                'count' => (int)$todayCount,
                'percent' => $percentageChange
            ],
            'total' => (int)$totalCount,
            'public' => (int)$publicCount,
            'private' => (int)$privateCount,
            'week' => [
                'count' => (int)$todayCount, // Placeholder - update with actual weekly data if needed
                'percent' => 0
            ],
            'month' => [
                'count' => (int)($publicCount + $privateCount), // Example: total visible reviews
                'percent' => 0
            ],
            'year' => [
                'count' => (int)$totalCount,
                'percent' => 0
            ]
        ]
    ];
    
    // Send the single, well-formed JSON response
    echo json_encode($response);
    exit;

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
