<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './analytics/products_analytics_cards.php'; ?>
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                      <h3 class="text-white mb-1">
                        <i class="fa fa-cube me-2"></i><span> </span>Product Management
                      </h3>
                      <small class="text-white-50">Manage and organize your product catalog</small>
                    </div>
                    <button type="button" class="btn btn-light btn-lg shadow-sm" id="addProductBtn">
                      <i class="fa fa-plus me-2"></i>Add New Product
                    </button>
                  </div>
                  <div class="card-body">
                    
                    <!-- Enhanced Filter Section -->
                    <div class="filter-section mb-4">
                      <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                          <div class="filter-group">
                            <label for="categoryFilter" class="form-label fw-semibold">
                              <i class="fa fa-tags me-1 text-primary"></i>Category
                            </label>
                            <select id="categoryFilter" class="form-select form-select-modern" onchange="applyFilters()">
                              <option value="">All Categories</option>
                              <!-- Categories will be loaded dynamically -->
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                          <div class="filter-group">
                            <label for="statusFilter" class="form-label fw-semibold">
                              <i class="fa fa-info-circle me-1 text-primary"></i>Status
                            </label>
                            <select id="statusFilter" class="form-select form-select-modern" onchange="applyFilters()">
                              <option value="">All Status</option>
                              <option value="active">Active</option>
                              <option value="discontinued">Discontinued</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-5 col-md-8">
                          <div class="filter-group">
                            <label for="searchBar" class="form-label fw-semibold">
                              <i class="fa fa-search me-1 text-primary"></i>Search
                            </label>
                            <div class="search-input-group">
                              <input type="text" id="searchBar" class="form-control form-control-modern" 
                                     placeholder="Search products by name, category, description..." onkeyup="searchProducts()">
                              <span class="search-icon">
                                <i class="fa fa-search"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-1 col-md-4">
                          <div class="filter-group">
                            <label class="form-label fw-semibold text-transparent">Action</label>
                            <button type="button" class="btn btn-outline-primary w-100" onclick="clearFilters()" 
                                    title="Clear all filters and reset search">
                              <i class="fa fa-refresh"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover table-striped" id="productTable">
                        <thead class="table-dark">
                          <tr>
                            <th class="text-center" style="width: 80px;">
                              <i class="fa fa-hashtag me-1"></i>ID
                            </th>
                            <th style="width: 200px;">
                              <i class="fa fa-cube me-1"></i>Product Name
                            </th>
                            <th style="width: 150px;">
                              <i class="fa fa-tags me-1"></i>Category
                            </th>
                            <th class="text-center" style="width: 120px;">
                              <i class="fa fa-rupee me-1"></i>Price
                            </th>
                            <th class="text-center" style="width: 100px;">
                              <i class="fa fa-file-pdf-o me-1"></i>Catalog
                            </th>
                            <th class="text-center" style="width: 100px;">
                              <i class="fa fa-image me-1"></i>Image
                            </th>
                            <th style="width: 200px;">
                              <i class="fa fa-align-left me-1"></i>Description
                            </th>
                            <th class="text-center" style="width: 100px;">
                              <i class="fa fa-info-circle me-1"></i>Status
                            </th>
                            <th class="text-center" style="width: 120px;">
                              <i class="fa fa-cogs me-1"></i>Actions
                            </th>
                          </tr>
                        </thead>
                        <tbody id="product-table-body">
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
            
            <!-- Categories Table -->
            <div class="mt-5">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                    <h3 class="text-white mb-1">
                      <i class="fa fa-tags me-2"></i>Product Categories
                    </h3>
                    <small class="text-white-50">Manage and organize your product categories</small>
                  </div>
                  <button type="button" class="btn btn-light shadow-sm" onclick="showCategoryModal()">
                    <i class="fa fa-plus me-2"></i>Add Category
                  </button>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-data2 table-hover mb-0" id="categoriesTable">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Category Name</th>
                          <th class="text-center">Total Products</th>
                          <th class="text-center">Active Products</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="categoriesTableBody">
                        <tr>
                          <td colspan="6" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- Pagination -->
                  <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted" id="categoriesPaginationInfo">
                      Showing <span id="categoriesStart">0</span> to <span id="categoriesEnd">0</span> of <span id="categoriesTotal">0</span> categories
                    </div>
                    <nav aria-label="Categories pagination">
                      <ul class="pagination mb-0" id="categoriesPagination">
                        <!-- Pagination will be inserted here by JavaScript -->
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <!-- Add rows here -->
          
        <!-- End the main code above this line -->
<?php require './bottom.php'; ?>

<!-- SweetAlert2 CSS -->

<!-- JavaScript Libraries -->
<!-- Bootstrap Bundle with Popper -->
<!-- SweetAlert2 -->

<style>
/* Card Styling */
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    border-radius: 0.35rem;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
    padding: 1.5rem;
}

.card-header h3 {
    color: white !important;
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.card-header small {
    color: rgba(255, 255, 255, 0.8) !important;
    font-size: 0.875rem;
}

/* Enhanced Filter Section */
.filter-section {
    background: #f8f9fc;
    border-radius: 0.5rem;
    padding: 1.5rem;
    border: 1px solid #e3e6f0;
}

.filter-group {
    position: relative;
}

.filter-group .form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #5a5c69;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.text-transparent {
    color: transparent !important;
}

/* Modern Form Controls */
.form-select-modern,
.form-control-modern {
    border: 2px solid #e3e6f0;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    background-color: white;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.form-select-modern:focus,
.form-control-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    outline: none;
}

.form-select-modern:hover,
.form-control-modern:hover {
    border-color: #667eea;
}

