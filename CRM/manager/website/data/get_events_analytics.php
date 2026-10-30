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
    
    // Create database connection
    $database = new Database();
    $pdo = $database->getConnection();
    
    if (!$pdo) {
        throw new Exception('Failed to connect to database');
    }
    
    // Get current date and first day of current month
    $currentDate = (new DateTimeImmutable('now', new DateTimeZone('Asia/Kolkata')))->format('Y-m-d'); // same clock as the public Events page
    $firstDayOfMonth = date('Y-m-01');
    $firstDayOfLastMonth = date('Y-m-01', strtotime('first day of last month'));
    $lastDayOfLastMonth = date('Y-m-t', strtotime('first day of last month'));
    
    // 1. Total Events Count
    $query = "SELECT COUNT(*) as total_events FROM events";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $totalEvents = $stmt->fetch(PDO::FETCH_ASSOC)['total_events'];
    
    // 2. Upcoming Events (events with date >= today)
    $query = "SELECT COUNT(*) as upcoming_events FROM events WHERE event_date >= :current_date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':current_date', $currentDate);
    $stmt->execute();
    $upcomingEvents = $stmt->fetch(PDO::FETCH_ASSOC)['upcoming_events'];
    
    // 3. Past Events (events with date < today)
    $query = "SELECT COUNT(*) as past_events FROM events WHERE event_date < :current_date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':current_date', $currentDate);
    $stmt->execute();
    $pastEvents = $stmt->fetch(PDO::FETCH_ASSOC)['past_events'];
    
    // 4. Events added this month and last month for percentage calculation
    $query = "SELECT COUNT(*) as count FROM events 
              WHERE created_at BETWEEN :first_day AND LAST_DAY(CURDATE())";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':first_day', $firstDayOfMonth);
    $stmt->execute();
    $eventsThisMonth = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    $query = "SELECT COUNT(*) as count FROM events 
              WHERE created_at BETWEEN :first_day AND :last_day";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':first_day', $firstDayOfLastMonth);
    $stmt->bindParam(':last_day', $lastDayOfLastMonth);
    $stmt->execute();
    $eventsLastMonth = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Calculate percentage change
    $percentageChange = 0;
    if ($eventsLastMonth > 0) {
        $percentageChange = round((($eventsThisMonth - $eventsLastMonth) / $eventsLastMonth) * 100);
    } elseif ($eventsThisMonth > 0) {
        $percentageChange = 100; // If no events last month but some this month
    }
    
    // Prepare response
    $response = [
        'success' => true,
        'data' => [
            'total_events' => (int)$totalEvents,
            'upcoming_events' => (int)$upcomingEvents,
            'past_events' => (int)$pastEvents,
            'events_this_month' => (int)$eventsThisMonth,
            'percentage_change' => $percentageChange
        ]
    ];
    
    echo json_encode($response);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => crm_public_error($e)
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => crm_public_error($e)
    ]);
}
