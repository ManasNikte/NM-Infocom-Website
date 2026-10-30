<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once __DIR__ . '/../../../config/uploads.php';
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
    // Get the raw POST data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    // Check if event ID is provided
    if (!isset($data['id']) || !is_numeric($data['id'])) {
        throw new Exception('Invalid event ID');
    }
    
    $eventId = (int)$data['id'];
    
    // First, get the event to check if it exists and get the image path
    $stmt = $pdo->prepare("SELECT event_img FROM events WHERE event_id = :event_id");
    $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$event) {
        throw new Exception('Event not found');
    }
    
    // Start transaction
    $pdo->beginTransaction();
    
    try {
        // Delete related speakers first
        $speakerStmt = $pdo->prepare("DELETE FROM event_speakers WHERE event_id = :event_id");
        $speakerStmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $speakerStmt->execute();
        
        // Delete the event
        $stmt = $pdo->prepare("DELETE FROM events WHERE event_id = :event_id");
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $result = $stmt->execute();
        
        if ($result) {
            // If the event had an image, delete it from the server
            if (!empty($event['event_img'])) {
                crm_delete_upload($event['event_img'], 'events');
            }
            
            // Commit the transaction
            $pdo->commit();
            
            echo json_encode([
                'success' => true,
                'message' => 'Event deleted successfully!'
            ]);
        } else {
            throw new Exception('No event was deleted. The event may have already been deleted.');
        }
        
    } catch (Exception $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        throw $e;
    }
    
} catch (Exception $e) {
    // Log the error
    error_log('Error in delete_event.php: ' . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => crm_public_error($e)
    ]);
}
?>
