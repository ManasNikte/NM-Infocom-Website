<?php
require_once __DIR__ . '/../data/review_data.php';
$featured = array_slice($reviews ?? [], 0, 6);
?>
<?php if ($featured): ?>
<section id="reviews" class="section">
  <div class="container section-title" data-aos="fade-up">
    <span class="nm-eyebrow">Client stories</span>
    <h2>What our clients say</h2>
    <p>Real feedback from the businesses we work with every day.</p>
  </div>
  <div class="container">
    <div class="row g-4">
      <?php foreach ($featured as $i => $review):
          $rating = max(1, min(5, (int) $review['reviewer_rating']));
          $initials = strtoupper(implode('', array_map(fn ($w) => mb_substr($w, 0, 1), array_slice(preg_split('/\s+/', trim($review['reviewer_name'])), 0, 2))));
      ?>
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
          <figure class="nm-quote">
            <div class="nm-stars" aria-label="<?= $rating ?> out of 5 stars"><?= str_repeat('★', $rating) . str_repeat('☆', 5 - $rating) ?></div>
            <blockquote>“<?= htmlspecialchars($review['review_text']) ?>”</blockquote>
            <figcaption class="nm-person">
              <span class="nm-avatar" aria-hidden="true"><?= htmlspecialchars($initials) ?></span>
              <div>
                <strong><?= htmlspecialchars($review['reviewer_name']) ?></strong>
                <span><?= htmlspecialchars($review['reviewer_designation']) ?></span>
              </div>
            </figcaption>
          </figure>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="text-center mt-5 mb-0"><a href="reviewform.php" class="nm-btn nm-btn-ghost">Worked with us? Leave a review</a></p>
  </div>
</section>
<?php endif; ?>
