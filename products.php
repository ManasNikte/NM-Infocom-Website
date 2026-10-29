<?php 
require "./components/top.php";
require "./data/product_data.php";
$categoriesData = require "./data/product_category_data.php";

// Get categories with product counts
$totalProducts = array_sum(array_column($categoriesData, 'num_of_products'));

// Replace the JavaScript data initialization

$productsDataJSON = json_encode($productsData);
// Price filter spans the real catalogue (in rupees), rounded up to a tidy number.
$maxPrice = max(1000, (int) (ceil(max(array_map('floatval', array_column($productsData['products'] ?? [], 'product_cost')) ?: [0]) / 1000) * 1000));
?>

<!-- Hero section -->
<div class="page-title dark-background">
  <div class="container position-relative">
    <h1>Products</h1>
    <p>The variety of products we deal in</p>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.php#hero">Home</a></li>
        <li class="current">Products</li>
      </ol>
    </nav>
  </div>
</div><!--/Hero section -->

<!-- Product Page Container -->
<div class="product-container">
  <!-- Mobile Header -->
  <div class="mobile-header">
    <!-- Mobile Search Bar -->
    <div class="mobile-search" id="mobileSearch">
      <div class="search-box">
        <input type="text" id="mobileProductSearch" placeholder="Search products...">
      </div>
    </div>
    
    <!-- Sidebar Toggle -->
    <div class="sidebar-toggle" id="sidebarToggle">
      <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <!-- Search Section -->
    <div class="search-section">
      <div class="search-box">
        <input type="text" id="productSearch" placeholder="Search products...">
      </div>
      <div id="searchResults" class="search-results"></div>
    </div>

    <!-- Categories -->
    <div class="category-section">
      <h3>Categories</h3>
      <div class="category-checkboxes">
        <label class="category-checkbox main-category">
          <input type="checkbox" id="allCategories" checked>
          All Categories
          <span class="product-count">(<?php echo $totalProducts; ?>)</span>
        </label>
        <div class="category-divider"></div>
        <?php foreach ($categoriesData as $category): ?>
          <?php if ($category['status'] === 'active'): ?>
            <label class="category-checkbox">
              <input type="checkbox" name="category" data-category="<?php echo htmlspecialchars((string) $category['category_id']); ?>">
              <?php echo htmlspecialchars((string) $category['category_name']); ?>
              <span class="product-count">(<?php echo htmlspecialchars((string) $category['num_of_products']); ?>)</span>
            </label>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
      <h3>Filters</h3>
      
      <!-- Price Range -->
      <div class="filter-group">
        <h4>Price range (₹)</h4>
        <div class="price-range">
          <input type="range" min="0" max="<?= $maxPrice ?>" value="<?= $maxPrice ?>" step="100" class="price-slider" aria-label="Maximum price in rupees">
          <div class="price-inputs">
            <input type="number" value="0" min="0" max="<?= $maxPrice ?>" class="min-price" aria-label="Minimum price (₹)">
            <input type="number" value="<?= $maxPrice ?>" min="0" max="<?= $maxPrice ?>" class="max-price" aria-label="Maximum price (₹)">
          </div>
        </div>
      </div>

      <!-- Sort By -->
      <div class="filter-group">
        <h4>Sort By</h4>
        <select class="sort-select">
          <option value="featured">Featured</option>
          <option value="price-low">Price: Low to High</option>
          <option value="price-high">Price: High to Low</option>
          <option value="newest">Newest First</option>
        </select>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content" id="mainContent">
    <!-- Loading State -->
    <div id="loadingState" class="loading-state" style="display: none;">
      <div class="spinner"></div>
    </div>
    
    <!-- Empty State -->
    <div id="emptyState" class="empty-state" style="display: none;">
      <i class="bi bi-inbox"></i>
      <h3>No Products Found</h3>
      <p>Try adjusting your search or filter criteria</p>
    </div>

    <div class="products-grid" id="productsGrid">
      <!-- Product Cards will be dynamically loaded here -->
    </div>
    
    <!-- Add this new pagination container -->
    <div class="pagination" id="pagination">
      <!-- Pagination buttons will be dynamically loaded here -->
    </div>
  </main>
