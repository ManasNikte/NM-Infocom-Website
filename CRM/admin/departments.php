<?php require_once './top.php'; ?>

<div class="main-content">
  <div class="section__content">
    <div class="container-fluid px-4 py-4">
      <div class="crm-hero">
        <div>
          <h2>Departments</h2>
          <p>Staff, workload and pipeline for each team.</p>
        </div>
        <div class="dept-tabs" id="deptTabs">
          <?php foreach (['marketing', 'sales', 'purchase', 'website', 'hr'] as $d): ?>
            <button type="button" class="btn btn-outline-primary btn-sm" data-dept="<?= $d ?>"><?= $d === 'hr' ? 'HR' : ucfirst($d) ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div id="admError" class="alert alert-danger d-none"></div>

      <div class="adm-stats">
        <div class="adm-stat adm-blue"><i class="fas fa-users adm-stat-icon" aria-hidden="true"></i><span data-total="active_staff">–</span><small>Active staff · <b data-total="inactive_staff">–</b> left</small></div>
        <div class="adm-stat adm-amber"><i class="fas fa-tasks adm-stat-icon" aria-hidden="true"></i><span data-total="tasks_open">–</span><small>Open tasks · <b data-total="tasks_overdue">–</b> overdue</small></div>
        <div class="adm-stat adm-teal"><i class="fas fa-check-circle adm-stat-icon" aria-hidden="true"></i><span data-total="tasks_completed">–</span><small>Tasks completed</small></div>
        <div class="adm-stat adm-violet"><i class="fas fa-plus-circle adm-stat-icon" aria-hidden="true"></i><span data-total="leads_added">–</span><small>Leads added</small></div>
        <div class="adm-stat adm-blue"><i class="fas fa-bullseye adm-stat-icon" aria-hidden="true"></i><span data-total="leads_assigned">–</span><small>Leads assigned · <b data-total="leads_won">–</b> won</small></div>
        <div class="adm-stat adm-teal"><i class="fas fa-truck adm-stat-icon" aria-hidden="true"></i><span data-total="vendors_added">–</span><small>Vendors added</small></div>
      </div>

      <div class="adm-grid adm-grid-2">
        <div class="adm-card"><h4>Tasks by status</h4><div class="adm-chart"><canvas id="deptTasks"></canvas></div></div>
        <div class="adm-card"><h4>Department leads by status</h4><div class="adm-chart"><canvas id="deptLeads"></canvas></div></div>
      </div>

      <div class="adm-card">
        <h4>Staff</h4>
        <div class="table-responsive">
          <table class="table table-sm">
            <thead><tr>
              <th>Name</th><th>Role</th><th>Status</th><th>Open tasks</th><th>Overdue</th><th>Done</th>
              <th>Leads added</th><th>Leads assigned</th><th>Won</th><th>Vendors</th><th>Pending leave</th><th>Last login</th>
            </tr></thead>
            <tbody id="deptStaff"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.adm-card td, .adm-card th { white-space: nowrap; }
</style>

<?php require 'bottom.php'; ?>

<script>
(function () {
  // Chart.js 4 and the shared theme (layout/crm-charts.js) are loaded by the layout.
  const p = window.crmCharts.palette;
  const palette = [p[0], p[2], p[4], p[6], p[8], p[10]];
  const charts = {};
  const esc = (v) => $('<div>').text(v == null ? '' : v).html();
  const title = (s) => String(s).replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());

  function doughnut(id, counts) {
    const labels = Object.keys(counts);
    if (charts[id]) charts[id].destroy();
    charts[id] = new Chart(document.getElementById(id), {
      type: 'doughnut',
      data: { labels: labels.map(title), datasets: [{ data: labels.map((k) => counts[k]), backgroundColor: palette }] },
      options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } },
    });
  }

  function render(data) {
    $('[data-total]').each(function () { $(this).text(data.totals[$(this).data('total')]); });
    doughnut('deptTasks', data.charts.tasks_by_status);
    doughnut('deptLeads', data.charts.leads_by_status);

    const rows = data.staff.map((m) => {
      const badge = m.status === 'active' ? 'badge-active' : 'badge-inactive';
      return '<tr>' + [
        esc(m.name), esc(m.role), '<span class="badge ' + badge + '">' + esc(title(m.status)) + '</span>',
        m.tasks_open, m.tasks_overdue, m.tasks_completed, m.leads_added, m.leads_assigned, m.leads_won,
        m.vendors_added, m.leaves_pending, esc(m.last_login ? m.last_login.slice(0, 16) : 'Never'),
      ].map((c) => '<td>' + c + '</td>').join('') + '</tr>';
    });
    $('#deptStaff').html(rows.join('') || '<tr><td colspan="12" class="adm-empty">No staff in this department</td></tr>');
  }

  function load(dept) {
    $('#deptTabs button').removeClass('active').filter('[data-dept="' + dept + '"]').addClass('active');
    history.replaceState(null, '', '?dept=' + dept);
    $.getJSON('data/department_data.php', { dept })
      .done((data) => {
        if (!data.success) return $('#admError').removeClass('d-none').text(data.message);
        $('#admError').addClass('d-none');
        render(data);
      })
      .fail((xhr) => {
        $('#admError').removeClass('d-none').text((xhr.responseJSON && xhr.responseJSON.message) || 'Could not load department data.');
      });
  }

  $('#deptTabs').on('click', 'button', function () { load($(this).data('dept')); });
  $(() => load(new URLSearchParams(location.search).get('dept') || 'marketing'));
  crmLiveRefresh(() => load(new URLSearchParams(location.search).get('dept') || 'marketing'));
})();
</script>
