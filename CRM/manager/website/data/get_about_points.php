<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
// Enable error reporting for debugging


header('Content-Type: application/json');

try {
    // Create database connection
    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($_GET['about_id'])) {
        throw new Exception('About ID not provided');
    }

    $about_id = intval($_GET['about_id']);
    
    // Prepare and execute query
    $query = "SELECT about_pointsid, heading, description 
             FROM about_points 
             WHERE about_id = :about_id
             ORDER BY about_pointsid ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':about_id', $about_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $points = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $points,
        'total_points' => count($points),
        'about_id' => $about_id // Adding this for debugging
    ]);

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred',
        'debug' => $e->getMessage() // Remove this in production
    ]);
} catch (Exception $e) {
    error_log("General Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'debug' => $e->getTraceAsString() // Remove this in production
    ]);
}
