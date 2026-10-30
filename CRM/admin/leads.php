<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content" style="min-height: 100vh;">
        <div class="section__content section__content--p30">
          <div class="container-fluid" style="min-height: 90vh; display: flex; flex-direction: column; justify-content: flex-start;">
            <div class="row mb-4" id="statsCardsRow">
              <div class="col-md-3 col-6 mb-3">
                <div class="card text-center shadow-sm stat-card h-100">
                  <div class="card-body py-3 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon stat-icon-blue mb-2"><i class="zmdi zmdi-plus-circle"></i></div>
                    <div class="stat-title text-primary">New Leads</div>
                    <div class="stat-value" id="statNewLeads">0</div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6 mb-3">
                <div class="card text-center shadow-sm stat-card h-100">
                  <div class="card-body py-3 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon stat-icon-green mb-2"><i class="zmdi zmdi-check-circle"></i></div>
                    <div class="stat-title text-success">Leads Closed</div>
                    <div class="stat-value" id="statLeadsClosed">0</div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6 mb-3">
                <div class="card text-center shadow-sm stat-card h-100">
                  <div class="card-body py-3 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon stat-icon-info mb-2"><i class="zmdi zmdi-thumb-up"></i></div>
                    <div class="stat-title text-info">Won</div>
                    <div class="stat-value" id="statWon">0</div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6 mb-3">
                <div class="card text-center shadow-sm stat-card h-100">
                  <div class="card-body py-3 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon stat-icon-red mb-2"><i class="zmdi zmdi-thumb-down"></i></div>
                    <div class="stat-title text-danger">Lost</div>
                    <div class="stat-value" id="statLost">0</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row flex-column">
              
              <div class="col-md-12">
                <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                    <h3 class="mb-0 text-white">Leads</h3>
                    <small class="text-white-50 ml-3">Contact leads, manage sales and marketing opportunities</small>
                    
                  </div>
                  <div class="card-body p-4">
                    <div class="row mb-4 align-items-end filter-row" style="background: #f8f9fa; border-radius: 12px; padding: 18px 8px 8px 8px; box-shadow: 0 2px 8px rgba(44,62,80,0.04);">
                      <div class="col-md-3 col-12 mb-2 mb-md-0">
                        <div class="input-group">
                          <input type="text" id="searchInput" class="form-control custom-input" placeholder="Search orders...">
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="zmdi zmdi-search"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-6 mb-2 mb-md-0">
                        <select id="statusFilter" class="form-control custom-input custom-select">
                          <option value="">Select Status</option>
                          <option value="new">New</option>
                          <option value="closed">Closed</option>
                          <option value="connected">Connected</option>
                          <option value="not connected">Not Connected</option>
                        </select>
                      </div>
                      <div class="col-md-3 col-6 mb-2 mb-md-0">
                        <select id="responseFilter" class="form-control custom-input custom-select">
                          <option value="">Select Response</option>
                          <option value="positive">Positive</option>
                          <option value="negative">Negative</option>
                          <option value="confused">Confused</option>
                        </select>
                      </div>
                      <div class="col-md-3 col-12 mb-2 mb-md-0">
                        <select id="employeeFilter" class="form-control custom-input custom-select">
                          <option value="">All Employees</option>
                        </select>
                      </div>
                    </div>
                    <div class="d-flex justify-content-end mb-2">
                      <button class="btn btn-primary btn-sm rounded-pill shadow-sm" id="addLeadBtn" style="font-size: 0.95rem; padding: 6px 18px;">
                        <i class="zmdi zmdi-plus mr-1"></i> Add Lead
                      </button>
                    </div>
                    <div class="table-responsive table-responsive-data2 mt-3">
                      
                      <table class="table table-data2 table-hover" id="leadsTable">
                        
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary text-center">Lead ID</th>
                            <th class="text-primary text-center">Name</th>
                            <th class="text-primary text-center">Contact No</th>
                            <th class="text-primary text-center">Email ID</th>
                            <th class="text-primary text-center">Interested Product</th>
                            <th class="text-primary text-center">Quantity</th>
                            <th class="text-primary text-center">Added By</th>
                            <th class="text-primary text-center">Added On</th>
                            <th class="text-primary text-center">Last Modified</th>
                            <th class="text-primary text-center">Status</th>
                            <th class="text-primary text-center">Response</th>
                            <th class="text-primary text-center">Vendor</th>
                            <th class="text-primary text-center">Remarks</th>
                            <th class="text-primary text-center">Assigned To</th>
                            <th class="text-primary text-center">Actions
                            </th>
                          </tr>
                        </thead>
                        <tbody id="leadsTableBody"></tbody>
                      </table>
                    </div>
                    <!-- Pagination -->
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

