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
    <!-- Sent Today Card -->
    <div class="col-sm-6 col-lg-3 d-flex">
        <div class="card text-white bg-brown-gradient w-100 analytics-card">
            <div class="card-body d-flex flex-column min-h-150">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <p class="mb-1 text-uppercase font-weight-bold">Sent Today</p>
                        <h4 class="mb-2 font-weight-bolder text-white">156</h4>
                        <div class="mt-auto">
                          <span class="text-white-50">
                            <i class="fas fa-arrow-up"></i> 12%
                          </span>
                          <small class="text-white-50 ml-1">vs yesterday</small>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <i class="fas fa-paper-plane fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sent This Month Card -->
    <div class="col-sm-6 col-lg-3 d-flex">
        <div class="card text-white bg-brown-gradient w-100 analytics-card">
            <div class="card-body d-flex flex-column min-h-150">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <p class="mb-1 text-uppercase font-weight-bold">Sent This Month</p>
                        <h4 class="mb-2 font-weight-bolder text-white">2,483</h4>
                    </div>
                    <div class="ml-auto">
                        <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscribers Card -->
    <div class="col-sm-6 col-lg-3 d-flex">
        <div class="card text-white bg-brown-gradient w-100 analytics-card">
            <div class="card-body d-flex flex-column min-h-150">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <p class="mb-1 text-uppercase font-weight-bold">Subscribers</p>
                        <h4 class="mb-2 font-weight-bolder text-white">12,654</h4>
                    </div>
                    <div class="ml-auto">
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unsubscribers Card -->
    <div class="col-sm-6 col-lg-3 d-flex">
        <div class="card text-white bg-brown-gradient w-100 analytics-card">
            <div class="card-body d-flex flex-column min-h-150">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <p class="mb-1 text-uppercase font-weight-bold">Unsubscribers</p>
                        <h4 class="mb-2 font-weight-bolder text-white">23</h4>
                    </div>
                    <div class="ml-auto">
                        <i class="fas fa-user-minus fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>