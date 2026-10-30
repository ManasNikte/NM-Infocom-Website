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
                    <h3 class="text-primary">About Slides Management</h3>
                    <small class="text-muted">Manage about slides</small>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="reviewsTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary text-center">ID</th>
                            <th class="text-primary text-center">Title</th>
                            <th class="text-primary text-center">Description</th>
                            <th class="text-primary text-center">Points</th>
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
        <!-- Modal for viewing about points -->
        <div class="modal fade" id="viewPointsModal" tabindex="-1" role="dialog" aria-labelledby="viewPointsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPointsModalLabel">About Points</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-primary">Point ID</th>
                                        <th class="text-primary">Heading</th>
                                        <th class="text-primary">Description</th>
                                    </tr>
                                </thead>
                                <tbody id="pointsTableBody">
                                    <!-- Will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for editing about points -->
        <div class="modal fade" id="editPointsModal" tabindex="-1" role="dialog" aria-labelledby="editPointsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPointsModalLabel">Edit About Points</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editPointsForm">
                            <input type="hidden" id="editAboutId" name="about_id">
                            <div id="editPointsContainer">
                                <!-- Points fields will be dynamically added here -->
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
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
    width: 180px;
    text-align: center;
}

.table-data2 th:nth-child(3), /* Title */
.table-data2 td:nth-child(3) {
    width: 300px;
}

.table-data2 th:nth-child(4), /* Description */
.table-data2 td:nth-child(4) {
    width: 250px;
}

.table-data2 th:nth-child(6), /* Date Added */
.table-data2 td:nth-child(6) {
    width: 100px;
}

.table-data2 th:nth-child(7), /* Last Modified */
.table-data2 td:nth-child(7) {
    width: 100px;
}

.table-data2 th:nth-child(8), /* Actions */
.table-data2 td:nth-child(8) {
    width: 200px;
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

#aboutPointsModal .table {
    margin-bottom: 0;
}

#aboutPointsModal .table th,
#aboutPointsModal .table td {
    padding: 12px 15px;
    vertical-align: middle;
}

#aboutPointsModal .table tbody tr {
    transition: all 0.3s;
}

#aboutPointsModal .table tbody tr:hover {
    background-color: #f8f9fa;
}

#pointsCountBadge {
    font-size: 0.9rem;
    padding: 8px 12px;
}

#aboutPointsModal .badge-light {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 500;
    padding: 5px 10px;
}

#viewPointsModal .table {
    margin-bottom: 0;
}

#viewPointsModal .table th,
#viewPointsModal .table td {
    padding: 12px 15px;
    vertical-align: middle;
}

#viewPointsModal .badge-light {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 500;
    padding: 5px 10px;
}

#viewPointsModal .table tbody tr {
    transition: all 0.3s;
}

#viewPointsModal .table tbody tr:hover {
    background-color: #f8f9fa;
}

#pointsCountBadge {
    font-size: 0.9rem;
    padding: 8px 12px;
}

#aboutSectionHeader {
    font-size: 1.1rem;
    font-weight: 500;
}

/* Fix modal height to viewport */
.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 1rem);
}

.modal-content {
    max-height: calc(100vh - 1rem);
    overflow-y: auto;
}

/* Ensure the modal body scrolls properly */
.modal-body {
    max-height: calc(100vh - 210px); /* Adjust based on header/footer height */
    overflow-y: auto;
}

/* Fix backdrop height to viewport */
.modal-backdrop {
    height: 100vh;
}
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;
let pollingInterval;

