<?php // Leave Portal body for department managers: approve their team's requests and file their own. ?>
<!-- MAIN CONTENT-->
<div class="main-content" style="min-height: 100vh;">
  <div class="section__content section__content--p30">
    <div class="container-fluid" style="min-height: 90vh; display: flex; flex-direction: column; justify-content: flex-start;">
      <div class="row flex-column">
        <div class="col-md-12">
          <!-- DATA TABLE 1 -->
          <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
            <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
              <h3 class="mb-0 text-white">Employee Leave Management</h3>
              <small class="text-white-50 ml-3">Accept or Reject Employee Leave Requests</small>
            </div>
            <div class="card-body p-4">
              <div class="row mb-4 align-items-end">
                <div class="col-md-6 col-lg-6 mb-2 mb-md-0">
                  <div class="input-group">
                    <input type="text" id="table1-search-input" class="form-control custom-input" placeholder="Search leaves...">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="zmdi zmdi-search"></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 col-6 mb-2 mb-md-0">
                  <select id="table1-statusFilter" class="form-control custom-input custom-select">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                  </select>
                </div>
                <div class="col-md-2 col-6 mb-2 mb-md-0">
                  <input type="date" id="table1-dateFilter" class="form-control custom-input" title="Filter by date">
                </div>
              </div>
              <div class="table-responsive table-responsive-data2">
                <table class="table table-data2 table-hover" id="leaveTable1">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-primary text-center">Leave ID</th>
                      <th class="text-primary text-center">Name</th>
                      <th class="text-primary text-center">Reason</th>
                      <th class="text-primary text-center">Start Date</th>
                      <th class="text-primary text-center">End Date</th>
                      <th class="text-primary text-center">Status</th>
                      <th class="text-primary text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody id="table1-table-body"></tbody>
                </table>
              </div>
              <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-muted" id="table1-showingEntries"></div>
                <nav aria-label="Page navigation">
                  <ul class="pagination mb-0" id="table1-pagination"></ul>
                </nav>
              </div>
            </div>
          </div>
          <!-- END DATA TABLE 1 -->

          <!--Data Table 2-->
          <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff); margin-bottom: 48px !important;">
            <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
              <h3 class="mb-0 text-white">Leave Management</h3>
              <small class="text-white-50 ml-3">Request and track your leaves</small>
            </div>
            <div class="card-body p-4">
              <div class="row mb-4 align-items-end">
                <div class="col-md-4 mb-2 mb-md-0">
                  <div class="input-group">
                    <input type="text" id="table2-search-input" class="form-control custom-input" placeholder="Search leaves...">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="zmdi zmdi-search"></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 col-6 mb-2 mb-md-0">
                  <select id="table2-statusFilter" class="form-control custom-input custom-select">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                  </select>
                </div>
                <div class="col-md-3 col-6 mb-2 mb-md-0">
                  <input type="date" id="table2-dateFilter" class="form-control custom-input" title="Filter by date">
                </div>
                <div class="col-md-3 mt-2 mt-md-0">
                  <button class="btn custom-button btn-block w-100" id="requestLeaveBtn"><i class="zmdi zmdi-plus mr-2"></i>Request Leave</button>
                </div>
              </div>
              <div class="table-responsive table-responsive-data2">
                <table class="table table-data2 table-hover" id="leaveTable">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-primary text-center">Leave ID</th>
                      <th class="text-primary text-center">Reason</th>
                      <th class="text-primary text-center">Start Date</th>
                      <th class="text-primary text-center">End Date</th>
                      <th class="text-primary text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody id="table2-table-body"></tbody>
                </table>
              </div>
              <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-muted" id="table2-showingEntries"></div>
                <nav aria-label="Page navigation">
                  <ul class="pagination mb-0" id="table2-pagination"></ul>
                </nav>
              </div>
            </div>
          </div>
          <!-- End Data Table 2-->
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Gradient text utility */
.text-gradient {
  background: linear-gradient(45deg, #1a237e, #4e73df);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
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

/* Responsive adjustments */
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

/* Custom select styling to match date input */
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

/* Remove default arrow in IE */
.custom-select::-ms-expand {
  display: none;
}
</style>

<script>
const rowsPerPage = 7;
let currentPage1 = 1;
let currentPage2 = 1;

// Remove polling interval variables and polling functions

// Improved debounce function
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(this, args);
        }, wait);
    };
}

