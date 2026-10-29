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
                    <div class="dashboard-chart-header">Applicants Overview</div>
                    <div class="dashboard-chart-body">
                        <div class="chart-container" style="height: 300px; width: 100%; position: relative;">
                            <canvas id="customBarChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-chart-footer">
                        <button class="btn custom-button" onclick="window.location.href='custom1.php';">Custom</button>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <div class="dashboard-chart-header">Manager Task Status</div>
                    <div class="dashboard-chart-body">
                        <div class="chart-container" style="height: 300px; width: 100%; position: relative;">
                            <canvas id="managerTaskChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-chart-footer">
                        <button class="btn custom-button" onclick="window.location.href='custom2.php';">Custom</button>
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
                                        <!-- Table rows will be dynamically loaded by JavaScript from data/tasks_data.php -->
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
                                    <ul class="pagination pagination-sm mb-0"><!-- filled by JavaScript -->
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
            </style>
        </div>
    </div>
</div>

<!-- Add necessary JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Applicants Overview Line Chart
        fetch('data/applicants_line_chart_data.php')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('customBarChart').getContext('2d');
                new Chart(ctx, {
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
            });

        
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

        function initPieChart(data) {
            if (!document.getElementById('taskStatusChart')) return; // HR has no employee task chart
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

        function refreshManagerTaskChart() {
            fetch('../../shared/task_status.php?mine=1')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${esc(response.status)}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Remove the old chart instance if it exists
                    if (window.managerTaskChartInstance) {
                        window.managerTaskChartInstance.destroy();
                    }
                    window.managerTaskChartInstance = initPieChartManager('managerTaskChart', data);
                })
                .catch(error => console.error('Error fetching manager tasks data:', error));
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
                const enumToDisplay = {
                    'pending': 'Pending',
                    'in progress': 'In Progress',
                    'completed': 'Completed'
                };
                const enumStatus = (task[5] || '').toLowerCase();
                const displayStatus = enumToDisplay[enumStatus] || task[5];
                const taskId = task[0]; // Already zero-padded, no prefix
                html += `<tr style='transition: all 0.3s ease;'>
                    <td class='px-4'><span class='font-weight-bold'>${taskId}</span></td>
                    <td>${esc(task[1])}</td>
                    <td>${esc(task[2])}</td>
                    <td>${esc(task[3])}</td>
                    <td>${esc(task[4])}</td>
                    <td><span class='badge badge-soft-${statusClass}' style='padding: 8px 12px; font-weight: 500; border-radius: 20px;' data-enum-status='${enumStatus}'>${displayStatus}</span></td>
                    <td class='text-right px-4'>`;
                html += `<div class='dropdown'>
                    <select class='form-control status-select' data-task-id='${taskId}' data-original-status='${enumStatus}'
                        style='width: 140px; max-width: 100%; background-color: white; border: 1px solid #e3e6f0; border-radius: 20px; padding: 8px 15px; font-size: 0.875rem; color: #6e707e; cursor: pointer; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236e707e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 15px center; background-size: 12px;'>
                        <option value='pending' ${enumStatus === 'pending' ? 'selected' : ''}>🕒 Pending</option>
                        <option value='in progress' ${enumStatus === 'in progress' ? 'selected' : ''}>🔄 In Progress</option>
                        <option value='completed' ${enumStatus === 'completed' ? 'selected' : ''}>✅ Completed</option>
                    </select>
                </div>`;
                html += `</td></tr>`;
            });
            tableBody.innerHTML = html;
            addStatusSelectListeners(); // <-- Add this line
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

        // Status update functionality
        function addStatusSelectListeners() {
            document.querySelectorAll('.status-select').forEach(select => {
                select.addEventListener('change', function() {
                    const selectEl = this;
                    const taskId = this.getAttribute('data-task-id');
                    const newStatus = this.value;
                    const originalStatus = this.getAttribute('data-original-status');
                    selectEl.disabled = true;
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
                            throw new Error('Invalid JSON response');
                        }
                        return data;
                    })
                    .then(data => {
                        if (data.success) {
                            // Update badge and dropdown to reflect new status
                            const row = selectEl.closest('tr');
                            const badge = row.querySelector('span.badge');
                            const enumToDisplay = {
                                'pending': 'Pending',
                                'in progress': 'In Progress',
                                'completed': 'Completed'
                            };
                            const statusClassMap = {
                                'pending': 'warning',
                                'in progress': 'info',
                                'completed': 'success'
                            };
                            const displayStatus = enumToDisplay[newStatus] || newStatus;
                            const badgeClass = 'badge-soft-' + (statusClassMap[newStatus] || 'secondary');
                            badge.textContent = displayStatus;
                            badge.className = 'badge ' + badgeClass;
                            badge.setAttribute('data-enum-status', newStatus);
                            selectEl.setAttribute('data-original-status', newStatus);
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Task status updated successfully',
                                    timer: 1200,
                                    showConfirmButton: false,
                                    position: 'top-end',
                                    toast: true
                                });
                            }
                            refreshManagerTaskChart(); // Refresh the manager task chart
                        } else {
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.error || 'Failed to update task status',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    position: 'top-end',
                                    toast: true
                                });
                            }
                            selectEl.value = originalStatus || 'pending';
                        }
                    })
                    .catch(error => {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Network Error!',
                                text: 'Failed to update task status. Please try again.',
                                timer: 3000,
                                showConfirmButton: false,
                                position: 'top-end',
                                toast: true
                            });
                        }
                        selectEl.value = originalStatus || 'pending';
                    })
                    .finally(() => {
                        selectEl.disabled = false;
                    });
                });
            });
        }
    });
</script>


<?php require './bottom.php'; ?>
