<style>
    body {
        font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
        background: #f5f6fa;
    }
    .analytics-card {
        background: #fff;
        color: #222;
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        transition: transform 0.16s cubic-bezier(.4,2,.6,1), box-shadow 0.16s;
        position: relative;
        overflow: hidden;
        min-width: 0;
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .analytics-card:hover {
        transform: translateY(-4px) scale(1.018);
        box-shadow: 0 10px 32px rgba(0,0,0,0.13);
    }
    .card-body {
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: 1px;
        opacity: 0.92;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        color: #333;
    }
    .card-value {
        font-size: 2.6rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: 1px;
        color: #111;
        line-height: 1.1;
    }
    .change-indicator {
        display: inline-flex;
        align-items: center;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 1.5rem;
        padding: 0.3rem 1rem;
        margin-top: 0.25rem;
        background: #f2f2f2;
        transition: background 0.2s;
        color: #222;
    }
    .change-indicator.positive {
        color: #219a52;
        background: rgba(33,154,82,0.08);
    }
    .change-indicator.negative {
        color: #d32f2f;
        background: rgba(211,47,47,0.08);
    }
    .change-indicator i {
        margin-right: 0.4rem;
        font-size: 1.2em;
    }
    .card-icon {
        font-size: 2.8rem;
        opacity: 0.13;
        position: absolute;
        right: 1.2rem;
        bottom: 1.2rem;
        pointer-events: none;
        color: #2575fc;
    }
    .card-footer {
        font-size: 0.97rem;
        color: #888;
        margin-top: auto;
        letter-spacing: 0.5px;
    }
    /* Accent icons for each card */
    .analytics-card .fa-boxes { color: #2575fc; }
    .analytics-card .fa-check-circle { color: #d32f2f; }
    /* Responsive */
    @media (max-width: 768px) {
        .analytics-card {
            margin-bottom: 1.2rem;
        }
        .card-body {
            padding: 1.2rem;
        }
        .card-value {
            font-size: 2rem;
        }
        .card-icon {
            font-size: 2rem;
        }
    }
</style>

<!-- Analytics Cards Row -->
<div class="row mb-4">
  <!-- Products Added Today -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-gradient-today w-100 analytics-card">
      <div class="card-body">
        <div class="card-title">Products Added Today</div>
        <div class="card-value" id="products-today-count">--</div>
        <span class="change-indicator" id="products-today-change">
          <i class="fas fa-arrow-up"></i> --
        </span>
        <div class="card-footer">vs yesterday</div>
        <i class="fas fa-boxes card-icon"></i>
      </div>
    </div>
  </div>
  <!-- Discontinued Products -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-gradient-discontinued w-100 analytics-card">
      <div class="card-body">
        <div class="card-title">Discontinued Products</div>
        <div class="card-value" id="products-discontinued-count">--</div>
        <span class="change-indicator" id="products-discontinued-change">
          <i class="fas fa-arrow-up"></i> --
        </span>
        <div class="card-footer">All Time</div>
        <i class="fas fa-check-circle card-icon"></i>
      </div>
    </div>
  </div>
  <!-- Products Added This Month -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-gradient-month w-100 analytics-card">
      <div class="card-body">
        <div class="card-title">Products Added This Month</div>
        <div class="card-value" id="products-month-count">--</div>
        <span class="change-indicator" id="products-month-change">
          <i class="fas fa-arrow-up"></i> --
        </span>
        <div class="card-footer">vs last month</div>
        <i class="fas fa-boxes card-icon"></i>
      </div>
    </div>
  </div>
  <!-- Products Added This Year -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card text-white bg-gradient-year w-100 analytics-card">
      <div class="card-body">
        <div class="card-title">Products Added This Year</div>
        <div class="card-value" id="products-year-count">--</div>
        <span class="change-indicator" id="products-year-change">
          <i class="fas fa-arrow-up"></i> --
        </span>
        <div class="card-footer">vs last year</div>
        <i class="fas fa-boxes card-icon"></i>
      </div>
    </div>
  </div>
</div>

<script>
            function updateAnalyticsCards() {
    fetch('analytics/products_analytics_data.php')
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                console.error("Failed to fetch analytics data:", data.error);
                return;
            }

            // Helper to set indicator
            function setChange(id, change) {
                const el = document.getElementById(id);
                const up = change >= 0;
                el.innerHTML = `<i class="fas fa-arrow-${up ? 'up' : 'down'}"></i> ${Math.abs(change)}%`;
                el.classList.remove('positive', 'negative');
                el.classList.add(up ? 'positive' : 'negative');
            }

            document.getElementById('products-today-count').textContent = data.today.count;
            setChange('products-today-change', data.today.change);

            document.getElementById('products-discontinued-count').textContent = data.discontinued.count;
            setChange('products-discontinued-change', data.discontinued.change);

            document.getElementById('products-month-count').textContent = data.month.count;
            setChange('products-month-change', data.month.change);

            document.getElementById('products-year-count').textContent = data.year.count;
            setChange('products-year-change', data.year.change);
        })
        .catch(error => {
            console.error("Error fetching analytics data:", error);
        });
}
document.addEventListener('DOMContentLoaded', updateAnalyticsCards);
</script>