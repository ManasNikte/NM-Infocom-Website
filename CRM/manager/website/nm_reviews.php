<?php require_once './top.php'; ?>
<!-- Add SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './analytics/nm_reviews_analytics_cards.php'; ?>
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h3 class="mb-0 text-white"><i class="zmdi zmdi-star-circle mr-2"></i>Reviews Management</h3>
                        <small class="text-white-50">Manage and moderate customer reviews</small>
                      </div>
                      <div class="d-flex align-items-center">
                        <button class="btn btn-light btn-sm" onclick="refreshData()">
                          <i class="zmdi zmdi-refresh"></i> Refresh
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-light">
                              <i class="zmdi zmdi-search text-muted"></i>
                            </span>
                          </div>
                          <input type="text" id="searchBar" class="form-control border-left-0" 
                                 placeholder="Search reviews by name, email, or content..." 
                                 onkeyup="searchReviews()">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                          <select class="form-control form-control-sm mr-2" style="width: auto;" onchange="filterByStatus(this.value)">
                            <option value="">All Status</option>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                            <option value="pending">Pending</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="reviewsTable">
                        <thead class="bg-gradient-light">
                          <tr>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-hash mr-1"></i>ID
                            </th>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-account mr-1"></i>Name
                            </th>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-email mr-1"></i>Email
                            </th>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-phone mr-1"></i>Contact
                            </th>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-badge mr-1"></i>Designation
                            </th>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-star mr-1"></i>Rating
                            </th>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-comment mr-1"></i>Review
                            </th>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-calendar mr-1"></i>Date
                            </th>
                            <th class="text-primary border-0">
                              <i class="zmdi zmdi-label mr-1"></i>Status
                            </th>
                            <th class="text-primary border-0 text-center">
                              <i class="zmdi zmdi-settings mr-1"></i>Actions
                            </th>
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
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-bottom: none;
    padding: 25px;
}

.bg-gradient-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* Input group styling */
.input-group-text {
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Button styling */
.btn-light {
    background-color: rgba(255,255,255,0.9);
    border: 1px solid rgba(255,255,255,0.3);
    color: #333;
}

.btn-light:hover {
    background-color: rgba(255,255,255,1);
    color: #333;
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
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
    border-radius: 8px;
    overflow: hidden;
}

/* Default cell styles */
.table-data2 td {
    white-space: normal !important;
    overflow: visible !important;
    text-overflow: initial !important;
    word-break: break-word;
    padding: 12px 8px !important;
    vertical-align: middle !important;
    font-size: 0.9rem;
    line-height: 1.4;
    border-bottom: 1px solid #f0f0f0;
}

/* Row hover effect */
.table-data2 tbody tr:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
}

/* Column widths */
.table-data2 th:nth-child(1), /* ID */
.table-data2 td:nth-child(1) {
    width: 60px;
    min-width: 60px;
}

.table-data2 th:nth-child(2), /* Name */
.table-data2 td:nth-child(2) {
    width: 120px;
    min-width: 120px;
}

.table-data2 th:nth-child(3), /* Email */
.table-data2 td:nth-child(3) {
    width: 180px;
    min-width: 180px;
}

.table-data2 th:nth-child(4), /* Contact */
.table-data2 td:nth-child(4) {
    width: 120px;
    min-width: 120px;
}

.table-data2 th:nth-child(5), /* Designation */
.table-data2 td:nth-child(5) {
    width: 120px;
    min-width: 120px;
}

.table-data2 th:nth-child(6), /* Rating */
.table-data2 td:nth-child(6) {
    width: 80px;
    min-width: 80px;
}

.table-data2 th:nth-child(7), /* Review */
.table-data2 td:nth-child(7) {
    width: 200px;
    min-width: 200px;
}

.table-data2 th:nth-child(8), /* Date */
.table-data2 td:nth-child(8) {
    width: 100px;
    min-width: 100px;
}

.table-data2 th:nth-child(9), /* Status */
.table-data2 td:nth-child(9) {
    width: 80px;
    min-width: 80px;
}

.table-data2 th:nth-child(10), /* Actions */
.table-data2 td:nth-child(10) {
    width: 120px;
    min-width: 120px;
    text-align: center;
}

/* Header styles */
.table-data2 thead th {
    padding: 15px 8px !important;
    font-weight: 600;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle !important;
    position: sticky;
    top: 0;
    z-index: 1;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Badge styling */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.badge-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    color: white;
}

.badge-info {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
    color: white;
}

.badge-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
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

