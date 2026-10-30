<?php 
require_once './top.php';
?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './sales_emp_cards.php'?>
            <div class="row flex-column">
              <div class="col-md-12">
                <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                    <h3 class="mb-0 text-white">Sales Leads</h3>
                    <small class="text-white-50 ml-3">Contact leads and manage sales opportunities</small>
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
                    </div>
                    <div class="table-responsive table-responsive-data2 mt-3">
                      <table class="table table-data2 table-hover">
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
                            <th class="text-primary text-center">Remarks</th>
                            <th class="text-primary text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody id="leadsTableBody">
                          <!-- Table body will be populated by JavaScript -->
                        </tbody>
                      </table>
                    </div>
                    <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                      <div class="text-muted showing-entries" id="showingEntries"></div>
                      <nav aria-label="Page navigation">
                        <ul class="pagination mb-0" id="paginationContainer"></ul>
                      </nav>
                    </div>
                  </div>
                </div>
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

/* Table Layout and Structure */
.table-responsive-data2 {
    overflow-x: auto;
    margin: 0 -15px; /* Compensate for container padding */
    padding: 0 15px;
}

.table-data2 {
    min-width: 1800px;
    table-layout: relative;
    width: 100%;
}

.table-data2 th,
.table-data2 td {
    padding:  8px !important;
    vertical-align: middle !important;
}

/* Column widths */
.table-data2 th:nth-child(1), /* Lead ID */
.table-data2 td:nth-child(1) {
    width: 80px; /* Adjusted width */
}

.table-data2 th:nth-child(2), /* Name */
.table-data2 td:nth-child(2) {
    width: 150px; /* Adjusted width */
}

.table-data2 th:nth-child(3), /* Contact */
.table-data2 td:nth-child(3) {
    width: 120px; /* Adjusted width */
}

.table-data2 th:nth-child(4), /* Email */
.table-data2 td:nth-child(4) {
    width: 180px; /* Adjusted width */
}

.table-data2 th:nth-child(5), /* Product */
.table-data2 td:nth-child(5) {
    width: 150px; /* Adjusted width */
}

.table-data2 th:nth-child(6), /* Quantity */
.table-data2 td:nth-child(6) {
    width: 80px; /* Adjusted width */
}

.table-data2 th:nth-child(7), /* Added By */
.table-data2 td:nth-child(7) {
    width: 120px; /* Adjusted width */
}

.table-data2 th:nth-child(8), /* Added On */
.table-data2 td:nth-child(8) {
    width: 100px; /* Reduced width */
}

.table-data2 th:nth-child(9), /* Last Modified */
.table-data2 td:nth-child(9) {
    width: 100px; /* Reduced width */
}

.table-data2 th:nth-child(10), /* Status */
.table-data2 td:nth-child(10) {
    width: 120px; /* Adjusted width */
}

.table-data2 th:nth-child(11), /* Response */
.table-data2 td:nth-child(11) {
    width: 120px; /* Adjusted width */
}

.table-data2 th:nth-child(12), /* Remarks */
.table-data2 td:nth-child(12) {
    width: 120px; /* Adjusted width */
}

.table-data2 th:nth-child(13), /* Actions */
.table-data2 td:nth-child(13) {
    width: 80px; /* Adjusted width */
}

/* Action Column Styling */
.table-data-feature {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}

.table-data-feature .item {
    flex-shrink: 0;
    transition: all 0.3s;
}

.table-data-feature .item:hover {
    transform: translateY(-2px);
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
    white-space: normal;
    overflow: visible;
    text-overflow: clip;
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

/* Remarks Input */
.remarks-input {
    padding: 5px 10px;
    font-size: 0.9rem;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    background-color: #fff;
    transition: all 0.3s;
    width: 100%;
}

.remarks-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.15);
    border-color: #80bdff;
    outline: none;
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

/* Remove the status-dropdown styles */
.status-dropdown,
.status-dropdown:focus {
    display: none;
}

.remarks-text {
    display: none;
}

.add-remarks {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}

.add-remarks i {
    font-size: 1rem;
}

.edit-lead {
    padding: 0.25rem;
    color: #007bff;
}

.edit-lead:hover {
    color: #0056b3;
    background-color: rgba(0, 123, 255, 0.1);
    border-radius: 50%;
}

.edit-lead i {
    font-size: 1.2rem;
}

/* Add these styles to your existing CSS */
.gap-4 {
    gap: 1.5rem;
}

.custom-control-input:checked ~ .custom-control-label::before {
    border-color: #007bff;
    background-color: #007bff;
}

.custom-radio .custom-control-label {
    padding-left: 0.5rem;
    cursor: pointer;
}

.font-weight-bold {
    font-weight: 600 !important;
    color: #2c3e50;
    margin-bottom: 0.75rem;
}

.modal-body {
    padding: 1.5rem;
}

.custom-control-input:disabled ~ .custom-control-label {
    opacity: 0.6;
    cursor: not-allowed;
}

