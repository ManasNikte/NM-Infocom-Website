<?php 
require_once './top.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<!-- MAIN CONTENT-->
<div class="main-content" style="min-height: 100vh;">
  <div class="section__content section__content--p30">
    <div class="container-fluid" style="min-height: 90vh; display: flex; flex-direction: column; justify-content: flex-start;">
      <div class="row flex-column">
        <div class="col-md-12">
          <!-- DATA TABLE -->
          <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
            <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
              <h3 class="mb-0 text-white">Purchase Orders</h3>
              <small class="text-white-50 ml-3">View and manage purchase orders</small>
            </div>
            <div class="card-body p-4">
              <div class="filter-row d-flex flex-wrap flex-md-nowrap align-items-stretch mb-4" style="gap: 1rem;">
                <div style="flex:1 1 220px;">
                  <div class="input-group h-100">
                    <input type="text" id="searchInput" class="form-control custom-input filter-tall" placeholder="Search purchase orders...">
                    <div class="input-group-append">
                      <span class="input-group-text bg-white border-0"><i class="zmdi zmdi-search"></i></span>
                    </div>
                  </div>
                </div>
                <div style="flex:0 1 170px;">
                  <select id="statusFilter" class="form-control custom-input custom-select filter-tall">
                    <option value="">Select Status</option>
                    <option value="connected">Connected</option>
                    <option value="closed">Closed</option>
                  </select>
                </div>
                <div style="flex:0 1 170px;">
                  <select id="vendorFilter" class="form-control custom-input custom-select filter-tall">
                    <option value="">Select Vendor</option>
                  </select>
                </div>
                <!-- Removed response filter dropdown -->
                <div style="flex:0 1 60px;">
                  <button class="btn btn-outline-secondary w-100 filter-tall" id="clearFilters" title="Clear filters"><i class="zmdi zmdi-close"></i></button>
                </div>
              </div>
              <div class="table-responsive table-responsive-data2" style="overflow-x: auto;">
                <table class="table table-data2 table-hover mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-primary text-center">Order ID</th>
                      <th class="text-primary text-center">Name</th>
                      <th class="text-primary text-center">Contact No</th>
                      <th class="text-primary text-center">Email ID</th>
                      <th class="text-primary text-center">Interested Product</th>
                      <th class="text-primary text-center">Quantity</th>
                      <th class="text-primary text-center">Added By</th>
                      <th class="text-primary text-center">Added On</th>
                      <th class="text-primary text-center">Last Modified</th>
                      <th class="text-primary text-center">Status</th>
                      <th class="text-primary text-center">Remarks</th>
                      <th class="text-primary text-center">Supplier</th>
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

<!-- Add New Lead Modal -->
<div class="modal fade" id="addLeadModal" tabindex="-1" role="dialog" aria-labelledby="addLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeadModalLabel">Add New Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addLeadForm">
                    <div class="form-group">
                        <label for="product">Product</label>
                        <input type="text" class="form-control" id="product" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier">Supplier</label>
                        <input type="text" class="form-control" id="supplier" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="totalCost">Total Cost (₹)</label>
                        <input type="number" class="form-control" id="totalCost" min="0" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveNewLead">Save Order</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Lead Modal -->
<div class="modal fade" id="editLeadModal" tabindex="-1" role="dialog" aria-labelledby="editLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="editLeadModalLabel">Edit Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editLeadForm">
                    <input type="hidden" id="editLeadId">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" required>
                    </div>
                    <div class="form-group">
                        <label for="editContact">Contact</label>
                        <input type="text" class="form-control" id="editContact" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="editProduct">Interested Product</label>
                        <input type="text" class="form-control" id="editProduct" required>
                    </div>
                    <div class="form-group">
                        <label for="editQuantity">Quantity</label>
                        <input type="number" class="form-control" id="editQuantity" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateLead">Update Order</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteLeadModal" tabindex="-1" role="dialog" aria-labelledby="deleteLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLeadModalLabel">Delete Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this order? This action cannot be undone.</p>
                <input type="hidden" id="deleteLeadId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Remarks Modal -->
