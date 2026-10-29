<?php
require_once __DIR__ . '/../data/about_data.php';
require_once __DIR__ . '/../data/about_pointsdata.php';
$tabs = [1 => 'Our solutions', 2 => 'Our team', 3 => 'Our reputation'];
?>
<section id="about" class="section nm-about">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6" data-aos="fade-right">
        <img src="assets/img/about.jpg" class="nm-about-img" alt="The NM INFOCOM team at work" loading="lazy">
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <span class="nm-eyebrow">About NM INFOCOM</span>
        <h2><?= htmlspecialchars($about_data[1]['about_subintroline'] ?? 'Your trusted partner for digital transformation') ?></h2>
        <p class="nm-lead"><?= htmlspecialchars($about_data[0]['about_subintroline'] ?? '') ?></p>

        <ul class="nav nm-tabs" role="tablist">
          <?php foreach ($tabs as $n => $label): ?>
            <li><button class="nav-link <?= $n === 1 ? 'active' : '' ?>" data-bs-toggle="pill" data-bs-target="#about-tab<?= $n ?>" type="button" role="tab"><?= $label ?></button></li>
          <?php endforeach; ?>
        </ul>
        <div class="tab-content">
          <?php foreach ($tabs as $n => $label): ?>
            <div class="tab-pane fade <?= $n === 1 ? 'show active' : '' ?>" id="about-tab<?= $n ?>" role="tabpanel">
              <?php foreach ($about_points[$n] ?? [] as $point): ?>
                <div class="nm-check">
                  <i class="bi bi-check2"></i>
                  <div>
                    <h4><?= htmlspecialchars($point['heading']) ?></h4>
                    <p><?= htmlspecialchars($point['description']) ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
