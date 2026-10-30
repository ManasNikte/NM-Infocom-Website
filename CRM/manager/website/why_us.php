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
                    <h3 class="text-primary">Why Choose Us Cards Management</h3>
                    <small class="text-muted">Manage why us cards</small>
                    <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="crmAddContent()"><i class="fas fa-plus mr-1"></i> Add card</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="whyUsTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary">ID</th>
                            <th class="text-primary text-center">Title</th>
                            <th class="text-primary">Card Number</th>
                            <th class="text-primary">Description</th>
                            <th class="text-primary text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody id="why-us-table-body">
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

<!-- Edit Why Us Modal -->
<div class="modal fade" id="editWhyUsModal" tabindex="-1" role="dialog" aria-labelledby="editWhyUsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editWhyUsModalLabel">Edit Why Us Card</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editWhyUsForm">
        <div class="modal-body">
          <ul class="list-group mb-3" id="whyUsDetailsList">
            <!-- Why Us details will be injected here -->
          </ul>
          <div class="form-group">
            <label for="editWhyUsTitle">Title</label>
            <input type="text" class="form-control" id="editWhyUsTitle" name="whyus_title" required>
          </div>
          <div class="form-group">
            <label for="editWhyUsCardNumber">Card Number</label>
            <input type="number" class="form-control" id="editWhyUsCardNumber" name="whyus_card_number" required>
          </div>
          <div class="form-group">
            <label for="editWhyUsDescription">Description</label>
            <textarea class="form-control" id="editWhyUsDescription" name="whyus_description" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
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
    min-width: 900px;
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

.table-data2 th:nth-child(3), /* Card Number */
.table-data2 td:nth-child(3) {
    width: 100px;
}

.table-data2 th:nth-child(4), /* Description */
.table-data2 td:nth-child(4) {
    width: 300px;
}

.table-data2 th:nth-child(5), /* Action */
.table-data2 td:nth-child(5) {
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
    fetch(`./data/why_us_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data fetched:', data); // Debugging information
            renderTable(data);
        })
        .catch(error => console.error('Error loading data:', error));
}

// Function to render table
function renderTable(whyUsData) {
    const tableBody = document.getElementById('why-us-table-body');
    tableBody.innerHTML = '';
    window.allWhyUsData = whyUsData;
    if (whyUsData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5">No data available</td></tr>';
        return;
    }
    whyUsData.forEach(item => {
        const row = `
            <tr class='tr-shadow'>
                <td>${esc(item.whyus_id)}</td>
                <td class="text-center">${esc(item.whyus_title)}</td>
                <td>${esc(item.whyus_card_number)}</td>
                <td>${esc(item.whyus_description)}</td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm btn-custom" onclick="editWhyUs(${esc(item.whyus_id)})">Edit</button>
                    <button class="btn btn-danger btn-sm btn-custom" onclick="deleteWhyUs(${esc(item.whyus_id)})">Delete</button>
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


// Handle form submission (demo only)
document.addEventListener('DOMContentLoaded', function() {
});

// Load the table, then keep it current (crmLiveRefresh)
document.addEventListener('DOMContentLoaded', () => {
    startPolling();
});
</script>

<script>
// Real create / edit / delete (data/content_admin.php); replaces the old demo-only handlers.
(function () {
  const resource = "why_us", pk = "whyus_id", noun = "card", labelField = "whyus_title";
  const fields = [{"label": "Card number", "name": "whyus_card_number", "type": "text", "required": true, "placeholder": "e.g. 01"}, {"label": "Title", "name": "whyus_title", "type": "text", "required": true}, {"label": "Description", "name": "whyus_description", "type": "textarea", "required": true, "rows": 4}];
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
  window["editWhyUs"] = edit;
  
  window["deleteWhyUs"] = (id) => crmContentDelete({ resource, id, label: (rows[id] && rows[id][labelField]) || noun, onDone: reload });
})();
</script>
