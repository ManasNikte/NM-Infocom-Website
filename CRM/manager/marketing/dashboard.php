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
                    <div class="dashboard-chart-header">Employee Task Status</div>
                    <div class="dashboard-chart-body">
                        <div class="chart-container" style="height: 260px; width: 100%; position: relative;">
                            <canvas id="taskStatusChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-chart-footer">
                        <button class="btn custom-button" onclick="window.location.href='custom.php';">Custom</button>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <div class="dashboard-chart-header">Monthly Progress</div>
                    <div class="dashboard-chart-body">
                        <div class="chart-container" style="height: 260px; width: 100%; position: relative;">
                            <canvas id="customLineChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-chart-footer">
                        <button class="btn custom-button" onclick="window.location.href='custom1.php';">Custom</button>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <div class="dashboard-chart-header">Manager Task Status</div>
                    <div class="dashboard-chart-body">
                        <div class="chart-container" style="height: 260px; width: 100%; position: relative;">
                            <canvas id="managerTaskChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-chart-footer">
                        <button class="btn custom-button" onclick="window.location.href='custom2.php';">Custom</button>
                    </div>
                </div>
            </div>

            <!-- Task List Section (copied from main.php) -->
            <div class="row flex-column">
                <div class="col-md-12">
                    <!-- DATA TABLE 1: To Do List -->
                    <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                        <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                            <h3 class="mb-0 text-white"><i class="fas fa-list mr-2"></i>To Do List</h3>
                            <small class="text-white-50 ml-3">Manage your tasks</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-4 align-items-end">
                                <div class="col-md-6 col-lg-6 mb-2 mb-md-0">
                                    <div class="input-group">
                                        <input type="text" id="taskSearchInput" class="form-control custom-input" placeholder="Search tasks...">
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
                                        </tr>
                                    </thead>
                                    <tbody id="todoTableBody"></tbody>
                                </table>
                            </div>
                            <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                                <div class="text-muted" id="todoTableInfo"></div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0" id="todoTablePagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- END DATA TABLE 1 -->

                    <!-- DATA TABLE 2: Marketing Employee Tasks -->
                    <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff); margin-bottom: 48px !important;">
                        <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                            <h3 class="mb-0 text-white"><i class="fas fa-users mr-2"></i>Marketing Employee Tasks</h3>
                            <small class="text-white-50 ml-3">Assign and track employee tasks</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-4 align-items-end flex-nowrap" style="gap: 12px; flex-wrap: wrap;">
                                <div class="d-flex align-items-center flex-grow-1" style="gap: 8px; min-width: 320px;">
                                    <div class="input-group flex-nowrap" style="min-width: 220px;">
                                        <input type="text" id="employeeTaskSearchInput" class="form-control custom-input" placeholder="Search tasks...">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="zmdi zmdi-search"></i></span>
                                        </div>
                                    </div>
                                    <div class="dropdown" style="min-width: 150px;">
                                        <button class="btn custom-input custom-select employee-custom-dropdown-btn w-100" data-toggle="dropdown" style="text-align:left;">
                                            <i class="fas fa-tasks mr-2 text-secondary"></i>All Tasks
                                        </button>
                                        <div class="dropdown-menu custom-dropdown-menu w-100">
                                            <a class="dropdown-item employee-filter-status" data-status="all" href="#">
                                                <i class="fas fa-tasks mr-2 text-secondary"></i>All Tasks
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item employee-filter-status" data-status="Pending" href="#">
                                                <i class="far fa-clock mr-2 text-warning"></i>Pending
                                            </a>
                                            <a class="dropdown-item employee-filter-status" data-status="In Progress" href="#">
                                                <i class="fas fa-spinner mr-2 text-info"></i>In Progress
                                            </a>
                                            <a class="dropdown-item employee-filter-status" data-status="Completed" href="#">
                                                <i class="fas fa-check-circle mr-2 text-success"></i>Completed
                                            </a>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-secondary" id="clearEmployeeTaskSearch" title="Clear search" style="min-width:48px;"><i class="zmdi zmdi-close"></i></button>
                                </div>
                                <div class="d-flex align-items-center justify-content-end" style="min-width: 180px; flex-shrink: 0; margin-left: auto;">
                                    <button class="btn custom-button btn-block w-100" id="assignTaskBtn"><i class="fas fa-plus mr-1"></i>Assign New Task</button>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2 table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-primary text-center">Task ID</th>
                                            <th class="text-primary text-center">Employee Name</th>
                                            <th class="text-primary text-center">Task</th>
                                            <th class="text-primary text-center">Date Added</th>
                                            <th class="text-primary text-center">Due Date</th>
                                            <th class="text-primary text-center">Date of Completion</th>
                                            <th class="text-primary text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="employeeTasksTableBody"></tbody>
                                </table>
                            </div>
                            <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                                <div class="text-muted" id="employeeTasksInfo"></div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0" id="employeeTasksPagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- END DATA TABLE 2 -->
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

                .custom-input {
                    border-radius: 15px;
                    border: 2px solid #e3e6f0;
                    padding: 12px;
                    font-size: 1rem;
                    transition: box-shadow 0.2s, border-color 0.2s;
                }
                .custom-input:focus {
                    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
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
                    color: #fff;
                }
                .custom-button:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(78, 115, 223, 0.3);
                    background: linear-gradient(45deg, #4e73df, #1a237e);
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
                .table-responsive-data2 {
                    overflow-x: auto;
                    display: flex;
                    justify-content: center;
                    padding: 0;
                    margin: 0;
                }
                .table-data2 {
                    min-width: 900px;
                    max-width: 1000px;
                    width: 100%;
                    margin-left: auto;
                    margin-right: auto;
                    table-layout: fixed;
                    border-collapse: separate;
                    border-spacing: 0;
                }
                .table-data2 td, .table-data2 th {
                    white-space: normal !important;
                    overflow: visible !important;
                    text-overflow: initial !important;
                    word-break: break-word;
                    padding: 12px 8px !important;
                    vertical-align: middle !important;
                    font-size: 0.98rem;
                    line-height: 1.5;
                }
                .table-data2 thead th {
                    font-weight: 600;
                    background-color: #f8f9fa;
                    border-bottom: 2px solid #dee2e6;
                    vertical-align: middle !important;
                    position: sticky;
                    top: 0;
                    z-index: 1;
                    padding: 14px 8px !important;
                }
                .tr-shadow {
                    height: auto !important;
                    border-radius: 8px;
                    transition: all 0.3s;
                }
                .tr-shadow:hover {
                    background-color: #f8f9fa;
                    transform: translateY(-1px);
                    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                }
                .spacer {
                    height: 4px;
                }
                .status--process {
                    padding: 4px 12px;
                    border-radius: 12px;
                    font-weight: 500;
                    font-size: 13px;
                    display: inline-block;
                    text-align: center;
                    min-width: 80px;
                }
                .status--process.approved {
                    background-color: #28a745;
                    color: white;
                }
                .status--process.rejected {
                    background-color: #dc3545;
                    color: white;
                }
                .status--process.pending {
                    background-color: #ffc107;
                    color: #000;
                }
                .pagination {
                    margin: 0;
                }
                #showingEntries {
                    font-size: 0.9rem;
                }
                @media (max-width: 992px) {
                    .main-content {
                        min-height: 100vh;
                    }
                    .container-fluid {
                        min-height: 90vh;
                    }
                    .card {
                        margin-bottom: 32px !important;
                    }
                    .table-data2 {
                        min-width: 800px;
                    }
                    .table-data2 td, .table-data2 th {
                        padding: 10px 6px !important;
                        font-size: 0.92rem;
                    }
                    .card-header, .card-body {
                        padding: 1rem;
                    }
                }
                @media (max-width: 768px) {
                    .table-data2 {
                        min-width: 600px;
                        font-size: 0.9rem;
                    }
                    .table-data2 th, .table-data2 td {
                        padding: 8px 4px !important;
                    }
                    .card-header, .card-body {
                        padding: 0.7rem;
                    }
                }
                @media (max-width: 576px) {
                    .table-data2 {
                        min-width: 400px;
                        font-size: 0.88rem;
                    }
                    .d-flex {
                        flex-direction: column;
                        gap: 1rem;
                    }
                    .showing-entries {
                        text-align: center;
                    }
                    .pagination {
                        justify-content: center;
                    }
                    .card-header h3, .card-header small {
                        font-size: 1.1rem;
                    }
                    .card {
                        margin-bottom: 24px !important;
                    }
                }
                .custom-select {
                    border-radius: 15px;
                    border: 2px solid #e3e6f0;
                    padding: 12px 40px 12px 16px;
                    font-size: 1rem;
                    background: #fff url('data:image/svg+xml;utf8,<svg fill="%234e73df" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7.293 7.293a1 1 0 011.414 0L10 8.586l1.293-1.293a1 1 0 111.414 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z"/></svg>') no-repeat right 16px center/20px 20px;
                    appearance: none;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    transition: box-shadow 0.2s, border-color 0.2s;
                    min-height: 48px;
                    line-height: 24px;
                    height: 48px;
                    box-sizing: border-box;
                }
                .custom-select:focus {
                    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
                    border-color: #4e73df;
                    outline: none;
                }
                .custom-select::-ms-expand {
                    display: none;
                }
                .table-data2 th, .table-data2 td {
                    text-align: center !important;
                }
                .dashboard-charts-row {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 32px;
                    margin-bottom: 32px;
                    justify-content: center;
                }
                .dashboard-chart-card {
                    flex: 1 1 320px;
                    max-width: 370px;
                    min-width: 280px;
                    min-height: 420px;
                    background: linear-gradient(135deg, #f5f7ff 60%, #e3e6f0 100%);
                    border-radius: 24px;
                    box-shadow: 0 8px 32px rgba(44, 62, 80, 0.13);
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: flex-start;
                    padding: 0;
                    margin: 0;
                    position: relative;
                    transition: box-shadow 0.3s, transform 0.3s;
                }
                .dashboard-chart-card:hover {
                    box-shadow: 0 16px 40px rgba(44, 62, 80, 0.18);
                    transform: translateY(-4px) scale(1.02);
                }
                .dashboard-chart-header {
                    width: 100%;
                    border-radius: 24px 24px 0 0;
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
                @media (max-width: 1200px) {
                    .dashboard-charts-row {
                        gap: 20px;
                    }
                    .dashboard-chart-card {
                        max-width: 320px;
                        min-width: 220px;
                        min-height: 340px;
                    }
                }
                @media (max-width: 900px) {
                    .dashboard-charts-row {
                        flex-wrap: wrap;
                        gap: 16px;
                    }
                    .dashboard-chart-card {
                        flex: 1 1 45%;
                        max-width: 48%;
                        min-width: 220px;
                        margin-bottom: 18px;
                    }
                }
                @media (max-width: 600px) {
                    .dashboard-charts-row {
                        flex-direction: column;
                        gap: 16px;
                    }
                    .dashboard-chart-card {
                        max-width: 100%;
                        min-width: 0;
                        width: 100%;
                        margin-bottom: 12px;
                    }
                }
                .dashboard-main-title {
                    font-family: 'Nunito', sans-serif;
                    font-size: 2.3rem;
                    font-weight: 800;
                    letter-spacing: 1px;
                    text-align: center;
                    margin-top: 0px;
                    margin-bottom: 36px;
                    background: linear-gradient(45deg, #1a237e, #4e73df);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    color: transparent;
                    line-height: 1.1;
                }
                @media (max-width: 600px) {
                    .dashboard-main-title {
                        font-size: 1.5rem;
                        margin-top: 18px;
                        margin-bottom: 22px;
                    }
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

        
            // Load pie chart data
            fetch('../../shared/task_status.php')
                .then(response => response.json())
                .then(data => {
                    initPieChart(data);
                });
        
            // Load pie chart data for Manager Tasks
            fetch('../../shared/task_status.php?mine=1')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${esc(response.status)}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    initPieChartManager('managerTaskChart', data);
                })
                .catch(error => console.error('Error fetching data:', error));


        }
        crmLoadCharts();
        crmLiveRefresh(crmLoadCharts);

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

        function initPieChartManager(chartId, data) {
            if (!data || !data.colors || typeof data.colors !== 'object') {
                console.error('Invalid data for pie chart:', data);
                return;
            }

            const canvas = document.getElementById(chartId);
            if (!canvas) {
                console.error(`Canvas element not found: ${chartId}`);
                return;
            }
            const taskStatusCtx = canvas.getContext('2d');

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
                            display: true
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
    });
