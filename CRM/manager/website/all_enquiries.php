<?php require_once './top.php'; ?>

      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './analytics/enquiry_analytics_cards.php'; ?>
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="text-primary">Enquiries Management</h3>
                    <small class="text-muted">Manage customer enquiries</small>
                  </div>
                  <div class="card-body">
                    <div class="mb-3">
                      <input type="text" id="searchBar" class="form-control" placeholder="Search by name, email, product, or status" onkeyup="searchEnquiries()">
                    </div>
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="enquiriesTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary">Lead ID</th>
                            <th class="text-primary">Name</th>
                            <th class="text-primary">Email</th>
                            <th class="text-primary">Interested Product</th>
                            <th class="text-primary">Quantity</th>
                            <th class="text-primary">Status</th>
                          </tr>
                        </thead>
                        <tbody id="enquiries-table-body">
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
.table-data2 th:nth-child(1), /* Enquiry ID */
.table-data2 td:nth-child(1) {
    width: 100px;
}

.table-data2 th:nth-child(2), /* Name */
.table-data2 td:nth-child(2) {
    width: 150px;
}

.table-data2 th:nth-child(3), /* Email */
.table-data2 td:nth-child(3) {
    width: 200px;
}

.table-data2 th:nth-child(4), /* Interested Product */
.table-data2 td:nth-child(4) {
    width: 200px;
}

.table-data2 th:nth-child(5), /* Quantity */
.table-data2 td:nth-child(5) {
    width: 100px;
}

.table-data2 th:nth-child(6), /* Status */
.table-data2 td:nth-child(6) {
    width: 150px;
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
        min-width: 800px;
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
let pollingInterval;

// Function to load table data
function loadTableData(page = 1) {
    const searchTerm = document.getElementById('searchBar').value.toLowerCase();
    fetch(`./data/enquiries_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
        .then(response => response.json())
        .then(data => {
            renderTable(data.enquiries, searchTerm);
            renderPagination(data.pagination);
        })
        .catch(error => console.error('Error loading data:', error));
}

// Function to render table
function renderTable(enquiries, searchTerm = '') {
    const tableBody = document.getElementById('enquiries-table-body');
    tableBody.innerHTML = '';

    enquiries.forEach(enquiry => {
        const name = enquiry.name.toLowerCase();
        const email = enquiry.email.toLowerCase();
        const product = enquiry.interested_product.toLowerCase();
        const status = enquiry.status.toLowerCase();

        if (name.includes(searchTerm) || email.includes(searchTerm) || product.includes(searchTerm) || status.includes(searchTerm)) {
            const row = `
                <tr class='tr-shadow'>
                    <td>${esc(enquiry.id)}</td>
                    <td>${esc(enquiry.name)}</td>
                    <td>${esc(enquiry.email)}</td>
                    <td>${esc(enquiry.interested_product)}</td>
                    <td>${esc(enquiry.quantity)}</td>
                    <td>${esc(enquiry.status)}</td>
                </tr>
                <tr class='spacer'></tr>
            `;
            tableBody.innerHTML += row;
        }
    });
}

// Function to render pagination
function renderPagination(pagination) {
    const paginationContainer = document.getElementById('pagination');
    let paginationHTML = '';

    // Previous button
    paginationHTML += `
        <li class="page-item ${esc(pagination.page === 1 ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${esc(pagination.page - 1)})" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;

    // Page numbers
    for (let i = 1; i <= pagination.totalPages; i++) {
        paginationHTML += `
            <li class="page-item ${esc(pagination.page === i ? 'active' : '')}">
                <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${i})">${i}</a>
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

    paginationContainer.innerHTML = `<ul class="pagination">${paginationHTML}</ul>`;
}

// Function to change page
function changePage(page) {
    currentPage = page;
    loadTableData(page);
}

// Keep the table current (crmLiveRefresh)
function startPolling() {
    loadTableData(currentPage);
    pollingInterval = crmLiveRefresh(() => {
        loadTableData(currentPage);
    });
}

// Function to search enquiries
function searchEnquiries() {
    loadTableData(currentPage);
}

// Load the table, then keep it current (crmLiveRefresh)
document.addEventListener('DOMContentLoaded', () => {
    startPolling();
});
</script>