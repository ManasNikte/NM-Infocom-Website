<?php require"./components/top.php";?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Enterprise Mobility Management</h1>
      <p></p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="Service.php">Services</a></li>
          <li><a href="Mobility.php">Mobility</a></li>
          <li class="current">Enterprise Mobility Management</li>
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
              <img src="./assets/img/Mobility/em-main-cover.webp" alt="Enterprise Mobility Management Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Comprehensive Enterprise Mobility Management</h2>
              <p>Our Enterprise Mobility Management services enable businesses to securely manage their mobile fleets, ensuring a seamless mobile experience while enhancing productivity and security. Discover how we can help you manage your devices, apps, and data with ease.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Jamf -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/em1.webp" alt="Jamf" class="img-fluid rounded mb-3">
                <h4>Jamf</h4>
                <p>Jamf helps organizations succeed with Apple. It automates the entire lifecycle of Apple management, personalizes Apple devices, and preserves the Apple device experience users demand.</p>
                <ul>
                  <li>Automated Lifecycle Management</li>
                  <li>Personalized Device Management</li>
                  <li>Access to a Global Apple IT Community</li>
                </ul>
              </div>
            </div><!-- End Jamf -->

            <!-- Workspace ONE -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/em2.jpg" alt="Workspace ONE" class="img-fluid rounded mb-3">
                <h4>Workspace ONE</h4>
                <p>Workspace ONE allows businesses to integrate Mac, iPhone, and iPad easily. It provides flexible enterprise leasing plans, ensuring minimal upfront investment while offering convenience and predictable cash flows.</p>
                <ul>
                  <li>Flexible Leasing Plans</li>
                  <li>Minimal Upfront Investment</li>
                  <li>Seamless Device Integration</li>
                </ul>
              </div>
            </div><!-- End Workspace ONE -->

            <!-- ManageEngine -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/em3.jpg" alt="ManageEngine" class="img-fluid rounded mb-3">
                <h4>ManageEngine</h4>
                <p>ManageEngine Mobile Device Manager Plus is designed to empower your workforce with mobile devices, enhancing productivity while ensuring corporate security and compliance.</p>
                <ul>
                  <li>Enhanced Employee Productivity</li>
                  <li>Comprehensive Mobile Device Management</li>
                  <li>Enterprise Security Compliance</li>
                </ul>
              </div>
            </div><!-- End ManageEngine -->

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
        min-height: 550px;
        display: flex;
        flex-direction: column;
      }

      .service-card img {
        height: 180px;
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

      .service-card h4 {
        font-size: 1.2rem;
        margin: 1rem 0;
        min-height: 40px;
      }

      .service-card p {
        font-size: 0.9rem;
        flex-grow: 1;
      }

      .service-card ul {
        margin-bottom: 1rem;
        padding-left: 20px;
      }

      /* Add responsive adjustments */
      @media (max-width: 992px) {
        .service-card {
          min-height: auto;
        }
        
        .col-md-6 {
          margin-bottom: 20px;
        }
      }
    </style>

</main>
<?php require"./components/bottom.php";?>
