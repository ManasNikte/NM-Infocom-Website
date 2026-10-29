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
                    <h3 class="text-primary">Client Logos Management</h3>
                    <small class="text-muted">Manage client logos</small>
                    <div class="mt-3 mb-2 d-flex justify-content-end">
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addClientModal">
                        <i class="fa fa-plus"></i> Add New Client
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="clientLogosTable">
                        <thead class="thead-light">
                          <tr>
                            <th class="text-primary">ID</th>
                            <th class="text-primary">Client Logo</th>
                            <th class="text-primary">Client Name</th>
                            <th class="text-primary">Date Added</th>
                            <th class="text-primary">Last Modified</th>
                            <th class="text-primary">Action</th>
                          </tr>
                        </thead>
                        <tbody id="client-logos-table-body">
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
        <!-- Add New Client Modal -->
        <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add New Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="addClientForm" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="clientName">Client Name</label>
                    <input type="text" class="form-control" id="clientName" name="client_name" required>
                  </div>
                  <div class="form-group">
                    <label for="clientLogo">Client Logo</label>
                    <input type="file" class="form-control-file" id="clientLogo" name="client_logo" accept="image/*" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Add Client</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Edit Client Modal -->
        <div class="modal fade" id="editClientModal" tabindex="-1" role="dialog" aria-labelledby="editClientModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editClientModalLabel">Edit Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="editClientForm" enctype="multipart/form-data">
                <div class="modal-body">
                  <ul class="list-group mb-3" id="clientDetailsList">
                    <!-- Client details will be injected here -->
                  </ul>
                  <div class="form-group">
                    <label for="editClientName">Client Name</label>
                    <input type="text" class="form-control" id="editClientName" name="client_name" required>
                  </div>
                  <div class="form-group">
                    <label for="editClientLogo">Client Logo</label>
                    <input type="file" class="form-control-file" id="editClientLogo" name="client_logo" accept="image/*">
                    <div class="mt-2">
                      <img id="currentClientLogo" src="" alt="Current Logo" class="img-fluid rounded" style="max-width: 100px; height: auto;">
                    </div>
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
/* Remove most custom table styles, keep only minimal adjustments */
.table-responsive {
    overflow-x: auto;
}
.table th, .table td {
    vertical-align: middle !important;
    text-align: center;
}
.table img {
    max-width: 100px;
    height: auto;
}
.btn-edit, .btn-delete {
    padding: 8px 12px;
    font-size: 0.9rem;
    border-radius: 4px;
    margin: 0 2px;
    width: 80px;
    height: 40px;
    display: inline-block;
    text-align: center;
    line-height: 24px;
    box-sizing: border-box;
}
.btn-edit {
    background-color: #007bff;
    color: white;
}
.btn-delete {
    background-color: #dc3545;
    color: white;
}
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;
let pollingInterval;

// Function to load table data
function loadTableData(page = 1) {
    fetch(`./data/client_logo_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
        .then(response => response.json())
        .then(data => {
            renderTable(data);
        })
        .catch(error => console.error('Error loading data:', error));
}

// Function to render table
function renderTable(clientLogos) {
    const tableBody = document.getElementById('client-logos-table-body');
    tableBody.innerHTML = '';
    window.allClientLogos = clientLogos;
    clientLogos.forEach(client => {
        const row = `
            <tr>
                <td>${esc(client.client_id)}</td>
                <td>
                    <img src="../../../${esc(client.client_img)}" alt="Client Logo" 
                         class="img-fluid rounded" 
                         onerror="this.src='placeholder-image.jpg'">
                </td>
                <td>${esc(client.client_name)}</td>
                <td>${esc(client.date_added)}</td>
                <td>${esc(client.last_modified)}</td>
                <td>
                    <button class="btn btn-primary btn-edit" onclick="editClient(${esc(client.client_id)})">Edit</button>
                    <button class="btn btn-danger btn-delete">Delete</button>
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
}

// Function to start polling
function startPolling() {
    loadTableData(currentPage);
    pollingInterval = setInterval(() => {
        loadTableData(currentPage);
    }, 3000);
}

// Start polling when the page loads
document.addEventListener('DOMContentLoaded', () => {
    startPolling();
});

// Edit button handler
function editClient(id) {
    const client = (window.allClientLogos || []).find(c => c.client_id == id);
    let html = '';
    if (client) {
        html += `<li class='list-group-item'><strong>ID:</strong> ${esc(client.client_id)}</li>`;
        html += `<li class='list-group-item'><strong>Date Added:</strong> ${esc(client.date_added)}</li>`;
        html += `<li class='list-group-item'><strong>Last Modified:</strong> ${esc(client.last_modified)}</li>`;
        setTimeout(function() {
            document.getElementById('editClientName').value = client.client_name;
            document.getElementById('currentClientLogo').src = '../../../' + client.client_img;
            document.getElementById('editClientForm').setAttribute('data-id', client.client_id);
        }, 200);
    } else {
        html = `<li class='list-group-item'>No data found for this entry.</li>`;
        setTimeout(function() {
            document.getElementById('editClientName').value = '';
            document.getElementById('currentClientLogo').src = '';
            document.getElementById('editClientForm').removeAttribute('data-id');
        }, 200);
    }
    document.getElementById('clientDetailsList').innerHTML = html;
    $('#editClientModal').modal('show');
}

// Handle form submission (demo only)
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('editClientForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const clientId = this.getAttribute('data-id');
    const clientName = document.getElementById('editClientName').value;
    // For demo, we do not handle file upload
    alert('Submitted!\nID: ' + clientId + '\nClient Name: ' + clientName + '\n(Demo only, not saved)');
    $('#editClientModal').modal('hide');
  });
});
</script>