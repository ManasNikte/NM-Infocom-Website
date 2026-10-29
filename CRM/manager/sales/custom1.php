<?php require_once './top.php'; ?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row mb-4">
              <!-- Bar Chart Column -->
              <div class="col-lg-8">
                <div class="card shadow-lg" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header">
                    <h4 class="mb-0" style="color: #fff; font-weight: 700;">Sales Status Trends (Custom Range)</h4>
                  </div>
                  <div class="card-body p-4">
                    <div class="chart-container" style="height: 320px; width: 100%; position: relative; min-width: 320px; min-height: 260px;">
                      <canvas id="customBarChart" style="height: 260px; width: 100%; min-width: 320px; min-height: 260px; background: #fff;"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Custom Date Range Column -->
              <div class="col-lg-4">
                <div class="card shadow-lg" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header">
                    <h4 class="mb-0" style="color: #fff; font-weight: 700;">Custom Date Range</h4>
                  </div>
                  <div class="card-body p-4">
                    <form>
                      <!-- Start Date -->
                      <div class="form-group mb-4">
                        <label class="text-gradient font-weight-bold mb-2" style="background: linear-gradient(45deg, #1a237e, #4e73df); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Start Date</label>
                        <div class="input-group">
                          <input type="date" class="form-control custom-input" id="startDate" style="border-radius: 15px 0 0 15px; border: 2px solid #e3e6f0; padding: 12px;">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                          </div>
                        </div>
                      </div>

                      <!-- End Date -->
                      <div class="form-group mb-4">
                        <label class="text-gradient font-weight-bold mb-2" style="background: linear-gradient(45deg, #1a237e, #4e73df); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">End Date</label>
                        <div class="input-group">
                          <input type="date" class="form-control custom-input" id="endDate" style="border-radius: 15px 0 0 15px; border: 2px solid #e3e6f0; padding: 12px;">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                          </div>
                        </div>
                      </div>

                      <!-- Submit Button -->
                      <button type="button" class="btn btn-primary btn-block custom-button" onclick="validateAndRenderBarChart()" 
                        style="border-radius: 15px; padding: 12px; background: linear-gradient(45deg, #1a237e, #4e73df); border: none; font-weight: 600; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.2); transition: all 0.3s ease;">
                        <i class="fas fa-paper-plane mr-2"></i>Generate Report
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
    color: #fff;
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
  .card {
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
    background: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    min-height: 100%;
  }
  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(44, 62, 80, 0.13) !important;
  }
  .card-header {
    border-radius: 20px 20px 0 0;
    background: linear-gradient(45deg, #1a237e, #4e73df);
    color: #fff;
    font-family: 'Nunito', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    padding: 16px 24px;
    display: flex;
    align-items: center;
    min-height: 60px;
  }
  .card-body {
    font-family: 'Nunito', sans-serif;
    font-size: 1rem;
    color: #2c3e50;
  }
  .form-group label {
    font-weight: 600;
    color: #1a237e;
    margin-bottom: 0.5rem;
  }
  .input-group-text {
    background: #f5f7ff;
    border: 2px solid #e3e6f0;
    color: #4e73df;
  }
  @media (max-width: 992px) {
    .col-lg-8, .col-lg-4 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    .chart-container {
      height: 260px;
      padding: 20px 5px 5px 5px;
    }
  }
  @media (max-width: 576px) {
    .chart-container {
      height: 200px;
      padding: 10px 2px 2px 2px;
    }
    .card-header h4, .card-header h5 {
      font-size: 1.1rem;
    }
    #noDataMsg {
      font-size: 1rem;
      padding: 30px 0;
    }
  }
  .row.mb-4 {
    display: flex;
    align-items: stretch;
  }
  .col-lg-8, .col-lg-4 {
    display: flex;
    flex-direction: column;
  }
</style>