.pagination .page-link {
  border: none;
  color: #6c757d;
  padding: 8px 12px;
  margin: 0 2px;
  border-radius: 6px;
  transition: all 0.3s ease;
}

.pagination .page-link:hover {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.active .page-link {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  color: white;
  box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.disabled .page-link {
  background-color: #f8f9fa;
  color: #6c757d;
  cursor: not-allowed;
}

#showingEntries {
  font-size: 0.9rem;
  color: #6c757d;
  font-weight: 500;
}

/* Loading state */
.loading {
  opacity: 0.6;
  pointer-events: none;
}

.loading::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 20px;
  height: 20px;
  margin: -10px 0 0 -10px;
  border: 2px solid #667eea;
  border-top: 2px solid transparent;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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

/* Action buttons styling */
.table-data-feature {
    display: flex;
    gap: 6px;
    justify-content: center;
    align-items: center;
}

.table-data-feature .item {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 14px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.table-data-feature .item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.table-data-feature .item:nth-child(1):hover {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
    color: white;
}

.table-data-feature .item:nth-child(2):hover {
    background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
    color: white;
}

/* Make sure action column is always visible */
.table-data2 td:nth-child(10) {
    position: relative;
    z-index: 2;
}

/* Rating stars styling */
.rating-stars {
    color: #ffc107;
    font-size: 0.9rem;
}

/* Empty state styling */
.no-data-message {
    padding: 40px 20px;
    text-align: center;
    color: #6c757d;
    font-style: italic;
}

.no-data-message i {
    font-size: 3rem;
    margin-bottom: 15px;
    opacity: 0.5;
}
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;
let pollingInterval;

// Function to load table data
function loadTableData(page = 1) {
    const searchTerm = document.getElementById('searchBar').value;
    const url = `./data/nm_reviews_data.php?page=${page}&per_page=${rowsPerPage}${searchTerm ? '&search=' + encodeURIComponent(searchTerm) : ''}`;
    
    // Add loading state
    const tableContainer = document.querySelector('.table-responsive');
    tableContainer.classList.add('loading');
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            tableContainer.classList.remove('loading');
            if (data.success) {
                populateTable(data.reviews);
                renderPagination(data.pagination);
                updateShowingEntries(data.pagination);
            } else {
                console.error('Error:', data.error);
                swal('Error', data.error?.message || 'Unknown error', 'error');
            }
        })
        .catch(error => {
            tableContainer.classList.remove('loading');
            console.error('Error loading data:', error);
            swal('Error', 'Error loading data. Please try again.', 'error');
        });
}

// Function to render table
// Function to show review details and handle status change
function showReviewDetails(review) {
    const statusOptions = [
        { value: 'public', text: 'Public', disabled: review.reviewer_status === 'public' },
        { value: 'private', text: 'Private', disabled: review.reviewer_status === 'private' },
        { value: 'pending', text: 'Pending', disabled: review.reviewer_status === 'pending' }
    ];

    // Filter out disabled options if needed
    const availableOptions = statusOptions.filter(option => !option.disabled);
    
    // If current status is pending, only show public option
    const optionsHtml = statusOptions
        .filter(option => {
            if (review.reviewer_status === 'pending') {
                return option.value === 'public';
            }
            return option.value !== 'pending' || review.reviewer_status === 'pending';
        })
        .map(option => 
            `<option value="${esc(option.value)}" ${esc(option.disabled ? 'selected disabled' : '')}>
                ${esc(option.text)} ${esc(option.disabled ? '(Current)' : '')}
            </option>`
        )
        .join('');

    Swal.fire({
        title: 'Review Details',
        html: `
            <div class="text-left">
                <p><strong>Name:</strong> ${esc(review.reviewer_name)}</p>
                <p><strong>Email:</strong> ${esc(review.reviewer_email)}</p>
                <p><strong>Contact:</strong> ${esc(review.reviewer_contact || 'N/A')}</p>
                <p><strong>Designation:</strong> ${esc(review.reviewer_designation || 'N/A')}</p>
                <p><strong>Rating:</strong> ${esc('★'.repeat(review.rating))}${esc('☆'.repeat(5 - review.rating))}</p>
                <p><strong>Status:</strong> 
                    <select id="reviewStatus" class="form-control mt-2">
                        ${optionsHtml}
                    </select>
                </p>
                <div class="form-group mt-3">
                    <label class="font-weight-bold">Review:</label>
                    <div class="border p-2 rounded" style="max-height: 200px; overflow-y: auto;">
                        ${review.review_text.replace(/\n/g, '<br>')}
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update Status',
        cancelButtonText: 'Close',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const newStatus = document.getElementById('reviewStatus').value;
            if (newStatus === review.reviewer_status) {
                Swal.showValidationMessage('Please select a different status');
                return false;
            }
            return updateReviewStatus(review.review_id, newStatus);
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value && result.value.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Review status has been updated.',
                timer: 2000,
                showConfirmButton: false
            });
            // Reload the table data
            loadTableData(currentPage);
        } else if (result.dismiss !== Swal.DismissReason.cancel && result.value && !result.value.success) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.value.message || 'Failed to update review status.'
            });
        }
    });
}

// Function to update review status
function updateReviewStatus(reviewId, newStatus) {
    console.log('Updating review status:', { reviewId, newStatus });
    const formData = new FormData();
    formData.append('action', 'toggle_status');
    formData.append('review_id', reviewId);
    
    return fetch('./data/nm_reviews_actions.php', {
        method: 'POST',
        body: formData
    })
    .then(async response => {
        const text = await response.text();
        console.log('Raw response:', text);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${esc(response.status)}`);
        }
        
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Failed to parse JSON response:', e);
            throw new Error('Invalid JSON response from server');
        }
    })
    .catch(error => {
        console.error('Error updating status:', error);
        return { 
            success: false, 
            message: 'Failed to update status: ' + (error.message || 'Unknown error occurred') 
        };
    });
}

