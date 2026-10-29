<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
ini_set('display_errors', 0); // Disable displaying errors
ini_set('log_errors', 1); // Enable logging errors
ini_set('error_log', 'C:/xampp/php/logs/php-error.log'); // Set the path to your error log file

require_once '../../../../config/db_connection.php'; // Adjusted path

try {
    // Get newsletter subscribers count
    $subscribersQuery = "SELECT COUNT(*) as subscribers_count FROM newsletter_subscribers";
    $subscribersResult = $conn->query($subscribersQuery);
    
    // Get projects count
    $projectsQuery = "SELECT COUNT(*) as projects_count FROM projects";
    $projectsResult = $conn->query($projectsQuery);
    
    if (!$subscribersResult || !$projectsResult) {
        throw new Exception($conn->error);
    }
    
    $counts = [
        'newsletter_subscribers' => $subscribersResult->fetch_assoc()['subscribers_count'],
        'projects' => $projectsResult->fetch_assoc()['projects_count']
    ];
    
    header('Content-Type: application/json');
    echo json_encode($counts);

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>