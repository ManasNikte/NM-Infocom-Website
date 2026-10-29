<?php require_once __DIR__ . '/../data/whyus_data.php'; ?>
<section id="why-us" class="section nm-dark nm-why">
  <div class="container section-title" data-aos="fade-up">
    <span class="nm-eyebrow">Why NM INFOCOM</span>
    <h2>Why businesses choose us</h2>
    <p><?= htmlspecialchars($why_us_intro ?: 'Choose us for unparalleled quality and service') ?></p>
  </div>
  <div class="container">
    <div class="row g-4">
      <?php foreach ($whyus_data as $i => $item): ?>
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
          <div class="nm-why-card">
            <span><?= htmlspecialchars($item['whyus_card_number']) ?></span>
            <h3><?= htmlspecialchars($item['whyus_title']) ?></h3>
            <p><?= htmlspecialchars($item['whyus_description']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
