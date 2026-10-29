<?php
$phoneHref = preg_replace('/[^0-9+]/', '', $contact_number ?? '');
$mapSrc = (isset($google_map) && str_starts_with($google_map, 'https://www.google.com/maps/embed')) ? $google_map : '';
?>
<section id="contact" class="section light-background">
  <div class="container section-title" data-aos="fade-up">
    <span class="nm-eyebrow">Contact</span>
    <h2>Let's talk about your IT</h2>
    <p>Tell us what you're working on. A solutions engineer will get back to you within one business day.</p>
  </div>

  <div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-lg-5" data-aos="fade-up">
        <div class="nm-contact-info">
          <?php if ($phoneHref): ?>
            <a href="tel:<?= htmlspecialchars($phoneHref) ?>">
              <span class="nm-icon"><i class="bi bi-telephone"></i></span>
              <div><strong>Call us</strong><span><?= htmlspecialchars($contact_number) ?> · Mon–Sat, 10am–7pm</span></div>
            </a>
          <?php endif; ?>
          <?php if (!empty($contact_email)): ?>
            <a href="mailto:<?= htmlspecialchars($contact_email) ?>">
              <span class="nm-icon"><i class="bi bi-envelope"></i></span>
              <div><strong>Email</strong><span><?= htmlspecialchars($contact_email) ?></span></div>
            </a>
          <?php endif; ?>
          <?php if (!empty($company_address)): ?>
            <div class="nm-info">
              <span class="nm-icon"><i class="bi bi-geo-alt"></i></span>
              <div><strong>Visit us</strong><span><?= htmlspecialchars($company_address) ?></span></div>
            </div>
          <?php endif; ?>
          <?php if ($mapSrc): ?>
            <iframe src="<?= htmlspecialchars($mapSrc) ?>" title="NM INFOCOM office location" style="border:0; width:100%; height:220px; border-radius:14px;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
        <form id="contactForm" class="nm-contact-card nm-form" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="cf-name">Full name</label>
              <input id="cf-name" type="text" name="name" class="form-control" autocomplete="name" maxlength="100" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="cf-email">Work email</label>
              <input id="cf-email" type="email" name="email" class="form-control" autocomplete="email" maxlength="150" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="cf-phone">Phone</label>
              <input id="cf-phone" type="tel" name="contact" class="form-control" autocomplete="tel" maxlength="20" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="cf-subject">I'm interested in</label>
              <select id="cf-subject" name="subject" class="form-select" required>
                <option value="" selected disabled>Select a service</option>
                <option>IT Security</option>
                <option>IT Infrastructure</option>
                <option>Cloud Services</option>
                <option>Apple Enterprise Mobility</option>
                <option>Engineering Services</option>
                <option>Web Development</option>
                <option>Free IT assessment</option>
                <option>Something else</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label" for="cf-message">How can we help?</label>
              <textarea id="cf-message" class="form-control" name="message" rows="5" maxlength="1000" required></textarea>
            </div>
            <?php // Honeypot: hidden from people, bots fill it in and get silently dropped. ?>
            <div class="nm-hp" aria-hidden="true">
              <label for="cf-website">Website</label>
              <input id="cf-website" type="text" name="website" tabindex="-1" autocomplete="off">
            </div>
            <div class="col-12">
              <div class="alert alert-danger d-none mb-3" role="alert" data-form-error></div>
              <div class="alert alert-success d-none mb-3" role="status" data-form-success>
                Thanks! Your message is in. We'll get back to you within one business day.
              </div>
              <button type="submit" class="w-100">Send message <i class="bi bi-send"></i></button>
              <p class="text-secondary small text-center mt-3 mb-0"><i class="bi bi-lock"></i> We never share your details. No spam, ever.</p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
(function () {
  const form = document.getElementById('contactForm');
  if (!form) return;
  // "Ask about this" links from service pages arrive as index.php?service=<name>#contact.
  const wanted = new URLSearchParams(location.search).get('service');
  const subject = form.querySelector('#cf-subject');
  if (wanted && [...subject.options].some((o) => o.value === wanted)) subject.value = wanted;
  const errorBox = form.querySelector('[data-form-error]');
  const successBox = form.querySelector('[data-form-success]');
  const button = form.querySelector('button[type=submit]');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    errorBox.classList.add('d-none');
    successBox.classList.add('d-none');
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }
    const label = button.innerHTML;
    button.disabled = true;
    button.textContent = 'Sending…';
    try {
      const res = await fetch('data/handle_contact_form.php', {
        method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest' },
      });
      const data = await res.json().catch(() => ({}));
      if (!res.ok || !data.success) {
        throw new Error((data.errors && data.errors.join(' ')) || data.message || 'Something went wrong. Please try again.');
      }
      form.reset();
      successBox.classList.remove('d-none');
    } catch (err) {
      errorBox.textContent = err.message;
      errorBox.classList.remove('d-none');
    } finally {
      button.disabled = false;
      button.innerHTML = label;
    }
  });
})();
</script>
