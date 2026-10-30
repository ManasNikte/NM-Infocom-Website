<?php
// Admin: open any manager or employee desk and use its tools (see crm_admin_workspace_token in config/auth.php).
$adminHeading = 'Workspaces';
require_once './top.php';

$desks = [
    ['Managers', 'manager/HR/dashboard.php', 'HR Manager', 'fas fa-user-tie', 'violet',
     ['Hire: post jobs, shortlist or reject applicants', 'Add staff and send their login emails', 'Approve or reject team leave', 'HR dashboard and applicant trends']],
    ['Managers', 'manager/marketing/dashboard.php', 'Marketing Manager', 'fas fa-bullhorn', 'blue',
     ['Team task board: assign and track tasks', 'All marketing leads, remarks and status', 'Approve or reject team leave', 'Marketing dashboard and custom charts']],
    ['Managers', 'manager/sales/dashboard.php', 'Sales Manager', 'fas fa-chart-line', 'green',
     ['Sales pipeline and deal outcomes', 'Assign leads and tasks to the sales team', 'Approve or reject team leave', 'Sales dashboard and monthly progress']],
    ['Managers', 'manager/purchase/dashboard.php', 'Purchase Manager', 'fas fa-truck', 'amber',
     ['Vendors: add, edit, allot and remove', 'Purchase orders', 'Team tasks and leave approvals', 'Purchase dashboard']],
    ['Managers', 'manager/website/dashboard.php', 'Website Manager', 'fas fa-globe', 'teal',
     ['Blog posts, events, products and FAQs', 'Reviews, contact messages and enquiries', 'Hero slides, team, stats, client logos', 'Newsletter subscribers']],
    ['Employees', 'employee/marketing/main.php', 'Marketing Employee', 'fas fa-bullseye', 'blue',
     ['Add leads and update their status', 'Personal task list', 'Leave requests']],
    ['Employees', 'employee/sales/main.php', 'Sales Employee', 'fas fa-handshake', 'green',
     ['Work assigned leads: responses and remarks', 'Personal task list', 'Leave requests']],
    ['Employees', 'employee/purchase/main.php', 'Purchase Employee', 'fas fa-boxes', 'amber',
     ['Add and update vendors', 'Personal task list', 'Leave requests']],
];
?>
<div class="main-content">
  <div class="section__content">
    <div class="container-fluid px-4 py-4">
      <div class="crm-hero">
        <div>
          <h2>Work as any role</h2>
          <p>Open a department desk to use its tools exactly as its manager or employee would. Everything you change is recorded under your admin account.</p>
        </div>
      </div>

      <?php foreach (['Managers', 'Employees'] as $group): ?>
        <h3 class="ws-group"><?= $group === 'Managers' ? 'Manager desks' : 'Employee desks' ?></h3>
        <div class="ws-grid">
          <?php foreach ($desks as [$g, $href, $title, $icon, $tone, $tools]): if ($g !== $group) continue; ?>
            <a class="ws-card adm-<?= $tone ?>" href="../<?= $href ?>">
              <span class="ws-icon"><i class="<?= $icon ?>" aria-hidden="true"></i></span>
              <h4><?= htmlspecialchars($title) ?></h4>
              <ul><?php foreach ($tools as $t): ?><li><?= htmlspecialchars($t) ?></li><?php endforeach; ?></ul>
              <span class="ws-open">Open desk <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<style>
  .ws-group { font: 700 .8rem/1.2 var(--crm-font) !important; letter-spacing: .1em; text-transform: uppercase; color: var(--crm-muted) !important; margin: 6px 0 12px; }
  .ws-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; margin-bottom: 26px; }
  .ws-card {
    --tone: #3b82f6; display: flex; flex-direction: column; padding: 20px; border-radius: 18px; background: var(--crm-surface);
    border: 1px solid var(--crm-border); box-shadow: var(--crm-shadow); color: var(--crm-text) !important; text-decoration: none !important;
    transition: transform .2s, border-color .2s, box-shadow .2s;
  }
  .ws-card:hover { transform: translateY(-3px); border-color: var(--tone); box-shadow: 0 16px 32px -20px var(--tone); }
  .ws-icon { width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center; background: var(--tone-soft); color: var(--tone); font-size: 1.1rem; margin-bottom: 14px; }
  .ws-card h4 { font: 800 1.05rem/1.3 var(--crm-heading-font); color: var(--crm-heading) !important; margin: 0 0 10px; }
  .ws-card ul { margin: 0 0 16px; padding-left: 18px; font-size: .86rem; color: var(--crm-muted); flex: 1; }
  .ws-card li { margin-bottom: 4px; }
  .ws-open { font-weight: 700; font-size: .86rem; color: var(--tone); }
  .ws-open i { margin-left: 4px; transition: transform .2s; }
  .ws-card:hover .ws-open i { transform: translateX(3px); }
</style>

<?php require 'bottom.php'; ?>
