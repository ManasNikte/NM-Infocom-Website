<?php require_once './top.php'; ?>
<!-- Newsletter subscribers: real data from newsletter_subscribers (filled by the website's sign-up form). -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="adm-stats">
                <div class="adm-stat adm-blue"><i class="fas fa-users adm-stat-icon" aria-hidden="true"></i><span data-nl="subscribed">–</span><small>Active subscribers</small></div>
                <div class="adm-stat adm-green"><i class="fas fa-user-plus adm-stat-icon" aria-hidden="true"></i><span data-nl="this_month">–</span><small>New this month</small></div>
                <div class="adm-stat adm-violet"><i class="fas fa-chart-line adm-stat-icon" aria-hidden="true"></i><span data-nl="last_30_days">–</span><small>New in the last 30 days</small></div>
                <div class="adm-stat adm-rose"><i class="fas fa-user-minus adm-stat-icon" aria-hidden="true"></i><span data-nl="unsubscribed">–</span><small>Unsubscribed</small></div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary mb-0">Newsletter subscribers</h3>
                    <small class="text-muted">People who signed up on the website</small>
                    <a class="btn btn-primary btn-sm ml-auto" id="nlExport" href="data/nm_newsletter_data.php?export=csv"><i class="fas fa-file-csv mr-1"></i> Export CSV</a>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap mb-3" style="gap:10px">
                        <input type="search" id="nlSearch" class="form-control" style="max-width:320px" placeholder="Search by email…">
                        <select id="nlStatus" class="form-control" style="max-width:200px">
                            <option value="">All statuses</option>
                            <option value="subscribed">Subscribed</option>
                            <option value="unsubscribed">Unsubscribed</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="newsletterTable">
                            <thead><tr><th>Email</th><th>Status</th><th>Signed up</th><th class="text-right">Actions</th></tr></thead>
                            <tbody id="newsletter-table-body"><tr><td colspan="4" class="text-center text-muted">Loading…</td></tr></tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap:10px">
                        <small class="text-muted" id="nlInfo"></small>
                        <ul class="pagination pagination-sm mb-0" id="nlPagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './bottom.php'; ?>
<script>
(function () {
    let page = 1;
    const api = 'data/nm_newsletter_data.php';
    const query = () => new URLSearchParams({ search: $('#nlSearch').val().trim(), status: $('#nlStatus').val(), page });

    function load() {
        fetch(api + '?' + query(), { credentials: 'same-origin' })
            .then((r) => r.json())
            .then((res) => {
                if (!res.success) throw new Error(res.message);
                Object.entries(res.totals).forEach(([k, v]) => $('[data-nl="' + k + '"]').text(Number(v).toLocaleString('en-IN')));
                const rows = res.data.map((s) => `
                    <tr>
                        <td>${esc(s.email)}</td>
                        <td><span class="badge ${s.status === 'subscribed' ? 'badge-success' : 'badge-secondary'}">${esc(s.status === 'subscribed' ? 'Subscribed' : 'Unsubscribed')}</span></td>
                        <td>${esc(new Date(String(s.subscribed_at).replace(' ', 'T')).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }))}</td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-light" data-nl-toggle="${esc(s.id)}" data-to="${s.status === 'subscribed' ? 'unsubscribed' : 'subscribed'}">${s.status === 'subscribed' ? 'Unsubscribe' : 'Resubscribe'}</button>
                            <button class="btn btn-sm btn-danger" data-nl-delete="${esc(s.id)}" data-email="${esc(s.email)}" title="Delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`).join('');
                $('#newsletter-table-body').html(rows || '<tr><td colspan="4" class="text-center text-muted">No subscribers match</td></tr>');
                const p = res.pagination;
                $('#nlInfo').text(p.total ? `${p.total.toLocaleString('en-IN')} subscriber${p.total === 1 ? '' : 's'}` : '');
                let pager = '';
                for (let i = 1; i <= p.pages && p.pages > 1; i++) pager += `<li class="page-item${i === p.page ? ' active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                $('#nlPagination').html(pager);
                $('#nlExport').attr('href', api + '?export=csv&' + new URLSearchParams({ search: $('#nlSearch').val().trim(), status: $('#nlStatus').val() }));
            })
            .catch((e) => $('#newsletter-table-body').html('<tr><td colspan="4" class="text-center text-danger">' + esc(e.message || 'Could not load subscribers') + '</td></tr>'));
    }
    const post = (data) => fetch(api, { method: 'POST', body: new URLSearchParams(data), credentials: 'same-origin' }).then((r) => r.json());

    let timer;
    $('#nlSearch').on('input', () => { clearTimeout(timer); timer = setTimeout(() => { page = 1; load(); }, 300); });
    $('#nlStatus').on('change', () => { page = 1; load(); });
    $('#nlPagination').on('click', 'a', function (e) { e.preventDefault(); page = +this.dataset.page; load(); });
    $('#newsletter-table-body').on('click', '[data-nl-toggle]', function () {
        post({ action: 'status', id: this.dataset.nlToggle, status: this.dataset.to }).then((r) => r.success ? load() : Swal.fire('Not changed', r.message, 'error'));
    }).on('click', '[data-nl-delete]', function () {
        const id = this.dataset.nlDelete;
        Swal.fire({ icon: 'warning', title: 'Delete this subscriber?', text: this.dataset.email, showCancelButton: true, confirmButtonText: 'Delete', confirmButtonColor: '#e11d48' })
            .then((r) => r.isConfirmed && post({ action: 'delete', id }).then((res) => res.success ? load() : Swal.fire('Not deleted', res.message, 'error')));
    });
    load();
    crmLiveRefresh(load);
})();
</script>
