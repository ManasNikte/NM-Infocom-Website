<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api('Employee', 'marketing');

header('Content-Type: application/json');

try {
    $db = new Database();
    $pdo = $db->getConnection();

    // Leads added today
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE added_by = ? AND DATE(added_on) = CURDATE()");
    $stmt->execute([$auth->id]);
    $leads_today = (int)$stmt->fetchColumn();

    // Leads added this month
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE added_by = ? AND YEAR(added_on) = YEAR(CURDATE()) AND MONTH(added_on) = MONTH(CURDATE())");
    $stmt->execute([$auth->id]);
    $leads_this_month = (int)$stmt->fetchColumn();

    // Positive leads this month
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE added_by = ? AND YEAR(added_on) = YEAR(CURDATE()) AND MONTH(added_on) = MONTH(CURDATE()) AND LOWER(response) = 'positive'");
    $stmt->execute([$auth->id]);
    $positive_this_month = (int)$stmt->fetchColumn();

    // Negative leads this month
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE added_by = ? AND YEAR(added_on) = YEAR(CURDATE()) AND MONTH(added_on) = MONTH(CURDATE()) AND LOWER(response) = 'negative'");
    $stmt->execute([$auth->id]);
    $negative_this_month = (int)$stmt->fetchColumn();

    echo json_encode([
        'success' => true,
        'leads_today' => $leads_today,
        'leads_this_month' => $leads_this_month,
        'positive_this_month' => $positive_this_month,
        'negative_this_month' => $negative_this_month
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => crm_public_error($e)]);
} 