// Function to confirm and delete review
function confirmDeleteReview(reviewId, reviewName) {
    console.log('Deleting review:', { reviewId, reviewName });
    
    Swal.fire({
        title: 'Delete Review',
        html: `Are you sure you want to delete the review by <strong>${reviewName}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('review_id', reviewId);
            
            return fetch('./data/nm_reviews_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(async response => {
                const text = await response.text();
                console.log('Raw delete response:', text);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${esc(response.status)}`);
                }
                
                try {
                    const data = JSON.parse(text);
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to delete review');
                    }
                    return data;
                } catch (e) {
                    console.error('Failed to parse JSON response:', e);
                    throw new Error('Invalid JSON response from server');
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                Swal.showValidationMessage('Failed to delete review: ' + (error.message || 'Unknown error'));
                return { success: false, message: error.message };
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value && result.value.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'The review has been deleted.',
                    timer: 1500,
                    showConfirmButton: false
                });
                // Reload the table data
                loadTableData(currentPage);
            } else {
                Swal.fire(
                    'Error',
                    result.value ? result.value.message : 'Failed to delete review',
                    'error'
                );
            }
        }
    });
}

function populateTable(reviews) {
    const tbody = document.getElementById('reviews-table-body');
    tbody.innerHTML = '';

    if (!reviews || reviews.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="10" class="no-data-message">
                    <i class="zmdi zmdi-star-outline"></i>
                    <div>No reviews found</div>
                    <small class="text-muted">Try adjusting your search criteria or add a new review</small>
                </td>
            </tr>
        `;
        return;
    }

    reviews.forEach(review => {
        const row = document.createElement('tr');
        const rating = review.reviewer_rating || 0;
        const stars = '★'.repeat(rating) + '☆'.repeat(5 - rating);
        const reviewText = review.review_text || '';
        const truncatedText = reviewText.length > 50 ? reviewText.substring(0, 50) + '...' : reviewText;
        
        row.innerHTML = `
            <td><span class="badge badge-secondary">#${esc(review.id || review.review_id || 'N/A')}</span></td>
            <td><strong>${esc(review.reviewer_name || 'N/A')}</strong></td>
            <td><a href="mailto:${esc(review.reviewer_email || '')}" class="text-primary">${esc(review.reviewer_email || 'N/A')}</a></td>
            <td>${esc(review.reviewer_contact || 'N/A')}</td>
            <td><span class="text-muted">${esc(review.reviewer_designation || 'N/A')}</span></td>
            <td><span class="rating-stars" title="${rating}/5 stars">${stars}</span></td>
            <td>
                <div class="review-text" title="${reviewText}">
                    ${truncatedText}
                </div>
            </td>
            <td><small class="text-muted">${esc(new Date(review.created_at || review.reviewer_date || '').toLocaleDateString())}</small></td>
            <td><span class="badge ${getStatusBadgeClass(review.reviewer_status || 'pending')}">${esc(review.reviewer_status || 'pending')}</span></td>
            <td>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm ${esc(review.reviewer_status === 'public' ? 'btn-success' : 'btn-warning')}" 
                            title="View Details" 
                            onclick="event.stopPropagation(); showReviewDetails(${JSON.stringify(review).replace(/"/g, '&quot;')})">
                        <i class="zmdi zmdi-eye"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" 
                            title="Delete Review" 
                            onclick="event.stopPropagation(); confirmDeleteReview(${esc(review.id || review.review_id)}, '${esc((review.reviewer_name || 'this review').replace(/'/g, "\\'"))}')">
                        <i class="zmdi zmdi-delete"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Function to render pagination
