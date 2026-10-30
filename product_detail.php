<?php
require_once __DIR__ . '/config/format.php';
require "./data/product_data.php";

// Get product ID from URL parameter
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

// Find the product
$product = null;
if ($product_id) {
    foreach ($productsData as $p) {
        if ($p['product_id'] == $product_id) {
            $product = $p;
            break;
        }
    }
}

// Redirect if product not found (before any page markup is sent)
if (!$product) {
    header('Location: products.php');
    exit;
}
require "./components/top.php";
?>

<!-- Hero section -->
<div class="page-title dark-background">
    <div class="container position-relative">
        <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.php#hero">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li class="current"><?php echo htmlspecialchars($product['product_name']); ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Product Detail Container -->
<div class="product-detail-container">
    <!-- First Row -->
    <div class="product-row top-row">
        <!-- Left Column - Image -->
        <div class="product-col image-col">
            <div class="product-image-container">
                <img src="<?php echo htmlspecialchars($product['cover_image'] ?: ($product['image'] && !str_contains($product['image'], 'placehold.co') ? $product['image'] : 'assets/img/services.jpg')); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>
        </div>
        
        <!-- Right Column - Title and Catalogue -->
        <div class="product-col info-col">
            <h2 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h2>
            <div class="product-description">
                <h3 style="text-align: start;">Description</h3>
                <p  style="text-align: start;"><?php echo nl2br(htmlspecialchars($product['product_description'])); ?></p>
            </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="product-row bottom-row">
        <!-- Left Column - Description -->
        <div class="product-col description-col">
            <div class="product-description text-center">
                <h3>Catalogue</h3>
                <div class="catalogue-section">
                    <?php if (!empty($product['catalogue_pdf'])): ?>
                        <a href="data/download_catalogue.php?id=<?php echo (int) $product['product_id']; ?>" download class="catalogue-pdf-link">
                            <div class="pdf-icon-container">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                <span class="pdf-text">Download Product Catalogue</span>
                            </div>
                        </a>
                    <?php else: ?>
                        <p class="text-secondary mb-0">A catalogue for this product isn't online yet. Send an enquiry below and we'll email it to you.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column - Price and Enquiry -->
        <div class="product-col price-col">
            <div class="price-container">
                <p class="product-price"><?php echo nm_inr_amount($product['product_cost']); ?></p>
                <button class="enquiry-btn" id="enquiryBtn">
                    <i class="bi bi-cart"></i>
                    Make Enquiry
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Related Products Section -->
<section class="related-products section bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-4">Related Products</h2>
        
        <div id="relatedProductsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $relatedProducts = getRelatedProducts($product['product_id'], $product['category_id'], 6); // Get 6 products
                $chunks = array_chunk($relatedProducts, 3); // Split into groups of 3
                
                foreach ($chunks as $index => $productGroup):
                ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="row g-4">
                            <?php foreach ($productGroup as $relatedProduct): ?>
                                <div class="col-md-4">
                                    <div class="card h-100 product-card">
                                        <img src="<?php echo htmlspecialchars($relatedProduct['cover_image'] ?: ($relatedProduct['image'] && !str_contains($relatedProduct['image'], 'placehold.co') ? $relatedProduct['image'] : 'assets/img/services.jpg')); ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo htmlspecialchars($relatedProduct['product_name']); ?>">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title"><?php echo htmlspecialchars($relatedProduct['product_name']); ?></h5>
                                            <p class="card-text flex-grow-1"><?php echo htmlspecialchars(substr($relatedProduct['product_description'], 0, 100)) . '...'; ?></p>
                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="product-price"><?php echo nm_inr_amount($relatedProduct['product_cost']); ?></span>
                                                    <a href="product_detail.php?id=<?php echo htmlspecialchars((string) $relatedProduct['product_id']); ?>" 
                                                       class="btn btn-outline-primary">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Carousel Controls -->
            <?php if (count($chunks) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#relatedProductsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#relatedProductsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Enquiry Form Modal -->
<div class="enquiry-modal" id="enquiryModal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Product Enquiry</h2>
        <form id="enquiryForm" action="data/enquiry_sumbission.php" method="POST">
            <div class="nm-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
            <!-- Product Details Section -->
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" 
                       value="<?php echo htmlspecialchars($product['product_name']); ?>" 
                       readonly>
            </div>

            <input type="hidden" name="product_id" 
                   value="<?php echo htmlspecialchars($product['product_id']); ?>">
            
            <input type="hidden" id="unit_price" 
                   value="<?php echo htmlspecialchars($product['product_cost']); ?>">

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" 
                       min="1" value="1" required>
            </div>

            <div class="form-group">
                <label for="total_price">Total Approximate Price</label>
                <input type="text" id="total_price" name="total_price" 
                       value="<?php echo nm_inr_amount($product['product_cost']); ?>" 
                       readonly>
            </div>

            <!-- Customer Details Section -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Contact Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <button type="submit" class="submit-btn">Submit Enquiry</button>
        </form>
    </div>
</div>

<style>
.product-detail-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 2rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.product-row {
    display: flex;
    gap: 2rem;
}

.product-col {
    flex: 1;
}

/* Top Row Styles */
.top-row {
    min-height: 400px;
}

.image-col {
    flex: 1;
}

.info-col {
    flex: 1;
}

.product-image-container {
    width: 100%;
    height: 100%;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.product-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.product-title {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: #2c5282;
}

/* Bottom Row Styles */
.bottom-row {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.description-col {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
}

.product-description {
    width: 100%;
    text-align: center;
}

.price-col {
    padding: 2rem;
    background: #f8f9fa;
    border-left: 1px solid #eee;
}

.price-container {
    position: sticky;
    top: 2rem;
}

.product-price {
    font-size: 2rem;
    font-weight: bold;
    color: #2c5282;
    margin-bottom: 1.5rem;
}

.enquiry-btn {
    width: 100%;
    background: #2c5282;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: background 0.2s;
}

.enquiry-btn:hover {
    background: #2a4365;
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-row {
        flex-direction: column;
    }

    .product-col {
        width: 100%;
    }

    .image-col {
        height: 300px;
    }

    .price-container {
        position: relative;
        top: 0;
    }
}

/* Modal Styles */
.enquiry-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    overflow-y: auto;
}

.modal-content {
    position: relative;
    background: #fff;
    width: 90%;
    max-width: 500px;
    margin: 50px auto;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.close-modal {
    position: absolute;
    right: 1rem;
    top: 1rem;
    font-size: 1.5rem;
    cursor: pointer;
    color: #666;
    transition: color 0.2s;
}

.close-modal:hover {
    color: #333;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #333;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border-color 0.2s;
}

.form-group input:focus {
    border-color: #2c5282;
    outline: none;
}

/* Form alerts */
.alert-message {
    padding: 12px 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    font-size: 14px;
    transition: opacity 0.3s ease-in-out;
}

.alert-message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-message.info {
    background-color: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

/* Error state for form inputs */
.form-group input.error {
    border-color: #dc3545 !important;
    background-color: #fff8f8;
}

/* Loading state for submit button */
button[type="submit"]:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.submit-btn {
    width: 100%;
    padding: 1rem;
    background: #2c5282;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.2s;
    margin-top: 1rem;
}

.submit-btn:hover {
    background: #2a4365;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-content {
        width: 95%;
        margin: 20px auto;
        padding: 1.5rem;
    }
}

.catalogue-item {
    border-bottom: none !important;
}

.pdf-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #2c5282;
    text-decoration: none;
    padding: 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.pdf-link:hover {
    background: rgba(44, 82, 130, 0.1);
    transform: translateX(2px);
}

.pdf-link i {
    font-size: 1.25rem;
    color: #dc2626;
}

.pdf-link span {
    font-weight: 500;
}

/* Add these new styles */
.catalogue-section {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
}

.catalogue-pdf-link {
    display: inline-block;
    text-decoration: none;
    margin-bottom: 1.5rem;
}

.pdf-icon-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 2rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.pdf-icon-container:hover {
    background: #fff;
    border-color: #2c5282;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.pdf-icon-container i {
    font-size: 2rem;
    color: #dc2626;
}

.pdf-text {
    font-size: 1.1rem;
    font-weight: 500;
    color: #2c5282;
}

.catalogue-description {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .pdf-icon-container {
        padding: 0.75rem;
    }

    .pdf-icon-container i {
        font-size: 1.5rem;
    }

    .pdf-text {
        font-size: 1rem;
    }
}

/* Add styles for readonly input */
input[readonly] {
    background-color: #f8f9fa;
    color: #495057;
    cursor: not-allowed;
}

/* Add styles for number input */
input[type="number"] {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border-color 0.2s;
}

input[type="number"]:focus {
    border-color: #2c5282;
    outline: none;
}

/* Optional: Add arrows styling for number input */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    opacity: 1;
    height: 24px;
}

/* Total price styling */
#total_price {
    font-weight: bold;
    color: #2c5282;
    background-color: #f8f9fa;
}

/* Related Products Styles */
.related-products {
    padding: 4rem 0;
    margin-top: 2rem;
}

.section-title {
    color: #2c5282;
    margin-bottom: 2rem;
    font-size: 2rem;
    font-weight: 600;
}

.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.product-card .card-img-top {
    height: 200px;
    object-fit: cover;
}

.product-card .card-title {
    color: #2c5282;
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.product-card .card-text {
    color: #4a5568;
    font-size: 0.9rem;
    line-height: 1.5;
}

.product-price {
    color: #2c5282;
    font-weight: 600;
    font-size: 1.1rem;
}

.btn-outline-primary {
    color: #2c5282;
    border-color: #2c5282;
}

.btn-outline-primary:hover {
    background-color: #2c5282;
    color: white;
}

/* Carousel Specific Styles */
#relatedProductsCarousel {
    position: relative;
    padding: 0 50px;
}

#relatedProductsCarousel .carousel-control-prev,
#relatedProductsCarousel .carousel-control-next {
    width: 40px;
    height: 40px;
    background: #2c5282;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.8;
}

