<?php
require_once __DIR__ . '/data/blog_lib.php';
require_once __DIR__ . '/config/app.php';

$post = null;
$related = [];
try {
    $conn = getDBConnection();
    $post = nm_blog_post($conn, $_GET['id'] ?? 0);
    $related = $post ? nm_blog_related($conn, $post) : [];
} catch (Exception $e) {
    error_log('blog-details.php: ' . $e->getMessage());
}
if (!$post) {
    // Unknown or unpublished article: send readers to the blog index.
    header('Location: Blogs.php');
    exit;
}

$e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
$pageTitle = $post['blog_title'] . ' | NM INFOCOM Blog';
$pageDescription = mb_substr($post['blog_excerpt'], 0, 160);
$readTime = $post['blog_content'] ? nm_read_time($post['blog_content']) : $post['read_time'];
$base = rtrim((string) nm_config('APP_URL', ''), '/');
$url = ($base ?: ((!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . dirname($_SERVER['SCRIPT_NAME'])))
     . '/blog-details.php?id=' . (int) $post['blog_id'];

require "./components/top.php";
?>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $post['blog_title'],
    'description' => $post['blog_excerpt'],
    'image' => $post['blog_img'],
    'author' => ['@type' => 'Person', 'name' => $post['blog_author']],
    'publisher' => ['@type' => 'Organization', 'name' => 'NM INFOCOM'],
    'datePublished' => date('c', strtotime($post['created_at'])),
    'dateModified' => date('c', strtotime($post['last_modified'])),
    'mainEntityOfPage' => $url,
], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>
</script>

<main class="main nm-blog">
  <header class="bl-article-head">
    <div class="container">
      <nav class="wd-crumbs" aria-label="Breadcrumb"><a href="index.php">Home</a><span>/</span><a href="Blogs.php">Blog</a><span>/</span><?= $e($post['blog_category_label']) ?></nav>
      <span class="bl-chip bl-chip-dark"><?= $e($post['blog_category_label']) ?></span>
      <h1><?= $e($post['blog_title']) ?></h1>
      <div class="bl-meta bl-meta-dark">
        <span class="bl-author"><span class="nm-avatar" aria-hidden="true"><?= $e(strtoupper(mb_substr($post['blog_author'], 0, 1))) ?></span><?= $e($post['blog_author']) ?></span>
        <span><i class="bi bi-calendar3"></i> <?= date('j F Y', strtotime($post['created_at'])) ?></span>
        <span><i class="bi bi-clock"></i> <?= $e($readTime) ?></span>
      </div>
    </div>
  </header>

  <section class="bl-article">
    <div class="container">
      <div class="row g-5 justify-content-center">
        <article class="col-lg-8">
          <img class="bl-cover" src="<?= $e($post['blog_img']) ?>" alt="<?= $e($post['blog_title']) ?>">
          <p class="bl-lead"><?= $e($post['blog_excerpt']) ?></p>
          <?php if ($post['blog_content']): ?>
            <div class="bl-body"><?= nm_blog_render($post['blog_content']) ?></div>
          <?php endif; ?>

          <div class="bl-share">
            <strong>Share this article</strong>
            <?php $shareUrl = rawurlencode($url); $shareText = rawurlencode($post['blog_title']); ?>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $shareUrl ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&amp;text=<?= $shareText ?>" target="_blank" rel="noopener" aria-label="Share on X"><i class="bi bi-twitter-x"></i></a>
            <a href="https://wa.me/?text=<?= $shareText ?>%20<?= $shareUrl ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><i class="bi bi-whatsapp"></i></a>
            <button type="button" id="copyLink" data-url="<?= $e($url) ?>" aria-label="Copy link"><i class="bi bi-link-45deg"></i> <span>Copy link</span></button>
          </div>
        </article>

        <aside class="col-lg-4">
          <div class="bl-side">
            <span class="nm-eyebrow">Need help with this?</span>
            <h3>Talk to an NM INFOCOM expert</h3>
            <p>Get practical advice for your business. Our engineers usually reply within one business day.</p>
            <a href="index.php#contact" class="nm-btn nm-btn-primary w-100">Book a free consultation</a>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <?php if ($related): ?>
    <section class="section light-background">
      <div class="container">
        <h2 class="bl-related-title">Keep reading</h2>
        <div class="row g-4">
          <?php foreach ($related as $p): ?>
            <div class="col-md-6 col-lg-4">
              <a class="bl-card" href="blog-details.php?id=<?= (int) $p['blog_id'] ?>">
                <div class="bl-card-img"><img src="<?= $e($p['blog_img']) ?>" alt="<?= $e($p['blog_title']) ?>" loading="lazy"></div>
                <div class="bl-card-body">
                  <span class="bl-chip"><?= $e($p['blog_category_label']) ?></span>
                  <h3><?= $e($p['blog_title']) ?></h3>
                  <div class="bl-meta"><span><?= date('j M Y', strtotime($p['created_at'])) ?></span></div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
</main>

<script>
document.getElementById('copyLink')?.addEventListener('click', async function () {
  try {
    await navigator.clipboard.writeText(this.dataset.url);
    this.querySelector('span').textContent = 'Copied!';
    setTimeout(() => { this.querySelector('span').textContent = 'Copy link'; }, 2000);
  } catch (e) {
    prompt('Copy this link:', this.dataset.url);
  }
});
</script>

<?php require "./components/bottom.php"; ?>
