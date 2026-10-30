<?php
/**
 * Greeting banner + KPI tiles at the top of the manager and employee dashboards.
 * Included after layout/top.php, so $section, $user and $crm are set.
 * Numbers come from shared/dashboard_summary.php.
 */
$heroDept = $section['sub_role'];
$heroIsManager = $section['role'] === 'Manager';
$heroDeptName = $heroDept === 'hr' ? 'HR' : ucfirst((string) $heroDept);
$heroHour = (int) (new DateTime('now', new DateTimeZone('Asia/Kolkata')))->format('G');
$heroGreeting = $heroHour < 12 ? 'Good morning' : ($heroHour < 17 ? 'Good afternoon' : 'Good evening');
$heroFirstName = preg_split('/\s+/', trim($user['name'] ?? ''))[0] ?? '';

// [total key, label, icon, tone, link or null, secondary "key|label" or null]
$heroTiles = $heroIsManager
    ? [
        ['tasks_pending', 'Team tasks pending', 'far fa-clock', 'amber', null, 'tasks_in_progress|in progress'],
        ['tasks_overdue', 'Team tasks overdue', 'fas fa-exclamation-triangle', 'rose', null, 'tasks_due_week|due this week'],
        ['completion_rate', 'Team completion rate', 'fas fa-chart-line', 'green', null, 'tasks_completed|completed'],
        ['leaves_pending', 'Team leave requests', 'fas fa-calendar-alt', 'violet', 'leave_portal.php', 'team_size|in team'],
    ]
    : [
        ['tasks_pending', 'My tasks pending', 'far fa-clock', 'amber', null, 'tasks_in_progress|in progress'],
        ['tasks_overdue', 'Overdue tasks', 'fas fa-exclamation-triangle', 'rose', null, 'tasks_due_week|due this week'],
        ['completion_rate', 'My completion rate', 'fas fa-chart-line', 'green', null, 'tasks_completed|completed'],
        ['my_leaves_pending', 'My leave requests pending', 'fas fa-calendar-alt', 'violet', 'leave_portal.php', null],
    ];
$leadsPage = $heroDept === 'sales' ? 'sales.php' : 'leads.php';
$deptTiles = [
    'marketing' => [['leads_open', $heroIsManager ? 'Open leads (team)' : 'My open leads', 'fas fa-bullseye', 'blue', $leadsPage, 'leads_month|added this month'],
                    ['leads_won', 'Leads won', 'fas fa-trophy', 'teal', $leadsPage, 'leads_total|total']],
    'sales' => [['leads_open', $heroIsManager ? 'Open leads (team)' : 'My open leads', 'fas fa-bullseye', 'blue', $leadsPage, 'leads_month|new this month'],
                ['leads_won', 'Deals won', 'fas fa-trophy', 'teal', $leadsPage, 'leads_total|total']],
    'purchase' => [['vendors', $heroIsManager ? 'Vendors' : 'Vendors I added', 'fas fa-truck', 'blue', 'vendors.php', 'vendors_month|added this month']],
    'hr' => [['open_jobs', 'Open jobs', 'fas fa-briefcase', 'blue', 'career.php', 'applicants|applicants'],
             ['staff_active', 'Active staff', 'fas fa-users', 'teal', 'emp_list.php', 'company_leaves_pending|leaves pending (all)']],
    'website' => [['contacts_pending', 'Contact messages pending', 'fas fa-envelope', 'blue', 'contact_submits.php', 'contacts_total|total'],
                  ['enquiries', 'Product enquiries', 'fas fa-box', 'teal', 'all_enquiries.php', 'products|products'],
                  ['subscribers', 'Newsletter subscribers', 'fas fa-newspaper', 'violet', 'nm_newsletter.php', null],
                  ['reviews_private', 'Reviews awaiting approval', 'fas fa-star', 'amber', 'nm_reviews.php', null]],
];
if ($heroDept === 'website') {
    // The website team has no task-tracking employees; show the site inbox first.
    $heroTiles = array_merge($deptTiles['website'], [$heroTiles[0], $heroTiles[3]]);
} else {
    $heroTiles = array_merge($heroTiles, $deptTiles[$heroDept] ?? []);
}
?>
<div class="crm-hero">
  <div>
    <h2><?= htmlspecialchars($heroGreeting . ($heroFirstName !== '' ? ', ' . $heroFirstName : '')) ?></h2>
    <p><?= htmlspecialchars($heroDeptName . ($heroIsManager ? ' manager dashboard: your team at a glance.' : ' workspace: your tasks and progress at a glance.')) ?></p>
  </div>
  <div class="crm-hero-actions">
    <a class="btn btn-sm" href="leave_portal.php"><i class="fas fa-calendar-plus mr-1"></i> Leave portal</a>
    <a class="btn btn-sm" href="profile.php"><i class="fas fa-user mr-1"></i> My profile</a>
  </div>
</div>

<div id="crmSummaryError" class="alert alert-danger d-none"></div>
<div class="adm-stats" id="crmSummary">
  <?php foreach ($heroTiles as [$key, $label, $icon, $tone, $href, $sub]):
      $tag = $href ? 'a' : 'div'; ?>
    <<?= $tag ?> class="adm-stat adm-<?= $tone ?>"<?= $href ? ' href="' . htmlspecialchars($href) . '"' : '' ?>>
      <i class="<?= $icon ?> adm-stat-icon" aria-hidden="true"></i>
      <span data-summary="<?= $key ?>"<?= $key === 'completion_rate' ? ' data-suffix="%"' : '' ?>>–</span>
      <small><?= htmlspecialchars($label) ?><?php if ($sub): [$subKey, $subLabel] = explode('|', $sub); ?> · <b data-summary="<?= $subKey ?>">–</b> <?= htmlspecialchars($subLabel) ?><?php endif; ?></small>
    </<?= $tag ?>>
  <?php endforeach; ?>
</div>
<script>
  // Fill the KPI tiles (counts animate up); refreshed by crmLiveRefresh instead of polling.
  function crmLoadSummary() {
    fetch('<?= $crm ?>shared/dashboard_summary.php', { credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data.success) throw new Error(data.message);
        document.getElementById('crmSummaryError').classList.add('d-none');
        document.querySelectorAll('#crmSummary [data-summary]').forEach(function (el) {
          var target = Number(data.totals[el.getAttribute('data-summary')] || 0), suffix = el.getAttribute('data-suffix') || '';
          var start = performance.now(), dur = 700;
          (function step(now) {
            var p = Math.min(1, (now - start) / dur), v = Math.round(target * (1 - Math.pow(1 - p, 3)));
            el.textContent = v.toLocaleString('en-IN') + suffix;
            if (p < 1) requestAnimationFrame(step);
          })(start);
        });
      })
      .catch(function (e) {
        var box = document.getElementById('crmSummaryError');
        box.textContent = 'Could not load the summary numbers. ' + (e && e.message ? e.message : '');
        box.classList.remove('d-none');
      });
  }
  document.addEventListener('DOMContentLoaded', function () {
    crmLoadSummary();
    crmLiveRefresh(crmLoadSummary);
  });
</script>
