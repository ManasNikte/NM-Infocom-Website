<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once '../../../../config/db_connection.php'; // Adjust the path to the actual configuration file

// Ensure $conn is defined
if (!isset($conn)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

parse_str(file_get_contents("php://input"), $_DELETE);
$reviewId = isset($_DELETE['id']) ? (int)$_DELETE['id'] : null;

if (!$reviewId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Review ID is required']);
    exit;
}

try {
    $stmt = $conn->prepare('DELETE FROM reviews WHERE id = ?');
    $stmt->bind_param('i', $reviewId);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception('Review not found');
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log('Error deleting review: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