</div>
 
<script>
const ITEMS_PER_PAGE = 4;
let currentPage = 1;
let productsData = {
    products: <?php echo json_encode($productsData); ?>
};

// No need for fetch since data is loaded directly
function initializeProducts() {
    renderProducts();
    document.getElementById('loadingState').style.display = 'none';
    document.getElementById('productsGrid').style.display = 'grid';
}

function createProductCard(product) {
    return `
        <div class="product-card" data-category="${esc(product.category_id)}">
            <div class="product-image">
                <img src="${esc(product.cover_image || (product.image && !product.image.includes('placehold.co') ? product.image : 'assets/img/services.jpg'))}" alt="${esc(product.product_name)}" loading="lazy">
                ${product.featured ? '<span class="featured-badge">Featured</span>' : ''}
            </div>
            <div class="product-info">
                <h3>${esc(product.product_name)}</h3>
                <p>${esc(product.product_description)}</p>
                <div class="product-footer">
                    <span class="price">${esc(Number(product.product_cost).toLocaleString('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 2 }))}</span>
                    <a href="product_detail.php?id=${esc(product.product_id)}" class="btn-primary">View Details</a>
                </div>
            </div>
        </div>
    `;
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize products directly since we have the data
    initializeProducts();
    
    // ... rest of the existing initialization code ...
});

function renderProducts(products = productsData.products) {
  const productsGrid = document.getElementById('productsGrid');
  const paginationContainer = document.getElementById('pagination');

  if (!products.length) {
    productsGrid.innerHTML = `
      <div class="nm-empty">
        <i class="bi bi-box-seam"></i>
        <h3>${productsData.products.length ? 'No products match your filters' : 'Our product catalogue is being updated'}</h3>
        <p>Tell us what you need and our team will recommend the right hardware or software for you.</p>
        <a href="index.php#contact" class="nm-btn nm-btn-primary">Talk to an expert</a>
      </div>`;
    if (paginationContainer) paginationContainer.innerHTML = '';
    return;
  }

  // Calculate pagination
  const totalPages = Math.ceil(products.length / ITEMS_PER_PAGE);
  const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
  const endIndex = startIndex + ITEMS_PER_PAGE;
  const currentProducts = products.slice(startIndex, endIndex);

  // Create rows of two products each
  let productsHTML = '';
  for (let i = 0; i < currentProducts.length; i += 2) {
    productsHTML += `
      <div class="product-row">
        ${createProductCard(currentProducts[i])}
        ${currentProducts[i + 1] ? createProductCard(currentProducts[i + 1]) : ''}
      </div>
    `;
  }
  
  productsGrid.innerHTML = productsHTML;
  renderPagination(totalPages);
}

function renderPagination(totalPages) {
  const paginationContainer = document.getElementById('pagination');
  let paginationHTML = '';
  
  // Previous button
  paginationHTML += `
    <button class="pagination-btn" 
            ${currentPage === 1 ? 'disabled' : ''} 
            onclick="changePage(${currentPage - 1})">
      Previous
    </button>
  `;

  // Page numbers
  for (let i = 1; i <= totalPages; i++) {
    paginationHTML += `
      <button class="pagination-btn ${currentPage === i ? 'active' : ''}" 
              onclick="changePage(${i})">
        ${i}
      </button>
    `;
  }

  // Next button
  paginationHTML += `
    <button class="pagination-btn" 
            ${currentPage === totalPages ? 'disabled' : ''} 
            onclick="changePage(${currentPage + 1})">
      Next
    </button>
  `;

  paginationContainer.innerHTML = paginationHTML;
}

function changePage(newPage) {
  if (newPage < 1) return;
  const totalPages = Math.ceil(productsData.products.length / ITEMS_PER_PAGE);
  if (newPage > totalPages) return;
  
  currentPage = newPage;
  renderProducts();
}

// Add this function to filter products by category
function filterProductsByCategory(category) {
  const filteredProducts = category === 'all' 
    ? productsData.products 
    : productsData.products.filter(product => product.category === category);
  
  currentPage = 1; // Reset to first page when filtering
  renderProducts(filteredProducts);
}

