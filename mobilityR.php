<?php
// Enable full error reporting

// Optionally, log errors to a file (useful for production environments)
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '/path/to/your/error.log'); // Set the path for the error log

?>
<?php require"./components/top.php";?>
<main class="main">

  <!-- Hero section -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Resources</h1>
      <p></p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="Service.php">Services</a></li>
          <li><a href="Mobility.php">Mobility</a></li>
          <li class="current">Resources</li>
        </ol>
      </nav>
    </div>
  </div><!--/Hero section -->

  <section id="resources" class="resources section">

    <!-- Section Title -->
    <section id="resources-section" class="resources section light-background">
      <div class="container">
        <!-- Main Flexbox -->
        <div class="d-flex flex-column">
          
          <!-- Upper Flexbox: Image and Description -->
          <div class="d-flex justify-content-between align-items-center mb-5">
            
            <!-- Left Div: Image -->
            <div class="left-image col-lg-6 col-md-12">
              <img src="./assets/img/Mobility/resource.jpg" alt="Resources Image" class="img-fluid rounded">
            </div>

            <!-- Right Div: Description -->
            <div class="right-description col-lg-6 col-md-12">
              <h2>Our Resources</h2>
              <p>Explore our comprehensive resources designed to help you get the most out of your Apple products and services. From brochures and case studies to deployment guides and video tutorials, we’ve got you covered.</p>
            </div>
          </div><!-- End Upper Flexbox -->

          <!-- Lower Flexbox: Resource Cards -->
          <div class="row gy-4 justify-content-center mt-5">

            <!-- Brochures -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="resource-card position-relative">
                <i class="fa fa-book fa-3x mb-3"></i>
                <h4>Brochures</h4>
                <p>Download our brochures for detailed information about Apple products and services.</p>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Brochures -->

            <!-- Zero Touch Deployment -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="resource-card position-relative">
                <i class="fa fa-cogs fa-3x mb-3"></i>
                <h4>Zero Touch Deployment</h4>
                <p>Learn how to streamline your deployment process with Zero Touch Deployment for Apple devices.</p>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Zero Touch Deployment -->

            <!-- Jamf Pro and Now -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="resource-card position-relative">
                <i class="fa fa-wrench fa-3x mb-3"></i>
                <h4>Jamf Pro and Now</h4>
                <p>Manage and secure your Apple devices effectively with Jamf Pro and Jamf Now.</p>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Jamf Pro and Now -->

            <!-- Case Studies -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="resource-card position-relative">
                <i class="fa fa-briefcase fa-3x mb-3"></i>
                <h4>Case Studies</h4>
                <p>Explore our case studies to see how Apple products are transforming businesses and industries.</p>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Case Studies -->

            <!-- Videos -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="resource-card position-relative">
                <i class="fa fa-video fa-3x mb-3"></i>
                <h4>Videos</h4>
                <p>Watch our video tutorials and webinars to understand how Apple solutions can enhance your workflow.</p>
                <a href="index.php?service=Apple%20Enterprise%20Mobility#contact" class="nm-card-link">Ask about this <i class="bi bi-arrow-right"></i></a>
              </div>
            </div><!-- End Videos -->

          </div><!-- End Resource Cards -->

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

      .resource-card {
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

      .resource-card i {
        color: #007bff;
        transition: color 0.3s ease-in-out;
        margin-bottom: 1rem;
      }

      .resource-card h4 {
        margin: 1rem 0;
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .resource-card p {
        flex-grow: 1;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }

      .resource-card img {
        max-height: 200px;
        object-fit: cover;
        width: 100%;
        border-radius: 8px;
      }

      .resource-card:hover {
        background: #5c9f24; /* Hover color */
        box-shadow: 0 4px 15px rgba(248, 241, 241, 0.2);
        transform: translateY(-5px);
        color: white; /* Change text color to white on hover */
      }

      .resource-card:hover i {
        color: white; /* Change icon color to white on hover */
      }

      .resource-card h4,
      .resource-card p,
      .resource-card ul li {
        transition: color 0.3s ease-in-out; /* Smooth transition */
      }

      .resource-card:hover h4,
      .resource-card:hover p,
      .resource-card:hover ul li {
        color: white; /* Change text color to white */
      }

      .resource-card a {
        display: inline-block;
        margin-top: 15px;
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
      }

      .resource-card a:hover {
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