<?php require './bottom.php'; ?>

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
  display: block;
  width: 100%;
  padding: 0;
  margin: 0;
}
.table-data2 {
  min-width: 1800px; /* Increase min-width for more columns */
  width: auto;
  margin-left: 0;
  margin-right: 0;
  table-layout: auto;
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
  text-align: center;
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
.pagination {
  margin: 0;
}
#showingEntries {
  font-size: 0.9rem;
}
.status-badge {
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 0.95rem;
  font-weight: 600;
  display: inline-block;
  box-shadow: 0 2px 8px rgba(44,62,80,0.08);
  transition: box-shadow 0.2s, transform 0.2s, filter 0.2s;
  letter-spacing: 0.5px;
  border: none;
}
.status-badge:hover {
  box-shadow: 0 4px 16px rgba(44,62,80,0.18);
  filter: brightness(1.08);
  transform: scale(1.07);
  cursor: pointer;
}
.status-new { background: linear-gradient(90deg,#007bff,#4e73df); color: #fff; }
.status-closed { background: linear-gradient(90deg,#6c757d,#868e96); color: #fff; }
.status-connected { background: linear-gradient(90deg,#28a745,#43e97b); color: #fff; }
.status-not-connected { background: linear-gradient(90deg,#dc3545,#ff7675); color: #fff; }
.status-pending { background: linear-gradient(90deg,#000,#434343); color: #fff; }
.status-completed { background: linear-gradient(90deg,#caffca,#0ea949); color: #0ea949; }
.response-positive { background: linear-gradient(90deg,#28a745,#43e97b); color: #fff; }
.response-negative { background: linear-gradient(90deg,#dc3545,#ff7675); color: #fff; }
.response-confused { background: linear-gradient(90deg,#ffc107,#ffe082); color: #212529; }
.closed-positive-combo { background: linear-gradient(90deg,#145a32,#43e97b); color: #fff; }
.closed-negative-combo { background: linear-gradient(90deg,#7b241c,#ff7675); color: #fff; }

.table-data2 tbody tr {
  transition: background 0.2s, box-shadow 0.2s;
}
.table-data2 tbody tr:hover {
  background: #f1f6ff !important;
  box-shadow: 0 4px 18px rgba(78,115,223,0.10);
  z-index: 2;
  position: relative;
}
.stat-card {
  border-radius: 16px;
  background: linear-gradient(135deg, #e3f0ff, #f5f7ff);
  min-height: 130px;
  box-shadow: 0 2px 8px rgba(44,62,80,0.08);
  transition: box-shadow 0.2s, transform 0.2s;
}
.stat-card:hover {
  box-shadow: 0 6px 18px rgba(44,62,80,0.13);
  transform: translateY(-2px) scale(1.03);
}
.stat-title {
  font-size: 1.08rem;
  font-weight: 600;
  margin-bottom: 0.2rem;
  letter-spacing: 0.5px;
}
.stat-value {
  font-size: 2.2rem;
  font-weight: 700;
  margin-top: 0.1rem;
  letter-spacing: 1px;
}
.stat-icon {
  font-size: 2.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 54px;
  height: 54px;
  border-radius: 50%;
  margin-bottom: 0.3rem;
  box-shadow: 0 2px 8px rgba(44,62,80,0.10);
}
.stat-icon-blue {
  background: linear-gradient(135deg, #e3f0ff 60%, #4e73df 100%);
  color: #1a237e;
}
.stat-icon-green {
  background: linear-gradient(135deg, #eaffea 60%, #28a745 100%);
  color: #218838;
}
.stat-icon-info {
  background: linear-gradient(135deg, #e3f7ff 60%, #007bff 100%);
  color: #007bff;
}
.stat-icon-red {
  background: linear-gradient(135deg, #ffeaea 60%, #dc3545 100%);
  color: #dc3545;
}
.filter-row {
  margin-bottom: 0 !important;
  box-shadow: 0 2px 8px rgba(44,62,80,0.04);
  border-radius: 12px;
  background: #f8f9fa;
  padding: 18px 8px 8px 8px;
}
@media (max-width: 992px) {
  #statsCardsRow .col-md-3 {
    flex: 0 0 50%;
    max-width: 50%;
  }
}
@media (max-width: 576px) {
  #statsCardsRow .col-md-3 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .stat-card {
    min-height: 90px;
  }
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

<script>
$(function() {
  const PAGE_SIZE = 6;
  let currentPage = 1;
  let searchTerm = '';
  let statusFilter = '';
  let responseFilter = '';
  let employeeFilter = '';

  // --- Helper functions for popups and toast ---
  function showToast(title, icon = 'success', timer = 1500) {
    Swal.fire({
      icon,
      title,
      timer,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  }
  function showError(message, title = 'Error') {
    Swal.fire({
      icon: 'error',
      title,
      text: message
    });
  }

  function getStatusClass(status) {
            switch (status) {
                case 'new': return 'status-new';
                case 'closed': return 'status-closed';
                case 'connected': return 'status-connected';
                case 'not connected': return 'status-not-connected';
      case 'pending': return 'status-pending';
      case 'completed': return 'status-completed';
                default: return '';
            }
        }
        function getResponseClass(response) {
            switch (response) {
                case 'positive': return 'response-positive';
                case 'negative': return 'response-negative';
                case 'confused': return 'response-confused';
                default: return '';
            }
        }
  function renderTableRow(lead) {
    let comboClassStatus = '', comboClassResponse = '';
    if (lead.status === 'closed' && lead.response === 'positive') {
        comboClassStatus = 'closed-positive-combo';
        comboClassResponse = 'closed-positive-combo';
    } else if (lead.status === 'closed' && lead.response === 'negative') {
        comboClassStatus = 'closed-negative-combo';
        comboClassResponse = 'closed-negative-combo';
    }
    const statusClass = getStatusClass(lead.status) + (comboClassStatus ? ' ' + comboClassStatus : '');
    const responseClass = getResponseClass(lead.response) + (comboClassResponse ? ' ' + comboClassResponse : '');
    const statusOptions = ['new', 'closed', 'connected', 'not connected'];
    const responseOptions = ['positive', 'negative', 'confused'];
    const statusSelect = `<select class='form-control form-control-sm status-select ${statusClass}' data-lead-id='${esc(lead.lead_id)}' data-row-id='${esc(lead.lead_id)}'>` +
        `<option value=''>Select Status</option>` +
        statusOptions.map(opt => `<option value='${opt}' ${esc(lead.status === opt ? 'selected' : '')}>${esc(opt.charAt(0).toUpperCase() + opt.slice(1))}</option>`).join('') +
        `</select>`;
    const responseSelect = `<select class='form-control form-control-sm response-select ${responseClass}' data-lead-id='${esc(lead.lead_id)}' data-row-id='${esc(lead.lead_id)}'>` +
        `<option value=''>Select Response</option>` +
        responseOptions.map(opt => `<option value='${opt}' ${esc(lead.response === opt ? 'selected' : '')}>${esc(opt.charAt(0).toUpperCase() + opt.slice(1))}</option>`).join('') +
        `</select>`;
    const assignBtnLabel = lead.assigned_to ? 'Re-Assign' : 'Assign';
    const assignBtnClass = lead.assigned_to ? 'btn-warning' : 'btn-success';

    // --- Vendor cell logic with reallot option ---
    let vendorCell = '';
    if (lead.supplier_name && lead.vendor_id) {
        vendorCell = `
            <div>
                <span>${esc(lead.supplier_name)}</span>
                <button class='btn btn-sm btn-outline-warning ml-2 reallot-vendor-btn' data-lead-id='${esc(lead.lead_id)}' data-current-vendor='${esc(lead.vendor_id)}'>Reallot</button>
            </div>
        `;
    } else {
        vendorCell = `<button class='btn btn-sm btn-outline-primary allot-vendor-btn' data-lead-id='${esc(lead.lead_id)}'>Allot Vendor</button>`;
    }

    return `<tr>
      <td>${esc(lead.lead_id)}</td>
      <td>${esc(lead.name)}</td>
      <td>${esc(lead.contact)}</td>
      <td>${esc(lead.email)}</td>
      <td>${esc(lead.product)}</td>
      <td>${esc(lead.quantity)}</td>
      <td>${esc(lead.added_by)}</td>
      <td>${esc(lead.added_on)}</td>
      <td>${esc(lead.modified)}</td>
      <td>${statusSelect}</td>
      <td>${responseSelect}</td>
      <td>${vendorCell}</td>
      <td><button class='btn btn-sm btn-outline-info add-remarks' data-lead-id='${esc(lead.lead_id)}' data-remarks='${esc(lead.remarks || '')}'><i class='zmdi zmdi-comment-edit mr-1'></i>Remarks</button></td>
      <td><button class='btn btn-sm ${assignBtnClass} assign-lead' data-lead-id='${esc(lead.lead_id)}' data-assigned-to='${esc(lead.assigned_to || '')}'>${assignBtnLabel}${lead.assigned_to ? ` <span class='ml-1'>(${esc(lead.assigned_to)})</span>` : ''}</button></td>
      <td><button class='btn btn-sm btn-link text-primary edit-lead' data-lead-id='${esc(lead.lead_id)}' data-name='${esc(lead.name)}' data-contact='${esc(lead.contact)}' data-email='${esc(lead.email)}' data-product='${esc(lead.product)}' data-quantity='${esc(lead.quantity)}'><i class='zmdi zmdi-edit'></i></button></td>
    </tr>`;
  }

  function renderPagination(pagination) {
    const container = $('#paginationContainer');
    let html = '';
    if (pagination.total_pages <= 1) {
      container.html('');
      return;
    }
        if (pagination.current_page > 1) {
      html += `<li class="page-item"><a class="page-link" href="#" data-page="${esc(pagination.current_page - 1)}">&laquo;</a></li>`;
        }
        for (let i = 1; i <= pagination.total_pages; i++) {
      html += `<li class="page-item${esc(i === pagination.current_page ? ' active' : '')}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
        if (pagination.current_page < pagination.total_pages) {
      html += `<li class="page-item"><a class="page-link" href="#" data-page="${esc(pagination.current_page + 1)}">&raquo;</a></li>`;
    }
    container.html(html);
  }

  function renderShowingEntries(pagination) {
    const start = pagination.showing_start;
    const end = pagination.showing_end;
    const total = pagination.total_entries;
    $('#showingEntries').text(`Showing ${start} to ${end} of ${total} entries`);
  }

  // Populate employee filter
  function loadEmployeeFilter() {
    $.get('./data/get_users.php', function(response) {
      if (response.success && response.users) {
        const $emp = $('#employeeFilter');
        $emp.empty();
        $emp.append('<option value="">All Employees</option>');
        response.users.forEach(function(u) {
          $emp.append(`<option value="${esc(u.id)}">${esc(u.id)} - ${esc(u.name)}</option>`);
        });
      }
    }, 'json');
  }
  loadEmployeeFilter();

  function loadLeads(page = 1) {
      loadLeads.lastArgs = arguments;
    $.get('./data/sales_data.php', {
      page,
      search: searchTerm,
      status: statusFilter,
      response: responseFilter,
      assigned_to: employeeFilter
    }, function(response) {
      if (response.success && response.data.length) {
        $('#leadsTableBody').html(response.data.map(renderTableRow).join(''));
                } else {
        $('#leadsTableBody').html('<tr><td colspan="13" class="text-center">No leads found.</td></tr>');
      }
      if (response.pagination) {
        renderPagination(response.pagination);
        renderShowingEntries(response.pagination);
        currentPage = response.pagination.current_page;
      }
    }, 'json');
    }
  crmLiveRefresh(function () { loadLeads.apply(null, loadLeads.lastArgs || []); }); // keep current without polling

    // Pagination click
  $(document).on('click', '#paginationContainer .page-link', function(e) {
        e.preventDefault();
    const page = parseInt($(this).data('page'));
    if (!isNaN(page)) {
      loadLeads(page);
    }
  });

  // Search input
    $('#searchInput').on('input', debounce(function() {
        searchTerm = $(this).val();
    loadLeads(1);
    }, 300));

    // Status filter
    $('#statusFilter').on('change', function() {
        statusFilter = $(this).val();
    loadLeads(1);
    });

    // Response filter
    $('#responseFilter').on('change', function() {
        responseFilter = $(this).val();
    loadLeads(1);
    });

    // Employee filter
    $('#employeeFilter').on('change', function() {
        employeeFilter = $(this).val();
    loadLeads(1);
    });

    // Debounce function
    function debounce(func, wait) {
        let timeout;
    return function(...args) {
                clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Initial load
  loadLeads(1);

  // SweetAlert2 popup for remarks
  $(document).on('click', '.add-remarks', function() {
    const leadId = $(this).data('lead-id');
    const remarks = $(this).data('remarks');
    Swal.fire({
      title: 'Add/Edit Remarks',
      input: 'textarea',
      inputLabel: 'Remarks',
      inputValue: remarks,
      showCancelButton: true,
      confirmButtonText: 'Save',
      preConfirm: (newRemarks) => newRemarks
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: './data/update_remarks.php',
          method: 'POST',
          data: { lead_id: leadId, remarks: result.value },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              showToast('Remarks updated successfully');
              reloadAll();
            } else {
              showError(response.message || 'Error updating remarks');
            }
          },
          error: function() { showError('Error updating remarks'); }
        });
      }
    });
  });

  // SweetAlert2 popup for editing lead
  $(document).on('click', '.edit-lead', function() {
    const leadId = $(this).data('lead-id');
    const name = $(this).data('name');
    const contact = $(this).data('contact');
    const email = $(this).data('email');
    const product = $(this).data('product');
    const quantity = $(this).data('quantity');
    Swal.fire({
      title: 'Edit Lead',
      html: `
        <input id="swal-edit-name" class="swal2-input" placeholder="Name" value="${esc(name)}">
        <input id="swal-edit-contact" class="swal2-input" placeholder="Contact" value="${esc(contact)}">
        <input id="swal-edit-email" class="swal2-input" placeholder="Email" value="${esc(email)}">
        <input id="swal-edit-product" class="swal2-input" placeholder="Product" value="${esc(product)}">
        <input id="swal-edit-quantity" class="swal2-input" type="number" min="1" placeholder="Quantity" value="${esc(quantity)}">
      `,
      focusConfirm: false,
      showCancelButton: true,
      confirmButtonText: 'Update',
      preConfirm: () => ({
        lead_id: leadId,
        name: $('#swal-edit-name').val().trim(),
        contact: $('#swal-edit-contact').val().trim(),
        email: $('#swal-edit-email').val().trim(),
        product: $('#swal-edit-product').val().trim(),
        quantity: parseInt($('#swal-edit-quantity').val())
      })
    }).then((result) => {
      if (result.isConfirmed) {
        const updatedLead = result.value;
        $.ajax({
          url: './data/update_lead.php',
          method: 'POST',
          data: updatedLead,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              showToast('Lead updated successfully');
              reloadAll();
            } else {
              showError(response.message || 'Error updating lead');
            }
          },
          error: function() { showError('Error updating lead'); }
        });
      }
    });
  });

  // Status select change
  $(document).on('change', '.status-select', function() {
    const leadId = $(this).data('lead-id');
    const status = $(this).val();
    $.ajax({
      url: './data/update_status.php',
      method: 'POST',
      data: { lead_id: leadId, status: status },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          showToast('Status updated', 'success', 1200);
          reloadAll();
        } else {
          showError(response.message || 'Error updating status');
        }
      },
      error: function() { showError('Error updating status'); }
    });
  });

  // Response select change
  $(document).on('change', '.response-select', function() {
    const leadId = $(this).data('lead-id');
    const responseVal = $(this).val();
    $.ajax({
      url: './data/update_response.php',
      method: 'POST',
      data: { lead_id: leadId, response: responseVal },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          showToast('Response updated', 'success', 1200);
          reloadAll();
        } else {
          showError(response.message || 'Error updating response');
        }
      },
      error: function() { showError('Error updating response'); }
    });
  });

  // SweetAlert2 popup for assigning/re-assigning lead
  $(document).on('click', '.assign-lead', function() {
    const leadId = $(this).data('lead-id');
    const assignedTo = $(this).data('assigned-to');
    // Fetch user list via AJAX
    $.get('./data/get_users.php', function(response) {
      if (response.success && response.users && response.users.length) {
        const userOptions = response.users.map(u => `<option value='${esc(u.id)}'>${esc(u.id)} - ${esc(u.name)}</option>`).join('');
        Swal.fire({
          title: assignedTo ? 'Re-Assign Lead' : 'Assign Lead',
          html: `<select id='swal-assign-user' class='swal2-input'>${userOptions}</select>`,
          showCancelButton: true,
          confirmButtonText: assignedTo ? 'Re-Assign' : 'Assign',
          preConfirm: () => $('#swal-assign-user').val()
        }).then((result) => {
          if (result.isConfirmed) {
            const userId = result.value;
            $.ajax({
              url: './data/update_assign.php',
              method: 'POST',
              data: { lead_id: leadId, assigned_to: userId },
              dataType: 'json',
              success: function(resp) {
                if (resp.success) {
                  showToast('Lead assigned successfully');
                  reloadAll();
                } else {
                  showError(resp.message || 'Error assigning lead');
                }
              },
              error: function() { showError('Error assigning lead'); }
            });
          }
        });
      } else {
        showError('No users available to assign.', 'No users found');
      }
    }, 'json');
  });

  // Load stats cards
  function loadStatsCards() {
      loadStatsCards.lastArgs = arguments;
    $.get('./data/sales_data.php?stats=1', function(response) {
      if (response.success && response.stats) {
        $('#statNewLeads').text(response.stats.new_leads);
        $('#statLeadsClosed').text(response.stats.leads_closed);
        $('#statWon').text(response.stats.won);
        $('#statLost').text(response.stats.lost);
      }
    }, 'json');
  }
  crmLiveRefresh(function () { loadStatsCards.apply(null, loadStatsCards.lastArgs || []); }); // keep current without polling
  loadStatsCards();

  // Call loadStatsCards after any action that may change stats
  function reloadAll() {
    loadLeads(currentPage);
    loadStatsCards();
  }

  // Add Lead Button SweetAlert2 popup
  $(document).on('click', '#addLeadBtn', function() {
    Swal.fire({
      title: 'Add New Lead',
      html: `
        <input id="swal-add-name" class="swal2-input" placeholder="Name">
        <input id="swal-add-contact" class="swal2-input" placeholder="Contact">
        <input id="swal-add-email" class="swal2-input" placeholder="Email">
        <input id="swal-add-product" class="swal2-input" placeholder="Product">
        <input id="swal-add-quantity" class="swal2-input" type="number" min="1" placeholder="Quantity" value="1">
      `,
      focusConfirm: false,
      showCancelButton: true,
      confirmButtonText: 'Add Lead',
      preConfirm: () => {
        return {
          name: $('#swal-add-name').val().trim(),
          contact: $('#swal-add-contact').val().trim(),
          email: $('#swal-add-email').val().trim(),
          product: $('#swal-add-product').val().trim(),
          quantity: parseInt($('#swal-add-quantity').val()) || 1
        };
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const newLead = result.value;
        $.ajax({
          url: '../shared/add_lead.php',
          method: 'POST',
          data: { lead: newLead }, // <-- wrap in 'lead'
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              showToast('Lead added successfully');
              reloadAll();
            } else {
              showError(response.message || 'Error adding lead');
            }
          },
          error: function(xhr) {
            showError(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error adding lead');
          }
        });
      }
    });
  });

  // Replace all loadLeads(currentPage) calls with reloadAll() in AJAX success callbacks
  // ... (for brevity, only show one example, you should update all such calls) ...
  // Example:
  // success: function(response) {
  //   if (response.success) {
  //     Swal.fire({ ... });
  //     reloadAll();
  //   } ...
  // }

  // Vendor assignment modal logic
$(document).on('click', '.allot-vendor-btn', function() {
  const leadId = $(this).data('lead-id');
  openVendorAllotModal(leadId);
});

// Reallot Vendor (for leads with vendor)
$(document).on('click', '.reallot-vendor-btn', function() {
  const leadId = $(this).data('lead-id');
  openVendorAllotModal(leadId, true);
});

// Shared function for allot/reallot vendor
function openVendorAllotModal(leadId, isReallot = false) {
  $.ajax({
    url: './data/vendor_list.php',
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.success && Array.isArray(response.vendors)) {
        let options = response.vendors.map(v => `<option value='${esc(v.id)}'>${esc(v.supplier_name)}</option>`).join('');
        Swal.fire({
          title: isReallot ? 'Reallot Vendor' : 'Allot Vendor',
          html: `<select id='swal-vendor-select' class='swal2-input'>${options}</select>`,
          showCancelButton: true,
          confirmButtonText: isReallot ? 'Reallot' : 'Allot',
          preConfirm: () => $('#swal-vendor-select').val()
        }).then(result => {
          if (result.isConfirmed && result.value) {
            $.ajax({
              url: './data/allot_vendor.php',
              method: 'POST',
              data: {
                action: 'allot_vendor',
                lead_id: leadId,
                vendor_id: result.value
              },
              dataType: 'json',
              success: function(res) {
                if (res.success) {
                  Swal.fire({
                    icon: 'success',
                    title: isReallot ? 'Vendor reallotted successfully' : 'Vendor allotted successfully',
                    timer: 1200,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                  });
                  loadLeads(currentPage);
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message || 'Error allotting vendor'
                  });
                }
              },
              error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error allotting vendor'
                });
              }
            });
          }
        });
      } else {
        Swal.fire('No vendors found', '', 'info');
      }
    },
    error: function() {
      Swal.fire('Error fetching vendors', '', 'error');
    }
  });
}
});
</script>



