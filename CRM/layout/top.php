<?php
/**
 * Shared page shell for every CRM section (admin, managers, employees).
 *
 * The including section's top.php sets $section before requiring this file:
 *   'role'     => 'Admin' | 'Manager' | 'Employee'
 *   'sub_role' => department ('sales', 'hr', ...) or null for Admin
 *   'title'    => heading shown in the desktop header
 *   'nav'      => [[href, icon class, label], ...]
 *   'base'     => relative path from the page to CRM/ ('../' or '../../')
 *   'head'     => optional extra markup for <head>
 *
 * Afterwards pages can use $conn, $user, $user_id, $role, $sub_role and $auth.
 */
require_once __DIR__ . '/../config/auth.php';

$auth = crm_require_page($section['role'], $section['sub_role'] ?? null);
$db = new Database();
$conn = $db->getConnection();
$user = crm_current_user($conn);
$user_id = $user['id'] ?? null;
// An admin working inside a department workspace uses that role's view of the data (see crm_admin_workspace_token).
$actingAdmin = !empty($auth->acting_admin);
if ($actingAdmin && $user) {
    $user['role'] = $auth->role;
    $user['sub_role'] = $auth->sub_role;
}
$role = $user['role'] ?? null;
$sub_role = $user['sub_role'] ?? null;

$crm = $section['base'];
$logoutUrl = $crm . '../logout.php';
$currentPage = basename($_SERVER['SCRIPT_NAME']);

$renderNav = function () use ($section, $currentPage) {
    foreach ($section['nav'] as [$href, $icon, $label]) {
        $isActive = basename($href) === $currentPage;
        printf("<li><a class=\"crm-nav-link%s\" href=\"%s\"%s><i class=\"%s\"></i><span>%s</span></a></li>\n",
               $isActive ? ' active' : '', htmlspecialchars($href), $isActive ? ' aria-current="page"' : '',
               htmlspecialchars($icon), htmlspecialchars($label));
    }
};
// Page heading: the active nav item's label, else the section title.
$pageHeading = $section['title'];
foreach ($section['nav'] as [$href, , $label]) {
    if (basename($href) === $currentPage) {
        $pageHeading = $label;
    }
}
$pageHeading = $section['heading'] ?? $pageHeading;
$roleLabel = $section['role'] === 'Admin' ? 'Administrator' : $section['role'] . ' · ' . ($section['sub_role'] === 'hr' ? 'HR' : ucfirst((string) $section['sub_role']));
// Workspaces an admin can open: every manager desk, and the employee desks that exist.
$crmWorkspaces = [
    'Managers' => ['manager/HR/dashboard.php' => 'HR Manager', 'manager/marketing/dashboard.php' => 'Marketing Manager',
                   'manager/sales/dashboard.php' => 'Sales Manager', 'manager/purchase/dashboard.php' => 'Purchase Manager',
                   'manager/website/dashboard.php' => 'Website Manager'],
    'Employees' => ['employee/marketing/main.php' => 'Marketing Employee', 'employee/sales/main.php' => 'Sales Employee',
                    'employee/purchase/main.php' => 'Purchase Employee'],
];
$nameParts = preg_split('/\s+/', trim($user['name'] ?? '?'));
$initials = strtoupper(mb_substr($nameParts[0], 0, 1) . (count($nameParts) > 1 ? mb_substr(end($nameParts), 0, 1) : ''));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <script>
    // Apply the saved (or system) colour theme before anything paints.
    (function () {
      var t = null;
      try { t = localStorage.getItem('crm-theme'); } catch (e) {}
      if (t !== 'light' && t !== 'dark') t = window.matchMedia && matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      document.documentElement.setAttribute('data-theme', t);
    })();
  </script>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" type="image/png" href="<?= $crm ?>images/icon/favicon.png" />
  <title><?= htmlspecialchars($section['title']) ?> | NM INFOCOM CRM</title>

  <link href="<?= $crm ?>css/font-face.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <link href="<?= $crm ?>vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/animsition/animsition.min.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/wow/animate.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/slick/slick.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/select2/select2.min.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all" />
  <link href="<?= $crm ?>css/theme.css" rel="stylesheet" media="all" />
  <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet" />
  <link href="<?= $crm ?>layout/layout.css?v=16" rel="stylesheet" media="all" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script src="<?= $crm ?>layout/crm-charts.js?v=6"></script>
  <script>
    // HTML-escape a value before putting it into markup (template literals, innerHTML).
    window.esc = function (v) {
      return v == null ? '' : String(v).replace(/[&<>"'`]/g, function (c) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '`': '&#96;' }[c];
      });
    };
  </script>
  <?= $section['head'] ?? '' ?>
