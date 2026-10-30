<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './analytics/contact_analytics_cards.php'; ?>
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="text-primary">Contact Submissions</h3>
                    <small class="text-muted">Manage contact submissions</small>
                  </div>
                  <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" id="searchBar" class="form-control" placeholder="Search by any column" onkeyup="searchSubmissions()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-filter"></i> Status</span>
                                </div>
                                <select id="status-filter" class="form-control" name="status">
                                    <option value="">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="responded">Responded</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="contactSubmitsTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary">ID</th>
                            <th class="text-primary">Name</th>
                            <th class="text-primary">Email</th>
                            <th class="text-primary">Contact</th>
                            <th class="text-primary">Subject</th>
                            <th class="text-primary">Message</th>
                            <th class="text-primary">Status</th>
                            <th class="text-primary">Date</th>
                            <th class="text-primary">Time</th>
                            <th class="text-primary">Responded On</th>
                            <th class="text-primary">Response</th>
                          </tr>
                        </thead>
                        <tbody id="contact-submits-table-body">
                          <!-- Data will be loaded here via AJAX -->
                        </tbody>
                      </table>
                    </div>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                      <!-- Page info on left -->
                      <div class="text-muted" id="showingEntries">
                        <!-- Will be populated by JavaScript -->
                      </div>
                      
                      <!-- Pagination on right -->
                      <nav aria-label="Page navigation">
                        <ul class="pagination mb-0" id="pagination">
                          <!-- Will be populated by JavaScript -->
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <!-- Add rows here -->
          
        <!-- End the main code above this line -->
<?php require './bottom.php'; ?>

<style>
/* Card Styling */
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    border-radius: 8px;
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #f0f0f0;
    padding: 20px;
}

/* Table container */
.table-responsive-data2 {
    overflow-x: auto;
    margin: 0 -15px;
    padding: 0 15px;
}

/* Base table styles */
.table-data2 {
    min-width: 900px;
    width: 100%;
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
}

/* Default cell styles */
.table-data2 td {
    white-space: normal !important;
    overflow: visible !important;
    text-overflow: initial !important;
    word-break: break-word;
    padding: 8px 6px !important;
    vertical-align: middle !important;
    font-size: 0.9rem;
    line-height: 1.4;
}

/* Column widths */
.table-data2 th:nth-child(1), /* ID */
.table-data2 td:nth-child(1) {
    width: 50px;
}

.table-data2 th:nth-child(2), /* Name */
.table-data2 td:nth-child(2) {
    width: 120px;
}

.table-data2 th:nth-child(3), /* Email */
.table-data2 td:nth-child(3) {
    width: 180px;
}

.table-data2 th:nth-child(4), /* Contact */
.table-data2 td:nth-child(4) {
    width: 100px;
}

.table-data2 th:nth-child(5), /* Subject */
.table-data2 td:nth-child(5) {
    width: 150px;
}

.table-data2 th:nth-child(6), /* Message */
.table-data2 td:nth-child(6) {
    width: 200px;
}

.table-data2 th:nth-child(7), /* Status */
.table-data2 td:nth-child(7) {
    width: 100px;
}

.table-data2 th:nth-child(8), /* Date */
.table-data2 td:nth-child(8) {
    width: 100px;
}

.table-data2 th:nth-child(9), /* Time */
.table-data2 td:nth-child(9) {
    width: 90px;
}

.table-data2 th:nth-child(10), /* Responded On */
.table-data2 td:nth-child(10) {
    width: 150px;
}

.table-data2 th:nth-child(11), /* Response */
.table-data2 td:nth-child(11) {
    width: 200px;
}

/* Header styles */
.table-data2 thead th {
    padding: 8px 6px !important;
    font-weight: 600;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle !important;
    position: sticky;
    top: 0;
    z-index: 1;
}

/* Row styles */
.tr-shadow {
    height: auto !important;
}

.spacer {
    height: 4px;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .table-data2 {
        min-width: 1200px;
    }
    
    .table-data2 tbody td {
        padding: 6px 4px !important;
        font-size: 0.85rem;
    }
}

/* Pagination styles */
.pagination {
  margin: 0;
}

#showingEntries {
  font-size: 0.9rem;
}

/* Add hover effect for rows */
.table-data2 tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
    transition: background-color 0.2s ease;
}

