<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once __DIR__ . '/../../../config/uploads.php';
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

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
        'message' => crm_public_error($e)
    ]);
    exit;
}

// Set default timezone
date_default_timezone_set('Asia/Kolkata');

// Function to handle file upload
function handleFileUpload($file, $eventId = null) {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    // Content-checked image, stored with a server-chosen extension (see CRM/config/uploads.php).
    return crm_store_upload($file, 'events', 'event_' . (int) $eventId . '_', CRM_IMAGE_TYPES, 2 * 1024 * 1024);
}

try {
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    
    // Get form data
    $eventId = $_POST['eventId'] ?? null;
    $eventTitle = trim($_POST['eventTitle'] ?? '');
    $eventCategory = trim($_POST['eventCategory'] ?? '');
    $eventDate = trim($_POST['eventDate'] ?? '');
    $eventTime = trim($_POST['eventTime'] ?? '');
    $eventDescription = trim($_POST['eventDescription'] ?? '');
    $eventMode = trim($_POST['eventMode'] ?? '');
    $eventLocation = trim($_POST['eventLocation'] ?? '');
    $speakers = trim($_POST['eventSpeakers'] ?? '');
    $eventLink = trim($_POST['eventLink'] ?? '');
    if ($eventLink !== '' && (!preg_match('#^https?://#i', $eventLink) || !filter_var($eventLink, FILTER_VALIDATE_URL))) {
        throw new Exception('The registration link must be a full address starting with https://');
    }
    
    // Validate required fields
    $required = [
        'Event Title' => $eventTitle,
        'Category' => $eventCategory,
        'Date' => $eventDate,
        'Time' => $eventTime,
        'Description' => $eventDescription,
        'Event Type' => $eventMode
    ];
    
    $missing = [];
    foreach ($required as $field => $value) {
        if (empty($value)) {
            $missing[] = $field;
        }
    }
    
    if (!empty($missing)) {
        throw new Exception('The following fields are required: ' . implode(', ', $missing));
    }
    
    // Process speakers (comma-separated to array)
    $speakersArray = [];
    if (!empty($speakers)) {
        $speakersArray = array_filter(array_map('trim', explode(',', $speakers)));
    }
    
    // Process file upload if a file was provided
    $imagePath = null;
    if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $imagePath = handleFileUpload($_FILES['eventImage'], $eventId);
        } catch (RuntimeException $e) {
            throw new Exception('Image: ' . $e->getMessage()); // tell the user instead of silently dropping the image
        }
    }
    
    // Prepare the SQL query
    // Fix field names and logic to match schema
    // 1. Use event_img and event_location
    // 2. Do not insert speakers into events table
    // 3. Only update event_img if a new image is uploaded
    // 4. Remove references to speakers in events table
    // 5. Ensure all required fields are handled
    if ($eventId) {
        $sql = "UPDATE events SET 
                event_title = :title, 
                event_description = :description, 
                event_category = :category,
                event_date = :event_date,
                event_time = :event_time,
                event_mode = :event_mode,
                event_location = :location,
                event_link = :link,"
                . ($imagePath ? " event_img = :image," : "")
                . " updated_at = NOW() 
                WHERE event_id = :id";
                
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        
        if ($imagePath) {
            $stmt->bindParam(':image', $imagePath);
        }
        
        $action = 'updated';
    } else {
        // Insert new event
        $sql = "INSERT INTO events (
                event_title, 
                event_description, 
                event_category,
                event_date,
                event_time,
                event_mode,
                event_location,
                event_link,"
                . ($imagePath ? " event_img," : "")
                . " created_at, 
                updated_at
            ) VALUES (
                :title, 
                :description, 
                :category,
                :event_date,
                :event_time,
                :event_mode,
                :location,
                :link,"
                . ($imagePath ? " :image," : "")
                . " NOW(), 
                NOW()
            )";
            
        $stmt = $pdo->prepare($sql);
        
        if ($imagePath) {
            $stmt->bindParam(':image', $imagePath);
        }
        
        $action = 'created';
    }
    
    // Bind common parameters
    $stmt->bindParam(':title', $eventTitle);
    $stmt->bindParam(':description', $eventDescription);
    $stmt->bindParam(':category', $eventCategory);
    $stmt->bindParam(':event_date', $eventDate);
    $stmt->bindParam(':event_time', $eventTime);
    $stmt->bindParam(':event_mode', $eventMode);
    $stmt->bindParam(':location', $eventLocation);
    $stmt->bindValue(':link', $eventLink !== '' ? $eventLink : null);
    $oldImage = null;
    if ($eventId && $imagePath) {
        $old = $pdo->prepare('SELECT event_img FROM events WHERE event_id = ?');
        $old->execute([$eventId]);
        $oldImage = $old->fetchColumn() ?: null;
    }
    
    // Begin transaction
    $pdo->beginTransaction();
    
    try {
        // Execute the event query
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception('Failed to save event to database');
        }
        
        // Get the ID of the newly inserted record if this was an insert
        $newEventId = $eventId ?: $pdo->lastInsertId();
        
        // Delete existing speakers for this event if updating
        if ($eventId) {
            $deleteStmt = $pdo->prepare("DELETE FROM event_speakers WHERE event_id = ?");
            $deleteStmt->execute([$eventId]);
        }
        
        // Insert new speakers
        if (!empty($speakersArray)) {
            $speakerStmt = $pdo->prepare("INSERT INTO event_speakers (event_id, speaker_name) VALUES (?, ?)");
            foreach ($speakersArray as $speaker) {
                if (!empty(trim($speaker))) {
                    $speakerStmt->execute([$newEventId, trim($speaker)]);
                }
            }
        }
        
        // Commit the transaction
        $pdo->commit();
        if ($oldImage && $oldImage !== $imagePath) {
            crm_delete_upload($oldImage, 'events'); // the replaced image
        }
        
        echo json_encode([
            'success' => true,
            'message' => "Event {$action} successfully!",
            'eventId' => $newEventId
        ]);
    } catch (Exception $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        if ($imagePath) {
            crm_delete_upload($imagePath, 'events');
        }
        throw $e;
    }
    
} catch (Exception $e) {
    // Log the error
    error_log('Error in save_event.php: ' . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => crm_public_error($e)
    ]);
}
?>
