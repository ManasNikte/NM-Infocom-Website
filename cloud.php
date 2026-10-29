<?php require"./components/top.php";?>
  <main class="main">

    <!-- Hero section -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1>Cloud Services</h1>
        <p></p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php#hero">Home</a></li>
            <li class="current">Services</li>
            <li>Cloud</li>
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
              <img src="./assets/img/Cloud/cloud-cover.jpg" alt="Cloud Service Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Comprehensive Cloud Services</h2>
              <p>Our cloud services provide secure, scalable, and agile solutions, enabling businesses to leverage the power of cloud for optimal performance and security.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Service Cards -->
          <div class="row gy-4">

            <!-- Secure FTP Hosting -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/Cloud/secure-ftp.jpg" alt="Secure FTP Hosting" class="img-fluid rounded mb-3">
                <h4>Secure FTP Hosting</h4>
                <p>Send and receive files securely with password authentication.</p>
                <ul>
                  <li>User Accounts</li>
                  <li>Max Connections per User Account</li>
                  <li>Max Concurrent Connections</li>
                  <li>Provision for 2 Factor Authentication</li>
                </ul>
                <a href="index.php?service=Cloud%20Services#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Secure FTP Hosting -->

            <!-- Enterprise Web Sec / CDN -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/Cloud/web-sec-cdn.jpg" alt="Enterprise Web Sec / CDN" class="img-fluid rounded mb-3">
                <h4>Enterprise Web Sec / CDN</h4>
                <p>Enterprise-level web protection with unlimited DDoS, WAF, CDN, Load Balancer, and more.</p>
                <ul>
                  <li>Unlimited DDoS Protection</li>
                  <li>WAF and CDN</li>
                  <li>Bot Security</li>
                  <li>Web Security Features</li>
                </ul>
                <a href="index.php?service=Cloud%20Services#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Enterprise Web Sec / CDN -->

            <!-- Email Security -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/Cloud/email-security.jpg" alt="Email Security" class="img-fluid rounded mb-3">
                <h4>Email Security</h4>
                <p>Protect your email infrastructure from threats like spam, APTs, phishing, and more.</p>
                <ul>
                  <li>Anti-APT/Anti-Spam Engine</li>
                  <li>Graymail Detection & Phishing Protection</li>
                  <li>Zero-Day Exploits Protection</li>
                  <li>99.99% Uptime</li>
                </ul>
                <a href="index.php?service=Cloud%20Services#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Email Security -->

          </div><!-- End First Row of Cards -->

          <!-- Second Row: Center-Aligned Cards -->
          <div class="row gy-4 justify-content-center">
            
            <!-- DMARC -->
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-card position-relative">
                <img src="./assets/img/Cloud/dmarc.jpg" alt="DMARC" class="img-fluid rounded mb-3">
                <h4>DMARC</h4>
                <p>Implement email authentication and reduce risks associated with email spoofing.</p>
                <ul>
                  <li>DNS, Email & 3rd Party Support</li>
                  <li>Reduce Legitimate Email Blocking</li>
                  <li>Address DKIM and SPF Failures</li>
                </ul>
                <a href="index.php?service=Cloud%20Services#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End DMARC -->

            <!-- Remote Monitoring Service -->
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-card position-relative">
                <img src="./assets/img/Cloud/remote-monitoring.jpg" alt="Remote Monitoring Service" class="img-fluid rounded mb-3">
                <h4>Remote Monitoring Service</h4>
                <p>24/7 monitoring with real-time alerts and detailed reports to ensure system uptime.</p>
                <ul>
                  <li>Real-Time Infrastructure Monitoring</li>
                  <li>Email Alerts for Critical Failures</li>
                  <li>Uptime and Performance Reports</li>
                </ul>
                <a href="index.php?service=Cloud%20Services#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Remote Monitoring Service -->

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


  </main>
<?php require"./components/bottom.php";?>
