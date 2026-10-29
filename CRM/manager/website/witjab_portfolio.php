<?php 
require_once './top.php'; 

// Include the portfolio data from the PHP file
include './data/witjab_portfolio_data.php'; 
?>

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <?php require './analytics/witjab_portfolio_analytics_cards.php'; ?>
            <!-- Do not delete this div -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-primary">Portfolio Management</h3>
                            <small class="text-muted">Manage your portfolio projects</small>
                        </div>
                        <div class="card-body">
                        <div class="mb-3 d-flex align-items-center" style="gap: 10px;">
                            <!-- Search Bar -->
                            <div class="w-75">
                                <input type="text" id="searchBar" class="form-control" placeholder="Search by any column" onkeyup="searchPortfolio()" style="padding: 10px;">
                            </div>
                            
                            <!-- Add Portfolio Button -->
                            <button class="btn" id="addPortfolioBtn" onclick="addPortfolio()" style="background-color: #007bff; color: white; padding: 8px 15px; border-radius: 5px; margin-left: 70px;">
                                Add Portfolio
                            </button>

                        </div>

                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 table-hover" id="portfolioTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-primary">ID</th>
                                        <th class="text-primary">Image</th>
                                        <th class="text-primary">Title</th>
                                        <th class="text-primary">Description</th>
                                        <th class="text-primary">Date Added</th>
                                        <th class="text-primary">Last Modified</th>
                                        <th class="text-primary">Status</th>
                                        <th class="text-primary">Visibility</th>
                                        <th class="text-primary">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="portfolio-table-body">
                                    <!-- Data will be populated dynamically -->
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

.table-data2 th:nth-child(2), /* Image */
.table-data2 td:nth-child(2) {
    width: 100px;
}

.table-data2 th:nth-child(3), /* Title */
.table-data2 td:nth-child(3) {
    width: 200px;
}

.table-data2 th:nth-child(4), /* Description */
.table-data2 td:nth-child(4) {
    width: 300px;
}

.table-data2 th:nth-child(5), /* Date Added */
.table-data2 td:nth-child(5) {
    width: 150px;
}

.table-data2 th:nth-child(6), /* Last Modified */
.table-data2 td:nth-child(6) {
    width: 150px;
}

.table-data2 th:nth-child(7), /* Status */
.table-data2 td:nth-child(7) {
    width: 100px;
}

.table-data2 th:nth-child(8), /* Visibility */
.table-data2 td:nth-child(8) {
    width: 100px;
}

