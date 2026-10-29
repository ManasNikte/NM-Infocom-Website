<?php require"./components/top.php"; ?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Data Centres & Cloud Solutions</h1>
      <p>Explore our innovative solutions for Data Centres, Cloud Infrastructure, and IT Management</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="ITInfra.php">IT Infrastructure</a></li>
          <li class="current">Data Centres & Cloud Solutions</li>
        </ol>
      </nav>
    </div>
  </div><!--/Hero section -->

  <section id="it-infrastructure" class="services section">

    <!-- Section Title -->
    <section id="data-centres-cloud" class="services section light-background">
      <div class="container">
        <!-- Main Flexbox -->
        <div class="d-flex flex-column">

          <!-- Upper Flexbox: Image and Description -->
          <div class="d-flex justify-content-between align-items-center mb-5">
            
            <!-- Left Div: Image -->
            <div class="left-image col-lg-6 col-md-12">
              <img src="./assets/img/ITInfra/dc-maim-cover.jpg" alt="Data Centres and Cloud Solutions" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Our Data Centres & Cloud Solutions</h2>
              <p>Explore our state-of-the-art data centre and cloud solutions, designed to improve performance, scalability, and efficiency. We offer a range of services, from hyper-converged infrastructure to disaster recovery, ensuring your business stays agile and secure.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Product and Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Converged & Hyperconverged Infrastructure -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative h-100">
                <img src="./assets/img/ITInfra/dc1.jpg" alt="Hyperconverged Infrastructure" class="img-fluid rounded mb-3">
                <h4>Converged & Hyperconverged Infrastructure</h4>
                <p>Leverage flexible, software-driven infrastructure solutions that streamline operations and improve IT efficiency. Fast deployment with reduced complexity.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>

            <!-- Turnkey Infrastructure -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative h-100">
                <img src="./assets/img/ITInfra/dc2.jpg" alt="Turnkey Infrastructure" class="img-fluid rounded mb-3">
                <h4>Turnkey Infrastructure</h4>
                <p>Complete, integrated infrastructure solutions designed for simplicity, scalability, and high performance. Ready-to-deploy and secure systems for your business.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>

            <!-- Virtualization -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative h-100">
                <img src="./assets/img/ITInfra/dc3.jpg" alt="Virtualization" class="img-fluid rounded mb-3">
                <h4>Virtualization</h4>
                <p>Maximize your IT resources by running multiple operating systems and applications on a single device. Increase performance, efficiency, and agility.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>

            <!-- Servers & Storage -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-card position-relative h-100">
                <img src="./assets/img/ITInfra/dc4.jpg" alt="Servers and Storage" class="img-fluid rounded mb-3">
                <h4>Servers & Storage</h4>
                <p>Utilize high-performance servers and storage solutions that offer flexibility, scalability, and improved cost-efficiency for growing businesses.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>

          </div><!-- End Upper Service Cards -->

          <!-- Lower Flexbox: Product and Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Data Protection & Backup -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/dc5.jpg" alt="Data Protection and Backup" class="img-fluid rounded mb-3">
                <h4>Data Protection & Backup</h4>
                <p>Protect your critical data with next-gen backup solutions, ensuring continuous access and security across multi-cloud environments.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Data Protection & Backup -->

            <!-- Disaster Recovery Solutions -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/dc6.jpg" alt="Disaster Recovery" class="img-fluid rounded mb-3">
                <h4>Disaster Recovery Solutions</h4>
                <p>Minimize downtime and ensure business continuity with automated disaster recovery solutions tailored to your organization’s needs.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Disaster Recovery Solutions -->

            <!-- Managed Cloud Services -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/dc7.jpg" alt="Managed Cloud Services" class="img-fluid rounded mb-3">
                <h4>Managed Cloud Services</h4>
                <p>Build and operate robust multi-cloud environments with expert management and support. Scale your cloud infrastructure seamlessly with reliable services.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Managed Cloud Services -->

          </div><!-- End Lower Service Cards -->

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
        max-height: 160px;
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
