<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <div class="row mb-4">
              <!-- Line Chart Column -->
              <div class="col-lg-8">
                <div class="card shadow-lg" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header">
                    <h4 class="mb-0" style="color: #fff; font-weight: 700;">Vendors Added Overview</h4>
                  </div>
                  <div class="card-body p-4">
                    <div class="chart-container" style="height: 300px; position: relative;">
                      <canvas id="customBarChart"></canvas>
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
                      <button type="button" class="btn btn-primary btn-block custom-button" onclick="validateAndRedirect()" 
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
        <script>
          let lineChartInstance = null;
          const ctx = document.getElementById('customBarChart').getContext('2d');

          // Fetch and render the line chart
          function fetchAndRenderLineChart(startDate, endDate) {
            let url = 'data/custom_line_chart_data.php?ajax=true';
            if (startDate && endDate) {
              url += `&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
            }
            fetch(url)
              .then(response => response.json())
              .then(data => {
                renderLineChart(data);
              });
          }

          // Render the line chart
          function renderLineChart(data) {
            if (lineChartInstance) {
              lineChartInstance.destroy();
            }
            lineChartInstance = new Chart(ctx, {
              type: 'line',
              data: {
                labels: data.months,
                datasets: [{
                  label: 'Vendors Added',
                  data: data.values,
                  fill: false,
                  borderColor: '#4e73df',
                  backgroundColor: '#4e73df',
                  tension: 0.3,
                  pointRadius: 5,
                  pointBackgroundColor: '#224abe',
                  pointBorderColor: '#fff',
                  pointHoverRadius: 7,
                  pointHoverBackgroundColor: '#4e73df',
                  pointHoverBorderColor: '#224abe',
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                  legend: {
                    display: true
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
                        size: function() {
                          return window.innerWidth < 768 ? 10 : 12;
                        }
                      }
                    }
                  },
                  x: {
                    grid: {
                      display: false
                    },
                    ticks: {
                      font: {
                        size: function() {
                          return window.innerWidth < 768 ? 10 : 12;
                        }
                      }
                    }
                  }
                }
              }
            });
          }

          // Date input validation
          document.getElementById('endDate').addEventListener('change', function() {
            const startDate = document.getElementById('startDate').value;
            const endDate = this.value;
            if(startDate && endDate && new Date(endDate) < new Date(startDate)) {
              alert('End date must be after start date');
              this.value = '';
            }
          });

          // On submit, update the chart
          function validateAndRedirect() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            if (!startDate || !endDate) {
              alert('Please select both dates');
              return;
            }
            fetchAndRenderLineChart(startDate, endDate);
          }

          // On page load, show last 3 months
          window.addEventListener('DOMContentLoaded', function() {
            fetchAndRenderLineChart();
          });
        </script>
<?php require './bottom.php'; ?>



       