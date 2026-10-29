<?php
require_once __DIR__ . '/../data/our_team_data.php';
$socialIcons = ['linkedin_link' => 'bi-linkedin', 'x_link' => 'bi-twitter-x', 'github_link' => 'bi-github',
                'insta_link' => 'bi-instagram', 'web_link' => 'bi-globe'];
?>
<?php if (!empty($team_members)): ?>
<section id="team" class="section light-background">
  <div class="container section-title" data-aos="fade-up">
    <span class="nm-eyebrow">Leadership</span>
    <h2>The people behind NM INFOCOM</h2>
    <p>Experienced professionals who take ownership of your outcomes.</p>
  </div>
  <div class="container">
    <div class="row g-4 justify-content-center">
      <?php foreach ($team_members as $member): ?>
        <div class="col-sm-6 col-lg-4" data-aos="fade-up">
          <div class="nm-member">
            <img src="<?= htmlspecialchars($member['emp_img']) ?>" alt="<?= htmlspecialchars($member['emp_name']) ?>" loading="lazy">
            <h4><?= htmlspecialchars($member['emp_name']) ?></h4>
            <span><?= htmlspecialchars($member['emp_post']) ?></span>
            <div class="nm-social">
              <?php foreach ($socialIcons as $field => $icon): ?>
                <?php if (!empty($member[$field]) && preg_match('#^https?://#i', $member[$field])): ?>
                  <a href="<?= htmlspecialchars($member[$field]) ?>" target="_blank" rel="noopener" aria-label="<?= htmlspecialchars($member['emp_name']) ?> profile"><i class="bi <?= $icon ?>"></i></a>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
