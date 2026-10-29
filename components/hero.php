<?php
require_once __DIR__ . '/../data/stats_data.php';
$heroStats = getStatsData()['total'];
?>
<section id="hero" class="nm-hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-up">
        <span class="nm-eyebrow"><i class="bi bi-shield-check"></i> IT solutions partner since 2020</span>
        <h1>Secure, scalable IT <span class="nm-grad">that just works.</span></h1>
        <p class="nm-lead">
          From endpoint and network security to cloud, datacentre and Apple enterprise mobility,
          NM INFOCOM designs, deploys and supports the technology your business runs on, so your team can focus on growth.
        </p>
        <div class="nm-hero-ctas">
          <a href="#contact" class="nm-btn nm-btn-primary">Book a free consultation <i class="bi bi-arrow-right"></i></a>
          <a href="#services" class="nm-btn nm-btn-ghost">Explore services</a>
        </div>
        <ul class="nm-hero-points">
          <li><i class="bi bi-check-circle-fill"></i> Certified OEM partners</li>
          <li><i class="bi bi-check-circle-fill"></i> End-to-end deployment</li>
          <li><i class="bi bi-check-circle-fill"></i> Ongoing support &amp; SLAs</li>
        </ul>
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
        <div class="nm-hero-visual">
          <img src="assets/img/hero/1.jpg" class="nm-hero-img" alt="NM INFOCOM engineers planning an IT rollout with a client team">
          <div class="nm-float nm-float-a">
            <div class="nm-float-icon"><i class="bi bi-people-fill"></i></div>
            <div><strong><?= number_format($heroStats['client_count']) ?>+</strong><span>businesses served</span></div>
          </div>
          <div class="nm-float nm-float-b">
            <div class="nm-float-icon"><i class="bi bi-headset"></i></div>
            <div><strong><?= number_format($heroStats['hours_of_support']) ?>+</strong><span>support hours delivered</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
