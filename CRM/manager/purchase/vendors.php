<?php 
require_once './top.php';
$includeOnly = true;
?>
<!-- MAIN CONTENT-->
<div class="main-content" style="min-height: 100vh;">
  <div class="section__content section__content--p30">
    <div class="container-fluid" style="min-height: 90vh; display: flex; flex-direction: column; justify-content: flex-start;">
      <?php require './Analytics/purchase_manager_cards.php';?>
      <div class="row flex-column">
        <div class="col-md-12">
          <!-- DATA TABLE -->
          <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
            <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
              <h3 class="mb-0 text-white">Vendors</h3>
              <small class="text-white-50 ml-3">Manage and track all vendors</small>
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
                <div style="flex:0 1 60px;">
                  <button class="btn btn-outline-secondary w-100 filter-tall" id="clearFilters" title="Clear filters"><i class="zmdi zmdi-close"></i></button>
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
                      <th class="text-primary text-center">Added By</th>
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

<!-- Add New Vendor Modal -->
<div class="modal fade" id="addVendorModal" tabindex="-1" role="dialog" aria-labelledby="addVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVendorModalLabel">Add New Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addVendorForm">
                    <div class="form-group">
                        <label for="supplierName">Supplier Name</label>
                        <input type="text" class="form-control" id="supplierName" required>
                    </div>
                    <div class="form-group">
                        <label for="productCategory">Product Category</label>
                        <input type="text" class="form-control" id="productCategory" required>
                    </div>
                    <div class="form-group">
                        <label for="contactNumber">Contact Number</label>
                        <input type="text" class="form-control" id="contactNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="form-group">
                        <label for="previousDeal">Previous Deal</label>
                        <select class="form-control" id="previousDeal" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" rows="3" placeholder="Enter remarks here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveNewVendor">Save Vendor</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Vendor Modal -->
<div class="modal fade" id="editLeadModal" tabindex="-1" role="dialog" aria-labelledby="editLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeadModalLabel">Edit Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editLeadForm">
                    <input type="hidden" id="editLeadId">
                    <div class="form-group">
                        <label for="editSupplierName">Supplier Name</label>
                        <input type="text" class="form-control" id="editSupplierName" required>
                    </div>
                    <div class="form-group">
                        <label for="editProductCategory">Product Category</label>
                        <input type="text" class="form-control" id="editProductCategory" required>
                    </div>
                    <div class="form-group">
                        <label for="editContactNumber">Contact Number</label>
                        <input type="text" class="form-control" id="editContactNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" required>
                    </div>
                    <div class="form-group">
                        <label for="editPreviousDeal">Previous Deal</label>
                        <select class="form-control" id="editPreviousDeal" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editRemarks">Remarks</label>
                        <textarea class="form-control" id="editRemarks" rows="3" placeholder="Enter remarks here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateLead">Update Vendor</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteLeadModal" tabindex="-1" role="dialog" aria-labelledby="deleteLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLeadModalLabel">Send Delete Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send a delete request for this vendor?</p>
                <input type="hidden" id="deleteLeadId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Send Request</button>
            </div>
        </div>
    </div>
</div>

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

<!-- Previous Deals Modal -->
<div class="modal fade" id="previousDealsModal" tabindex="-1" role="dialog" aria-labelledby="previousDealsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="modal-title" id="previousDealsModalLabel">
                        <span id="vendorDetailsHeader"></span>
                    </h5>
                    <span class="badge badge-primary" id="orderCountBadge"></span>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="previousDealsTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-primary">Lead ID</th>
                                <th class="text-primary">Product Purchased</th>
                                <th class="text-primary text-center">Quantity</th>
                                <th class="text-primary text-right">Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Will be populated by JavaScript -->
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="3" class="text-right">Total Amount:</th>
                                <th class="text-right" id="totalAmount">₹0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php require './bottom.php'; ?>


