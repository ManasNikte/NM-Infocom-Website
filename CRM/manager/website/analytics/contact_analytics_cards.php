<style>
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
    }
    .card-footer {
        font-size: 0.97rem;
        color: #888;
        margin-top: auto;
        letter-spacing: 0.5px;
    }
    .analytics-card .fa-calendar-day { color: #4a6cf7; }
    .analytics-card .fa-check-circle { color: #219a52; }
    .analytics-card .fa-clock { color: #ff9800; }
    .analytics-card .fa-chart-line { color: #9c27b0; }
    
    @media (max-width: 768px) {
        .analytics-card {
            margin-bottom: 1.2rem;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-value {
            font-size: 2rem;
        }
        .card-icon {
            font-size: 2.2rem;
        }
    }
</style>

<!-- Analytics Cards Row -->
<div class="row mb-4">
  <!-- Today's Form Submits Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card analytics-card w-100">
      <div class="card-body">
        <div class="card-title">Today's Form Submits</div>
        <div class="card-value" id="today-count">--</div>
        <span class="change-indicator" id="today-change">
          <i class="fas fa-arrow-up"></i> <span id="today-percent">--</span>%
        </span>
        <div class="card-footer">vs yesterday</div>
        <i class="fas fa-calendar-day card-icon"></i>
      </div>
    </div>
  </div>
  
  <!-- Responded Submits Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card analytics-card w-100">
      <div class="card-body">
        <div class="card-title">Responded Submits</div>
        <div class="card-value" id="responded-count">--</div>
        <div class="card-footer">Total Responded</div>
        <i class="fas fa-check-circle card-icon"></i>
      </div>
    </div>
  </div>
  
  <!-- Response Pending Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card analytics-card w-100">
      <div class="card-body">
        <div class="card-title">Response Pending</div>
        <div class="card-value" id="pending-count">--</div>
        <div class="card-footer">Awaiting Response</div>
        <i class="fas fa-clock card-icon"></i>
      </div>
    </div>
  </div>
  
  <!-- Total Contact Submits Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card analytics-card w-100">
      <div class="card-body">
        <div class="card-title">Total Submissions</div>
        <div class="card-value" id="total-submits">--</div>
        <div class="card-footer">All Time</div>
        <i class="fas fa-chart-line card-icon"></i>
      </div>
    </div>
  </div>
</div>

<script>
function formatNumber(num) {
    if (typeof num !== 'number') return '--';
    return num.toLocaleString();
}

function setChange(id, change) {
    const el = document.getElementById(id);
    if (!el) return;
    const up = change >= 0;
    el.innerHTML = `<i class="fas fa-arrow-${up ? 'up' : 'down'}"></i> ${Math.abs(change)}%`;
    el.classList.remove('positive', 'negative');
    el.classList.add(up ? 'positive' : 'negative');
}

document.addEventListener('DOMContentLoaded', function() {
    function updateAnalyticsCards(data) {
        // Update Today's Form Submits
        document.getElementById('today-count').textContent = formatNumber(data.today_count);
        setChange('today-change', data.today_percent);
        
        // Update other cards
        document.getElementById('responded-count').textContent = formatNumber(data.responded_count);
        document.getElementById('pending-count').textContent = formatNumber(data.pending_count);
        document.getElementById('total-submits').textContent = formatNumber(data.total_submits);
    }

    function fetchAnalyticsData() {
        // Show loading state
        const cards = document.querySelectorAll('.analytics-card .card-value');
        cards.forEach(card => {
            card.textContent = '...';
        });

        fetch('./data/get_contact_analytics_cards.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    updateAnalyticsCards(data.data);
                } else {
                    console.error('Error fetching analytics data:', data.message);
                    showErrorState();
                }
            })
            .catch(error => {
                console.error('Error fetching analytics data:', error);
                showErrorState();
            });
    }

    function showErrorState() {
        const cards = document.querySelectorAll('.analytics-card .card-value');
        cards.forEach(card => {
            card.textContent = '--';
            card.classList.add('text-danger');
        });
    }

    // Initial fetch
    fetchAnalyticsData();
});
</script>