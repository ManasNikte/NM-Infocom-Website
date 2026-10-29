<?php
require_once __DIR__ . '/data/career_data.php';

$jobs = [];
$categories = [];
try {
    $conn = getDBConnection();
    $jobs = nm_open_jobs($conn);
    $categories = nm_job_categories($conn);
} catch (Exception $e) {
    error_log('Career.php: ' . $e->getMessage());
}
$e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
$usedCategories = array_intersect_key($categories, array_flip(array_column($jobs, 'category')));
$types = array_values(array_unique(array_column($jobs, 'type')));

$perks = [
    ['bi-patch-check', 'Certifications & training', 'Sponsored OEM certifications and regular training on the security, cloud and networking platforms we deploy.'],
    ['bi-hdd-rack', 'Real enterprise projects', 'Work on live deployments for real clients, from datacentres to fleets of Apple devices, not just tickets.'],
    ['bi-people', 'Mentorship', 'Learn from experienced engineers and sales leads who review your work and help you grow.'],
    ['bi-graph-up-arrow', 'Clear growth path', 'Regular reviews, transparent expectations and room to move into senior and lead roles.'],
    ['bi-emoji-smile', 'Supportive team', 'A close-knit team in Thane where your ideas are heard and good work is noticed.'],
    ['bi-calendar-check', 'Fair time off', 'Paid leave you can request and track in our own CRM, approved by your manager.'],
];
$steps = [
    ['Apply', 'Send your details and CV for an open role, or a general application.'],
    ['Screening call', 'A short call with HR about your experience and what you are looking for.'],
    ['Interview', 'Meet the team lead for a practical conversation about the role.'],
    ['Offer', 'We share an offer and a joining date, usually within a week of the interview.'],
];

require "./components/top.php";
?>
<?php if ($jobs): ?>
<script type="application/ld+json">
<?= json_encode(array_map(fn ($j) => [
    '@context' => 'https://schema.org',
    '@type' => 'JobPosting',
    'title' => $j['title'],
    'description' => $j['description'],
    'datePosted' => $j['date_posted'],
    'validThrough' => $j['deadline'],
    'employmentType' => strtoupper(str_replace(' ', '_', $j['type'])),
    'hiringOrganization' => ['@type' => 'Organization', 'name' => 'NM INFOCOM'],
    'jobLocation' => ['@type' => 'Place', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => $j['location'], 'addressCountry' => 'IN']],
], $jobs), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>
</script>
<?php endif; ?>

