<?php
header('Location: nm_reviews.php');
exit;
?>

<?php require_once './top.php'; ?>

<style>
/* Container and Table Wrapper */
.table-container {
    width: 100%;
    margin: 0;
    padding: 0;
}

.table-responsive {
    overflow-x: auto;
    width: 100%;
    margin: 0;
    padding: 0;
    border-radius: 8px;
    max-height: 400px; /* Decrease the height of the table container */
}

/* Table Core Styles */
.table-data2 {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

/* Fixed Column Widths and Alignment */
.table-data2 th,
.table-data2 td {
    padding: 8px; /* Decrease padding to reduce row height */
    text-align: center !important;
    vertical-align: middle !important;
    height: 40px; /* Decrease height for consistent alignment */
    display: table-cell;
    white-space: nowrap; /* Ensure text values are displayed in one line */
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Column Widths */
.table-data2 th:nth-child(1), .table-data2 td:nth-child(1) { width: 5%; text-align: left !important; }   /* ID */
.table-data2 th:nth-child(2), .table-data2 td:nth-child(2) { width: 10%; }  /* Stars */
.table-data2 th:nth-child(3), .table-data2 td:nth-child(3) { width: 15%; }  /* Name */
.table-data2 th:nth-child(4), .table-data2 td:nth-child(4) { width: 10%; }  /* Post */
.table-data2 th:nth-child(5), .table-data2 td:nth-child(5) { width: 15%; }  /* Company */
.table-data2 th:nth-child(6), .table-data2 td:nth-child(6) { width: 25%; }  /* Review Text */
.table-data2 th:nth-child(7), .table-data2 td:nth-child(7) { width: 10%; }  /* Visibility */
.table-data2 th:nth-child(8), .table-data2 td:nth-child(8) { width: 10%; }  /* Created At */
.table-data2 th:nth-child(9), .table-data2 td:nth-child(9) { width: 10%; }  /* Updated At */
.table-data2 th:nth-child(10), .table-data2 td:nth-child(10) { width: 10%; text-align: left !important; } /* Actions */

/* Review Text Style */
.review-text {
    white-space: pre-wrap;
    max-height: 200px;
    overflow: hidden;
}
</style>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary">Reviews Management</h3>
                    <small class="text-muted">Manage all reviews</small>
                </div>
                <div class="card-body">
                    <!-- Search Bar -->
                    <div class="d-flex justify-content-between mb-3">
                        <input type="text" id="searchBar" class="form-control" placeholder="Search by any column" onkeyup="searchReviews()">
                    </div>
                    
                    <!-- Table -->
                    </div>
                    
                    <!-- Table -->
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-primary">ID</th>
                                    <th class="text-primary">Stars</th>
                                    <th class="text-primary">Name</th>
                                    <th class="text-primary">Designation</th>
                                    <th class="text-primary">Company</th>
                                    <th class="text-primary">Review</th>
                                    <th class="text-primary">Status</th>
                                    <th class="text-primary">Created At</th>
                                    <th class="text-primary">Updated At</th>
                                    <th class="text-primary">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="reviewsTableBody"></tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div class="text-muted" id="showingEntries">
                            <!-- Pagination info will be populated by JavaScript -->
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0" id="paginationContainer"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="deleteReviewId" value="">

<script>
let currentPage = 1;
const rowsPerPage = 3;

function loadReviews() {
    const tableBody = document.getElementById('reviewsTableBody');
    if (!tableBody) {
        console.error('Table body element not found');
        return;
    }

    tableBody.innerHTML = '<tr><td colspan="10" class="text-center">Loading...</td></tr>';

    const searchTerm = document.getElementById('searchBar').value.toLowerCase();
    fetch(`./data/reviews_data.php?page=${currentPage}&limit=${rowsPerPage}&search=${searchTerm}`)
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
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
                updatePagination(data.pagination);
            } catch (error) {
                throw new Error('Invalid JSON: ' + text); // Handle JSON parsing errors
            }
        })
        .catch(error => {
            console.error('Error loading data:', error);
            document.getElementById('reviewsTableBody').innerHTML = 
                '<tr><td colspan="10" class="text-center text-danger">Error loading reviews: ' + error.message + '</td></tr>';
        });
}

function renderTable(data) {
    const tableBody = document.getElementById('reviewsTableBody');
    if (!tableBody) {
        console.error('Table body element not found');
        return;
    }

    if (!data || data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="10" class="text-center">No reviews found</td></tr>';
        return;
    }

    tableBody.innerHTML = data.map(review => `
        <tr>
            <td>${esc(review.id)}</td>
            <td>${esc('⭐'.repeat(review.stars))}</td>
            <td>${esc(review.name)}</td>
            <td>${esc(review.post)}</td>
            <td>${esc(review.company)}</td>
            <td><div class="review-text">${esc(review.text)}</div></td>
            <td>${esc(review.visibility)}</td>
            <td>${esc(new Date(review.createdAt).toLocaleString())}</td>
            <td>${esc(new Date(review.updatedAt).toLocaleString())}</td>
            <td>
                <button class="btn btn-sm btn-secondary mr-1" onclick="toggleReview(${esc(review.id)})">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-primary mr-1" onclick="editReview(${esc(review.id)})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteReview(${esc(review.id)})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

function updatePagination(pagination) {
    const paginationContainer = document.getElementById('paginationContainer');
    if (!paginationContainer) {
        console.error('Pagination container element not found');
        return;
    }

    let paginationHTML = `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">&laquo;</a>
        </li>`;

    for (let i = 1; i <= pagination.total_pages; i++) {
        paginationHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>`;
    }

    paginationHTML += `
        <li class="page-item ${esc(currentPage === pagination.total_pages ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">&raquo;</a>
        </li>`;

    paginationContainer.innerHTML = paginationHTML;
}

function changePage(page) {
    currentPage = page;
    loadReviews();
}

function searchReviews() {
    currentPage = 1;
    loadReviews();
}

function addReview() {
    // Implement the logic to add a new review
    alert('Add new review functionality to be implemented');
}

function deleteReview(reviewId) {
    if (!confirm('Are you sure you want to delete this review?')) {
        return;
    }

    document.getElementById('deleteReviewId').value = reviewId;

    fetch(`./data/delete_review.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${reviewId}`
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.json();
    })
    .then(data => {
        if (!data.success) {
            throw new Error(data.error);
        }
        alert('Review deleted successfully');
        loadReviews();
    })
    .catch(error => {
        console.error('Error deleting review:', error);
        alert('Error deleting review: ' + error.message);
    });
}

function toggleReview(reviewId) {
    // Implement the logic to toggle review visibility/status
    alert('Toggle review functionality to be implemented for review ID: ' + reviewId);
}

document.addEventListener('DOMContentLoaded', () => {
    loadReviews();
});
</script>

<?php require './bottom.php'; ?>