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
        color: #2575fc;
    }
    .card-footer {
        font-size: 0.97rem;
        color: #888;
        margin-top: auto;
        letter-spacing: 0.5px;
    }
    .analytics-card .fa-calendar-day { color: #2575fc; }
    .analytics-card .fa-calendar-week { color: #6f42c1; }
    .analytics-card .fa-calendar-alt { color: #219a52; }
    .analytics-card .fa-chart-line { color: #fd7e14; }
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
  <!-- Today's Enquiries Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card analytics-card w-100">
      <div class="card-body">
        <div class="card-title">Today's New Enquiries</div>
        <div class="card-value" id="today-count">--</div>
        <span class="change-indicator" id="today-percent">
          <i class="fas fa-arrow-up"></i> --
        </span>
        <div class="card-footer">vs yesterday</div>
        <i class="fas fa-calendar-day card-icon"></i>
      </div>
    </div>
  </div>
  
  <!-- This Week's Enquiries Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card analytics-card w-100">
      <div class="card-body">
        <div class="card-title">This Week's Enquiries</div>
        <div class="card-value" id="week-count">--</div>
        <span class="change-indicator" id="week-percent">
          <i class="fas fa-arrow-up"></i> --
        </span>
        <div class="card-footer">vs last week</div>
        <i class="fas fa-calendar-week card-icon"></i>
      </div>
    </div>
  </div>
  
  <!-- This Month's Enquiries Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card analytics-card w-100">
      <div class="card-body">
        <div class="card-title">This Month's Enquiries</div>
        <div class="card-value" id="month-count">--</div>
        <span class="change-indicator" id="month-percent">
          <i class="fas fa-arrow-up"></i> --
        </span>
        <div class="card-footer">vs last month</div>
        <i class="fas fa-calendar-alt card-icon"></i>
      </div>
    </div>
  </div>
  
  <!-- This Year's Enquiries Card -->
  <div class="col-sm-6 col-lg-3 d-flex">
    <div class="card analytics-card w-100">
      <div class="card-body">
        <div class="card-title">This Year's Enquiries</div>
        <div class="card-value" id="year-count">--</div>
        <span class="change-indicator" id="year-percent">
          <i class="fas fa-arrow-up"></i> --
        </span>
        <div class="card-footer">vs last year</div>
        <i class="fas fa-chart-line card-icon"></i>
      </div>
    </div>
  </div>
</div>

<script>
function formatNumber(num) {
    if (typeof num !== 'number' || isNaN(num)) return '--';
    return num.toLocaleString();
}

function setChange(elementId, change) {
    const el = document.getElementById(elementId);
    if (!el) return;
    const up = change >= 0;
    el.innerHTML = `<i class="fas fa-arrow-${up ? 'up' : 'down'}"></i> ${Math.abs(change)}%`;
    el.classList.remove('positive', 'negative');
    el.classList.add(up ? 'positive' : 'negative');
}

function updateEnquiryAnalyticsCards() {
    fetch('./data/get_enquiry_analytics.php')
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                document.getElementById('today-count').textContent = '--';
                document.getElementById('week-count').textContent = '--';
                document.getElementById('month-count').textContent = '--';
                document.getElementById('year-count').textContent = '--';
                setChange('today-percent', 0);
                setChange('week-percent', 0);
                setChange('month-percent', 0);
                setChange('year-percent', 0);
                return;
            }
            const d = data.data;
            document.getElementById('today-count').textContent = formatNumber(d.today.count);
            setChange('today-percent', d.today.percent);
            document.getElementById('week-count').textContent = formatNumber(d.week.count);
            setChange('week-percent', d.week.percent);
            document.getElementById('month-count').textContent = formatNumber(d.month.count);
            setChange('month-percent', d.month.percent);
            document.getElementById('year-count').textContent = formatNumber(d.year.count);
            setChange('year-percent', d.year.percent);
        })
        .catch(error => {
            document.getElementById('today-count').textContent = '--';
            document.getElementById('week-count').textContent = '--';
            document.getElementById('month-count').textContent = '--';
            document.getElementById('year-count').textContent = '--';
            setChange('today-percent', 0);
            setChange('week-percent', 0);
            setChange('month-percent', 0);
            setChange('year-percent', 0);
        });
}

document.addEventListener('DOMContentLoaded', updateEnquiryAnalyticsCards);
if (document.readyState !== 'loading') {
    updateEnquiryAnalyticsCards();
}
</script>