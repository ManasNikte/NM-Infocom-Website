<?php 
require "./components/top.php";
require "./data/Partners_data.php";

$partnersDataObj = new PartnersData();
$partners = $partnersDataObj->getActivePartners();
$partnersPerSlide = 6; // 6 partners per slide (3x2 grid)
?>

<main class="main">
    <!-- Hero section -->
    <div class="page-title dark-background">
        <div class="container position-relative">
            <h1>Our Partners</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li class="current">Partners</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Centered Search Bar Section -->
    <section class="search-section py-4 light-background">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="search-box">
                        <input type="text" id="partnerSearch" class="form-control" placeholder="Search partners...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Updated Partners Grid Section -->
    <section class="partners-section py-5">
        <div class="container">
            <div id="partnersCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    if (!empty($partners)):
                        $totalSlides = ceil(count($partners) / $partnersPerSlide);
                        for ($i = 0; $i < $totalSlides; $i++):
                            $activeClass = ($i === 0) ? 'active' : '';
                            $slidePartners = array_slice($partners, $i * $partnersPerSlide, $partnersPerSlide);
                    ?>
                        <div class="carousel-item <?php echo $activeClass; ?>" data-bs-interval="5000">
                            <div class="row row-cols-3 justify-content-center align-items-center g-4">
                                <?php foreach ($slidePartners as $partner): ?>
                                    <div class="col partner-item" data-name="<?php echo htmlspecialchars($partner['partner_name']); ?>">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                            <?php if (!empty($partner['partner_img'])): ?>
                                                <img src="<?php echo htmlspecialchars($partner['partner_img']); ?>" 
                                                     alt="<?php echo htmlspecialchars($partner['partner_name']); ?>"
                                                     class="partner-logo"
                                                     onerror="this.replaceWith(Object.assign(document.createElement('span'), {className: 'partner-name-fallback', textContent: this.alt}))">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php 
                        endfor;
                    endif; 
                    ?>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#partnersCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#partnersCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <style>
        /* Search Box Styling */
        .search-box {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .search-box input {
            padding-right: 40px;
            border-radius: 25px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .search-box .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        /* Partner Logo Styling */
        .partner-logo {
            max-width: 80%;
            max-height: 150px;
            object-fit: contain;
        }

        /* Carousel Controls */
        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .carousel-control-prev {
            left: -50px;
        }

        .carousel-control-next {
            right: -50px;
        }

        /* Add to existing styles */
        .carousel-item {
            display: none;
        }

        .carousel-item.active {
            display: block;
        }

        /* During search */
        .searching .carousel-item {
            display: block;
            opacity: 1;
            position: relative;
        }

        #noResultsMessage {
            color: #666;
            font-style: italic;
        }
      .partner-name-fallback { font-weight: 700; font-size: 1.15rem; color: #334155; text-align: center; }
</style>

    <!-- Search functionality script remains the same -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('partnerSearch');
        const partnerItems = document.querySelectorAll('.partner-item');
        const carousel = document.getElementById('partnersCarousel');
        const carouselInstance = new bootstrap.Carousel(carousel, {
            interval: false // Pause auto sliding during search
        });

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            let hasVisiblePartners = false;

            // Show all carousel items during search
            if (searchTerm) {
                document.querySelectorAll('.carousel-item').forEach(item => {
                    item.classList.add('active');
                });
            }

            // Search through all partner items
            partnerItems.forEach(item => {
                const partnerName = item.dataset.name.toLowerCase();
                const isMatch = partnerName.includes(searchTerm);
                
                // Show/hide partners based on search
                item.style.display = isMatch ? '' : 'none';
                if (isMatch) hasVisiblePartners = true;
            });

            // Handle carousel behavior
            if (searchTerm) {
                // Disable carousel controls during search
                carousel.querySelector('.carousel-control-prev').style.display = 'none';
                carousel.querySelector('.carousel-control-next').style.display = 'none';
            } else {
                // Reset carousel when search is cleared
                document.querySelectorAll('.carousel-item').forEach((item, index) => {
                    item.classList.remove('active');
                    if (index === 0) item.classList.add('active');
                });
                
                // Show carousel controls
                carousel.querySelector('.carousel-control-prev').style.display = '';
                carousel.querySelector('.carousel-control-next').style.display = '';
                
                // Reset partner visibility
                partnerItems.forEach(item => {
                    item.style.display = '';
                });

                // Reinitialize carousel
                carouselInstance.to(0);
            }

            // Show message if no results found
            const noResultsMessage = document.getElementById('noResultsMessage') || 
                (() => {
                    const msg = document.createElement('div');
                    msg.id = 'noResultsMessage';
                    msg.className = 'text-center py-4';
                    carousel.parentNode.appendChild(msg);
                    return msg;
                })();

            noResultsMessage.innerHTML = !hasVisiblePartners && searchTerm ? 
                'No partners found matching your search.' : '';
        });
    });
    </script>
</main>

<?php require "./components/bottom.php"; ?>
    