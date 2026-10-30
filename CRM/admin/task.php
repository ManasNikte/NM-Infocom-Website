<?php
require_once './top.php';
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Title and Description -->
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="dashboard-main-title mb-1">Employee & Manager Task Board</h2>
                    <p class="text-muted mb-0" style="font-size:1.08rem;">View, filter, and assign tasks for employees and managers. Use the filters below to quickly find tasks by status, user type, or keyword.</p>
                </div>
            </div>
            <!-- Filter Bar -->
            <div class="card filter-bar-card mb-4 p-3" style="border-radius: 16px; box-shadow: 0 2px 12px rgba(44,62,80,0.07); background: #f8f9fa;">
                <div class="d-flex flex-wrap align-items-center gap-2 gap-md-3">
                    <div class="input-group flex-nowrap filter-search-group" style="min-width: 220px; max-width: 320px;">
                        <input type="text" id="employeeTaskSearchInput" class="form-control custom-input" placeholder="Search tasks...">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="zmdi zmdi-search"></i></span>
                                        </div>
                                    </div>
                    <div class="dropdown filter-dropdown">
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
                    <div class="dropdown filter-dropdown">
                        <button class="btn custom-input custom-select employee-user-type-dropdown-btn w-100" data-toggle="dropdown" style="text-align:left;">
                            <i class="fas fa-user mr-2 text-secondary"></i>All Users
                                        </button>
                                        <div class="dropdown-menu custom-dropdown-menu w-100">
                            <a class="dropdown-item employee-filter-user-type" data-user-type="all" href="#">
                                <i class="fas fa-users mr-2 text-secondary"></i>All Users
                            </a>
                            <a class="dropdown-item employee-filter-user-type" data-user-type="employee" href="#">
                                <i class="fas fa-user-tie mr-2 text-info"></i>Employee Tasks
                            </a>
                            <a class="dropdown-item employee-filter-user-type" data-user-type="manager" href="#">
                                <i class="fas fa-user-cog mr-2 text-warning"></i>Manager Tasks
                                            </a>
                                        </div>
                                    </div>
                    <button class="btn btn-outline-secondary ml-1" id="clearEmployeeTaskSearch" title="Clear search" style="min-width:44px;"><i class="zmdi zmdi-close"></i></button>
                    <div class="ml-auto d-flex align-items-center">
                        <button class="btn custom-button btn-block" id="assignTaskBtn"><i class="fas fa-plus mr-1"></i>Assign New Task</button>
                                </div>
                                </div>
                            </div>
            <!-- Task Table Card -->
            <div class="card shadow-lg mb-5 task-table-card" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                    <h3 class="mb-0 text-white"><i class="fas fa-users mr-2"></i>Marketing Employee & Manager Tasks</h3>
                </div>
                <div class="card-body p-0">
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2 table-hover mb-0">
                            <thead class="bg-light sticky-top" style="z-index:2;">
                                        <tr>
                                            <th class="text-primary text-center">Task ID</th>
                                            <th class="text-primary text-center">Employee Name</th>
                                    <th class="text-primary text-center">Role</th>
                                    <th class="text-primary text-center">Sub Role</th>
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
                    <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center px-4 pb-3">
                                <div class="text-muted" id="employeeTasksInfo"></div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0" id="employeeTasksPagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
            <!-- END Task Table Card -->
            <!-- Styles for Employee Task Table Only -->
            <style>
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
                    padding: 12px 24px;
                    background: linear-gradient(45deg, #1a237e, #4e73df);
                    border: none;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                    box-shadow: 0 4px 15px rgba(78, 115, 223, 0.13);
                    transition: all 0.3s ease;
                    color: #fff;
                }
                .custom-button:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(78, 115, 223, 0.18);
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
                    min-width: 1100px;
                    max-width: 100%;
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
                    text-align: center !important;
                }
                .table-data2 thead th {
                    font-weight: 600;
                    background-color: #f8f9fa;
                    border-bottom: 2px solid #dee2e6;
                    vertical-align: middle !important;
                    position: sticky;
                    top: 0;
                    z-index: 2;
                    padding: 14px 8px !important;
                }
                .pagination {
                    margin: 0;
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
                .badge-role {
                    background: linear-gradient(45deg, #4e73df, #1a237e);
                    color: #fff;
                    font-size: 0.93em;
                    padding: 4px 14px;
                    border-radius: 14px;
                    font-weight: 600;
                    margin-right: 2px;
                }
                .badge-subrole {
                    background: #e3e6f0;
                    color: #1a237e;
                    font-size: 0.93em;
                    padding: 4px 12px;
                    border-radius: 14px;
                    font-weight: 600;
                }
                .table-data2 tbody tr {
                    transition: background 0.18s, box-shadow 0.18s;
                }
                .table-data2 tbody tr:hover {
                    background: #f1f5fa;
                    box-shadow: 0 2px 8px rgba(44,62,80,0.07);
                }
                .filter-bar-card {
                    box-shadow: 0 2px 12px rgba(44,62,80,0.07) !important;
                    border: none;
                    margin-bottom: 1.5rem;
                    position: relative;
                    z-index: 1051;
                }
                .filter-search-group input {
                    border-radius: 12px 0 0 12px !important;
                }
                .filter-search-group .input-group-text {
                    border-radius: 0 12px 12px 0 !important;
                    background: #e3e6f0;
                }
                .filter-dropdown .btn {
                    min-width: 140px;
                    margin-right: 0.5rem;
                }
                .filter-dropdown .dropdown-menu {
                    min-width: 180px;
                }
                .task-table-card {
                    margin-top: 0;
                }
                @media (max-width: 1200px) {
                    .table-data2 {
                        min-width: 900px;
                    }
                }
                @media (max-width: 992px) {
                    .main-content {
                        min-height: 100vh;
                    }
                    .container-fluid {
                        min-height: 90vh;
                    }
                    .table-data2 {
                        min-width: 700px;
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
                        min-width: 500px;
                        font-size: 0.9rem;
                    }
                    .table-data2 th, .table-data2 td {
                        padding: 8px 4px !important;
                    }
                    .card-header, .card-body {
                        padding: 0.7rem;
                    }
                    .dashboard-main-title {
                        font-size: 1.3rem;
                    }
                }
                @media (max-width: 576px) {
                    .table-data2 {
                        min-width: 350px;
                        font-size: 0.88rem;
                    }
                    .d-flex {
                        flex-direction: column;
                        gap: 1rem;
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
            </style>
        </div>
    </div>
</div>

<!-- Add SweetAlert2 for popups -->

<!-- JavaScript for Employee Task Table and Add Task -->
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

// Employee Task Table AJAX logic
let employeeTaskSearch = '';
let employeeTaskStatus = 'all';
let employeeTaskPage = 1;
let employeeUserType = 'all';

function fetchEmployeeTasks(page = 1) {
    fetchEmployeeTasks.lastArgs = arguments;
    employeeTaskPage = page;
    const tableBody = document.getElementById('employeeTasksTableBody');
    tableBody.innerHTML = `<tr><td colspan="9" class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
    fetch(`data/employee_task_table_data.php?search=${encodeURIComponent(employeeTaskSearch)}&status=${encodeURIComponent(employeeTaskStatus)}&page=${page}&user_type=${encodeURIComponent(employeeUserType)}`)
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = '';
            if (data.success && data.tasks.length) {
                data.tasks.forEach(task => {
                    let status = (task[8] || '').toLowerCase();
                    let badgeClass = '';
                    let badgeStyle = '';
                    let badgeText = task[8];
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
                        <td><span class='badge-role'>${esc(task[2])}</span></td>
                        <td><span class='badge-subrole'>${esc(task[3])}</span></td>
                        <td>${esc(task[4])}</td>
                        <td>${esc(task[5])}</td>
                        <td>${esc(task[6])}</td>
                        <td>${esc(task[7])}</td>
                        <td><span class='${badgeClass}' style='${badgeStyle}'>${badgeText}</span></td>
                    `;
                    tableBody.appendChild(tr);
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="9" class="text-center">No tasks found.</td></tr>';
            }
            renderEmployeeTasksPagination(data.pagination);
        })
        .catch(() => {
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error loading employee tasks.</td></tr>';
            renderEmployeeTasksPagination({});
        });
}
crmLiveRefresh(function () { fetchEmployeeTasks.apply(null, fetchEmployeeTasks.lastArgs || []); }); // keep current without polling

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

document.querySelectorAll('.employee-filter-user-type').forEach(filter => {
    filter.addEventListener('click', function(e) {
        e.preventDefault();
        employeeUserType = this.getAttribute('data-user-type');
        const dropdownBtn = document.querySelector('.employee-user-type-dropdown-btn');
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

document.getElementById('assignTaskBtn').addEventListener('click', function () {
    crmAssignTask({ base: '../', assignUrl: 'data/assign_task.php', onDone: function () { fetchEmployeeTasks(); } });
});
</script>

<?php require './bottom.php'; ?>



       
