<?php
require_once __DIR__ . '/../data/stats_data.php';
$total_stats = getStatsData()['total'];
$statItems = [
    [$total_stats['client_count'], 'Clients served since 2020'],
    [$total_stats['websites_count'], 'Projects delivered'],
    [$total_stats['hours_of_support'], 'Hours of support provided'],
    [$total_stats['emp_count'], 'Specialists on the team'],
];
?>
<section id="stats" class="nm-stats" aria-label="NM INFOCOM in numbers">
  <div class="container">
    <div class="row g-4">
      <?php foreach ($statItems as [$value, $label]): ?>
        <div class="col-6 col-lg-3">
          <div class="nm-stat">
            <strong><span data-purecounter-start="0" data-purecounter-end="<?= (int) $value ?>" data-purecounter-duration="1" class="purecounter"><?= (int) $value ?></span><span class="nm-plus">+</span></strong>
            <p><?= $label ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
