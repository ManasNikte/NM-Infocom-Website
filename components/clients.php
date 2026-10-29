<?php require_once __DIR__ . '/../data/clients_data.php'; ?>
<?php if (!empty($clients_data)): ?>
<section id="clients" class="nm-logos" aria-label="Clients">
  <div class="container">
    <p>Trusted by teams at</p>
    <div class="nm-marquee">
      <div class="nm-marquee-track">
        <?php // Two copies so the strip can scroll seamlessly; the second is hidden from screen readers. ?>
        <?php foreach ([false, true] as $duplicate): ?>
          <?php foreach ($clients_data as $client): ?>
            <img src="<?= htmlspecialchars($client['client_img']) ?>"
                 alt="<?= $duplicate ? '' : htmlspecialchars($client['client_name']) ?>"
                 <?= $duplicate ? 'aria-hidden="true"' : '' ?> loading="lazy">
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