</script>

<script>
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

// Task Table AJAX logic
        let currentPage = 1;
        let currentStatus = 'all';
let currentSearch = '';
const itemsPerPage = 6;

function fetchTasks(page = 1, search = '', status = 'all') {
    const tableBody = document.getElementById('todoTableBody');
    tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
    fetch(`../../shared/my_tasks.php?page=${page}&search=${encodeURIComponent(search)}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderTasks(data.data.tasks);
                renderPagination(data.data.pagination);
            } else {
                tableBody.innerHTML = '<tr><td colspan="7">No tasks found.</td></tr>';
                document.getElementById('todoTableInfo').textContent = 'No tasks found';
                document.getElementById('todoTablePagination').innerHTML = '';
            }
        })
        .catch(() => {
            tableBody.innerHTML = '<tr><td colspan="7">Error loading tasks.</td></tr>';
            document.getElementById('todoTableInfo').textContent = 'Error loading tasks';
            document.getElementById('todoTablePagination').innerHTML = '';
        });
}

function renderTasks(tasks) {
    const tableBody = document.getElementById('todoTableBody');
    tableBody.innerHTML = '';
    if (!tasks.length) return;
    const fragment = document.createDocumentFragment();
    tasks.forEach(task => {
        const statusClass = {
            'Completed': 'success',
            'Pending': 'warning',
            'In Progress': 'info'
        }[task[5]] || 'secondary';
        // Format dates (assume YYYY-MM-DD or YYYY-MM-DD HH:MM:SS)
        function formatDate(dateStr) {
            if (!dateStr || dateStr === '-') return '-';
            const d = new Date(dateStr);
            if (isNaN(d)) return dateStr;
            return d.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
        }
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class='px-4'><span class='font-weight-bold'>${esc(task[0])}</span></td>
            <td>${esc(task[1])}</td>
            <td>${formatDate(task[2])}</td>
            <td>${formatDate(task[3])}</td>
            <td>${formatDate(task[4])}</td>
            <td>
                <div class='dropdown'>
                    <select class='form-control status-select' style='width: 160px; border-radius: 20px;' data-task-id='${esc(task[0])}'>
                        <option value='Pending' ${esc((task[5] && task[5].toLowerCase() === 'pending') ? 'selected' : '')}>🕒 Pending</option>
                        <option value='In Progress' ${esc((task[5] && task[5].toLowerCase() === 'in progress') ? 'selected' : '')}>🔄 In Progress</option>
                        <option value='Completed' ${esc((task[5] && task[5].toLowerCase() === 'completed') ? 'selected' : '')}>✅ Completed</option>
                    </select>
                </div>
            </td>`;
        fragment.appendChild(tr);
    });
    tableBody.appendChild(fragment);

    // Add event listeners for status select
    tableBody.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const taskId = this.getAttribute('data-task-id');
            const newStatus = this.value;
            this.disabled = true;
            fetch('../../shared/update_my_task.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `task_id=${encodeURIComponent(taskId)}&new_status=${encodeURIComponent(newStatus)}`
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    toastr.success('Task status updated');
                    fetchTasks(currentPage, currentSearch, currentStatus);
                } else {
                    toastr.error(res.error || 'Failed to update status');
                    this.disabled = false;
                }
            })
            .catch(() => {
                toastr.error('Failed to update status');
                this.disabled = false;
            });
        });
    });
}