/* Search Input Group */
.search-input-group {
    position: relative;
}

.search-input-group .form-control-modern {
    padding-right: 3rem;
}

.search-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #adb5bd;
    pointer-events: none;
    z-index: 5;
}

.search-input-group .form-control-modern:focus + .search-icon {
    color: #667eea;
}

/* Enhanced Button Styling */
.btn {
    border-radius: 0.5rem;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    border-width: 2px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: 2px solid transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

.btn-outline-primary {
    border: 2px solid #667eea;
    color: #667eea;
    background: white;
}

.btn-outline-primary:hover {
    background: #667eea;
    border-color: #667eea;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Center icon in reset button */
.filter-section .btn[onclick="clearFilters()"] {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    padding: 0;
    margin-top: 1.5rem;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filter-section {
        padding: 1rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between > div:first-child {
        text-align: center;
    }
}

/* Table container */
.table-responsive-data2 {
    overflow-x: auto;
    border-radius: 0.35rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

/* Base table styles */
.table-data2 {
    min-width: 1200px;
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    background-color: #fff;
}

/* Modern table styling */
.table-data2 thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white !important;
    font-weight: 600;
    padding: 1rem 0.75rem;
    border: none;
    font-size: 0.875rem;
    letter-spacing: 0.02em;
    position: sticky;
    top: 0;
    z-index: 10;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.table-data2 thead th i {
    color: white !important;
    opacity: 0.9;
}

.table-data2 thead th:first-child {
    border-top-left-radius: 0.35rem;
}

.table-data2 thead th:last-child {
    border-top-right-radius: 0.35rem;
}

/* Enhanced table row styling */
.table-data2 tbody .product-row {
    border-bottom: 1px solid #e3e6f0;
    transition: all 0.2s ease;
}

.table-data2 tbody .product-row:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.table-data2 tbody .product-row:last-child {
    border-bottom: none;
}

/* Default cell styles */
.table-data2 td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-top: none;
    font-size: 0.875rem;
    line-height: 1.5;
    color: #5a5c69;
}

/* Product-specific styling */
.product-id-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-weight: 600;
    font-size: 0.75rem;
}

.product-title {
    color: #2c3e50;
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.3;
}

.product-name-cell {
    max-width: 200px;
}

/* Image styling */
.product-image-container {
    width: 50px;
    height: 50px;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 2px solid #e3e6f0;
    display: inline-block;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.2s ease;
}

.product-image:hover {
    transform: scale(1.05);
}

.product-image-placeholder {
    width: 50px;
    height: 50px;
    background: #f8f9fc;
    border: 2px dashed #dee2e6;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #adb5bd;
}

/* Description styling */
.description-cell {
    max-width: 200px;
}

.description-text {
    color: #6c757d;
    font-size: 0.85rem;
    line-height: 1.4;
}

/* No data message styling */
.no-data-message {
    padding: 3rem 1rem;
}

.no-data-message i {
    opacity: 0.5;
}

.no-data-message h5 {
    margin-top: 1rem;
    color: #6c757d;
}

/* Categories table styles */
#categoriesTable {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
}

#categoriesTable thead th {
    background-color: #4e73df;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
    border: none;
}

#categoriesTable tbody tr {
    transition: all 0.2s ease;
}

#categoriesTable tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

#categoriesTable tbody td {
    padding: 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #e3e6f0;
}

/* Make text white for specific columns with colored backgrounds */
#categoriesTable tbody td:first-child,
#categoriesTable tbody td:nth-child(3),
#categoriesTable tbody td:nth-child(4),
#categoriesTable tbody td:nth-child(5) {
    color: white !important;
    font-weight: 500;
}

/* Category name styling */
.category-name {
    font-weight: 500;
    color: #2c3e50;
}

/* Badge styling */
.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
    padding: 0.4em 0.8em;
    border-radius: 0.25rem;
    font-size: 0.75rem;
}

/* Action buttons */
.btn-group .btn {
    border-radius: 0.25rem;
    margin: 0 2px;
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
}

.btn-outline-primary {
    border-color: #4e73df;
    color: #4e73df;
}

.btn-outline-primary:hover {
    background-color: #4e73df;
    border-color: #4e73df;
    color: white;
}

.btn-outline-danger {
    border-color: #e74a3b;
    color: #e74a3b;
}

.btn-outline-danger:hover:not(:disabled) {
    background-color: #e74a3b;
    border-color: #e74a3b;
    color: white;
}

.btn-outline-danger:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Status badges */
.bg-success {
    background-color: #1cc88a !important;
}

.bg-secondary {
    background-color: #858796 !important;
}

/* SweetAlert2 custom styles */
.swal2-popup {
    border-radius: 0.5rem !important;
    padding: 2rem !important;
}

.swal2-title {
    font-size: 1.5rem !important;
    font-weight: 600 !important;
    color: #2c3e50 !important;
}

.swal2-html-container {
    font-size: 1rem !important;
    color: #5a5c69 !important;
}

.swal2-confirm {
    background-color: #4e73df !important;
    border: none !important;
    border-radius: 0.375rem !important;
    padding: 0.5rem 1.5rem !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
}

.swal2-cancel {
    border-radius: 0.375rem !important;
    padding: 0.5rem 1.5rem !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
}

/* Form controls */
.form-control {
    border: 1px solid #d1d3e2;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #bac8f3;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    outline: 0;
}

.form-label {
    font-weight: 500;
    color: #5a5c69;
    margin-bottom: 0.5rem;
    display: block;
}

.no-data-message p {
    margin-bottom: 0;
    color: #adb5bd;
}

