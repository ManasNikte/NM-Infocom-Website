/*
 * Shared CRM helpers, loaded in <head> by layout/top.php (jQuery and SweetAlert2 are used only once the page has loaded).
 *
 * crmAssignTask({ base, assignUrl, onDone }) opens the "Assign task" form:
 *   base      - path from the page to CRM/ ('../' or '../../')
 *   assignUrl - endpoint that stores the task (JSON body: assigned_to, task, due_date)
 *   onDone    - called after a task was saved (refresh the task table)
 * Admins pick from every active manager and employee; managers from their department's employees.
 */
(function () {
  function today() {
    var d = new Date();
    return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
  }
  var dept = function (s) { return s === 'hr' ? 'HR' : s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; };

  window.crmAssignTask = function (opts) {
    fetch(opts.base + 'shared/department_staff.php?all=1', { credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        var staff = data.data || [];
        if (!staff.length) {
          return Swal.fire({
            icon: 'info',
            title: 'No one to assign yet',
            html: 'There are no active employees ' + (data.scope === 'all' ? 'in the CRM' : 'in your department') +
              ' yet.<br>Once staff are added (Employee list → <b>Add user</b>), you can assign them tasks here.',
            confirmButtonText: 'OK',
          });
        }
        // Group the people by department for the dropdown.
        var groups = {};
        staff.forEach(function (p) { (groups[p.sub_role || ''] = groups[p.sub_role || ''] || []).push(p); });
        var options = Object.keys(groups).sort().map(function (g) {
          var items = groups[g].map(function (p) {
            return '<option value="' + esc(p.lead_id) + '">' + esc(p.name) + (p.role === 'Manager' ? ' (Manager)' : '') + '</option>';
          }).join('');
          return Object.keys(groups).length > 1 ? '<optgroup label="' + esc(dept(g)) + '">' + items + '</optgroup>' : items;
        }).join('');

        Swal.fire({
          title: 'Assign a task',
          customClass: { popup: 'crm-form-popup' },
          html:
            '<form class="crm-form" onsubmit="return false">' +
            '<label class="crm-field"><span>Assign to</span><select id="crmTaskWho" class="form-control">' + options + '</select></label>' +
            '<label class="crm-field"><span>Task</span><textarea id="crmTaskText" class="form-control" rows="3" maxlength="500" placeholder="What needs to be done?"></textarea></label>' +
            '<label class="crm-field"><span>Due date</span><input id="crmTaskDue" type="date" class="form-control" min="' + today() + '"></label>' +
            '<p class="crm-form-note"><i class="fas fa-envelope"></i> The assignee gets an email about the new task.</p>' +
            '</form>',
          showCancelButton: true,
          confirmButtonText: 'Assign task',
          focusConfirm: false,
          didOpen: function () { document.getElementById('crmTaskText').focus(); },
          preConfirm: function () {
            var who = document.getElementById('crmTaskWho').value;
            var task = document.getElementById('crmTaskText').value.trim();
            var due = document.getElementById('crmTaskDue').value;
            if (!task) return Swal.showValidationMessage('Describe the task'), false;
            if (!due) return Swal.showValidationMessage('Pick a due date'), false;
            if (due < today()) return Swal.showValidationMessage('The due date is in the past'), false;
            return fetch(opts.assignUrl, {
              method: 'POST', credentials: 'same-origin',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ assigned_to: who, task: task, due_date: due }),
            })
              .then(function (r) { return r.json(); })
              .then(function (res) {
                if (!res.success) throw new Error(res.error || res.message || 'Could not assign the task');
                return res;
              })
              .catch(function (e) { Swal.showValidationMessage(e.message); return false; });
          },
        }).then(function (result) {
          if (!result.isConfirmed || !result.value) return;
          Swal.fire({
            icon: 'success', title: 'Task assigned',
            text: result.value.email_sent ? 'An email has been sent to the assignee.' : 'Saved. (The notification email could not be sent.)',
            timer: 2600, showConfirmButton: false,
          });
          if (opts.onDone) opts.onDone();
        });
      })
      .catch(function () { Swal.fire({ icon: 'error', title: 'Could not load staff', text: 'Please refresh the page and try again.' }); });
  };
})();

// A JSON list field ('["PHP","MySQL"]') as one item per line, for editing in a textarea.
window.crmListLines = function (value) {
  if (Array.isArray(value)) return value.join('\n');
  try {
    var list = JSON.parse(value);
    if (Array.isArray(list)) return list.join('\n');
  } catch (e) {}
  return value == null ? '' : String(value);
};

