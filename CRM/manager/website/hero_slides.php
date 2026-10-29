<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="text-primary">Hero Slides Management</h3>
                    <small class="text-muted">Manage hero slides</small>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="reviewsTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary text-center">ID</th>
                            <th class="text-primary text-center">Image</th>
                            <th class="text-primary text-center">Title</th>
                            <th class="text-primary text-center">Description</th>
                            <th class="text-primary text-center">Link</th>
                            <th class="text-primary text-center">Date Added</th>
                            <th class="text-primary text-center">Last Modified</th>
                            <th class="text-primary text-center">Actions</th>
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

        <!-- Add this modal HTML just before the closing </div> of main-content -->
        <div class="modal fade" id="editSlideModal" tabindex="-1" role="dialog" aria-labelledby="editSlideModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editSlideModalLabel">Edit Hero Slide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="editSlideForm">
                  <input type="hidden" id="editSlideId">
                  
                  <!-- Image Preview and Upload -->
                  <div class="form-group">
                    <label for="slideImage">Current Image</label>
                    <div class="mb-2">
                      <img id="currentSlideImage" src="" alt="Current Slide" class="img-fluid" style="max-height: 200px;">
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="newSlideImage" accept="image/*">
                      <label class="custom-file-label" for="newSlideImage">Choose new image...</label>
                    </div>
                  </div>

                  <!-- Title -->
                  <div class="form-group">
                    <label for="slideTitle">Title</label>
                    <input type="text" class="form-control" id="slideTitle" placeholder="Enter slide title">
                  </div>

                  <!-- Description -->
                  <div class="form-group">
                    <label for="slideDescription">Description</label>
                    <textarea class="form-control" id="slideDescription" rows="3" placeholder="Enter slide description"></textarea>
                  </div>

                  <!-- Link -->
                  <div class="form-group">
                    <label for="slideLink">Link</label>
                    <input type="url" class="form-control" id="slideLink" placeholder="Enter slide link">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSlideChanges">Save changes</button>
              </div>
            </div>
          </div>
        </div>
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
    min-width: 1000px;
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
    width: 60px;
    padding-left: 15px !important;
}

.table-data2 th:nth-child(2), /* Image */
.table-data2 td:nth-child(2) {
    width: 120px;
    text-align: center;
}

.table-data2 th:nth-child(3), /* Title */
.table-data2 td:nth-child(3) {
    width: 150px;
}

.table-data2 th:nth-child(4), /* Description */
.table-data2 td:nth-child(4) {
    width: 250px;
}

.table-data2 th:nth-child(5), /* Link */
.table-data2 td:nth-child(5) {
    width: 200px;
}

.table-data2 th:nth-child(6), /* Date Added */
.table-data2 td:nth-child(6) {
    width: 150px;
}

.table-data2 th:nth-child(7), /* Last Modified */
.table-data2 td:nth-child(7) {
    width: 180px;
}

.table-data2 th:nth-child(8), /* Actions */
.table-data2 td:nth-child(8) {
    width: 220px;
    text-align: right;
    padding-right: 15px !important;
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
    text-align: left;
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
    padding: 8px 15px !important;
}

/* Ensure action buttons are aligned in one line */
.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;
let pollingInterval;

// Function to load table data
function loadTableData(page = 1) {
    console.log('Fetching data for page:', page); // Debug log
    
    fetch(`./data/hero_slides_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Received data:', data); // Debug log
            renderTable(data.slides);
            renderPagination(data.pagination);
        })
        .catch(error => {
            console.error('Error loading data:', error);
            document.getElementById('reviews-table-body').innerHTML = 
                '<tr><td colspan="8" class="text-center">Error loading data: ' + error.message + '</td></tr>';
        });
}

// Function to render table
function renderTable(slides) {
    console.log('Rendering slides:', slides);
    const tableBody = document.getElementById('reviews-table-body');
    
    if (!slides || slides.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="8" class="text-center">No slides found</td></tr>';
        return;
    }

    tableBody.innerHTML = '';
    slides.forEach(slide => {
        const dateAdded = new Date(slide.date_added).toLocaleString();
        const lastModified = new Date(slide.last_modified).toLocaleString();
        
        const row = `
            <tr class='tr-shadow' data-slide-id="${esc(slide.slide_id)}">
                <td class="text-center">${esc(slide.slide_id || '')}</td>
                <td class="text-center">
                    <img src="../../../${esc(slide.slide_img || '')}" alt="Slide Image" 
                         style="max-width: 100px; height: auto;" 
                         onerror="this.src='assets/img/hero/placeholder-image.jpg'">
                </td>
                <td class="text-center">${esc(slide.slide_title || '')}</td>
                <td class="text-center">${esc(slide.slide_description || '')}</td>
                <td class="text-center">${esc(slide.link || '')}</td>
                <td class="text-center">${dateAdded}</td>
                <td class="text-center">${lastModified}</td>
                <td class="text-center">
                    <div class="action-buttons d-flex justify-content-center">
                        <button class="btn btn-primary btn-sm" onclick="editSlide(${esc(slide.slide_id)})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                </td>
            </tr>
            <tr class='spacer'></tr>
        `;
        tableBody.innerHTML += row;
    });
}

// Function to edit slide
function editSlide(id) {
    // Find the slide data from the current table
    const slideRow = document.querySelector(`tr[data-slide-id="${id}"]`);
    if (!slideRow) return;

    // Populate the modal with current data
    document.getElementById('editSlideId').value = id;
    document.getElementById('currentSlideImage').src = slideRow.querySelector('img').src;
    document.getElementById('slideTitle').value = slideRow.querySelector('td:nth-child(3)').textContent;
    document.getElementById('slideDescription').value = slideRow.querySelector('td:nth-child(4)').textContent;
    document.getElementById('slideLink').value = slideRow.querySelector('td:nth-child(5)').textContent;

    // Show the modal
    $('#editSlideModal').modal('show');
}

// Function to update order
function updateOrder(id) {
    const newOrder = prompt("Enter new display order:");
    if (newOrder !== null) {
        fetch(`./data/hero_slides_data.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'updateOrder',
                slide_id: id,
                new_order: newOrder
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTableData(currentPage);
            } else {
                alert('Failed to update order');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Function to delete slide
function deleteSlide(id) {
    if (confirm('Are you sure you want to delete this slide?')) {
        fetch(`./data/hero_slides_data.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'delete',
                slide_id: id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTableData(currentPage);
            } else {
                alert('Failed to delete slide');
            }
        })
        .catch(error => console.error('Error:', error));
    }
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

// Add event listener for file input change
document.getElementById('newSlideImage').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Choose new image...';
    e.target.nextElementSibling.textContent = fileName;
});

// Add some CSS for the modal
const modalStyle = document.createElement('style');
modalStyle.textContent = `
    #editSlideModal .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    #currentSlideImage {
        display: block;
        margin: 0 auto;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .custom-file-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
`;
document.head.appendChild(modalStyle);
</script>