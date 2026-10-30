<?php 
require_once './top.php';
$includeOnly = true;
require_once './data/leads_data.php';
?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './Analytics/marketing_emp_cards.php';?> 
            <div class="row">
              <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="card">
                  <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 24px 24px 20px 24px; display: flex; flex-direction: column; align-items: flex-start; min-height: 60px;">
                    <span style="color: #fff; font-size: 2rem; font-weight: 800; line-height: 1.1; margin-bottom: 0.2rem;">Leads Management</span>
                    <span style="color: #fff; font-size: 1.1rem; font-weight: 500; opacity: 0.95;">Manage and track all sales leads</span>
                  </div>
                  <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search leads...">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="zmdi zmdi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select id="statusFilter" class="form-control custom-select">
                                <option value="">Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="connected">Connected</option>
                                <option value="not_connected">Not Connected</option>
                                <option value="positive">Positive</option>
                                <option value="negative">Negative</option>
                                <option value="confused">Confused</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" id="dateFilter" class="form-control custom-select" 
                                   title="Filter by last modified date">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-block" id="addNewLead">
                                <i class="zmdi zmdi-plus mr-2"></i>Add New Lead
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary text-center">Lead ID</th>
                            <th class="text-primary text-center">Name</th>
                            <th class="text-primary text-center">Contact No</th>
                            <th class="text-primary text-center">Email ID</th>
                            <th class="text-primary text-center">Interested Product</th>
                            <th class="text-primary text-center">Quantity</th>
                            <th class="text-primary text-center">Added On</th>
                            <th class="text-primary text-center">Last Modified</th>
                            <th class="text-primary text-center">Assigned To</th>
                            <th class="text-primary text-center">Added By</th>
                            <th class="text-primary text-center">Status</th>
                            <th class="text-primary text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody id="leadsTableBody">
                          <!-- Table body will be populated by JavaScript -->
                        </tbody>
                      </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted showing-entries" id="showingEntries">
                                <!-- Entries info will be populated by JavaScript -->
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0" id="paginationContainer">
                                    <!-- Pagination will be populated by JavaScript -->
                                </ul>
                            </nav>
                        </div>
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

<!-- Add New Lead Modal -->
<!-- Removed Bootstrap modal for Add Lead -->

<!-- Edit Lead Modal -->
<!-- Removed Bootstrap modal for Edit Lead -->

<?php require './bottom.php'; ?>

