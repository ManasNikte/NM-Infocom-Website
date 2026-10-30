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
            <div class="dashboard-charts-row">
                <div class="dashboard-chart-card">
                    <div class="dashboard-chart-header">Task Status</div>
                    <div class="dashboard-chart-body">
                        <div class="chart-container" style="height: 300px; width: 100%; position: relative;">
                            <canvas id="taskStatusChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-chart-footer">
                        <button class="btn custom-button" onclick="window.location.href='custom.php';">Custom</button>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <div class="dashboard-chart-header"><i class="zmdi zmdi-chart-bar mr-2"></i>Sales Status Trends</div>
                    <div class="dashboard-chart-body">
                        <div class="chart-container" style="height: 300px; width: 100%; position: relative;">
                            <canvas id="salesStatusBarChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-chart-footer">
                        <button class="btn custom-button" onclick="window.location.href='custom1.php';">Custom</button>
                    </div>
                </div>
            </div>

            <!-- Task List Section -->
            <div class="row flex-column">
                <div class="col-md-12">
                    <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                        <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                            <h3 class="mb-0 text-white"><i class="fas fa-list mr-2"></i>To Do List</h3>
                            <small class="text-white-50 ml-3">Manage your tasks</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-4 align-items-end">
                                <div class="col-md-6 col-lg-6 mb-2 mb-md-0">
                                    <div class="input-group">
                                        <input type="text" id="tableSearch" class="form-control custom-input" placeholder="Search in table...">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="zmdi zmdi-search"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    <div class="dropdown w-100">
                                        <button class="btn custom-input custom-select custom-dropdown-btn w-100" data-toggle="dropdown" style="text-align:left;">
                                            <i class="fas fa-tasks mr-2 text-secondary"></i>All Tasks
                                        </button>
                                        <div class="dropdown-menu custom-dropdown-menu w-100">
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
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2 table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-primary text-center">Task ID</th>
                                            <th class="text-primary text-center">Task</th>
                                            <th class="text-primary text-center">Date Added</th>
                                            <th class="text-primary text-center">Due Date</th>
                                            <th class="text-primary text-center">Date of Completion</th>
                                            <th class="text-primary text-center">Status</th>
                                            <th class="text-primary text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Load tasks from database for the current user

                                        try {

                                            $db = new Database();
                                            $conn = $db->getConnection();

                                            // Get initial tasks for the current user
                                            $sql = "SELECT id, task, date_added, due_date, date_of_completion, status 
                                                    FROM tasks 
                                                    WHERE assigned_to = :user_id 
                                                    ORDER BY date_added DESC";
                                            
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute([':user_id' => $user_id]);
                                            
                                            $tasks = [];
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $tasks[] = [
                                                    '#TASK' . str_pad($row['id'], 3, '0', STR_PAD_LEFT),
                                                    $row['task'],
                                                    date('M d, Y', strtotime($row['date_added'])),
                                                    date('M d, Y', strtotime($row['due_date'])),
                                                    $row['date_of_completion'] ? date('M d, Y', strtotime($row['date_of_completion'])) : '-',
                                                    ucfirst($row['status'])
                                                ];
                                            }

                                            // Pagination variables
                                            $items_per_page = 6;
                                            $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                                            $total_items = count($tasks);
                                            $total_pages = ceil($total_items / $items_per_page);
                                            $offset = ($current_page - 1) * $items_per_page;

                                            // Get tasks for current page
                                            $current_tasks = array_slice($tasks, $offset, $items_per_page);

                                                                                        foreach ($current_tasks as $task) {
                                                $enumToDisplay = [
                                                    'pending' => 'Pending',
                                                    'in progress' => 'In Progress',
                                                    'completed' => 'Completed'
                                                ];
                                                $enumStatus = strtolower($task[5]);
                                                $displayStatus = $enumToDisplay[$enumStatus] ?? ucfirst($enumStatus);
                                                $statusClass = match($enumStatus) {
                                                    'completed' => 'success',
                                                    'pending' => 'warning',
                                                    'in progress' => 'info',
                                                    default => 'secondary'
                                                };
                                                $taskId = str_replace('#TASK', '', $task[0]);
                                                $task = array_map(fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES), $task);
                                                $taskId = (int) $taskId;
                                                echo "<tr style='transition: all 0.3s ease;'>
                                                    <td class='px-4'><span class='font-weight-bold'>{$task[0]}</span></td>
                                                    <td>{$task[1]}</td>
                                                    <td>{$task[2]}</td>
                                                    <td>{$task[3]}</td>
                                                    <td>{$task[4]}</td>
                                                    <td><span class='badge badge-soft-{$statusClass}' style='padding: 8px 12px; font-weight: 500; border-radius: 20px;' data-enum-status='{$enumStatus}'>{$displayStatus}</span></td>
                                                    <td class='text-right px-4'>";
                                                // Always show the dropdown, even for completed
                                                echo "<div class='dropdown'>
                                                    <select class='form-control status-select' data-task-id='{$taskId}' data-original-status='{$enumStatus}'
                                                        style='width: 160px; background-color: white; border: 1px solid #e3e6f0; border-radius: 20px; padding: 8px 15px; font-size: 0.875rem; color: #6e707e; cursor: pointer; appearance: none; -webkit-appearance: none; background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236e707e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 15px center; background-size: 12px;'>
                                                        <option value='pending'" . ($enumStatus === 'pending' ? ' selected' : '') . ">🕒 Pending</option>
                                                        <option value='in progress'" . ($enumStatus === 'in progress' ? ' selected' : '') . ">🔄 In Progress</option>
                                                        <option value='completed'" . ($enumStatus === 'completed' ? ' selected' : '') . ">✅ Completed</option>
                                                    </select>
                                                </div>";
                                                echo "</td></tr>";
                                            }
                                        } catch (Exception $e) {
                                            // Handle error gracefully
                                            echo "<tr><td colspan='7' class='text-center text-muted'>No tasks found or error loading tasks.</td></tr>";
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
                                    <?php if ($total_items > 0): ?>
                                        Showing <span class="font-weight-bold"><?= $offset + 1 ?></span> to 
                                        <span class="font-weight-bold"><?= min($offset + $items_per_page, $total_items) ?></span> of 
                                        <span class="font-weight-bold"><?= $total_items ?></span> entries
                                    <?php else: ?>
                                        No tasks found
                                    <?php endif; ?>
                                </div>
                                <?php if ($total_items > 0): ?>
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
                                <?php endif; ?>
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

                .dashboard-charts-row {
                    display: flex;
                    flex-wrap: wrap;
                    width: 100%;
                    margin-bottom: 32px;
                    gap: 24px;
                }
                .dashboard-chart-card {
                    flex: 1 1 0;
                    min-width: 0;
                    max-width: 50%;
                    background: linear-gradient(145deg, #ffffff, #f5f7ff);
                    border-radius: 20px;
                    box-shadow: 0 4px 24px rgba(30, 34, 90, 0.08);
                    margin-bottom: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: stretch;
                }
                .dashboard-chart-header {
                    width: 100%;
                    border-radius: 20px 20px 0 0;
                    background: linear-gradient(45deg, #1a237e, #4e73df);
                    color: #fff;
                    font-family: 'Nunito', sans-serif;
                    font-size: 1.15rem;
                    font-weight: 700;
                    letter-spacing: 0.5px;
                    padding: 18px 0 12px 0;
                    text-align: center;
                    margin-bottom: 0;
                }
                .dashboard-chart-body {
                    flex: 1 1 auto;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 18px 18px 0 18px;
                }
                .dashboard-chart-footer {
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 18px 0 24px 0;
                }
                .dashboard-chart-card .custom-button {
                    min-width: 120px;
                    font-size: 1rem;
                    margin: 0 auto;
                }
                @media (max-width: 992px) {
                    .dashboard-charts-row {
                        flex-direction: column;
                        gap: 16px;
                    }
                    .dashboard-chart-card {
                        max-width: 100%;
                    }
                }
            </style>
        </div>
    </div>
</div>

<!-- Add necessary JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart data; drawn on load. The To Do list below is rendered on the server,
        // so stale data means a quiet page reload (crmReloadWhenStale).
        function crmLoadCharts() {
            fetch('../../shared/task_status.php?mine=1')
                .then(response => response.json())
                .then(data => {
                    initPieChart(data);
                });
        }
        crmLoadCharts();
        crmReloadWhenStale();

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

        // Enhanced search and filter functionality
        const searchInput = document.getElementById('tableSearch');
        const searchButton = document.querySelector('.btn-primary');
        const paginationInfo = document.querySelector('.text-muted');
        
        function updateTableDisplay() {
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            const tableRows = document.querySelectorAll('tbody tr');
            let visibleCount = 0;
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                row.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });
            
            // Update pagination info
            if (paginationInfo) {
                if (visibleCount === 0) {
                    paginationInfo.innerHTML = 'No tasks found';
                } else {
                    paginationInfo.innerHTML = `Showing <span class="font-weight-bold">1</span> to 
                        <span class="font-weight-bold">${visibleCount}</span> of 
                        <span class="font-weight-bold">${visibleCount}</span> entries`;
                }
            }
        }
        
        if (searchInput) {
            searchInput.addEventListener('input', updateTableDisplay);
        }
        
        if (searchButton) {
            searchButton.addEventListener('click', updateTableDisplay);
        }

        // Status filter functionality
        document.querySelectorAll('.filter-status').forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                const status = this.getAttribute('data-status');
                const tableRows = document.querySelectorAll('tbody tr');
                let visibleCount = 0;
                
                tableRows.forEach(row => {
                    const statusCell = row.querySelector('td:nth-child(6)');
                    if (statusCell) {
                        const rowStatus = statusCell.textContent.trim();
                        const isVisible = status === 'all' || rowStatus === status;
                        row.style.display = isVisible ? '' : 'none';
                        if (isVisible) visibleCount++;
                    }
                });
                
                // Update pagination info
                if (paginationInfo) {
                    if (visibleCount === 0) {
                        paginationInfo.innerHTML = 'No tasks found';
                    } else {
                        paginationInfo.innerHTML = `Showing <span class="font-weight-bold">1</span> to 
                            <span class="font-weight-bold">${visibleCount}</span> of 
                            <span class="font-weight-bold">${visibleCount}</span> entries`;
                    }
                }
                
                // Update dropdown button text
                const dropdownBtn = document.querySelector('.custom-dropdown-btn');
                if (dropdownBtn) {
                    dropdownBtn.innerHTML = this.innerHTML;
                }
            });
        });

        // Task status update functionality using new data file
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const taskId = this.getAttribute('data-task-id');
                const newStatus = this.value;
                const originalStatus = this.getAttribute('data-original-status');
                this.disabled = true;
                const formData = new FormData();
                formData.append('task_id', taskId);
                formData.append('new_status', newStatus);
                fetch('../../shared/update_my_task.php', {
                    method: 'POST',
                    body: formData
                })
                .then(async response => {
                    let data;
                    try {
                        data = await response.json();
                    } catch (e) {
                        console.error('Failed to parse JSON:', e, response);
                        throw new Error('Invalid JSON response');
                    }
                    console.log('Backend response:', data);
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Task status updated successfully',
                            timer: 1500,
                            showConfirmButton: false,
                            position: 'top-end',
                            toast: true
                        }).then(() => {
                            window.location.reload();
                        });
                        this.setAttribute('data-original-status', newStatus);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.error || 'Failed to update task status',
                            timer: 3000,
                            showConfirmButton: false,
                            position: 'top-end',
                            toast: true
                        });
                        this.value = originalStatus || 'pending';
                        console.error('Task status update failed:', data.error);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error!',
                        text: 'Failed to update task status. Please try again.',
                        timer: 3000,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });
                    this.value = originalStatus || 'pending';
                    console.error('Fetch/network error:', error);
                })
                .finally(() => {
                    this.disabled = false;
                });
            });
        });

        // Add new JS for Sales Status Distribution Bar Chart
        function initSalesStatusBarChart() {
            const ctx = document.getElementById('salesStatusBarChart').getContext('2d');
            fetch('data/sales_status_bar_chart_data.php')
                .then(response => response.json())
                .then(data => {
                    if (!data.success) throw new Error('Failed to load sales status data');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: data.datasets.map(ds => ({
                                ...ds,
                                borderRadius: 6,
                                maxBarThickness: 40
                            }))
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.dataset.label}: ${context.parsed.y}`;
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
                            },
                            barPercentage: 0.7,
                            categoryPercentage: 0.6
                        }
                    });
                })
                .catch(err => {
                    ctx.font = '16px sans-serif';
                    ctx.fillText('Failed to load sales status data', 10, 50);
                });
        }
        // Call the function after DOM is loaded
        initSalesStatusBarChart();
    });
</script>


<?php require './bottom.php'; ?>



       
