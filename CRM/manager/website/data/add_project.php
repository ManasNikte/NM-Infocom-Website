<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once '../../../../config/db_connection.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['title'], $data['text'], $data['date'], $data['status'], $data['colorful'], $data['visibility'])) {
        throw new Exception('Missing required fields');
    }

    $query = "INSERT INTO projects (title, text, date, status, file, colorful, visibility, weburl, createdAt, updatedAt) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", 
        $data['title'],
        $data['text'],
        $data['date'],
        $data['status'],
        $data['file'],
        $data['colorful'],
        $data['visibility'],
        $data['weburl']
    );

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Project added successfully',
        'id' => $conn->insert_id
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$stmt->close();
$conn->close();
?>