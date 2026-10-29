<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './analytics/witjab_reviews_analytics_cards.php'; ?>
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="text-primary">Reviews Management</h3>
                    <small class="text-muted">Manage customer reviews</small>
                  </div>
                  <div class="card-body">
                    <!-- Search Bar -->
                    <div class="mb-3">
                      <input type="text" id="searchBar" class="form-control" placeholder="Search by any column" onkeyup="searchReviews()">
                    </div>
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="reviewsTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary">ID</th>
                            <th class="text-primary">Name</th>
                            <th class="text-primary">Post</th>
                            <th class="text-primary">Company</th>
                            <th class="text-primary">Stars</th>
                            <th class="text-primary">Review Text</th>
                            <th class="text-primary">Visibility</th>
                            <th class="text-primary">Created At</th>
                            <th class="text-primary">Updated At</th>
                            <th class="text-primary">Action</th>
                          </tr>
                        </thead>
                        <tbody id="reviews-table-body">
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
    width: 150px;
}

.table-data2 th:nth-child(3), /* Post */
.table-data2 td:nth-child(3) {
    width: 150px;
}

.table-data2 th:nth-child(4), /* Company */
.table-data2 td:nth-child(4) {
    width: 150px;
}

.table-data2 th:nth-child(5), /* Stars */
.table-data2 td:nth-child(5) {
    width: 100px;
}

.table-data2 th:nth-child(6), /* Review Text */
.table-data2 td:nth-child(6) {
    width: 250px;
}

.table-data2 th:nth-child(7), /* Visibility */
.table-data2 td:nth-child(7) {
    width: 100px;
}

.table-data2 th:nth-child(8), /* Created At */
.table-data2 td:nth-child(8) {
    width: 150px;
}

.table-data2 th:nth-child(9), /* Updated At */
.table-data2 td:nth-child(9) {
    width: 150px;
}

.table-data2 th:nth-child(10), /* Action */
.table-data2 td:nth-child(10) {
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
.table-data2 td:nth-child(6) {
    position: relative;
}

/* Optional: Add tooltip for long text */
.table-data2 td:nth-child(6)[title] {
    cursor: help;
}

/* Ensure table cells align properly */
.table-data2 th,
.table-data2 td {
    vertical-align: middle !important;
}

/* Ensure action buttons are aligned in one line */
.action-buttons {
    display: flex;
    gap: 10px; /* Space between buttons */
}
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;
let pollingInterval;

// Function to load table data
function loadTableData(page = 1) {
    const searchTerm = document.getElementById('searchBar').value.toLowerCase();
    fetch(`./data/witjab_reviews_data.php?page=${page}&limit=${rowsPerPage}&search=${searchTerm}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // Get the response as text
        })
        .then(text => {
            try {
                const data = JSON.parse(text); // Parse the text to JSON
                if (!data.success) {
                    throw new Error(data.error);
                }
                renderTable(data.data);
                renderPagination(data.pagination);
            } catch (error) {
                throw new Error('Invalid JSON: ' + text); // Handle JSON parsing errors
            }
        })
        .catch(error => {
            console.error('Error loading data:', error);
            document.getElementById('reviews-table-body').innerHTML = 
                '<tr><td colspan="10" class="text-center">Error loading data: ' + error.message + '</td></tr>';
        });
}

// Function to render table
function renderTable(reviews) {
    const tableBody = document.getElementById('reviews-table-body');
    tableBody.innerHTML = '';

    reviews.forEach(review => {
        const row = `
            <tr class='tr-shadow'>
                <td>${esc(review.id)}</td>
                <td>${esc(review.name)}</td>
                <td>${esc(review.post)}</td>
                <td>${esc(review.company)}</td>
                <td>${esc(review.stars)}</td>
                <td title="${esc(review.text)}">${esc(review.text)}</td>
                <td>${esc(review.visibility)}</td>
                <td>${esc(review.createdAt)}</td>
                <td>${esc(review.updatedAt)}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm" onclick="toggleVisibility(${esc(review.id)})">
                            Toggle Visibility
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteReview(${esc(review.id)})">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            <tr class='spacer'></tr>
        `;
        tableBody.innerHTML += row;
    });
}

// Function to render pagination
function renderPagination(pagination) {
    const paginationContainer = document.getElementById('pagination');
    let paginationHTML = '';

    // Previous button
    paginationHTML += `
        <li class="page-item ${esc(pagination.current_page === 1 ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${esc(pagination.current_page - 1)})" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;

    // Page numbers
    for (let i = 1; i <= pagination.total_pages; i++) {
        paginationHTML += `
            <li class="page-item ${esc(pagination.current_page === i ? 'active' : '')}">
                <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${i})">${i}</a>
            </li>
        `;
    }

    // Next button
    paginationHTML += `
        <li class="page-item ${esc(pagination.current_page === pagination.total_pages ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${esc(pagination.current_page + 1)})" aria-label="Next">
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

// Function to start polling
function startPolling() {
    loadTableData(currentPage);
    pollingInterval = setInterval(() => {
        loadTableData(currentPage);
    }, 3000);
}

// Start polling when the page loads
document.addEventListener('DOMContentLoaded', () => {
    startPolling();
});

// Function to delete review
function deleteReview(id) {
    if (confirm('Are you sure you want to delete this review?')) {
        const params = new URLSearchParams();
        params.append('id', id);

        fetch(`./data/delete_review.php`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: params.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Review deleted successfully');
                loadTableData(currentPage);
            } else {
                alert('Error deleting review: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error deleting review:', error);
            alert('Error deleting review: ' + error.message);
        });
    }
}

// Function to toggle review visibility
function toggleVisibility(id) {
    fetch(`./data/toggle_review_visibility.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadTableData(currentPage);
        } else {
            alert('Error toggling visibility: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error toggling visibility:', error);
        alert('Error toggling visibility: ' + error.message);
    });
}

// Function to search reviews
function searchReviews() {
    currentPage = 1;
    loadTableData();
}
</script>
