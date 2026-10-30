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
                    <h3 class="text-primary">Stats Management</h3>
                    <small class="text-muted">Manage stats data</small>
                    <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="crmAddContent()"><i class="fas fa-plus mr-1"></i> Add statistic</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="statsTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary">ID</th>
                            <th class="text-primary">Stat</th>
                            <th class="text-primary">Counts</th>
                            <th class="text-primary">Date Added</th>
                            <th class="text-primary">Last Modified</th>
                            <th class="text-primary text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody id="stats-table-body">
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

        <!-- Add the modal for viewing/editing stats -->
        <div class="modal fade" id="viewStatModal" tabindex="-1" role="dialog" aria-labelledby="viewStatModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="viewStatModalLabel">Edit Stat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="editStatForm">
                <div class="modal-body">
                  <ul class="list-group mb-3" id="statDetailsList">
                    <!-- Stat details will be injected here -->
                  </ul>
                  <div class="form-group">
                    <label for="editStatInput">Stat</label>
                    <input type="text" class="form-control" id="editStatInput" name="stat" required>
                  </div>
                  <div class="form-group">
                    <label for="editCountsInput">Counts</label>
                    <input type="number" class="form-control" id="editCountsInput" name="counts" required>
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

.table-data2 th:nth-child(2), /* Stat */
.table-data2 td:nth-child(2) {
    width: 150px;
}

.table-data2 th:nth-child(3), /* Counts */
.table-data2 td:nth-child(3) {
    width: 100px;
}

.table-data2 th:nth-child(4), /* Date Added */
.table-data2 td:nth-child(4) {
    width: 150px;
}

.table-data2 th:nth-child(5), /* Last Modified */
.table-data2 td:nth-child(5) {
    width: 150px;
}

.table-data2 th:nth-child(6), /* Action */
.table-data2 td:nth-child(6) {
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
    fetch(`./data/stats_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data fetched:', data); // Debugging information
            renderTable(data);
        })
        .catch(error => console.error('Error loading data:', error));
}

// Function to render table
function renderTable(statsData) {
    const tableBody = document.getElementById('stats-table-body');
    tableBody.innerHTML = '';

    if (statsData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6">No data available</td></tr>';
        return;
    }

    // Store all stats in a global variable for modal lookup
    window.allStatsData = statsData;

    statsData.forEach(item => {
        const row = `
            <tr class='tr-shadow'>
                <td>${esc(item.stats_id)}</td>
                <td>${esc(item.stat)}</td>
                <td>${esc(item.counts)}</td>
                <td>${esc(item.date_added)}</td>
                <td>${esc(item.last_modified)}</td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm btn-custom" onclick="editStat(${esc(item.stats_id)})">Edit</button>
                    <button class="btn btn-danger btn-sm btn-custom" onclick="deleteStat(${esc(item.stats_id)})">Delete</button>
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


// Optional: handle form submission (demo only)
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
  const resource = "stats", pk = "stats_id", noun = "statistic", labelField = "stat";
  const fields = [{"label": "Label", "name": "stat", "type": "text", "required": true, "placeholder": "e.g. Happy clients"}, {"label": "Number", "name": "counts", "type": "number", "required": true}];
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
  window["editStat"] = edit;
  
  window["deleteStat"] = (id) => crmContentDelete({ resource, id, label: (rows[id] && rows[id][labelField]) || noun, onDone: reload });
})();
</script>
