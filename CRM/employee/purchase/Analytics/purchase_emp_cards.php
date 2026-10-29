<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api('Employee', 'purchase');
$conn = getDBConnection();

// Get logged-in user id from JWT
$user_id = null;
if ($auth) {
    try {
        $decoded = $auth;
        $user_id = $decoded->id ?? null;
    } catch (Exception $e) {
        $user_id = null;
    }
}

$today = date('Y-m-d');
$month_start = date('Y-m-01');
$week_ago = date('Y-m-d', strtotime('-7 days'));

// Vendors Added Today
$stmt = $conn->prepare("SELECT COUNT(*) FROM vendor WHERE added_by = ? AND date_added = ?");
$stmt->execute([$user_id, $today]);
$vendors_today = $stmt->fetchColumn();

// Vendors Added This Month
$stmt = $conn->prepare("SELECT COUNT(*) FROM vendor WHERE added_by = ? AND date_added >= ?");
$stmt->execute([$user_id, $month_start]);
$vendors_month = $stmt->fetchColumn();

// New Vendors (last 7 days)
$stmt = $conn->prepare("SELECT COUNT(*) FROM vendor WHERE added_by = ? AND date_added >= ?");
$stmt->execute([$user_id, $week_ago]);
$new_vendors = $stmt->fetchColumn();

// Vendors With Previous Deals
$stmt = $conn->prepare("SELECT COUNT(*) FROM vendor WHERE added_by = ? AND LOWER(previous_deal) = 'yes'");
$stmt->execute([$user_id]);
$vendors_prev_deal = $stmt->fetchColumn();
?>
<style>
    .min-h-150 {
        min-height: 150px;
    }

    .card-body {
        padding: 1.5rem;
    }

    .opacity-50 {
        opacity: 0.5;
    }

    /* Card Base Styles */
    .analytics-card {
        border: none;
        border-radius: 1rem;
        transition: transform 0.2s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .analytics-card:hover {
        transform: translateY(-5px);
    }

    /* Gradient Backgrounds */
    .bg-brown-gradient {
        background: linear-gradient(45deg,rgb(60, 36, 21) 0%,rgb(118, 81, 78) 100%);
    }


    /* Card Content Styles */
    .card-icon {
        font-size: 2.5rem;
        opacity: 0.8;
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

    /* Percentage Indicators */
    .change-indicator {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        background: rgba(255, 255, 255, 0.2);
    }

    .change-indicator i {
        margin-right: 0.25rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .analytics-card {
            margin-bottom: 1rem;
        }
    }
</style>
            <!-- Analytics Cards Row -->
            <div class="row mb-4">
                <!-- Total Vendors Card -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card text-white bg-brown-gradient w-100 analytics-card">
                        <div class="card-body d-flex flex-column min-h-150">
                            <div class="d-flex align-items-center justify-content-between h-100">
                                <div>
                                    <p class="mb-1 text-uppercase font-weight-bold">Vendors Added Today</p>
                                    <h4 class="mb-2 font-weight-bolder text-white"><?php echo $vendors_today; ?></h4>
                                    <div class="mt-auto">
                                        <span class="text-white-50">
                                            <i class="fas fa-arrow-up"></i> &mdash;
                                        </span>
                                        <small class="text-white-50 ml-1">vs last month</small>
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    <i class="fas fa-users fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Vendors Card -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card text-white bg-brown-gradient w-100 analytics-card">
                        <div class="card-body d-flex flex-column min-h-150">
                            <div class="d-flex align-items-center justify-content-between h-100">
                                <div>
                                    <p class="mb-1 text-uppercase font-weight-bold">Vendors Added This Month</p>
                                    <h4 class="mb-2 font-weight-bolder text-white"><?php echo $vendors_month; ?></h4>
                                    <div class="mt-auto">
                                        <span class="text-white-50">
                                            <i class="fas fa-arrow-up"></i> &mdash;
                                        </span>
                                        <small class="text-white-50 ml-1">vs last month</small>
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    <i class="fas fa-users fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Approvals Card -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card text-white bg-brown-gradient w-100 analytics-card">
                        <div class="card-body d-flex flex-column min-h-150">
                            <div class="d-flex align-items-center justify-content-between h-100">
                                <div>
                                    <p class="mb-1 text-uppercase font-weight-bold">New Vendors</p>
                                    <h4 class="mb-2 font-weight-bolder text-white"><?php echo $new_vendors; ?></h4>
                                    <div class="mt-auto">
                                        <span class="text-white-50">
                                            <i class="fas fa-arrow-down"></i> &mdash;
                                        </span>
                                        <small class="text-white-50 ml-1">vs last month</small>
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    <i class="fas fa-clock fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Purchases Card -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card text-white bg-brown-gradient w-100 analytics-card">
                        <div class="card-body d-flex flex-column min-h-150">
                            <div class="d-flex align-items-center justify-content-between h-100">
                                <div>
                                    <p class="mb-1 text-uppercase font-weight-bold">Vendors With Previous Deals</p>
                                    <h4 class="mb-2 font-weight-bolder text-white"><?php echo $vendors_prev_deal; ?></h4>
                                    <div class="mt-auto">
                                        <span class="text-white-50">
                                            <i class="fas fa-arrow-up"></i> &mdash;
                                        </span>
                                        <small class="text-white-50 ml-1">vs last month</small>
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>