function renderPagination(pagination) {
    const paginationInfo = document.getElementById('todoTableInfo');
    const paginationContainer = document.getElementById('todoTablePagination');
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
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
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
                    fetchTasks(currentPage, currentSearch, currentStatus);
                        }
                    });
                });
            }
        }

        // Status filter functionality
        document.querySelectorAll('.filter-status').forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                currentStatus = this.getAttribute('data-status');
            currentPage = 1;
                // Update dropdown button text
                const dropdownBtn = document.querySelector('.custom-dropdown-btn');
            if (dropdownBtn) {
                dropdownBtn.innerHTML = this.innerHTML;
            }
            fetchTasks(currentPage, currentSearch, currentStatus);
                });
            });
// Initial load
fetchTasks(currentPage, currentSearch, currentStatus);
document.addEventListener('DOMContentLoaded', function () {
    // Fetch and render the line chart for Monthly Progress
    fetch('data/line_chart_data.php?ajax=true')
        .then(response => response.json())
        .then(data => {
            initLineChart(data);
        })
        .catch(() => {
            // Optionally, handle error (e.g., show a message or empty chart)
        });

    function initLineChart(data) {
        const ctx = document.getElementById('customLineChart').getContext('2d');
        const labels = Array.isArray(data.months) ? data.months : [];
        const values = Array.isArray(data.values) ? data.values : [];
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.25)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0.01)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Leads',
                    data: values,
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#4e73df',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4e73df',
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255,255,255,0.95)',
                        titleColor: '#1a237e',
                        bodyColor: '#4e73df',
                        borderColor: '#4e73df',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                return `Leads: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        grid: {
                            color: 'rgba(78, 115, 223, 0.08)',
                            borderDash: [4, 4],
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 13,
                                weight: 'bold'
                            },
                            color: '#1a237e',
                            stepSize: 1,
                            callback: function (value) {
                                return Number.isInteger(value) ? value : '';
                            },
                            precision: 0
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 13,
                                weight: 'bold'
                            },
                            color: '#4e73df'
                        }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutCubic'
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
});

// Search bar event listener (debounced)
document.getElementById('taskSearchInput').addEventListener('input', debounce(function(e) {
    currentSearch = e.target.value.trim();
    currentPage = 1;
    fetchTasks(currentPage, currentSearch, currentStatus);
}, 300));

// Fetch and render Marketing Employee Tasks
let employeeTaskSearch = '';
let employeeTaskStatus = 'all';
let employeeTaskPage = 1;

function fetchEmployeeTasks(page = 1) {
    employeeTaskPage = page;
    const tableBody = document.getElementById('employeeTasksTableBody');
    tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
    fetch(`data/employee_task_table_data.php?search=${encodeURIComponent(employeeTaskSearch)}&status=${encodeURIComponent(employeeTaskStatus)}&page=${page}`)
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = '';
            if (data.success && data.tasks.length) {
                data.tasks.forEach(task => {
                    let status = (task[6] || '').toLowerCase();
                    let badgeClass = '';
                    let badgeStyle = '';
                    let badgeText = task[6];
                    if (status === 'pending') {
                        badgeClass = 'badge';
                        badgeStyle = 'background-color: #ffc107; color: #fff; font-size: 1em; padding: 6px 16px; border-radius: 16px;';
                    } else if (status === 'in progress') {
                        badgeClass = 'badge badge-primary';
                        badgeStyle = 'font-size: 1em; padding: 6px 16px; border-radius: 16px;';
                    } else if (status === 'completed') {
                        badgeClass = 'badge badge-success';
                        badgeStyle = 'font-size: 1em; padding: 6px 16px; border-radius: 16px;';
                    } else {
                        badgeClass = 'badge badge-secondary';
                        badgeStyle = 'font-size: 1em; padding: 6px 16px; border-radius: 16px;';
                    }
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class='px-4'><span class='font-weight-bold'>${esc(task[0])}</span></td>
                        <td>${esc(task[1])}</td>
                        <td>${esc(task[2])}</td>
                        <td>${esc(task[3])}</td>
                        <td>${esc(task[4])}</td>
                        <td>${esc(task[5])}</td>
                        <td><span class='${badgeClass}' style='${badgeStyle}'>${badgeText}</span></td>
                    `;
                    tableBody.appendChild(tr);
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No tasks found.</td></tr>';
            }
            renderEmployeeTasksPagination(data.pagination);
        })
        .catch(() => {
            tableBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error loading employee tasks.</td></tr>';
            renderEmployeeTasksPagination({});
        });
}

