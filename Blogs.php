<?php
require_once __DIR__ . '/data/blog_lib.php';

$posts = [];
try {
    $posts = nm_blog_posts(getDBConnection());
} catch (Exception $e) {
    error_log('Blogs.php: ' . $e->getMessage());
}
$featured = $posts[0] ?? null;
$rest = array_slice($posts, 1);

// Topic filters from the posts themselves: slug => [label, count]
$topics = [];
foreach ($posts as $p) {
    $slug = nm_blog_slug($p['blog_category_label']);
    $topics[$slug] = [$p['blog_category_label'], ($topics[$slug][1] ?? 0) + 1];
}
$e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);

require "./components/top.php";
?>
<main class="main nm-blog">
  <div class="page-title">
    <div class="container">
      <h1>Insights &amp; updates</h1>
      <p>Security advisories, cloud and infrastructure guides, and practical IT advice from the NM INFOCOM team.</p>
      <nav class="breadcrumbs"><ol><li><a href="index.php">Home</a></li><li class="current">Blog</li></ol></nav>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <?php if (!$posts): ?>
        <div class="nm-empty">
          <i class="bi bi-journal-text"></i>
          <h3>New articles are on the way</h3>
          <p>Subscribe to our newsletter in the footer and we'll send you the first one.</p>
          <a href="index.php#contact" class="nm-btn nm-btn-primary">Talk to an expert</a>
        </div>
      <?php else: ?>

        <?php if ($featured): ?>
          <a class="bl-featured" href="blog-details.php?id=<?= (int) $featured['blog_id'] ?>" data-aos="fade-up">
            <div class="bl-featured-img"><img src="<?= $e($featured['blog_img']) ?>" alt="<?= $e($featured['blog_title']) ?>" loading="eager"></div>
            <div class="bl-featured-body">
              <span class="bl-chip"><?= $e($featured['blog_category_label']) ?></span>
              <h2><?= $e($featured['blog_title']) ?></h2>
              <p><?= $e($featured['blog_excerpt']) ?></p>
              <div class="bl-meta">
                <span><i class="bi bi-person"></i> <?= $e($featured['blog_author']) ?></span>
                <span><i class="bi bi-calendar3"></i> <?= date('j M Y', strtotime($featured['created_at'])) ?></span>
                <span><i class="bi bi-clock"></i> <?= $e($featured['blog_content'] ? nm_read_time($featured['blog_content']) : $featured['read_time']) ?></span>
              </div>
              <span class="nm-link">Read article <i class="bi bi-arrow-right"></i></span>
            </div>
          </a>
        <?php endif; ?>

        <?php if ($rest): ?>
          <div class="bl-toolbar" data-aos="fade-up">
            <div class="bl-filters" role="group" aria-label="Filter by topic">
              <button type="button" class="active" data-topic="">All</button>
              <?php foreach ($topics as $slug => [$label, $count]): ?>
                <button type="button" data-topic="<?= $e($slug) ?>"><?= $e($label) ?> <small><?= $count ?></small></button>
              <?php endforeach; ?>
            </div>
            <label class="bl-search">
              <i class="bi bi-search"></i>
              <input type="search" id="blogSearch" placeholder="Search articles" aria-label="Search articles">
            </label>
          </div>

          <div class="row g-4" id="blogGrid">
            <?php foreach ($rest as $p): ?>
              <div class="col-md-6 col-lg-4" data-topic="<?= $e(nm_blog_slug($p['blog_category_label'])) ?>"
                   data-text="<?= $e(strtolower($p['blog_title'] . ' ' . $p['blog_excerpt'] . ' ' . $p['blog_author'])) ?>">
                <a class="bl-card" href="blog-details.php?id=<?= (int) $p['blog_id'] ?>">
                  <div class="bl-card-img"><img src="<?= $e($p['blog_img']) ?>" alt="<?= $e($p['blog_title']) ?>" loading="lazy"></div>
                  <div class="bl-card-body">
                    <span class="bl-chip"><?= $e($p['blog_category_label']) ?></span>
                    <h3><?= $e($p['blog_title']) ?></h3>
                    <p><?= $e($p['blog_excerpt']) ?></p>
                    <div class="bl-meta">
                      <span><?= date('j M Y', strtotime($p['created_at'])) ?></span>
                      <span><?= $e($p['blog_content'] ? nm_read_time($p['blog_content']) : $p['read_time']) ?></span>
                    </div>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="nm-empty d-none mt-2" id="blogNoResults">
            <i class="bi bi-search"></i>
            <h3>No articles match</h3>
            <p>Try another topic or search term.</p>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </section>
</main>

<script>
(function () {
  const grid = document.getElementById('blogGrid');
  if (!grid) return;
  const items = [...grid.children];
  const search = document.getElementById('blogSearch');
  const empty = document.getElementById('blogNoResults');
  let topic = '';
  function apply() {
    const q = search.value.trim().toLowerCase();
    let shown = 0;
    items.forEach((el) => {
      const ok = (!topic || el.dataset.topic === topic) && (!q || el.dataset.text.includes(q));
      el.classList.toggle('d-none', !ok);
      shown += ok ? 1 : 0;
    });
    empty.classList.toggle('d-none', shown > 0);
  }
  document.querySelectorAll('.bl-filters button').forEach((b) => b.addEventListener('click', () => {
    document.querySelectorAll('.bl-filters button').forEach((x) => x.classList.toggle('active', x === b));
    topic = b.dataset.topic;
    apply();
  }));
  search.addEventListener('input', apply);
})();
</script>

<?php require "./components/bottom.php"; ?>