// Function to load table data
function loadTableData(page = 1) {
    console.log('Fetching data for page:', page); // Debug log
    
    fetch(`./data/about_slides_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
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
        const row = `
            <tr class='tr-shadow'>
                <td class="text-center">${esc(slide.slide_id || '')}</td>
                <td class="text-center">${esc(slide.slide_title || '')}</td>
                <td class="text-center">${esc(slide.slide_description || '')}</td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm view-points" 
                            data-about-id="${esc(slide.slide_id)}"
                            data-about-title="${esc(slide.slide_title)}"
                            data-points-count="${esc(slide.points_count)}">
                        <i class="fas fa-eye"></i> View Points (${esc(slide.points_count)})
                    </button>
                </td>
                <td class="text-center">${esc(slide.date_added)}</td>
                <td class="text-center">${esc(slide.last_modified)}</td>
                <td class="text-center">
                    <div class="action-buttons justify-content-center" >
                        <button class="btn btn-primary btn-sm edit-slide" 
                                data-about-id="${esc(slide.slide_id)}"
                                data-heading="${esc(slide.slide_title)}"
                                data-description="${esc(slide.slide_description)}">
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
    // Implement edit functionality
    console.log(`Edit slide ID: ${id}`);
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

// Load the table, then keep it current (crmLiveRefresh)
document.addEventListener('DOMContentLoaded', () => {
    startPolling();
});

// Add some CSS to handle the image and table layout
const style = document.createElement('style');
style.textContent = `
    .table-data2 td {
        vertical-align: middle !important;
    }
    
    .action-buttons {
        display: flex;
        gap: 5px;
    }
    
    .action-buttons button {
        white-space: nowrap;
    }
    
    .table-data2 img {
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
`;
document.head.appendChild(style);

$(document).ready(function() {
    // View About Points Handler
    $(document).on('click', '.view-about-points', function() {
        const aboutId = $(this).data('about-id');
        const modal = $('#aboutPointsModal');
        const tableBody = modal.find('#aboutPointsTableBody');
        
        // Show loading state
        tableBody.html('<tr><td colspan="3" class="text-center">Loading...</td></tr>');
        modal.modal('show');
        
        // Fetch about points data
        $.ajax({
            url: './data/get_about_points.php',
            method: 'GET',
            data: { about_id: aboutId },
            success: function(response) {
                if (response.success) {
                    const rows = response.data.map(point => `
                        <tr>
                            <td><span class="badge badge-light">${esc(point.about_pointsid)}</span></td>
                            <td>${esc(point.heading)}</td>
                            <td>${esc(point.description)}</td>
                        </tr>
                    `).join('');
                    
                    tableBody.html(rows);
                    modal.find('#pointsCountBadge').html(
                        `${esc(response.total_points)} Points`
                    );
                } else {
                    tableBody.html(
                        `<tr><td colspan="3" class="text-center text-muted">
                            ${esc(response.message || 'No points found')}
                        </td></tr>`
                    );
                    modal.find('#pointsCountBadge').html('0 Points');
                }
            },
            error: function() {
                tableBody.html(
                    `<tr><td colspan="3" class="text-center text-danger">
                        Error loading about points
                    </td></tr>`
                );
            }
        });
    });

    // Remove any existing click handlers
    $(document).off('click', '.view-points');
    
    // Add the click handler for view points button
    $(document).on('click', '.view-points', function(e) {
        e.preventDefault();
        const aboutId = $(this).data('about-id');
        const aboutTitle = $(this).data('about-title');
        const pointsCount = $(this).data('points-count');
        console.log('View points clicked:', { aboutId, aboutTitle, pointsCount }); // Debug log
        viewPoints(aboutId, aboutTitle, pointsCount);
    });

    // Edit slide button click handler
    $(document).on('click', '.edit-slide', function() {
        const aboutId = $(this).data('about-id');
        $('#editAboutId').val(aboutId);

        // Fetch points data for the selected about section
        $.ajax({
            url: './data/get_about_points.php',
            method: 'GET',
            data: { about_id: aboutId },
            success: function(response) {
                if (response.success) {
                    const pointsContainer = $('#editPointsContainer');
                    pointsContainer.empty();

                    response.data.forEach(point => {
                        const pointField = `
                            <div class="form-group">
                                <label for="editHeading_${esc(point.about_pointsid)}">Heading</label>
                                <input type="text" class="form-control" id="editHeading_${esc(point.about_pointsid)}" name="points[${esc(point.about_pointsid)}][heading]" value="${esc(point.heading)}" required>
                            </div>
                            <div class="form-group">
                                <label for="editDescription_${esc(point.about_pointsid)}">Description</label>
                                <textarea class="form-control" id="editDescription_${esc(point.about_pointsid)}" name="points[${esc(point.about_pointsid)}][description]" rows="3" required>${esc(point.description)}</textarea>
                            </div>
                        `;
                        pointsContainer.append(pointField);
                    });

                    $('#editPointsModal').modal('show');
                } else {
                    alert('Failed to load points: ' + response.message);
                }
            },
            error: function() {
                alert('Error loading points. Please try again.');
            }
        });
    });

    // Handle form submission for editing points
    $('#editPointsForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: './data/edit_about_points.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#editPointsModal').modal('hide');
                    loadTableData(currentPage);
                } else {
                    alert('Failed to update points: ' + response.message);
                }
            },
            error: function() {
                alert('Error updating points. Please try again.');
            }
        });
    });
});

