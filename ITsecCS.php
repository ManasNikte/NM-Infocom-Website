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
            <li><a href="Service.php">Services</a></li>
            <li><a href="ITsec.php">IT Security</a></li>
            <li class="current">Cloud Services</li>
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
              <img src="./assets/img/ITSEC/cloud-cover.jpg" alt="Cloud Services Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Comprehensive Cloud Services</h2>
              <p>Our cloud services provide secure, scalable, and cost-effective solutions for businesses, ensuring reliable performance and protection for your cloud infrastructure.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Cloud Access Security Brokers (CASB) -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/c1.webp" alt="Cloud Access Security Brokers (CASB)" class="img-fluid rounded mb-3">
                <h4>Cloud Access Security Brokers (CASB)</h4>
                <p>A CASB acts as an intermediary between users and cloud service providers, offering shadow-IT detection, malware inspection, and data protection for cloud-to-cloud traffic.</p>
                <ul>
                  <li>Shadow-IT Detection</li>
                  <li>Malware Inspection</li>
                  <li>Data Protection & Compliance</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Cloud Access Security Brokers (CASB) -->

            <!-- Cloud Security Posture Management (CSPM) -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/c2.jpg" alt="Cloud Security Posture Management (CSPM)" class="img-fluid rounded mb-3">
                <h4>Cloud Security Posture Management (CSPM)</h4>
                <p>CSPM identifies misconfigurations in cloud environments and automates security management for IaaS, SaaS, and PaaS platforms to reduce risks and ensure compliance.</p>
                <ul>
                  <li>Misconfiguration Detection</li>
                  <li>Automated Cloud Security Management</li>
                  <li>Compliance Monitoring</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Cloud Security Posture Management (CSPM) -->

            <!-- Cloud Workload Security -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/ITSEC/c3.jpg" alt="Cloud Workload Security" class="img-fluid rounded mb-3">
                <h4>Cloud Workload Security</h4>
                <p>Protect cloud-native applications and workloads, including VMs, containers, and databases, with a comprehensive security solution for your entire cloud environment.</p>
                <ul>
                  <li>Workload Security for VMs & Containers</li>
                  <li>Intrusion Prevention & Firewall</li>
                  <li>Virtual Patching & Integrity Monitoring</li>
                </ul>
                <a href="index.php?service=IT%20Security#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Cloud Workload Security -->

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
        justify-content: space-between;
      }

      .service-card img {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-radius: 8px;
      }

      .service-card > * {
        margin-bottom: 15px;
      }

      .service-card > *:last-child {
        margin-bottom: 0;
      }

      .service-card ul {
        padding-left: 0;
        list-style-position: inside;
        margin-bottom: 15px;
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
