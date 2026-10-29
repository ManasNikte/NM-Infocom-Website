<?php require"./components/top.php";?>
  <main class="main">

    <!-- Hero section -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1>IT Infrastructure Services</h1>
        <p></p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php#hero">Home</a></li>
            <li class="current"><a href="Service.php">Services</a></li>
            <li>IT Infrastructure</li>
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
          <img src="./assets/img/ITInfra/infra-main-cover.jpg" alt="Service Image" class="img-fluid rounded">
        </div>

        <!-- Right Div: Description -->
        <div class="right-description col-lg-6 col-md-12">
          <h2>Comprehensive IT Infrastructure Services</h2>
          <p>We help re-engineer your datacentre infrastructure and align its potential with your business outcomes. We provide cloud solutions and enable you to build a hybrid IT infrastructure that is secure, scalable, and agile.</p>
        </div>
      </div><!-- End Upper Flexbox -->

      <!-- Lower Flexbox: Service Cards -->
      <div class="row gy-4">
        
        <!-- Datacentre & Cloud Solutions -->
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-card position-relative">
            <img src="./assets/img/ITInfra/data-center1.jpg" alt="Datacentre & Cloud Solutions" class="img-fluid rounded mb-3">
            <h4>Datacentre & Cloud Solutions</h4>
            <p>Transform your datacentre infrastructure and migrate to the cloud with our end-to-end solutions.</p>
            <ul>
              <li>Private & Hybrid Cloud Solutions</li>
              <li>Cloud Migration</li>
              <li>Datacentre Optimization</li>
              <li>Modernization</li>
              <li>Cloud Security</li>
            </ul>
            <a href="./ITInfraDC.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div><!-- End Datacentre & Cloud Solutions -->

        <!-- Networking & Edge Computing -->
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="service-card position-relative">
            <img src="./assets/img/ITInfra/infra2.jpg" alt="Networking & Edge Computing" class="img-fluid rounded mb-3">
            <h4>Networking & Edge Computing</h4>
            <p>Ensure your network is agile, secure, and high-performing with our edge computing solutions.</p>
            <ul>
              <li>Network Transformation</li>
              <li>Agile & Secure Networks</li>
              <li>Edge Computing Infrastructure</li>
              <li>Cloud Connectivity</li>
              <li>On-Demand Network Solutions</li>
            </ul>
            <a href="./ITInfraNEC.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div><!-- End Networking & Edge Computing -->

        <!-- Management, Automation & Orchestration -->
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-card position-relative">
            <img src="./assets/img/ITInfra/infra3.webp" alt="Management, Automation & Orchestration" class="img-fluid rounded mb-3">
            <h4>Management, Automation & Orchestration</h4>
            <p>Optimize your processes and drive digital transformation with management, automation, and orchestration tools.</p>
            <ul>
              <li>Business Process Optimization</li>
              <li>Automation Solutions</li>
              <li>Orchestration Tools</li>
              <li>Cross-Program Integration</li>
              <li>Performance Monitoring</li>
            </ul>
            <a href="./ITInfraMAO.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div><!-- End Management, Automation & Orchestration -->

        <!-- Digital Workplace & Transformation -->
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="service-card position-relative">
            <img src="./assets/img/ITInfra/infra4.jpg" alt="Digital Workplace & Transformation" class="img-fluid rounded mb-3">
            <h4>Digital Workplace & Transformation</h4>
            <p>Deliver personalized user experiences and empower your team to collaborate seamlessly anytime, anywhere.</p>
            <ul>
              <li>User-Centric Solutions</li>
              <li>Remote Work Enablement</li>
              <li>Collaboration Tools</li>
              <li>Employee Experience</li>
              <li>Digital Transformation Support</li>
            </ul>
            <a href="./ITInfraDWT.php" class="stretched-link nm-card-link">Learn more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div><!-- End Digital Workplace & Transformation -->

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
    min-height: 600px;
  }

  .service-card img {
    height: 200px !important;
    min-height: 200px;
    max-height: 200px !important;
    width: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 8px;
    margin-bottom: 15px;
    display: block;
  }

  .service-card h4 {
    height: 50px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
  }

  .service-card p {
    height: 80px;
    margin-bottom: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 0.95rem;
  }

  .service-card ul {
    height: 150px;
    padding-left: 20px;
    margin-bottom: 15px;
    font-size: 0.9rem;
  }

  .service-card ul li {
    margin-bottom: 5px;
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
