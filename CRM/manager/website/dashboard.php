<?php
require_once './top.php';
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Dashboard Header -->
            <?php require __DIR__ . '/../../layout/dashboard_hero.php'; ?>

            <!-- Charts Row -->
            <div class="row mb-4">
                
                <!-- Tasks Pie Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                        <div class="card-header border-0 bg-transparent pt-4 px-4">
                            <h4 class="text-gradient mb-0" style="background: linear-gradient(45deg, #1a237e, #4e73df); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">Task Status</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="chart-container" style="height: 300px; position: relative;">
                                <canvas id="taskStatusChart"></canvas>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button 
                                    style="background-color: #007BFF; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; box-shadow: 0 2px 5px rgba(0,123,255,0.3); transition: all 0.3s ease;" 
                                    onmouseover="this.style.backgroundColor='#0056b3'; this.style.transform='translateY(-2px)';" 
                                    onmouseout="this.style.backgroundColor='#007BFF'; this.style.transform='translateY(0)';" 
                                    onclick="window.location.href='custom.php';">
                                    Custom
                                </button>
                            </div>
                        </div>
                    </div>
                </div> 
                
                <!-- Leads Bar Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                        <div class="card-header border-0 bg-transparent pt-4 px-4">
                            <h4 class="text-gradient mb-0" style="background: linear-gradient(45deg, #1a237e, #4e73df); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">Monthly Progress</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="chart-container" style="height: 300px; position: relative;">
                                <canvas id="customBarChart"></canvas>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button 
                                    style="background-color: #007BFF; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; box-shadow: 0 2px 5px rgba(0,123,255,0.3); transition: all 0.3s ease;" 
                                    onmouseover="this.style.backgroundColor='#0056b3'; this.style.transform='translateY(-2px)';" 
                                    onmouseout="this.style.backgroundColor='#007BFF'; this.style.transform='translateY(0)';" 
                                    onclick="window.location.href='custom1.php';">
                                    Custom
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task List Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg" style="border-radius: 15px; border: none; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                        <div class="card-header bg-white py-3" style="border-bottom: 2px solid #f8f9fa; border-radius: 15px 15px 0 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="font-weight-bold text-primary mb-0">
                                    <i class="fas fa-list mr-2"></i>To Do List
                                </h6>
                                <div class="d-flex align-items-center">
                                    <!-- Search Box -->
                                    <div class="input-group input-group-sm mr-3" style="width: 250px;">
                                        <input type="text" id="tableSearch" class="form-control" 
                                            placeholder="Search in table..."
                                            style="border-radius: 20px 0 0 20px; border: 1px solid #e0e0e0;">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" style="border-radius: 0 20px 20px 0; box-shadow: 0 2px 5px rgba(0,123,255,0.3);">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Filter dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-light custom-dropdown-btn" data-toggle="dropdown" style="border-radius: 20px; padding: 8px 15px;">
                                            <i class="fas fa-tasks mr-2 text-secondary"></i>All Tasks
                                    </button>
                                        <div class="dropdown-menu custom-dropdown-menu">
                                            <a class="dropdown-item filter-status" data-status="all" href="#">
                                                <i class="fas fa-tasks mr-2 text-secondary"></i>All Tasks
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item filter-status" data-status="Pending" href="#">
                                                <i class="far fa-clock mr-2 text-warning"></i>Pending
                                            </a>
                                            <a class="dropdown-item filter-status" data-status="In Progress" href="#">
                                                <i class="fas fa-spinner mr-2 text-info"></i>In Progress
                                            </a>
                                            <a class="dropdown-item filter-status" data-status="Completed" href="#">
                                                <i class="fas fa-check-circle mr-2 text-success"></i>Completed
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-4">Task ID</th>
                                            <th>Task</th>
                                            <th>Date Added</th>
                                            <th>Due Date</th>
                                            <th>Date of Completion</th>
                                            <th>Status</th>
                                            <th class="text-right px-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tasks = [
                                                ['#TASK001', 'Complete market analysis report', 'Jan 10, 2024', 'Jan 15, 2024', '-', 'Pending'],
                                                ['#TASK002', 'Design social media campaign', 'Jan 08, 2024', 'Jan 20, 2024', 'Jan 18, 2024', 'Completed'],
                                                ['#TASK003', 'Prepare quarterly presentation', 'Jan 05, 2024', 'Jan 25, 2024', '-', 'In Progress'],
                                                ['#TASK004', 'Update website content', 'Jan 12, 2024', 'Jan 18, 2024', '-', 'Pending'],
                                                ['#TASK005', 'Create email newsletter', 'Jan 07, 2024', 'Jan 14, 2024', 'Jan 14, 2024', 'Completed'],
                                                ['#TASK006', 'Analyze competitor strategies', 'Jan 15, 2024', 'Jan 30, 2024', '-', 'In Progress'],
                                                ['#TASK007', 'Organize team workshop', 'Jan 03, 2024', 'Jan 10, 2024', 'Jan 10, 2024', 'Completed'],
                                                ['#TASK008', 'Draft client proposals', 'Jan 11, 2024', 'Jan 20, 2024', '-', 'Pending'],
                                                ['#TASK009', 'Review budget allocation', 'Jan 02, 2024', 'Jan 15, 2024', 'Jan 14, 2024', 'Completed'],
                                                ['#TASK010', 'Conduct staff performance reviews', 'Jan 13, 2024', 'Jan 22, 2024', '-', 'Pending'],
                                                ['#TASK011', 'Plan product launch', 'Jan 06, 2024', 'Jan 31, 2024', '-', 'In Progress'],
                                                ['#TASK012', 'Optimize website SEO', 'Jan 10, 2024', 'Jan 17, 2024', 'Jan 17, 2024', 'Completed'],
                                                ['#TASK013', 'Host client meeting', 'Jan 04, 2024', 'Jan 11, 2024', 'Jan 10, 2024', 'Completed'],
                                                ['#TASK014', 'Update employee handbook', 'Jan 09, 2024', 'Jan 16, 2024', '-', 'Pending'],
                                                ['#TASK015', 'Research new software tools', 'Jan 07, 2024', 'Jan 20, 2024', '-', 'In Progress'],
                                                ['#TASK016', 'Coordinate charity event', 'Jan 01, 2024', 'Jan 12, 2024', 'Jan 12, 2024', 'Completed'],
                                                ['#TASK017', 'Design new product logo', 'Jan 14, 2024', 'Jan 25, 2024', '-', 'Pending'],
                                                ['#TASK018', 'Set up employee training', 'Jan 02, 2024', 'Jan 18, 2024', 'Jan 18, 2024', 'Completed'],
                                                ['#TASK019', 'Develop new app feature', 'Jan 08, 2024', 'Jan 30, 2024', '-', 'In Progress'],
                                                ['#TASK020', 'Write press release', 'Jan 11, 2024', 'Jan 19, 2024', '-', 'Pending'],
                                                ['#TASK021', 'Fix website bugs', 'Jan 03, 2024', 'Jan 10, 2024', 'Jan 10, 2024', 'Completed'],
                                                ['#TASK022', 'Evaluate supplier contracts', 'Jan 06, 2024', 'Jan 15, 2024', '-', 'Pending'],
                                                ['#TASK023', 'Prepare tax documents', 'Jan 05, 2024', 'Jan 20, 2024', '-', 'In Progress'],
                                                ['#TASK024', 'Conduct market survey', 'Jan 09, 2024', 'Jan 19, 2024', 'Jan 18, 2024', 'Completed'],
                                                ['#TASK025', 'Upgrade office equipment', 'Jan 04, 2024', 'Jan 15, 2024', '-', 'Pending'],
                                                ['#TASK026', 'Write team performance report', 'Jan 13, 2024', 'Jan 22, 2024', '-', 'In Progress'],
                                                ['#TASK027', 'Draft annual business plan', 'Jan 01, 2024', 'Jan 28, 2024', '-', 'Pending'],
                                                ['#TASK028', 'Plan team-building activity', 'Jan 12, 2024', 'Jan 19, 2024', 'Jan 19, 2024', 'Completed'],
                                                ['#TASK029', 'Test software updates', 'Jan 10, 2024', 'Jan 18, 2024', '-', 'In Progress'],
                                                ['#TASK030', 'Arrange client onboarding', 'Jan 07, 2024', 'Jan 14, 2024', 'Jan 14, 2024', 'Completed'],
                                                ['#TASK031', 'Refine marketing strategy', 'Jan 02, 2024', 'Jan 20, 2024', '-', 'Pending'],
                                            ];


                                        // Pagination variables
                                        $items_per_page = 6;
                                        $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                                        $total_items = count($tasks);
                                        $total_pages = ceil($total_items / $items_per_page);
                                        $offset = ($current_page - 1) * $items_per_page;

                                        // Get tasks for current page
                                        $current_tasks = array_slice($tasks, $offset, $items_per_page);

                                        foreach ($current_tasks as $task) {
                                            $statusClass = match($task[5]) {
                                                'Completed' => 'success',
                                                'Pending' => 'warning',
                                                'In Progress' => 'info',
                                                default => 'secondary'
                                            };
                                            
                                            echo "<tr style='transition: all 0.3s ease;'>
                                                <td class='px-4'><span class='font-weight-bold'>{$task[0]}</span></td>
                                                <td>{$task[1]}</td>
                                                <td>{$task[2]}</td>
                                                <td>{$task[3]}</td>
                                                <td>{$task[4]}</td>
                                                <td><span class='badge badge-soft-{$statusClass}' style='padding: 8px 12px; font-weight: 500; border-radius: 20px;'>{$task[5]}</span></td>
                                                <td class='text-right px-4'>";
                                            
                                            if ($task[5] !== 'Completed') {
                                                echo "<div class='dropdown'>
                                                    <select class='form-control status-select' 
                                                        style='width: 160px; 
                                                            background-color: white;
                                                            border: 1px solid #e3e6f0;
                                                            border-radius: 20px;
                                                            padding: 8px 15px;
                                                            font-size: 0.875rem;
                                                            color: #6e707e;
                                                            cursor: pointer;
                                                            appearance: none;
                                                            -webkit-appearance: none;
                                                            background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236e707e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E\");
                                                            background-repeat: no-repeat;
                                                            background-position: right 15px center;
                                                            background-size: 12px;'>
                                                        <option value='Pending' " . ($task[5] === 'Pending' ? 'selected' : '') . ">🕒 Pending</option>
                                                        <option value='In Progress' " . ($task[5] === 'In Progress' ? 'selected' : '') . ">🔄 In Progress</option>
                                                        <option value='Completed'>✅ Completed</option>
                                                    </select>
                                                </div>";
                                            } else {
                                                echo "<div class='d-flex align-items-center justify-content-end'>
                                                    <i class='fas fa-check-circle text-success mr-2' style='font-size: 1.2rem;'></i>
                                                    <span class='text-success font-weight-medium'>Completed</span>
                                                </div>";
                                            }
                                            
                                            echo "</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Pagination -->
                        <div class="card-footer bg-white py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing <span class="font-weight-bold">0</span> to 
                                    <span class="font-weight-bold">0</span> of 
                                    <span class="font-weight-bold">0</span> entries
                                </div>
                                <nav>
                                    <ul class="pagination pagination-sm mb-0">
                                        <!-- Previous button -->
                                        <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $current_page - 1 ?>" <?= ($current_page <= 1) ? 'tabindex="-1"' : '' ?>>
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        
                                        <?php
                                        // Calculate range of pages to show
                                        $start_page = max(1, min($current_page - 2, $total_pages - 4));
                                        $end_page = min($total_pages, max(5, $current_page + 2));
                                        
                                        // Show first page if not in range
                                        if ($start_page > 1) {
                                            echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                            if ($start_page > 2) {
                                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                            }
                                        }
                                        
                                        // Show page numbers
                                        for ($i = $start_page; $i <= $end_page; $i++) {
                                            echo '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">
                                                    <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                                                </li>';
                                        }
                                        
                                        // Show last page if not in range
                                        if ($end_page < $total_pages) {
                                            if ($end_page < $total_pages - 1) {
                                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                            }
                                            echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                                        }
                                        ?>
                                        
                                        <!-- Next button -->
                                        <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $current_page + 1 ?>" <?= ($current_page >= $total_pages) ? 'tabindex="-1"' : '' ?>>
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add these styles -->
            <style>
                /* Essential Responsive Breakpoints */
                @media (max-width: 768px) {
                    .container-fluid {
                        padding: 15px;
                    }
                    
                    .chart-container {
                        height: 250px !important;
                    }
                    
                    .card {
                        margin-bottom: 15px;
                    }
                }

                @media (max-width: 576px) {
                    .chart-container {
                        height: 200px !important;
                    }
                }

                /* Chart Container */
                .chart-container {
                    position: relative;
                    margin: auto;
                    height: 100%;
                    width: 100%;
                }

                /* Card Hover Effects */
                .card {
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                .card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
                }

                .text-gradient {
                    background: linear-gradient(45deg, #1a237e, #4e73df);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
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
            </style>
        </div>
    </div>
</div>

<!-- Add necessary JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart data; re-run by crmLiveRefresh when the tab comes back or another tab saves a change.
        function crmLoadCharts() {
            // Load bar chart data
            fetch('./data/bar_chart_data.php?ajax=true')
                .then(response => response.json())
                .then(data => {
                    initBarChart(data);
                });

        
            // Load pie chart data
            fetch('../../shared/task_status.php')
                .then(response => response.json())
                .then(data => {
                    initPieChart(data);
                });
        
        }
        crmLoadCharts();
        crmLiveRefresh(crmLoadCharts);

        function initBarChart(data) {
            const customBarCtx = document.getElementById('customBarChart').getContext('2d');
            
            // Create gradient
            const customGradient = customBarCtx.createLinearGradient(0, 0, 0, 300);
            customGradient.addColorStop(0, 'rgba(78, 115, 223, 0.8)');
            customGradient.addColorStop(1, 'rgba(78, 115, 223, 0.1)');

            new Chart(customBarCtx, {
                type: 'bar',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Monthly Enquiries',
                        data: Object.values(data.values),
                        backgroundColor: customGradient,
                        borderColor: '#4e73df',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 'flex',
                        maxBarThickness: 40
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
        }

        function initPieChart(data) {
            const taskStatusCtx = document.getElementById('taskStatusChart').getContext('2d');
            
            // Create gradients
            const gradients = Object.entries(data.colors).map(([status, colors]) => {
                const gradient = taskStatusCtx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, colors[0]);
                gradient.addColorStop(1, colors[1]);
                return gradient;
            });

            new Chart(taskStatusCtx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: Object.values(data.values),
                        backgroundColor: gradients,
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverBorderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'start',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 13,
                                    weight: '600',
                                    family: "'Nunito', sans-serif"
                                },
                                usePointStyle: true,
                                pointStyle: 'circle',
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => ({
                                            text: label,
                                            fillStyle: gradients[i],
                                            strokeStyle: '#ffffff',
                                            lineWidth: 2,
                                            hidden: false,
                                            index: i,
                                            pointStyle: 'circle'
                                        }));
                                    }
                                    return [];
                                }
                            },
                            display: true // Ensure legend is displayed
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
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value}%`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Search and filter functionality
        const searchInput = document.getElementById('tableSearch');
        const tableBody = document.querySelector('tbody');
        let currentPage = 1;
        let currentStatus = 'all';

        function loadTasks(page = 1, search = '', status = 'all') {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `../../shared/my_tasks.php?page=${page}&search=${encodeURIComponent(search)}&status=${status}`, true);
            
            xhr.onload = function() {
                if (this.status === 200) {
                    try {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            updateTable(response.data.tasks);
                            updatePagination(response.data.pagination);
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }
                }
            };
            
            xhr.send();
        }


        function updateTable(tasks) {
            let html = '';
            tasks.forEach(task => {
                const statusClass = {
                    'Completed': 'success',
                    'Pending': 'warning',
                    'In Progress': 'info'
                }[task[5]] || 'secondary';
                
                html += `<tr style='transition: all 0.3s ease;'>
                    <td class='px-4'><span class='font-weight-bold'>${esc(task[0])}</span></td>
                    <td>${esc(task[1])}</td>
                    <td>${esc(task[2])}</td>
                    <td>${esc(task[3])}</td>
                    <td>${esc(task[4])}</td>
                    <td><span class='badge badge-soft-${statusClass}' style='padding: 8px 12px; font-weight: 500; border-radius: 20px;'>${esc(task[5])}</span></td>
                    <td class='text-right px-4'>`;
                
                if (task[5] !== 'Completed') {
                    html += `<div class='dropdown'>
                        <select class='form-control status-select' 
                            style='width: 160px; 
                                background-color: white;
                                border: 1px solid #e3e6f0;
                                border-radius: 20px;
                                padding: 8px 15px;
                                font-size: 0.875rem;
                                color: #6e707e;
                                cursor: pointer;
                                appearance: none;
                                -webkit-appearance: none;
                                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236e707e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                                background-repeat: no-repeat;
                                background-position: right 15px center;
                                background-size: 12px;'>
                            <option value='Pending' ${esc(task[5] === 'Pending' ? 'selected' : '')}>🕒 Pending</option>
                            <option value='In Progress' ${esc(task[5] === 'In Progress' ? 'selected' : '')}>🔄 In Progress</option>
                            <option value='Completed'>✅ Completed</option>
                        </select>
                    </div>`;
                } else {
                    html += `<div class='d-flex align-items-center justify-content-end'>
                        <i class='fas fa-check-circle text-success mr-2' style='font-size: 1.2rem;'></i>
                        <span class='text-success font-weight-medium'>Completed</span>
                    </div>`;
                }
                
                html += `</td></tr>`;
            });
            
            tableBody.innerHTML = html;
        }

        function updatePagination(pagination) {
            const paginationInfo = document.querySelector('.text-muted');
            const paginationContainer = document.querySelector('.pagination');
            
            // Update showing entries text
            if (paginationInfo) {
                if (pagination.total_items === 0) {
                    paginationInfo.textContent = 'No matching records found';
                } else {
                    paginationInfo.innerHTML = `Showing <span class="font-weight-bold">${esc(pagination.showing_start)}</span> to 
                        <span class="font-weight-bold">${esc(pagination.showing_end)}</span> of 
                        <span class="font-weight-bold">${esc(pagination.total_items)}</span> entries`;
                }
            }
            
            // Update pagination controls
            if (paginationContainer) {
                let html = '';
                
                // Previous button
                html += `<li class="page-item ${pagination.current_page <= 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${esc(pagination.current_page - 1)}">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>`;
                
                // Page numbers
                for (let i = 1; i <= pagination.total_pages; i++) {
                    if (i === 1 || i === pagination.total_pages || 
                        (i >= pagination.current_page - 2 && i <= pagination.current_page + 2)) {
                        html += `<li class="page-item ${esc(pagination.current_page === i ? 'active' : '')}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>`;
                    } else if (i === pagination.current_page - 3 || i === pagination.current_page + 3) {
                        html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }
                }
                
                // Next button
                html += `<li class="page-item ${esc(pagination.current_page >= pagination.total_pages ? 'disabled' : '')}">
                    <a class="page-link" href="#" data-page="${esc(pagination.current_page + 1)}">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>`;
                
                paginationContainer.innerHTML = html;
                
                // Add click events to pagination links
                paginationContainer.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = this.getAttribute('data-page');
                        if (page) {
                            currentPage = parseInt(page);
                            loadTasks(currentPage, searchInput.value, currentStatus);
                        }
                    });
                });
            }
        }

        // Add event listener for search with debounce
        searchInput.addEventListener('input', debounce(function(e) {
            currentPage = 1; // Reset to first page on search
            loadTasks(currentPage, e.target.value, currentStatus);
        }, 300));

        // Status filter functionality
        document.querySelectorAll('.filter-status').forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                currentStatus = this.getAttribute('data-status');
                currentPage = 1; // Reset to first page on filter change
                
                // Update dropdown button text
                const dropdownBtn = document.querySelector('.custom-dropdown-btn');
                dropdownBtn.innerHTML = this.innerHTML;
                
                loadTasks(currentPage, searchInput.value, currentStatus);
            });
        });

        // Initial load
        loadTasks(currentPage, '', 'all');
        crmLiveRefresh(function () { loadTasks(currentPage, searchInput.value, currentStatus); });
    });
</script>


<?php require './bottom.php'; ?>



       
