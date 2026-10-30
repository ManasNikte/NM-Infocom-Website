<?php require_once './top.php'; ?>

<div class="main-content">
  <div class="section__content">
    <div class="container-fluid px-4 py-4">
      <?php $h = (int) (new DateTime('now', new DateTimeZone('Asia/Kolkata')))->format('G'); ?>
      <div class="crm-hero">
        <div>
          <h2><?= $h < 12 ? 'Good morning' : ($h < 17 ? 'Good afternoon' : 'Good evening') ?>, <?= htmlspecialchars(preg_split('/\s+/', trim($user['name'] ?? 'Admin'))[0]) ?></h2>
          <p>Company-wide overview: people, pipeline, work and website activity.</p>
        </div>
        <div class="crm-hero-actions">
        <a class="btn btn-sm" href="workspaces.php"><i class="fas fa-th-large mr-1"></i> Work as any role</a>
        <label class="adm-range">Trend range
          <select id="admRange" class="form-control form-control-sm">
            <option value="6">Last 6 months</option>
            <option value="12" selected>Last 12 months</option>
            <option value="24">Last 24 months</option>
          </select>
        </label>
        </div>
      </div>

      <div id="admError" class="alert alert-danger d-none"></div>

      <!-- Headline numbers; each card links to the page that manages it -->
      <div class="adm-stats">
        <a class="adm-stat adm-blue" href="emp_list.php"><i class="fas fa-users adm-stat-icon" aria-hidden="true"></i><span data-total="employees">–</span><small>Active employees · <b data-total="managers">–</b> managers</small></a>
        <a class="adm-stat adm-violet" href="leads.php"><i class="fas fa-bullseye adm-stat-icon" aria-hidden="true"></i><span data-total="open_leads">–</span><small>Open leads of <b data-total="leads">–</b></small></a>
        <a class="adm-stat adm-teal" href="vendors.php"><i class="fas fa-truck adm-stat-icon" aria-hidden="true"></i><span data-total="vendors">–</span><small>Vendors</small></a>
        <a class="adm-stat adm-amber" href="task.php"><i class="fas fa-tasks adm-stat-icon" aria-hidden="true"></i><span data-total="open_tasks">–</span><small>Open tasks · <b data-total="overdue_tasks">–</b> overdue</small></a>
        <a class="adm-stat adm-rose" href="leave_portal.php"><i class="fas fa-calendar-alt adm-stat-icon" aria-hidden="true"></i><span data-total="pending_leaves">–</span><small>Leave requests pending</small></a>
        <a class="adm-stat adm-blue" href="careers.php"><i class="fas fa-briefcase adm-stat-icon" aria-hidden="true"></i><span data-total="job_applicants">–</span><small>Job applicants · <b data-total="open_jobs">–</b> open jobs</small></a>
        <div class="adm-stat adm-teal"><i class="fas fa-cube adm-stat-icon" aria-hidden="true"></i><span data-total="product_enquiries">–</span><small>Product enquiries</small></div>
        <div class="adm-stat adm-violet"><i class="fas fa-envelope adm-stat-icon" aria-hidden="true"></i><span data-total="contact_submissions">–</span><small>Contact submissions · <b data-total="pending_contacts">–</b> pending</small></div>
      </div>

      <div class="adm-grid">
        <div class="adm-card adm-wide"><h4>New leads per month</h4><div class="adm-chart"><canvas id="admLeadsMonthly"></canvas></div></div>
        <div class="adm-card"><h4>Leads by status</h4><div class="adm-chart"><canvas id="admLeadsStatus"></canvas></div></div>
        <div class="adm-card"><h4>Lead responses</h4><div class="adm-chart"><canvas id="admLeadsResponse"></canvas></div></div>
        <div class="adm-card adm-wide"><h4>Tasks by department</h4><div class="adm-chart"><canvas id="admTasksDept"></canvas></div></div>
        <div class="adm-card"><h4>Staff by department</h4><div class="adm-chart"><canvas id="admStaff"></canvas></div></div>
        <div class="adm-card"><h4>Leave requests</h4><div class="adm-chart"><canvas id="admLeaves"></canvas></div></div>
        <div class="adm-card">
          <h4>Most enquired products</h4>
          <table class="table table-sm"><thead><tr><th>Product</th><th>Enquiries</th></tr></thead>
            <tbody id="admTopProducts"></tbody></table>
        </div>
        <div class="adm-card adm-wide"><h4>Website activity per month</h4><div class="adm-chart"><canvas id="admWebMonthly"></canvas></div></div>
        <div class="adm-card"><h4>Job applicants</h4><div class="adm-chart"><canvas id="admApplicants"></canvas></div></div>
      </div>

      <div class="adm-grid">
        <div class="adm-card adm-wide">
          <h4>Latest leads <a href="leads.php">View all</a></h4>
          <table class="table table-sm"><thead><tr><th>Name</th><th>Product</th><th>Status</th><th>Added</th></tr></thead>
            <tbody id="admRecentLeads"></tbody></table>
        </div>
        <div class="adm-card">
          <h4>Pending leaves <a href="leave_portal.php">Review</a></h4>
          <table class="table table-sm"><thead><tr><th>Employee</th><th>From</th><th>To</th></tr></thead>
            <tbody id="admPendingLeaves"></tbody></table>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require 'bottom.php'; ?>