<!-- Add necessary scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script>
  let barChartInstance = null;
  const canvas = document.getElementById('customBarChart');
  const ctx = canvas.getContext('2d');

  // Set default date range to last 3 months (including current month)
  function setDefaultDateRange() {
    const end = new Date();
    const start = new Date(end.getFullYear(), end.getMonth() - 2, 1); // 2 months ago, first day
    document.getElementById('startDate').value = start.toISOString().slice(0, 10);
    document.getElementById('endDate').value = end.toISOString().slice(0, 10);
  }

  function fetchAndRenderBarChart(startDate, endDate) {
    let url = 'data/custom_bar_chart_data.php?ajax=true';
    if (startDate && endDate) {
      url += `&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
    }
    fetch(url)
      .then(response => response.json())
      .then(data => {
        renderBarChart(data);
      })
      .catch(err => {
        console.error('Chart data fetch error:', err);
        showNoDataMsg('Failed to load chart data.');
      });
  }

  function showNoDataMsg(msg) {
    canvas.style.display = 'none';
    let chartContainer = document.querySelector('.chart-container');
    let noDataMsg = document.getElementById('noDataMsg');
    if (!noDataMsg) {
      noDataMsg = document.createElement('div');
      noDataMsg.id = 'noDataMsg';
      noDataMsg.style.textAlign = 'center';
      noDataMsg.style.color = '#888';
      noDataMsg.style.fontWeight = 'bold';
      noDataMsg.style.padding = '60px 0';
      chartContainer.appendChild(noDataMsg);
    }
    noDataMsg.textContent = msg;
    noDataMsg.style.display = 'block';
  }

  function renderBarChart(data) {
    console.log('Bar chart data:', data);
    // Remove previous chart if exists
    if (barChartInstance) {
      barChartInstance.destroy();
    }
    // Check if all values are zero
    const allZero = data.datasets.every(ds => ds.data.every(v => v === 0));
    let chartContainer = document.querySelector('.chart-container');
    let noDataMsg = document.getElementById('noDataMsg');
    if (allZero) {
      canvas.style.display = 'none';
      if (!noDataMsg) {
        noDataMsg = document.createElement('div');
        noDataMsg.id = 'noDataMsg';
        noDataMsg.style.textAlign = 'center';
        noDataMsg.style.color = '#888';
        noDataMsg.style.fontWeight = 'bold';
        noDataMsg.style.padding = '60px 0';
        chartContainer.appendChild(noDataMsg);
      }
      noDataMsg.textContent = 'No sales data found for the selected date range.';
      noDataMsg.style.display = 'block';
      return;
    } else {
      canvas.style.display = 'block';
      if (noDataMsg) noDataMsg.style.display = 'none';
    }
    try {
      barChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: data.datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                padding: 20,
                font: {
                  size: 12,
                  family: "'Nunito', sans-serif"
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: 'rgba(0, 0, 0, 0.05)'
              },
              ticks: {
                font: {
                  size: 12
                }
              }
            },
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  size: 12
                }
              }
            }
          },
          animation: {
            duration: 2000,
            easing: 'easeInOutQuart'
          },
          layout: {
            padding: {
              left: 10,
              right: 10,
              top: 10,
              bottom: 10
            }
          }
        }
      });
      console.log('Chart.js instance created:', barChartInstance);
    } catch (e) {
      console.error('Chart.js render error:', e);
      showNoDataMsg('Failed to render chart.');
    }
  }

  // Initial load (set default range and fetch data)
  setDefaultDateRange();
  fetchAndRenderBarChart(
    document.getElementById('startDate').value,
    document.getElementById('endDate').value
  );

  // Enhanced date input validation
  document.getElementById('endDate').addEventListener('change', function() {
    const startDate = document.getElementById('startDate').value;
    const endDate = this.value;
    if(startDate && endDate) {
      const start = new Date(startDate);
      const end = new Date(endDate);
      if(end < start) {
        Swal.fire({
          icon: 'warning',
          title: 'Invalid Date Range',
          text: 'End date must be after start date',
          confirmButtonColor: '#4e73df'
        });
        this.value = '';
      }
    }
  });

  function validateAndRenderBarChart() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    if (!startDate || !endDate) {
      Swal.fire({
        icon: 'warning',
        title: 'Missing Dates',
        text: 'Please select both start and end dates',
        confirmButtonColor: '#4e73df'
      });
      return;
    }
    // Add loading animation
    Swal.fire({
      title: 'Generating Report',
      html: 'Please wait...',
      timer: 1000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      }
    }).then(() => {
      fetchAndRenderBarChart(startDate, endDate);
    });
  }
</script>

<!-- Add SweetAlert2 for better alerts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<?php require './bottom.php'; ?> 