<div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="remarksModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="remarksModalLabel">Add/Edit Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="remarksForm">
                    <input type="hidden" id="remarkLeadId">
                    <!-- Remove old Call Status and Response radio buttons -->
                    <!-- Only keep remarks textarea for now -->
                    <div class="form-group mt-4 remarks-section">
                        <label class="font-weight-bold" for="remarks">Additional Remarks</label>
                        <textarea class="form-control" id="remarks" rows="3" 
                                 placeholder="Enter additional remarks here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveRemarks">Save Remarks</button>
            </div>
        </div>
    </div>
</div>

<?php require './bottom.php'; ?>

<style>
/* Card and Table Modernization */
.card {
  border-radius: 20px;
  box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
  background: #fff;
  transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 32px rgba(44, 62, 80, 0.13);
}
.table-responsive-data2 {
  overflow-x: auto;
  background: #f8f9fa;
  border-radius: 16px;
  box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
  padding: 0;
  margin: 0;
}
.table-data2 {
  min-width: 1200px;
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  font-family: 'Nunito', sans-serif;
  font-size: 1rem;
  background: #fff;
}
.table-data2 thead th {
  position: sticky;
  top: 0;
  z-index: 2;
  background: #f5f7ff;
  font-weight: 700;
  color: #1a237e;
  border-bottom: 2px solid #e3e6f0;
  box-shadow: 0 2px 6px rgba(44, 62, 80, 0.04);
  padding: 16px 10px !important;
  letter-spacing: 0.5px;
}
.table-data2 tbody tr {
  transition: background 0.2s;
}
.table-data2 tbody tr:nth-child(even) {
  background: #f8f9fa;
}
.table-data2 tbody tr:hover {
  background: #e3e6f0;
}
.table-data2 td {
  padding: 14px 10px !important;
  vertical-align: middle !important;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 180px;
  font-size: 0.98rem;
}
.table-data2 td[data-tooltip]:hover::after {
  content: attr(data-tooltip);
  position: absolute;
  background: #222;
  color: #fff;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.95em;
  white-space: pre-line;
  z-index: 10;
  left: 50%;
  transform: translateX(-50%);
  top: 100%;
  margin-top: 4px;
  pointer-events: none;
}
/* Badges */
.badge {
  display: inline-block;
  min-width: 70px;
  padding: 7px 18px;
  font-size: 0.98em;
  border-radius: 999px;
  font-weight: 600;
  box-shadow: 0 2px 6px rgba(44, 62, 80, 0.08);
  letter-spacing: 0.2px;
  margin: 0 auto;
}
/* Status and response badge colors */
.badge.status-new { background: #1976d2; color: #fff; }
.badge.status-closed-negative, .badge.response-closed-negative { background: #8B0000; color: #fff; }
.badge.status-closed-positive, .badge.response-closed-positive { background: #006400; color: #fff; }
.badge.status-connected { background: #28a745; color: #fff; }
.badge.status-not-connected { background: #dc3545; color: #fff; }
.badge.response-positive { background: #28a745; color: #fff; }
.badge.response-negative { background: #dc3545; color: #fff; }
.badge.response-confused { background: #ffc107; color: #212529; }
/* Action Buttons */
.table-data-feature .btn {
  border-radius: 50%;
  width: 38px;
  height: 38px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin: 0 2px;
  background: #f5f7ff;
  color: #1976d2;
  box-shadow: 0 2px 6px rgba(44, 62, 80, 0.08);
  transition: background 0.2s, color 0.2s, box-shadow 0.2s;
  font-size: 1.2em;
}
.table-data-feature .btn:hover {
  background: #1976d2;
  color: #fff;
  box-shadow: 0 4px 12px rgba(44, 62, 80, 0.13);
}
.table-data-feature .btn[title]::after {
  content: attr(title);
  display: none;
  position: absolute;
  background: #222;
  color: #fff;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.95em;
  white-space: pre-line;
  z-index: 10;
  left: 50%;
  transform: translateX(-50%);
  top: 100%;
  margin-top: 4px;
}
.table-data-feature .btn:hover[title]::after {
  display: block;
}
/* Filter/Search Bar */
.custom-input, .custom-select {
  border-radius: 15px;
  border: 2px solid #e3e6f0;
  padding: 12px;
  font-size: 1rem;
  transition: box-shadow 0.2s, border-color 0.2s;
  background: #fff;
}
.custom-input:focus, .custom-select:focus {
  box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
  border-color: #4e73df;
}
.input-group-text {
  background: #fff;
  border: none;
  color: #1976d2;
  font-size: 1.2em;
}
/* Responsive */
@media (max-width: 1200px) {
  .table-data2 { min-width: 900px; }
}
@media (max-width: 992px) {
  .table-data2 { min-width: 700px; }
}
@media (max-width: 768px) {
  .table-data2 { min-width: 500px; }
  .row.mb-4.align-items-end.g-2 > div { margin-bottom: 8px; }
}
@media (max-width: 576px) {
  .table-data2 { min-width: 400px; font-size: 0.95rem; }
  .row.mb-4.align-items-end.g-2 { flex-direction: column; gap: 1rem; }
  .showing-entries { text-align: center; }
  .pagination { justify-content: center; }
  .card-header h3, .card-header small { font-size: 1.1rem; }
  .card { margin-bottom: 24px !important; }
}
/* Make filter selects match search bar height */
.filter-tall {
  min-height: 48px !important;
  height: 48px !important;
  padding-top: 10px !important;
  padding-bottom: 10px !important;
  display: flex;
  align-items: center;
}
#addLeadBtn.filter-tall {
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 1rem;
  min-width: 150px;
  height: 48px !important;
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}
#clearFilters.filter-tall {
  height: 48px !important;
  min-width: 48px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
@media (min-width: 768px) {
  .row.mb-4.align-items-end.g-2.flex-nowrap > div {
    margin-bottom: 0 !important;
    width: auto !important;
    flex: 0 1 auto;
  }
  .row.mb-4.align-items-end.g-2.flex-nowrap {
    flex-wrap: nowrap !important;
  }
}
@media (max-width: 767.98px) {
  .row.mb-4.align-items-end.g-2.flex-nowrap > div {
    width: 100% !important;
    margin-bottom: 8px !important;
  }
  .btn, .custom-input, .custom-select { width: 100%; }
}
.filter-row {
  display: flex;
  flex-wrap: wrap;
  align-items: stretch;
  gap: 1rem;
  margin-bottom: 1.5rem;
}
.filter-row > div {
  display: flex;
  align-items: stretch;
}
</style>
<script>
$(document).ready(function() {
    let currentPage = 1;
    let statusFilter = 'connected,closed';
    let searchTerm = '';
    let vendorFilter = '';

    function renderTableRow(lead) {
        // Status and Response options
        // Helper to get class for status
        function getStatusClass(status, response) {
            if (status === 'new') return 'status-new';
            if (status === 'closed' && response === 'positive') return 'status-closed-positive';
            if (status === 'closed' && response === 'negative') return 'status-closed-negative';
            if (status === 'connected') return 'status-connected';
            if (status === 'not connected') return 'status-not-connected';
            return '';
        }
        // Remove response badge logic
        // Status badge
        const statusClass = getStatusClass(lead.status, lead.response);
        const statusBadge = `<span class='badge ${statusClass}'>${esc(lead.status ? lead.status.charAt(0).toUpperCase() + lead.status.slice(1) : '')}</span>`;
        // Ellipsis and tooltip for long text fields
        function ellipsisCell(content) {
            if (!content) return '';
            const safe = String(content).replace(/"/g, '&quot;');
            return `<span style="display:inline-block;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;vertical-align:middle;" title="${safe}">${safe}</span>`;
        }
        return `
            <tr>
                <td class="text-center font-weight-bold">${esc(lead.lead_id)}</td>
                <td>${ellipsisCell(lead.name)}</td>
                <td class="text-center">${ellipsisCell(lead.contact)}</td>
                <td>${ellipsisCell(lead.email)}</td>
                <td>${ellipsisCell(lead.product)}</td>
                <td class="text-center">${ellipsisCell(lead.quantity)}</td>
                <td>${ellipsisCell(lead.added_by_user || lead.added_by)}</td>
                <td class="text-center">${ellipsisCell(lead.added_on)}</td>
                <td class="text-center">${ellipsisCell(lead.modified)}</td>
                <td class="text-center">${statusBadge}</td>
                <td>${ellipsisCell(lead.remarks || '')}</td>
                <td>
                    ${(lead.supplier_name && lead.vendor_id) ? ellipsisCell(lead.supplier_name) : `<button class='btn btn-sm btn-outline-primary allot-vendor-btn' data-lead-id='${esc(lead.lead_id)}'>Allot Vendor</button>`}
                </td>
                <td class="text-center">
                    <div class='table-data-feature'>
                        <button class='btn btn-sm btn-link text-primary edit-lead' 
                                data-toggle='tooltip' 
                                data-placement='top' 
                                title='Edit Allotted Vendor'
                                data-lead-id='${esc(lead.lead_id)}'
                                data-name='${esc(lead.name)}'
                                data-contact='${esc(lead.contact)}'
                                data-email='${esc(lead.email)}'
                                data-product='${esc(lead.product)}'
                                data-quantity='${esc(lead.quantity)}'
                                data-vendor-id='${esc(lead.vendor_id || '')}'>
                            <i class='zmdi zmdi-edit'></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    function updateTableBody(leads) {
        const tableBody = document.getElementById('leadsTableBody');
        if (!leads.length) {
            tableBody.innerHTML = `<tr><td colspan="13" class="text-center text-muted">No leads found.</td></tr>`;
        } else {
            tableBody.innerHTML = leads.map(renderTableRow).join('');
        }
    }

    function updatePaginationUI(pagination) {
        const paginationContainer = document.getElementById('paginationContainer');
        const showingEntries = document.getElementById('showingEntries');
        let paginationHtml = '';
        if (pagination.current_page > 1) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link page-nav" href="#" data-page="${esc(pagination.current_page - 1)}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`;
        }
        for (let i = 1; i <= pagination.total_pages; i++) {
            paginationHtml += `
                <li class="page-item ${esc(i === pagination.current_page ? 'active' : '')}">
                    <a class="page-link page-nav" href="#" data-page="${i}">${i}</a>
                </li>`;
        }
        if (pagination.current_page < pagination.total_pages) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link page-nav" href="#" data-page="${esc(pagination.current_page + 1)}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`;
        }
        paginationContainer.innerHTML = paginationHtml;
        showingEntries.textContent = `Showing ${esc(pagination.showing_start)} to ${esc(pagination.showing_end)} of ${esc(pagination.total_entries)} entries`;
    }

    function loadPage(page = 1, search = '', status = '', vendor_id = '') {
        // If no status provided, use default filters
        if (!status) status = 'connected,closed';
        $.ajax({
            url: './data/leads_data.php',
            method: 'GET',
            dataType: 'json',
            data: {
                page: page,
                search: search,
                status: status,
                vendor_id: vendor_id
            },
            success: function(response) {
                if (response.success) {
                    updateTableBody(response.data);
                    updatePaginationUI(response.pagination);
                } else {
                    updateTableBody([]);
                }
            },
            error: function(xhr, status, error) {
                updateTableBody([]);
                toastr.error('Error loading purchase orders');
                console.error('AJAX error:', xhr.responseText);
            }
        });
    }

    // Pagination click
    $(document).on('click', '.page-nav', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadPage(page, searchTerm, statusFilter, vendorFilter);
    });

    // Defensive function to get lowercased value
    function getInputLower(selector) {
        var $el = $(selector);
        if ($el.length === 0) return '';
        var val = $el.val();
        return (typeof val === 'string' ? val : '').toLowerCase();
    }

    // Search input
    $('#searchInput').on('input', debounce(function() {
        searchTerm = getInputLower('#searchInput');
        loadPage(1, searchTerm, statusFilter, vendorFilter);
    }, 300));

    // Search icon click
    $('.input-group-text').on('click', function() {
        searchTerm = getInputLower('#searchInput');
        loadPage(1, searchTerm, statusFilter, vendorFilter);
    });

    // Enter key
    $('#searchInput').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchTerm = getInputLower('#searchInput');
            loadPage(1, searchTerm, statusFilter, vendorFilter);
        }
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        statusFilter = ($(this).val() || '').toLowerCase();
        loadPage(1, searchTerm, statusFilter, vendorFilter);
    });
    // Vendor filter
    $('#vendorFilter').on('change', function() {
        vendorFilter = $(this).val();
        loadPage(1, searchTerm, statusFilter, vendorFilter);
    });

    // Clear filters button
    $('#clearFilters').on('click', function() {
        $('#searchInput').val('').trigger('input');
        $('#statusFilter').val('').trigger('change');
        $('#vendorFilter').val('').trigger('change');
        loadPage(1, '', 'connected,closed', '');
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

    // Initial load
    // Populate vendor filter dropdown
    $.ajax({
        url: './data/vendor_list.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && Array.isArray(response.vendors)) {
                let options = '<option value="">Select Vendor</option>';
                response.vendors.forEach(function(v) {
                    options += `<option value='${esc(v.id)}'>${esc(v.supplier_name)}</option>`;
                });
                $('#vendorFilter').html(options);
            }
        }
    });
    loadPage();

    // Use SweetAlert2 for edit and add-remarks popups
    $(document).on('click', '.edit-lead', function() {
        const leadId = $(this).data('lead-id');
        const name = $(this).data('name');
        const contact = $(this).data('contact');
        const email = $(this).data('email');
        const product = $(this).data('product');
        const quantity = $(this).data('quantity');
        const vendorId = $(this).data('vendor-id') || '';
        // Fetch vendor list and current vendor for this lead
        $.ajax({
            url: './data/vendor_list.php',
            method: 'GET',
            dataType: 'json',
            success: function(vendorResponse) {
                if (vendorResponse.success && Array.isArray(vendorResponse.vendors)) {
                    // Get the current vendor_id for this lead from the leads table row (if available)
                    let currentVendorId = null;
                    // Try to get vendor_id from the row's data attribute if available
                    const row = $("button.edit-lead[data-lead-id='" + leadId + "']").closest('tr');
                    if (row.length && row.data('vendor-id')) {
                        currentVendorId = row.data('vendor-id');
                    } else if (row.length) {
                        // Try to get from a hidden cell if you render it, or fallback to null
                        currentVendorId = row.find('.vendor-id-cell').text() || null;
                    }
                    // Build vendor options
                    let options = `<option value="">-- No Vendor --</option>`;
                    vendorResponse.vendors.forEach(v => {
                        options += `<option value='${esc(v.id)}' ${esc(v.id == vendorId ? 'selected' : '')}>${esc(v.supplier_name)}</option>`;
                    });
                    Swal.fire({
                        title: 'Edit Allotted Vendor',
                        html: `
                            <label style='margin-top:10px;'>Vendor</label>
                            <select id="swal-edit-vendor" class="swal2-input">${options}</select>
                        `,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonText: 'Update',
                        preConfirm: () => {
                            return {
                                lead_id: leadId,
                                vendor_id: $('#swal-edit-vendor').val() || null
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const updatedLead = result.value;
                            $.ajax({
                                url: './data/allot_vendor.php',
                                method: 'POST',
                                data: updatedLead,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sales lead updated successfully',
                                            timer: 1500,
                                            showConfirmButton: false,
                                            toast: true,
                                            position: 'top-end'
                                        });
                                        loadPage(currentPage, searchTerm, statusFilter, vendorFilter);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: response.message || 'Error updating order'
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error updating order'
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
    });

    $(document).on('click', '.add-remarks', function() {
        const leadId = $(this).data('lead-id');
        const remarks = $(this).data('remarks');
        Swal.fire({
            title: 'Remarks',
            input: 'textarea',
            inputLabel: 'Remarks',
            inputValue: remarks,
            inputAttributes: {
                readonly: true,
                disabled: true,
                style: 'background-color: #f8f9fa; color: #495057;'
            },
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Close',
            allowOutsideClick: true,
            allowEscapeKey: true
        });
    });

    // Add New Lead Button
    $('#addLeadBtn').on('click', function() {
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
                    url: '../../shared/add_lead.php',
                    method: 'POST',
                    data: { lead: newLead },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Lead added successfully',
                                timer: 1500,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                            loadPage(1, searchTerm, statusFilter, vendorFilter);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Error adding lead'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error adding lead'
                        });
                    }
                });
            }
        });
    });

    // Helper to update combo classes for both selects in a row
    function updateComboClasses(rowId) {
        const statusSel = $(`select.status-select[data-row-id='${rowId}']`);
        const responseSel = $(`select.response-select[data-row-id='${rowId}']`);
        const status = statusSel.val();
        const response = responseSel.val();
        // Remove old combo classes
        statusSel.removeClass('closed-positive-combo closed-negative-combo');
        responseSel.removeClass('closed-positive-combo closed-negative-combo');
        if (status === 'closed' && response === 'positive') {
            statusSel.addClass('closed-positive-combo');
            responseSel.addClass('closed-positive-combo');
        } else if (status === 'closed' && response === 'negative') {
            statusSel.addClass('closed-negative-combo');
            responseSel.addClass('closed-negative-combo');
        }
    }

    // Add event listeners for status and response select
    $(document).on('change', '.status-select', function() {
        const leadId = $(this).data('lead-id');
        const newStatus = $(this).val();
        // Remove old color classes
        $(this).removeClass('status-new status-closed status-connected status-not-connected closed-positive-combo closed-negative-combo');
        // Add new color class
        if (newStatus) {
            $(this).addClass('status-' + newStatus.replace(/ /g, '-'));
        }
        // Update combo classes for both selects
        updateComboClasses(leadId);
        $.ajax({
            url: './data/leads_data.php',
            method: 'POST',
            data: {
                action: 'update_status',
                lead_id: leadId,
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status updated',
                        timer: 1000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    loadPage(currentPage, searchTerm, statusFilter, vendorFilter);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Error updating status'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status'
                });
            }
        });
    });

    $(document).on('change', '.response-select', function() {
        const leadId = $(this).data('lead-id');
        const newResponse = $(this).val();
        // Remove old color classes
        $(this).removeClass('response-positive response-negative response-confused closed-positive-combo closed-negative-combo');
        // Add new color class
        if (newResponse) {
            $(this).addClass('response-' + newResponse);
        }
        // Update combo classes for both selects
        updateComboClasses(leadId);
        $.ajax({
            url: './data/leads_data.php',
            method: 'POST',
            data: {
                action: 'update_response',
                lead_id: leadId,
                response: newResponse
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Response updated',
                        timer: 1000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    loadPage(currentPage, searchTerm, statusFilter, vendorFilter);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Error updating response'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating response'
                });
            }
        });
    });

    // Allot Vendor button click
    $(document).on('click', '.allot-vendor-btn', function() {
        const leadId = $(this).data('lead-id');
        // Fetch vendor list
        $.ajax({
            url: './data/vendor_list.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && Array.isArray(response.vendors)) {
                    let options = response.vendors.map(v => `<option value='${esc(v.id)}'>${esc(v.supplier_name)}</option>`).join('');
                    Swal.fire({
                        title: 'Allot Vendor',
                        html: `<select id='swal-vendor-select' class='swal2-input'>${options}</select>`,
                        showCancelButton: true,
                        confirmButtonText: 'Allot',
                        preConfirm: () => {
                            return $('#swal-vendor-select').val();
                        }
                    }).then(result => {
                        if (result.isConfirmed && result.value) {
                            // Allot vendor via AJAX
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
                                            title: 'Vendor allotted successfully',
                                            timer: 1200,
                                            showConfirmButton: false,
                                            toast: true,
                                            position: 'top-end'
                                        });
                                        loadPage(currentPage, searchTerm, statusFilter, vendorFilter);
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
    });

    $('.table-responsive-data2').scrollLeft(0);
});
</script>

<!-- Add Toastr CSS and JS for notifications -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>