/*
 * crmLiveRefresh(reload, { staleAfter }) keeps a table or chart current without polling the server.
 * `reload` runs:
 *   - when the tab is shown or focused again after `staleAfter` ms (default 30 s) away,
 *   - when a change is saved in another open CRM tab (BroadcastChannel, no server requests).
 * The page itself already reloads after its own saves. Registering the same function again replaces it.
 * Returns the reload function so old "clearInterval(handle)" calls stay harmless.
 */
(function () {
  var views = {};
  var channel = null;
  try { channel = 'BroadcastChannel' in window ? new BroadcastChannel('nm-crm-changes') : null; } catch (e) {}

  function run(view) {
    view.last = Date.now();
    try { view.reload(); } catch (e) { if (window.console) console.error(e); }
  }
  function refreshStale() {
    if (document.hidden) return;
    Object.keys(views).forEach(function (k) { if (Date.now() - views[k].last > views[k].staleAfter) run(views[k]); });
  }
  document.addEventListener('visibilitychange', refreshStale);
  window.addEventListener('focus', refreshStale);

  var pending = null;
  if (channel) {
    channel.onmessage = function () {
      // Another tab saved something: refresh now if visible, otherwise as soon as this tab is shown.
      Object.keys(views).forEach(function (k) { views[k].last = 0; });
      clearTimeout(pending);
      pending = setTimeout(refreshStale, 400);
    };
  }

  window.crmLiveRefresh = function (reload, opts) {
    var key = (opts && opts.key ? opts.key + ':' : '') + String(reload);
    views[key] = { reload: reload, last: Date.now(), staleAfter: (opts && opts.staleAfter) || 30000 };
    return reload;
  };

  // Tell other tabs whenever this tab saves something (any successful non-GET request to the CRM).
  function announce(method, ok) {
    if (channel && ok && method && method.toUpperCase() !== 'GET') channel.postMessage({ at: Date.now() });
  }
  if (window.fetch) {
    var nativeFetch = window.fetch;
    window.fetch = function (input, init) {
      var method = (init && init.method) || (input && input.method) || 'GET';
      return nativeFetch.apply(this, arguments).then(function (res) { announce(method, res.ok); return res; });
    };
  }
  document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery) jQuery(document).ajaxSuccess(function (e, xhr, settings) { announce(settings.type, true); });
  });
})();

// For server-rendered lists: reload the page when it is stale, unless the user is busy in a form or pop-up.
window.crmReloadWhenStale = function () {
  crmLiveRefresh(function crmPageReload() {
    var busy = document.querySelector('.swal2-container, .modal.show') ||
      (document.activeElement && /^(INPUT|TEXTAREA|SELECT)$/.test(document.activeElement.tagName) && document.activeElement.value);
    if (!busy) location.reload();
  });
};

// "Fire employee": one dialog with a required reason, then shared/fire_employee.php.
window.crmFireEmployee = function (id, name, base, onDone) {
  Swal.fire({
    icon: 'warning',
    title: 'Remove ' + esc(name) + '?',
    html: 'Their CRM access ends immediately; their past work stays on record.<br><small>Employee ID ' + esc(id) + '</small>',
    input: 'text',
    inputLabel: 'Reason (kept in their record)',
    inputPlaceholder: 'e.g. Resigned on 30 Oct 2026',
    inputValidator: function (v) { return v && v.trim() ? undefined : 'Please give a reason.'; },
    showCancelButton: true,
    confirmButtonText: 'Remove access',
    confirmButtonColor: '#e11d48',
    showLoaderOnConfirm: true,
    preConfirm: function (reason) {
      return $.ajax({ url: base + 'shared/fire_employee.php', method: 'POST', dataType: 'json', data: { lead_id: id, reason: reason.trim() } })
        .then(function (res) {
          if (!res.success) throw new Error(res.error || res.message || 'Could not remove this employee');
          return res;
        })
        .catch(function (e) { Swal.showValidationMessage(e.message || (e.responseJSON && e.responseJSON.message) || 'Could not remove this employee'); });
    },
  }).then(function (r) {
    if (!r.isConfirmed) return;
    Swal.fire({ icon: 'success', title: 'Access removed', timer: 1800, showConfirmButton: false });
    if (onDone) onDone();
  });
};

/*
 * Website content editors (team, stats, why-us, FAQs, clients, hero slides, site details) →
 * manager/website/data/content_admin.php, which whitelists every table and field.
 *   crmContentEditor({ resource, title, record, fields: [{ name, label, type, required, options, rows, placeholder }],
 *                      image: { label, current }, onDone })
 *   type: text | textarea | number | url | email | select (options: [[value, label], …])
 */