<style>
.card {
  border-radius: 20px;
  box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
  background: #fff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  min-height: 100%;
  border: none;
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
  padding: 24px 24px 20px 24px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
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
  min-width: 1500px;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  table-layout: relative;
  border-collapse: separate;
  border-spacing: 0;
}
.table-data2 th, .table-data2 td {
  padding: 12px 8px !important;
  vertical-align: middle !important;
  white-space: normal !important;
  overflow: visible !important;
  text-overflow: initial !important;
  word-break: break-word;
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
  height: 8px;
}
.status-badge {
  padding: 5px 10px;
  border-radius: 15px;
  font-size: 0.85rem;
  font-weight: 500;
}
.status-not-connected {
  background-color:rgb(180, 184, 188);
  color:rgb(0, 0, 0);
  align-items: center;
  text-align: center;
}
.status-pending {
  background-color:rgb(0, 0, 0);
  color:rgb(255, 255, 255);
}
.status-positive {
  background-color: #d4edda;
  color: #155724;
}
.status-negative {
  background-color: #f8d7da;
  color: #721c24;
}
.status-confused {
  background-color: #fff3cd;
  color: #856404;
}
.status-completed {
  background-color:rgb(205, 255, 205);
  color:rgb(14, 169, 73);
}
.table-data-feature {
  display: flex;
  justify-content: center;
  gap: 12px;
  min-width: 120px;
}
.table-data-feature .item {
  flex-shrink: 0;
}
.pagination {
  margin: 0;
}
.showing-entries {
  font-size: 0.9rem;
}
@media (max-width: 992px) {
  .table-data2 {
    min-width: 1000px;
  }
  .table-data2 tbody td {
    padding: 8px 4px !important;
    font-size: 0.85rem;
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
  .card-header span {
    font-size: 1.1rem;
  }
  .card {
    margin-bottom: 24px !important;
  }
}
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
.custom-select::-ms-expand {
  display: none;
}
</style>

<script>
$(document).ready(function() {
    let pollingInterval;
    let currentPage = <?php echo $current_page; ?>;
    let isPollingPaused = false;
    let searchTerm = '';
    let statusFilter = '';
    let dateFilter = '';

    // Function to render table row
    function renderTableRow(lead) {

        function getStatusBadge(callStatus, response) {
            if (callStatus === 'not connected' || callStatus === 'not_connected') {
                return '<span class="status-badge status-not-connected">Not Connected</span>';
            }
            if(callStatus === 'pending') {
                return '<span class="status-badge status-pending">Pending</span>';
            }
            
            switch(response) {
                case 'positive':
                    return '<span class="status-badge status-positive">Positive</span>';
                case 'negative':
                    return '<span class="status-badge status-negative">Negative</span>';
                case 'confused':
                    return '<span class="status-badge status-confused">Confused</span>';
                case 'completed':
                    return '<span class="status-badge status-completed">Completed</span>';
                default:
                    return '<span class="status-badge status-not-connected">No Status</span>';
            }
        }

        return `
            <tr class='tr-shadow'>
                <td class='text-center'><span class='badge badge-light'>${esc(lead.lead_id)}</span></td>
                <td class='text-center'>${esc(lead.name)}</td>
                <td class='text-center desc'>${esc(lead.contact)}</td>
                <td class='text-center'>${esc(lead.email)}</td>
                <td class='text-center'>${esc(lead.product)}</td>
                <td class='text-center'>${esc(lead.quantity)}</td>
                <td class='text-center'>${formatDate(lead.added_on)}</td>
                <td class='text-center'>${formatDate(lead.modified)}</td>
                <td class='text-center'>${esc(lead.assigned_to)}</td>
                <td class='text-center'>#ID ${esc(lead.added_by_user)}</td>
                <td class="text-center">
                    ${getStatusBadge(lead.status, lead.response)}
                </td>
                <td class='text-center'>
                    <div class='table-data-feature justify-content-center'>
                        <button class='item btn btn-sm btn-outline-primary mr-2 edit-lead' 
                                data-toggle='tooltip' 
                                data-placement='top' 
                                title='Edit'
                                data-lead-id='${esc(lead.lead_id)}'
                                data-lead-name='${esc(lead.name)}'
                                data-lead-contact='${esc(lead.contact)}'
                                data-lead-email='${esc(lead.email)}'
                                data-lead-product='${esc(lead.product)}'
                                data-lead-quantity='${esc(lead.quantity)}'>
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

        $.ajax({
            url: './data/leads_data.php',
            method: 'GET',
            data: {
                page: page,
                search: searchTerm,
                status: statusFilter,
                date: dateFilter
            },
            beforeSend: function() {
                if (!isPolling) {
                    $('#leadsTableBody').addClass('loading');
                }
            },
            success: function(response) {
                let res = response;
                if (typeof response === 'string') {
                    try { res = JSON.parse(response); } catch (e) { res = {success: false, data: [], pagination: {}, message: 'Unexpected response.'}; }
                }
                if (res.success && Array.isArray(res.data)) {
                    currentPage = page;
                    if (res.data.length === 0) {
                        $('#leadsTableBody').html(`
                            <tr>
                                <td colspan="11" class="text-center">
                                    <p class="text-muted my-3">No results found</p>
                                </td>
                            </tr>
                        `);
                    } else {
                        updateTableBody(res.data);
                    }
                    updatePaginationUI(res.pagination || {});
                    initTooltips();
                    initStatusDropdowns();
                    if (!isPolling) {
                        const params = new URLSearchParams(window.location.search);
                        params.set('page', page);
                        if (searchTerm) params.set('search', searchTerm);
                        if (statusFilter) params.set('status', statusFilter);
                        if (dateFilter) params.set('date', dateFilter);
                        window.history.pushState({}, '', '?' + params.toString());
                    }
                } else {
                    $('#leadsTableBody').html(`
                        <tr><td colspan="11" class="text-center text-danger">Error loading data</td></tr>
                    `);
                }
            },
            error: function() {
                $('#leadsTableBody').html(`
                    <tr><td colspan="11" class="text-center text-danger">Error loading data</td></tr>
                `);
            },
            complete: function() {
                if (!isPolling) {
                    $('#leadsTableBody').removeClass('loading');
                }
            }
        });
    }

    // Function to initialize tooltips
    function initTooltips() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Function to initialize status dropdown handlers
    function initStatusDropdowns() {
        $('.status-dropdown').change(function() {
            var leadId = $(this).data('lead-id');
            var newStatus = $(this).val();
            
            // Pause polling while updating status
            pausePolling();
            
            $(this).removeClass('text-warning text-success')
                .addClass(newStatus === 'completed' ? 'text-success' : 'text-warning');
        });
    }

    // Keep the table current (crmLiveRefresh)
    function startPolling() {
        pollingInterval = crmLiveRefresh(function() {
            loadPage(currentPage, true);
        });
    }

    // Function to pause polling
    function pausePolling() {
        isPollingPaused = true;
    }

    // Function to resume polling
    function resumePolling() {
        isPollingPaused = false;
    }

    // Function to stop polling
    function stopPolling() {
        clearInterval(pollingInterval);
    }

    // Handle pagination clicks
    $(document).on('click', '.page-nav', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        if (!$(this).parent().hasClass('disabled')) {
            // Pause polling during manual navigation
            pausePolling();
            loadPage(page);
            // Resume polling after a short delay
            setTimeout(resumePolling, 500);
        }
    });

    // Handle table hover
    $('.table-responsive').hover(
        function() { pausePolling(); },  // Mouse enter
        function() { resumePolling(); }  // Mouse leave
    );

    // Initialize tooltips and status dropdowns
    initTooltips();
    initStatusDropdowns();

    // Keep the table current (crmLiveRefresh)
    startPolling();

    // Add loading animation styles
    $('<style>')
        .text(`
            .loading {
                opacity: 0.5;
                pointer-events: none;
                transition: opacity 0.3s;
            }
        `)
        .appendTo('head');

    // Clean up on page unload
    $(window).on('unload', function() {
        stopPolling();
    });

    // Add this function to your JavaScript
    function updatePaginationUI(pagination) {
        const paginationContainer = document.getElementById('paginationContainer');
        const showingEntries = document.getElementById('showingEntries');
        let paginationHtml = '';

        // Previous button
        if (pagination.current_page > 1) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link page-nav" href="#" data-page="${esc(pagination.current_page - 1)}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`;
        }

        // Page numbers
        for (let i = 1; i <= pagination.total_pages; i++) {
            paginationHtml += `
                <li class="page-item ${esc(i === pagination.current_page ? 'active' : '')}">
                    <a class="page-link page-nav" href="#" data-page="${i}">${i}</a>
                </li>`;
        }

        // Next button
        if (pagination.current_page < pagination.total_pages) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link page-nav" href="#" data-page="${esc(pagination.current_page + 1)}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`;
        }

        // Update pagination HTML
        paginationContainer.innerHTML = paginationHtml;

        // Update showing entries text
        showingEntries.textContent = `Showing ${esc(pagination.showing_start)} to ${esc(pagination.showing_end)} of ${esc(pagination.total_entries)} entries`;
    }

    // Initialize the page on load
    $(document).ready(function() {
        // Initial load of the first page
        loadPage(currentPage);
        
        // Rest of your existing ready function code...
    });

    // Search and filter functionality
    $('#searchInput, #statusFilter, #dateFilter').on('input change', function() {
        searchTerm = $('#searchInput').val().trim();
        statusFilter = $('#statusFilter').val();
        dateFilter = $('#dateFilter').val();
        pausePolling();
        loadPage(1, false);
        setTimeout(resumePolling, 1000); // Resume polling after 1s
    });

    // Handle Add New Lead button click
    $('#addNewLead').click(function() {
        Swal.fire({
            title: 'Add New Lead',
            html: `
                <input type="text" id="swalLeadName" class="swal2-input" placeholder="Lead Name" required>
                <input type="tel" id="swalLeadContact" class="swal2-input" placeholder="Contact Number" pattern="[0-9]{10}" maxlength="10" required>
                <input type="email" id="swalLeadEmail" class="swal2-input" placeholder="Email" required>
                <input type="text" id="swalLeadProduct" class="swal2-input" placeholder="Interested Product" required>
                <input type="number" id="swalLeadQuantity" class="swal2-input" placeholder="Quantity" required>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Save Lead',
            preConfirm: () => {
                const name = $('#swalLeadName').val().trim();
                const contact = $('#swalLeadContact').val().trim();
                const email = $('#swalLeadEmail').val().trim();
                const product = $('#swalLeadProduct').val().trim();
                const quantity = $('#swalLeadQuantity').val().trim();
                if (!name || !contact || !email || !product || !quantity) {
                    Swal.showValidationMessage('All fields are required');
                    return false;
                }
                if (!/^\d{10}$/.test(contact)) {
                    Swal.showValidationMessage('Contact number must be 10 digits');
                    return false;
                }
                return { name, contact, email, product, quantity };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const newLead = result.value;
                Swal.showLoading();
                $.ajax({
                    url: '../../shared/add_lead.php',
                    method: 'POST',
                    data: { lead: newLead },
                    success: function(response) {
                        let res = response;
                        if (typeof response === 'string') {
                            try { res = JSON.parse(response); } catch (e) { res = {success: false, message: 'Unexpected response.'}; }
                        }
                        if (res.success) {
                            Swal.fire('Success', 'New lead added successfully', 'success');
                            loadPage(currentPage);
                        } else {
                            Swal.fire('Error', res.message || 'Error adding lead', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error adding lead', 'error');
                    }
                });
            }
        });
    });

    // Edit Lead
    $(document).on('click', '.edit-lead', function() {
        const leadId = $(this).data('lead-id');
        const leadName = $(this).data('lead-name');
        const leadContact = $(this).data('lead-contact');
        const leadEmail = $(this).data('lead-email');
        const leadProduct = $(this).data('lead-product');
        const leadQuantity = $(this).data('lead-quantity');
        Swal.fire({
            title: 'Edit Lead',
            html: `
                <input type="text" id="swalEditLeadName" class="swal2-input" placeholder="Lead Name" value="${esc(leadName)}" required>
                <input type="tel" id="swalEditLeadContact" class="swal2-input" placeholder="Contact Number" pattern="[0-9]{10}" maxlength="10" value="${esc(leadContact)}" required>
                <input type="email" id="swalEditLeadEmail" class="swal2-input" placeholder="Email" value="${esc(leadEmail)}" required>
                <input type="text" id="swalEditLeadProduct" class="swal2-input" placeholder="Interested Product" value="${esc(leadProduct)}" required>
                <input type="number" id="swalEditLeadQuantity" class="swal2-input" placeholder="Quantity" value="${esc(leadQuantity)}" required>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Update Lead',
            preConfirm: () => {
                const name = $('#swalEditLeadName').val().trim();
                const contact = $('#swalEditLeadContact').val().trim();
                const email = $('#swalEditLeadEmail').val().trim();
                const product = $('#swalEditLeadProduct').val().trim();
                const quantity = $('#swalEditLeadQuantity').val().trim();
                if (!name || !contact || !email || !product || !quantity) {
                    Swal.showValidationMessage('All fields are required');
                    return false;
                }
                if (!/^\d{10}$/.test(contact)) {
                    Swal.showValidationMessage('Contact number must be 10 digits');
                    return false;
                }
                return { lead_id: leadId, name, contact, email, product, quantity };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const updatedLead = result.value;
                Swal.showLoading();
                $.ajax({
                    url: './data/update_lead.php',
                    method: 'POST',
                    data: { lead: updatedLead },
                    success: function(response) {
                        let res = response;
                        if (typeof response === 'string') {
                            try { res = JSON.parse(response); } catch (e) { res = {success: false, message: 'Unexpected response.'}; }
                        }
                        if (res.success) {
                            Swal.fire('Success', 'Lead updated successfully', 'success');
                            loadPage(currentPage);
                        } else {
                            Swal.fire('Error', res.message || 'Error updating lead', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error updating lead', 'error');
                    }
                });
            }
        });
    });

    // Reset form when modal is closed
    $('#deleteLeadModal').on('hidden.bs.modal', function() {
        $('#deleteLeadForm')[0].reset();
    });

    // Add some CSS for the delete modal
    $('<style>')
        .text(`
            #deleteLeadModal .modal-header {
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            
            #deleteLeadModal .close {
                text-shadow: none;
            }
            
            #deleteLeadModal .close:hover {
                opacity: 1;
                color: #fff;
            }
            
            #deleteReason {
                resize: vertical;
                min-height: 100px;
            }
            
            #deleteLeadModal .modal-footer {
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
            }
        `)
        .appendTo('head');

    // Contact number validation for edit form
    $('#swalEditLeadContact').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
});
</script>



