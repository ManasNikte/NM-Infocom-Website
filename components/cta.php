<?php $contactHref = basename($_SERVER['SCRIPT_NAME']) === 'index.php' ? '#contact' : 'index.php#contact'; ?>
<section class="nm-cta" aria-label="Get started">
  <div class="container" data-aos="fade-up">
    <div class="nm-cta-card">
      <div>
        <span class="nm-eyebrow">Free IT health check</span>
        <h2>Not sure where your IT stands?</h2>
        <p>Get a no-obligation assessment of your security, infrastructure and devices, with a clear action plan from our engineers.</p>
      </div>
      <div class="nm-cta-actions">
        <a href="<?= $contactHref ?>" class="nm-btn nm-btn-light">Book my assessment <i class="bi bi-arrow-right"></i></a>
        <?php if (!empty($contact_number)): ?>
          <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $contact_number)) ?>" class="nm-btn nm-btn-outline-light"><i class="bi bi-telephone"></i> <?= htmlspecialchars($contact_number) ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
