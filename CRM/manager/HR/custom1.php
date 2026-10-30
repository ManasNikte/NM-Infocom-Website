<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content" style="min-height:100vh; background: linear-gradient(135deg, #f5f7fa 0%, #e3e9fc 100%);">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <div class="row mb-4">
              <div class="col-12 text-center mb-4">
                <h2 class="dashboard-title" style="font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 2.2rem; letter-spacing: 1px; background: linear-gradient(45deg, #1a237e, #4e73df); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent;">Applicants Analytics</h2>
                <p class="dashboard-subtitle" style="font-size: 1.1rem; color: #4e73df; font-weight: 500; margin-bottom: 0;">Visualize applicant trends and filter by month range</p>
              </div>
            </div>
            <div class="row mb-4 align-items-stretch">
              <!-- Chart Column -->
              <div class="col-lg-8 d-flex align-items-stretch">
                <div class="card shadow-lg chart-card" style="border-radius: 24px; background: #fff; box-shadow: 0 8px 32px rgba(44, 62, 80, 0.13); border: 1.5px solid #e3e9fc; min-width: 0; width: 100%; display: flex; flex-direction: column; justify-content: center;">
                  <div class="card-body p-4" style="display: flex; flex-direction: column; justify-content: center; height: 100%;">
                    <h5 class="card-title mb-4" style="font-weight: 700; color: #1a237e; letter-spacing: 0.5px;">Applicants Overview</h5>
                    <div class="chart-container" style="height: 320px;">
                      <canvas id="customBarChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Right Column: Date Filter -->
              <div class="col-lg-4 d-flex align-items-stretch">
                <div class="card shadow-lg filter-card" style="border-radius: 24px; background: rgba(255,255,255,0.85); backdrop-filter: blur(6px); box-shadow: 0 8px 32px rgba(44, 62, 80, 0.10); border: 1.5px solid #e3e9fc; min-width: 0; width: 100%; display: flex; flex-direction: column; justify-content: center;">
                  <div class="card-header bg-gradient-primary" style="border-radius: 24px 24px 0 0;">
                    <h5 class="text-white mb-0">Filter by Month</h5>
                  </div>
                  <div class="card-body p-4">
                    <form id="dateFilterForm">
                      <div class="form-group mb-4">
                        <label class="text-gradient font-weight-bold mb-2">From</label>
                        <div class="input-group">
                          <input type="month" class="form-control custom-input" id="filterStart" name="filterStart" style="border-radius: 15px 0 0 15px; border: 2px solid #e3e6f0; padding: 12px;">
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label class="text-gradient font-weight-bold mb-2">Till</label>
                        <div class="input-group">
                          <input type="month" class="form-control custom-input" id="filterEnd" name="filterEnd" style="border-radius: 15px 0 0 15px; border: 2px solid #e3e6f0; padding: 12px;">
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block custom-button filter-btn" style="border-radius: 15px; padding: 12px; background: linear-gradient(45deg, #1a237e, #4e73df); border: none; font-weight: 600; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.2); transition: all 0.3s ease;">
                        <i class="fas fa-filter mr-2"></i>Apply Filter
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<!-- Add necessary styles -->
<style>
  .bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
  }
  
  .input-group-text {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
  }
  
  .form-control {
    border-color: #e3e6f0;
  }
  
  .form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
  }
  
  .btn-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
    border: none;
    padding: 0.75rem;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
  }
  
  /* Responsive styles */
  @media (max-width: 1200px) {
    .col-lg-8, .col-lg-4 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    
    .card {
      margin-bottom: 1.5rem;
    }
  }

  @media (max-width: 992px) {
    .main-content {
      padding: 20px;
    }
    
    .card-body {
      padding: 1.25rem;
    }
    
    .chart-container {
      height: 350px !important;
    }
  }

  @media (max-width: 768px) {
    .main-content {
      padding: 15px;
    }
    
    .card {
      margin-bottom: 1rem;
    }
    
    .card-header {
      padding: 0.75rem 1rem;
    }
    
    .card-header h5 {
      font-size: 1rem;
    }
    
    .form-group {
      margin-bottom: 1rem;
    }
    
    .input-group {
      flex-wrap: nowrap;
    }
    
    .form-control {
      font-size: 0.9rem;
    }
    
    .btn {
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
    }
    
    .chart-container {
      height: 300px !important;
    }
  }

  @media (max-width: 576px) {
    .container-fluid {
      padding: 0.5rem;
    }
    
    .card {
      border-radius: 0.5rem;
      margin-bottom: 0.75rem;
    }
    
    .card-body {
      padding: 1rem;
    }
    
    .input-group-text {
      padding: 0.375rem 0.5rem;
    }
    
    .chart-container {
      height: 250px !important;
    }
    
    .form-group label {
      font-size: 0.9rem;
    }
    
    .btn {
      padding: 0.5rem;
    }
  }

  @media (max-width: 400px) {
    .main-content {
      padding: 10px;
    }
    
    .card-header h5 {
      font-size: 0.9rem;
    }
    
    .chart-container {
      height: 200px !important;
    }
    
    .form-control, .input-group-text {
      font-size: 0.85rem;
    }
  }

  /* Chart container styles */
  .chart-container {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 200px;
  }
  .text-gradient {
    background: linear-gradient(45deg, #1a237e, #4e73df);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .custom-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    border-color: #4e73df;
  }
  .custom-button {
    border-radius: 15px;
    padding: 12px;
    background: linear-gradient(45deg, #1a237e, #4e73df);
    border: none;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(78, 115, 223, 0.2);
    transition: all 0.3s ease;
  }
  .custom-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(78, 115, 223, 0.3);
    background: linear-gradient(45deg, #4e73df, #1a237e);
  }
  .chart-container {
    position: relative;
    margin: 0 auto;
    height: 320px;
    width: 100%;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(44, 62, 80, 0.08);
    padding: 30px 20px 10px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
  }
  #noDataMsg {
    text-align: center;
    color: #888;
    font-weight: 600;
    font-size: 1.2rem;
    padding: 60px 0;
    border-radius: 16px;
    background: linear-gradient(90deg, #4e73df 0%, #1a237e 100%);
    box-shadow: 0 2px 12px rgba(44, 62, 80, 0.04);
    margin: 0 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  #noDataMsg::before {
    content: '\1F50D';
    font-size: 2.2rem;
    display: block;
    margin-bottom: 10px;
  }
  .row.mb-4 { display: flex; align-items: stretch; }
  .col-lg-8, .col-lg-4 { display: flex; flex-direction: column; }
  @media (max-width: 992px) {
    .col-lg-8, .col-lg-4 { flex: 0 0 100%; max-width: 100%; }
    .chart-container { height: 260px; padding: 20px 5px 5px 5px; }
  }
  @media (max-width: 576px) {
    .chart-container { height: 200px; padding: 10px 2px 2px 2px; }
    #noDataMsg { font-size: 1rem; padding: 30px 0; }
    .dashboard-title { font-size: 1.3rem; }
    .dashboard-subtitle { font-size: 0.95rem; }
  }
  .dashboard-title {
    margin-top: 32px;
    margin-bottom: 8px;
  }
  .dashboard-subtitle {
    margin-bottom: 32px;
  }
  .filter-card {
    background: rgba(255,255,255,0.85) !important;
    backdrop-filter: blur(6px);
    box-shadow: 0 8px 32px rgba(44, 62, 80, 0.10);
    border: 1.5px solid #e3e9fc;
  }
  .chart-card {
    box-shadow: 0 8px 32px rgba(44, 62, 80, 0.13);
    border: 1.5px solid #e3e9fc;
  }
  .custom-button.filter-btn {
    background: linear-gradient(45deg, #1a237e, #4e73df);
    color: #fff;
    border: none;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(78, 115, 223, 0.2);
    transition: all 0.3s ease;
  }
  .custom-button.filter-btn:hover {
    background: linear-gradient(45deg, #4e73df, #1a237e);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(78, 115, 223, 0.3);
  }
  .main-content {
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e3e9fc 100%);
  }
  .row.mb-4.align-items-stretch { align-items: stretch !important; }
  .col-lg-8, .col-lg-4 { display: flex; flex-direction: column; }
  @media (max-width: 992px) {
    .col-lg-8, .col-lg-4 { flex: 0 0 100%; max-width: 100%; }
    .chart-container { height: 260px; padding: 20px 5px 5px 5px; }
  }
  @media (max-width: 576px) {
    .chart-container { height: 200px; padding: 10px 2px 2px 2px; }
    #noDataMsg { font-size: 1rem; padding: 30px 0; }
    .dashboard-title { font-size: 1.3rem; }
    .dashboard-subtitle { font-size: 0.95rem; }
  }
</style>
<script>
let applicantsLineChart = null;
function showLoadingChart() {
  const ctx = document.getElementById('customBarChart').getContext('2d');
  ctx.clearRect(0, 0, 600, 400);
  ctx.font = '18px Nunito, sans-serif';
  ctx.fillStyle = '#888';
  ctx.textAlign = 'center';
  ctx.fillText('Loading...', 300, 200);
}
function showNoDataMsg() {
  let msg = document.getElementById('noDataMsg');
  if (!msg) {
    msg = document.createElement('div');
    msg.id = 'noDataMsg';
    msg.textContent = 'No data found for the selected range.';
    document.querySelector('.chart-container').appendChild(msg);
  } else {
    msg.style.display = 'flex';
  }
  document.getElementById('customBarChart').style.display = 'none';
}
function hideNoDataMsg() {
  const msg = document.getElementById('noDataMsg');
  if (msg) msg.style.display = 'none';
  document.getElementById('customBarChart').style.display = 'block';
}
function loadLineChart(start = null, end = null) {
  showLoadingChart();
  let url = './data/custom1_line_chart_data.php';
  if (start && end) {
    url += `?start=${start}-01&end=${end}-01`;
  }
  fetch(url)
    .then(response => response.json())
    .then(data => {
      if (
        (!data.labels || data.labels.length === 0) ||
        ((data.applicants||[]).every(v => v === 0) && (data.shortlisted||[]).every(v => v === 0) && (data.rejected||[]).every(v => v === 0))
      ) {
        showNoDataMsg();
        if (applicantsLineChart) applicantsLineChart.destroy();
        return;
      }
      hideNoDataMsg();
      const ctx = document.getElementById('customBarChart').getContext('2d');
      if (applicantsLineChart) applicantsLineChart.destroy();
      applicantsLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.labels,
          datasets: [
            {
              label: 'Applicants',
              data: data.applicants,
              borderColor: 'rgba(0, 123, 255, 1)',
              backgroundColor: 'rgba(0, 123, 255, 0.1)',
              fill: false,
              tension: 0.3,
              pointBackgroundColor: 'rgba(0, 123, 255, 1)',
              pointBorderColor: 'rgba(0, 123, 255, 1)',
              pointRadius: 5
            },
            {
              label: 'Shortlisted',
              data: data.shortlisted,
              borderColor: 'rgba(40, 167, 69, 1)',
              backgroundColor: 'rgba(40, 167, 69, 0.1)',
              fill: false,
              tension: 0.3,
              pointBackgroundColor: 'rgba(40, 167, 69, 1)',
              pointBorderColor: 'rgba(40, 167, 69, 1)',
              pointRadius: 5
            },
            {
              label: 'Rejected',
              data: data.rejected,
              borderColor: 'rgba(220, 53, 69, 1)',
              backgroundColor: 'rgba(220, 53, 69, 0.1)',
              fill: false,
              tension: 0.3,
              pointBackgroundColor: 'rgba(220, 53, 69, 1)',
              pointBorderColor: 'rgba(220, 53, 69, 1)',
              pointRadius: 5
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: true },
            tooltip: { enabled: true }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: { color: 'rgba(0, 0, 0, 0.05)' },
              ticks: { font: { size: 12 } }
            },
            x: {
              grid: { display: false },
              ticks: { font: { size: 12 } }
            }
          },
          animation: { duration: 2000, easing: 'easeInOutQuart' },
          layout: { padding: { left: 10, right: 10, top: 10, bottom: 10 } }
        }
      });
    })
    .catch(() => {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load chart data.' });
    });
}
document.addEventListener('DOMContentLoaded', function() {
  loadLineChart();
  document.getElementById('dateFilterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const start = document.getElementById('filterStart').value;
    const end = document.getElementById('filterEnd').value;
    if (start && end && start > end) {
      Swal.fire({ icon: 'warning', title: 'Invalid Range', text: 'Till month must be after or equal to From month' });
      return;
    }
    loadLineChart(start, end);
  });
});
</script>

<?php require './bottom.php'; ?>