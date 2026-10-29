<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');
// All authentication and JWT logic is now handled in top.php
// Assume $user, $user_id, $role, $sub_role are set and available here

$vendors_today = 0;
$vendors_yesterday = 0;
$vendors_month = 0;
$vendors_last_month = 0;
$new_vendors_7 = 0;
$new_vendors_prev_7 = 0;
$vendors_with_deal = 0;
$vendors_with_deal_last_month = 0;

if (isset($user_id) && strtolower($role) === 'manager' && strtolower($sub_role) === 'purchase') {
        $db = new Database();
        $pdo = $db->getConnection();
        // Vendors added today
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor WHERE DATE(date_added) = CURDATE()");
        $stmt->execute();
        $vendors_today = (int)$stmt->fetchColumn();
        // Vendors added yesterday
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor WHERE DATE(date_added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        $stmt->execute();
        $vendors_yesterday = (int)$stmt->fetchColumn();
        // Vendors added this month
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor WHERE YEAR(date_added) = YEAR(CURDATE()) AND MONTH(date_added) = MONTH(CURDATE())");
        $stmt->execute();
        $vendors_month = (int)$stmt->fetchColumn();
        // Vendors added last month
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor WHERE YEAR(date_added) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(date_added) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))");
        $stmt->execute();
        $vendors_last_month = (int)$stmt->fetchColumn();
        // New vendors in last 7 days
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor WHERE date_added >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
        $stmt->execute();
        $new_vendors_7 = (int)$stmt->fetchColumn();
        // New vendors in previous 7 days
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor WHERE date_added >= DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND date_added < DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
        $stmt->execute();
        $new_vendors_prev_7 = (int)$stmt->fetchColumn();
        // Vendors with previous deals (this month)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor WHERE previous_deal = 'yes' AND YEAR(date_added) = YEAR(CURDATE()) AND MONTH(date_added) = MONTH(CURDATE())");
        $stmt->execute();
        $vendors_with_deal = (int)$stmt->fetchColumn();
        // Vendors with previous deals (last month)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor WHERE previous_deal = 'yes' AND YEAR(date_added) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(date_added) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))");
        $stmt->execute();
        $vendors_with_deal_last_month = (int)$stmt->fetchColumn();
    }

