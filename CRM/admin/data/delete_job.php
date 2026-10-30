<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');
header('Content-Type: application/json');

// Enable error reporting for debugging

function deleteJob($jobId) {
    $database = new Database();
    $conn = $database->getConnection();
    
    try {
        // Get the category before deleting
        $getCategoryQuery = "SELECT category FROM careers WHERE id = :id";
        $getStmt = $conn->prepare($getCategoryQuery);
        $getStmt->bindParam(':id', $jobId);
        $getStmt->execute();
        $job = $getStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$job) {
            throw new Exception("Job not found");
        }
        
        $category = $job['category'];
        
        // Delete the job
        $deleteQuery = "DELETE FROM careers WHERE id = :id";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bindParam(':id', $jobId);
        
        if ($deleteStmt->execute()) {
            // Update the count in career_categories table
            $updateCountQuery = "UPDATE career_categories SET count = count - 1 WHERE category_id = :category";
            $updateStmt = $conn->prepare($updateCountQuery);
            $updateStmt->bindParam(':category', $category);
            $updateStmt->execute();
            
            return [
                'success' => true,
                'message' => 'Job deleted successfully'
            ];
        } else {
            throw new Exception("Failed to delete job");
        }
        
    } catch (PDOException $e) {
        throw new Exception("Database error: " . crm_public_error($e));
    }
}

try {
    // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    
    // Get job ID
    $jobId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if ($jobId <= 0) {
        throw new Exception('Invalid job ID');
    }
    
    // Delete the job
    $result = deleteJob($jobId);
    
    echo json_encode($result);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => crm_public_error($e)
    ]);
}
?> 