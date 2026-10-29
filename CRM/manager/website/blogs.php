<?php
require_once './top.php';

$posts = $conn->query('SELECT blog_id, blog_title, blog_author, blog_img, blog_category_label, blog_status, is_featured, created_at,
                              CHAR_LENGTH(COALESCE(blog_content, "")) AS content_length
                       FROM blogs ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
$counts = ['all' => count($posts), 'Approved' => 0, 'Pending' => 0, 'Rejected' => 0];
foreach ($posts as $p) {
    $counts[$p['blog_status']] = ($counts[$p['blog_status']] ?? 0) + 1;
}
$topics = array_values(array_unique(array_filter(array_column($posts, 'blog_category_label'))));
$statusLabel = ['Approved' => ['Published', 'badge-success'], 'Pending' => ['Draft', 'badge-warning'], 'Rejected' => ['Hidden', 'badge-secondary']];
// Uploaded covers are stored relative to the site root; this page is three folders deeper.
$asset = fn ($p) => preg_match('#^(https?:)?//#', (string) $p) ? $p : '../../../' . $p;
?>
<div class="main-content">
  <div class="section__content section__content--p30">
    <div class="container-fluid">

      <div class="row mb-4">
        <?php foreach ([['Total posts', $counts['all'], 'fa-newspaper', '#2563eb'], ['Published', $counts['Approved'], 'fa-globe', '#10b981'],
                        ['Drafts', $counts['Pending'], 'fa-pen', '#f59e0b'], ['Hidden', $counts['Rejected'], 'fa-eye-slash', '#64748b']] as [$label, $value, $icon, $color]): ?>
          <div class="col-6 col-lg-3 mb-3">
            <div class="card h-100"><div class="card-body d-flex align-items-center" style="gap:14px">
              <span style="width:44px;height:44px;border-radius:12px;display:grid;place-items:center;background:<?= $color ?>1a;color:<?= $color ?>"><i class="fas <?= $icon ?>"></i></span>
              <div><div style="font:800 1.6rem/1 'Plus Jakarta Sans',Inter,sans-serif;color:var(--crm-heading)"><?= (int) $value ?></div><small class="text-muted"><?= $label ?></small></div>
            </div></div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div><h3 class="mb-0">Blog posts</h3><small>Write, publish and feature articles on the public blog</small></div>
          <button class="btn btn-primary" type="button" id="newPost"><i class="fas fa-plus mr-1"></i> New post</button>
        </div>
        <div class="card-body">
          <input type="search" id="postSearch" class="form-control mb-3" placeholder="Search by title, author or topic" style="max-width:360px">
          <div class="table-responsive">
            <table class="table table-hover" id="postsTable">
              <thead><tr><th>Post</th><th>Topic</th><th>Author</th><th>Status</th><th>Published</th><th class="text-right">Actions</th></tr></thead>
              <tbody>
                <?php if (!$posts): ?>
                  <tr><td colspan="6" class="text-center text-muted py-4">No posts yet. Click <b>New post</b> to write the first one.</td></tr>
                <?php endif; ?>
                <?php foreach ($posts as $p): [$label, $badge] = $statusLabel[$p['blog_status']] ?? ['Draft', 'badge-warning']; ?>
                  <tr data-text="<?= htmlspecialchars(strtolower($p['blog_title'] . ' ' . $p['blog_author'] . ' ' . $p['blog_category_label'])) ?>">
                    <td>
                      <div class="d-flex align-items-center" style="gap:12px">
                        <img src="<?= htmlspecialchars($asset($p['blog_img'])) ?>" alt="" style="width:64px;height:44px;object-fit:cover;border-radius:8px">
                        <div>
                          <strong style="color:#0f172a"><?= htmlspecialchars($p['blog_title']) ?></strong>
                          <?php if ($p['is_featured']): ?><span class="badge badge-info ml-1">Featured</span><?php endif; ?>
                          <?php if (!$p['content_length']): ?><div><small class="text-warning"><i class="fas fa-exclamation-circle"></i> Summary only, no article body yet</small></div><?php endif; ?>
                        </div>
                      </div>
                    </td>
                    <td><?= htmlspecialchars($p['blog_category_label']) ?></td>
                    <td><?= htmlspecialchars($p['blog_author']) ?></td>
                    <td><span class="badge <?= $badge ?>"><?= $label ?></span></td>
                    <td><?= date('j M Y', strtotime($p['created_at'])) ?></td>
                    <td class="text-right" style="white-space:nowrap">
                      <?php if ($p['blog_status'] === 'Approved'): ?>
                        <a class="btn btn-sm btn-light" href="../../../blog-details.php?id=<?= (int) $p['blog_id'] ?>" target="_blank" title="View on website"><i class="fas fa-external-link-alt"></i></a>
                        <button class="btn btn-sm btn-light" data-status="Pending" data-id="<?= (int) $p['blog_id'] ?>" title="Move to drafts"><i class="fas fa-eye-slash"></i></button>
                      <?php else: ?>
                        <button class="btn btn-sm btn-success" data-status="Approved" data-id="<?= (int) $p['blog_id'] ?>" title="Publish"><i class="fas fa-globe"></i></button>
                      <?php endif; ?>
                      <button class="btn btn-sm btn-light" data-edit="<?= (int) $p['blog_id'] ?>" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                      <button class="btn btn-sm btn-light text-danger" data-delete="<?= (int) $p['blog_id'] ?>" data-title="<?= htmlspecialchars($p['blog_title']) ?>" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Editor -->
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form class="modal-content" id="postForm" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="postModalTitle">New post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" id="postId">
        <div class="form-group"><label for="postTitle">Title *</label><input class="form-control" id="postTitle" name="title" maxlength="255" required></div>
        <div class="form-row">
          <div class="form-group col-md-6"><label for="postAuthor">Author *</label><input class="form-control" id="postAuthor" name="author" maxlength="100" required></div>
          <div class="form-group col-md-6"><label for="postCategory">Topic *</label>
            <input class="form-control" id="postCategory" name="category" maxlength="50" list="topicList" placeholder="e.g. Cybersecurity" required>
            <datalist id="topicList"><?php foreach ($topics as $t): ?><option value="<?= htmlspecialchars($t) ?>"><?php endforeach; ?></datalist>
          </div>
        </div>
        <div class="form-group"><label for="postExcerpt">Summary * <small class="text-muted">(shown on blog cards and as the article intro)</small></label>
          <textarea class="form-control" id="postExcerpt" name="excerpt" rows="2" maxlength="400" required></textarea></div>
        <div class="form-group"><label for="postContent">Article</label>
          <textarea class="form-control" id="postContent" name="content" rows="12" style="font-family:ui-monospace,Menlo,monospace;font-size:.88rem"
                    placeholder="Write the article here.&#10;&#10;## A heading&#10;A paragraph with **bold text** and a [link](https://example.com).&#10;&#10;- bullet point&#10;- another point"></textarea>
          <small class="text-muted">Formatting: <code>## Heading</code>, <code>### Sub-heading</code>, <code>- bullet</code>, <code>1. numbered</code>, <code>**bold**</code>, <code>[text](https://link)</code>. Leave a blank line between paragraphs. Read time is calculated automatically.</small>
        </div>
        <div class="form-row align-items-end">
          <div class="form-group col-md-6"><label for="postImage">Cover image <span id="imageHint">*</span></label>
            <input type="file" class="form-control" id="postImage" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
            <small class="text-muted">JPG, PNG or WebP, up to 5 MB. 1600×900 works best.</small>
            <img id="postImagePreview" alt="" style="display:none;margin-top:8px;max-width:180px;border-radius:8px">
          </div>
          <div class="form-group col-md-3"><label for="postStatus">Status</label>
            <select class="form-control" id="postStatus" name="status">
              <option value="Pending">Draft</option><option value="Approved">Published</option><option value="Rejected">Hidden</option>
            </select></div>
          <div class="form-group col-md-3">
            <div class="custom-control custom-checkbox mb-2"><input type="checkbox" class="custom-control-input" id="postFeatured" name="featured" value="1">
              <label class="custom-control-label" for="postFeatured">Feature on blog</label></div>
          </div>
        </div>
        <div class="alert alert-danger d-none mb-0" id="postError"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="postSave">Save post</button>
      </div>
    </form>
  </div>
</div>

<?php require './bottom.php'; ?>
<script>
(function () {
  const api = 'data/blogs_admin.php';
  const form = document.getElementById('postForm');
  const toast = (icon, title) => Swal.fire({ icon, title, timer: 1600, showConfirmButton: false });
  const asset = (p) => (!p || /^(https?:)?\/\//.test(p) ? p : '../../../' + p);
  const post = (data) => fetch(api, { method: 'POST', body: data }).then((r) => r.json());

  function openEditor(p) {
    form.reset();
    document.getElementById('postError').classList.add('d-none');
    document.getElementById('postModalTitle').textContent = p ? 'Edit post' : 'New post';
    document.getElementById('postId').value = p ? p.blog_id : '';
    document.getElementById('postTitle').value = p ? p.blog_title : '';
    document.getElementById('postAuthor').value = p ? p.blog_author : <?= json_encode($user['name'] ?? '') ?>;
    document.getElementById('postCategory').value = p ? p.blog_category_label : '';
    document.getElementById('postExcerpt').value = p ? p.blog_excerpt : '';
    document.getElementById('postContent').value = p ? (p.blog_content || '') : '';
    document.getElementById('postStatus').value = p ? p.blog_status : 'Pending';
    document.getElementById('postFeatured').checked = p ? p.is_featured == 1 : false;
    document.getElementById('imageHint').textContent = p ? '(leave empty to keep the current one)' : '*';
    const preview = document.getElementById('postImagePreview');
    preview.style.display = p ? 'block' : 'none';
    if (p) preview.src = asset(p.blog_img);
    $('#postModal').modal('show');
  }

  document.getElementById('newPost').addEventListener('click', () => openEditor(null));
  document.getElementById('postImage').addEventListener('change', function () {
    const f = this.files[0], preview = document.getElementById('postImagePreview');
    if (f) { preview.src = URL.createObjectURL(f); preview.style.display = 'block'; }
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('postSave');
    btn.disabled = true; btn.textContent = 'Saving…';
    try {
      const res = await post(new FormData(form));
      if (!res.success) throw new Error(res.message);
      $('#postModal').modal('hide');
      toast('success', res.message);
      setTimeout(() => location.reload(), 900);
    } catch (err) {
      const box = document.getElementById('postError');
      box.textContent = err.message || 'Could not save the post.';
      box.classList.remove('d-none');
    } finally {
      btn.disabled = false; btn.textContent = 'Save post';
    }
  });

  document.getElementById('postsTable').addEventListener('click', async (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;
    if (btn.dataset.edit) {
      const res = await fetch(api + '?id=' + btn.dataset.edit).then((r) => r.json());
      return res.success ? openEditor(res.post) : toast('error', res.message);
    }
    const data = new FormData();
    if (btn.dataset.status) {
      data.append('action', 'status'); data.append('id', btn.dataset.id); data.append('status', btn.dataset.status);
    } else if (btn.dataset.delete) {
      const ok = await Swal.fire({ icon: 'warning', title: 'Delete this post?', text: btn.dataset.title, showCancelButton: true, confirmButtonText: 'Delete', confirmButtonColor: '#ef4444' });
      if (!ok.isConfirmed) return;
      data.append('action', 'delete'); data.append('id', btn.dataset.delete);
    } else {
      return;
    }
    const res = await post(data);
    toast(res.success ? 'success' : 'error', res.message);
    if (res.success) setTimeout(() => location.reload(), 900);
  });

  document.getElementById('postSearch').addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll('#postsTable tbody tr[data-text]').forEach((tr) => tr.classList.toggle('d-none', q && !tr.dataset.text.includes(q)));
  });
})();
</script>
