<?php require"./components/top.php";?>
  <main class="main">

    <!-- Hero section -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1>IT Security</h1>
        <p></p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php#hero">Home</a></li>
            <li><a href="Service.php">Services</a></li>
            <li><a href="ITsec.php">IT Security</a></li>
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
          <img src="./assets/img/ITSEC/ITSEC.webp" alt="Service Image" class="img-fluid rounded">
        </div>

        <!-- Right Div: Description -->
        <div class="right-description col-lg-6 col-md-12">
          <h2>Comprehensive IT Security Services</h2>
          <p>Our IT security services protect your business from the growing threats in today’s digital world. We offer robust solutions to secure your endpoints, network, cloud, and data with the latest technologies and industry best practices.</p>
        </div>
      </div><!-- End Upper Flexbox -->

      <!-- Lower Flexbox: Service Cards -->
      <div class="row gy-4">
        
        <!-- Endpoint Security -->
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-card position-relative">
            <img src="./assets/img/ITSEC/endpoint-security.jpg" alt="Endpoint Security" class="img-fluid rounded mb-3">
            <h4>Endpoint Security</h4>
            <p>The Endpoint is where the action happens and we need to secure it!</p>
            <ul>
              <li>Anti-virus software</li>
              <li>APT/EDR</li>
              <li>Server Security</li>
              <li>Encryption</li>
              <li>Vulnerability Assessment</li>
              <li>Patch Management</li>
            </ul>
            <a href="./ITsecEP.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div><!-- End Endpoint Security -->

        <!-- Network Security -->
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="service-card position-relative">
            <img src="./assets/img/ITSEC/ns1.jpg" alt="Network Security" class="img-fluid rounded mb-3">
            <h4>Network Security</h4>
            <p>Secure your Enterprise Backbone. Protect your crown jewels.</p>
            <ul>
              <li>Next Gen Firewalls</li>
              <li>Email & Web Security</li>
              <li>IPS & APT Protection</li>
              <li>WAF & NAC</li>
              <li>SIEM & SOAR</li>
            </ul>
            <a href="./ITsecNS.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div><!-- End Network Security -->

        <!-- Cloud Security -->
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-card position-relative">
            <img src="./assets/img/ITSEC/cloud.jpg" alt="Cloud Security" class="img-fluid rounded mb-3">
            <h4>Cloud Security</h4>
            <p>Control Access to your Cloud. Monitor, Manage & Fine-tune. Move to the cloud safely & securely!</p>
            <ul>
              <li>CASB (Cloud Access Security Brokers)</li>
              <li>Cloud Security Posture Management</li>
              <li>Cloud Workload Security</li>
            </ul>
            <a href="./ITsecCS.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div><!-- End Cloud Security -->

        <!-- Data Security -->
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="service-card position-relative">
            <img src="./assets/img/ITSEC/data-security.jpg" alt="Data Security" class="img-fluid rounded mb-3">
            <h4>Data Security</h4>
            <p>Data & Apps are the new oil and they need protection! Protect your crown jewels in your Network and Data Centre.</p>
            <ul>
              <li>File Integrity Solutions</li>
              <li>App Security</li>
              <li>DLP</li>
              <li>DRM</li>
              <li>PIM/PAM</li>
            </ul>
            <a href="./ITsecDS.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div><!-- End Data Security -->

      </div><!-- End Lower Flexbox -->
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

  /* Specific styles for service cards in IT Security section */
  #services .service-card {
    background: #fff;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: all 0.3s ease-in-out;
    height: 500px;
    display: flex;
    flex-direction: column;
  }

  #services .service-card img,
  #services .service-card .img-fluid.rounded.mb-3 {
    height: 200px !important;
    width: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
    border-radius: 8px !important;
    margin-bottom: 15px !important;
    aspect-ratio: 16/9 !important;
  }

  #services .service-card .img-fluid {
    max-width: 100% !important;
    height: 200px !important;
  }

  #services .service-card ul {
    flex-grow: 1;
    padding-left: 20px;
    text-align: left;
    margin-bottom: 10px;
  }

  #services .service-card a {
    margin-top: auto;
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
  }

  #services .service-card:hover {
    background: #5c9f24;
    box-shadow: 0 4px 15px rgba(248, 241, 241, 0.2);
    transform: translateY(-5px);
    color: white;
  }

  #services .service-card h4,
  #services .service-card p,
  #services .service-card ul li {
    transition: color 0.3s ease-in-out;
  }

  #services .service-card:hover h4,
  #services .service-card:hover p,
  #services .service-card:hover ul li {
    color: white;
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

  /* Add these styles to maintain equal card heights */
  .card-row {
    display: flex;
    align-items: stretch;
  }

  .card-row .card {
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .card-row .card img {
    height: 200px; /* Set a fixed height for all images */
    object-fit: cover; /* This ensures images cover the area without distortion */
    width: 100%;
  }
</style>




</div>

</section>


  </main>
<?php require"./components/bottom.php";?>