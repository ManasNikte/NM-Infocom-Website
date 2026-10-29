<?php // Employee List page body for the marketing, sales and purchase managers (their own department). ?>
<!-- MAIN CONTENT-->
<div class="main-content" style="min-height: 100vh;">
  <div class="section__content section__content--p30">
    <div class="container-fluid" style="min-height: 90vh; display: flex; flex-direction: column; justify-content: flex-start;">
      <div class="row flex-column">
        <div class="col-md-12">
          <!-- DATA TABLE -->
          <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
            <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
              <h3 class="mb-0 text-white">Employee List</h3>
              <small class="text-white-50 ml-3">Manage and track all employees</small>
            </div>
            <div class="card-body p-4">
              <div class="row mb-4 align-items-end">
                <div class="col-md-4 mb-2 mb-md-0">
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
                    <option value="inactive">Fired</option>
                    <option value="active">On Board</option>
                  </select>
                </div>
                <div class="col-md-3 col-6 mb-2 mb-md-0">
                  <input type="date" id="dateFilter" class="form-control custom-input" title="Filter by date">
                </div>
                <div class="col-md-3 text-right">
                  <span id="loadingSpinner" style="display:none;"><i class="zmdi zmdi-spinner zmdi-hc-spin"></i> Loading...</span>
                </div>
              </div>
              <div class="table-responsive table-responsive-data2">
                <table class="table table-data2 table-hover" id="empTable">
                  <thead class="bg-light sticky-top">
                    <tr>
                      <th class="text-primary text-center">Employee-ID</th>
                      <th class="text-primary text-center">Employee Name</th>
                      <th class="text-primary text-center">Role</th>
                      <th class="text-primary text-center">Resume</th>
                      <th class="text-primary text-center">Date of Joining</th>
                      <th class="text-primary text-center">Date of Resignation</th>
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
.table-responsive-data2 {
  overflow-x: auto;
  display: flex;
  justify-content: center;
  padding: 0;
  margin: 0;
}
.table-data2 {
  min-width: 900px;
  max-width: 1000px;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  table-layout: fixed;
  border-collapse: separate;
  border-spacing: 0;
}
.table-data2 td, .table-data2 th {
  white-space: normal !important;
  overflow: visible !important;
  text-overflow: initial !important;
  word-break: break-word;
  padding: 12px 8px !important;
  vertical-align: middle !important;
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
  text-align: center !important;
  vertical-align: middle !important;
}
@media (max-width: 992px) {
  .main-content {
    min-height: 100vh;
  }
  .container-fluid {
    min-height: 90vh;
  }
  .card {
    margin-bottom: 32px !important;
  }
  .table-data2 {
    min-width: 800px;
  }
  .table-data2 td, .table-data2 th {
    padding: 10px 6px !important;
    font-size: 0.92rem;
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
  .card-header h3, .card-header small {
    font-size: 1.1rem;
  }
  .card {
    margin-bottom: 24px !important;
  }
}
</style>

<script src="<?= $crm ?>vendor/sweetalert/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    let pollingInterval;
    let currentPage = <?php echo isset($_GET['page']) ? intval($_GET['page']) : 1; ?>;
    let isPollingPaused = false;
    let searchTerm = '';
    let statusFilter = '';
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
        return `<tr>
            <td>${esc(lead.lead_id)}</td>
            <td>${esc(lead.name)}</td>
            <td>${esc(lead.role)}</td>
            <td class="text-center">
                ${lead.resume_url ? 
                    `<a href="${esc(lead.resume_url)}" target="_blank" title="View Resume" data-toggle="tooltip">
                        <i class="zmdi zmdi-file-text pdf-icon"></i>
                    </a>` : 
                    '<span class="text-muted">-</span>'
                }
            </td>
            <td>${esc(lead.added_on)}</td>
            <td>${esc(lead.modified || '-')}</td>
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
        tableBody.innerHTML = leads.map(lead => renderTableRow(lead)).join('');
    }

    // Function to load page data
    function loadPage(page, isPolling = false) {
        if (isPollingPaused && isPolling) return;

        // Log the parameters being sent to the server
        console.log('Sending AJAX request with:', {
            page: page,
            search: searchTerm,
            status: statusFilter,
            date: dateFilter
        });

        $.ajax({
            url: '<?= $crm ?>shared/department_staff.php',
            method: 'GET',
            data: {
                page: page,
                search: searchTerm,
                status: statusFilter,
                date: dateFilter
            },
            headers: { 'X-Requested-With': 'XMLHttpRequest' }, // <-- Add this line
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

    // Remove the separate search AJAX call and use loadPage instead
    $('#searchInput').off('input');
    
    // Update status filter handler
    $('#statusFilter').on('change', function() {
        statusFilter = $(this).val();
        $('#leadsTableBody').addClass('loading'); // Add loading state
        loadPage(1, false); // Reset to first page and load filtered results
    });

    // Update date filter handler
    $('#dateFilter').on('change', function() {
        dateFilter = $(this).val();
        loadPage(1, false);
    });

    // --- New Fire Employee Flow ---
    // Delegated event handler for Fire button
    $(document).off('click', '.fire-employee-btn').on('click', '.fire-employee-btn', function() {
        const id = $(this).data('lead-id');
        const name = $(this).data('lead-name');
        // Step 1: Confirm fire
        swal({
            title: "Are you sure?",
            text: `Do you want to fire Employee-ID ${id} Name: ${name}?`,
            icon: "warning",
            buttons: [
                "Cancel",
                {
                    text: "Yes, Fire",
                    value: true,
                    className: "swal-btn-danger"
                }
            ],
            dangerMode: true,
        }).then((willFire) => {
            if (willFire) {
                // Step 2: Ask for reason
                swal({
                    title: "Reason for Firing",
                    text: "Please provide a reason for firing this employee:",
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: "Enter reason...",
                            type: "text"
                        }
                    },
                    buttons: ["Cancel", {text: "Submit", value: true, className: "swal-btn-danger"}],
                    dangerMode: true
                }).then((reason) => {
                    if (reason && reason.trim() !== "") {
                        // Step 3: Send AJAX request
                        swal({
                            title: "Processing...",
                            text: "Firing employee...",
                            buttons: false,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            icon: "info"
                        });
                        $.ajax({
                            url: '<?= $crm ?>shared/fire_employee.php',
                            method: 'POST',
                            data: {
                                lead_id: id,
                                reason: reason.trim()
                            },
                            success: function(response) {
                                swal.close();
                                if (response.success) {
                                    toastr.success('Employee has been fired successfully');
                                    loadPage(currentPage);
                                } else {
                                    toastr.error(response.error || 'Error firing employee');
                                }
                            },
                            error: function(xhr, status, error) {
                                swal.close();
                                toastr.error('Error firing employee');
                            }
                        });
                    } else if (reason !== null) {
                        toastr.error('Please provide a reason for firing.');
                    }
                });
            }
        });
    });

    // Add CSS for swal-btn-danger if not present
    if (!$('head style:contains(".swal-btn-danger")').length) {
        $('head').append(`
        <style>
        .swal-btn-danger {
            background: #d32f2f !important;
            color: #fff !important;
            border-radius: 8px !important;
            border: none !important;
            font-weight: 600 !important;
        }
        .swal-btn-danger:hover, .swal-btn-danger:focus {
            background: #b71c1c !important;
            color: #fff !important;
        }
        </style>
        `);
    }
});
</script>