/* Add ellipsis for very long text */
.table-data2 td:nth-child(5) {
    position: relative;
}

/* Optional: Add tooltip for long text */
.table-data2 td:nth-child(5)[title] {
    cursor: help;
}

/* Ensure table cells align properly */
.table-data2 th,
.table-data2 td {
    vertical-align: middle !important;
}
</style>


<script>
let currentPage = 1;
const rowsPerPage = 5;
let currentStatus = '';

// Function to load table data
function loadTableData(page = 1) {
    loadTableData.lastArgs = arguments;
    currentPage = page;
    const searchTerm = document.getElementById('searchBar').value;
    currentStatus = document.getElementById('status-filter').value;
    
    // Show loading state
    const tableBody = document.getElementById('contact-submits-table-body');
    tableBody.innerHTML = '<tr><td colspan="11" class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></td></tr>';
    
    // Show loading in entries info
    const showingEntries = document.getElementById('showingEntries');
    showingEntries.innerHTML = 'Loading...';
    
    let url = `./data/contact_submits_data.php?page=${page}&rowsPerPage=${rowsPerPage}&search=${encodeURIComponent(searchTerm)}`;
    
    // Add status filter if selected
    if (currentStatus) {
        url += `&status=${encodeURIComponent(currentStatus)}`;
    }
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${esc(response.status)}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                renderTable(data.data, data.total, page, rowsPerPage);
                renderPagination({
                    page: data.page || page,
                    totalPages: data.totalPages || Math.ceil(data.total / rowsPerPage),
                    totalItems: data.total
                });
                
                // Update showing entries info
                const start = ((page - 1) * rowsPerPage) + 1;
                const end = Math.min(page * rowsPerPage, data.total);
                showingEntries.textContent = `Showing ${start} to ${end} of ${esc(data.total)} entries${searchTerm ? ` (filtered from ${esc(data.total)} total entries)` : ''}`;
            } else {
                console.error('Error loading data:', data.message);
                tableBody.innerHTML = '<tr><td colspan="11" class="text-center text-danger py-4">Error loading data. Please try again.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tableBody.innerHTML = '<tr><td colspan="11" class="text-center text-danger py-4">Network error. Please check your connection.</td></tr>';
        });
}
crmLiveRefresh(function () { loadTableData.apply(null, loadTableData.lastArgs || []); }); // keep current without polling

// Function to render table
function renderTable(submits, totalItems, currentPage, rowsPerPage) {
    const tableBody = document.getElementById('contact-submits-table-body');
    
    if (submits.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="11" class="text-center py-4">No matching records found</td></tr>';
        return;
    }
    
    let html = '';
    
    submits.forEach(submit => {
        html += `
            <tr class='tr-shadow'>
                <td>${esc(submit.id)}</td>
                <td>${esc(submit.name)}</td>
                <td>${esc(submit.email)}</td>
                <td>${esc(submit.contact || '-')}</td>
                <td>${esc(submit.subject)}</td>
                <td title="${esc(submit.message)}">${esc(submit.message.length > 50 ? submit.message.substring(0, 50) + '...' : submit.message)}</td>
                <td>
                    <span class="badge ${esc(submit.status === 'responded' ? 'badge-success' : 'badge-warning')}">
                        ${esc(submit.status || 'pending')}
                    </span>
                </td>
                <td>${esc(submit.date)}</td>
                <td>${esc(submit.time)}</td>
                <td>
                    ${submit.responded_on ? submit.responded_on : 
                        `<button class='btn btn-sm btn-outline-primary btn-respond' data-id='${esc(submit.id)}'>
                            <i class='fa fa-reply'></i> Respond
                        </button>`
                    }
                </td>
                <td>${esc(submit.response_message ? submit.response_message : '-')}</td>
            </tr>
            <tr class='spacer'></tr>
        `;
    });
    
    tableBody.innerHTML = html;
    
    // Reattach event listeners for respond buttons
    document.querySelectorAll('.btn-respond').forEach(btn => {
        btn.addEventListener('click', function() {
            handleResponseClick(this);
        });
    });
}

