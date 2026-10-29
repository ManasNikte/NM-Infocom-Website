<?php require_once __DIR__ . '/../data/faq_data.php'; ?>
<?php if (!empty($faqs)): ?>
<section id="faq" class="section light-background nm-faq">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-4" data-aos="fade-up">
        <span class="nm-eyebrow">FAQ</span>
        <h2 class="mb-3" style="font-size: clamp(1.8rem, 1.3rem + 1.8vw, 2.4rem); font-weight: 800;">Questions, answered</h2>
        <p class="text-secondary mb-4">Can't find what you're looking for? Our team usually replies within one business day.</p>
        <a href="#contact" class="nm-btn nm-btn-primary">Ask us anything</a>
      </div>
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
        <?php foreach ($faqs as $i => $faq): ?>
          <div class="faq-item <?= $i === 0 ? 'faq-active' : '' ?>">
            <h3><?= htmlspecialchars($faq['faq_title']) ?></h3>
            <div class="faq-content"><div><p><?= htmlspecialchars($faq['faq_description']) ?></p></div></div>
            <i class="faq-toggle bi bi-plus-lg"></i>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
