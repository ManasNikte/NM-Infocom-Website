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
$roleLabel = $section['role'] === 'Admin' ? 'Administrator' : $section['role'] . ' · ' . ($section['sub_role'] === 'hr' ? 'HR' : ucfirst((string) $section['sub_role']));
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
  <link href="<?= $crm ?>layout/layout.css?v=15" rel="stylesheet" media="all" />
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
          <?php $renderNav(); ?>
        </ul>
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
