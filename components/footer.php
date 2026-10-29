<?php
$socials = ['linkedin_link' => ['bi-linkedin', 'LinkedIn'], 'twitter_link' => ['bi-twitter-x', 'X'],
            'facebook_link' => ['bi-facebook', 'Facebook'], 'instagram_link' => ['bi-instagram', 'Instagram']];
$socialUrls = compact('linkedin_link', 'twitter_link', 'facebook_link', 'instagram_link');
?>
<footer id="footer" class="footer">
  <div class="container footer-top">
    <div class="row gy-5">
      <div class="col-lg-4 col-md-12">
        <a href="index.php" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-3">
          <img src="assets/img/favicon.png" alt="" style="height:40px">
          <span class="nm-wordmark">NM <span>INFOCOM</span></span>
        </a>
        <p>IT security, infrastructure, cloud and enterprise mobility solutions for growing businesses.</p>
        <div class="social-links d-flex mt-4">
          <?php foreach ($socials as $field => [$icon, $label]):
              $url = $socialUrls[$field] ?? '';
              // Skip empty and placeholder links (e.g. ".../yourcompany").
              if (!preg_match('#^https://#', $url) || stripos($url, 'yourcompany') !== false) continue; ?>
            <a href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener" aria-label="<?= $label ?>"><i class="bi <?= $icon ?>"></i></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-6 col-md-3 col-lg-2 footer-links">
        <h4>Services</h4>
        <ul>
          <li><a href="ITsec.php">IT Security</a></li>
          <li><a href="ITInfra.php">IT Infrastructure</a></li>
          <li><a href="cloud.php">Cloud</a></li>
          <li><a href="Mobility.php">Mobility</a></li>
          <li><a href="webdev.php">Web Development</a></li>
          <li><a href="Service.php">All services</a></li>
        </ul>
      </div>

      <div class="col-6 col-md-3 col-lg-2 footer-links">
        <h4>Company</h4>
        <ul>
          <li><a href="index.php#about">About</a></li>
          <li><a href="Partners.php">Partners</a></li>
          <li><a href="Career.php">Careers</a></li>
          <li><a href="Blogs.php">Blog</a></li>
          <li><a href="CRM/index.html">Staff login</a></li>
        </ul>
      </div>

      <div class="col-md-6 col-lg-4">
        <h4>Get IT insights in your inbox</h4>
        <p>Security advisories, product launches and practical tips. One email a month.</p>
        <form id="newsletterForm" class="nm-newsletter" novalidate>
          <label for="nl-email" class="visually-hidden">Email address</label>
          <input id="nl-email" type="email" name="email" placeholder="you@company.com" autocomplete="email" maxlength="150" required>
          <input type="text" name="website" class="nm-hp" tabindex="-1" autocomplete="off" aria-hidden="true">
          <button type="submit">Subscribe</button>
        </form>
        <div class="nm-form-msg" id="newsletterMsg" role="status"></div>
        <?php if (!empty($contact_email)): ?>
          <p class="mt-3 mb-0"><i class="bi bi-envelope me-2"></i><a href="mailto:<?= htmlspecialchars($contact_email) ?>" class="text-reset"><?= htmlspecialchars($contact_email) ?></a></p>
        <?php endif; ?>
      </div>
    </div>

    <div class="copyright">
      <span>© <?= date('Y') ?> NM INFOCOM. All rights reserved.</span>
      <span><a href="policy.php">Terms &amp; privacy</a></span>
    </div>
  </div>
</footer>

<script>
document.getElementById('newsletterForm')?.addEventListener('submit', async function (e) {
  e.preventDefault();
  const msg = document.getElementById('newsletterMsg');
  if (!this.checkValidity()) { this.reportValidity(); return; }
  msg.textContent = 'Subscribing…';
  try {
    const res = await fetch('data/newsletter_subscribe.php', { method: 'POST', body: new FormData(this) });
    const data = await res.json();
    msg.textContent = data.message;
    if (data.success) this.reset();
  } catch (err) {
    msg.textContent = 'Could not subscribe right now. Please try again later.';
  }
});
</script>