const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const productsGrid = document.getElementById('productsGrid');
const productSearch = document.getElementById('productSearch');
const mobileProductSearch = document.getElementById('mobileProductSearch');
const categoryLinks = document.querySelectorAll('.category-list a');

// Create and append overlay
const overlay = document.createElement('div');
overlay.className = 'sidebar-overlay';
document.body.appendChild(overlay);
  
// Toggle sidebar
sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    sidebarToggle.classList.toggle('active');
    overlay.classList.toggle('active');
});

// Close sidebar when clicking overlay
overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    sidebarToggle.classList.remove('active');
    overlay.classList.remove('active');
});

// Sync both search inputs
function syncSearchInputs(value) {
    productSearch.value = value;
    mobileProductSearch.value = value;
    const searchTerm = value.toLowerCase();
    const filteredProducts = productsData.products.filter(product => {
        const title = product.title.toLowerCase();
        const description = product.description.toLowerCase();
        return title.includes(searchTerm) || description.includes(searchTerm);
    });
    
    currentPage = 1;
    renderProducts(filteredProducts);
}

productSearch.addEventListener('input', (e) => syncSearchInputs(e.target.value));
mobileProductSearch.addEventListener('input', (e) => syncSearchInputs(e.target.value));

// Category filtering
categoryLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const category = e.target.dataset.category;
        
        // Update active state
        categoryLinks.forEach(l => l.classList.remove('active'));
        e.target.classList.add('active');
        
        // Show loading state
        document.getElementById('loadingState').style.display = 'flex';
        productsGrid.style.display = 'none';
        
        setTimeout(() => {
            filterProductsByCategory(category);
            
            // Hide loading, show results or empty state
            document.getElementById('loadingState').style.display = 'none';
            const filteredProducts = category === 'all' 
                ? productsData.products 
                : productsData.products.filter(product => product.category === category);
            
            if (filteredProducts.length === 0) {
                document.getElementById('emptyState').style.display = 'flex';
                productsGrid.style.display = 'none';
            } else {
                document.getElementById('emptyState').style.display = 'none';
                productsGrid.style.display = 'grid';
            }
        }, 500);
    });
});