textarea:disabled {
    background-color: #e9ecef;
    cursor: not-allowed;
}

/* Add status badge styles */
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


/* Ensure text truncation works properly */
.table-data2 td {
    white-space: nowrap;
    overflow-x: auto;
    text-overflow: ellipsis;
    scrollbar-width: thin;
}

/* Fix the table inside the card */
.card .table-data2 {
    width: 100%; /* Ensure the table takes the full width of the card */
    border-collapse: collapse; /* Collapse borders for a cleaner look */
}

.card .table-data2 th, 
.card .table-data2 td {
    padding: 12px; /* Consistent padding for table cells */
    text-align: left; /* Align text to the left */
    border: 1px solid #ddd; /* Add border for better visibility */
}

/* Optional: Add a hover effect for rows */
.card .table-data2 tbody tr:hover {
    background-color: #f1f1f1; /* Light background on hover */
}

/* Status select color classes */
.status-new {
    background-color: #007bff !important;
    color: #fff !important;
}
.status-closed {
    background-color: #6c757d !important;
    color: #fff !important;
}
.status-connected {
    background-color: #28a745 !important;
    color: #fff !important;
}
.status-not-connected {
    background-color: #dc3545 !important;
    color: #fff !important;
}
/* Response select color classes */
.response-positive {
    background-color: #28a745 !important;
    color: #fff !important;
}
.response-negative {
    background-color: #dc3545 !important;
    color: #fff !important;
}
.response-confused {
    background-color: #ffc107 !important;
    color: #212529 !important;
}
/* Special combo classes */
.closed-positive-combo {
    background-color: #145a32 !important; /* Darker green */
    color: #fff !important;
}
.closed-negative-combo {
    background-color: #7b241c !important; /* Darker red */
    color: #fff !important;
}
</style>