.table-data2 th:nth-child(9), /* Action */
.table-data2 td:nth-child(9) {
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

/* Optional: Add tooltip for long text */
.table-data2 td:nth-child(9) {
    text-align: center;
}

/* Button styling */
.btn-primary {
    background-color: #007bff;  /* Match the blue used in the table headings */
    border-color: #007bff;
}

/* Hover effect for the button */
.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<script>
// JavaScript to dynamically add Update and Delete buttons with pagination

const rowsPerPage = 6; // Number of rows per page
let currentPage = 1; // Default page is 1
let portfolioData = <?php echo json_encode($portfolio_data); ?>;  // Ensure this data is fetched from the included file

// Function to render portfolio table rows
function renderPortfolioTable() {
    const tableBody = document.getElementById('portfolio-table-body');
    tableBody.innerHTML = '';  // Clear current rows

    // Get the data to display for the current page
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const currentData = portfolioData.slice(startIndex, endIndex);

    currentData.forEach(project => {
        const row = document.createElement('tr');
        row.classList.add('tr-shadow');
        
        row.innerHTML = `
            <td>${esc(project.id)}</td>
            <td><img src="${esc(project.image)}" alt="${esc(project.title)}" width="80"></td>
            <td>${esc(project.title)}</td>
            <td>${esc(project.description)}</td>
            <td>${esc(project.date_added)}</td>
            <td>${esc(project.last_modified)}</td>
            <td>${esc(project.status)}</td>
            <td>${esc(project.visibility)}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="updateProject(${esc(project.id)})">Update</button>
                <button class="btn btn-danger btn-sm" onclick="deleteProject(${esc(project.id)})">Delete</button>
            </td>
        `;
        
        tableBody.appendChild(row);
    });

    updatePagination();
}

// Function to update pagination buttons
function updatePagination() {
    const pagination = document.getElementById('pagination');
    const totalPages = Math.ceil(portfolioData.length / rowsPerPage);
    pagination.innerHTML = ''; // Clear existing pagination

    // Create previous button
    const prevButton = document.createElement('li');
    prevButton.classList.add('page-item');
    prevButton.innerHTML = `<a class="page-link" href="#" onclick="changePage(currentPage - 1)">Previous</a>`;
    if (currentPage === 1) {
        prevButton.classList.add('disabled');
    }
    pagination.appendChild(prevButton);

    // Create page number buttons
    for (let page = 1; page <= totalPages; page++) {
        const pageButton = document.createElement('li');
        pageButton.classList.add('page-item');
        pageButton.innerHTML = `<a class="page-link" href="#" onclick="changePage(${page})">${page}</a>`;
        if (page === currentPage) {
            pageButton.classList.add('active');
        }
        pagination.appendChild(pageButton);
    }

    // Create next button
    const nextButton = document.createElement('li');
    nextButton.classList.add('page-item');
    nextButton.innerHTML = `<a class="page-link" href="#" onclick="changePage(currentPage + 1)">Next</a>`;
    if (currentPage === totalPages) {
        nextButton.classList.add('disabled');
    }
    pagination.appendChild(nextButton);

    // Update showing entries text
    const showingEntries = document.getElementById('showingEntries');
    showingEntries.textContent = `Showing ${startIndex + 1} to ${esc(Math.min(startIndex + rowsPerPage, portfolioData.length))} of ${esc(portfolioData.length)} entries`;
}

// Function to change page
function changePage(page) {
    if (page < 1 || page > Math.ceil(portfolioData.length / rowsPerPage)) return;
    currentPage = page;
    renderPortfolioTable();
}

// Function to update project
function updateProject(id) {
    const project = portfolioData.find(p => p.id === id);
    if (project) {
        alert(`Updating Project: ${esc(project.title)}`);
        // Add your logic for update here
    }
}

// Function to delete project
function deleteProject(id) {
    const confirmDelete = confirm("Are you sure you want to delete this project?");
    if (confirmDelete) {
        portfolioData = portfolioData.filter(p => p.id !== id);
        renderPortfolioTable();
    }
}

// Function to filter portfolio data based on search input
function searchPortfolio() {
    const searchInput = document.getElementById('searchBar').value.toLowerCase();
    const filteredData = portfolioData.filter(project => {
        return Object.values(project).some(value => 
            value.toString().toLowerCase().includes(searchInput)
        );
    });
    portfolioData = filteredData;  // Update portfolioData with the filtered data
    currentPage = 1;  // Reset to the first page after search
    renderPortfolioTable();  // Re-render table with filtered data
}

// Function to open Add Portfolio modal
function openAddPortfolioModal() {
    Swal.fire({
        title: 'Add New Portfolio',
        html: `
            <form id="addPortfolioForm" class="swal2-compact">
                <div class="form-group mb-2">
                    <label for="title" class="small">Title</label>
                    <input type="text" class="form-control form-control-sm" id="title" required>
                </div>
                <div class="form-group mb-2">
                    <label for="description" class="small">Description</label>
                    <textarea class="form-control form-control-sm" id="description" rows="2" required></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="url" class="small">Project URL</label>
                    <input type="url" class="form-control form-control-sm" id="url" required>
                </div>
                <div class="form-group mb-2">
                    <label for="image" class="small">Image URL</label>
                    <input type="text" class="form-control form-control-sm" id="image" required>
                </div>
            </form>
        `,
        customClass: {
            popup: 'swal2-small',
            content: 'p-2'
        },
        width: 'auto',
        padding: '1rem',
        showCancelButton: true,
        confirmButtonText: 'Add',
        cancelButtonText: 'Cancel'
        // ... rest of the modal config
    });
}

// Add custom CSS
const style = document.createElement('style');
style.textContent = `
.swal2-small {
    max-height: 80vh !important;
}
.swal2-compact .form-control-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
`;
document.head.appendChild(style);

// Add event listener to Add Portfolio button
document.getElementById('addPortfolioBtn').addEventListener('click', openAddPortfolioModal);

// Initial table render
renderPortfolioTable();
</script>
