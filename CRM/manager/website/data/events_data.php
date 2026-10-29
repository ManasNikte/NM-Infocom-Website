<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Log the request for debugging

try {
    // Include database configuration
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
    
    // Get and validate pagination parameters
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 6;
    
    // Ensure reasonable limits
    if ($perPage < 1) $perPage = 6;
    if ($perPage > 50) $perPage = 50;
    
    $offset = ($page - 1) * $perPage;
    
    // Get search and filter parameters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $eventType = isset($_GET['type']) ? trim($_GET['type']) : '';
    
    // Log the query parameters
    
    // Build base query for counting
    $countQuery = "SELECT COUNT(DISTINCT e.event_id) FROM events e";
    $whereClauses = [];
    $params = [];
    
    // Add search conditions
    if (!empty($search)) {
        $whereClauses[] = "(e.event_title LIKE :search OR e.event_description LIKE :search OR e.event_category LIKE :search)";
        $params[':search'] = "%$search%";
    }
    
    // Add event type filter
    if (!empty($eventType)) {
        $whereClauses[] = "e.event_mode = :event_type";
        $params[':event_type'] = $eventType;
    }
    
    // Add WHERE clause if we have conditions
    if (!empty($whereClauses)) {
        $countQuery .= " WHERE " . implode(" AND ", $whereClauses);
    }
    
    // Execute count query
    $countStmt = $pdo->prepare($countQuery);
    foreach ($params as $key => $value) {
        $countStmt->bindValue($key, $value);
    }
    
    if (!$countStmt->execute()) {
        $errorInfo = $countStmt->errorInfo();
        throw new Exception("Count query failed: " . ($errorInfo[2] ?? 'Unknown error'));
    }
    
    $totalEvents = (int)$countStmt->fetchColumn();
    $totalPages = $perPage > 0 ? ceil($totalEvents / $perPage) : 1;
    
    // Build main query
    $query = "
        SELECT 
            e.*,
            COALESCE(GROUP_CONCAT(DISTINCT es.speaker_name SEPARATOR ', '), 'No speakers') as speakers
        FROM 
            events e
        LEFT JOIN 
            event_speakers es ON e.event_id = es.event_id
    ";
    
    // Add WHERE clause if we have conditions
    if (!empty($whereClauses)) {
        $query .= " WHERE " . implode(" AND ", $whereClauses);
    }
    
    // Add GROUP BY, ORDER BY and LIMIT
    $query .= "
        GROUP BY 
            e.event_id
        ORDER BY 
            e.event_date DESC, e.event_time DESC
        LIMIT :offset, :perPage
    ";
    
    // Log the query for debugging
    
    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    
    if (!$stmt->execute()) {
        $errorInfo = $stmt->errorInfo();
        throw new Exception("Query execution failed: " . ($errorInfo[2] ?? 'Unknown error'));
    }
    
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Log the number of events found
    
    // Format the response
    $response = [
        'success' => true,
        'debug' => [
            'query' => $query,
            'params' => array_merge($params, [
                ':offset' => $offset,
                ':perPage' => $perPage
            ]),
            'total_events' => $totalEvents,
            'total_pages' => $totalPages,
            'current_page' => $page,
            'per_page' => $perPage,
            'event_count' => count($events)
        ],
        'events' => array_map(function($event) {
            return [
                'id' => $event['event_id'],
                'image' => $event['event_img'] ?? 'default-event.jpg',
                'title' => $event['event_title'],
                'author' => 'NM Infocom', // Default author
                'description' => $event['event_description'],
                'key_topics' => $event['event_category'],
                'date' => $event['event_date'],
                'time' => $event['event_time'],
                'type' => $event['event_mode'],
                'location' => $event['event_location'],
                'speakers' => $event['speakers'] ?? 'No speakers',
                'link' => $event['event_link'],
                // Upcoming until the end of the event day in India time, like the public Events page.
                'status' => (new DateTimeImmutable($event['event_date'] . ' 23:59:59', new DateTimeZone('Asia/Kolkata')))
                            >= new DateTimeImmutable('now', new DateTimeZone('Asia/Kolkata')) ? 'upcoming' : 'past',
                'date_added' => $event['created_at'],
                'last_modified' => $event['updated_at'] ?? $event['created_at']
            ];
        }, $events),
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_events' => $totalEvents
        ]
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    // Log the error (skip file logging to avoid permission issues)
    error_log('[' . date('Y-m-d H:i:s') . '] Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
    
    // Send error response
    http_response_code(500);
    header('Content-Type: application/json');
    
    $response = [
        'success' => false,
        'error' => [
            'message' => 'An error occurred while processing your request.',
            'debug' => [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'production') ? null : $e->getTraceAsString()
            ]
        ]
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
