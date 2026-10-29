<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

try {
    // Check if required parameters are provided
    if (!isset($_POST['id']) || !isset($_POST['response'])) {
        throw new Exception('Missing required parameters');
    }

    $submissionId = (int)$_POST['id'];
    $responseMessage = trim($_POST['response']);

    if (empty($responseMessage)) {
        throw new Exception('Response message cannot be empty');
    }

    // Create database connection
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db === null) {
        throw new Exception('Database connection failed');
    }

    // Prepare and execute the update query
    $query = "
        UPDATE contact_submits 
        SET 
            status = 'responded',
            responded_on = NOW(),
            response_message = :response
        WHERE id = :id
    ";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $submissionId, PDO::PARAM_INT);
    $stmt->bindParam(':response', $responseMessage, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Response submitted successfully';
    } else {
        throw new Exception('Failed to update submission');
    }
    
} catch (Exception $e) {
    http_response_code(400);
    $response['message'] = 'Error: ' . $e->getMessage();
    error_log('Error in update_submission_response.php: ' . $e->getMessage());
}

// Return JSON response
echo json_encode($response);
