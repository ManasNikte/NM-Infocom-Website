<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'sales');
header('Content-Type: application/json');

$user_id = $auth->id;

$db = new Database();
$conn = $db->getConnection();

// Get the latest 3 months (including current month)
$months = [];
for ($i = 2; $i >= 0; $i--) {
    $months[] = date('Y-m', strtotime("-{$i} month"));
}

// Prepare result structure
$labels = [];
$new = [];
$in_progress = [];
$won = [];
$lost = [];

foreach ($months as $ym) {
    $labels[] = date('M y', strtotime($ym . '-01'));
    // New
    $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'new'");
    $stmt->execute([$ym]);
    $new[] = (int)$stmt->fetchColumn();
    // In Progress
    $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE DATE_FORMAT(added_on, '%Y-%m') = ? AND (status = 'connected' OR status = 'not connected')");
    $stmt->execute([$ym]);
    $in_progress[] = (int)$stmt->fetchColumn();
    // Won
    $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'closed' AND response = 'positive'");
    $stmt->execute([$ym]);
    $won[] = (int)$stmt->fetchColumn();
    // Lost
    $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'closed' AND response = 'negative'");
    $stmt->execute([$ym]);
    $lost[] = (int)$stmt->fetchColumn();
}

echo json_encode([
    'success' => true,
    'months' => $labels,
    'datasets' => [
        [ 'label' => 'New', 'data' => $new, 'backgroundColor' => '#2979FF' ],
        [ 'label' => 'In Progress', 'data' => $in_progress, 'backgroundColor' => '#26C6DA' ],
        [ 'label' => 'Won', 'data' => $won, 'backgroundColor' => '#145a32' ],
        [ 'label' => 'Lost', 'data' => $lost, 'backgroundColor' => '#7b241c' ]
    ]
]); 