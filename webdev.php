<?php
$hideFooterCta = true; // this page ends with its own call-to-action
require "./components/top.php";
?>

<main class="main nm-webdev">

  <!-- Hero -->
  <section class="wd-hero">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6" data-aos="fade-up">
          <nav class="wd-crumbs" aria-label="Breadcrumb"><a href="index.php">Home</a><span>/</span><a href="Service.php">Services</a><span>/</span>Web Development</nav>
          <span class="nm-eyebrow"><i class="bi bi-code-slash"></i> Web development</span>
          <h1>Websites and web apps, <span class="nm-grad">built from scratch.</span></h1>
          <p class="nm-lead">
            No templates and no drag-and-drop builders. Our developers design, code, launch and look after your website
            or web application end to end, and we review progress with you after every milestone.
          </p>
          <div class="nm-hero-ctas">
            <a href="index.php?service=Web%20Development#contact" class="nm-btn nm-btn-primary">Start your project <i class="bi bi-arrow-right"></i></a>
            <a href="#process" class="nm-btn nm-btn-outline-light">See how we work</a>
          </div>
          <ul class="wd-points">
            <li><i class="bi bi-check-circle-fill"></i> Hand-written, maintainable code</li>
            <li><i class="bi bi-check-circle-fill"></i> A review meeting at every milestone</li>
            <li><i class="bi bi-check-circle-fill"></i> You own the code and the domain</li>
          </ul>
        </div>

        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
          <div class="wd-mock" aria-hidden="true">
            <div class="wd-window">
              <div class="wd-bar"><span></span><span></span><span></span><em>yourcompany.com</em></div>
              <div class="wd-screen">
                <div class="wd-code">
                  <p><b class="k">const</b> <b class="v">project</b> = {</p>
                  <p class="i">client: <b class="s">'Your business'</b>,</p>
                  <p class="i">built: <b class="s">'from scratch'</b>,</p>
                  <p class="i">stack: [<b class="s">'PHP'</b>, <b class="s">'JavaScript'</b>, <b class="s">'MySQL'</b>],</p>
                  <p class="i">reviews: <b class="s">'every milestone'</b>,</p>
                  <p class="i">launch: <b class="k">true</b></p>
                  <p>};</p>
                  <p class="c">// Shipped, tested and supported.</p>
                </div>
                <div class="wd-preview">
                  <div class="wd-skel wd-skel-nav"></div>
                  <div class="wd-skel wd-skel-h"></div>
                  <div class="wd-skel wd-skel-p"></div>
                  <div class="wd-skel wd-skel-btn"></div>
                  <div class="wd-tiles"><span></span><span></span><span></span></div>
                </div>
              </div>
            </div>
            <div class="nm-float wd-float-a">
              <div class="nm-float-icon"><i class="bi bi-calendar2-check"></i></div>
              <div><strong>Milestone 3 approved</strong><span>Review call with client · done</span></div>
            </div>
            <div class="nm-float wd-float-b">
              <div class="nm-float-icon"><i class="bi bi-speedometer2"></i></div>
              <div><strong>Fast by default</strong><span>Lightweight, optimised pages</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- What we build -->
  <?php
  $builds = [
      ['bi-window', 'Business websites', 'Fast, search-friendly company websites that explain what you do and turn visitors into enquiries.'],
      ['bi-bag-check', 'E-commerce stores', 'Product catalogues, carts, payments and order management tailored to how you actually sell.'],
      ['bi-grid-1x2', 'Web apps & portals', 'Customer portals, booking systems and internal tools with secure, role-based access.'],
      ['bi-speedometer', 'CRMs & dashboards', 'Track leads, tasks, vendors and staff in one place, like the CRM our own team runs on.'],
      ['bi-plug', 'APIs & integrations', 'Connect payment gateways, email, SMS, accounting and ERP systems so data flows on its own.'],
      ['bi-tools', 'Care & maintenance', 'Hosting, backups, security updates and improvements after launch, on a plan that suits you.'],
  ];
  ?>
  <section class="section" id="what-we-build">
    <div class="container section-title" data-aos="fade-up">
      <span class="nm-eyebrow">What we build</span>
      <h2>From a five-page website to a full web platform</h2>
      <p>Every project is designed around your business and written by our own developers.</p>
    </div>
    <div class="container">
      <div class="row g-4 nm-services">
        <?php foreach ($builds as $i => [$icon, $title, $text]): ?>
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
            <div class="nm-service">
              <div class="nm-icon"><i class="bi <?= $icon ?>"></i></div>
              <h3><?= $title ?></h3>
              <p><?= $text ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- From scratch -->
  <section class="section light-background">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-5" data-aos="fade-right">
          <span class="nm-eyebrow">Built from scratch</span>
          <h2 class="wd-h2">Why hand-built beats a template</h2>
          <p class="text-secondary">Page builders and themes are quick to start but slow, bloated and hard to change later.
            We write every line for your project, so your site does exactly what you need and nothing it doesn't.</p>
          <a href="index.php?service=Web%20Development#contact" class="nm-btn nm-btn-primary mt-2">Get a free estimate</a>
        </div>
        <div class="col-lg-7" data-aos="fade-left">
          <div class="row g-3">
            <?php
            $benefits = [
                ['bi-lightning-charge', 'Performance', 'Lean pages that load fast on any connection, which visitors and Google both reward.'],
                ['bi-shield-lock', 'Security', 'Validated inputs, protected admin areas and safe file handling built in from day one.'],
                ['bi-phone', 'Responsive', 'Designed for phones, tablets and desktops, and tested on real devices.'],
                ['bi-search', 'SEO-ready', 'Clean markup, page titles, descriptions and structured data so you can be found.'],
                ['bi-pencil-square', 'Easy to update', 'Content you can edit yourself through a simple admin panel.'],
                ['bi-key', 'You own it', 'Full source code, documentation and credentials are handed over to you.'],
            ];
            foreach ($benefits as [$icon, $title, $text]): ?>
              <div class="col-sm-6">
                <div class="wd-benefit">
                  <i class="bi <?= $icon ?>"></i>
                  <div><h3><?= $title ?></h3><p><?= $text ?></p></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Process -->
  <?php
  $steps = [
      ['Discovery', 'We learn your goals, users and must-haves, then agree a written scope, timeline and fixed quote.', 'Kick-off meeting'],
      ['Design', 'Wireframes and visual designs for key pages, refined with your feedback before any code is written.', 'Design review'],
      ['Build in sprints', 'Our developers build feature by feature on a private staging site you can click through at any time.', 'Demo after each sprint'],
      ['Test & refine', 'Cross-device, speed, security and accessibility testing, plus your own sign-off round.', 'Acceptance review'],
      ['Launch', 'We deploy to your domain, set up analytics, backups and SSL, and train your team on the admin panel.', 'Go-live meeting'],
      ['Support & grow', 'Monitoring, updates and new features whenever you need them, on a plan that suits you.', 'Monthly check-ins'],
  ];
  ?>
  <section class="section" id="process">
    <div class="container section-title" data-aos="fade-up">
      <span class="nm-eyebrow">How we work</span>
      <h2>End to end, with you at every milestone</h2>
      <p>You are never left wondering how your project is going. After each milestone we meet, demo the work and agree the next step together.</p>
    </div>
    <div class="container">
      <ol class="wd-timeline">
        <?php foreach ($steps as $i => [$title, $text, $meeting]): ?>
          <li data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
            <span class="wd-num"><?= sprintf('%02d', $i + 1) ?></span>
            <div class="wd-step">
              <h3><?= $title ?></h3>
              <p><?= $text ?></p>
              <span class="wd-meet"><i class="bi bi-people"></i> <?= $meeting ?></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <!-- Stack + promise -->
  <section class="section nm-dark nm-why">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6" data-aos="fade-up">
          <span class="nm-eyebrow">Technology</span>
          <h2 class="wd-h2 text-white">Proven, mainstream tools your future team can maintain</h2>
          <p>We pick technology for reliability and long-term support, not hype, so you are never locked in to us.</p>
          <div class="wd-chips">
            <?php foreach (['HTML5', 'CSS3', 'JavaScript', 'PHP', 'MySQL / MariaDB', 'Bootstrap', 'REST APIs', 'Chart.js', 'Git', 'Linux hosting', 'Cloudflare CDN', 'SSL / HTTPS'] as $tech): ?>
              <span><?= $tech ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="120">
          <div class="row g-3">
            <?php foreach ([['bi-person-workspace', 'One project lead', 'A single point of contact from kick-off to launch.'],
                            ['bi-calendar-week', 'Regular meetings', 'A review after every milestone, never just at the end.'],
                            ['bi-eye', 'Always visible', 'A live staging link so you can see progress any day.'],
                            ['bi-receipt', 'No surprises', 'Fixed, written quotes and change requests agreed in advance.']] as [$icon, $title, $text]): ?>
              <div class="col-sm-6">
                <div class="nm-why-card">
                  <span><i class="bi <?= $icon ?>"></i></span>
                  <h3><?= $title ?></h3>
                  <p><?= $text ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <?php
  $faqs = [
      ['How long does a website take?', 'A typical business website takes 3–6 weeks; web applications and stores usually take 6–12 weeks. You get a timeline with milestone dates in the proposal.'],
      ['How much does it cost?', "It depends on scope. After the discovery call we send a fixed, itemised quote, and you only pay more if you ask for something new."],
      ['Will I be able to update the site myself?', 'Yes. We build a simple admin panel for the content you change often and train your team on it at launch.'],
      ['Do you redesign existing websites?', 'Yes. We can rebuild your current site from scratch, keep your content and search rankings, and move it to faster, safer hosting.'],
      ['What happens after launch?', 'Choose a care plan for hosting, backups, updates and improvements, or take the code in-house. It is yours either way.'],
  ];
  ?>
  <section class="section light-background nm-faq">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-4" data-aos="fade-up">
          <span class="nm-eyebrow">FAQ</span>
          <h2 class="wd-h2">Web projects, explained</h2>
          <p class="text-secondary">Still deciding? Ask us anything, we're happy to talk it through.</p>
        </div>
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
          <?php foreach ($faqs as $i => [$q, $a]): ?>
            <div class="faq-item <?= $i === 0 ? 'faq-active' : '' ?>">
              <h3><?= htmlspecialchars($q) ?></h3>
              <div class="faq-content"><div><p><?= htmlspecialchars($a) ?></p></div></div>
              <i class="faq-toggle bi bi-plus-lg"></i>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA -->
  <section class="nm-cta wd-cta">
    <div class="container" data-aos="fade-up">
      <div class="nm-cta-card">
        <div>
          <span class="nm-eyebrow">Let's build it</span>
          <h2>Have a website or app in mind?</h2>
          <p>Book a free 30-minute discovery call. We'll talk through your idea and follow up with a clear plan and quote.</p>
        </div>
        <div class="nm-cta-actions">
          <a href="index.php?service=Web%20Development#contact" class="nm-btn nm-btn-light">Book a discovery call <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require "./components/bottom.php"; ?>