/* Column widths */
.table-data2 th:nth-child(1), /* Product ID */
.table-data2 td:nth-child(1) {
    width: 100px; /* Increased width */
}

.table-data2 th:nth-child(2), /* Product Name */
.table-data2 td:nth-child(2) {
    width: 150px;
}

.table-data2 th:nth-child(3), /* Product Category */
.table-data2 td:nth-child(3) {
    width: 150px;
}

.table-data2 th:nth-child(4), /* Approx Cost */
.table-data2 td:nth-child(4) {
    width: 100px;
}

.table-data2 th:nth-child(5), /* PDF Link */
.table-data2 td:nth-child(5) {
    width: 100px;
}

.table-data2 th:nth-child(6), /* Cover Image */
.table-data2 td:nth-child(6) {
    width: 100px; /* New column width */
}

.table-data2 th:nth-child(7), /* Description */
.table-data2 td:nth-child(7) {
    width: 250px;
}

.table-data2 th:nth-child(8), /* Status */
.table-data2 td:nth-child(8) {
    width: 150px; /* Increased width */
}

.table-data2 th:nth-child(9), /* Action */
.table-data2 td:nth-child(9) {
    width: 150px; /* Increased width */
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
.table-data2 td:nth-child(7) {
    position: relative;
}

/* Optional: Add tooltip for long text */
.table-data2 td:nth-child(7)[title] {
    cursor: help;
}

/* Ensure table cells align properly */
.table-data2 th,
.table-data2 td {
    vertical-align: middle !important;
}

/* Ensure action buttons are aligned in one line */
.action-buttons {
    display: flex;
    gap: 10px; /* Space between buttons */
}

/* Badge styles */
.badge-status {
    display: inline-block;
    padding: 0.35em 0.7em;
    font-size: 0.95em;
    border-radius: 0.5em;
    font-weight: 600;
    letter-spacing: 0.03em;
}
.badge-status.active {
    background: #e8f5e9;
    color: #388e3c;
    border: 1px solid #a5d6a7;
}
.badge-status.discontinued {
    background: #fff3e0;
    color: #f57c00;
    border: 1px solid #ffcc80;
}

/* SweetAlert2 Custom Styles */
.swal2-popup-lg {
    width: 600px !important;
    max-width: 90vw !important;
}

.swal2-popup .form-control {
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.swal2-popup .form-control:focus {
    border-color: #bac8f3;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.swal2-popup .form-label {
    font-weight: 600;
    color: #5a5c69;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.swal2-popup .form-group {
    margin-bottom: 1rem;
}

.swal2-popup .btn {
    font-weight: 600;
    padding: 0.375rem 1rem;
    border-radius: 0.35rem;
    font-size: 0.9rem;
}

.swal2-popup .btn-success {
    background-color: #1cc88a;
    border-color: #1cc88a;
}

.swal2-popup .btn-success:hover {
    background-color: #17a673;
    border-color: #169b6b;
}

.swal2-popup .btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.swal2-popup .btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
}

.swal2-popup .btn-secondary {
    background-color: #858796;
    border-color: #858796;
}

.swal2-popup .btn-secondary:hover {
    background-color: #717384;
    border-color: #6b6d7d;
}

.swal2-popup .btn-danger {
    background-color: #e74a3b;
    border-color: #e74a3b;
}

.swal2-popup .btn-danger:hover {
    background-color: #e02e1e;
    border-color: #d52a1a;
}

/* Ensure proper spacing in SweetAlert2 */
.swal2-html-container {
    margin: 1rem 0;
}

.swal2-actions {
    margin-top: 1.5rem;
}

/* PDF Viewer Popup Styles */
.swal2-popup-xl {
    width: 90% !important;
    max-width: 1200px !important;
}

.pdf-viewer-container {
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
    overflow: hidden;
    background: #f8f9fc;
}

.pdf-viewer-container iframe {
    display: block;
    border: none;
}

/* PDF Button Styles */
.btn-view-pdf {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

.btn-view-pdf:hover {
    background-color: #4e73df;
    border-color: #4e73df;
    color: white;
}

/* File Input Styling */
.form-control[type="file"] {
    padding: 0.375rem 0.75rem;
    line-height: 1.5;
}

.form-control[type="file"]::-webkit-file-upload-button {
    background-color: #4e73df;
    color: white;
    border: none;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    margin-right: 0.5rem;
    cursor: pointer;
}

.form-control[type="file"]::-webkit-file-upload-button:hover {
    background-color: #2e59d9;
}

/* Form Text Styling */
.form-text {
    font-size: 0.8rem;
    color: #858796;
}

.text-info {
    color: #36b9cc !important;
}
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;
let pollingInterval;
let allProducts = []; // Store all products data

// Function to load table data
function loadTableData(page = 1) {
    const searchTerm = document.getElementById('searchBar').value.toLowerCase();
    
    // Build query parameters with filters
    const params = new URLSearchParams({
        page: page,
        rowsPerPage: rowsPerPage
    });
    
    // Add filter parameters if they exist
    if (currentFilters.category) {
        params.append('category', currentFilters.category);
    }
    if (currentFilters.status) {
        params.append('status', currentFilters.status);
    }
    
    fetch(`./data/products_data.php?${esc(params.toString())}`)
        .then(response => response.json())
        .then(data => {
            allProducts = data.products; // Store products data
            renderTable(data.products, searchTerm);
            renderPagination(data.pagination);
        })
        .catch(error => {
            console.error('Error loading data:', error);
            Swal.fire('Error', 'Failed to load products data', 'error');
        });
}

// Function to render table
function renderTable(products, searchTerm = '') {
    const tableBody = document.getElementById('product-table-body');
    tableBody.innerHTML = '';

    if (products.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center py-5">
                    <div class="no-data-message">
                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Products Found</h5>
                        <p class="text-muted">Try adjusting your filters or search terms.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    products.forEach(product => {
        const id = product.id.toString().toLowerCase();
        const name = product.name.toLowerCase();
        const category = product.category.toLowerCase();
        const cost = product.cost.toLowerCase();
        const pdf = product.pdf ? product.pdf.toLowerCase() : '';
        const image = product.cover_image ? product.cover_image.toLowerCase() : '';
        const description = product.description ? product.description.toLowerCase() : '';
        const status = product.status.toLowerCase();

        if (id.includes(searchTerm) || name.includes(searchTerm) || category.includes(searchTerm) || cost.includes(searchTerm) || pdf.includes(searchTerm) || description.includes(searchTerm) || status.includes(searchTerm)) {
            
            // Enhanced status badge with better styling
            const statusClass = status === 'active' ? 'success' : 'danger';
            const statusIcon = status === 'active' ? 'check-circle' : 'times-circle';
            const statusBadge = `
                <span class="badge bg-${statusClass} d-flex align-items-center justify-content-center" style="min-width: 80px; color: white !important;">
                    <i class="fa fa-${statusIcon} me-1" style="color: white !important;"></i>
                    <span style="color: white !important;">${esc(product.status.charAt(0).toUpperCase() + product.status.slice(1))}</span>
                </span>
            `;
            
            // Truncate description with better formatting
            const descShort = product.description && product.description.length > 50 
                ? product.description.slice(0, 50) + '…' 
                : (product.description || 'No description');
            
            // Enhanced PDF cell with better styling
            let pdfCell = `
                <div class="text-center">
                    <span class="text-muted small">
                        <i class="fa fa-file-o"></i> No PDF
                    </span>
                </div>
            `;
            if (product.pdf) {
                pdfCell = `
                    <div class="text-center">
                        <button class="btn btn-outline-primary btn-sm btn-view-pdf" data-pdf="${esc(product.pdf)}" title="View PDF">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                    </div>
                `;
            }
            
            // Enhanced image cell with better styling and fallback
            let coverCell = `
                <div class="text-center">
                    <div class="product-image-placeholder">
                        <i class="fa fa-image text-muted"></i>
                    </div>
                </div>
            `;
            if (product.cover_image) {
                coverCell = `
                    <div class="text-center">
                        <div class="product-image-container">
                            <img src="${esc(siteAsset(product.cover_image))}" alt="${esc(product.name)}" class="product-image" 
                                 onerror="this.parentElement.innerHTML='<div class=\"product-image-placeholder\"><i class=\"fa fa-image text-muted\"></i></div>'">
                        </div>
                    </div>
                `;
            }
            
            // Enhanced product name with better formatting
            const productName = `
                <div class="product-name-cell">
                    <strong class="product-title">${esc(product.name)}</strong>
                </div>
            `;
            
            // Enhanced category with badge styling
            const categoryCell = `
                <span class="badge bg-light text-dark border" data-category-id="${esc(product.category_id)}">
                    <i class="fa fa-tag me-1"></i>${esc(product.category)}
                </span>
            `;
            
            // Enhanced price with better formatting
            const priceCell = `
                <div class="text-center">
                    <strong class="text-success">${esc(product.cost)}</strong>
                </div>
            `;
            
            // Enhanced description with tooltip
            const descriptionCell = `
                <div class="description-cell" title="${esc(product.description ? product.description.replace(/"/g, '&quot;') : 'No description')}">
                    <span class="description-text">${esc(descShort)}</span>
                </div>
            `;
            
            const row = `
                <tr class="product-row" data-id="${esc(product.id)}">
                    <td class="text-center align-middle">
                        <span class="product-id-badge">#${esc(product.id)}</span>
                    </td>
                    <td class="align-middle">${productName}</td>
                    <td class="text-center align-middle">${categoryCell}</td>
                    <td class="align-middle">${priceCell}</td>
                    <td class="align-middle">${pdfCell}</td>
                    <td class="align-middle">${coverCell}</td>
                    <td class="align-middle">${descriptionCell}</td>
                    <td class="text-center align-middle">${statusBadge}</td>
                    <td class="text-center align-middle">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-primary btn-sm btn-edit-product" data-id="${esc(product.id)}" title="Edit Product">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm btn-delete-product" data-id="${esc(product.id)}" title="Delete Product">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        }
    });
    
    // Add empty state if no products match search
    if (tableBody.innerHTML === '') {
        tableBody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center py-5">
                    <div class="no-data-message">
                        <i class="fa fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Results Found</h5>
                        <p class="text-muted">No products match your search criteria: "<strong>${esc(searchTerm)}</strong>"</p>
                    </div>
                </td>
            </tr>
        `;
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

// Keep the table current (crmLiveRefresh)
function startPolling() {
    loadTableData(currentPage);
    pollingInterval = crmLiveRefresh(() => {
        loadTableData(currentPage);
    });
}

// Function to search products
function searchProducts() {
    loadTableData(currentPage);
}

// Fetch categories from the database
function fetchCategories() {
    return new Promise((resolve, reject) => {
        $.get('data/products_data.php', { action: 'get_categories' })
            .done(function(response) {
                if (response.success) {
                    resolve(response.categories);
                } else {
                    reject(new Error('Failed to load categories'));
                }
            })
            .fail(function() {
                reject(new Error('Network error loading categories'));
            });
    });
}

// Add Product functionality using SweetAlert2
async function addProduct() {
    try {
        const categories = await fetchCategories();
        const categoryOptions = categories.map(cat =>
            `<option value="${esc(cat.category_id)}">${esc(cat.category_name)}</option>`
        ).join('');

        const { value: formValues } = await Swal.fire({
            title: 'Add New Product',
            html: `
                <div class="form-group mb-3">
                    <label for="swal-input-name" class="form-label">Product Name</label>
                    <input id="swal-input-name" class="form-control" placeholder="Enter product name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-input-category" class="form-label">Category</label>
                    <select id="swal-input-category" class="form-control" required>
                        <option value="">Select category</option>
                        ${categoryOptions}
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-input-cost" class="form-label">Cost (₹)</label>
                    <input id="swal-input-cost" class="form-control" type="number" step="0.01" placeholder="Enter cost" required>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-input-pdf" class="form-label">Catalogue PDF</label>
                    <input id="swal-input-pdf" class="form-control" type="file" accept=".pdf" onchange="validatePdfFile(this)">
                    <small class="form-text text-muted">Max size: 10MB. Only PDF files allowed.</small>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-input-cover" class="form-label">Cover Image</label>
                    <input id="swal-input-cover" class="form-control" type="file" accept="image/*" onchange="validateImageFile(this)">
                    <small class="form-text text-muted">Max size: 2MB. Only image files allowed.</small>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-input-description" class="form-label">Description</label>
                    <textarea id="swal-input-description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-input-status" class="form-label">Status</label>
                    <select id="swal-input-status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="discontinued">Discontinued</option>
                    </select>
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Add Product',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'swal2-popup-lg',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false,
            preConfirm: () => {
                const name = document.getElementById('swal-input-name').value.trim();
                const category_id = document.getElementById('swal-input-category').value;
                const cost = document.getElementById('swal-input-cost').value;
                const pdfFile = document.getElementById('swal-input-pdf').files[0];
                const coverFile = document.getElementById('swal-input-cover').files[0];
                const description = document.getElementById('swal-input-description').value.trim();
                const status = document.getElementById('swal-input-status').value;

                if (!name) {
                    Swal.showValidationMessage('Product name is required');
                    return false;
                }
                if (!category_id) {
                    Swal.showValidationMessage('Category is required');
                    return false;
                }
                if (!cost || cost <= 0) {
                    Swal.showValidationMessage('Valid cost is required');
                    return false;
                }

                return { name, category_id, cost, pdfFile, coverFile, description, status };
            }
        });

        if (formValues) {
            // Create FormData for file upload
            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('name', formValues.name);
            formData.append('category_id', formValues.category_id);
            formData.append('cost', formValues.cost);
            formData.append('description', formValues.description);
            formData.append('status', formValues.status);
            
            if (formValues.pdfFile) {
                formData.append('pdf', formValues.pdfFile);
            }
            if (formValues.coverFile) {
                formData.append('cover_image', formValues.coverFile);
            }
            if (formValues.coverFile) {
                formData.append('cover_image', formValues.coverFile);
            }

            try {
                const response = await fetch('data/products_data.php', {
                    method: 'POST',
                    body: formData
                });

                // Check if response is ok
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${esc(response.status)}`);
                }

                // Get response text first for debugging
                const responseText = await response.text();
                console.log('Raw response:', responseText);

                // Try to parse as JSON
                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (parseError) {
                    console.error('JSON parse error:', parseError);
                    console.error('Response text:', responseText);
                    throw new Error('Server returned invalid JSON. Check console for details.');
                }

                if (result.success) {
                    Swal.fire('Success!', 'Product added successfully', 'success');
                    loadTableData(currentPage);
                } else {
                    Swal.fire('Error!', result.message || 'Failed to add product', 'error');
                }
            } catch (error) {
                console.error('Fetch error:', error);
                Swal.fire('Error!', error.message || 'Failed to add product', 'error');
            }
        }
    } catch (error) {
        console.error('Error adding product:', error);
        Swal.fire('Error!', error.message || 'Failed to add product', 'error');
    }
}

// Edit Product functionality using SweetAlert2
async function editProductPopup(id) {
    try {
        // Find product data from stored array
        const product = allProducts.find(p => p.id == id);
        if (!product) {
            Swal.fire('Error!', 'Product not found', 'error');
            return;
        }

        const categories = await fetchCategories();
        const categoryOptions = categories.map(cat =>
            `<option value="${esc(cat.category_id)}" ${esc(cat.category_id == product.category_id ? 'selected' : '')}>${esc(cat.category_name)}</option>`
        ).join('');

        // Extract numeric cost value
        const costValue = product.cost.replace(/[^\d.]/g, '');

        const { value: formValues } = await Swal.fire({
            title: 'Edit Product',
            html: `
                <div class="form-group mb-3">
                    <label for="swal-edit-name" class="form-label">Product Name</label>
                    <input id="swal-edit-name" class="form-control" value="${esc(product.name)}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-edit-category" class="form-label">Category</label>
                    <select id="swal-edit-category" class="form-control" required>
                        ${categoryOptions}
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-edit-cost" class="form-label">Cost (₹)</label>
                    <input id="swal-edit-cost" class="form-control" type="number" step="0.01" value="${costValue}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-edit-pdf" class="form-label">Catalogue PDF</label>
                    ${product.pdf ? `<div class="mb-2"><small class="text-info">Current: ${esc(product.pdf.split('/').pop())}</small></div>` : ''}
                    <input id="swal-edit-pdf" class="form-control" type="file" accept=".pdf" onchange="validatePdfFile(this)">
                    <small class="form-text text-muted">Leave empty to keep current PDF. Max size: 10MB.</small>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-edit-cover" class="form-label">Cover Image</label>
                    ${product.cover_image ? `<div class="mb-2"><img src="${esc(siteAsset(product.cover_image))}" alt="Current Cover" style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #eee;"></div>` : ''}
                    <input id="swal-edit-cover" class="form-control" type="file" accept="image/*" onchange="validateImageFile(this)">
                    <small class="form-text text-muted">Leave empty to keep current image. Max size: 2MB.</small>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-edit-description" class="form-label">Description</label>
                    <textarea id="swal-edit-description" class="form-control" rows="3">${esc(product.description || '')}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="swal-edit-status" class="form-label">Status</label>
                    <select id="swal-edit-status" class="form-control" required>
                        <option value="active" ${esc(product.status === 'active' ? 'selected' : '')}>Active</option>
                        <option value="discontinued" ${esc(product.status === 'discontinued' ? 'selected' : '')}>Discontinued</option>
                    </select>
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Update Product',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'swal2-popup-lg',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false,
            preConfirm: () => {
                const name = document.getElementById('swal-edit-name').value.trim();
                const category_id = document.getElementById('swal-edit-category').value;
                const cost = document.getElementById('swal-edit-cost').value;
                const pdfFile = document.getElementById('swal-edit-pdf').files[0];
                const coverFile = document.getElementById('swal-edit-cover').files[0];
                const description = document.getElementById('swal-edit-description').value.trim();
                const status = document.getElementById('swal-edit-status').value;

                if (!name) {
                    Swal.showValidationMessage('Product name is required');
                    return false;
                }
                if (!category_id) {
                    Swal.showValidationMessage('Category is required');
                    return false;
                }
                if (!cost || cost <= 0) {
                    Swal.showValidationMessage('Valid cost is required');
                    return false;
                }

                return { id: product.id, name, category_id, cost, pdfFile, coverFile, description, status };
            }
        });

        if (formValues) {
            // Create FormData for file upload
            const formData = new FormData();
            formData.append('action', 'edit');
            formData.append('id', formValues.id);
            formData.append('name', formValues.name);
            formData.append('category_id', formValues.category_id);
            formData.append('cost', formValues.cost);
            formData.append('description', formValues.description);
            formData.append('status', formValues.status);
            
            if (formValues.pdfFile) {
                formData.append('pdf', formValues.pdfFile);
            }
            if (formValues.coverFile) {
                formData.append('cover_image', formValues.coverFile);
            }

            try {
                const response = await fetch('data/products_data.php', {
                    method: 'POST',
                    body: formData
                });

                // Check if response is ok
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${esc(response.status)}`);
                }

                // Get response text first for debugging
                const responseText = await response.text();
                console.log('Raw response:', responseText);

                // Try to parse as JSON
                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (parseError) {
                    console.error('JSON parse error:', parseError);
                    console.error('Response text:', responseText);
                    throw new Error('Server returned invalid JSON. Check console for details.');
                }

                if (result.success) {
                    Swal.fire('Success!', 'Product updated successfully', 'success');
                    loadTableData(currentPage);
                } else {
                    Swal.fire('Error!', result.message || 'Failed to update product', 'error');
                }
            } catch (error) {
                console.error('Fetch error:', error);
                Swal.fire('Error!', error.message || 'Failed to update product', 'error');
            }
        }
    } catch (error) {
        console.error('Error editing product:', error);
        Swal.fire('Error!', error.message || 'Failed to edit product', 'error');
    }
}

// Delete Product functionality using SweetAlert2
async function deleteProduct(id) {
    try {
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            const response = await $.post('data/products_data.php', {
                action: 'delete',
                id: id
            });

            if (response.success) {
                Swal.fire('Deleted!', 'Product has been deleted successfully.', 'success');
                loadTableData(currentPage);
            } else {
                Swal.fire('Error!', response.message || 'Failed to delete product', 'error');
            }
        }
    } catch (error) {
        console.error('Error deleting product:', error);
        Swal.fire('Error!', 'Failed to delete product', 'error');
    }
}

// PDF file validation function
function validatePdfFile(input) {
    const file = input.files[0];
    if (file) {
        // Check file type
        if (file.type !== 'application/pdf') {
            Swal.fire('Error!', 'Only PDF files are allowed', 'error');
            input.value = '';
            return false;
        }
        
        // Check file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            Swal.fire('Error!', 'File size must be less than 10MB', 'error');
            input.value = '';
            return false;
        }
    }
    return true;
}

// Image file validation function
function validateImageFile(input) {
    const file = input.files[0];
    if (file) {
        if (!file.type.startsWith('image/')) {
            Swal.fire('Error!', 'Only image files are allowed', 'error');
            input.value = '';
            return false;
        }
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire('Error!', 'Image size must be less than 2MB', 'error');
            input.value = '';
            return false;
        }
    }
    return true;
}

// PDF Viewer Popup
// Stored upload paths are relative to the site root ("uploads/..."); this page is three folders deeper.
function siteAsset(path) {
    if (!path) return '';
    return /^(https?:)?\/\//.test(path) || path.charAt(0) === '/' ? path : '../../../' + path;
}

function viewPdfPopup(pdfPath) {
    const fullPdfUrl = siteAsset(pdfPath);

    Swal.fire({
        title: 'Product Catalogue PDF',
        html: `
            <div class="pdf-viewer-container">
                <iframe src="${fullPdfUrl}" width="100%" height="500px" frameborder="0"></iframe>
            </div>
            <div class="mt-3">
                <a href="${fullPdfUrl}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fa fa-external-link"></i> Open in New Tab
                </a>
                <a href="${fullPdfUrl}" download class="btn btn-success btn-sm">
                    <i class="fa fa-download"></i> Download PDF
                </a>
            </div>
        `,
        width: '80%',
        showConfirmButton: false,
        showCloseButton: true,
        customClass: {
            popup: 'swal2-popup-xl'
        }
    });
}

// Event delegation for edit and delete buttons
document.addEventListener('click', function(e) {
    const editBtn = e.target.closest('.btn-edit-product');
    if (editBtn) {
        e.preventDefault();
        const id = editBtn.getAttribute('data-id');
        editProductPopup(id);
        return;
    }

    const deleteBtn = e.target.closest('.btn-delete-product');
    if (deleteBtn) {
        e.preventDefault();
        const id = deleteBtn.getAttribute('data-id');
        deleteProduct(id);
        return;
    }

    const viewPdfBtn = e.target.closest('.btn-view-pdf');
    if (viewPdfBtn) {
        e.preventDefault();
        const pdfPath = viewPdfBtn.getAttribute('data-pdf');
        viewPdfPopup(pdfPath);
        return;
    }
});

// Filter functionality
let currentFilters = {
    category: '',
    status: ''
};

// Load categories for filter dropdown
async function loadCategories() {
    try {
        const response = await fetch('data/products_data.php?action=get_categories');
        const data = await response.json();
        
        if (data.success && data.categories) {
            const categoryFilter = document.getElementById('categoryFilter');
            
            // Clear existing options except "All Categories"
            categoryFilter.innerHTML = '<option value="">All Categories</option>';
            
            // Add category options
            data.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.category_id;
                option.textContent = category.category_name;
                categoryFilter.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error loading categories:', error);
    }
}

// Apply filters function
function applyFilters() {
    const categoryFilter = document.getElementById('categoryFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    
    currentFilters.category = categoryFilter;
    currentFilters.status = statusFilter;
    
    // Reset to first page when applying filters
    currentPage = 1;
    loadTableData(currentPage);
}

// Clear all filters
function clearFilters() {
    document.getElementById('categoryFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('searchBar').value = '';
    
    currentFilters = {
        category: '',
        status: ''
    };
    
    currentPage = 1;
    loadTableData(currentPage);
}

// Add Product button event
document.addEventListener('DOMContentLoaded', () => {
    const addProductBtn = document.getElementById('addProductBtn');
    if (addProductBtn) {
        addProductBtn.addEventListener('click', addProduct);
    }
    
    // Load categories for filter dropdown
    loadCategories();
    
    startPolling();
    
    // Load categories table
    loadCategoriesTable();
});

// ======================
// Category Management
// ======================

// Categories table functionality
let categories = [];
let currentCategoriesPage = 1;
const categoriesPerPage = 10;

// Load categories table with pagination
function loadCategoriesTable(page = 1) {
    currentCategoriesPage = page;
    console.log(`Loading categories page ${page}...`);
    
    const params = new URLSearchParams({
        action: 'get_categories',
        page: page,
        per_page: categoriesPerPage
    });
    
    fetch('data/categories_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Error response text:', text);
                throw new Error(`HTTP error! status: ${esc(response.status)}, body: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Categories data:', data);
        if (data && data.success) {
            categories = data.data || [];
            renderCategoriesTable(categories);
            
            // Update pagination info
            if (data.pagination) {
                updateCategoriesPagination(data.pagination);
            }
        } else {
            const errorMsg = data && data.message ? data.message : 'Invalid response format';
            console.error('Error loading categories:', errorMsg);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Failed to load categories: ${errorMsg}`,
                confirmButtonColor: '#4e73df'
            });
        }
    })
    .catch(error => {
        console.error('Error loading categories:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `An error occurred while loading categories: ${esc(error.message)}`,
            confirmButtonColor: '#4e73df'
        });
    });
}

// Update categories pagination info and controls
function updateCategoriesPagination(pagination) {
    const start = ((pagination.current_page - 1) * pagination.per_page) + 1;
    const end = Math.min(start + pagination.per_page - 1, pagination.total);
    
    // Update pagination info text
    document.getElementById('categoriesStart').textContent = start;
    document.getElementById('categoriesEnd').textContent = end;
    document.getElementById('categoriesTotal').textContent = pagination.total;
    
    // Generate pagination controls
    const paginationContainer = document.getElementById('categoriesPagination');
    if (!paginationContainer) return;
    
    let paginationHTML = '';
    const maxPagesToShow = 5;
    let startPage, endPage;
    
    if (pagination.total_pages <= maxPagesToShow) {
        // Less than max pages so show all pages
        startPage = 1;
        endPage = pagination.total_pages;
    } else {
        // More than max pages so calculate start and end pages
        const maxPagesBeforeCurrent = Math.floor(maxPagesToShow / 2);
        const maxPagesAfterCurrent = Math.ceil(maxPagesToShow / 2) - 1;
        
        if (pagination.current_page <= maxPagesBeforeCurrent) {
            // Current page near the start
            startPage = 1;
            endPage = maxPagesToShow;
        } else if (pagination.current_page + maxPagesAfterCurrent >= pagination.total_pages) {
            // Current page near the end
            startPage = pagination.total_pages - maxPagesToShow + 1;
            endPage = pagination.total_pages;
        } else {
            // Current page somewhere in the middle
            startPage = pagination.current_page - maxPagesBeforeCurrent;
            endPage = pagination.current_page + maxPagesAfterCurrent;
        }
    }
    
    // Previous button
    paginationHTML += `
        <li class="page-item ${esc(pagination.current_page === 1 ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); loadCategoriesTable(${esc(pagination.current_page - 1)})" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;
    
    // Page numbers
    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `
            <li class="page-item ${esc(pagination.current_page === i ? 'active' : '')}">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadCategoriesTable(${i})">${i}</a>
            </li>
        `;
    }
    
    // Next button
    paginationHTML += `
        <li class="page-item ${esc(pagination.current_page === pagination.total_pages ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="event.preventDefault(); loadCategoriesTable(${esc(pagination.current_page + 1)})" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;
    
    paginationContainer.innerHTML = paginationHTML;
}

// Render categories table
function renderCategoriesTable(categories) {
    const tbody = document.getElementById('categoriesTableBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (!categories || categories.length === 0) {
        const tr = document.createElement('tr');
        tr.className = 'category-row';
        tr.innerHTML = `
            <td colspan="6" class="text-center py-4">
                <div class="d-flex flex-column align-items-center">
                    <i class="fas fa-inbox mb-2" style="font-size: 1.5rem; color: #d1d3e2;"></i>
                    <span class="text-muted">No categories found</span>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
        return;
    }
    
    categories.forEach(category => {
        const tr = document.createElement('tr');
        tr.className = 'category-row';
        const canDelete = parseInt(category.active_products) === 0;
        const statusClass = category.status === 'active' ? 'bg-success' : 'bg-secondary';
        const statusText = category.status === 'active' ? 'Active' : 'Inactive';
        
        tr.innerHTML = `
            <td class="align-middle">
                <span class="badge bg-primary text-white">#${esc(category.category_id)}</span>
            </td>
            <td class="align-middle fw-semibold">
                <span class="category-name">${escapeHtml(category.category_name)}</span>
            </td>
            <td class="text-center align-middle">
                <span class="badge bg-info text-white">${esc(category.product_count || 0)} Products</span>
            </td>
            <td class="text-center align-middle">
                <span class="badge bg-success text-white">${esc(category.active_products || 0)} Active</span>
            </td>
            <td class="text-center align-middle">
                <span class="badge ${statusClass} text-white">
                    <i class="fas ${esc(category.status === 'active' ? 'fa-check-circle' : 'fa-times-circle')} me-1"></i>
                    ${statusText}
                </span>
            </td>
            <td class="text-center align-middle">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary px-3" 
                            data-name="${esc(category.category_name)}" onclick="editCategory(${esc(category.category_id)}, this.dataset.name)"
                            data-toggle="tooltip" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger px-3" 
                            data-name="${esc(category.category_name)}" onclick="deleteCategory(${esc(category.category_id)}, this.dataset.name, ${canDelete})"
                            ${!canDelete ? 'disabled' : ''}
                            data-toggle="tooltip" 
                            title="${!canDelete ? 'Cannot delete - has active products' : 'Delete'}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
    
    // Initialize tooltips if Bootstrap tooltip plugin is available
    if (typeof $.fn.tooltip === 'function') {
        $('[data-toggle="tooltip"]').tooltip();
    } else {
        console.warn('Bootstrap tooltip plugin not available');
    }
}

// Show add/edit category modal
function showCategoryModal(categoryId = '', categoryName = '') {
    // Decode HTML entities in category name
    const decodedName = String(categoryName ?? '');
    
    Swal.fire({
        title: categoryId ? 'Edit Category' : 'Add New Category',
        html: `
            <form id="categoryForm" class="text-start">
                <input type="hidden" id="categoryId" value="${categoryId || ''}">
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="categoryName" value="${esc(decodedName)}" required>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: categoryId ? 'Update' : 'Add Category',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#4e73df',
        cancelButtonColor: '#6c757d',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            if (categoryId) {
                return editCategory(categoryId, categoryName);
            } else {
                return addCategory();
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (categoryId) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Category updated successfully',
                    confirmButtonColor: '#4e73df'
                }).then(() => {
                    // Reload categories on the current page
                    loadCategoriesTable(currentCategoriesPage);
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Category added successfully',
                    confirmButtonColor: '#4e73df'
                }).then(() => {
                    // Close modal and refresh categories
                    $('#categoryModal').modal('hide');
                    // Reload categories on the first page
                    loadCategoriesTable(1);
                });
            }
        }
    }).catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'An error occurred',
            confirmButtonColor: '#4e73df'
        });
    });
}

