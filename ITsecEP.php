<?php require"./components/top.php";?>
  <main class="main">

    <!-- Hero section -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1>End-Point Services</h1>
        <p></p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php#hero">Home</a></li>
            <li><a href="Service.php">Services</a></li>
            <li><a href="ITsec.php">IT Security</a></li>
            <li class="current">End-Point Security</li>
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
              <img src="./assets/img/ITSEC/endpoint-cover.jpg" alt="Security Service Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Comprehensive End-Point Security Services</h2>
              <p>Our security services provide end-to-end protection for your enterprise, safeguarding data, endpoints, servers, and systems from potential threats and vulnerabilities.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Service Cards -->
          <div class="row gy-4">

            <!-- Encryption -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ep1.jpg" alt="Encryption" class="img-fluid rounded mb-3">
                <h4>Encryption</h4>
                <p>Protect critical data both at rest and in motion with enterprise-grade encryption solutions.</p>
                <ul>
                  <li>Data-at-rest & Data-in-motion</li>
                  <li>End-to-End Protection</li>
                  <li>Protect against theft or data breaches</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Encryption -->

            <!-- Endpoint Protection -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ep2.jpg" alt="Endpoint Protection" class="img-fluid rounded mb-3">
                <h4>Endpoint Protection</h4>
                <p>Protect your devices with enhanced endpoint protection solutions that guard against zero-day attacks and more.</p>
                <ul>
                  <li>Gartner Magic Quadrant Leaders</li>
                  <li>Zero-Day Attack Protection</li>
                  <li>Cloud Managed Security</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Endpoint Protection -->

            <!-- Server Security -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ep3.jpg" alt="Server Security" class="img-fluid rounded mb-3">
                <h4>Server Security</h4>
                <p>Enhance the protection of your servers with multi-layered security for critical applications and data.</p>
                <ul>
                  <li>Malware Protection</li>
                  <li>Integrity Monitoring</li>
                  <li>Host Firewall & Log Inspection</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Server Security -->

          </div><!-- End First Row of Cards -->

          <!-- Second Row: Center-Aligned Cards -->
          <div class="row gy-4 justify-content-center mt-5">
            
            <!-- Vulnerability Management -->
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ep4.webp" alt="Vulnerability Management" class="img-fluid rounded mb-3">
                <h4>Vulnerability Management</h4>
                <p>Identify, prioritize, and address vulnerabilities in your systems to protect your organization from cyber threats.</p>
                <ul>
                  <li>Scan & Identify Vulnerabilities</li>
                  <li>Prioritize Risks</li>
                  <li>Comprehensive Security Coverage</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Vulnerability Management -->

            <!-- Patch Management -->
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/ep5.webp" alt="Patch Management" class="img-fluid rounded mb-3">
                <h4>Patch Management</h4>
                <p>Ensure your systems are regularly patched to prevent vulnerabilities from being exploited.</p>
                <ul>
                  <li>Automated Patch Deployment</li>
                  <li>Real-Time Vulnerability Fixes</li>
                  <li>Support for Global Organizations</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Patch Management -->

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

  .service-card p,
  .service-card ul {
    flex-grow: 1;
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
