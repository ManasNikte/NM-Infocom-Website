<?php
require_once __DIR__ . '/data/events_lib.php';

$upcoming = $past = [];
try {
    ['upcoming' => $upcoming, 'past' => $past] = nm_events(getDBConnection());
} catch (Exception $e) {
    error_log('Events.php: ' . $e->getMessage());
}
$next = $upcoming[0] ?? null;
$laterUpcoming = array_slice($upcoming, 1);
$years = array_values(array_unique(array_map(fn ($ev) => $ev['starts']->format('Y'), $past)));
$modes = array_values(array_unique(array_filter(array_map(fn ($ev) => $ev['event_mode'], $past))));
$e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
$modeIcon = fn ($mode) => ['virtual' => 'bi-camera-video', 'hybrid' => 'bi-broadcast', 'in-person' => 'bi-geo-alt'][strtolower((string) $mode)] ?? 'bi-calendar-event';

require "./components/top.php";
?>
<?php if ($upcoming): ?>
<script type="application/ld+json">
<?= json_encode(array_map(fn ($ev) => array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'Event',
    'name' => $ev['title'],
    'description' => $ev['event_description'],
    'startDate' => $ev['starts']->format(DATE_ATOM),
    'eventAttendanceMode' => 'https://schema.org/' . (['virtual' => 'OnlineEventAttendanceMode', 'hybrid' => 'MixedEventAttendanceMode'][strtolower((string) $ev['event_mode'])] ?? 'OfflineEventAttendanceMode'),
    'location' => $ev['event_location'] ?: null,
    'organizer' => ['@type' => 'Organization', 'name' => 'NM INFOCOM'],
    'url' => $ev['register'],
]), $upcoming), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>
</script>
<?php endif; ?>

