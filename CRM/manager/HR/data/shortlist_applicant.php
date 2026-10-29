<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'hr');
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}
$id = intval($_POST['id']);
try {
    $db = new Database();
    $pdo = $db->getConnection();
    $stmt = $pdo->prepare('UPDATE job_applicants SET status = ? WHERE id = ?');
    $stmt->execute(['Shortlisted', $id]);
    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'message' => 'No applicant updated.']);
    } else {
        echo json_encode(['success' => true]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 