<?php require"./components/top.php";?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Enterprise Programs</h1>
      <p></p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="Service.php">Services</a></li>
          <li><a href="Mobility.php">Mobility</a></li>
          <li class="current">Enterprise Programs</li>
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
              <img src="./assets/img/Mobility/ep-main-cover.jpg" alt="Enterprise Programs Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Comprehensive Enterprise Programs</h2>
              <p>Our Enterprise Programs are designed to streamline asset management, improve mobility, and offer flexible options like leasing and employee purchases for large businesses. Discover the benefits of our tailored solutions for your business needs.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Service Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Company Owned -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/ep1.webp" alt="Company Owned" class="img-fluid rounded mb-3">
                <h4>Company Owned</h4>
                <p>NM Infocom understands a client’s strategic needs and guides the design, deployment, and support of every IT solution, reducing overhead costs while ensuring compliance with Apple’s sourcing policies and environmental goals.</p>
                <ul>
                  <li>Reliable Vendor</li>
                  <li>Cost-Effective Solutions</li>
                  <li>Genuine Apple Products</li>
                </ul>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Company Owned -->

            <!-- Employee Purchase -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/ep2.jpg" alt="Employee Purchase" class="img-fluid rounded mb-3">
                <h4>Employee Purchase</h4>
                <p>With NM Infocom’s Consumer@Work platform, employees can purchase Apple products of their choice, offering flexibility while ensuring seamless deployment, support, and cost savings for businesses.</p>
                <ul>
                  <li>Flexible Employee Choices</li>
                  <li>Streamlined Deployment</li>
                  <li>Cost Savings</li>
                </ul>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Employee Purchase -->

            <!-- Enterprise Leasing -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/ep3.jpg" alt="Enterprise Leasing" class="img-fluid rounded mb-3">
                <h4>Enterprise Leasing</h4>
                <p>Integrate Mac, iPhone, and iPad into your office with flexible leasing options from NM Infocom. Minimize upfront investment and enjoy the flexibility of upgrading devices as needed.</p>
                <ul>
                  <li>Flexible Leasing Plans</li>
                  <li>Minimal Up-Front Investment</li>
                  <li>Predictable Cash Flow</li>
                </ul>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Enterprise Leasing -->

            <!-- Vendor Consolidation -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-card position-relative">
                <img src="./assets/img/Mobility/ep4.jpg" alt="Vendor Consolidation" class="img-fluid rounded mb-3">
                <h4>Vendor Consolidation</h4>
                <p>Streamline procurement and vendor management with NM Infocom's Vendor Consolidation program. Benefit from better service, improved pricing, and a more efficient corporate IT experience.</p>
                <ul>
                  <li>Reduced Operational Costs</li>
                  <li>More Efficient Vendor Management</li>
                  <li>Improved Employee Productivity</li>
                </ul>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Vendor Consolidation -->

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
        height: 700px;
        display: flex;
        flex-direction: column;
        width: 100%;
        margin: 0;
      }

      .service-card img {
        height: 300px;
        width: 100%;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
      }

      .service-card h4 {
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 0 15px 0;
      }

      .service-card p {
        height: 150px;
        margin: 0 0 15px 0;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
      }

      .service-card ul {
        height: 120px;
        margin: 0;
        padding: 0;
        list-style-position: inside;
        display: flex;
        flex-direction: column;
        justify-content: center;
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

      /* Modify the column classes in the service cards row */
      .row.gy-4.justify-content-center.mt-5 {
        display: flex;
        flex-wrap: nowrap;
        gap: 10px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
      }

      /* Hide scrollbar for Chrome, Safari and Opera */
      .row.gy-4.justify-content-center.mt-5::-webkit-scrollbar {
        display: none;
      }

      /* Adjust the column widths to account for reduced spacing */
      .col-lg-6.col-md-6 {
        flex: 0 0 25%;
        max-width: 25%;
        min-width: 280px;
        padding: 0 5px;
      }
    </style>

</main>
<?php require"./components/bottom.php";?>