// Add this function to handle viewing points
function viewPoints(aboutId, aboutTitle, pointsCount) {
    console.log('Opening modal for:', { aboutId, aboutTitle, pointsCount });
    
    // Get modal element
    const modal = $('#viewPointsModal');
    const tableBody = modal.find('#pointsTableBody');
    
    // Update header information before showing modal
    modal.find('#viewPointsModalLabel').text(`About Section: ${aboutTitle}`);
    
    // Show the modal
    modal.modal('show');
    
    // Show loading state
    tableBody.html('<tr><td colspan="3" class="text-center">Loading points...</td></tr>');
    
    // Fetch points data
    $.ajax({
        url: './data/get_about_points.php',
        method: 'GET',
        data: { about_id: aboutId },
        dataType: 'json',
        success: function(response) {
            console.log('Success response:', response);
            
            if (response.success && response.data && response.data.length > 0) {
                const rows = response.data.map(point => `
                    <tr>
                        <td><span class="badge badge-light">${esc(point.about_pointsid)}</span></td>
                        <td>${esc(point.heading || '')}</td>
                        <td>${esc(point.description || '')}</td>
                    </tr>
                `).join('');
                tableBody.html(rows);
            } else {
                tableBody.html(`
                    <tr>
                        <td colspan="3" class="text-center">
                            ${esc(response.message || 'No points found for this section')}
                        </td>
                    </tr>
                `);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            tableBody.html(`
                <tr>
                    <td colspan="3" class="text-center text-danger">
                        Error loading points. Please try again.
                    </td>
                </tr>
            `);
        }
    });
}

// Document ready handler
$(document).ready(function() {
    // Debug check for modal element
    if ($('#viewPointsModal').length === 0) {
        console.error('Modal element not found in DOM');
    }
    
    // Debug check for Bootstrap modal functionality
    if (typeof $.fn.modal === 'undefined') {
        console.error('Bootstrap modal plugin not loaded');
    }
    
    // Remove any existing click handlers
    $(document).off('click', '.view-points');
    
    // Add click handler for view points button
    $(document).on('click', '.view-points', function(e) {
        e.preventDefault();
        const aboutId = $(this).data('about-id');
        const aboutTitle = $(this).data('about-title');
        const pointsCount = $(this).data('points-count');
        console.log('View points clicked:', { aboutId, aboutTitle, pointsCount });
        viewPoints(aboutId, aboutTitle, pointsCount);
    });
});
</script>

<?php

class AboutSlides {

    public function getAboutSlides() {
        try {
            $query = "
                SELECT ap.about_pointsid, ap.about_id, ap.heading, ap.description, ap.date_added, ap.last_modified, 
                       a.about_subintroline, a.status
                FROM about_points ap
                JOIN about a ON ap.about_id = a.about_id
                ORDER BY ap.about_pointsid ASC
            ";  
        } catch (PDOException $e) {
            error_log("Error fetching about slides: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $aboutSlidesObj = new AboutSlides();
    $about_slides = $aboutSlidesObj->getAboutSlides();
} catch (Exception $e) {
    error_log("Error initializing AboutSlides: " . $e->getMessage());
    $about_slides = [];
}
?>