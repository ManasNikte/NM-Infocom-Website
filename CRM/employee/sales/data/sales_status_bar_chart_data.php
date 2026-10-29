<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api('Employee', 'sales');
header('Content-Type: application/json');

$user_id = $auth->id;

$db = new Database();
$conn = $db->getConnection();

// Get the latest 3 months (YYYY-MM format)
$sql_months = "SELECT DATE_FORMAT(added_on, '%Y-%m') as ym
               FROM leads
               WHERE assigned_to = ?
               GROUP BY ym
               ORDER BY ym DESC
               LIMIT 3";
$stmt = $conn->prepare($sql_months);
$stmt->execute([$user_id]);
$months = $stmt->fetchAll(PDO::FETCH_COLUMN);
$months = array_reverse($months); // Oldest to newest

// Prepare result structure
$labels = [];
$new = [];
$in_progress = [];
$won = [];
$lost = [];

foreach ($months as $ym) {
    $labels[] = date('M y', strtotime($ym . '-01'));
    // New
    $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE assigned_to = ? AND DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'new'");
    $stmt->execute([$user_id, $ym]);
    $new[] = (int)$stmt->fetchColumn();
    // In Progress
    $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE assigned_to = ? AND DATE_FORMAT(added_on, '%Y-%m') = ? AND (status = 'connected' OR status = 'not connected')");
    $stmt->execute([$user_id, $ym]);
    $in_progress[] = (int)$stmt->fetchColumn();
    // Won
    $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE assigned_to = ? AND DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'closed' AND response = 'positive'");
    $stmt->execute([$user_id, $ym]);
    $won[] = (int)$stmt->fetchColumn();
    // Lost
    $stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE assigned_to = ? AND DATE_FORMAT(added_on, '%Y-%m') = ? AND status = 'closed' AND response = 'negative'");
    $stmt->execute([$user_id, $ym]);
    $lost[] = (int)$stmt->fetchColumn();
}

echo json_encode([
    'success' => true,
    'labels' => $labels,
    'datasets' => [
        [ 'label' => 'New', 'data' => $new, 'backgroundColor' => '#2979FF' ],
        [ 'label' => 'In Progress', 'data' => $in_progress, 'backgroundColor' => '#26C6DA' ],
        [ 'label' => 'Won', 'data' => $won, 'backgroundColor' => '#145a32' ],
        [ 'label' => 'Lost', 'data' => $lost, 'backgroundColor' => '#7b241c' ]
    ]
]); 