function percent_change($current, $previous) {
    if ($previous == 0) {
        if ($current == 0) return '--';
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
    .analytics-cards-row {
        display: flex;
        flex-wrap: nowrap;
        gap: 1.25rem;
        margin-bottom: 2rem;
        width: 100%;
    }
    .analytics-card-modern {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 1.2rem 1.1rem 1.2rem 1.1rem;
        min-height: 140px;
        flex: 1 1 0;
        min-width: 0;
        transition: box-shadow 0.2s, transform 0.2s;
        position: relative;
        max-width: 100%;
    }
    .analytics-card-modern:hover {
        box-shadow: 0 8px 32px rgba(44, 62, 80, 0.13);
        transform: translateY(-2px);
    }
    .analytics-card-modern .icon-col {
        flex: 0 0 44px;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.8rem;
    }
    .analytics-card-modern .icon-bg {
        background: linear-gradient(135deg, #4e73df 0%, #1a237e 100%);
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(44, 62, 80, 0.10);
    }
    .analytics-card-modern i.fa-3x {
        font-size: 1.3rem !important;
        color: #fff;
        opacity: 1;
    }
    .analytics-card-modern .card-content {
        flex: 1 1 0;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .analytics-card-modern .card-title {
        font-size: 0.98rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
        color: #1a237e;
        line-height: 1.2;
    }
    .analytics-card-modern .card-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #4e73df;
        margin-bottom: 0.4rem;
        line-height: 1.1;
    }
    .analytics-card-modern .change-indicator-row {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.98rem;
        margin-top: 0.15rem;
        color: #6c757d;
    }
    .analytics-card-modern .change-indicator {
        padding: 0.15rem 0.7rem;
        border-radius: 1rem;
        font-size: 0.95rem;
        background: #f5f7ff;
        color: #4e73df;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        margin-right: 0.2rem;
    }
    .analytics-card-modern .change-indicator i {
        margin-right: 0.18rem;
        color: inherit;
    }
    .analytics-card-modern .change-indicator.negative {
        background: #ffeaea;
        color: #dc3545;
    }
    .analytics-card-modern .change-indicator.positive {
        background: #eafaf1;
        color: #28a745;
    }
    .analytics-card-modern .change-indicator.neutral {
        background: #f5f7ff;
        color: #888;
    }
    /* Reduce font size and lighten color for comparison label */
    .analytics-card-modern .change-indicator-row span.comparison-label {
        font-size: 0.82rem;
        color: #b0b3bb;
        margin-left: 0.1rem;
        font-weight: 500;
        letter-spacing: 0.01em;
    }
    @media (max-width: 1200px) {
        .analytics-cards-row { gap: 0.7rem; }
        .analytics-card-modern { padding: 1rem 0.7rem 1rem 0.7rem; }
        .analytics-card-modern .icon-col { margin-right: 0.5rem; }
        .analytics-card-modern .card-title { font-size: 0.93rem; }
        .analytics-card-modern .card-value { font-size: 1.2rem; }
    }
    @media (max-width: 992px) {
        .analytics-cards-row { gap: 0.5rem; }
        .analytics-card-modern { padding: 0.7rem 0.5rem 0.7rem 0.5rem; }
        .analytics-card-modern .icon-col { margin-right: 0.4rem; }
        .analytics-card-modern .card-title { font-size: 0.9rem; }
        .analytics-card-modern .card-value { font-size: 1.05rem; }
    }
    @media (max-width: 768px) {
        .analytics-cards-row {
            flex-wrap: wrap;
            gap: 0.7rem;
        }
        .analytics-card-modern {
            min-width: 180px;
            flex: 1 1 48%;
            margin-bottom: 0.7rem;
        }
    }
    @media (max-width: 576px) {
        .analytics-cards-row {
            flex-direction: column;
            gap: 0.5rem;
        }
        .analytics-card-modern {
            min-width: 0;
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>
<div class="analytics-cards-row">
    <!-- Vendors Added Today Card -->
    <div class="analytics-card-modern">
        <div class="icon-col">
            <div class="icon-bg"><i class="fas fa-users fa-3x"></i></div>
        </div>
        <div class="card-content">
            <div class="card-title">Vendors Added Today</div>
            <div class="card-value"><?php echo $vendors_today; ?></div>
            <div class="change-indicator-row">
                <span class="change-indicator <?php echo ($vendors_today > $vendors_yesterday ? 'positive' : ($vendors_today < $vendors_yesterday ? 'negative' : 'neutral')); ?>">
                    <?php 
                        $pct = percent_change($vendors_today, $vendors_yesterday);
                        echo percent_arrow($vendors_today, $vendors_yesterday);
                        echo ($pct === '--' || $pct === 'N/A') ? $pct : $pct . '%';
                    ?>
                </span>
                <span class="comparison-label">vs yesterday</span>
            </div>
        </div>
    </div>
    <!-- Vendors Added This Month Card -->
    <div class="analytics-card-modern">
        <div class="icon-col">
            <div class="icon-bg"><i class="fas fa-users fa-3x"></i></div>
        </div>
        <div class="card-content">
            <div class="card-title">Vendors Added This Month</div>
            <div class="card-value"><?php echo $vendors_month; ?></div>
            <div class="change-indicator-row">
                <span class="change-indicator <?php echo ($vendors_month > $vendors_last_month ? 'positive' : ($vendors_month < $vendors_last_month ? 'negative' : 'neutral')); ?>">
                    <?php 
                        $pct = percent_change($vendors_month, $vendors_last_month);
                        echo percent_arrow($vendors_month, $vendors_last_month);
                        echo ($pct === '--' || $pct === 'N/A') ? $pct : $pct . '%';
                    ?>
                </span>
                <span class="comparison-label">vs last month</span>
            </div>
        </div>
    </div>
    <!-- New Vendors Card -->
    <div class="analytics-card-modern">
        <div class="icon-col">
            <div class="icon-bg"><i class="fas fa-clock fa-3x"></i></div>
        </div>
        <div class="card-content">
            <div class="card-title">New Vendors Added This Week</div>
            <div class="card-value"><?php echo $new_vendors_7; ?></div>
            <div class="change-indicator-row">
                <span class="change-indicator <?php echo ($new_vendors_7 > $new_vendors_prev_7 ? 'positive' : ($new_vendors_7 < $new_vendors_prev_7 ? 'negative' : 'neutral')); ?>">
                    <?php 
                        $pct = percent_change($new_vendors_7, $new_vendors_prev_7);
                        echo percent_arrow($new_vendors_7, $new_vendors_prev_7);
                        echo ($pct === '--' || $pct === 'N/A') ? $pct : $pct . '%';
                    ?>
                </span>
                <span class="comparison-label">vs previous week</span>
            </div>
        </div>
    </div>
    <!-- Vendors With Previous Deals Card -->
    <div class="analytics-card-modern">
        <div class="icon-col">
            <div class="icon-bg"><i class="fas fa-shopping-cart fa-3x"></i></div>
        </div>
        <div class="card-content">
            <div class="card-title">Vendors With Previous Deals</div>
            <div class="card-value"><?php echo $vendors_with_deal; ?></div>
            <div class="change-indicator-row">
                <span class="change-indicator <?php echo ($vendors_with_deal > $vendors_with_deal_last_month ? 'positive' : ($vendors_with_deal < $vendors_with_deal_last_month ? 'negative' : 'neutral')); ?>">
                    <?php 
                        $pct = percent_change($vendors_with_deal, $vendors_with_deal_last_month);
                        echo percent_arrow($vendors_with_deal, $vendors_with_deal_last_month);
                        echo ($pct === '--' || $pct === 'N/A') ? $pct : $pct . '%';
                    ?>
                </span>
                <span class="comparison-label">vs last month</span>
            </div>
        </div>
    </div>
</div>