<main class="main nm-careers">
  <section class="wd-hero cr-hero">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-7" data-aos="fade-up">
          <nav class="wd-crumbs" aria-label="Breadcrumb"><a href="index.php">Home</a><span>/</span>Careers</nav>
          <span class="nm-eyebrow"><i class="bi bi-briefcase"></i> Careers at NM INFOCOM</span>
          <h1>Build the IT that <span class="nm-grad">businesses rely on.</span></h1>
          <p class="nm-lead">Join a team of engineers, sales and support specialists delivering security, cloud, infrastructure and mobility solutions to growing companies across India.</p>
          <div class="nm-hero-ctas">
            <a href="#openings" class="nm-btn nm-btn-primary">See open roles <i class="bi bi-arrow-down"></i></a>
            <button type="button" class="nm-btn nm-btn-outline-light" data-apply="">Send a general application</button>
          </div>
        </div>
        <div class="col-lg-5" data-aos="fade-left">
          <div class="cr-stats">
            <div><strong><?= count($jobs) ?></strong><span>open <?= count($jobs) === 1 ? 'role' : 'roles' ?></span></div>
            <div><strong>Thane</strong><span>office · Maharashtra</span></div>
            <div><strong>4</strong><span>step hiring process</span></div>
            <div><strong>~1 week</strong><span>from interview to offer</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section" id="openings">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <span class="nm-eyebrow">Open roles</span>
        <h2>Current openings</h2>
        <p>Don't see the right role? Send a general application and we'll keep your CV on file.</p>
      </div>

      <?php if (!$jobs): ?>
        <div class="nm-empty" data-aos="fade-up">
          <i class="bi bi-briefcase"></i>
          <h3>No open roles right now</h3>
          <p>We're always happy to meet talented people. Send us your CV and we'll reach out when a matching role opens.</p>
          <button type="button" class="nm-btn nm-btn-primary" data-apply="">Send a general application</button>
        </div>
      <?php else: ?>
        <div class="bl-toolbar">
          <div class="bl-filters" role="group" aria-label="Filter by team">
            <button type="button" class="active" data-cat="">All teams</button>
            <?php foreach ($usedCategories as $id => $name): ?>
              <button type="button" data-cat="<?= $e($id) ?>"><?= $e($name) ?></button>
            <?php endforeach; ?>
          </div>
          <div class="d-flex flex-wrap" style="gap:10px">
            <?php if (count($types) > 1): ?>
              <select class="form-select cr-type" id="jobType" aria-label="Filter by job type">
                <option value="">All job types</option>
                <?php foreach ($types as $t): ?><option><?= $e($t) ?></option><?php endforeach; ?>
              </select>
            <?php endif; ?>
            <label class="bl-search"><i class="bi bi-search"></i><input type="search" id="jobSearch" placeholder="Search roles, skills, location" aria-label="Search roles"></label>
          </div>
        </div>

        <div class="cr-jobs" id="jobList">
          <?php foreach ($jobs as $job): $daysLeft = (int) ceil((strtotime($job['deadline']) - strtotime('today')) / 86400); ?>
            <details class="cr-job" data-cat="<?= $e($job['category']) ?>" data-type="<?= $e($job['type']) ?>"
                     data-text="<?= $e(strtolower($job['title'] . ' ' . $job['location'] . ' ' . $job['description'] . ' ' . implode(' ', $job['skills']))) ?>">
              <summary>
                <div class="cr-job-main">
                  <span class="cr-job-team"><?= $e($categories[$job['category']] ?? ucfirst($job['category'])) ?></span>
                  <h3><?= $e($job['title']) ?></h3>
                  <div class="cr-job-meta">
                    <span><i class="bi bi-geo-alt"></i> <?= $e($job['location']) ?></span>
                    <span><i class="bi bi-clock"></i> <?= $e($job['type']) ?></span>
                    <span><i class="bi bi-award"></i> <?= $e($job['experience']) ?></span>
                    <?php if ($job['salary']): ?><span><i class="bi bi-cash-stack"></i> <?= $e($job['salary']) ?></span><?php endif; ?>
                  </div>
                </div>
                <div class="cr-job-side">
                  <span class="cr-deadline <?= $daysLeft <= 7 ? 'soon' : '' ?>"><?= $daysLeft <= 0 ? 'Closes today' : 'Closes in ' . $daysLeft . ' day' . ($daysLeft === 1 ? '' : 's') ?></span>
                  <span class="cr-toggle">Details <i class="bi bi-chevron-down"></i></span>
                </div>
              </summary>
              <div class="cr-job-body">
                <p><?= nl2br($e($job['description'])) ?></p>
                <div class="row g-4">
                  <?php if ($job['responsibilities']): ?>
                    <div class="col-md-6"><h4>What you'll do</h4><ul><?php foreach ($job['responsibilities'] as $r): ?><li><?= $e($r) ?></li><?php endforeach; ?></ul></div>
                  <?php endif; ?>
                  <?php if ($job['requirements']): ?>
                    <div class="col-md-6"><h4>What we're looking for</h4><ul><?php foreach ($job['requirements'] as $r): ?><li><?= $e($r) ?></li><?php endforeach; ?></ul></div>
                  <?php endif; ?>
                </div>
                <?php if ($job['skills']): ?>
                  <div class="cr-skills"><?php foreach ($job['skills'] as $s): ?><span><?= $e($s) ?></span><?php endforeach; ?></div>
                <?php endif; ?>
                <div class="cr-job-foot">
                  <small class="text-secondary"><i class="bi bi-mortarboard"></i> <?= $e($job['education']) ?> · Apply by <?= date('j M Y', strtotime($job['deadline'])) ?></small>
                  <button type="button" class="nm-btn nm-btn-primary nm-btn-sm" data-apply="<?= (int) $job['id'] ?>" data-title="<?= $e($job['title']) ?>">Apply for this role</button>
                </div>
              </div>
            </details>
          <?php endforeach; ?>
        </div>
        <div class="nm-empty d-none" id="jobNoResults"><i class="bi bi-search"></i><h3>No roles match</h3><p>Try a different team or search term, or send a general application.</p></div>
      <?php endif; ?>
    </div>
  </section>

  <section class="section light-background">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <span class="nm-eyebrow">Why NM INFOCOM</span>
        <h2>A place to grow your career</h2>
      </div>
      <div class="row g-4">
        <?php foreach ($perks as $i => [$icon, $title, $text]): ?>
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
            <div class="wd-benefit"><i class="bi <?= $icon ?>"></i><div><h3><?= $title ?></h3><p><?= $text ?></p></div></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <span class="nm-eyebrow">Hiring process</span>
        <h2>Simple, quick and transparent</h2>
      </div>
      <div class="row g-4">
        <?php foreach ($steps as $i => [$title, $text]): ?>
          <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
            <div class="nm-step"><span class="nm-step-num">STEP <?= sprintf('%02d', $i + 1) ?></span><h3><?= $title ?></h3><p><?= $text ?></p></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>

