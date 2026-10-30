<?php 
require_once './top.php';
$includeOnly = true;
require_once './data/vendors_data.php';
?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './Analytics/purchase_emp_cards.php'; ?>
            <div class="row flex-column">
              <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                    <h3 class="mb-0 text-white">Vendor Orders</h3>
                    <small class="text-white-50 ml-3">Manage and track all purchase orders</small>
                  </div>
                  <div class="card-body p-4">
                    <div class="filter-row d-flex flex-wrap flex-md-nowrap align-items-stretch mb-4" style="gap: 1rem;">
                      <div style="flex:1 1 220px;">
                        <div class="input-group h-100">
                          <input type="text" id="searchInput" class="form-control custom-input filter-tall" placeholder="Search orders...">
                          <div class="input-group-append">
                            <span class="input-group-text bg-white border-0"><i class="zmdi zmdi-search"></i></span>
                          </div>
                        </div>
                      </div>
                      <div style="flex:0 1 170px;">
                        <select id="statusFilter" class="form-control custom-input custom-select filter-tall">
                          <option value="">All Status</option>
                          <option value="yes">Previous Deal: Yes</option>
                          <option value="no">Previous Deal: No</option>
                        </select>
                      </div>
                      <div style="flex:0 1 180px;">
                        <button class="btn btn-primary rounded-pill shadow-sm px-4 filter-tall w-100" id="addNewVendor"><i class="zmdi zmdi-plus mr-2"></i>Add New Vendor</button>
                      </div>
                    </div>
                    <div class="table-responsive table-responsive-data2" style="overflow-x: auto;">
                      <table class="table table-data2 table-hover mb-0">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary text-center">Vendor ID</th>
                            <th class="text-primary text-center">Supplier Name</th>
                            <th class="text-primary text-center">Product Category</th>
                            <th class="text-primary text-center">Contact Number</th>
                            <th class="text-primary text-center">Email</th>
                            <th class="text-primary text-center">Address</th>
                            <th class="text-primary text-center">Previous Deal</th>
                            <th class="text-primary text-center">Remarks</th>
                            <th class="text-primary text-center">Date Added</th>
                            <th class="text-primary text-center">Last Modified</th>
                            <th class="text-primary text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody id="leadsTableBody">
                          <!-- Table body will be populated by JavaScript -->
                        </tbody>
                      </table>
                    </div>
                    <!-- Pagination -->
                    <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                      <div class="text-muted showing-entries" id="showingEntries"></div>
                      <nav aria-label="Page navigation">
                        <ul class="pagination mb-0" id="paginationContainer"></ul>
                      </nav>
                    </div>
                  </div>
                </div>
                <!-- END DATA TABLE -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END MAIN CONTENT-->

<!-- Add Remark Modal -->
<div class="modal fade" id="addRemarkModal" tabindex="-1" role="dialog" aria-labelledby="addRemarkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRemarkModalLabel">Add Remark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="addRemarkId">
                <div class="form-group">
                    <label for="remarkText">Remark</label>
                    <textarea class="form-control" id="remarkText" rows="3" 
                              placeholder="Enter your remark here..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveRemark">Save Remark</button>
            </div>
        </div>
    </div>
</div>

<?php require './bottom.php'; ?>


<style>
/* Table Layout and Structure */
.table-responsive-data2 {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin: 0 -15px;  /* Negative margin to counter container padding */
    padding: 0 15px;  /* Add padding back to maintain spacing */
    scrollbar-width: thin;  /* For Firefox */
}

/* Customize scrollbar for webkit browsers */
.table-responsive-data2::-webkit-scrollbar {
    height: 8px;
}

.table-responsive-data2::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.table-responsive-data2::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.table-responsive-data2::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.table-data2 {
    table-layout: relative;
    width: 100%;
    min-width: 1700px;  /* Minimum width to ensure proper column spacing */
}

/* Column widths - Adjusted for better spacing */
.table-data2 th:nth-child(1),
.table-data2 td:nth-child(1) { width: 100px; }  /* Vendor ID */

.table-data2 th:nth-child(2),
.table-data2 td:nth-child(2) { width: 170px; } /* Supplier Name */

.table-data2 th:nth-child(3),
.table-data2 td:nth-child(3) { width: 100px; } /* Product Category */

.table-data2 th:nth-child(4),
.table-data2 td:nth-child(4) { width: 100px; } /* Contact Number */

