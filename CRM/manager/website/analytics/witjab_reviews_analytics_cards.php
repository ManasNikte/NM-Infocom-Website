<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once __DIR__ . '/../config/db_connection.php';

// Reviews added today
$today = date('Y-m-d');
$stmtToday = $conn->prepare("SELECT COUNT(*) as cnt FROM reviews WHERE DATE(createdAt) = ?");
$stmtToday->bind_param("s", $today);
$stmtToday->execute();
$resToday = $stmtToday->get_result()->fetch_assoc();
$reviewsToday = $resToday['cnt'] ?? 0;

// Total reviews
$resTotal = $conn->query("SELECT COUNT(*) as cnt FROM reviews");
$reviewsTotal = $resTotal->fetch_assoc()['cnt'] ?? 0;

// Public reviews
$resPublic = $conn->query("SELECT COUNT(*) as cnt FROM reviews WHERE visibility = 'public'");
$reviewsPublic = $resPublic->fetch_assoc()['cnt'] ?? 0;

// Private reviews
$resPrivate = $conn->query("SELECT COUNT(*) as cnt FROM reviews WHERE visibility = 'private'");
$reviewsPrivate = $resPrivate->fetch_assoc()['cnt'] ?? 0;

// Optionally, calculate percentage change for today vs yesterday
$yesterday = date('Y-m-d', strtotime('-1 day'));
$stmtYesterday = $conn->prepare("SELECT COUNT(*) as cnt FROM reviews WHERE DATE(createdAt) = ?");
$stmtYesterday->bind_param("s", $yesterday);
$stmtYesterday->execute();
$resYesterday = $stmtYesterday->get_result()->fetch_assoc();
$reviewsYesterday = $resYesterday['cnt'] ?? 0;

$change = $reviewsYesterday > 0 ? round((($reviewsToday - $reviewsYesterday) / $reviewsYesterday) * 100) : ($reviewsToday > 0 ? 100 : 0);
$changeIcon = $change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
$changeClass = $change >= 0 ? '' : 'opacity-50';

$conn->close();
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
  <!-- Today's Enquiries Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body d-flex flex-column min-h-150">
        <div class="d-flex align-items-center justify-content-between h-100">
          <div>
            <p class="mb-1 text-uppercase font-weight-bold">Reviews Added Today</p>
            <h4 class="mb-2 font-weight-bolder text-white"><?php echo $reviewsToday; ?></h4>
            <div class="mt-auto">
              <span class="text-white-50 <?php echo $changeClass; ?>">
                <i class="fas <?php echo $changeIcon; ?>"></i> <?php echo abs($change); ?>%
              </span>
              <small class="text-white-50 ml-1">vs yesterday</small>
            </div>
          </div>
          <div class="ml-auto">
            <i class="fas fa-pen fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Reviews Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body d-flex flex-column min-h-150">
        <div class="d-flex align-items-center justify-content-between h-100">
          <div>
            <p class="mb-1 text-uppercase font-weight-bold">Total Reviews</p>
            <h4 class="mb-2 font-weight-bolder text-white"><?php echo $reviewsTotal; ?></h4>
          </div>
          <div class="ml-auto">
            <i class="fas fa-book fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Public Reviews Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body d-flex flex-column min-h-150">
        <div class="d-flex align-items-center justify-content-between h-100">
          <div>
            <p class="mb-1 text-uppercase font-weight-bold">Public Reviews</p>
            <h4 class="mb-2 font-weight-bolder text-white"><?php echo $reviewsPublic; ?></h4>
          </div>
          <div class="ml-auto">
            <i class="fas fa-eye fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Private Reviews Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-brown-gradient w-100 analytics-card">
      <div class="card-body d-flex flex-column min-h-150">
        <div class="d-flex align-items-center justify-content-between h-100">
          <div>
            <p class="mb-1 text-uppercase font-weight-bold">Private Reviews</p>
            <h4 class="mb-2 font-weight-bolder text-white"><?php echo $reviewsPrivate; ?></h4>
          </div>
          <div class="ml-auto">
            <i class="fas fa-lock fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>