function handleCategoryChange(e) {
    const allCategoriesCheckbox = document.getElementById('allCategories');
    const categoryCheckboxes = document.querySelectorAll('input[name="category"]');
    
    if (e.target.id === 'allCategories') {
        // If "All Categories" is checked, uncheck other categories
        if (e.target.checked) {
            categoryCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    } else {
        // If any individual category is checked, uncheck "All Categories"
        allCategoriesCheckbox.checked = false;
    }
    
    filterProducts();
}

function filterProducts() {
    const allCategoriesChecked = document.getElementById('allCategories').checked;
    const selectedCategories = Array.from(document.querySelectorAll('input[name="category"]:checked'))
        .map(checkbox => checkbox.dataset.category);
    
    const searchTerm = document.getElementById('productSearch').value.toLowerCase();
    const minPrice = parseFloat(document.querySelector('.min-price').value) || 0;
    const maxPrice = parseFloat(document.querySelector('.max-price').value) || Infinity;
    const sortBy = document.querySelector('.sort-select').value;
    
    // Filter products based on all criteria
    let filteredProducts = productsData.products.filter(product => {
        const matchesCategory = allCategoriesChecked || selectedCategories.includes(product.category_id);
        const matchesSearch = product.product_name.toLowerCase().includes(searchTerm) || 
                            product.product_description.toLowerCase().includes(searchTerm);
        const matchesPrice = product.product_cost >= minPrice && product.product_cost <= maxPrice;
        
        return matchesCategory && matchesSearch && matchesPrice;
    });

    // Sort products based on selected criteria
    filteredProducts = sortProducts(filteredProducts, sortBy);
    
    // Update display
    currentPage = 1;
    renderProducts(filteredProducts);
    
    // Update product counts in UI
    updateProductCounts(filteredProducts);
}

// Add this new function to handle sorting
function sortProducts(products, sortBy) {
    switch (sortBy) {
        case 'price-low':
            return [...products].sort((a, b) => a.product_cost - b.product_cost);
        case 'price-high':
            return [...products].sort((a, b) => b.product_cost - a.product_cost);
        case 'newest':
            return [...products].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        case 'featured':
            return [...products].sort((a, b) => {
                if (a.featured && !b.featured) return -1;
                if (!a.featured && b.featured) return 1;
                return 0;
            });
        default:
            return products;
    }
}

// Add this new function to update product counts
function updateProductCounts(filteredProducts) {
    const categoryCounts = {};
    
    // Count products in filtered results
    filteredProducts.forEach(product => {
        categoryCounts[product.category_id] = (categoryCounts[product.category_id] || 0) + 1;
    });
    
    // Update category counts in UI
    document.querySelectorAll('.category-checkbox').forEach(checkbox => {
        const categoryId = checkbox.querySelector('input').dataset.category;
        if (categoryId) {
            const count = categoryCounts[categoryId] || 0;
            const countSpan = checkbox.querySelector('.product-count');
            if (countSpan) {
                countSpan.textContent = `(${count})`;
            }
        }
    });
    
    // Update "All Categories" count
    const totalCount = filteredProducts.length;
    const allCategoriesCount = document.querySelector('.main-category .product-count');
    if (allCategoriesCount) {
        allCategoriesCount.textContent = `(${totalCount})`;
    }
}

// Update the DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    initializeProducts();
    
    // Category checkbox listeners
    document.getElementById('allCategories').addEventListener('change', handleCategoryChange);
    document.querySelectorAll('input[name="category"]').forEach(checkbox => {
        checkbox.addEventListener('change', handleCategoryChange);
    });
    
    // Existing search and price filter listeners...
    const productSearch = document.getElementById('productSearch');
    const mobileProductSearch = document.getElementById('mobileProductSearch');
    
    productSearch.addEventListener('input', filterProducts);
    mobileProductSearch.addEventListener('input', (e) => {
        productSearch.value = e.target.value;
        filterProducts();
    });
    
    // Price range listeners
    const minPriceInput = document.querySelector('.min-price');
    const maxPriceInput = document.querySelector('.max-price');
    const priceSlider = document.querySelector('.price-slider');
    
    minPriceInput.addEventListener('change', filterProducts);
    maxPriceInput.addEventListener('change', filterProducts);
    priceSlider.addEventListener('input', (e) => {
        maxPriceInput.value = e.target.value;
        filterProducts();
    });

    // Add sort select listener
    document.querySelector('.sort-select').addEventListener('change', filterProducts);
});
</script>

<style>
.product-container {
  display: flex;
  gap: 2rem;
  max-width: 1400px;
  margin: 0 auto;
  padding: 2rem;
}

.main-content {
  flex: 1;
}

.products-grid {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  margin-bottom: 2rem;
}

/* Product Row */
.product-row {
  display: flex;
  gap: 2rem;
  width: 100%;
}

.product-card {
  flex: 1;
  width: calc(50% - 1rem); /* Exactly half width minus half the gap */
  display: flex;
  flex-direction: column;
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.product-image {
  position: relative;
  width: 100%;
  padding-top: 66.67%; /* 3:2 Aspect Ratio */
  overflow: hidden;
}

.product-image img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.featured-badge {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #ffd700;
  color: #000;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 0.8rem;
  font-weight: bold;
}

.product-info {
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.product-info h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.2rem;
  color: #333;
}

.product-info p {
  margin: 0 0 1rem 0;
  color: #666;
  font-size: 0.9rem;
  flex-grow: 1;
}

.product-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: auto;
}

.price {
  font-size: 1.2rem;
  font-weight: bold;
  color: #2c5282;
}

.btn-primary {
  background: #2c5282;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-primary:hover {
  background: #2a4365;
}

.loading-state, .empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 300px;
  width: 100%;
}

/* Mobile Responsive */
@media (max-width: 768px) {
  .product-container {
    flex-direction: column;
  }
  
  .product-row {
    flex-direction: column;
    gap: 1rem;
  }

  .product-card {
    width: 100%;
  }
  
  .sidebar {
    position: fixed;
    left: -300px;
    top: 0;
    height: 100vh;
    z-index: 1000;
    transition: left 0.3s ease;
  }
  
  .sidebar.active {
    left: 0;
  }
  
  .sidebar-toggle {
    display: block;
    position: fixed;
    left: 1rem;
    top: 1rem;
    z-index: 1001;
  }

  .pagination {
    flex-wrap: wrap;
  }
}

