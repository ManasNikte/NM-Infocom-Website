<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'marketing');
// require_once __DIR__ . '/../../../config/database.php';
// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

// $secret_key = 'your_secret_key_here';
// $employee_id = null;
// $role = null;
// $sub_role = null;

$leads_today = 0;
$leads_month = 0;
$positive_month = 0;
$negative_month = 0;
$leads_yesterday = 0;
$leads_last_month = 0;
$positive_last_month = 0;
$negative_last_month = 0;

// Use $user from top.php
if (isset($user) && isset($user['id']) && strtolower($user['role']) === 'manager' && strtolower($user['sub_role']) === 'marketing') {
    $employee_id = $user['id'];
    try {
        $db = new Database();
        $pdo = $db->getConnection();
        // Leads added today
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE DATE(added_on) = CURDATE()");
        $stmt->execute();
        $leads_today = (int)$stmt->fetchColumn();
        // Leads added yesterday
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE DATE(added_on) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        $stmt->execute();
        $leads_yesterday = (int)$stmt->fetchColumn();
        // Leads added this month
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE YEAR(added_on) = YEAR(CURDATE()) AND MONTH(added_on) = MONTH(CURDATE())");
        $stmt->execute();
        $leads_month = (int)$stmt->fetchColumn();
        // Leads added last month
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE YEAR(added_on) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(added_on) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))");
        $stmt->execute();
        $leads_last_month = (int)$stmt->fetchColumn();
        // Positive leads this month
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE response = 'positive' AND YEAR(added_on) = YEAR(CURDATE()) AND MONTH(added_on) = MONTH(CURDATE())");
        $stmt->execute();
        $positive_month = (int)$stmt->fetchColumn();
        // Positive leads last month
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE response = 'positive' AND YEAR(added_on) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(added_on) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))");
        $stmt->execute();
        $positive_last_month = (int)$stmt->fetchColumn();
        // Negative leads this month
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE response = 'negative' AND YEAR(added_on) = YEAR(CURDATE()) AND MONTH(added_on) = MONTH(CURDATE())");
        $stmt->execute();
        $negative_month = (int)$stmt->fetchColumn();
        // Negative leads last month
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE response = 'negative' AND YEAR(added_on) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(added_on) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))");
        $stmt->execute();
        $negative_last_month = (int)$stmt->fetchColumn();
    } catch (Exception $e) {
        // If error, keep all values as 0
    }
}
function percent_change($current, $previous) {
    if ($previous == 0) {
        if ($current == 0) return '--';
        // If previous is 0 and current is not, it's a full increase from zero, so show 'N/A' or '∞%'
        return 'N/A';
    }
    $change = (($current - $previous) / $previous) * 100;
    return ($change > 0 ? '+' : '') . round($change, 1);
}
function percent_arrow($current, $previous) {
    if ($previous == 0) return '';
    if ($current > $previous) return '<span style="color:#28a745;font-weight:bold"><i class="fas fa-arrow-up"></i></span>';
    if ($current < $previous) return '<span style="color:#dc3545;font-weight:bold"><i class="fas fa-arrow-down"></i></span>';
    return '<span style="color:#888"><i class="fas fa-arrows-alt-h"></i></span>';
}
?>
<style>
    .min-h-150 {
        min-height: 180px !important;
        height: 180px !important;
    }
    .analytics-card {
        border: none;
        border-radius: 1rem;
        transition: transform 0.2s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        color: #fff !important;
        background: none !important;
        height: 180px !important;
        min-height: 180px !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .analytics-card.bg-brown-gradient {
        background: linear-gradient(45deg,rgb(60, 36, 21) 0%,rgb(118, 81, 78) 100%) !important;
    }
    .analytics-card:hover {
        transform: translateY(-5px);
    }
    .bg-brown-gradient {
        background: linear-gradient(45deg,rgb(60, 36, 21) 0%,rgb(118, 81, 78) 100%) !important;
    }
    .analytics-card .card-icon,
    .analytics-card .card-title,
    .analytics-card .card-value,
    .analytics-card p,
    .analytics-card h4,
    .analytics-card span,
    .analytics-card small {
        color: #fff !important;
    }
    .card-title {
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }
    .card-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .change-indicator-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: nowrap;
        font-size: 0.95em;
        white-space: nowrap;
    }
    .change-indicator {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        background: rgba(255, 255, 255, 0.2);
        color: #fff !important;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-right: 0.25rem;
        white-space: nowrap;
    }
    .change-indicator i {
        margin-right: 0.25rem;
        color: #fff !important;
    }
    .change-indicator-row small {
        white-space: nowrap;
        font-size: 0.95em;
    }
    .analytics-card .card-body {
        padding: 1.25rem 1.25rem 1.25rem 1.5rem;
        display: flex;
        flex-direction: row;
        align-items: center;
        height: 100%;
        min-height: 0;
    }
    .analytics-card .card-content {
        flex: 1 1 0%;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .analytics-card .icon-col {
        flex: 0 0 56px;
        max-width: 56px;
        min-width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 1rem;
    }
    .analytics-card i.fa-3x {
        font-size: 2.2rem !important;
        width: 2.2rem;
        height: 2.2rem;
        display: block;
        opacity: 0.5;
        margin: 0;
    }
    @media (max-width: 768px) {
        .analytics-card {
            margin-bottom: 1rem;
            height: auto !important;
            min-height: 120px !important;
        }
        .min-h-150 {
            min-height: 120px !important;
            height: 120px !important;
        }
        .analytics-card .icon-col {
            flex: 0 0 36px;
            max-width: 36px;
            min-width: 36px;
            height: 36px;
            margin-left: 0.5rem;
        }
        .analytics-card i.fa-3x {
            font-size: 1.3rem !important;
            width: 1.3rem;
            height: 1.3rem;
        }
        .analytics-card .card-body {
            padding: 0.7rem 0.7rem 0.7rem 1rem;
        }
    }
</style>
<!-- Analytics Cards Row -->
<div class="row mb-4">
  <!-- Total Leads Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body min-h-150">
        <div class="card-content">
          <p class="mb-1 text-uppercase font-weight-bold">Leads Added Today</p>
          <h4 class="mb-2 font-weight-bolder text-white"><?php echo $leads_today; ?></h4>
          <div class="mt-auto change-indicator-row">
            <span class="change-indicator">
              <?php 
                $pct = percent_change($leads_today, $leads_yesterday);
                echo percent_arrow($leads_today, $leads_yesterday);
                echo ($pct === '--' || $pct === 'N/A') ? $pct : $pct . '%';
              ?>
            </span>
            <small class="text-white ml-1">vs yesterday</small>
          </div>
        </div>
        <div class="icon-col">
          <i class="fas fa-users fa-3x"></i>
        </div>
      </div>
    </div>
  </div>
  <!-- Active Leads Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body min-h-150">
        <div class="card-content">
          <p class="mb-1 text-uppercase font-weight-bold">Leads Added This Month</p>
          <h4 class="mb-2 font-weight-bolder text-white"><?php echo $leads_month; ?></h4>
          <div class="mt-auto change-indicator-row">
            <span class="change-indicator">
              <?php 
                $pct = percent_change($leads_month, $leads_last_month);
                echo percent_arrow($leads_month, $leads_last_month);
                echo ($pct === '--' || $pct === 'N/A') ? $pct : $pct . '%';
              ?>
            </span>
            <small class="text-white ml-1">vs last month</small>
          </div>
        </div>
        <div class="icon-col">
          <i class="fas fa-users fa-3x"></i>
        </div>
      </div>
    </div>
  </div>
  <!-- Converted Leads Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body min-h-150">
        <div class="card-content">
          <p class="mb-1 text-uppercase font-weight-bold">Positive Leads This Month</p>
          <h4 class="mb-2 font-weight-bolder text-white"><?php echo $positive_month; ?></h4>
          <div class="mt-auto change-indicator-row">
            <span class="change-indicator">
              <?php 
                $pct = percent_change($positive_month, $positive_last_month);
                echo percent_arrow($positive_month, $positive_last_month);
                echo ($pct === '--' || $pct === 'N/A') ? $pct : $pct . '%';
              ?>
            </span>
            <small class="text-white ml-1">vs last month</small>
          </div>
        </div>
        <div class="icon-col">
          <i class="fas fa-handshake fa-3x"></i>
        </div>
      </div>
    </div>
  </div>
  <!-- Lost Leads Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body min-h-150">
        <div class="card-content">
          <p class="mb-1 text-uppercase font-weight-bold">Negative Leads This Month</p>
          <h4 class="mb-2 font-weight-bolder text-white"><?php echo $negative_month; ?></h4>
          <div class="mt-auto change-indicator-row">
            <span class="change-indicator">
              <?php 
                $pct = percent_change($negative_month, $negative_last_month);
                echo percent_arrow($negative_month, $negative_last_month);
                echo ($pct === '--' || $pct === 'N/A') ? $pct : $pct . '%';
              ?>
            </span>
            <small class="text-white ml-1">vs last month</small>
          </div>
        </div>
        <div class="icon-col">
          <i class="fas fa-user-times fa-3x"></i>
        </div>
      </div>
    </div>
  </div>
</div>