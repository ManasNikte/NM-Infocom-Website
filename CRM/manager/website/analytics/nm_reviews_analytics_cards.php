<style>
    .analytics-card {
        background: #fff;
        color: #222;
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        transition: transform 0.16s cubic-bezier(.4,2,.6,1), box-shadow 0.16s;
        position: relative;
        overflow: hidden;
        min-width: 0;
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .analytics-card:hover {
        transform: translateY(-4px) scale(1.018);
        box-shadow: 0 10px 32px rgba(0,0,0,0.13);
    }
    .card-body {
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: 1px;
        opacity: 0.92;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        color: #333;
    }
    .card-value {
        font-size: 2.6rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: 1px;
        color: #111;
        line-height: 1.1;
    }
    .change-indicator {
        display: inline-flex;
        align-items: center;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 1.5rem;
        padding: 0.3rem 1rem;
        margin-top: 0.25rem;
        background: #f2f2f2;
        transition: background 0.2s;
        color: #222;
    }
    .change-indicator.positive {
        color: #219a52;
        background: rgba(33,154,82,0.08);
    }
    .change-indicator.negative {
        color: #d32f2f;
        background: rgba(211,47,47,0.08);
    }
    .change-indicator i {
        margin-right: 0.4rem;
        font-size: 1.2em;
    }
    .card-icon {
        font-size: 2.8rem;
        opacity: 0.13;
        position: absolute;
        right: 1.2rem;
        bottom: 1.2rem;
        pointer-events: none;
    }
    .card-footer {
        font-size: 0.97rem;
        color: #888;
        margin-top: auto;
        letter-spacing: 0.5px;
    }
    .analytics-card .fa-pen { color: #6a11cb; }
    .analytics-card .fa-book { color: #2575fc; }
    .analytics-card .fa-eye { color: #219a52; }
    .analytics-card .fa-lock { color: #d32f2f; }
    @media (max-width: 768px) {
        .analytics-card {
            margin-bottom: 1.2rem;
        }
        .card-body {
            padding: 1.2rem;
        }
        .card-value {
            font-size: 2rem;
        }
        .card-icon {
            font-size: 2rem;
        }
    }

    /* Percentage Indicators */
    .change-indicator {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        background: rgba(255, 255, 255, 0.2);
    }

    .change-indicator i {
        margin-right: 0.25rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .analytics-card {
            margin-bottom: 1rem;
        }
    }
</style>
            <!-- Analytics Cards Row -->
            <div class="row mb-4">
              <!-- Today's Reviews Card -->
              <div class="col-sm-6 col-lg-3 d-flex">
                <div class="card analytics-card w-100">
                  <div class="card-body">
                    <div class="card-title">Reviews Today</div>
                    <div class="card-value" id="reviews-today">--</div>
                    <span class="change-indicator" id="reviews-today-change">
                      <i class="fas fa-arrow-up"></i> --
                    </span>
                    <div class="card-footer">vs yesterday</div>
                    <i class="fas fa-pen card-icon"></i>
                  </div>
                </div>
              </div>
              <!-- Total Reviews Card -->
              <div class="col-sm-6 col-lg-3 d-flex">
                <div class="card analytics-card w-100">
                  <div class="card-body">
                    <div class="card-title">Total Reviews</div>
                    <div class="card-value" id="total-reviews">--</div>
                    <div class="card-footer">All Time</div>
                    <i class="fas fa-book card-icon"></i>
                  </div>
                </div>
              </div>
              <!-- Public Reviews Card -->
              <div class="col-sm-6 col-lg-3 d-flex">
                <div class="card analytics-card w-100">
                  <div class="card-body">
                    <div class="card-title">Public Reviews</div>
                    <div class="card-value" id="public-reviews">--</div>
                    <div class="card-footer">Visible to Everyone</div>
                    <i class="fas fa-eye card-icon"></i>
                  </div>
                </div>
              </div>
              <!-- Private Reviews Card -->
              <div class="col-sm-6 col-lg-3 d-flex">
                <div class="card analytics-card w-100">
                  <div class="card-body">
                    <div class="card-title">Private Reviews</div>
                    <div class="card-value" id="private-reviews">--</div>
                    <div class="card-footer">Hidden from Public</div>
                    <i class="fas fa-lock card-icon"></i>
                  </div>
                </div>
              </div>
            </div>

            <script>
            function formatNumber(num) {
                if (typeof num !== 'number') return '--';
                return num.toLocaleString();
            }
            
            function setChange(id, change) {
                const el = document.getElementById(id);
                if (!el) return;
                const up = change >= 0;
                el.innerHTML = `<i class="fas fa-arrow-${up ? 'up' : 'down'}"></i> ${Math.abs(change)}%`;
                el.classList.remove('positive', 'negative');
                el.classList.add(up ? 'positive' : 'negative');
            }
            
            function updateReviewsAnalytics() {
                console.log('Loading reviews analytics data...');
                fetch('./data/get_reviews_analytics.php')
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Analytics data received:', data);
                        if (!data.success) {
                            console.error('API returned error:', data.message);
                            document.getElementById('reviews-today').textContent = '--';
                            document.getElementById('total-reviews').textContent = '--';
                            document.getElementById('public-reviews').textContent = '--';
                            document.getElementById('private-reviews').textContent = '--';
                            setChange('reviews-today-change', 0);
                            return;
                        }
                        
                        const d = data.data;
                        console.log('Processing data:', d);
                        
                        // Update all cards with the actual data
                        document.getElementById('reviews-today').textContent = formatNumber(d.today.count);
                        setChange('reviews-today-change', d.today.percent);
                        document.getElementById('total-reviews').textContent = formatNumber(d.total);
                        document.getElementById('public-reviews').textContent = formatNumber(d.public);
                        document.getElementById('private-reviews').textContent = formatNumber(d.private);
                        
                        console.log('Analytics cards updated successfully');
                    })
                    .catch(error => {
                        console.error('Error fetching reviews analytics:', error);
                        document.getElementById('reviews-today').textContent = '--';
                        document.getElementById('total-reviews').textContent = '--';
                        document.getElementById('public-reviews').textContent = '--';
                        document.getElementById('private-reviews').textContent = '--';
                        setChange('reviews-today-change', 0);
                    });
            }
            
            // Load analytics data when page loads
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, updating reviews analytics cards...');
                updateReviewsAnalytics();
            });
            
            // Also try to load immediately if DOM is already loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', updateReviewsAnalytics);
            } else {
                updateReviewsAnalytics();
            }
            </script>