// Create a dedicated search function
function handleSearch(tableId) {
    // Reset to first page when searching
    if (tableId === 'table1') {
        currentPage1 = 1;
    } else {
        currentPage2 = 1;
    }
    loadTableData(tableId, tableId === 'table1' ? currentPage1 : currentPage2);
}

// Modify the loadTableData function to always update the table
function loadTableData(tableId, currentPage, isBackgroundRefresh = false) {
    if (!document.getElementById(`${tableId}-search-input`)) return; // table not on this page
    const searchTerm = document.getElementById(`${tableId}-search-input`).value.trim();
    const statusFilter = document.getElementById(`${tableId}-statusFilter`).value;
    const dateFilter = document.getElementById(`${tableId}-dateFilter`).value;
    
    // Only show loading state if it's not a background refresh
    if (!isBackgroundRefresh) {
        const tableBody = document.getElementById(`${tableId}-table-body`);
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </td>
            </tr>
        `;
    }

    // Prepare form data
    const formData = new FormData();
    formData.append('action', 'getLeaves');
    formData.append('page', currentPage);
    formData.append('search', searchTerm);
    formData.append('status', statusFilter);
    formData.append('date', dateFilter);
    formData.append('rowsPerPage', rowsPerPage);

    // Determine the correct data file to fetch from
    const dataFile = tableId === 'table1' ? '<?= $crm ?>shared/team_leaves.php' : '<?= $crm ?>shared/my_leaves.php';

    // Make AJAX request
    fetch(dataFile, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        console.log(`Data fetched for ${tableId}:`, result); // Log the fetched data
        if (result.status === 'success') {
            // Remove the conditional update and always render the table
            renderTable(tableId, result.data, currentPage);
            renderPagination(tableId, result.pagination, currentPage);
            updateShowingEntries(tableId, result.pagination);
            window.lastData = JSON.stringify(result.data);
        } else {
                showError(tableId, 'Failed to load data');
        }
    })
    .catch(error => {
            showError(tableId, 'An error occurred while loading data');
            console.error('Error:', error);
            console.log('Error details:', error);
    });
}
['table1', 'table2'].forEach((t) => crmLiveRefresh(() => loadTableData(t, t === 'table1' ? currentPage1 : currentPage2, true), { key: t }));

function renderTable(tableId, data, currentPage) {
  const tableBody = document.getElementById(`${tableId}-table-body`);
  tableBody.innerHTML = "";

  if (data.length === 0) {
    tableBody.innerHTML = `
      <tr class="tr-shadow">
        <td colspan="${tableId === 'table1' ? 7 : 5}" class="text-center text-muted py-4"> <!-- Updated colspan -->
          No leaves found matching your filters
        </td>
      </tr>
    `;
    return;
  }

  data.forEach((item, index) => {
    // Add title attribute if reason is long
    const reasonCell = item.reason.length > 50 ? 
      `<td title="${esc(item.reason)}" class="text-center">${esc(item.reason)}</td>` : 
      `<td class="text-center">${esc(item.reason)}</td>`;

    // Include name field for Table 1
    const nameCell = tableId === 'table1' ? `<td class="text-center">${esc(item.name)}</td>` : '';

    // Add action buttons for Table 1
    const actionCell = tableId === 'table1' ? `
      <td class="text-center">
        <button class="btn btn-success btn-sm" onclick="approveLeave(${esc(item.id)})">
          <i class="zmdi zmdi-check"></i>
        </button>
        <button class="btn btn-danger btn-sm" onclick="rejectLeave(${esc(item.id)})">
          <i class="zmdi zmdi-close"></i>
        </button>
      </td>
    ` : '';

    // For table2, show leave id instead of Sr.no
    const firstCell = tableId === 'table1' 
      ? `<td class="text-center">${esc(item.id)}</td>` 
      : `<td class="text-center">${esc(item.id)}</td>`;

    tableBody.innerHTML += `
      <tr class='tr-shadow'>
        ${firstCell}
        ${nameCell}
        ${reasonCell}
        <td class="text-center">${formatDate(item.startDate)}</td>
        <td class="text-center">${formatDate(item.endDate)}</td>
        <td class="text-center"><span class="status--process ${esc(item.status)}">${esc(item.status.toUpperCase())}</span></td>
        ${actionCell} <!-- Add action cell -->
      </tr>
      <tr class='spacer'></tr>
    `;
  });
}

function formatDate(dateStr) {
    // Parse YYYY-MM-DD as a local date; new Date('YYYY-MM-DD') is UTC and shows the previous day west of GMT.
    const [y, m, d] = String(dateStr).split('-').map(Number);
    const date = new Date(y, m - 1, d);
    return date.toLocaleDateString('en-GB', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function renderPagination(tableId, pagination, currentPage) {
    const paginationContainer = document.getElementById(`${tableId}-pagination`);
    let paginationHTML = '';
    
    // Previous button
    paginationHTML += `
        <li class="page-item ${esc(pagination.page === 1 ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); ${pagination.page > 1 ? `changePage('${tableId}', ${esc(pagination.page - 1)})` : ''}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;
    
    // Page numbers
    for (let i = 1; i <= pagination.totalPages; i++) {
        paginationHTML += `
            <li class="page-item ${esc(pagination.page === i ? 'active' : '')}">
                <a class="page-link" href="#" onclick="event.preventDefault(); changePage('${tableId}', ${i})">${i}</a>
            </li>
        `;
    }
    
    // Next button
    paginationHTML += `
        <li class="page-item ${esc(pagination.page === pagination.totalPages ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); ${pagination.page < pagination.totalPages ? `changePage('${tableId}', ${esc(pagination.page + 1)})` : ''}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;
    
    paginationContainer.innerHTML = paginationHTML;
}

function updateShowingEntries(tableId, pagination) {
    const startIndex = (pagination.page - 1) * pagination.rowsPerPage + 1;
    const endIndex = Math.min(startIndex + pagination.rowsPerPage - 1, pagination.totalRecords);
    const showingEntries = document.getElementById(`${tableId}-showingEntries`);
    
    if (pagination.totalRecords === 0) {
        showingEntries.textContent = "Showing 0 entries";
    } else {
        showingEntries.textContent = `Showing ${startIndex} to ${endIndex} of ${esc(pagination.totalRecords)} entries`;
    }
}

function changePage(tableId, page) {
    // Update current page and reload data
    if (tableId === 'table1') {
        currentPage1 = page;
        loadTableData(tableId, currentPage1);
    } else {
        currentPage2 = page;
        loadTableData(tableId, currentPage2);
    }
}

function showError(tableId, message) {
    const tableBody = document.getElementById(`${tableId}-table-body`);
    tableBody.innerHTML = `
        <tr class="tr-shadow">
            <td colspan="6" class="text-center text-danger py-4">
                ${message}
            </td>
        </tr>
    `;
    console.log(`Error in ${tableId}: ${message}`);
}

// Update the search input event listener
const debouncedSearch1 = debounce(() => handleSearch('table1'), 300);
document.getElementById("table1-search-input").addEventListener("input", debouncedSearch1);

const debouncedSearch2 = debounce(() => handleSearch('table2'), 300);
document.getElementById("table2-search-input").addEventListener("input", debouncedSearch2);

// Update the filter event listeners to use the same pattern
document.getElementById("table1-statusFilter").addEventListener("change", () => {
    currentPage1 = 1;
    loadTableData('table1', currentPage1);
});

document.getElementById("table1-dateFilter").addEventListener("change", () => {
    currentPage1 = 1;
    loadTableData('table1', currentPage1);
});

document.getElementById("table2-statusFilter").addEventListener("change", () => {
    currentPage2 = 1;
    loadTableData('table2', currentPage2);
});

document.getElementById("table2-dateFilter").addEventListener("change", () => {
    currentPage2 = 1;
    loadTableData('table2', currentPage2);
});

// Initialize tables
loadTableData('table1', currentPage1);
loadTableData('table2', currentPage2);

// Add approveLeave and rejectLeave functions
function approveLeave(leaveId) {
  Swal.fire({
    title: 'Approve Leave',
    text: 'Are you sure you want to approve this leave request?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Approve',
    cancelButtonText: 'Cancel',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      // AJAX to approve leave
    const formData = new FormData();
      formData.append('action', 'approveLeave');
      formData.append('leave_id', leaveId);
      fetch('<?= $crm ?>shared/team_leaves.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          Swal.fire({
            title: 'Approved!',
            text: data.message || 'Leave approved successfully.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            loadTableData('table1', currentPage1);
          });
        } else {
          Swal.fire('Error', data.message || 'Failed to approve leave.', 'error');
        }
      })
      .catch(() => {
        Swal.fire('Error', 'Failed to approve leave.', 'error');
      });
    }
  });
}

function rejectLeave(leaveId) {
  Swal.fire({
    title: 'Reject Leave',
    text: 'Are you sure you want to reject this leave request?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Reject',
    cancelButtonText: 'Cancel',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      // AJAX to reject leave
      const formData = new FormData();
      formData.append('action', 'rejectLeave');
      formData.append('leave_id', leaveId);
      fetch('<?= $crm ?>shared/team_leaves.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          Swal.fire({
            title: 'Rejected!',
            text: data.message || 'Leave rejected successfully.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            loadTableData('table1', currentPage1);
          });
        } else {
          Swal.fire('Error', data.message || 'Failed to reject leave.', 'error');
        }
      })
      .catch(() => {
        Swal.fire('Error', 'Failed to reject leave.', 'error');
      });
    }
  });
}

// Add Leave functionality with SweetAlert2
const requestLeaveBtn = document.getElementById('requestLeaveBtn');
if (requestLeaveBtn) {
    requestLeaveBtn.addEventListener('click', function() {
        const formHtml = `
            <div class="form-group">
                <label for="swalStartDate">Start Date</label>
                <input type="date" class="form-control" id="swalStartDate" required>
            </div>
            <div class="form-group">
                <label for="swalEndDate">End Date</label>
                <input type="date" class="form-control" id="swalEndDate" required>
            </div>
            <div class="form-group">
                <label for="swalReason">Reason for Leave</label>
                <textarea class="form-control" id="swalReason" rows="4" placeholder="Please specify your reason..." required></textarea>
        </div>
    `;
        Swal.fire({
            title: 'Request Leave',
            html: formHtml,
            showCancelButton: true,
            confirmButtonText: 'Submit Request',
            cancelButtonText: 'Cancel',
            width: '500px',
            focusConfirm: false,
            preConfirm: () => {
                const startDate = Swal.getHtmlContainer().querySelector('#swalStartDate').value;
                const endDate = Swal.getHtmlContainer().querySelector('#swalEndDate').value;
                const reason = Swal.getHtmlContainer().querySelector('#swalReason').value;
                if (!startDate || !endDate || !reason) {
                    Swal.showValidationMessage('All fields are required');
                    return false;
                }
                // AJAX to add_leave.php
                const formData = new FormData();
                formData.append('startDate', startDate);
                formData.append('endDate', endDate);
                formData.append('reason', reason);
                formData.append('action', 'addLeave');
                return fetch('<?= $crm ?>shared/my_leaves.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload the table data for table2
                            loadTableData('table2', 1);
                        });
                    } else {
                        Swal.showValidationMessage(data.message || 'Failed to submit leave request.');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage('Failed to submit leave request.');
                });
            }
        });
    });
}
</script>

<?php require __DIR__ . '/bottom.php'; ?>

<!-- Add SweetAlert2 JS and CSS -->
