<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <div class="row mb-4">
              <!-- Bar Graph Column -->
              <div class="col-lg-8">
                <div class="card shadow-lg">
                  <div class="card-body p-3">
                    <div style="height: 300px;">
                      <canvas id="customBarChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Custom To-Do List Column -->
              <div class="col-lg-4">
                <div class="card shadow-lg">
                  <div class="card-header bg-gradient-primary">
                    <h5 class="text-white mb-0">Custom</h5>
                  </div>
                  <div class="card-body">
                    <form>
                      <!-- Start Date -->
                      <div class="form-group mb-4">
                        <label class="text-muted font-weight-bold">Start Date</label>
                        <div class="input-group">
                          <input type="date" class="form-control" id="startDate">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <i class="fas fa-calendar-alt"></i>
                            </span>
                          </div>
                        </div>
                      </div>

                      <!-- End Date -->
                      <div class="form-group mb-4">
                        <label class="text-muted font-weight-bold">End Date</label>
                        <div class="input-group">
                          <input type="date" class="form-control" id="endDate">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <i class="fas fa-calendar-alt"></i>
                            </span>
                          </div>
                        </div>
                      </div>

                      <!-- Submit Button -->
                      <button type="button" class="btn btn-primary btn-block" onclick="validateAndRedirect()">
                        <i class="fas fa-paper-plane mr-2"></i>Submit
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
        </style>

        <!-- Add necessary scripts -->
        <script>
          const ctx = document.getElementById('customBarChart').getContext('2d');
          
          // Function to get last 3 months
          function getLastThreeMonths() {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                           'July', 'August', 'September', 'October', 'November', 'December'];
            const today = new Date();
            const last3Months = [];
            
            for(let i = 2; i >= 0; i--) {
              const d = new Date(today.getFullYear(), today.getMonth() - i, 1);
              last3Months.push(months[d.getMonth()]);
            }
            
            return last3Months;
          }

          // Create gradient
          const gradient = ctx.createLinearGradient(0, 0, 0, 300);
          gradient.addColorStop(0, 'rgba(78, 115, 223, 0.8)');
          gradient.addColorStop(1, 'rgba(78, 115, 223, 0.1)');

          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: getLastThreeMonths(),
              datasets: [{
                label: 'Performance',
                data: [65, 72, 80], // Sample data for last 3 months
                backgroundColor: gradient,
                borderColor: '#4e73df',
                borderWidth: 1,
                borderRadius: 6,
                barThickness: 50
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false
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

          // Date input validation
          document.getElementById('endDate').addEventListener('change', function() {
            const startDate = document.getElementById('startDate').value;
            const endDate = this.value;
            
            if(startDate && endDate && new Date(endDate) < new Date(startDate)) {
              alert('End date must be after start date');
              this.value = '';
            }
          });

          function validateAndRedirect() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (!startDate || !endDate) {
              alert('Please select both dates');
              return;
            }
            
            window.location.href = '#';
          }
        </script>
<?php require './bottom.php'; ?>



       