function renderPagination(pagination) {
    const paginationContainer = document.getElementById('pagination');
    let paginationHTML = '';

    if (pagination.totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }

    // Previous button
    paginationHTML += `
        <li class="page-item ${pagination.page <= 1 ? 'disabled' : ''}">
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
        <li class="page-item ${esc(pagination.page >= pagination.totalPages ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); changePage(${esc(pagination.page + 1)})" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;

    paginationContainer.innerHTML = `<ul class="pagination">${paginationHTML}</ul>`;
}

// Function to update showing entries
function updateShowingEntries(pagination) {
    const showingEntries = document.getElementById('showingEntries');
    if (showingEntries) {
        showingEntries.textContent = `Showing page ${esc(pagination.page)} of ${esc(pagination.totalPages)}`;
    }
}

// Function to get status badge class
function getStatusBadgeClass(status) {
    switch(status.toLowerCase()) {
        case 'public':
            return 'badge-success';
        case 'private':
            return 'badge-warning';
        case 'pending':
            return 'badge-info';
        default:
            return 'badge-secondary';
    }
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

// Function to search reviews
function searchReviews() {
    currentPage = 1;
    loadTableData(currentPage);
}

// Function to filter by status
function filterByStatus(status) {
    currentPage = 1;
    const searchTerm = document.getElementById('searchBar').value;
    const url = `./data/nm_reviews_data.php?page=${currentPage}&per_page=${rowsPerPage}${searchTerm ? '&search=' + encodeURIComponent(searchTerm) : ''}${status ? '&status=' + encodeURIComponent(status) : ''}`;
    
    // Add loading state
    const tableContainer = document.querySelector('.table-responsive');
    tableContainer.classList.add('loading');
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            tableContainer.classList.remove('loading');
            if (data.success) {
                populateTable(data.reviews);
                renderPagination(data.pagination);
                updateShowingEntries(data.pagination);
            } else {
                console.error('Error:', data.error);
                swal('Error', data.error?.message || 'Unknown error', 'error');
            }
        })
        .catch(error => {
            tableContainer.classList.remove('loading');
            console.error('Error loading data:', error);
            swal('Error', 'Error loading data. Please try again.', 'error');
        });
}

// Function to change rows per page
function changeRowsPerPage(rows) {
    rowsPerPage = parseInt(rows);
    currentPage = 1;
    loadTableData(currentPage);
}

// Function to refresh data
function refreshData() {
    loadTableData(currentPage);
    swal('Data refreshed!', 'Data refreshed successfully!', 'success');
}

// Function to toggle review status (eye icon)
function toggleReviewStatus(id) {
    swal({
        title: 'Change Review Visibility?',
        text: 'Do you want to toggle the visibility status of this review?',
        icon: 'info',
        buttons: true,
        dangerMode: false,
    }).then((willToggle) => {
        if (willToggle) {
            const formData = new FormData();
            formData.append('action', 'toggle_status');
            formData.append('review_id', id);
            fetch('./data/nm_reviews_data.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    swal('Status updated!', `Status changed: ${esc(data.old_status)} → ${esc(data.new_status)}`, 'success');
                    loadTableData(currentPage);
                } else {
                    swal('Error', data.message || 'Failed to update status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                swal('Error', 'Error updating status. Please try again.', 'error');
            });
        }
    });
}

// Function to delete review
function deleteReview(id) {
    swal({
        title: 'Are you sure?',
        text: 'This review will be permanently deleted. This action cannot be undone.',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('review_id', id);
            fetch('./data/nm_reviews_data.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    swal('Deleted!', 'Review deleted successfully.', 'success');
                    loadTableData(currentPage);
                } else {
                    swal('Error', data.message || 'Failed to delete review', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                swal('Error', 'Error deleting review. Please try again.', 'error');
            });
        }
    });
}

// Start polling when the page loads
document.addEventListener('DOMContentLoaded', () => {
    startPolling();
});
</script>