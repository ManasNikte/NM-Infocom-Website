<?php require"./components/top.php";?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Fulfilment Services</h1>
      <p></p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="Service.php">Services</a></li>
          <li><a href="Mobility.php">Mobility</a></li>
          <li class="current">Fulfilment Services</li>
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
              <img src="./assets/img/Mobility/fs-main-cover.webp" alt="Fulfilment Services Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Comprehensive Fulfilment Services</h2>
              <p>Our Fulfilment services help businesses streamline and optimize their device management and mobility processes, providing seamless device deployment, training, leasing, and support for enterprise mobility programs.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Device Fulfilment -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/fs1.webp" alt="Device Fulfilment" class="img-fluid rounded mb-3">
                <h4>Device Fulfilment</h4>
                <p>Our Device Fulfilment service ensures that devices are delivered, configured, and ready for deployment to employees or end-users quickly and efficiently.</p>
                <ul>
                  <li>Zero Touch Deployment</li>
                  <li>Training & Enablement</li>
                </ul>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Device Fulfilment -->

            <!-- Enterprise Programs -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/fs2.webp" alt="Enterprise Programs" class="img-fluid rounded mb-3">
                <h4>Enterprise Programs</h4>
                <p>We offer tailored solutions for large enterprises, including company-owned devices, employee purchase options, and leasing programs that streamline asset management and improve mobility.</p>
                <ul>
                  <li>Company Owned</li>
                  <li>Employee Purchase</li>
                  <li>Enterprise Leasing</li>
                  <li>Vendor Consolidation</li>
                </ul>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Enterprise Programs -->

            <!-- Enterprise Mobility Management -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/fs3.jpg" alt="Enterprise Mobility Management" class="img-fluid rounded mb-3">
                <h4>Enterprise Mobility Management</h4>
                <p>Manage your mobile fleet securely and effectively with our mobility management solutions, providing end-to-end control and support for all your business mobility needs.</p>
                <ul>
                  <li>Jamf</li>
                  <li>Workspace ONE</li>
                  <li>ManageEngine</li>
                </ul>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Enterprise Mobility Management -->

          </div><!-- End Service Cards -->

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

      .service-card h4 {
        margin-top: 1rem;
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .service-card p {
        flex-grow: 1;
        margin-bottom: 1rem;
      }

      .service-card ul {
        margin-bottom: 1rem;
        padding-left: 0;
        list-style-position: inside;
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

</main>
<?php require"./components/bottom.php";?>
