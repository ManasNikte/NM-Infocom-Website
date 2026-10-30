<?php // Company-wide Employee List page body for the admin and HR manager. ?>
<!-- MAIN CONTENT-->
<div class="main-content" style="min-height: 100vh;">
  <div class="section__content section__content--p30">
    <div class="container-fluid" style="min-height: 90vh; display: flex; flex-direction: column; justify-content: flex-start;">
      <div class="row flex-column">
        <div class="col-md-12">
          <!-- DATA TABLE -->
          <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
            <div class="card-header d-flex align-items-center justify-content-between" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; min-height: 60px;">
              <div>
                <h3 class="mb-0 text-white">Employee List</h3>
                <small class="text-white-50 ml-3">Manage and track all employees</small>
              </div>
              <button class="btn btn-light btn-sm rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#addEmployeeModal">
                <i class="zmdi zmdi-plus mr-1"></i> Add User
              </button>
            </div>
            <div class="card-body p-4">
              <div class="row mb-4 align-items-end flex-wrap" style="gap: 8px;">
                <div class="col-md-3 col-12 mb-2 mb-md-0">
                  <div class="input-group">
                    <input type="text" id="searchInput" class="form-control custom-input" placeholder="Search Employee...">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="zmdi zmdi-search"></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 col-6 mb-2 mb-md-0">
                  <select id="statusFilter" class="form-control custom-input custom-select">
                    <option value="">All Status</option>
                    <option value="fired">Fired</option>
                    <option value="active">On Board</option>
                  </select>
                </div>
                <div class="col-md-2 col-6 mb-2 mb-md-0">
                  <select id="roleFilter" class="form-control custom-input custom-select">
                    <option value="">All Roles</option>
                    <option value="Employee">Employee</option>
                    <option value="Manager">Manager</option>
                  </select>
                </div>
                <div class="col-md-2 col-6 mb-2 mb-md-0">
                  <select id="subRoleFilter" class="form-control custom-input custom-select">
                    <option value="">All Sub Roles</option>
                    <option value="sales">Sales</option>
                    <option value="marketing">Marketing</option>
                    <option value="purchase">Purchase</option>
                  </select>
                </div>
                <div class="col-md-2 col-6 mb-2 mb-md-0">
                  <input type="date" id="dateFilter" class="form-control custom-input" title="Filter by date">
                </div>
                <div class="col-md-1 text-right">
                  <span id="loadingSpinner" style="display:none;"><i class="zmdi zmdi-spinner zmdi-hc-spin"></i></span>
                </div>
              </div>
              <div class="table-responsive table-responsive-data2">
                <table class="table table-data2 table-hover" id="empTable">
                  <thead class="bg-light sticky-top">
                    <tr>
                      <th class="text-primary text-center" style="min-width: 70px; max-width: 80px; width: 70px; padding-left: 8px; padding-right: 8px;">ID</th>
                      <th class="text-primary text-center">Name</th>
                      <th class="text-primary text-center">Contact</th>
                      <th class="text-primary text-center">Email</th>
                      <th class="text-primary text-center">Resume</th>
                      <th class="text-primary text-center">DOB</th>
                      <th class="text-primary text-center">Role</th>
                      <th class="text-primary text-center">Sub Role</th>
                      <th class="text-primary text-center">Date of Joining</th>
                      <th class="text-primary text-center">Date of Resignation</th>
                      <th class="text-primary text-center">Last Login</th>
                      <th class="text-primary text-center">Actions</th>
                      <th class="text-primary text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody id="leadsTableBody">
                    <!-- Table body will be populated by JavaScript -->
                  </tbody>
                </table>
              </div>
              <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-muted" id="showingEntries"></div>
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

<!-- Remove the Add Employee Modal -->

<?php require __DIR__ . '/bottom.php'; ?>

