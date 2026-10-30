<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="text-primary">FAQs Management</h3>
                    <small class="text-muted">Manage FAQs</small>
                    <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="crmAddContent()"><i class="fas fa-plus mr-1"></i> Add FAQ</button>
                    <div class="mt-3 mb-2 d-flex justify-content-end">
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addFaqModal">
                        <i class="fa fa-plus"></i> Add FAQ
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="faqsTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary">ID</th>
                            <th class="text-primary text-center">Title</th>
                            <th class="text-primary">Description</th>
                            <th class="text-primary">Status</th>
                            <th class="text-primary">Date Added</th>
                            <th class="text-primary">Last Modified</th>
                            <th class="text-primary text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody id="faqs-table-body">
                          <!-- Data will be loaded here via AJAX -->
                        </tbody>
                      </table>
                    </div>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                      <!-- Page info on left -->
                      <div class="text-muted" id="showingEntries">
                        <!-- Will be populated by JavaScript -->
                      </div>
                      
                      <!-- Pagination on right -->
                      <nav aria-label="Page navigation">
                        <ul class="pagination mb-0" id="pagination">
                          <!-- Will be populated by JavaScript -->
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <!-- Add rows here -->
          
        <!-- End the main code above this line -->
        <!-- Add FAQ Modal -->
        <div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog" aria-labelledby="addFaqModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addFaqModalLabel">Add FAQ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="addFaqForm">
                  <div class="form-group">
                    <label for="faqTitle">Title</label>
                    <input type="text" class="form-control" id="faqTitle" name="faq_title" required>
                  </div>
                  <div class="form-group">
                    <label for="faqDescription">Description</label>
                    <textarea class="form-control" id="faqDescription" name="faq_description" rows="3" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="faqStatus">Status</label>
                    <select class="form-control" id="faqStatus" name="faq_status" required>
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Add FAQ</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Edit FAQ Modal -->
        <div class="modal fade" id="editFaqModal" tabindex="-1" role="dialog" aria-labelledby="editFaqModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editFaqModalLabel">
                  <i class="fa fa-edit mr-2"></i>Edit FAQ
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="editFaqForm">
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                  <div class="form-group">
                    <label for="editFaqTitle" class="font-weight-bold text-primary">Title</label>
                    <input type="text" class="form-control" id="editFaqTitle" name="faq_title" required>
                  </div>
                  <div class="form-group">
                    <label for="editFaqDescription" class="font-weight-bold text-primary">Description</label>
                    <textarea class="form-control" id="editFaqDescription" name="faq_description" rows="3" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="editFaqStatus" class="font-weight-bold text-primary">Status</label>
                    <select class="form-control" id="editFaqStatus" name="faq_status" required>
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer bg-light">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i>Cancel
                  </button>
                  <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save mr-1"></i>Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
<?php require './bottom.php'; ?>

<style>
/* Table container */
.table-responsive-data2 {
    overflow-x: auto;
    margin: 0 -15px;
    padding: 0 15px;
}

/* Base table styles */
.table-data2 {
    min-width: 1200px;
    width: 100%;
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
}

/* Default cell styles */
.table-data2 td {
    white-space: normal !important;
    overflow: visible !important;
    text-overflow: initial !important;
    word-break: break-word;
    padding: 8px 6px !important;
    vertical-align: middle !important;
    font-size: 0.9rem;
    line-height: 1.4;
}

/* Column widths */
.table-data2 th:nth-child(1), /* ID */
.table-data2 td:nth-child(1) {
    width: 50px;
}

.table-data2 th:nth-child(2), /* Title */
.table-data2 td:nth-child(2) {
    width: 150px;
    text-align: center;
}

.table-data2 th:nth-child(3), /* Description */
.table-data2 td:nth-child(3) {
    width: 300px;
}

.table-data2 th:nth-child(4), /* Status */
.table-data2 td:nth-child(4) {
    width: 100px;
}

.table-data2 th:nth-child(5), /* Date Added */
.table-data2 td:nth-child(5) {
    width: 150px;
}

.table-data2 th:nth-child(6), /* Last Modified */
.table-data2 td:nth-child(6) {
    width: 150px;
}

.table-data2 th:nth-child(7), /* Action */
.table-data2 td:nth-child(7) {
    width: 150px;
    text-align: center;
}

/* Header styles */
.table-data2 thead th {
    padding: 8px 6px !important;
    font-weight: 600;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle !important;
    position: sticky;
    top: 0;
    z-index: 1;
}

/* Row styles */
.tr-shadow {
    height: auto !important;
}

.spacer {
    height: 4px;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .table-data2 {
        min-width: 800px;
    }
    
    .table-data2 tbody td {
        padding: 6px 4px !important;
        font-size: 0.85rem;
    }
}

/* Pagination styles */
.pagination {
  margin: 0;
}

#showingEntries {
  font-size: 0.9rem;
}

/* Add hover effect for rows */
.table-data2 tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
    transition: background-color 0.2s ease;
}

/* Ensure table cells align properly */
.table-data2 th,
.table-data2 td {
    vertical-align: middle !important;
}