#relatedProductsCarousel .carousel-control-prev {
    left: 0;
}

#relatedProductsCarousel .carousel-control-next {
    right: 0;
}

#relatedProductsCarousel .carousel-control-prev:hover,
#relatedProductsCarousel .carousel-control-next:hover {
    opacity: 1;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 20px;
    height: 20px;
}

@media (max-width: 768px) {
    .related-products {
        padding: 2rem 0;
    }
    
    .product-card .card-img-top {
        height: 180px;
    }
    
    #relatedProductsCarousel {
        padding: 0 30px;
    }
}
</style>

<script>
// Modal functionality
const modal = document.getElementById('enquiryModal');
const btn = document.getElementById('enquiryBtn');
const span = document.getElementsByClassName('close-modal')[0];

// Open modal
btn.onclick = function() {
    modal.style.display = "block";
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

// Close modal when clicking (X)
span.onclick = function() {
    modal.style.display = "none";
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.body.style.overflow = 'auto'; // Restore scrolling
    }
}

// Form validation and submission
document.getElementById('enquiryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.textContent;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';
    
    // Basic form validation
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    
    if (!name || !email || !phone) {
        showAlert('Please fill in all fields', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showAlert('Please enter a valid email address', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
        return;
    }
    
    // Phone validation (basic)
    const phoneRegex = /^[0-9+\-\(\)\s]{10,20}$/;
    if (!phoneRegex.test(phone)) {
        showAlert('Please enter a valid phone number', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
        return;
    }
    
    // Collect form data
    const formData = new FormData(form);
    
    // Submit form via AJAX
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            form.reset();
            // Close modal after 2 seconds
            setTimeout(() => {
                modal.style.display = "none";
                document.body.style.overflow = 'auto';
            }, 2000);
        } else {
            showAlert(data.message || 'An error occurred. Please try again.', 'error');
            // Highlight fields with errors if any
            if (data.errors && data.errors.length > 0) {
                data.errors.forEach(field => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('error');
                        input.focus();
                    }
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred while submitting the form. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
    });
});

// Function to show alert messages
function showAlert(message, type = 'info') {
    // Remove any existing alerts
    const existingAlert = document.querySelector('.alert-message');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert-message ${type}`;
    alertDiv.textContent = message;
    
    // Add alert to the form
    const form = document.getElementById('enquiryForm');
    form.insertBefore(alertDiv, form.firstChild);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alertDiv.style.opacity = '0';
        setTimeout(() => alertDiv.remove(), 300);
    }, 5000);
}

// Clear error class on input focus
document.querySelectorAll('#enquiryForm input').forEach(input => {
    input.addEventListener('focus', function() {
        this.classList.remove('error');
    });
});

// Add total price calculation
document.getElementById('quantity').addEventListener('input', function() {
    const quantity = parseInt(this.value) || 0;
    const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
    const totalPrice = quantity * unitPrice;
    
    document.getElementById('total_price').value = totalPrice.toLocaleString('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 2 });
});

// Ensure minimum quantity is 1
document.getElementById('quantity').addEventListener('change', function() {
    if (this.value < 1) {
        this.value = 1;
        // Trigger input event to update total price
        this.dispatchEvent(new Event('input'));
    }
});
</script>

<?php require "./components/bottom.php"; ?>
