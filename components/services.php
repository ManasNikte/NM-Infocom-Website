<?php
$services = [
    ['ITsec.php', 'bi-shield-lock', 'IT Security',
     'Endpoint, network, data and cloud security that stops threats before they reach your business.'],
    ['ITInfra.php', 'bi-hdd-network', 'IT Infrastructure',
     'Datacentre, private cloud, edge computing and server &amp; storage networking, built to scale.'],
    ['cloud.php', 'bi-cloud-check', 'Cloud Services',
     'Secure business email, web &amp; FTP hosting, DNS and remote monitoring on reliable cloud platforms.'],
    ['Mobility.php', 'bi-phone', 'Apple Enterprise Mobility',
     'iPhone, Mac and MDM programs with leasing, deployment, training and support for your workforce.'],
    ['Service.php', 'bi-cpu', 'Engineering Services',
     'CAD, CAM, PDM/PLM, simulation (CAE &amp; CFD), IoT and Industry 4.0 solutions for manufacturers.'],
    ['webdev.php', 'bi-code-slash', 'Web Development',
     'Custom-built websites and web apps, designed around your business rather than a template.'],
];
?>
<section id="services" class="services section nm-services light-background">
  <div class="container section-title" data-aos="fade-up">
    <span class="nm-eyebrow">What we do</span>
    <h2>Everything your business needs from IT, under one roof</h2>
    <p>One accountable partner for security, infrastructure, cloud and devices, from first assessment to day-to-day support.</p>
  </div>
  <div class="container">
    <div class="row g-4">
      <?php foreach ($services as $i => [$href, $icon, $title, $text]): ?>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= 50 + $i * 50 ?>">
          <a class="nm-service" href="./<?= $href ?>">
            <div class="nm-icon"><i class="bi <?= $icon ?>"></i></div>
            <h3><?= $title ?></h3>
            <p><?= $text ?></p>
            <span class="nm-link">Learn more <i class="bi bi-arrow-right"></i></span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