<script>
(function () {
  // Chart.js 4 and the shared theme (layout/crm-charts.js) are loaded by the layout.
  const palette = window.crmCharts.palette;
  const C = { indigo: palette[0], blue: palette[1], sky: palette[2], green: palette[4], amber: palette[6], rose: palette[8], violet: palette[10] };
  const mix = [C.indigo, C.sky, C.green, C.amber, C.rose, C.violet, palette[3], palette[7]];
  const charts = {};
  const esc = (v) => $('<div>').text(v == null ? '' : v).html();
  const title = (s) => String(s).replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());

  function draw(id, config) {
    if (charts[id]) charts[id].destroy();
    config.options = Object.assign({ responsive: true, maintainAspectRatio: false }, config.options);
    charts[id] = new Chart(document.getElementById(id), config);
  }

  function doughnut(id, counts) {
    const labels = Object.keys(counts);
    draw(id, {
      type: 'doughnut',
      data: { labels: labels.map(title), datasets: [{ data: labels.map((k) => counts[k]), backgroundColor: mix }] },
      options: { plugins: { legend: { position: 'bottom' } } },
    });
  }

  // Whole-number ticks only (counts).
  const intTicks = { precision: 0 };
  const intAxis = () => ({ y: { beginAtZero: true, ticks: intTicks } });

  function rows(tbodyId, items, cols, emptyText) {
    const html = items.length
      ? items.map((it) => '<tr>' + cols.map((c) => '<td>' + esc(c(it)) + '</td>').join('') + '</tr>').join('')
      : '<tr><td colspan="' + cols.length + '" class="adm-empty">' + emptyText + '</td></tr>';
    $('#' + tbodyId).html(html);
  }

  function render(data) {
    $('[data-total]').each(function () {
      $(this).text(Number(data.totals[$(this).data('total')]).toLocaleString());
    });

    const c = data.charts;
    draw('admLeadsMonthly', {
      type: 'bar',
      data: { labels: c.leads_per_month.labels, datasets: [{ label: 'Leads', data: c.leads_per_month.values, backgroundColor: C.indigo }] },
      options: { plugins: { legend: { display: false } }, scales: intAxis() },
    });
    doughnut('admLeadsStatus', c.leads_by_status);
    doughnut('admLeadsResponse', c.leads_by_response);
    draw('admTasksDept', {
      type: 'bar',
      data: {
        labels: c.tasks_by_department.map((r) => title(r.department)),
        datasets: [
          { label: 'Completed', data: c.tasks_by_department.map((r) => r.completed), backgroundColor: C.green },
          { label: 'In progress', data: c.tasks_by_department.map((r) => r.in_progress), backgroundColor: C.blue },
          { label: 'Pending', data: c.tasks_by_department.map((r) => r.pending), backgroundColor: C.amber },
        ],
      },
      options: { plugins: { legend: { position: 'bottom' } }, scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true, ticks: intTicks } } },
    });
    doughnut('admStaff', c.staff_by_department);
    doughnut('admLeaves', c.leaves_by_status);
    draw('admWebMonthly', {
      type: 'line',
      data: {
        labels: c.contacts_per_month.labels,
        datasets: [
          { label: 'Contact submissions', data: c.contacts_per_month.values, borderColor: C.indigo, fill: true },
          { label: 'Job applications', data: c.applicants_per_month.values, borderColor: C.green, fill: true },
        ],
      },
      options: { plugins: { legend: { position: 'bottom' } }, interaction: { mode: 'index', intersect: false }, scales: intAxis() },
    });
    doughnut('admApplicants', c.applicants_by_status);

    rows('admRecentLeads', data.recent.leads, [(l) => l.name, (l) => l.product, (l) => title(l.status || ''), (l) => (l.added_on || '').slice(0, 10)], 'No leads yet');
    rows('admPendingLeaves', data.recent.pending_leaves, [(l) => l.name, (l) => l.start_date, (l) => l.end_date], 'Nothing pending');
    rows('admTopProducts', data.recent.top_products, [(p) => p.product_name, (p) => p.enquiries_count], 'No products');
  }

  function showError(message) {
    $('#admError').removeClass('d-none').text(message || 'Could not load dashboard data.');
  }

  function load() {
    $.getJSON('data/dashboard_data.php', { months: $('#admRange').val() })
      .done((data) => {
        if (!data.success) return showError(data.message);
        $('#admError').addClass('d-none');
        render(data);
      })
      .fail((xhr) => showError(xhr.responseJSON && xhr.responseJSON.message));
  }

  $('#admRange').on('change', load);
  $(load);
})();
</script>