// Add new category
function addCategory() {
    const categoryName = document.getElementById('categoryName').value.trim();
    
    if (!categoryName) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please enter a category name',
            confirmButtonColor: '#4e73df'
        });
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'add_category');
    formData.append('category_name', categoryName);
    
    return fetch('data/categories_data.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            return data;
        } else {
            throw new Error(data.message || 'Failed to add category');
        }
    })
    .catch(error => {
        console.error('Error adding category:', error);
        throw new Error(error.message || 'Failed to add category');
    });
}

// Edit category
function editCategory(id, name) {
    Swal.fire({
        title: 'Edit Category',
        input: 'text',
        inputValue: name,
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Save',
        confirmButtonColor: '#4e73df',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: (newName) => {
            if (!newName.trim()) {
                Swal.showValidationMessage('Category name cannot be empty');
                return false;
            }
            
            const formData = new FormData();
            formData.append('action', 'update_category');
            formData.append('category_id', id);
            formData.append('category_name', newName.trim());
            
            return fetch('data/categories_data.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Failed to update category');
                }
                return data;
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            return result.value;
        }
    }).catch(error => {
        console.error('Error updating category:', error);
        throw new Error(error.message || 'Failed to update category');
    });
}

// ...
function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe
        .toString()
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// Set up form submission
document.addEventListener('DOMContentLoaded', function() {
    const categoryForm = document.getElementById('categoryForm');
    if (categoryForm) {
        categoryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveCategory();
        });
    }
});
</script>