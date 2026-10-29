<?php require"./components/top.php";?>


<!-- Hero section for Review Form -->
<div class="page-title dark-background">
  <div class="container position-relative">
    <h1>Leave a Review</h1>
    <p>Your feedback helps us improve! Please take a moment to share your experience.</p>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.php#hero">Home</a></li>
        <li>Review</li>
        <li class="current">Leave a Review</li>
      </ol>
    </nav>
  </div>
</div><!--/Hero section for Review Form -->

<main class="main">


  <section class="review-section">
  <div class="container">
    <h2>Submit Your Review</h2>
    <form id="reviewForm" action="submit_review.php" method="POST">
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="designation">Designation</label>
        <input type="text" id="designation" name="designation" placeholder="Your role or position" required>
      </div>
      <div class="form-group">
        <label>Rating</label>
        <div class="star-rating">
          <input type="radio" id="star5" name="rating" value="5" required />
          <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
          <input type="radio" id="star4" name="rating" value="4" />
          <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
          <input type="radio" id="star3" name="rating" value="3" />
          <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
          <input type="radio" id="star2" name="rating" value="2" />
          <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
          <input type="radio" id="star1" name="rating" value="1" />
          <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
        </div>
      </div>
      <div class="form-group">
        <label for="review">Your Review (Optional)</label>
        <textarea id="review" name="review" rows="4" placeholder="Share your experience..."></textarea>
      </div>
      
      <!-- Honeypot: hidden from people; bots that fill it in are ignored. -->
      <div class="nm-hp" aria-hidden="true">
        <label for="website">Website</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
      </div>

      <button type="submit" class="submit-btn">Submit Review</button>
    </form>
  </div>
</section>

<!-- Add Font Awesome for stars -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.review-section {
  background-color: #ffffff;
  padding: 60px 0;
  color: #333;
  box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.review-section h2 {
  text-align: center;
  font-size: 2.5rem;
  margin-bottom: 40px;
  color: #2c3e50;
}

.review-section .container {
  max-width: 600px;
  margin: 0 auto;
  padding: 0 20px;
}

.review-section .form-group {
  margin-bottom: 25px;
}

.review-section label {
  font-weight: 600;
  display: block;
  margin-bottom: 8px;
  color: #2c3e50;
}

.review-section input {
  width: 100%;
  padding: 12px 15px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.review-section input:focus {
  border-color: #3498db;
  outline: none;
}

.review-section button.submit-btn {
  background-color: #3498db;
  color: white;
  padding: 15px 30px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1.1rem;
  width: 100%;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.review-section button.submit-btn:hover {
  background-color: #2980b9;
}

/* Star Rating Styles */
.star-rating {
  display: inline-flex;
  flex-direction: row-reverse;
  gap: 5px;
  width: 100%;
  justify-content: center;
}

.star-rating input {
  display: none;
}

.star-rating label {
  cursor: pointer;
  font-size: 30px;
  color: #ddd;
  transition: color 0.2s ease;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
  color: #ffd700;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .review-section h2 {
    font-size: 2rem;
  }

  .review-section .container {
    padding: 0 15px;
  }
  
  .star-rating {
    gap: 15px;
  }
  
  .star-rating label {
    font-size: 40px;
  }
}
</style>

<!-- Add form handling JavaScript -->
<script>
document.getElementById('reviewForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';

    try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        
        if (result.success) {
            alert(result.message);
            if (result.redirect) {
                window.location.href = result.redirect;
            }
        } else {
            alert(result.message || 'An error occurred. Please try again.');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit Review';
    }
});
</script>

<!-- Add this right after the existing Font Awesome link -->
<style>
/* Enhanced Review Form Styles */
.review-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.review-section .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.review-section h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 2.5rem;
    margin-bottom: 40px;
    position: relative;
}

.review-section h2:after {
    content: '';
    display: block;
    width: 80px;
    height: 4px;
    background: linear-gradient(to right, #4F46E5, #818CF8);
    margin: 20px auto 0;
    border-radius: 2px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.1rem;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #4F46E5;
    outline: none;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    background: white;
}

.form-group textarea {
    min-height: 120px;
    resize: vertical;
}

/* Enhanced Star Rating Styles */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 15px;
    margin: 20px 0;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    font-size: 35px;
    color: #ddd;
    transition: all 0.2s ease;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #FFD700;
    transform: scale(1.1);
}

.star-rating:hover label {
    text-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
}

/* Submit Button Styles */
.submit-btn {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #4F46E5, #818CF8);
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 20px;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
}

.submit-btn:active {
    transform: translateY(0);
}

/* Loading State */
.submit-btn.loading {
    background: #e0e0e0;
    cursor: not-allowed;
    opacity: 0.8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .review-section .container {
        padding: 20px;
        margin: 20px;
    }

    .review-section h2 {
        font-size: 2rem;
    }

    .star-rating label {
        font-size: 30px;
    }

    .form-group input,
    .form-group textarea {
        padding: 12px;
    }
}

/* Form Validation Styles */
.form-group input:invalid,
.form-group textarea:invalid {
    border-color: #ff4444;
}

.form-group .error-message {
    color: #ff4444;
    font-size: 0.9rem;
    margin-top: 5px;
    display: none;
}

/* Success Message Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.success-message {
    display: none;
    text-align: center;
    color: #10B981;
    padding: 20px;
    border-radius: 12px;
    background: rgba(16, 185, 129, 0.1);
    margin-bottom: 20px;
    animation: fadeIn 0.5s ease;
}

/* Field Focus Effect */
.form-group {
    position: relative;
}

.form-group label {
    transition: all 0.3s ease;
}

.form-group input:focus + label,
.form-group textarea:focus + label {
    color: #4F46E5;
}

/* Optional: Add icons to form fields */
.form-group.with-icon {
    position: relative;
}

.form-group.with-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6B7280;
}

.form-group.with-icon input {
    padding-left: 45px;
}
</style>

<!-- Add this JavaScript right before the closing </body> tag -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reviewForm');
    const submitBtn = form.querySelector('.submit-btn');
    
    // Add loading state to button
    function setLoadingState(isLoading) {
        submitBtn.classList.toggle('loading', isLoading);
        submitBtn.textContent = isLoading ? 'Submitting...' : 'Submit Review';
        submitBtn.disabled = isLoading;
    }

    // Show success message
    function showSuccess(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.textContent = message;
        form.insertBefore(successDiv, form.firstChild);
        successDiv.style.display = 'block';
    }

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        setLoadingState(true);

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            
            if (result.success) {
                showSuccess(result.message);
                form.reset();
                if (result.redirect) {
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                }
            } else {
                alert(result.message || 'An error occurred. Please try again.');
            }
        } catch (error) {
            alert('An error occurred. Please try again.');
        } finally {
            setLoadingState(false);
        }
    });

    // Real-time validation
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    inputs.forEach(input => {
        input.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.classList.add('invalid');
        });

        input.addEventListener('input', function() {
            this.classList.remove('invalid');
        });
    });
});
</script>

  </main>
<?php require"./components/bottom.php";?>