<style>
.text-gradient {
  background: linear-gradient(45deg, #1a237e, #4e73df);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.custom-input {
  border-radius: 15px;
  border: 2px solid #e3e6f0;
  padding: 12px;
  font-size: 1rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.custom-input:focus {
  box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
  border-color: #4e73df;
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
.card {
  border-radius: 20px;
  box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
  background: #fff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  min-height: 100%;
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
  padding: 16px 24px;
  display: flex;
  align-items: center;
  min-height: 60px;
}
.card-body {
  font-family: 'Nunito', sans-serif;
  font-size: 1rem;
  color: #2c3e50;
}
/* Modern Employee Table Styles */
.table-responsive-data2 {
  overflow-x: auto;
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
  padding: 0;
  margin: 0;
  width: 100%;
}
.table-data2 {
  min-width: 1300px;
  width: 100%;
  border-radius: 18px;
  border-collapse: separate;
  border-spacing: 0;
  background: #fff;
  font-family: 'Nunito', sans-serif;
  font-size: 1rem;
  color: #2c3e50;
  table-layout: auto;
}
.table-data2 thead th {
  position: sticky;
  top: 0;
  z-index: 2;
  background: #f5f7ff;
  color: #1a237e;
  font-weight: 700;
  font-size: 1.04rem;
  border-bottom: 2px solid #dee2e6;
  padding: 14px 10px !important;
  letter-spacing: 0.02em;
}
.table-data2 th:first-child, .table-data2 td:first-child {
  min-width: 70px !important;
  max-width: 80px !important;
  width: 70px !important;
  padding-left: 8px !important;
  padding-right: 8px !important;
  font-weight: 800;
  color: #4e73df;
  font-size: 1.02rem;
  background: #f5f7ff;
}
.table-data2 td, .table-data2 th {
  white-space: nowrap !important;
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  text-align: center !important;
  vertical-align: middle !important;
  border-right: 1px solid #f0f1f6;
}
.table-data2 td:last-child, .table-data2 th:last-child {
  border-right: none;
}
.table-data2 tbody tr {
  transition: background 0.18s;
}
.table-data2 tbody tr:nth-child(even) {
  background: #f8fafd;
}
.table-data2 tbody tr:hover {
  background: #e3eafe44;
  box-shadow: 0 2px 8px rgba(44, 62, 80, 0.07);
}
.table-data2 td {
  padding: 12px 10px !important;
  font-size: 0.98rem;
}
.table-data2 td .badge-status {
  font-size: 0.95em;
  padding: 0.5em 1.2em;
  border-radius: 20px;
  font-weight: 600;
  display: inline-block;
  letter-spacing: 0.01em;
}
.table-data2 td .badge-onboard {
  background: #e8f5e9;
  color: #388e3c;
}
.table-data2 td .badge-fired {
  background: #ffebee;
  color: #d32f2f;
}
.table-data2 .btn-danger.fire-employee-btn {
  border-radius: 8px;
  padding: 6px 12px;
  font-size: 1.1em;
  box-shadow: 0 2px 6px rgba(211, 47, 47, 0.08);
  transition: background 0.18s, box-shadow 0.18s;
}
.table-data2 .btn-danger.fire-employee-btn:hover {
  background: #b71c1c;
  box-shadow: 0 4px 12px rgba(211, 47, 47, 0.16);
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
  height: 4px;
}
.badge-status {
  font-size: 0.95em;
  padding: 0.5em 1.2em;
  border-radius: 20px;
  font-weight: 600;
  display: inline-block;
  letter-spacing: 0.01em;
}
.badge-onboard {
  background: #e8f5e9;
  color: #388e3c;
}
.badge-fired {
  background: #ffebee;
  color: #d32f2f;
}
.pagination {
  margin: 0;
}
#showingEntries {
  font-size: 0.9rem;
}
.table-data2 th, .table-data2 td {
  white-space: nowrap !important; /* Prevent wrapping */
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  text-align: center !important;
  vertical-align: middle !important;
}
/* Add min-width for Actions and Status columns */
.table-data2 th:nth-child(10), .table-data2 td:nth-child(10) {
  min-width: 110px;
  width: 110px;
}
.table-data2 th:nth-child(11), .table-data2 td:nth-child(11) {
  min-width: 110px;
  width: 110px;
}
.table-data2 th:first-child, .table-data2 td:first-child {
  min-width: 70px !important;
  max-width: 80px !important;
  width: 70px !important;
  padding-left: 8px !important;
  padding-right: 8px !important;
}
@media (max-width: 1200px) {
  .table-data2 {
    min-width: 1000px;
    font-size: 0.97rem;
  }
}
@media (max-width: 992px) {
  .table-data2 {
    min-width: 800px;
    font-size: 0.95rem;
  }
  .table-data2 td, .table-data2 th {
    padding: 10px 6px !important;
  }
  .card-header, .card-body {
    padding: 1rem;
  }
}
@media (max-width: 768px) {
  .table-data2 {
    min-width: 600px;
    font-size: 0.92rem;
  }
  .table-data2 th, .table-data2 td {
    padding: 8px 4px !important;
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
  .card-header h3, .card-header small {
    font-size: 1.1rem;
  }
  .card {
    margin-bottom: 24px !important;
  }
}
</style>

<script>
$(document).ready(function() {
    let pollingInterval;
    let currentPage = <?php echo isset($_GET['page']) ? intval($_GET['page']) : 1; ?>;
    let isPollingPaused = false;
    let searchTerm = '';
    let statusFilter = '';
    let roleFilter = '';
    let subRoleFilter = '';
    let dateFilter = '';

    // Function to render table row
    function renderTableRow(lead) {
        let statusLabel = '';
        let statusClass = '';
        let fireReasonHtml = '';
        if (lead.status === 'fired' || lead.status === 'inactive') {
            statusLabel = 'Fired';
            statusClass = 'badge-fired';
            if (lead.fire_reason) {
                fireReasonHtml = `<div class="text-danger small mt-1">Reason: ${esc(lead.fire_reason)}</div>`;
            }
        } else {
            statusLabel = 'On Board';
            statusClass = 'badge-onboard';
        }
        // PDF icon logic
        let pdfIconHtml = '-';
        if (lead.resume_url && typeof lead.resume_url === 'string' && lead.resume_url.trim() !== '' && lead.resume_url.trim() !== '-') {
            let pdfPath = lead.resume_url;
            if (!pdfPath.startsWith('/')) pdfPath = '/' + pdfPath;
            pdfIconHtml = `<a href="#" class="view-resume-pdf" data-resume-url="<?= $crm ?>../${esc(pdfPath)}" title="View Resume"><i class="zmdi zmdi-file-text pdf-icon" style="font-size:1.3em;color:#d32f2f;"></i></a>`;
        }
        return `<tr>
            <td style="min-width:70px;max-width:80px;width:70px;padding-left:8px;padding-right:8px;">${esc(lead.lead_id)}</td>
            <td>${esc(lead.name)}</td>
            <td>${esc(lead.contact || '-')}</td>
            <td>${esc(lead.email || '-')}</td>
            <td>${pdfIconHtml}</td>
            <td>${esc(lead.dob || '-')}</td>
            <td>${esc(lead.role)}</td>
            <td>${esc(lead.sub_role || '-')}</td>
            <td>${esc(lead.added_on)}</td>
            <td>${esc(lead.modified || '-')}</td>
            <td>${esc(lead.last_login || '-')}</td>
            <td class='text-center'>
                <div class='table-data-feature justify-content-center'>
                    ${lead.status === 'fired' || lead.status === 'inactive' ? '' : `
                    <button class='btn btn-danger fire-employee-btn' data-lead-id='${esc(lead.lead_id)}' data-lead-name='${esc(lead.name)}' title="Fire Employee">
                        <i class="zmdi zmdi-fire"></i>
                    </button>`}
                </div>
                ${fireReasonHtml}
            </td>
            <td class='text-center'>
                <span id="status-${esc(lead.lead_id)}" class='badge badge-status ${statusClass}'>
                    ${statusLabel}
                </span>
            </td>
        </tr>`;
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
        tableBody.innerHTML = '';
        if (Array.isArray(leads) && leads.length > 0) {
            tableBody.innerHTML = leads.map(lead => renderTableRow(lead)).join('');
        } else {
            tableBody.innerHTML = `<tr><td colspan="11" class="text-center text-muted">No employees found for this page.</td></tr>`;
        }
    }

    // Function to load page data
    function loadPage(page, isPolling = false) {
        loadPage.lastArgs = arguments;
        if (isPollingPaused && isPolling) return;

        // Log the parameters being sent to the server
        console.log('Sending AJAX request with:', {
            page: page,
            search: searchTerm,
            status: statusFilter,
            role: roleFilter,
            sub_role: subRoleFilter,
            date: dateFilter
        });

        $.ajax({
            url: '<?= $crm ?>shared/staff_directory.php',
            method: 'GET',
            data: {
                page: page,
                search: searchTerm,
                status: statusFilter,
                role: roleFilter,
                sub_role: subRoleFilter,
                date: dateFilter
            },
            headers: { 'X-Requested-With': 'XMLHttpRequest' }, // <-- Add this line
            dataType: 'json', // Ensure response is parsed as JSON
            success: function(response) {
                // Log the raw response from the server
                console.log('AJAX success, response:', response);

                if (response.success) {
                    $('#leadsTableBody').removeClass('loading');
                    currentPage = page;
                    updateTableBody(response.data);

                    // Log the data used to update the table
                    console.log('Updating table with data:', response.data);

                    updatePaginationUI(response.pagination);
                } else {
                    // Log if the response indicates failure
                    console.error('AJAX response indicates failure:', response);
                }
            },
            error: function(xhr, status, error) {
                $('#leadsTableBody').removeClass('loading');
                // Log AJAX error details
                console.error('AJAX error:', {xhr, status, error});
                toastr.error('Error loading data');
            }
        });
    }
    crmLiveRefresh(function () { loadPage.apply(null, loadPage.lastArgs || []); }); // keep current without polling

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

    // Fix pagination click handler and AJAX response parsing
    $(document).off('click', '.page-nav').on('click', '.page-nav', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        if (!$(this).parent().hasClass('disabled') && page) {
            currentPage = page; // Force update global currentPage
            console.log('Pagination clicked, loading page:', page);
            loadPage(currentPage, false);
            setTimeout(function() { if (typeof resumePolling === 'function') resumePolling(); }, 500);
        }
    });

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
        // stopPolling(); // Removed as polling is no longer automatic
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

    // Search functionality
    $('#searchInput').on('input', function() {
        const searchValue = $(this).val().trim();
        searchTerm = searchValue; // Update the global searchTerm
        console.log('Search input changed:', searchTerm); // Log search input
        
        // Show loading state
        $('#leadsTableBody').addClass('loading');
        
        // Load filtered results
        loadPage(1, false); // Load first page with search term
    });

    // Add a small delay to prevent too many requests
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Apply debounce to the search input
    const debouncedSearch = debounce(function(e) {
        const searchValue = $(e.target).val().trim();
        searchTerm = searchValue;
        console.log('Debounced search input:', searchTerm); // Log debounced input
        loadPage(1, false);
    }, 300);

    $('#searchInput').on('keyup', debouncedSearch);

    // Remove the input event handler entirely and use only debounced keyup
    // Remove the input event handler entirely and use only debounced keyup

    // Update status filter handler
    $('#statusFilter').on('change', function() {
        statusFilter = $(this).val();
        $('#leadsTableBody').addClass('loading');
        loadPage(1, false);
    });

    // Update role filter handler
    $('#roleFilter').on('change', function() {
        roleFilter = $(this).val();
        $('#leadsTableBody').addClass('loading');
        loadPage(1, false);
    });

    // Update sub role filter handler
    $('#subRoleFilter').on('change', function() {
        subRoleFilter = $(this).val();
        $('#leadsTableBody').addClass('loading');
        loadPage(1, false);
    });

    // Update date filter handler
    $('#dateFilter').on('change', function() {
        dateFilter = $(this).val();
        $('#leadsTableBody').addClass('loading');
        loadPage(1, false);
    });

    // Handle form submission
    $('#saveEmployee').click(function() {
        // Validate form
        const form = document.getElementById('addEmployeeForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Get form data
        const newLead = {
            name: $('#empName').val().trim(),
            role: $('#empRole').val(),
            sub_role: $('#empSubRole').val(),
            contact: $('#empContact').val().trim(),
            email: $('#empEmail').val().trim(),
            resume: $('#empResume')[0].files[0], // Get the file object
            joining_date: $('#empJoiningDate').val()
        };

        // Add loading state
        const $btn = $(this).prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Saving...'
        );

        // Send AJAX request
        $.ajax({
            url: '<?= $crm ?>shared/staff_directory.php',
            method: 'POST',
            data: {
                action: 'add_lead',
                lead: newLead
            },
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the content type
            success: function(response) {
                if (response.success) {
                    // Show success message
                    toastr.success('New employee added successfully');
                    
                    // Reset form
                    $('#addEmployeeForm')[0].reset();
                    
                    // Close modal
                    $('#addEmployeeModal').modal('hide');
                    
                    // Reload table data
                    loadPage(currentPage);
                } else {
                    toastr.error(response.message || 'Error adding employee');
                }
            },
            error: function() {
                toastr.error('Error adding employee');
            },
            complete: function() {
                // Reset button state
                $btn.prop('disabled', false).html('Add Employee');
            }
        });
    });

    // Reset form when modal is closed
    $('#addEmployeeModal').on('hidden.bs.modal', function() {
        $('#addEmployeeForm')[0].reset();
    });

    // Add contact number validation
    $('#empContact').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });

    // Edit Lead
    $(document).on('click', '.edit-lead', function() {
        const leadId = $(this).data('lead-id');
        const leadName = $(this).data('lead-name');
        const leadContact = $(this).data('lead-contact');
        const leadProduct = $(this).data('lead-product');
        
        $('#editLeadId').val(leadId);
        $('#editLeadName').val(leadName);
        $('#editLeadContact').val(leadContact);
        $('#editLeadProduct').val(leadProduct);
        
        $('#editLeadModal').modal('show');
    });

    // Update Lead
    $('#updateLead').click(function() {
        const form = document.getElementById('editLeadForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const updatedLead = {
            lead_id: $('#editLeadId').val(),
            name: $('#editLeadName').val().trim(),
            contact: $('#editLeadContact').val().trim(),
            product: $('#editLeadProduct').val()
        };

        const $btn = $(this).prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Updating...'
        );

        $.ajax({
            url: '<?= $crm ?>shared/staff_directory.php',
            method: 'POST',
            data: {
                action: 'update_lead',
                lead: updatedLead
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Lead updated successfully');
                    $('#editLeadModal').modal('hide');
                    loadPage(currentPage);
                } else {
                    toastr.error(response.message || 'Error updating lead');
                }
            },
            error: function() {
                toastr.error('Error updating lead');
            },
            complete: function() {
                $btn.prop('disabled', false).html('Update Lead');
            }
        });
    });

    // Delete Lead
    $(document).on('click', '.delete-lead', function() {
        const leadId = $(this).data('lead-id');
        $('#deleteLeadId').val(leadId);
        $('#deleteLeadModal').modal('show');
    });

    // Confirm Delete
    $('#confirmDelete').click(function() {
        // Validate form
        const form = document.getElementById('deleteLeadForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const leadId = $('#deleteLeadId').val();
        const deleteReason = $('#deleteReason').val().trim();
        
        // Add loading state
        const $btn = $(this).prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Submitting...');

        $.ajax({
            url: '<?= $crm ?>shared/staff_directory.php',
            method: 'POST',
            data: {
                action: 'request_delete_lead',
                lead_id: leadId,
                reason: deleteReason
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Deletion request submitted successfully');
                    $('#deleteLeadModal').modal('hide');
                    loadPage(currentPage); // Reload the current page
                } else {
                    toastr.error(response.message || 'Error submitting deletion request');
                }
            },
            error: function() {
                toastr.error('Error submitting deletion request');
            },
            complete: function() {
                // Reset button state
                $btn.prop('disabled', false)
                    .html('<i class="zmdi zmdi-delete mr-2"></i>Request Deletion');
                
                // Clear the form
                $('#deleteReason').val('');
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
    $('#editLeadContact').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });

    // --- New Fire Employee Flow ---
    // Delegated event handler for Fire button
    $(document).off('click', '.fire-employee-btn').on('click', '.fire-employee-btn', function() {
        const id = $(this).data('lead-id');
        const name = $(this).data('lead-name');
        crmFireEmployee(id, name, '<?= $crm ?>', function () { loadPage(currentPage); });
    });


    // Add User (SweetAlert2). Admins can create any role; HR managers create managers and employees.
    const canCreateAdmin = <?= json_encode(strtolower($role ?? '') === 'admin') ?>;
    $(document).on('click', '[data-target="#addEmployeeModal"]', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Add user',
            html: `
                <form id="swalAddEmployeeForm" style="text-align:left;">
                  <div class="form-group mb-2">
                    <label for="swalEmpName">Full name *</label>
                    <input type="text" class="form-control" id="swalEmpName" maxlength="100" required>
                  </div>
                  <div class="form-group mb-2">
                    <label for="swalEmpEmail">Work email * <small class="text-muted">(login details are sent here)</small></label>
                    <input type="email" class="form-control" id="swalEmpEmail" maxlength="100" placeholder="name@nminfocom.com" required>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-6 mb-2">
                      <label for="swalEmpRole">Role *</label>
                      <select class="form-control" id="swalEmpRole" required>
                        <option value="Employee">Employee</option>
                        <option value="Manager">Manager</option>
                        ${canCreateAdmin ? '<option value="Admin">Admin</option>' : ''}
                      </select>
                    </div>
                    <div class="form-group col-6 mb-2" id="swalEmpSubRoleGroup">
                      <label for="swalEmpSubRole">Department *</label>
                      <select class="form-control" id="swalEmpSubRole">
                        <option value="">Select…</option>
                        <option value="sales">Sales</option>
                        <option value="marketing">Marketing</option>
                        <option value="purchase">Purchase</option>
                        <option value="website">Website</option>
                        <option value="hr">HR</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group mb-2">
                    <label for="swalEmpContact">Phone *</label>
                    <input type="text" class="form-control" id="swalEmpContact" maxlength="10" inputmode="numeric" placeholder="10-digit number" required>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-6 mb-2">
                      <label for="swalEmpDOB">Date of birth *</label>
                      <input type="date" class="form-control" id="swalEmpDOB" required>
                    </div>
                    <div class="form-group col-6 mb-2">
                      <label for="swalEmpJoiningDate">Date of joining *</label>
                      <input type="date" class="form-control" id="swalEmpJoiningDate" required>
                    </div>
                  </div>
                  <div class="form-group mb-0">
                    <label for="swalEmpResume">Resume (PDF, optional, max 5 MB)</label>
                    <input type="file" class="form-control" id="swalEmpResume" accept="application/pdf,.pdf">
                  </div>
                </form>`,
            showCancelButton: true,
            confirmButtonText: 'Create user & email login',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            width: 560,
            didOpen: () => {
                // Admins belong to no department.
                const sync = () => $('#swalEmpSubRoleGroup').toggle($('#swalEmpRole').val() !== 'Admin');
                $('#swalEmpRole').on('change', sync);
                sync();
                $('#swalEmpContact').on('input', function () { this.value = this.value.replace(/\D/g, '').slice(0, 10); });
            },
            preConfirm: () => {
                const fields = {
                    name: $('#swalEmpName').val().trim(),
                    email: $('#swalEmpEmail').val().trim(),
                    role: $('#swalEmpRole').val(),
                    sub_role: $('#swalEmpRole').val() === 'Admin' ? '' : $('#swalEmpSubRole').val(),
                    contact: $('#swalEmpContact').val().trim(),
                    dob: $('#swalEmpDOB').val(),
                    date_of_joining: $('#swalEmpJoiningDate').val(),
                };
                if (!fields.name || !fields.email || !fields.contact || !fields.dob || !fields.date_of_joining || (fields.role !== 'Admin' && !fields.sub_role)) {
                    return Swal.showValidationMessage('Please fill in all required fields.');
                }
                if (!/^\d{10}$/.test(fields.contact)) return Swal.showValidationMessage('Phone must be a 10-digit number.');
                if (!/^\S+@\S+\.\S+$/.test(fields.email)) return Swal.showValidationMessage('Please enter a valid email address.');
                const resume = $('#swalEmpResume')[0].files[0];
                if (resume && resume.type !== 'application/pdf') return Swal.showValidationMessage('Resume must be a PDF file.');

                const formData = new FormData();
                Object.entries(fields).forEach(([k, v]) => formData.append(k, v));
                if (resume) formData.append('resume', resume);
                return fetch('<?= $crm ?>shared/add_employee.php', { method: 'POST', body: formData })
                    .then((r) => r.json())
                    .then((res) => {
                        if (!res.success) throw new Error(res.message || 'Could not add the user.');
                        return res;
                    })
                    .catch((err) => Swal.showValidationMessage(err.message));
            },
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (!result.isConfirmed || !result.value) return;
            const res = result.value;
            loadPage(currentPage);
            if (res.email_sent) {
                Swal.fire({ icon: 'success', title: 'User created', html: `Login details were emailed to <b>${esc(res.email)}</b>.` });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'User created, but the email failed',
                    html: `${esc(res.email_error || '')}<br><br>Share these details with them securely:<br>` +
                          `Email: <code>${esc(res.email)}</code><br>Temporary password: <code>${esc(res.temp_password)}</code>`,
                });
            }
        });
    });

    // Add JS event handler for PDF icon click
    $(document).off('click', '.view-resume-pdf').on('click', '.view-resume-pdf', function(e) {
        e.preventDefault();
        const pdfUrl = $(this).data('resume-url');
        if (pdfUrl && pdfUrl !== '-') {
            Swal.fire({
                title: 'Resume PDF',
                html: `<iframe src='${esc(pdfUrl)}' width='100%' height='500px' style='border:none;'></iframe>`,
                width: 700,
                showCloseButton: true,
                showConfirmButton: false,
                customClass: { popup: 'swal2-popup-custom' }
            });
        }
    });
});
</script>

       