<script>
$(document).ready(function() {
    let currentPage = 1;
    let statusFilter = '';
    let responseFilter = '';
    let searchTerm = '';

    function renderTableRow(lead) {
        // Status and Response options
        const statusOptions = ['new', 'closed', 'connected', 'not connected'];
        const responseOptions = ['positive', 'negative', 'confused'];
        // Helper to get class for status
        function getStatusClass(status) {
            switch (status) {
                case 'new': return 'status-new';
                case 'closed': return 'status-closed';
                case 'connected': return 'status-connected';
                case 'not connected': return 'status-not-connected';
                default: return '';
            }
        }
        // Helper to get class for response
        function getResponseClass(response) {
            switch (response) {
                case 'positive': return 'response-positive';
                case 'negative': return 'response-negative';
                case 'confused': return 'response-confused';
                default: return '';
            }
        }
        // Determine combo class
        let comboClassStatus = '', comboClassResponse = '';
        if (lead.status === 'closed' && lead.response === 'positive') {
            comboClassStatus = 'closed-positive-combo';
            comboClassResponse = 'closed-positive-combo';
        } else if (lead.status === 'closed' && lead.response === 'negative') {
            comboClassStatus = 'closed-negative-combo';
            comboClassResponse = 'closed-negative-combo';
        }
        // Status select
        const statusClass = getStatusClass(lead.status) + (comboClassStatus ? ' ' + comboClassStatus : '');
        const statusSelect = `<select class='form-control form-control-sm status-select ${statusClass}' data-lead-id='${esc(lead.lead_id)}' data-row-id='${esc(lead.lead_id)}'>` +
            `<option value=''>Select Status</option>` +
            statusOptions.map(opt => `<option value='${opt}' ${esc(lead.status === opt ? 'selected' : '')}>${esc(opt.charAt(0).toUpperCase() + opt.slice(1))}</option>`).join('') +
            `</select>`;
        // Response select
        const responseClass = getResponseClass(lead.response) + (comboClassResponse ? ' ' + comboClassResponse : '');
        const responseSelect = `<select class='form-control form-control-sm response-select ${responseClass}' data-lead-id='${esc(lead.lead_id)}' data-row-id='${esc(lead.lead_id)}'>` +
            `<option value=''>Select Response</option>` +
            responseOptions.map(opt => `<option value='${opt}' ${esc(lead.response === opt ? 'selected' : '')}>${esc(opt.charAt(0).toUpperCase() + opt.slice(1))}</option>`).join('') +
            `</select>`;
        return `
            <tr class='tr-shadow'>
                <td class="text-center"><span class='badge badge-light'>${esc(lead.lead_id)}</span></td>
                <td class="text-center">${esc(lead.name)}</td>
                <td class="text-center">${esc(lead.contact)}</td>
                <td class="text-center">${esc(lead.email)}</td>
                <td class="text-center">${esc(lead.product)}</td>
                <td class="text-center">${esc(lead.quantity)}</td>
                <td class="text-center">${esc(lead.added_by)}</td>
                <td class="text-center">${esc(lead.added_on)}</td>
                <td class="text-center">${esc(lead.modified)}</td>
                <td class="text-center">${statusSelect}</td>
                <td class="text-center">${responseSelect}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        <button class='btn btn-sm btn-outline-info add-remarks' 
                                data-toggle='tooltip' 
                                data-placement='top' 
                                title='${esc(lead.remarks || "No remarks")}'
                                data-lead-id='${esc(lead.lead_id)}'
                                data-remarks='${esc(lead.remarks || "")}'
                                data-call-status='${esc(lead.status || "")}'
                                data-response='${esc(lead.response || "")}'>
                            <i class='zmdi zmdi-comment-edit mr-1'></i>Remarks
                        </button>
                    </div>
                </td>
                <td class="text-center">
                    <div class='table-data-feature'>
                        <button class='btn btn-sm btn-link text-primary edit-lead' 
                                data-toggle='tooltip' 
                                data-placement='top' 
                                title='Edit'
                                data-lead-id='${esc(lead.lead_id)}'
                                data-name='${esc(lead.name)}'
                                data-contact='${esc(lead.contact)}'
                                data-email='${esc(lead.email)}'
                                data-product='${esc(lead.product)}'
                                data-quantity='${esc(lead.quantity)}'>
                            <i class='zmdi zmdi-edit'></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class='spacer'></tr>`;
    }

    function updateTableBody(leads) {
        const tableBody = document.getElementById('leadsTableBody');
        if (!leads.length) {
            tableBody.innerHTML = `<tr><td colspan='13' class='text-center text-muted py-4'>No sales data found.</td></tr>`;
        } else {
            tableBody.innerHTML = leads.map(lead => renderTableRow(lead)).join('');
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

    function loadPage(page = 1, search = '', status = '', response = '') {
        loadPage.lastArgs = arguments;
        $.ajax({
            url: './data/sales_data.php',
            method: 'GET',
            dataType: 'json',
            data: {
                page: page,
                search: search,
                status: status,
                response: response
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
                toastr.error('Error loading sales data');
                console.error('AJAX error:', xhr.responseText);
            }
        });
    }
    crmLiveRefresh(function () { loadPage.apply(null, loadPage.lastArgs || []); }); // keep current without polling

    // Pagination click
    $(document).on('click', '.page-nav', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadPage(page, searchTerm, statusFilter, responseFilter);
    });

    // Search
    $('#searchInput').on('input', debounce(function() {
        searchTerm = $(this).val();
        loadPage(1, searchTerm, statusFilter, responseFilter);
    }, 300));

    // Also trigger search when clicking the search icon
    $('.input-group-text').on('click', function() {
        searchTerm = $('#searchInput').val();
        loadPage(1, searchTerm, statusFilter, responseFilter);
    });

    // Prevent form submission or page reload on Enter in search box
    $('#searchInput').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchTerm = $(this).val();
            loadPage(1, searchTerm, statusFilter, responseFilter);
        }
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        statusFilter = $(this).val();
        loadPage(1, searchTerm, statusFilter, responseFilter);
    });

    // Response filter
    $('#responseFilter').on('change', function() {
        responseFilter = $(this).val();
        loadPage(1, searchTerm, statusFilter, responseFilter);
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
    loadPage();

    // Use SweetAlert2 for edit and add-remarks popups
    $(document).on('click', '.edit-lead', function() {
        const leadId = $(this).data('lead-id');
        const name = $(this).data('name');
        const contact = $(this).data('contact');
        const email = $(this).data('email');
        const product = $(this).data('product');
        const quantity = $(this).data('quantity');
        Swal.fire({
            title: 'Edit Order',
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
            preConfirm: () => {
                return {
                    lead_id: leadId,
                    name: $('#swal-edit-name').val().trim(),
                    contact: $('#swal-edit-contact').val().trim(),
                    email: $('#swal-edit-email').val().trim(),
                    product: $('#swal-edit-product').val().trim(),
                    quantity: parseInt($('#swal-edit-quantity').val())
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const updatedLead = result.value;
                $.ajax({
                    url: './data/sales_data.php',
                    method: 'POST',
                    data: {
                        action: 'update_lead',
                        lead: updatedLead
                    },
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
                            loadPage(currentPage, searchTerm, statusFilter, responseFilter);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Error updating order'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating order'
                        });
                    }
                });
            }
        });
    });

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
            preConfirm: (newRemarks) => {
                return newRemarks;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: './data/sales_data.php',
                    method: 'POST',
                    data: {
                        action: 'update_remarks',
                        lead_id: leadId,
                        remarks: result.value
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Remarks updated successfully',
                                timer: 1500,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                            loadPage(currentPage, searchTerm, statusFilter, responseFilter);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Error updating remarks'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating remarks'
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
            url: './data/sales_data.php',
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
                    loadPage(currentPage, searchTerm, statusFilter, responseFilter);
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
            url: './data/sales_data.php',
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
                    loadPage(currentPage, searchTerm, statusFilter, responseFilter);
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
});
</script>



