<?php require"./components/top.php";?>
  <main class="main">

    <!-- Hero section -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1>Mobility Services</h1>
        <p></p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php#hero">Home</a></li>
            <li><a href="Service.php">Services</a></li>
            <li>Mobility</li>
          </ol>
        </nav>
      </div>
    </div><!--/Hero section -->

    <section id="services" class="services section">

    <!-- Section Title -->
    <section id="services" class="services section light-background">
      <div class="container">
        <!-- Main Flexbox -->
        <div class="d-flex flex-column">
          
          <!-- Upper Flexbox: Image and Description -->
          <div class="d-flex justify-content-between align-items-center mb-5">
            
            <!-- Left Div: Image -->
            <div class="left-image col-lg-6 col-md-12">
              <img src="./assets/img/Mobility/mobility-main-cover.jpg" alt="Mobility Service Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Comprehensive Mobility Services</h2>
              <p>Our mobility services provide end-to-end solutions for managing mobile devices and services, ensuring seamless, secure, and scalable operations for businesses.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Service Cards -->
          <div class="row gy-4">

            <!-- Fulfilment Services -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/fs-main-cover.webp" alt="Fulfilment Services" class="img-fluid rounded mb-3">
                <h4>Fulfilment Services</h4>
                <p>Complete mobile device fulfilment including zero-touch deployment and training.</p>
                <ul>
                  <li>Device Fulfilment</li>
                  <li>Zero Touch Deployment</li>
                  <li>Training & Enablement</li>
                </ul>
                <a href="./mobilityFS.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Fulfilment Services -->

            <!-- Enterprise Programs -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/ep-main-cover.jpg" alt="Enterprise Programs" class="img-fluid rounded mb-3">
                <h4>Enterprise Programs</h4>
                <p>Solutions for enterprise mobility, including leasing and vendor consolidation.</p>
                <ul>
                  <li>Company Owned</li>
                  <li>Employee Purchase</li>
                  <li>Enterprise Leasing</li>
                  <li>Vendor Consolidation</li>
                </ul>
                <a href="./mobilityEP.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Enterprise Programs -->

            <!-- Enterprise Mobility Management -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/em-main-cover.webp" alt="Enterprise Mobility Management" class="img-fluid rounded mb-3">
                <h4>Enterprise Mobility Management</h4>
                <p>Manage all your enterprise mobile devices with leading mobility management solutions.</p>
                <ul>
                  <li>Jamf</li>
                  <li>Workspace ONE</li>
                  <li>ManageEngine</li>
                </ul>
                <a href="./mobilityEM.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Enterprise Mobility Management -->

          </div><!-- End First Row of Cards -->

          <!-- Second Row: Center-Aligned Cards -->
          <div class="row gy-4 justify-content-center">
            
            <!-- Products & Services -->
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/ps-main-cover.webp" alt="Products & Services" class="img-fluid rounded mb-3">
                <h4>Products & Services</h4>
                <p>Wide range of mobility products and services tailored for enterprise needs.</p>
                <ul>
                  <li>iPhone</li>
                  <li>Mac</li>
                  <li>iPad</li>
                  <li>Wearables, Home, and Accessories</li>
                  <li>AppleCare</li>
                  <li>Cloud Services</li>
                  <li>Digital Content</li>
                  <li>Jamf</li>
                </ul>
                <a href="./mobilityPS.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Products & Services -->

            <!-- Resources -->
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/resource.jpg" alt="Resources" class="img-fluid rounded mb-3">
                <h4>Resources</h4>
                <p>Access valuable resources to help you make informed decisions for your mobility needs.</p>
                <ul>
                  <li>Brochures</li>
                  <li>Case Studies</li>
                  <li>Videos</li>
                </ul>
                <a href="./mobilityR.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Resources -->

          </div><!-- End Second Row of Cards -->

        </div><!-- End Main Flexbox -->
      </div>
    </section>

    <style>
  .d-flex {
    display: flex;
  }

  .flex-column {
    flex-direction: column;
  }

  .left-image {
    max-width: 100%;
    padding: 10px;
  }

  .right-description {
    max-width: 100%;
    padding: 10px;
  }

  .service-card {
    background: #fff;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: all 0.3s ease-in-out;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .service-card img {
    max-height: 200px;
    height: 200px;
    object-fit: cover;
    width: 100%;
    border-radius: 8px;
  }

  .service-card:hover {
    background: #5c9f24; /* Hover color */
    box-shadow: 0 4px 15px rgba(248, 241, 241, 0.2);
    transform: translateY(-5px);
    color: white; /* Change text color to white on hover */
  }

  .service-card h4,
  .service-card p,
  .service-card ul li {
    transition: color 0.3s ease-in-out; /* Smooth transition */
  }

  .service-card:hover h4,
  .service-card:hover p,
  .service-card:hover ul li {
    color: white; /* Change text color to white */
  }

  .service-card a {
    display: inline-block;
    margin-top: 15px;
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
  }

  .service-card a:hover {
    text-decoration: underline;
  }

  /* AOS fade-up */
  [data-aos="fade-up"] {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
  }

  [data-aos="fade-up"].aos-animate {
    opacity: 1;
    transform: translateY(0);
  }

  /* Add margin between card rows */
  .row + .row {
    margin-top: 2rem;  /* Adds 2rem (32px) space between rows */
  }
</style>


  </main>
<?php require"./components/bottom.php";?>
