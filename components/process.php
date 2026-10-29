<?php
$steps = [
    ['Assess', 'We audit your current setup, risks and goals, and share a clear, prioritised report.'],
    ['Design', 'A right-sized solution from leading OEMs, with a transparent quote and timeline.'],
    ['Deploy', 'Certified engineers install, migrate and configure with minimal disruption to your team.'],
    ['Support', 'Monitoring, maintenance and a responsive helpdesk long after go-live.'],
];
?>
<section id="process" class="section">
  <div class="container section-title" data-aos="fade-up">
    <span class="nm-eyebrow">How we work</span>
    <h2>A simple, proven path from problem to production</h2>
    <p>No jargon and no surprises: you always know what happens next and what it costs.</p>
  </div>
  <div class="container">
    <div class="row g-4">
      <?php foreach ($steps as $i => [$title, $text]): ?>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
          <div class="nm-step">
            <span class="nm-step-num">STEP <?= sprintf('%02d', $i + 1) ?></span>
            <h3><?= $title ?></h3>
            <p><?= $text ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