/* Add pagination styles */
.pagination {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 2rem;
  padding: 1rem;
}

.pagination-btn {
  padding: 0.5rem 1rem;
  border: 1px solid #2c5282;
  background: white;
  color: #2c5282;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.2s;
}

.pagination-btn:hover:not(:disabled) {
  background: #2c5282;
  color: white;
}

.pagination-btn.active {
  background: #2c5282;
  color: white;
}

.pagination-btn:disabled {
  border-color: #ccc;
  color: #ccc;
  cursor: not-allowed;
}

/* Update category list styles */
.category-section h3,
.filter-section h3,
.filter-group h4 {
  color: #fff;
  margin-bottom: 1rem;
}

.category-list a {
  color: #e0e0e0;
  text-decoration: none;
  display: block;
  padding: 0.5rem 0;
  transition: color 0.2s;
}

.category-list a:hover {
  color: #fff;
}

.category-list a.active {
  color: #fff;
  font-weight: bold;
  position: relative;
}

.category-list a.active::before {
  content: '';
  position: absolute;
  left: -1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 4px;
  height: 4px;
  background: #fff;
  border-radius: 50%;
}

/* Update search box styles */
.search-box {
  background: #2d2d2d;
  border-radius: 4px;
  padding: 0.5rem;
  margin-bottom: 1.5rem;
}

.search-box input {
  background: transparent;
  border: none;
  color: #fff;
  width: 100%;
  padding: 0.5rem;
}

.search-box input::placeholder {
  color: #888;
}

.search-box button {
  background: transparent;
  border: none;
  color: #888;
  cursor: pointer;
}

.search-box button:hover {
  color: #fff;
}

/* Update filter styles */
.filter-group {
  background: #2d2d2d;
  padding: 1rem;
  border-radius: 4px;
  margin-bottom: 1rem;
}

.sort-select {
  width: 100%;
  padding: 0.5rem;
  background: #1a1a1a;
  border: 1px solid #444;
  color: #fff;
  border-radius: 4px;
}

.sort-select option {
  background: #1a1a1a;
  color: #fff;
}

/* Update price range slider */
.price-range input[type="range"] {
  width: 100%;
  background: #444;
}

.price-inputs {
  display: flex;
  gap: 1rem;
  margin-top: 0.5rem;
}

.price-inputs input {
  width: 50%;
  padding: 0.5rem;
  background: #1a1a1a;
  border: 1px solid #444;
  color: #fff;
  border-radius: 4px;
}

/* Sidebar styles */
.sidebar {
  width: 300px;
  background: #000000;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  color: #fff;
}

/* Update mobile sidebar styles */
@media (max-width: 768px) {
  .sidebar {
    background: #000000;
    z-index: 1000;
  }
  
  .sidebar.active {
    box-shadow: 2px 0 8px rgba(0,0,0,0.5);
  }
}

/* Add/Update these styles */
.sidebar-toggle {
  display: none; /* Hidden by default on desktop */
  cursor: pointer;
  padding: 10px;
}

.hamburger {
  width: 30px;
  height: 20px;
  position: relative;
}

.hamburger span {
  display: block;
  position: absolute;
  height: 2px;
  width: 100%;
  background: #fff;
  border-radius: 2px;
  transition: all 0.3s ease;
}

.hamburger span:first-child {
  top: 0;
}

.hamburger span:nth-child(2) {
  top: 9px;
}

.hamburger span:last-child {
  top: 18px;
}

/* Hamburger animation */
.sidebar-toggle.active .hamburger span:first-child {
  transform: rotate(45deg);
  top: 9px;
}

.sidebar-toggle.active .hamburger span:nth-child(2) {
  opacity: 0;
}

.sidebar-toggle.active .hamburger span:last-child {
  transform: rotate(-45deg);
  top: 9px;
}

.mobile-search {
  display: none; /* Hidden by default on desktop */
  width: 100%;
  padding: 1rem;
  background: #1a1a1a;
  position: sticky;
  top: 0;
  z-index: 99;
}

