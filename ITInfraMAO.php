<?php require"./components/top.php"; ?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Management, Architecture & Orchestration</h1>
      <p>Explore our comprehensive solutions for Active Directory Management, Advanced Analytics, IT Service Management, and more.</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="ITInfra.php">IT Infrastructure</a></li>
          <li class="current">Management, Architecture & Orchestration</li>
        </ol>
      </nav>
    </div>
  </div><!--/Hero section -->

  <section id="it-infrastructure" class="services section">

    <!-- Section Title -->
    <section id="management-architecture-orchestration" class="services section light-background">
      <div class="container">
        <!-- Main Flexbox -->
        <div class="d-flex flex-column">

          <!-- Upper Flexbox: Image and Description -->
          <div class="d-flex justify-content-between align-items-center mb-5">
            
            <!-- Left Div: Image -->
            <div class="left-image col-lg-6 col-md-12">
              <img src="./assets/img/ITInfra/mao-main-cover.webp" alt="Management & Architecture" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Our Management, Architecture & Orchestration Solutions</h2>
              <p>Enhance your enterprise IT infrastructure with our solutions for Active Directory, Analytics, IT Service Management, and Unified Endpoint Management. We provide integrated technologies to streamline management, improve operational efficiency, and ensure secure and scalable IT environments.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Upper Flexbox: Product and Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Active Directory & 0365 Management -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/mao1.jpg" alt="Active Directory & O365 Management" class="img-fluid rounded mb-3">
                <h4>Active Directory & O365 Man agement</h4>
                <p>Exclusively partnered with ManageEngine, we provide comprehensive solutions for identity and access management across Windows, Active Directory, Exchange, and Office 365 environments, including backup, recovery, and security features.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Active Directory -->

            <!-- Advanced Analytics -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/mao2.jpg" alt="Advanced Analytics" class="img-fluid rounded mb-3">
                <h4>Advanced Analytics</h4>
                <p>Our analytics solutions powered by ManageEngine help collect, analyze, and report IT operations data to make faster decisions, optimize IT, and enable real-time collaboration across teams.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Advanced Analytics -->

            <!-- IT Service & Asset Management -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/mao3.webp" alt="IT Service & Asset Management" class="img-fluid rounded mb-3">
                <h4>IT Service & Asset Management</h4>
                <p>Optimize service delivery and customer support with full-stack ITSM solutions. Our service suite integrates IT asset management to manage and monitor your network and service operations seamlessly.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End IT Service & Asset Management -->

          </div><!-- End Upper Service Cards -->

          <!-- Lower Flexbox: Product and Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Unified Endpoint Management -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/mao4.jpg" alt="Unified Endpoint Management" class="img-fluid rounded mb-3">
                <h4>Unified Endpoint Management</h4>
                <p>Manage and secure desktops, laptops, mobile devices, and browsers with centralized endpoint management, enhancing productivity and simplifying remote troubleshooting.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Unified Endpoint Management -->

            <!-- IT Operations Management -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/mao5.jpg" alt="IT Operations Management" class="img-fluid rounded mb-3">
                <h4>IT Operations Management</h4>
                <p>Monitor and manage your entire IT infrastructure, including networks, servers, and applications. Our solutions offer proactive monitoring, troubleshooting, and enhanced user experience.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End IT Operations Management -->

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
        max-height: 200px;
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-radius: 8px;
      }

      .service-card h4 {
        margin: 15px 0;
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .service-card p {
        flex-grow: 1;
        margin-bottom: 15px;
        min-height: 100px;
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