</head>

<body class="crm">
  <div class="page-wrapper crm-app">
    <aside class="crm-sidebar" id="crmSidebar" aria-label="Main navigation">
      <a class="crm-brand" href="<?= htmlspecialchars($section['nav'][0][0]) ?>">
        <img src="<?= $crm ?>images/icon/favicon.png" alt="" />
        <span>NM <b>INFOCOM</b></span>
      </a>
      <div class="crm-nav-label"><?= htmlspecialchars($roleLabel) ?></div>
      <nav>
        <ul class="crm-nav">
          <?php if ($actingAdmin): ?>
            <li><a class="crm-nav-link crm-nav-back" href="<?= $crm ?>admin/dashboard.php"><i class="fas fa-arrow-left"></i><span>Admin dashboard</span></a></li>
          <?php endif; ?>
          <?php $renderNav(); ?>
        </ul>
        <?php if (($section['role'] ?? '') === 'Admin'): ?>
          <div class="crm-nav-label">Work as</div>
          <ul class="crm-nav">
            <li><a class="crm-nav-link<?= $currentPage === 'workspaces.php' ? ' active' : '' ?>" href="<?= $crm ?>admin/workspaces.php"><i class="fas fa-th-large"></i><span>All workspaces</span></a></li>
            <?php foreach ($crmWorkspaces['Managers'] as $href => $label): ?>
              <li><a class="crm-nav-link" href="<?= $crm . $href ?>"><i class="fas fa-briefcase"></i><span><?= $label ?></span></a></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </nav>
      <div class="crm-user">
        <span class="crm-avatar" aria-hidden="true"><?= htmlspecialchars($initials) ?></span>
        <div class="crm-user-meta">
          <strong><?= htmlspecialchars($user['name'] ?? '') ?></strong>
          <span><?= htmlspecialchars($user['email'] ?? '') ?></span>
        </div>
        <a class="crm-logout" href="<?= $logoutUrl ?>" title="Sign out" aria-label="Sign out"><i class="fas fa-sign-out-alt"></i></a>
      </div>
    </aside>
    <div class="crm-backdrop" data-crm-close></div>

    <div class="page-container crm-main">
      <header class="crm-topbar">
        <button class="crm-menu-btn" type="button" aria-label="Open menu" aria-controls="crmSidebar" data-crm-open><i class="fas fa-bars"></i></button>
        <div class="crm-topbar-title">
          <h1><?= htmlspecialchars($pageHeading) ?></h1>
          <span><?= htmlspecialchars($section['title']) ?> · <?= date('l, j F Y') ?></span>
        </div>
        <button class="crm-theme-btn" type="button" data-crm-theme aria-label="Switch to dark mode" title="Toggle dark / light mode">
          <i class="fas fa-moon crm-theme-moon" aria-hidden="true"></i><i class="fas fa-sun crm-theme-sun" aria-hidden="true"></i>
        </button>
        <div class="crm-chip">
          <span class="crm-avatar crm-avatar-sm" aria-hidden="true"><?= htmlspecialchars($initials) ?></span>
          <span class="crm-chip-name"><?= htmlspecialchars($user['name'] ?? '') ?></span>
        </div>
      </header>
      <?php if ($actingAdmin): ?>
        <div class="crm-acting" role="status">
          <span class="crm-acting-icon"><i class="fas fa-user-shield" aria-hidden="true"></i></span>
          <span class="crm-acting-text">Admin mode: you're working as <b><?= htmlspecialchars($roleLabel) ?></b>. Changes are recorded under your own account.</span>
          <label class="crm-acting-switch"><span class="sr-only">Switch workspace</span>
            <select onchange="if (this.value) location.href = this.value" aria-label="Switch workspace">
              <option value="">Switch workspace…</option>
              <?php foreach ($crmWorkspaces as $group => $items): ?>
                <optgroup label="<?= $group ?>">
                  <?php foreach ($items as $href => $label): ?><option value="<?= $crm . $href ?>"><?= $label ?></option><?php endforeach; ?>
                </optgroup>
              <?php endforeach; ?>
            </select>
          </label>
          <a class="btn btn-sm crm-acting-back" href="<?= $crm ?>admin/dashboard.php"><i class="fas fa-arrow-left mr-1"></i> Back to admin</a>
        </div>
      <?php endif; ?>