/* Custom button styles */
.btn-custom {
    width: 100px; /* Adjust the width as needed */
}
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;
let pollingInterval;

// Function to load table data
function loadTableData(page = 1) {
    fetch(`./data/faqs_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data fetched:', data); // Debugging information
            renderTable(data);
        })
        .catch(error => console.error('Error loading data:', error));
}

// Function to render table
function renderTable(faqsData) {
    const tableBody = document.getElementById('faqs-table-body');
    tableBody.innerHTML = '';
    window.allFaqsData = faqsData;
    if (faqsData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="8">No data available</td></tr>';
        return;
    }
    faqsData.forEach(item => {
        const row = `
            <tr class='tr-shadow'>
                <td>${esc(item.faq_id)}</td>
                <td class="text-center">${esc(item.faq_title)}</td>
                <td>${esc(item.faq_description)}</td>
                <td>${esc(item.status)}</td>
                <td>${esc(item.date_added)}</td>
                <td>${esc(item.last_modified)}</td>
                <td class="text-center">
                    <div class="btn-group" role="group" aria-label="FAQ Actions">
                      <button class="btn btn-info btn-sm btn-custom btn-view-faq" title="View" style="color: #fff;"><i class="fa fa-eye"></i></button>
                      <button class="btn btn-primary btn-sm btn-custom btn-edit-faq" data-id="${esc(item.faq_id)}">Edit</button>
                      <button class="btn btn-danger btn-sm btn-custom" onclick="deleteFaq(${esc(item.faq_id)})">Delete</button>
                    </div>
                </td>
            </tr>
            <tr class='spacer'></tr>
        `;
        tableBody.innerHTML += row;
    });
}

// Keep the table current (crmLiveRefresh)
function startPolling() {
    loadTableData(currentPage);
    pollingInterval = crmLiveRefresh(() => {
        loadTableData(currentPage);
    });
}



// Load the table, then keep it current (crmLiveRefresh)
document.addEventListener('DOMContentLoaded', () => {
    startPolling();
});

// Event delegation for edit button
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit-faq')) {
        const id = e.target.getAttribute('data-id');
        editFaqPopup(id);
    }
});


// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
});

// Update custom CSS for action buttons to ensure full visibility of button text/icons
const style = document.createElement('style');
style.innerHTML = `
  .btn-group .btn-custom {
    margin-right: 12px;
    min-width: 52px;
    max-width: 60px;
    padding-left: 0.85rem;
    padding-right: 0.85rem;
    padding-top: 0.45rem;
    padding-bottom: 0.45rem;
    font-size: 1.08rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .btn-group .btn-custom:last-child {
    margin-right: 0;
  }
  .btn-view-faq {
    background: linear-gradient(90deg, #36d1c4 0%, #5b86e5 100%);
    border: none;
    transition: box-shadow 0.2s;
  }
  .btn-view-faq:hover, .btn-view-faq:focus {
    box-shadow: 0 2px 8px rgba(54,209,196,0.2);
    color: #fff;
  }
`;
document.head.appendChild(style);
</script>

<script>
// Real create / edit / delete (data/content_admin.php); replaces the old demo-only handlers.
(function () {
  const resource = "faqs", pk = "faq_id", noun = "FAQ", labelField = "faq_title";
  const fields = [{"label": "Question", "name": "faq_title", "type": "text", "required": true, "wide": true}, {"label": "Answer", "name": "faq_description", "type": "textarea", "required": true, "rows": 4}, {"label": "Category", "name": "category", "type": "text", "required": false, "placeholder": "e.g. General"}, {"label": "Order on page", "name": "display_order", "type": "number", "required": false, "value": "0"}, {"label": "Status", "name": "status", "type": "select", "required": true, "options": [["active", "Shown on the website"], ["inactive", "Hidden"]], "value": "active"}];
  const image = null;
  let rows = {};
  const baseRender = window.renderTable;
  window.renderTable = function (list) {
    rows = {};
    (list || []).forEach((r) => { rows[r[pk]] = r; });
    return baseRender.apply(this, arguments);
  };
  const reload = () => (typeof loadTableData === 'function' ? loadTableData(typeof currentPage !== 'undefined' ? currentPage : 1) : location.reload());
  const imageOpts = (rec) => image && { label: image.label, required: image.required, current: rec && rec[image.field] ? '../../../' + rec[image.field].replace(/^\.?\//, '') : '' };
  function edit(id) {
    const rec = rows[id];
    if (!rec) return Swal.fire({ icon: 'info', title: 'Refresh the page', text: 'This item was changed or removed.' });
    crmContentEditor({ resource, title: 'Edit ' + noun, fields, image: imageOpts(rec), record: Object.assign({ __id: rec[pk] }, rec), onDone: reload });
  }
  window.crmAddContent = function () {
    crmContentEditor({ resource, title: 'Add ' + noun, fields, image: imageOpts(null), record: null, onDone: reload });
  };
  window["editFaq"] = edit;
  window["editFaqPopup"] = edit; 
  window["deleteFaq"] = (id) => crmContentDelete({ resource, id, label: (rows[id] && rows[id][labelField]) || noun, onDone: reload });
})();
</script>
