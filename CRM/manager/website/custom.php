<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <div class="row mb-4">
              <!-- Pie Chart Column -->
              <div class="col-lg-8">
                <div class="card shadow-lg" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header border-0 bg-transparent pt-4 px-4">
                    <h4 class="text-gradient mb-0" style="background: linear-gradient(45deg, #1a237e, #4e73df); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">Task Distribution Overview</h4>
                  </div>
                  <div class="card-body p-4">
                    <div class="chart-container" style="height: 300px; position: relative;">
                      <canvas id="customPieChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Custom To-Do List Column -->
              <div class="col-lg-4">
                <div class="card shadow-lg" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header bg-gradient-primary" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df);">
                    <h5 class="text-white mb-0" style="font-weight: 600; letter-spacing: 0.5px;">Custom Date Range</h5>
                  </div>
                  <div class="card-body p-4">
                    <form>
                      <!-- Start Date -->
                      <div class="form-group mb-4">
                        <label class="text-gradient font-weight-bold mb-2" style="background: linear-gradient(45deg, #1a237e, #4e73df); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Start Date</label>
                        <div class="input-group">
                          <input type="date" class="form-control custom-input" id="startDate" style="border-radius: 15px 0 0 15px; border: 2px solid #e3e6f0; padding: 12px;">
                          <div class="input-group-append">
                            <span class="input-group-text" style="border-radius: 0 15px 15px 0; border: 2px solid #e3e6f0; border-left: none; background: white;">
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
                            <span class="input-group-text" style="border-radius: 0 15px 15px 0; border: 2px solid #e3e6f0; border-left: none; background: white;">
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

          .custom-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.3);
          }

          .chart-container {
            position: relative;
            margin: auto;
            height: 100%;
            width: 100%;
          }

          canvas {
            max-width: 100%;
          }

          /* Card hover effect */
          .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
          }

          .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
          }

          /* Responsive styles */
          @media (max-width: 768px) {
            .chart-container {
              height: 300px;
            }
            
            .card {
              margin-bottom: 20px;
            }
          }

          @media (max-width: 576px) {
            .chart-container {
              height: 250px;
            }
            
            .card-header h4, .card-header h5 {
              font-size: 1.1rem;
            }
          }
        </style>

        <!-- Add necessary scripts -->
        <script>
          const ctx = document.getElementById('customPieChart').getContext('2d');
          
          // Enhanced gradient colors
          const gradients = [
            createGradient(['#00c853', '#69f0ae']),  // Green gradient
            createGradient(['#2962ff', '#82b1ff']),  // Blue gradient
            createGradient(['#ffd600', '#ffff00'])   // Yellow gradient
          ];

          function createGradient(colors) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, colors[0]);
            gradient.addColorStop(1, colors[1]);
            return gradient;
          }

          // Sample data for pie chart
          const data = {
            labels: ['Completed', 'In Progress', 'Pending'],
            datasets: [{
              data: [30, 40, 30],
              backgroundColor: gradients,
              borderWidth: 2,
              borderColor: '#ffffff',
              hoverBorderWidth: 0,
              hoverOffset: 10
            }]
          };

          // Enhanced chart configuration
          const config = {
            type: 'pie',
            data: data,
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  position: 'bottom',
                  labels: {
                    padding: 20,
                    font: {
                      size: 13,
                      weight: '600',
                      family: "'Nunito', sans-serif"
                    },
                    usePointStyle: true,
                    pointStyle: 'circle'
                  }
                },
                tooltip: {
                  backgroundColor: 'rgba(255, 255, 255, 0.95)',
                  titleColor: '#1a237e',
                  titleFont: {
                    size: 14,
                    weight: 'bold',
                    family: "'Nunito', sans-serif"
                  },
                  bodyColor: '#4e73df',
                  bodyFont: {
                    size: 13,
                    family: "'Nunito', sans-serif"
                  },
                  padding: 15,
                  borderColor: 'rgba(78, 115, 223, 0.1)',
                  borderWidth: 2,
                  displayColors: true,
                  boxWidth: 10,
                  boxHeight: 10,
                  boxPadding: 3,
                  callbacks: {
                    label: function(context) {
                      const label = context.label || '';
                      const value = context.raw || 0;
                      return `${label}: ${value}%`;
                    }
                  }
                }
              },
              layout: {
                padding: 20
              },
              animation: {
                animateScale: true,
                animateRotate: true,
                duration: 2000,
                easing: 'easeInOutQuart'
              },
              elements: {
                arc: {
                  borderWidth: 2
                }
              }
            }
          };

          // Initialize the pie chart
          new Chart(ctx, config);

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

          function validateAndRedirect() {
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
              window.location.href = 'dashboard.php';
            });
          }
        </script>

        <!-- Add SweetAlert2 for better alerts -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<?php require './bottom.php'; ?>



       