// Function to render pagination
function renderPagination(pagination) {
    const paginationContainer = document.getElementById('pagination');
    
    if (pagination.totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    const maxVisiblePages = 5;
    let startPage, endPage;
    
    if (pagination.totalPages <= maxVisiblePages) {
        startPage = 1;
        endPage = pagination.totalPages;
    } else {
        const maxPagesBeforeCurrent = Math.floor(maxVisiblePages / 2);
        const maxPagesAfterCurrent = Math.ceil(maxVisiblePages / 2) - 1;
        
        if (pagination.page <= maxPagesBeforeCurrent) {
            startPage = 1;
            endPage = maxVisiblePages;
        } else if (pagination.page + maxPagesAfterCurrent >= pagination.totalPages) {
            startPage = pagination.totalPages - maxVisiblePages + 1;
            endPage = pagination.totalPages;
        } else {
            startPage = pagination.page - maxPagesBeforeCurrent;
            endPage = pagination.page + maxPagesAfterCurrent;
        }
    }

    // Previous button
    paginationHTML += `
        <li class="page-item ${esc(pagination.page === 1 ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${esc(pagination.page - 1)})" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;

    // First page
    if (startPage > 1) {
        paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="event.preventDefault(); changePage(1)">1</a>
            </li>
        `;
        if (startPage > 2) {
            paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    // Page numbers
    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `
            <li class="page-item ${esc(pagination.page === i ? 'active' : '')}">
                <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${i})">${i}</a>
            </li>
        `;
    }

    // Last page
    if (endPage < pagination.totalPages) {
        if (endPage < pagination.totalPages - 1) {
            paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${esc(pagination.totalPages)})">${esc(pagination.totalPages)}</a>
            </li>
        `;
    }

    // Next button
    paginationHTML += `
        <li class="page-item ${esc(pagination.page === pagination.totalPages ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${esc(pagination.page + 1)})" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;

    paginationContainer.innerHTML = `<ul class="pagination justify-content-center">${paginationHTML}</ul>`;
}

// Function to change page
function changePage(page) {
    currentPage = page;
    loadTableData(page);
}

// Function to load data (no longer polls automatically)
function loadData() {
    loadTableData(currentPage);
}

// Function to search submissions with debounce
let searchTimeout;
function searchSubmissions() {
    // Clear any existing timeout
    clearTimeout(searchTimeout);
    
    // Set a new timeout
    searchTimeout = setTimeout(() => {
        loadTableData(1); // Reset to first page when searching
    }, 500); // Increased debounce time for better performance
}

// Add event listener for Enter key in search
const searchBar = document.getElementById('searchBar');
if (searchBar) {
    searchBar.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            clearTimeout(searchTimeout);
            loadTableData(1);
        }
    });
}

// Add event listener for status filter change
document.getElementById('status-filter').addEventListener('change', function() {
    loadTableData(1); // Reset to first page when filter changes
});

// Function to handle response button click
function handleResponseClick(button) {
    const submissionId = button.getAttribute('data-id');
    Swal.fire({
        title: 'Record your reply',
        input: 'textarea',
        inputLabel: 'What did you tell the customer? (Saved with the message; not emailed.)',
        inputPlaceholder: 'e.g. Called on 30 Oct, sent the quotation by email',
        inputAttributes: { rows: 5, maxlength: 2000 },
        inputValidator: (v) => (v && v.trim() ? undefined : 'Please enter your reply'),
        showCancelButton: true,
        confirmButtonText: 'Save reply',
        showLoaderOnConfirm: true,
        preConfirm: (value) => fetch('./data/update_submission_response.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${encodeURIComponent(submissionId)}&response=${encodeURIComponent(value.trim())}`
            })
            .then((r) => r.json())
            .then((data) => {
                if (!data.success) throw new Error(data.message || 'Failed to save the reply');
                return data;
            })
            .catch((e) => Swal.showValidationMessage(e.message)),
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (!result.isConfirmed) return;
        Swal.fire({ icon: 'success', title: 'Reply saved', timer: 1800, showConfirmButton: false });
        loadTableData(currentPage);
    });
}


// Event delegation for response buttons
document.addEventListener('click', (e) => {
    if (e.target.closest('.btn-respond')) {
        handleResponseClick(e.target.closest('.btn-respond'));
    }
});

// Load initial data when the page loads
document.addEventListener('DOMContentLoaded', () => {
    loadTableData(1);
});
</script>