window.crmContentEditor = function (opts) {
  var rec = opts.record || {};
  var field = function (f) {
    var v = rec[f.name] == null ? (f.value == null ? '' : f.value) : rec[f.name];
    var req = f.required ? ' <span class="text-danger">*</span>' : '';
    var attrs = 'id="cf_' + f.name + '" name="' + f.name + '" class="form-control"' + (f.placeholder ? ' placeholder="' + esc(f.placeholder) + '"' : '');
    var input;
    if (f.type === 'textarea') input = '<textarea ' + attrs + ' rows="' + (f.rows || 3) + '">' + esc(v) + '</textarea>';
    else if (f.type === 'select') input = '<select ' + attrs + '>' + f.options.map(function (o) {
      return '<option value="' + esc(o[0]) + '"' + (String(o[0]) === String(v) ? ' selected' : '') + '>' + esc(o[1]) + '</option>';
    }).join('') + '</select>';
    else input = '<input type="' + ({ number: 'number', url: 'url', email: 'email' }[f.type] || 'text') + '" ' + attrs + ' value="' + esc(v) + '"' + (f.type === 'number' ? ' min="0" step="1"' : '') + '>';
    return '<label class="crm-field' + (f.wide ? ' crm-field-wide' : '') + '"><span>' + esc(f.label) + req + '</span>' + input + '</label>';
  };
  var img = opts.image ? '<label class="crm-field crm-field-wide"><span>' + esc(opts.image.label || 'Image') + (opts.image.required && !opts.image.current ? ' <span class="text-danger">*</span>' : '') + '</span>' +
    (opts.image.current ? '<img src="' + esc(opts.image.current) + '" alt="" style="max-height:90px;max-width:100%;border-radius:10px;margin:0 0 8px;display:block">' : '') +
    '<input type="file" id="cf_image" accept="image/jpeg,image/png,image/webp,image/gif" class="form-control"><small class="text-muted">JPG, PNG, WebP or GIF, up to 5 MB' + (opts.image.current ? '. Leave empty to keep the current image.' : '') + '</small></label>' : '';
  Swal.fire({
    title: opts.title,
    customClass: { popup: 'swal2-modern-popup' },
    html: '<form class="crm-form crm-form-grid" onsubmit="return false">' + opts.fields.map(field).join('') + img + '</form>',
    showCancelButton: true,
    confirmButtonText: opts.record && opts.record.__id != null ? 'Save changes' : 'Add',
    focusConfirm: false,
    showLoaderOnConfirm: true,
    preConfirm: function () {
      var fd = new FormData();
      fd.append('resource', opts.resource);
      fd.append('action', 'save');
      if (rec.__id != null) fd.append('id', rec.__id);
      for (var i = 0; i < opts.fields.length; i++) {
        var f = opts.fields[i], val = document.getElementById('cf_' + f.name).value.trim();
        if (f.required && !val) return Swal.showValidationMessage('Please fill in ' + f.label), false;
        fd.append(f.name, val);
      }
      var file = document.getElementById('cf_image');
      if (file && file.files[0]) {
        if (file.files[0].size > 5 * 1024 * 1024) return Swal.showValidationMessage('The image is larger than 5 MB'), false;
        fd.append('image', file.files[0]);
      } else if (opts.image && opts.image.required && !opts.image.current) {
        return Swal.showValidationMessage('Please choose an image'), false;
      }
      return fetch(opts.endpoint || 'data/content_admin.php', { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (res) { if (!res.success) throw new Error(res.message); return res; })
        .catch(function (e) { Swal.showValidationMessage(e.message || 'Could not save'); });
    },
  }).then(function (r) {
    if (!r.isConfirmed || !r.value) return;
    Swal.fire({ icon: 'success', title: r.value.message, timer: 1400, showConfirmButton: false });
    if (opts.onDone) opts.onDone();
  });
};

window.crmContentDelete = function (opts) {
  Swal.fire({
    icon: 'warning', title: 'Delete ' + esc(opts.label || 'this item') + '?', text: 'This removes it from the website.',
    showCancelButton: true, confirmButtonText: 'Delete', confirmButtonColor: '#e11d48', showLoaderOnConfirm: true,
    preConfirm: function () {
      var fd = new FormData();
      fd.append('resource', opts.resource); fd.append('action', 'delete'); fd.append('id', opts.id);
      return fetch(opts.endpoint || 'data/content_admin.php', { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (res) { if (!res.success) throw new Error(res.message); return res; })
        .catch(function (e) { Swal.showValidationMessage(e.message || 'Could not delete'); });
    },
  }).then(function (r) {
    if (!r.isConfirmed || !r.value) return;
    Swal.fire({ icon: 'success', title: 'Deleted', timer: 1200, showConfirmButton: false });
    if (opts.onDone) opts.onDone();
  });
};
