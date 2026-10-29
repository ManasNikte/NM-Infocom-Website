<?php require"./components/top.php"; ?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Digital Workplace & Transformation</h1>
      <p>Empowering the future of work with seamless remote management, secure access, and optimized user experiences.</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="ITInfra.php">IT Infrastructure</a></li>
          <li class="current">Digital Workplace & Transformation</li>
        </ol>
      </nav>
    </div>
  </div><!--/Hero section -->

  <section id="it-infrastructure" class="services section">

    <!-- Section Title -->
    <section id="digital-workplace-transformation" class="services section light-background">
      <div class="container">
        <!-- Main Flexbox -->
        <div class="d-flex flex-column">

          <!-- Upper Flexbox: Image and Description -->
          <div class="d-flex justify-content-between align-items-center mb-5">
            
            <!-- Left Div: Image -->
            <div class="left-image col-lg-6 col-md-12">
              <img src="./assets/img/ITInfra/dwt-main-cover.jpg" alt="Digital Workplace & Transformation" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Our Digital Workplace & Transformation Solutions</h2>
              <p>Discover our innovative solutions for Remote Work Management, End User Computing, and more to enhance collaboration, productivity, and security in the digital workplace.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Upper Flexbox: Product and Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Remote Work Management -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/dwt1.jpg" alt="Remote Work Management" class="img-fluid rounded mb-3">
                <h4>Remote Work Management</h4>
                <p>Enable seamless remote work with solutions for remote access, task automation, and service monitoring. Ensure that your workforce can securely access applications and IT services from anywhere, anytime.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Remote Work Management -->

            <!-- End User Computing Solutions -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/dwt2.jpg" alt="End User Computing" class="img-fluid rounded mb-3">
                <h4>End User Computing Solutions</h4>
                <p>Empower your workforce with optimized virtual desktop infrastructure (VDI) solutions, ensuring high security and seamless user experiences across devices and platforms.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End End User Computing Solutions -->

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
      }

      .service-card img {
        max-height: 200px;
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
    </style>

  </section>

</main>
<?php require"./components/bottom.php"; ?>