function renderEmployeeTasksPagination(pagination) {
    const info = document.getElementById('employeeTasksInfo');
    const container = document.getElementById('employeeTasksPagination');
    if (!pagination || !pagination.total_items) {
        info.textContent = 'No matching records found';
        container.innerHTML = '';
        return;
    }
    info.innerHTML = `Showing <span class="font-weight-bold">${esc(pagination.showing_start)}</span> to <span class="font-weight-bold">${esc(pagination.showing_end)}</span> of <span class="font-weight-bold">${esc(pagination.total_items)}</span> entries`;
    let html = '';
    // Previous button
    html += `<li class="page-item ${pagination.current_page <= 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${esc(pagination.current_page - 1)}"><i class="fas fa-chevron-left"></i></a></li>`;
    // Page numbers
    for (let i = 1; i <= pagination.total_pages; i++) {
        if (i === 1 || i === pagination.total_pages || (i >= pagination.current_page - 2 && i <= pagination.current_page + 2)) {
            html += `<li class="page-item ${esc(pagination.current_page === i ? 'active' : '')}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        } else if (i === pagination.current_page - 3 || i === pagination.current_page + 3) {
            html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    // Next button
    html += `<li class="page-item ${esc(pagination.current_page >= pagination.total_pages ? 'disabled' : '')}"><a class="page-link" href="#" data-page="${esc(pagination.current_page + 1)}"><i class="fas fa-chevron-right"></i></a></li>`;
    container.innerHTML = html;
    container.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = parseInt(this.getAttribute('data-page'));
            if (page && page !== employeeTaskPage) {
                fetchEmployeeTasks(page);
            }
        });
    });
}

document.getElementById('employeeTaskSearchInput').addEventListener('input', debounce(function(e) {
    employeeTaskSearch = e.target.value.trim();
    fetchEmployeeTasks(1);
}, 300));

document.querySelectorAll('.employee-filter-status').forEach(filter => {
    filter.addEventListener('click', function(e) {
        e.preventDefault();
        employeeTaskStatus = this.getAttribute('data-status');
        const dropdownBtn = document.querySelector('.employee-custom-dropdown-btn');
        if (dropdownBtn) {
            dropdownBtn.innerHTML = this.innerHTML;
        }
        fetchEmployeeTasks(1);
    });
});

document.getElementById('clearEmployeeTaskSearch').addEventListener('click', function() {
    document.getElementById('employeeTaskSearchInput').value = '';
    employeeTaskSearch = '';
    fetchEmployeeTasks(1);
});

// Call on page load
fetchEmployeeTasks();
// Keep both task tables current without polling.
crmLiveRefresh(function () {
    fetchTasks(currentPage, currentSearch, currentStatus);
    fetchEmployeeTasks(employeeTaskPage);
});

document.getElementById('assignTaskBtn').addEventListener('click', function () {
    crmAssignTask({ base: '../../', assignUrl: '../../shared/assign_task.php', onDone: function () { fetchEmployeeTasks(); } });
});
</script>

<?php require './bottom.php'; ?>



       