<!-- Application form -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content nm-form" id="applyForm" method="post" action="data/job_applicant_data.php" enctype="multipart/form-data" novalidate>
      <div class="modal-header">
        <div><h5 class="modal-title" id="applyTitle">Apply</h5><small class="text-secondary" id="applyRole">General application</small></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="job_id" id="applyJobId">
        <div class="row g-3">
          <div class="col-12"><label class="form-label" for="apName">Full name</label><input class="form-control" id="apName" name="full_name" maxlength="255" autocomplete="name" required></div>
          <div class="col-md-6"><label class="form-label" for="apEmail">Email</label><input type="email" class="form-control" id="apEmail" name="email" maxlength="255" autocomplete="email" required></div>
          <div class="col-md-6"><label class="form-label" for="apPhone">Phone</label><input type="tel" class="form-control" id="apPhone" name="contact" maxlength="20" autocomplete="tel" required></div>
          <div class="col-12"><label class="form-label" for="apCity">Current city</label><input class="form-control" id="apCity" name="location" maxlength="255" autocomplete="address-level2" required></div>
          <div class="col-12">
            <label class="form-label" for="apCv">CV / résumé (PDF, max 5 MB)</label>
            <input type="file" class="form-control" id="apCv" name="resume" accept="application/pdf,.pdf" required>
          </div>
          <div class="nm-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
        </div>
        <div class="alert alert-danger d-none mt-3 mb-0" id="applyError" role="alert"></div>
        <div class="alert alert-success d-none mt-3 mb-0" id="applyDone" role="status">Thanks! Your application is in. Our HR team will be in touch if it's a match.</div>
      </div>
      <div class="modal-footer">
        <small class="text-secondary me-auto"><i class="bi bi-lock"></i> Only our HR team sees your details.</small>
        <button type="submit" id="applySubmit">Submit application</button>
      </div>
    </form>
  </div>
</div>

<script>
// Runs after the footer scripts (Bootstrap is loaded at the end of the page).
document.addEventListener('DOMContentLoaded', function () {
  // Filters
  const list = document.getElementById('jobList');
  if (list) {
    const jobs = [...list.children];
    const search = document.getElementById('jobSearch');
    const type = document.getElementById('jobType');
    const empty = document.getElementById('jobNoResults');
    let cat = '';
    const apply = () => {
      const q = search.value.trim().toLowerCase();
      let shown = 0;
      jobs.forEach((j) => {
        const ok = (!cat || j.dataset.cat === cat) && (!type || !type.value || j.dataset.type === type.value) && (!q || j.dataset.text.includes(q));
        j.classList.toggle('d-none', !ok);
        shown += ok ? 1 : 0;
      });
      empty.classList.toggle('d-none', shown > 0);
    };
    document.querySelectorAll('[data-cat]').forEach((b) => b.tagName === 'BUTTON' && b.addEventListener('click', () => {
      document.querySelectorAll('.bl-filters [data-cat]').forEach((x) => x.classList.toggle('active', x === b));
      cat = b.dataset.cat;
      apply();
    }));
    search.addEventListener('input', apply);
    type && type.addEventListener('change', apply);
  }

  // Application modal
  const modalEl = document.getElementById('applyModal');
  const modal = new bootstrap.Modal(modalEl);
  const form = document.getElementById('applyForm');
  const err = document.getElementById('applyError');
  const done = document.getElementById('applyDone');
  const submit = document.getElementById('applySubmit');
  document.querySelectorAll('[data-apply]').forEach((b) => b.addEventListener('click', (e) => {
    e.preventDefault();
    form.reset();
    err.classList.add('d-none'); done.classList.add('d-none');
    submit.classList.remove('d-none');
    document.getElementById('applyJobId').value = b.dataset.apply;
    document.getElementById('applyTitle').textContent = b.dataset.apply ? 'Apply for this role' : 'General application';
    document.getElementById('applyRole').textContent = b.dataset.title || 'We\'ll match you to future openings';
    modal.show();
  }));
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    err.classList.add('d-none');
    if (!form.checkValidity()) { form.reportValidity(); return; }
    const cv = document.getElementById('apCv').files[0];
    if (cv && cv.size > 5 * 1024 * 1024) { err.textContent = 'Your CV must be 5 MB or smaller.'; err.classList.remove('d-none'); return; }
    submit.disabled = true; submit.textContent = 'Sending…';
    try {
      const res = await fetch('data/job_applicant_data.php', { method: 'POST', body: new FormData(form) });
      const data = await res.json().catch(() => ({}));
      if (!res.ok || !data.success) throw new Error(data.message || 'Something went wrong. Please try again.');
      done.classList.remove('d-none');
      submit.classList.add('d-none');
    } catch (ex) {
      err.textContent = ex.message; err.classList.remove('d-none');
    } finally {
      submit.disabled = false; submit.textContent = 'Submit application';
    }
  });
});
</script>

<?php require "./components/bottom.php"; ?>