<main class="main nm-events">
  <div class="page-title">
    <div class="container">
      <h1>Events</h1>
      <p>Workshops, webinars and conferences from NM INFOCOM and our technology partners.</p>
      <nav class="breadcrumbs"><ol><li><a href="index.php">Home</a></li><li class="current">Events</li></ol></nav>
    </div>
  </div>

  <!-- Upcoming -->
  <section class="section" id="upcoming">
    <div class="container">
      <div class="ev-head" data-aos="fade-up">
        <div><span class="nm-eyebrow">Upcoming</span><h2>What's next</h2></div>
        <span class="ev-count"><?= count($upcoming) ?> upcoming <?= count($upcoming) === 1 ? 'event' : 'events' ?></span>
      </div>

      <?php if (!$next): ?>
        <div class="nm-empty" data-aos="fade-up">
          <i class="bi bi-calendar2-week"></i>
          <h3>No upcoming events scheduled</h3>
          <p>New workshops and webinars are announced in our newsletter. Subscribe in the footer, or tell us what you'd like us to cover.</p>
          <a href="index.php#contact" class="nm-btn nm-btn-primary">Suggest a topic</a>
        </div>
      <?php else: ?>
        <article class="ev-next" data-aos="fade-up">
          <div class="ev-next-img">
            <?php if ($next['image']): ?><img src="<?= $e($next['image']) ?>" alt="<?= $e($next['title']) ?>"><?php endif; ?>
            <span class="ev-badge ev-badge-live">Next event</span>
          </div>
          <div class="ev-next-body">
            <div class="ev-tags">
              <?php if ($next['event_category']): ?><span class="bl-chip"><?= $e($next['event_category']) ?></span><?php endif; ?>
              <?php if ($next['event_mode']): ?><span class="ev-mode"><i class="bi <?= $modeIcon($next['event_mode']) ?>"></i> <?= $e($next['event_mode']) ?></span><?php endif; ?>
            </div>
            <h3><?= $e($next['title']) ?></h3>
            <?php if ($next['event_description']): ?><p><?= $e($next['event_description']) ?></p><?php endif; ?>
            <ul class="ev-facts">
              <li><i class="bi bi-calendar3"></i> <?= $next['starts']->format('l, j F Y') ?></li>
              <li><i class="bi bi-clock"></i> <?= $next['starts']->format('g:i A') ?> IST</li>
              <?php if ($next['event_location']): ?><li><i class="bi bi-geo-alt"></i> <?= $e($next['event_location']) ?></li><?php endif; ?>
              <?php if ($next['speakers']): ?><li><i class="bi bi-mic"></i> <?= $e(implode(', ', $next['speakers'])) ?></li><?php endif; ?>
            </ul>
            <div class="ev-countdown" data-starts="<?= $next['starts']->format(DATE_ATOM) ?>" aria-live="polite">
              <div><strong data-cd="d">–</strong><span>days</span></div>
              <div><strong data-cd="h">–</strong><span>hours</span></div>
              <div><strong data-cd="m">–</strong><span>minutes</span></div>
            </div>
            <div class="nm-hero-ctas mb-0">
              <?php if ($next['register']): ?>
                <a href="<?= $e($next['register']) ?>" target="_blank" rel="noopener" class="nm-btn nm-btn-primary">Register now <i class="bi bi-box-arrow-up-right"></i></a>
              <?php else: ?>
                <a href="index.php#contact" class="nm-btn nm-btn-primary">Reserve my spot</a>
              <?php endif; ?>
            </div>
          </div>
        </article>

        <?php if ($laterUpcoming): ?>
          <div class="row g-4 mt-1">
            <?php foreach ($laterUpcoming as $ev): ?>
              <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <article class="ev-card">
                  <div class="ev-card-img">
                    <?php if ($ev['image']): ?><img src="<?= $e($ev['image']) ?>" alt="<?= $e($ev['title']) ?>" loading="lazy"><?php endif; ?>
                    <div class="ev-date"><strong><?= $ev['starts']->format('j') ?></strong><span><?= $ev['starts']->format('M Y') ?></span></div>
                  </div>
                  <div class="ev-card-body">
                    <div class="ev-tags">
                      <?php if ($ev['event_category']): ?><span class="bl-chip"><?= $e($ev['event_category']) ?></span><?php endif; ?>
                      <?php if ($ev['event_mode']): ?><span class="ev-mode"><i class="bi <?= $modeIcon($ev['event_mode']) ?>"></i> <?= $e($ev['event_mode']) ?></span><?php endif; ?>
                    </div>
                    <h3><?= $e($ev['title']) ?></h3>
                    <p class="ev-when"><i class="bi bi-clock"></i> <?= $ev['starts']->format('D, j M · g:i A') ?> IST</p>
                    <?php if ($ev['register']): ?>
                      <a href="<?= $e($ev['register']) ?>" target="_blank" rel="noopener" class="nm-card-link">Register <i class="bi bi-arrow-right"></i></a>
                    <?php endif; ?>
                  </div>
                </article>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- Past -->
  <?php if ($past): ?>
    <section class="section light-background" id="past">
      <div class="container">
        <div class="ev-head" data-aos="fade-up">
          <div><span class="nm-eyebrow">Past events</span><h2>Where we've been</h2></div>
          <span class="ev-count"><?= count($past) ?> past <?= count($past) === 1 ? 'event' : 'events' ?></span>
        </div>

        <div class="bl-toolbar">
          <div class="bl-filters" role="group" aria-label="Filter by year">
            <button type="button" class="active" data-year="">All years</button>
            <?php foreach ($years as $y): ?><button type="button" data-year="<?= $e($y) ?>"><?= $e($y) ?></button><?php endforeach; ?>
          </div>
          <div class="d-flex flex-wrap" style="gap:10px">
            <?php if (count($modes) > 1): ?>
              <select class="form-select cr-type" id="eventMode" aria-label="Filter by format">
                <option value="">All formats</option>
                <?php foreach ($modes as $m): ?><option><?= $e($m) ?></option><?php endforeach; ?>
              </select>
            <?php endif; ?>
            <label class="bl-search"><i class="bi bi-search"></i><input type="search" id="eventSearch" placeholder="Search past events" aria-label="Search past events"></label>
          </div>
        </div>

        <div class="row g-4" id="pastGrid">
          <?php foreach ($past as $ev): ?>
            <div class="col-md-6 col-lg-4" data-year="<?= $ev['starts']->format('Y') ?>" data-mode="<?= $e($ev['event_mode']) ?>"
                 data-text="<?= $e(strtolower($ev['title'] . ' ' . $ev['event_category'] . ' ' . $ev['event_description'] . ' ' . implode(' ', $ev['speakers']))) ?>">
              <article class="ev-card ev-past">
                <div class="ev-card-img">
                  <?php if ($ev['image']): ?><img src="<?= $e($ev['image']) ?>" alt="<?= $e($ev['title']) ?>" loading="lazy"><?php endif; ?>
                  <div class="ev-date"><strong><?= $ev['starts']->format('j') ?></strong><span><?= $ev['starts']->format('M Y') ?></span></div>
                  <span class="ev-badge">Completed</span>
                </div>
                <div class="ev-card-body">
                  <div class="ev-tags">
                    <?php if ($ev['event_category']): ?><span class="bl-chip"><?= $e($ev['event_category']) ?></span><?php endif; ?>
                    <?php if ($ev['event_mode']): ?><span class="ev-mode"><i class="bi <?= $modeIcon($ev['event_mode']) ?>"></i> <?= $e($ev['event_mode']) ?></span><?php endif; ?>
                  </div>
                  <h3><?= $e($ev['title']) ?></h3>
                  <?php if ($ev['event_description']): ?><p><?= $e($ev['event_description']) ?></p><?php endif; ?>
                  <?php if ($ev['speakers']): ?><p class="ev-when"><i class="bi bi-mic"></i> <?= $e(implode(', ', $ev['speakers'])) ?></p><?php endif; ?>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="nm-empty d-none" id="pastNoResults"><i class="bi bi-search"></i><h3>No past events match</h3><p>Try another year or search term.</p></div>
      </div>
    </section>
  <?php endif; ?>