/* Mobile styles */
@media (max-width: 768px) {
  .product-container {
    flex-direction: column;
    padding-top: 0;
  }

  .sidebar-toggle {
    display: block;
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1001;
    background: #1a1a1a;
    border-radius: 4px;
  }

  .mobile-search {
    display: block;
    margin-bottom: 1rem;
  }

  /* Hide desktop search in sidebar */
  .sidebar .search-section {
    display: none;
  }

  .sidebar {
    position: fixed;
    left: -300px;
    top: 0;
    height: 100vh;
    z-index: 1000;
    transition: left 0.3s ease;
    margin: 0;
  }

  .sidebar.active {
    left: 0;
    box-shadow: 2px 0 8px rgba(0,0,0,0.5);
  }

  .main-content {
    margin-top: 60px; /* Space for fixed mobile search */
  }

  /* Overlay when sidebar is open */
  .sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
  }

  .sidebar-overlay.active {
    display: block;
  }
}

/* Add/Update these styles */
.mobile-header {
  display: none;
  position: sticky;
  top: 0;
  width: 100%;
  background: #000000;
  padding: 1rem;
  z-index: 99;
}

.mobile-search {
  flex: 1;
  margin-right: 1rem;
}

.mobile-search .search-box {
  margin-bottom: 0;
}

.sidebar-toggle {
  display: none;
  cursor: pointer;
  background: #1a1a1a;
  border-radius: 4px;
  height: fit-content;
}

/* Mobile styles */
@media (max-width: 768px) {
  .product-container {
    flex-direction: column;
    padding: 0; /* Remove padding from container */
  }

  .mobile-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    width: 100vw; /* Full viewport width */
    margin-left: calc(-50vw + 50%); /* Center align the header */
    margin-right: calc(-50vw + 50%);
    padding: 1rem 2rem; /* Add horizontal padding */
    box-sizing: border-box;
    background: #000; /* Darker background to match sidebar */
  }

  .mobile-search {
    flex: 0 1 80%; /* Allow search to shrink but take 80% of space */
    margin: 0;
    padding: 0;
  }

  .sidebar-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    padding: 8px;
    margin: 0;
    position: static; /* Remove fixed positioning */
    background: #2d2d2d; /* Slightly lighter than header for contrast */
    border-radius: 4px;
  }

  /* Make hamburger icon more visible */
  .hamburger span {
    background: #fff; /* Ensure white color for visibility */
    height: 2px;
    width: 100%;
  }

  .main-content {
    padding: 1rem 2rem; /* Add padding to main content */
  }
}

/* Add to your existing styles */
.category-checkboxes {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.category-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #e0e0e0;
    cursor: pointer;
    transition: color 0.2s;
}

.category-checkbox:hover {
    color: #fff;
}

.category-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #2c5282;
    cursor: pointer;
}

/* Update price range styles */
.price-range {
    margin-top: 1rem;
}

.price-inputs {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.price-inputs input {
    width: calc(50% - 0.25rem);
    padding: 0.5rem;
    background: #2d2d2d;
    border: 1px solid #444;
    color: #fff;
    border-radius: 4px;
}

.price-slider {
    width: 100%;
    margin: 1rem 0;
    accent-color: #2c5282;
}

/* Add to your existing styles */
.subcategories {
    margin-left: 1.5rem;
    padding-top: 0.5rem;
}

.category-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #e0e0e0;
    cursor: pointer;
    transition: color 0.2s;
    margin-bottom: 0.5rem;
}

#allCategories {
    width: 18px;
    height: 18px;
    accent-color: #2c5282;
}

.category-checkbox:hover {
    color: #fff;
}

/* Add/Update these styles */
.category-section {
    margin-bottom: 2rem;
}

.category-checkboxes {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.category-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #e0e0e0;
    cursor: pointer;
    transition: color 0.2s;
}

.category-checkbox:hover {
    color: #fff;
}

.category-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #2c5282;
    cursor: pointer;
}

.main-category {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.category-divider {
    height: 1px;
    background: #444;
    margin: 0.5rem 0;
}
</style>

<?php require "./components/bottom.php";?>