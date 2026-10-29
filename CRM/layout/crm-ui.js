/*
 * Shared CRM dialogs, loaded by layout/bottom.php after jQuery and SweetAlert2.
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