<style>
/* Copy and adapt the card, table, filter, badge, and responsive CSS from leads.php here. Adjust column widths and selectors for vendor-specific columns. */
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
        min-width: 1850px;  /* Minimum width to ensure proper column spacing */
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
    .table-data2 td:nth-child(9) { width: 130px; }  /* Last Modified */

    .table-data2 th:nth-child(10),
    .table-data2 td:nth-child(10) { width: 80px; }  /* Last Modified */

    .table-data2 th:nth-child(11),
    .table-data2 td:nth-child(11) { width: 150px; } /* Email */

    .table-data2 th:nth-child(12),
    .table-data2 td:nth-child(12) { width: 80px; } /* Actions - increased width */


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

    .previous-deal-badge-yes {
        transition: all 0.3s ease;
        font-size: 1rem; /* Increase font size */
        padding: 0.5em 1em; /* Increase padding */
        border-radius: 20px; /* Rounded corners */
        font-weight: bold; /* Bold text */
        background: linear-gradient(45deg,rgb(174, 240, 172),rgb(114, 198, 120)); /* Gradient background */
        color: #fff; /* White text */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .previous-deal-badge-yes:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
        background: linear-gradient(45deg,rgb(82, 141, 86),rgb(94, 152, 91)); /* Gradient background */
    }

    .previous-deal-badge-no {
        transition: all 0.3s ease;
        font-size: 1rem; /* Increase font size */
        padding: 0.5em 1em; /* Increase padding */
        border-radius: 20px; /* Rounded corners */
        font-weight: bold; /* Bold text */
        background: linear-gradient(45deg,rgb(107, 113, 125),rgb(54, 54, 55)); /* Gradient background */
        color: #fff; /* White text */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .previous-deal-badge-no:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
        background: linear-gradient(45deg,rgb(54, 54, 55),rgb(12, 12, 13)); /* Gradient background */
    }

    #orderCountBadge {
        font-size: 0.9rem;
        padding: 8px 12px;
    }

    #vendorDetailsHeader {
        font-size: 1.1rem;
    }

    #vendorDetailsHeader strong {
        color: #007bff;
    }

    #previousDealsTable {
        margin-bottom: 0;
    }

    #previousDealsTable th,
    #previousDealsTable td {
        padding: 12px 15px !important;
    }

    #previousDealsTable tbody tr {
        transition: all 0.3s;
    }

    #previousDealsTable tbody tr:hover {
        background-color: #f8f9fa;
    }

    #previousDealsTable tfoot {
        border-top: 2px solid #dee2e6;
    }

    #previousDealsTable tfoot th {
        font-weight: 600;
        padding: 15px !important;
    }

    /* Previous Deals Table Styling */
    #previousDealsTable {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px; /* Add spacing between rows */
    }

    #previousDealsTable th,
    #previousDealsTable td {
        padding: 12px 15px;
        text-align: left;
        vertical-align: middle;
        background-color: #fff;
        border: none;
    }

    #previousDealsTable th {
        font-weight: 600;
        color: #007bff;
        border-bottom: 2px solid #dee2e6;
    }

    #previousDealsTable td {
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    #previousDealsTable tbody tr:hover td {
        background-color: #f8f9fa;
    }

    #previousDealsTable tfoot th {
        font-weight: 600;
        padding: 15px;
        background-color: #f8f9fa;
        border-top: 2px solid #dee2e6;
    }

    /* Column widths */
    #previousDealsTable th:nth-child(1),
    #previousDealsTable td:nth-child(1) { width: 15%; }  /* Lead ID */

    #previousDealsTable th:nth-child(2),
    #previousDealsTable td:nth-child(2) { width: 45%; } /* Product Purchased */

    #previousDealsTable th:nth-child(3),
    #previousDealsTable td:nth-child(3) { width: 20%; } /* Quantity */

    #previousDealsTable th:nth-child(4),
    #previousDealsTable td:nth-child(4) { width: 20%; } /* Amount */

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #previousDealsTable th,
        #previousDealsTable td {
            padding: 10px;
        }

        #previousDealsTable th:nth-child(1),
        #previousDealsTable td:nth-child(1) { width: 20%; }

        #previousDealsTable th:nth-child(2),
        #previousDealsTable td:nth-child(2) { width: 40%; }

        #previousDealsTable th:nth-child(3),
        #previousDealsTable td:nth-child(3) { width: 20%; }

        #previousDealsTable th:nth-child(4),
        #previousDealsTable td:nth-child(4) { width: 20%; }
    }

    /* Custom CSS for SweetAlert2 Popups */
    .swal2-popup-custom {
        max-width: 480px !important;
        padding: 1.5em 2em 1em 2em !important;
        border-radius: 18px !important;
    }
    .swal-form-group {
        margin-bottom: 0.5em;
        text-align: left;
    }
    .swal-form-group label {
        font-weight: 600;
        margin-bottom: 0.2em;
        display: block;
        color: #1a237e;
        font-size: 1em;
    }
    .swal2-input, .swal2-textarea, .swal2-select {
        margin-bottom: 0.5em !important;
        border-radius: 8px !important;
        border: 1.5px solid #e3e6f0 !important;
        font-size: 1em !important;
    }
    .swal2-input:focus, .swal2-textarea:focus, .swal2-select:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.15rem rgba(78, 115, 223, 0.15) !important;
    }
    .swal2-confirm {
        background: linear-gradient(45deg, #1a237e, #4e73df) !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        font-size: 1.1em !important;
    }
    .swal2-cancel {
        border-radius: 8px !important;
        font-weight: 600 !important;
    }
</style>

<script>
// Refactor the JavaScript to use the same logic for search, filter, pagination, and modals as in leads.php. Use Toastr for notifications. Use SweetAlert2 for modals if desired, or keep Bootstrap modals but ensure the styling is consistent.
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

            const previousDealBadge = lead.previous_deal === 'Yes' ?
                `<span class="badge badge-success previous-deal-badge-yes" 
                    style="cursor: pointer;"
                    data-toggle="modal" 
                    data-target="#previousDealsModal"
                    data-vendor-id="${esc(lead.vendor_id)}"
                    data-vendor-name="${esc(lead.supplier_name)}"
                    data-order-count="5">
                    ${esc(lead.previous_deal)}
                </span>` :
                `<span class="badge previous-deal-badge-no badge-secondary">
                    ${esc(lead.previous_deal)}
                </span>`;

            return `
                <tr class='tr-shadow'>
                    <td class='text-center'><span class='badge badge-light'>${esc(lead.vendor_id)}</span></td>
                    <td class='text-center'>${esc(lead.supplier_name)}</td>
                    <td class='text-center'>${esc(lead.product_category)}</td>
                    <td class='text-center'>${esc(lead.contact_number)}</td>
                    <td class='text-center'>${esc(lead.email)}</td>
                    <td class='text-center'>${esc(lead.address)}</td>
                    <td class='text-center'>${previousDealBadge}</td>
                    <td class='text-center'>${remarkContent}</td>
                    <td class='text-center'>${esc(lead.added_by)}</td>
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
                            <button class='item btn btn-sm btn-outline-danger delete-lead' 
                                    data-toggle='tooltip' 
                                    data-placement='top' 
                                    title='Delete'
                                    data-lead-id='${esc(lead.vendor_id)}'>
                                <i class='zmdi zmdi-delete'></i>
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
            const statusFilter = $('#statusFilter').val() || '';
            const searchTerm = $('#searchInput').val()?.trim() || '';
            console.log('AJAX params:', { page, searchInput: searchTerm, status: statusFilter }); // <--- Add this

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

        // Clear filters handler
        $('#clearFilters').on('click', function() {
            $('#searchInput').val('').trigger('input');
            $('#statusFilter').val('').trigger('change');
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

        // Add New Vendor button click handler
        $('#addNewVendor').on('click', function() {
            Swal.fire({
                title: 'Add New Vendor',
                html: `
                    <div class="swal-form-group">
                        <label for="swal-supplierName">Supplier Name<span style="color:red">*</span></label>
                        <input id="swal-supplierName" class="swal2-input" placeholder="Supplier Name">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-productCategory">Product Category<span style="color:red">*</span></label>
                        <input id="swal-productCategory" class="swal2-input" placeholder="Product Category">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-contactNumber">Contact Number<span style="color:red">*</span></label>
                        <input id="swal-contactNumber" class="swal2-input" placeholder="Contact Number">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-email">Email<span style="color:red">*</span></label>
                        <input id="swal-email" class="swal2-input" placeholder="Email" type="email">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-address">Address<span style="color:red">*</span></label>
                        <input id="swal-address" class="swal2-input" placeholder="Address">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-previousDeal">Previous Deal<span style="color:red">*</span></label>
                        <select id="swal-previousDeal" class="swal2-input">
                            <option value="">Select...</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-remarks">Remarks</label>
                        <textarea id="swal-remarks" class="swal2-textarea" placeholder="Remarks"></textarea>
                    </div>
                `,
                customClass: {
                    popup: 'swal2-popup-custom'
                },
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Save Vendor',
                preConfirm: () => {
                    const supplier_name = $('#swal-supplierName').val().trim();
                    const product_category = $('#swal-productCategory').val().trim();
                    const contact_number = $('#swal-contactNumber').val().trim();
                    const email = $('#swal-email').val().trim();
                    const address = $('#swal-address').val().trim();
                    const previous_deal = $('#swal-previousDeal').val();
                    if (!supplier_name || !product_category || !contact_number || !email || !address || !previous_deal) {
                        Swal.showValidationMessage('Please fill all required fields.');
                        return false;
                    }
                    return {
                        supplier_name,
                        product_category,
                        contact_number,
                        email,
                        address,
                        previous_deal,
                        remarks: $('#swal-remarks').val().trim()
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const newVendor = result.value;
                    $.ajax({
                        url: './data/add_vendor.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(newVendor),
                        success: function(response) {
                            console.log('Add Vendor Response:', response);
                            if (response.success) {
                                Swal.fire('Success', 'Vendor added successfully!', 'success');
                                loadPage(currentPage);
                            } else {
                                Swal.fire('Error', response.message || 'Error adding vendor', 'error');
                            }
                        },
                        error: function(xhr) {
                            console.log('Add Vendor AJAX Error:', xhr);
                            let msg = 'Error adding vendor';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            } else if (xhr.responseText) {
                                try {
                                    const err = JSON.parse(xhr.responseText);
                                    msg = err.message || msg;
                                } catch (e) {}
                            }
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        });

        // Edit Vendor button click handler
        $(document).on('click', '.edit-lead', function() {
            const lead = $(this).data();
            Swal.fire({
                title: 'Edit Vendor',
                html: `
                    <div class="swal-form-group">
                        <label for="swal-edit-supplierName">Supplier Name<span style="color:red">*</span></label>
                        <input id="swal-edit-supplierName" class="swal2-input" placeholder="Supplier Name" value="${esc(lead.supplierName)}">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-edit-productCategory">Product Category<span style="color:red">*</span></label>
                        <input id="swal-edit-productCategory" class="swal2-input" placeholder="Product Category" value="${esc(lead.productCategory)}">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-edit-contactNumber">Contact Number<span style="color:red">*</span></label>
                        <input id="swal-edit-contactNumber" class="swal2-input" placeholder="Contact Number" value="${esc(lead.contactNumber)}">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-edit-email">Email<span style="color:red">*</span></label>
                        <input id="swal-edit-email" class="swal2-input" placeholder="Email" value="${esc(lead.email)}">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-edit-address">Address<span style="color:red">*</span></label>
                        <input id="swal-edit-address" class="swal2-input" placeholder="Address" value="${esc(lead.address)}">
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-edit-previousDeal">Previous Deal<span style="color:red">*</span></label>
                        <select id="swal-edit-previousDeal" class="swal2-input">
                            <option value="Yes" ${esc(lead.previousDeal === 'Yes' ? 'selected' : '')}>Yes</option>
                            <option value="No" ${esc(lead.previousDeal === 'No' ? 'selected' : '')}>No</option>
                        </select>
                    </div>
                    <div class="swal-form-group">
                        <label for="swal-edit-remarks">Remarks</label>
                        <textarea id="swal-edit-remarks" class="swal2-textarea" placeholder="Remarks">${esc(lead.remarks || '')}</textarea>
                    </div>
                `,
                customClass: {
                    popup: 'swal2-popup-custom'
                },
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Update Vendor',
                preConfirm: () => {
                    const supplier_name = $('#swal-edit-supplierName').val().trim();
                    const product_category = $('#swal-edit-productCategory').val().trim();
                    const contact_number = $('#swal-edit-contactNumber').val().trim();
                    const email = $('#swal-edit-email').val().trim();
                    const address = $('#swal-edit-address').val().trim();
                    const previous_deal = $('#swal-edit-previousDeal').val();
                    if (!supplier_name || !product_category || !contact_number || !email || !address || !previous_deal) {
                        Swal.showValidationMessage('Please fill all required fields.');
                        return false;
                    }
                    return {
                        vendor_id: lead.leadId,
                        supplier_name,
                        product_category,
                        contact_number,
                        email,
                        address,
                        previous_deal,
                        remarks: $('#swal-edit-remarks').val().trim()
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const updatedVendor = result.value;
                    $.ajax({
                        url: './data/update_vendor.php', // updated
                        method: 'POST',
                        data: {
                            vendor: updatedVendor
                        },
                        success: function(response) {
                            console.log('Update Vendor Response:', response); // <-- log response
                            if (response.success) {
                                Swal.fire('Success', 'Vendor updated successfully!', 'success');
                                loadPage(currentPage);
                            } else {
                                Swal.fire('Error', response.message || 'Error updating vendor', 'error');
                            }
                        },
                        error: function(xhr) {
                            console.log('Update Vendor AJAX Error:', xhr);
                            let msg = 'Error updating vendor';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        });

        // Delete Vendor button click handler
        $(document).on('click', '.delete-lead', function() {
            const leadId = $(this).data('lead-id');
            Swal.fire({
                title: 'Delete Vendor',
                text: 'Are you sure you want to delete this vendor?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: './data/delete_vendor.php', // updated
                        method: 'POST',
                        data: {
                            vendor_id: leadId
                        },
                        success: function(response) {
                            console.log('Delete Vendor Response:', response); // <-- log response
                            if (response.success) {
                                Swal.fire('Deleted!', 'Vendor deleted successfully.', 'success');
                                loadPage(currentPage);
                            } else {
                                Swal.fire('Error', response.message || 'Error deleting vendor', 'error');
                            }
                        },
                        error: function(xhr) {
                            console.log('Delete Vendor AJAX Error:', xhr);
                            let msg = 'Error deleting vendor';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire('Error', msg, 'error');
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

        // Previous Deals Modal Handler
        $('#previousDealsModal').on('show.bs.modal', function (event) {
            const badge = $(event.relatedTarget);
            const vendorId = badge.data('vendor-id');
            const vendorName = badge.data('vendor-name');
            
            const modal = $(this);
            const tableBody = modal.find('#previousDealsTable tbody');
            
            // Show loading state
            tableBody.html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
            
            // Fetch previous deals data
            $.ajax({
                url: '../../shared/previous_deals.php',
                method: 'GET',
                data: { vendor_id: vendorId },
                success: function(response) {
                    if (response.success) {
                        let totalAmount = 0;
                        const rows = response.data.map(deal => {
                            totalAmount += deal.amount;
                            return `
                                <tr>
                                    <td><span class="badge badge-light">${esc(deal.lead_id)}</span></td>
                                    <td>${esc(deal.product_purchased)}</td>
                                    <td class="text-center">${esc(deal.quantity)}</td>
                                    <td class="text-right">₹${esc(deal.amount.toLocaleString('en-IN'))}</td>
                                </tr>
                            `;
                        }).join('');
                        
                        tableBody.html(rows);
                        modal.find('#totalAmount').html(`₹${esc(totalAmount.toLocaleString('en-IN'))}`);
                        modal.find('#orderCountBadge').html(
                            `${esc(response.total_orders)} Completed Orders`
                        );
                        modal.find('#vendorDetailsHeader').html(
                            `<strong>${esc(vendorId)}</strong> - ${esc(vendorName)}`
                        );
                    } else {
                        tableBody.html(
                            `<tr><td colspan="4" class="text-center text-muted">
                                ${esc(response.message || 'No previous deals found')}
                            </td></tr>`
                        );
                        modal.find('#totalAmount').html('₹0');
                        modal.find('#orderCountBadge').html('0 Completed Orders');
                    }
                },
                error: function() {
                    tableBody.html(
                        `<tr><td colspan="4" class="text-center text-danger">
                            Error loading previous deals
                        </td></tr>`
                    );
                }
            });
        });
    });
</script>



