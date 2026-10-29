<?php require"./components/top.php"; ?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Network & Edge Computing</h1>
      <p>Explore our cutting-edge solutions for SD-WAN, CDN, Collaboration, SASE, and more.</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="ITInfra.php">IT Infrastructure</a></li>
          <li class="current">Network & Edge Computing</li>
        </ol>
      </nav>
    </div>
  </div><!--/Hero section -->

  <section id="it-infrastructure" class="services section">

    <!-- Section Title -->
    <section id="network-edge-computing" class="services section light-background">
      <div class="container">
        <!-- Main Flexbox -->
        <div class="d-flex flex-column">

          <!-- Upper Flexbox: Image and Description -->
          <div class="d-flex justify-content-between align-items-center mb-5">
            
            <!-- Left Div: Image -->
            <div class="left-image col-lg-6 col-md-12">
              <img src="./assets/img/ITInfra/nec-main-cover.webp" alt="Network and Edge Computing" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Our Network & Edge Computing Solutions</h2>
              <p>Discover our comprehensive solutions for SD-WAN, CDN, Collaboration, and SASE, designed to enhance network performance, security, and scalability. We provide cutting-edge technologies to meet the growing demand for digital transformation and operational efficiency.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Upper Flexbox: Product and Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Software-Defined WAN (SD-WAN) -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/nec1.webp" alt="SD-WAN" class="img-fluid rounded mb-3">
                <h4>Software-Defined WAN (SD-WAN)</h4>
                <p>Enable branch agility and flexibility with SD-WAN solutions that reduce latency, improve network performance, and streamline operations across multiple locations.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End SD-WAN -->

            <!-- CDN Services with Enterprise-Class Security -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/nec2.jpg" alt="CDN with Security" class="img-fluid rounded mb-3">
                <h4>CDN Services with Enterprise-Class Security</h4>
                <p>Protect and accelerate your websites, apps, and APIs with advanced CDN solutions powered by Cloudflare, offering DDoS mitigation, load balancing, and enterprise-grade security.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End CDN Services -->

            <!-- Collaboration Solutions -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/nec3.jpg" alt="Collaboration Solutions" class="img-fluid rounded mb-3">
                <h4>Collaboration Solutions</h4>
                <p>Simplify team communication and boost collaboration with our suite of IT solutions, including workspaces, conferencing, messaging, and work-from-anywhere platforms.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Collaboration Solutions -->

          </div><!-- End Upper Service Cards -->

          <!-- Lower Flexbox: Product and Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Secure Access Service Edge (SASE) -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/nec4.jpg" alt="SASE" class="img-fluid rounded mb-3">
                <h4>Secure Access Service Edge (SASE)</h4>
                <p>Combine SD-WAN, SWG, CASB, and ZTNA with cloud-native network security to secure your edge network and remote access solutions, providing continuous monitoring and compliance.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End SASE -->

            <!-- Routing, Switching, and Wireless Solutions -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-card position-relative">
                <img src="./assets/img/ITInfra/nec5.webp" alt="Routing and Switching" class="img-fluid rounded mb-3">
                <h4>Routing, Switching & Wireless</h4>
                <p>Enhance network performance with advanced routing, switching, and wireless solutions to ensure seamless access, secure connections, and high availability for your IT infrastructure.</p>
                <a href="index.php?service=IT%20Infrastructure#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Routing and Switching -->

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
        height: 450px;
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
        width: 100%;
      }

      .service-card img {
        height: 200px;
        width: 100%;
        object-fit: cover;
        border-radius: 8px;
      }

      .service-card h4 {
        height: 60px;
        margin: 15px 0;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .service-card p {
        height: 120px;
        overflow: hidden;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
      }

      .service-card a {
        margin-top: auto;
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