.table-data2 th:nth-child(5),
.table-data2 td:nth-child(5) { width: 180px; } /* Address - reduced width */

.table-data2 th:nth-child(6),
.table-data2 td:nth-child(6) { width: 270px; }  /* Previous Deal */

.table-data2 th:nth-child(7),
.table-data2 td:nth-child(7) { width: 120px; } /* Remarks */

.table-data2 th:nth-child(8),
.table-data2 td:nth-child(8) { width: 280px; }  /* Date Added */

.table-data2 th:nth-child(9),
.table-data2 td:nth-child(9) { width: 80px; }  /* Last Modified */

.table-data2 th:nth-child(10),
.table-data2 td:nth-child(10) { width: 150px; } /* Email */

.table-data2 th:nth-child(11),
.table-data2 td:nth-child(11) { width: 80px; } /* Actions - increased width */


/* Add horizontal padding to cells */
.table-data2 td, 
.table-data2 th {
    padding: 15px !important;
    vertical-align: middle !important;
}

/* Ensure content doesn't wrap unnecessarily */
.table-data2 td > *,
.table-data2 th > * {
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Allow text wrapping for specific columns */
.table-data2 td:nth-child(2),  /* Supplier Name */
.table-data2 td:nth-child(6),  /* Address */
.table-data2 td:nth-child(8) { /* Remarks */
    white-space: normal ;
    word-wrap: break-word !important; /* Ensure address goes into next line if too long */
    overflow-wrap: break-word !important; /* Ensure address goes into next line if too long */
}

/* Keep other cells from wrapping */
.table-data2 td:nth-child(1),  /* Vendor ID */
.table-data2 td:nth-child(3),  /* Product Category */
.table-data2 td:nth-child(4),  /* Contact Number */
.table-data2 td:nth-child(5),  /* Previous Deal */
.table-data2 td:nth-child(7),  /* Date Added */
.table-data2 td:nth-child(9),  /* Last Modified */
.table-data2 td:nth-child(10) { /* Actions */
    white-space: nowrap;
}

/* Status dropdown container adjustment */
td .status-dropdown {
    max-width: 100%;
    margin: 0 auto;
}

/* Action buttons container adjustment */
.table-data-feature {
    display: flex;
    justify-content: center;
    gap: 8px;
    padding: 0 5px;
    min-width: 100px; /* Ensure minimum width for buttons */
}

.table-data-feature .item {
    flex-shrink: 0;
    transition: all 0.3s;
    padding: 6px 10px;
    white-space: nowrap;
}

/* Ensure the actions cell doesn't wrap or crop content */
.table-data2 td:nth-child(10) {
    padding: 8px 5px !important;
    min-width: 110px;
    white-space: nowrap;
    overflow: visible !important;
}

.table-data2 td:nth-child(10) > * {
    overflow: visible !important;
}

/* Table Header Styling */
.table-data2 thead th {
    font-weight: 600;
    padding: 15px 10px;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

/* Table Body Styling */
.table-data2 tbody td {
    padding: 12px 10px;
    vertical-align: middle;
    font-size: 0.9rem;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Row Styling */
.tr-shadow {
    border-radius: 8px;
    transition: all 0.3s;
}

.tr-shadow:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.spacer {
    height: 8px;
    background-color: transparent;
}

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

/* Action Buttons */
.table-data-feature {
    display: flex;
    justify-content: center;
    gap: 5px;
}

.table-data-feature .item {
    flex-shrink: 0;
    transition: all 0.3s;
}

.table-data-feature .item:hover {
    transform: translateY(-2px);
}

/* Status Dropdown */
.status-dropdown {
    padding: 5px 15px;
    font-size: 0.9rem;
    border: 1px solid #e0e0e0;
    background-color: #fff;
    transition: all 0.3s;
    width: 90%;  /* Adjusted width within the cell */
    min-width: 140px;  /* Increased minimum width */
    margin: 0 auto;
    display: block;
}

.status-dropdown:focus {
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    border-color: #80bdff;
}

/* Pagination Styling */
.pagination {
    margin-bottom: 0;
}

.page-link {
    color: #007bff;
    border: 1px solid #dee2e6;
    padding: 8px 16px;
    transition: all 0.3s;
}

.page-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #0056b3;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}

/* Responsive Adjustments */
@media (max-width: 576px) {
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
}

/* Loading State */
.loading {
    opacity: 0.5;
    pointer-events: none;
    transition: opacity 0.3s;
}

/* Additional Vendor-specific Styles */
.total-cost {
    font-family: 'Roboto Mono', monospace;
    font-weight: 500;
}

.badge-light {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.85rem;
}

/* Specific styling for remarks column */
.table-data2 td:nth-child(7) {
    white-space: normal;
    word-wrap: break-word;
    text-align: center !important;
    padding: 15px 20px !important;
}

.table-data2 td:nth-child(7) span.text-muted {
    display: block;
    line-height: 1.5;
    text-align: center;
}

/* Style for Add Remark button */
.table-data2 td:nth-child(7) .add-remark {
    display: inline-block;
    margin: 0 auto;
}

/* Override the general cell styles for remarks */
.table-data2 td:nth-child(7) > * {
    white-space: normal;
    overflow: visible;
    text-overflow: clip;
}

/* Add styles for date columns */
.table-data2 td:nth-child(8),
.table-data2 td:nth-child(9) {
    font-size: 0.85rem;
    color: #6c757d;
    white-space: nowrap;
}

.swal2-popup-vendor {
    max-height: 95vh !important;
    overflow-y: auto !important;
    box-sizing: border-box;
    padding-bottom: 0 !important;
    max-width: 380px !important;
    border-radius: 12px !important;
    background: #f9fbfd !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10) !important;
}
.swal2-form-grid {
    display: flex;
    flex-direction: column;
    gap: 10px;
    background: #fff;
    border-radius: 8px;
    padding: 18px 12px 10px 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.swal2-form-grid label {
    font-size: 0.97rem;
    font-weight: 500;
    color: #2d3a4a;
    margin-bottom: 2px;
    margin-top: 2px;
    letter-spacing: 0.01em;
}
.swal2-popup-vendor .swal2-input, .swal2-popup-vendor .swal2-textarea, .swal2-popup-vendor .swal2-select {
    font-size: 0.97rem !important;
    padding: 7px 10px !important;
    border-radius: 5px !important;
    border: 1px solid #dbe5ef !important;
    background: #f7fafc !important;
    margin-bottom: 2px;
}
.swal2-popup-vendor .swal2-input:focus, .swal2-popup-vendor .swal2-textarea:focus, .swal2-popup-vendor .swal2-select:focus {
    border-color: #7abaff !important;
    background: #fff !important;
    outline: none !important;
}
.swal2-popup-vendor .swal2-textarea {
    min-height: 60px;
    resize: vertical;
}
@media (max-width: 600px) {
    .swal2-popup-vendor {
        max-width: 98vw !important;
        padding: 6px !important;
    }
    .swal2-form-grid {
        gap: 6px;
        padding: 10px 4px 6px 4px;
    }
    .swal2-input, .swal2-textarea {
        font-size: 0.97rem !important;
    }
}
</style>

<script>
$(document).ready(function() {
    let pollingInterval;
    let currentPage = 1;
    let isPollingPaused = false;
    let searchTerm = '';
    let statusFilter = '';

    // Function to render table row
    function renderTableRow(lead) {
        const remarkContent = lead.remarks ? 
            `<span class="text-muted">${esc(lead.remarks)}</span>` : 
            `<button class="btn btn-sm btn-outline-info add-remark" 
                data-lead-id="${esc(lead.vendor_id)}">
                <i class="zmdi zmdi-plus mr-1"></i>Add Remark
            </button>`;

        return `
            <tr class='tr-shadow'>
                <td class='text-center'><span class='badge badge-light'>${esc(lead.vendor_id)}</span></td>
                <td class='text-center'>${esc(lead.supplier_name)}</td>
                <td class='text-center'>${esc(lead.product_category)}</td>
                <td class='text-center'>${esc(lead.contact_number)}</td>
                <td class='text-center'>${esc(lead.email)}</td>
                <td class='text-center'>${esc(lead.address)}</td>
                <td class='text-center'>
                    <span class="badge ${esc(lead.previous_deal === 'Yes' ? 'badge-success' : 'badge-secondary')}">
                        ${esc(lead.previous_deal)}
                    </span>
                </td>
                <td class='text-center'>${remarkContent}</td>
                <td class='text-center'>${esc(lead.date_added || '-')}</td>
                <td class='text-center'>${esc(lead.date_modified || '-')}</td>
                <td class='text-center'>
                    <div class='table-data-feature'>
                        <button class='item btn btn-sm btn-outline-primary mr-2 edit-lead' 
                                data-toggle='tooltip' 
                                data-placement='top' 
                                title='Edit'
                                data-lead-id='${esc(lead.vendor_id)}'
                                data-supplier-name='${esc(lead.supplier_name)}'
                                data-product-category='${esc(lead.product_category)}'
                                data-contact-number='${esc(lead.contact_number)}'
                                data-email='${esc(lead.email)}'
                                data-address='${esc(lead.address)}'
                                data-previous-deal='${esc(lead.previous_deal)}'
                                data-remarks='${esc(lead.remarks)}'>
                            <i class='zmdi zmdi-edit'></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class='spacer'></tr>`;
    }

    // Function to format date
    function formatDate(dateStr) {
        const parts = dateStr.split('-');
        // Check if the date is already in dd-mm-yyyy format
        if (parts[0].length === 2) {
            return dateStr; // Return as is if already in correct format
        }
        // Convert from yyyy-mm-dd to dd-mm-yyyy
        const date = new Date(dateStr);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    // Function to update table body
    function updateTableBody(leads) {
        const tableBody = document.getElementById('leadsTableBody');
        tableBody.innerHTML = leads.map(lead => renderTableRow(lead)).join('');
    }

    // Function to load page data
    function loadPage(page, isPolling = false) {
        if (isPollingPaused && isPolling) return;

        // Get filter values safely using optional chaining
        const statusFilter = $('#statusFilter').val() || '';
        const searchTerm = $('#searchInput').val()?.trim() || '';

        $.ajax({
            url: './data/vendors_data.php',
            method: 'GET',
            data: {
                page: page,
                searchInput: searchTerm,
                status: statusFilter
            },
            beforeSend: function() {
                if (!isPolling) {
                    $('#leadsTableBody').addClass('loading');
                }
            },
            success: function(response) {
                if (response.success) {
                    currentPage = page;
                    updateTableBody(response.data);
                    updatePaginationUI(response.pagination);
                    
                    if (!isPolling) {
                        window.history.pushState({page: page}, '', `?page=${page}`);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Page load error:', error);
                if (!isPolling) {
                    toastr.error('Error loading data');
                }
            },
            complete: function() {
                if (!isPolling) {
                    $('#leadsTableBody').removeClass('loading');
                }
            }
        });
    }

    // Function to update pagination UI
    function updatePaginationUI(pagination) {
        const paginationContainer = document.getElementById('paginationContainer');
        const showingEntries = document.getElementById('showingEntries');
        let paginationHtml = '';

        // Don't show pagination if there's only one page
        if (pagination.total_pages <= 1) {
            paginationContainer.innerHTML = '';
            showingEntries.textContent = pagination.total_entries > 0 
                ? `Showing all ${esc(pagination.total_entries)} entries` 
                : 'No entries to show';
            return;
        }

        // Calculate page range
        let startPage = Math.max(1, pagination.current_page - 2);
        let endPage = Math.min(pagination.total_pages, startPage + 4);
        
        // Adjust start if we're near the end
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }

        // Previous button
        paginationHtml += `
            <li class="page-item ${esc(pagination.current_page === 1 ? 'disabled' : '')}">
                <a class="page-link" href="#" data-page="${esc(pagination.current_page - 1)}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

        // First page
        if (startPage > 1) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="1">1</a>
                </li>`;
            if (startPage > 2) {
                paginationHtml += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>`;
            }
        }

        // Page numbers
        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += `
                <li class="page-item ${esc(i === pagination.current_page ? 'active' : '')}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
        }

        // Last page
        if (endPage < pagination.total_pages) {
            if (endPage < pagination.total_pages - 1) {
                paginationHtml += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>`;
            }
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${esc(pagination.total_pages)}">${esc(pagination.total_pages)}</a>
                </li>`;
        }

        // Next button
        paginationHtml += `
            <li class="page-item ${esc(pagination.current_page === pagination.total_pages ? 'disabled' : '')}">
                <a class="page-link" href="#" data-page="${esc(pagination.current_page + 1)}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

        // Update pagination HTML
        paginationContainer.innerHTML = paginationHtml;

        // Update showing entries text
        showingEntries.textContent = pagination.total_entries > 0
            ? `Showing ${esc(pagination.showing_start)} to ${esc(pagination.showing_end)} of ${esc(pagination.total_entries)} entries`
            : 'No entries to show';

        // Add click handlers to pagination links
        $('#paginationContainer').off('click').on('click', '.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page && !$(this).parent().hasClass('disabled') && page !== pagination.current_page) {
                loadPage(page);
            }
        });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initial page load
    loadPage(currentPage);

    // Search input handler
    $('#searchInput').on('input', debounce(function() {
        currentPage = 1;
        loadPage(currentPage);
    }, 300));

    // Filter change handler
    $('#statusFilter').on('change', function() {
        currentPage = 1;
        loadPage(currentPage);
    });

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

    // Keep the table current (crmLiveRefresh)
    function startPolling() {
        pollingInterval = crmLiveRefresh(function() {
            loadPage(currentPage, true);
        });
    }

    // Pause polling
    function pausePolling() {
        isPollingPaused = true;
    }

    // Resume polling
    function resumePolling() {
        isPollingPaused = false;
    }

    // Stop polling
    function stopPolling() {
        clearInterval(pollingInterval);
    }

    // Handle table hover
    $('.table-responsive').hover(
        function() { pausePolling(); },
        function() { resumePolling(); }
    );

    // Keep the table current (crmLiveRefresh)
    startPolling();

    // Clean up on page unload
    $(window).on('unload', function() {
        stopPolling();
    });

    // Add New Vendor button click handler (SweetAlert)
    $('#addNewVendor').click(function() {
        Swal.fire({
            title: 'Add New Vendor',
            customClass: {
                popup: 'swal2-popup-vendor'
            },
            width: '100%',
            maxWidth: 380,
            scrollable: true,
            html: `
                <div class="swal2-form-grid">
                    <input type="text" id="swalSupplierName" class="swal2-input" placeholder="Supplier Name" required>
                    <input type="text" id="swalProductCategory" class="swal2-input" placeholder="Product Category" required>
                    <input type="text" id="swalContactNumber" class="swal2-input" placeholder="Contact Number" required>
                    <input type="email" id="swalEmail" class="swal2-input" placeholder="Email" required>
                    <input type="text" id="swalAddress" class="swal2-input" placeholder="Address" required>
                    <select id="swalPreviousDeal" class="swal2-input" required>
                        <option value="">Previous Deal?</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <textarea id="swalRemarks" class="swal2-textarea" placeholder="Remarks" style="resize:vertical;min-height:60px;"></textarea>
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Save Vendor',
            preConfirm: () => {
                const supplierName = $('#swalSupplierName').val().trim();
                const productCategory = $('#swalProductCategory').val().trim();
                const contactNumber = $('#swalContactNumber').val().trim();
                const email = $('#swalEmail').val().trim();
                const address = $('#swalAddress').val().trim();
                const previousDeal = $('#swalPreviousDeal').val();
                const remarks = $('#swalRemarks').val().trim();
                if (!supplierName || !productCategory || !contactNumber || !email || !address || !previousDeal) {
                    Swal.showValidationMessage('Please fill all required fields');
                    return false;
                }
                return {
                    supplier_name: supplierName,
                    product_category: productCategory,
                    contact_number: contactNumber,
                    email: email,
                    address: address,
                    previous_deal: previousDeal,
                    remarks: remarks
                };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                Swal.showLoading();
                $.ajax({
                    url: './data/vendors_data.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'add_vendor',
                        vendor: result.value
                    },
                    success: function(response) {
                        Swal.close();
                        if (response.success) {
                            Swal.fire('Success', 'New vendor added successfully', 'success');
                            loadPage(currentPage);
                        } else {
                            Swal.fire('Error', response.message || 'Error adding vendor', 'error');
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire('Error', 'Error adding vendor', 'error');
                    }
                });
            }
        });
    });

    // Edit Vendor button click handler (SweetAlert)
    $(document).on('click', '.edit-lead', function() {
        const leadId = $(this).data('lead-id');
        const supplierName = $(this).data('supplier-name');
        const productCategory = $(this).data('product-category');
        const contactNumber = $(this).data('contact-number');
        const email = $(this).data('email');
        const address = $(this).data('address');
        const previousDeal = $(this).data('previous-deal');
        const remarks = $(this).data('remarks');

        Swal.fire({
            title: 'Edit Vendor',
            customClass: {
                popup: 'swal2-popup-vendor'
            },
            width: '100%',
            maxWidth: 380,
            scrollable: true,
            html: `
                <div class="swal2-form-grid">
                    <label for="swalEditSupplierName">Supplier Name</label>
                    <input type="text" id="swalEditSupplierName" class="swal2-input" placeholder="Supplier Name" value="${esc(supplierName)}" required>
                    <label for="swalEditProductCategory">Product Category</label>
                    <input type="text" id="swalEditProductCategory" class="swal2-input" placeholder="Product Category" value="${esc(productCategory)}" required>
                    <label for="swalEditContactNumber">Contact Number</label>
                    <input type="text" id="swalEditContactNumber" class="swal2-input" placeholder="Contact Number" value="${esc(contactNumber)}" required>
                    <label for="swalEditEmail">Email</label>
                    <input type="email" id="swalEditEmail" class="swal2-input" placeholder="Email" value="${esc(email)}" required>
                    <label for="swalEditAddress">Address</label>
                    <input type="text" id="swalEditAddress" class="swal2-input" placeholder="Address" value="${esc(address)}" required>
                    <label for="swalEditPreviousDeal">Previous Deal</label>
                    <select id="swalEditPreviousDeal" class="swal2-input" required>
                        <option value="">Previous Deal?</option>
                        <option value="Yes" ${previousDeal === 'Yes' ? 'selected' : ''}>Yes</option>
                        <option value="No" ${previousDeal === 'No' ? 'selected' : ''}>No</option>
                    </select>
                    <label for="swalEditRemarks">Remarks</label>
                    <textarea id="swalEditRemarks" class="swal2-textarea" placeholder="Remarks" style="resize:vertical;min-height:60px;">${esc(remarks || '')}</textarea>
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Update Vendor',
            preConfirm: () => {
                const supplierName = $('#swalEditSupplierName').val().trim();
                const productCategory = $('#swalEditProductCategory').val().trim();
                const contactNumber = $('#swalEditContactNumber').val().trim();
                const email = $('#swalEditEmail').val().trim();
                const address = $('#swalEditAddress').val().trim();
                const previousDeal = $('#swalEditPreviousDeal').val();
                const remarks = $('#swalEditRemarks').val().trim();
                if (!supplierName || !productCategory || !contactNumber || !email || !address || !previousDeal) {
                    Swal.showValidationMessage('Please fill all required fields');
                    return false;
                }
                return {
                    vendor_id: leadId,
                    supplier_name: supplierName,
                    product_category: productCategory,
                    contact_number: contactNumber,
                    email: email,
                    address: address,
                    previous_deal: previousDeal,
                    remarks: remarks
                };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                Swal.showLoading();
                $.ajax({
                    url: './data/vendors_data.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'update_vendor',
                        vendor: result.value
                    },
                    success: function(response) {
                        Swal.close();
                        if (response.success) {
                            Swal.fire('Success', 'Vendor updated successfully', 'success');
                            loadPage(currentPage);
                        } else {
                            Swal.fire('Error', response.message || 'Error updating vendor', 'error');
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire('Error', 'Error updating vendor', 'error');
                    }
                });
            }
        });
    });

    // Add Remark button click handler
    $(document).on('click', '.add-remark', function() {
        const leadId = $(this).data('lead-id');
        $('#addRemarkId').val(leadId);
        $('#addRemarkModal').modal('show');
    });

    // Save Remark handler
    $('#saveRemark').click(function() {
        const leadId = $('#addRemarkId').val();
        const remark = $('#remarkText').val().trim();
        
        if (!remark) {
            toastr.error('Please enter a remark');
            return;
        }

        const $btn = $(this).prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Saving...'
        );

        $.ajax({
            url: './data/vendors_data.php',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'add_remark',
                vendor_id: leadId,
                remark: remark
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Remark added successfully');
                    $('#addRemarkModal').modal('hide');
                    loadPage(currentPage);
                } else {
                    toastr.error(response.message || 'Error adding remark');
                }
            },
            error: function() {
                toastr.error('Error adding remark');
            },
            complete: function() {
                $btn.prop('disabled', false).html('Save Remark');
            }
        });
    });

    // Reset forms when modals are closed
    $('#addVendorModal, #editLeadModal, #addRemarkModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
    });
});
</script>



