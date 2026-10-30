<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');


// Get database connection
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
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed'
    ]);
    exit;
}

try {
    // Check if event ID is provided
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('Invalid event ID');
    }
    
    $eventId = (int)$_GET['id'];
    
    // Prepare and execute the query
    // Get the event details
    $stmt = $pdo->prepare("
        SELECT 
            event_id,
            event_title,
            event_name,
            event_description,
            event_category,
            DATE(event_date) as event_date,
            event_time,
            event_mode,
            event_location,
            event_img,
            event_link,
            created_at,
            updated_at
        FROM events 
        WHERE event_id = :event_id
    ");
    
    $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$event) {
        throw new Exception('Event not found');
    }
    
    // Get speakers for this event
    $speakerStmt = $pdo->prepare("
        SELECT speaker_name 
        FROM event_speakers 
        WHERE event_id = :event_id
        ORDER BY speaker_id
    ");
    $speakerStmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
    $speakerStmt->execute();
    
    $speakers = $speakerStmt->fetchAll(PDO::FETCH_COLUMN);
    $event['speakers'] = array_values(array_filter($speakers)); // Remove any empty values
    $event['eventSpeakers'] = implode(', ', $event['speakers']); // For form field
    
    // Return the event data
    echo json_encode([
        'success' => true,
        'event' => $event
    ]);
    
} catch (Exception $e) {
    // Log the error
    error_log('Error in get_event.php: ' . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => crm_public_error($e)
    ]);
}
?>
