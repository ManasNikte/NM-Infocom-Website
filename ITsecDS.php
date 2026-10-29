<?php require "./components/top.php"; ?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Data Services</h1>
      <p></p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="Service.php">Services</a><li>
          <li><a href="ITsec.php">IT Security</a><li>
          <li class="current">Data Services</li>
        </ol>
      </nav>
    </div>
  </div><!--/Hero section -->

  <section id="services" class="services section">

    <!-- Section Title -->
    <section class="services section light-background">
      <div class="container">
        <!-- Main Flexbox -->
        <div class="d-flex flex-column">

          <!-- Upper Flexbox: Image and Description -->
          <div class="d-flex justify-content-between align-items-center mb-5">

            <!-- Left Div: Image -->
            <div class="left-image col-lg-6 col-md-12">
              <img src="./assets/img/ITSEC/data-cover.jpg" alt="Cloud Services Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Comprehensive Data Services</h2>
              <p>Our data services provide reliable, secure, and scalable solutions to manage and optimize your data infrastructure. We help businesses streamline data storage, backup, and management for maximum efficiency and security.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- File Integrity Monitors (FIM) -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ds1.jpg" alt="File Integrity Monitors (FIM)" class="img-fluid rounded mb-3">
                <h4>File Integrity Monitors (FIM)</h4>
                <p>Detect changes to files and differentiate high-risk from low-risk changes to ensure secure and compliant environments.</p>
                <ul>
                  <li>Real-time Monitoring</li>
                  <li>Change Detection & Reporting</li>
                  <li>Risk Assessment</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End File Integrity Monitors (FIM) -->

            <!-- Data Loss Prevention (DLP) -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ds2.jpg" alt="Data Loss Prevention (DLP)" class="img-fluid rounded mb-3">
                <h4>Data Loss Prevention (DLP)</h4>
                <p>Ensure confidential data stays within the organization and is not leaked via unauthorized channels.</p>
                <ul>
                  <li>Email, Web & Endpoint Security</li>
                  <li>Real-time Data Leakage Monitoring</li>
                  <li>Comprehensive Data Loss Prevention</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Data Loss Prevention (DLP) -->

            <!-- Document Rights Management (DRM) -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ds3.jpg" alt="Document Rights Management (DRM)" class="img-fluid rounded mb-3">
                <h4>Document Rights Management (DRM)</h4>
                <p>Control who can access, modify, or share your documents, even after they leave your organization.</p>
                <ul>
                  <li>Control Document Access & Modification</li>
                  <li>Revoke Document Access</li>
                  <li>Limit Access to Specific IPs or Organizations</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Document Rights Management (DRM) -->

            <!-- Privileged Identity & Access Management (PIM/PAM) -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ds4.webp" alt="Privileged Identity & Access Management (PIM/PAM)" class="img-fluid rounded mb-3">
                <h4>Privileged Identity & Access Management (PIM/PAM)</h4>
                <p>Manage and monitor privileged access to critical systems, ensuring security for high-risk administrative users.</p>
                <ul>
                  <li>Centralized Password Vault</li>
                  <li>Action Logging for Admin Users</li>
                  <li>Control Access & Block Malicious Activity</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Privileged Identity & Access Management (PIM/PAM) -->

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

      .service-card a.stretched-link {
        margin-top: auto;
        padding-top: 15px;
      }
    </style>

  </main>
<?php require "./components/bottom.php"; ?>
