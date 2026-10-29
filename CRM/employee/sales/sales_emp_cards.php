<?php
// Monthly lead cards for the logged-in sales employee; included by sales.php after top.php.
if (!isset($auth)) {
    http_response_code(404);
    exit;
}
$user_id = $auth->id;

$db = new Database();
$conn = $db->getConnection();
$month = date('Y-m');

/**
 * Get lead count for a user by status/response in a given month
 */
function get_lead_count($conn, $user_id, $month, $status = null, $response = null) {
    $where = '';
    $params = [$user_id, $month];
    if ($status && is_array($status)) {
        $placeholders = implode(',', array_fill(0, count($status), '?'));
        $where .= " AND status IN ($placeholders)";
        $params = array_merge($params, $status);
    } elseif ($status) {
        $where .= " AND status = ?";
        $params[] = $status;
    }
    if ($response) {
        $where .= " AND response = ?";
        $params[] = $response;
    }
    $sql = "SELECT COUNT(*) FROM leads WHERE assigned_to = ? AND DATE_FORMAT(added_on, '%Y-%m') = ? $where";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $count = (int)$stmt->fetchColumn();
        return $count;
    } catch (Exception $e) {
        return 0;
    }
}

// Card definitions: title, icon, status, response, icon_direction
$cards = [
    [
        'title' => 'New Leads This Month',
        'icon' => 'fas fa-users',
        'status' => 'new',
        'response' => null,
        'icon_direction' => 'fa-arrow-up',
    ],
    [
        'title' => 'In Progress Leads',
        'icon' => 'fas fa-users',
        'status' => ['connected', 'not connected'],
        'response' => null,
        'icon_direction' => 'fa-arrow-up',
    ],
    [
        'title' => 'Won Leads This Month',
        'icon' => 'fas fa-handshake',
        'status' => 'closed',
        'response' => 'positive',
        'icon_direction' => 'fa-arrow-up',
    ],
    [
        'title' => 'Lost Leads This Month',
        'icon' => 'fas fa-handshake',
        'status' => 'closed',
        'response' => 'negative',
        'icon_direction' => 'fa-arrow-down',
    ],
];

$counts = [];
foreach ($cards as $card) {
    $counts[] = get_lead_count($conn, $user_id, $month, $card['status'], $card['response']);
}
?>
<style>
    .min-h-150 { min-height: 150px; }
    .card-body { padding: 1.5rem; }
    .opacity-50 { opacity: 0.5; }
    .analytics-card { border: none; border-radius: 1rem; transition: transform 0.2s ease; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); }
    .analytics-card:hover { transform: translateY(-5px); }
    .bg-brown-gradient { background: linear-gradient(45deg,rgb(60, 36, 21) 0%,rgb(118, 81, 78) 100%); }
    .card-icon { font-size: 2.5rem; opacity: 0.8; }
    .card-title { font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem; }
    .card-value { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; }
    .change-indicator { padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; background: rgba(255, 255, 255, 0.2); }
    .change-indicator i { margin-right: 0.25rem; }
    @media (max-width: 768px) { .analytics-card { margin-bottom: 1rem; } }
</style>
<!-- Analytics Cards Row -->
<div class="row mb-4">
<?php foreach ($cards as $i => $card): ?>
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body d-flex flex-column min-h-150">
        <div class="d-flex align-items-center justify-content-between h-100">
          <div>
            <p class="mb-1 text-uppercase font-weight-bold text-white"><?php echo htmlspecialchars($card['title']); ?></p>
            <h4 class="mb-2 font-weight-bolder text-white"><?php echo $counts[$i]; ?></h4>
            <div class="mt-auto">
              <span class="text-white-50">
                <i class="fas <?php echo htmlspecialchars((string) $card['icon_direction']); ?>"></i>
              </span>
              <small class="text-white-50 ml-1">vs last month</small>
            </div>
          </div>
          <div class="ml-auto">
            <i class="<?php echo htmlspecialchars((string) $card['icon']); ?> fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>