</main>

<script>
(function () {
  // Countdown to the next event
  const cd = document.querySelector('.ev-countdown');
  if (cd) {
    const starts = new Date(cd.dataset.starts).getTime();
    const tick = () => {
      const ms = Math.max(0, starts - Date.now());
      const d = Math.floor(ms / 864e5), h = Math.floor(ms / 36e5) % 24, m = Math.floor(ms / 6e4) % 60;
      cd.querySelector('[data-cd=d]').textContent = d;
      cd.querySelector('[data-cd=h]').textContent = h;
      cd.querySelector('[data-cd=m]').textContent = m;
      if (!ms) cd.innerHTML = '<div class="w-100"><strong>Happening now</strong></div>';
    };
    tick();
    setInterval(tick, 30000);
  }

  // Past event filters
  const grid = document.getElementById('pastGrid');
  if (!grid) return;
  const items = [...grid.children];
  const search = document.getElementById('eventSearch');
  const mode = document.getElementById('eventMode');
  const empty = document.getElementById('pastNoResults');
  let year = '';
  const apply = () => {
    const q = search.value.trim().toLowerCase();
    let shown = 0;
    items.forEach((el) => {
      const ok = (!year || el.dataset.year === year) && (!mode || !mode.value || el.dataset.mode === mode.value) && (!q || el.dataset.text.includes(q));
      el.classList.toggle('d-none', !ok);
      shown += ok ? 1 : 0;
    });
    empty.classList.toggle('d-none', shown > 0);
  };
  document.querySelectorAll('[data-year]').forEach((b) => b.tagName === 'BUTTON' && b.addEventListener('click', () => {
    document.querySelectorAll('.bl-filters [data-year]').forEach((x) => x.classList.toggle('active', x === b));
    year = b.dataset.year;
    apply();
  }));
  search.addEventListener('input', apply);
  mode && mode.addEventListener('change', apply);
})();
</script>

<?php require "./components/bottom.php"; ?>
