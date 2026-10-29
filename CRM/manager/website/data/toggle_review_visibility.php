<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once '../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Review ID is required']);
    exit;
}

try {
    // Get current visibility
    $stmt = $conn->prepare("SELECT visibility FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$row = $result->fetch_assoc()) {
        throw new Exception('Review not found');
    }
    $current = $row['visibility'];
    $new = ($current === 'public') ? 'private' : 'public';

    // Update visibility
    $update = $conn->prepare("UPDATE reviews SET visibility = ?, updatedAt = NOW() WHERE id = ?");
    $update->bind_param("si", $new, $id);
    $update->execute();

    echo json_encode(['success' => true, 'new_visibility' => $new]);
} catch (Exception $e) {
    error_log('Error toggling visibility: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>
