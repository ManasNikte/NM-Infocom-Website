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
                    <h3 class="text-primary">Team Management</h3>
                    <small class="text-muted">Manage team members</small>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="teamTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary">ID</th>
                            <th class="text-primary">Name</th>
                            <th class="text-primary">Post</th>
                            <th class="text-primary">Image</th>
                            <th class="text-primary">Instagram</th>
                            <th class="text-primary">GitHub</th>
                            <th class="text-primary">LinkedIn</th>
                            <th class="text-primary">X</th>
                            <th class="text-primary">Website</th>
                            <th class="text-primary">Date Added</th>
                            <th class="text-primary">Last Modified</th>
                            <th class="text-primary">Status</th>
                            <th class="text-primary text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody id="team-table-body">
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

        <!-- Edit Team Member Modal -->
        <div class="modal fade" id="editTeamModal" tabindex="-1" role="dialog" aria-labelledby="editTeamModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editTeamModalLabel">
                  <i class="fa fa-edit mr-2"></i>Edit Team Member
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="editTeamForm">
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="editEmpName" class="font-weight-bold text-primary">Name</label>
                        <input type="text" class="form-control" id="editEmpName" name="emp_name" required>
                      </div>
                      <div class="form-group">
                        <label for="editEmpPost" class="font-weight-bold text-primary">Post</label>
                        <input type="text" class="form-control" id="editEmpPost" name="emp_post" required>
                      </div>
                      <div class="form-group">
                        <label for="editStatus" class="font-weight-bold text-primary">Status</label>
                        <select class="form-control" id="editStatus" name="status" required>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="editInstaLink" class="font-weight-bold text-primary">Instagram</label>
                        <input type="url" class="form-control" id="editInstaLink" name="insta_link" placeholder="https://instagram.com/...">
                      </div>
                      <div class="form-group">
                        <label for="editGithubLink" class="font-weight-bold text-primary">GitHub</label>
                        <input type="url" class="form-control" id="editGithubLink" name="github_link" placeholder="https://github.com/...">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="editLinkedinLink" class="font-weight-bold text-primary">LinkedIn</label>
                        <input type="url" class="form-control" id="editLinkedinLink" name="linkedin_link" placeholder="https://linkedin.com/...">
                      </div>
                      <div class="form-group">
                        <label for="editXLink" class="font-weight-bold text-primary">X (Twitter)</label>
                        <input type="url" class="form-control" id="editXLink" name="x_link" placeholder="https://x.com/...">
                      </div>
                      <div class="form-group">
                        <label for="editWebLink" class="font-weight-bold text-primary">Website</label>
                        <input type="url" class="form-control" id="editWebLink" name="web_link" placeholder="https://...">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-primary">Current Image</label>
                        <div class="text-center mt-2">
                          <img id="currentEmpImg" src="" alt="Current Image" class="img-fluid rounded border" style="max-width: 120px; height: auto; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </div>
                      </div>
                    </div>
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

.table-data2 th:nth-child(2), /* Name */
.table-data2 td:nth-child(2) {
    width: 150px;
}

.table-data2 th:nth-child(3), /* Post */
.table-data2 td:nth-child(3) {
    width: 150px;
}

.table-data2 th:nth-child(4), /* Image */
.table-data2 td:nth-child(4) {
    width: 150px;
}

.table-data2 th:nth-child(5), /* Instagram */
.table-data2 td:nth-child(5) {
    width: 150px;
}

.table-data2 th:nth-child(6), /* GitHub */
.table-data2 td:nth-child(6) {
    width: 150px;
}

.table-data2 th:nth-child(7), /* LinkedIn */
.table-data2 td:nth-child(7) {
    width: 150px;
}

.table-data2 th:nth-child(8), /* X */
.table-data2 td:nth-child(8) {
    width: 150px;
}

.table-data2 th:nth-child(9), /* Website */
.table-data2 td:nth-child(9) {
    width: 150px;
}

.table-data2 th:nth-child(10), /* Date Added */
.table-data2 td:nth-child(10) {
    width: 150px;
}

.table-data2 th:nth-child(11), /* Last Modified */
.table-data2 td:nth-child(11) {
    width: 150px;
}

.table-data2 th:nth-child(12), /* Status */
.table-data2 td:nth-child(12) {
    width: 100px;
}

.table-data2 th:nth-child(13), /* Action */
.table-data2 td:nth-child(13) {
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
    fetch(`./data/team_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data fetched:', data);
            renderTable(data);
        })
        .catch(error => console.error('Error loading data:', error));
}

// Function to render table
function renderTable(teamData) {
    const tableBody = document.getElementById('team-table-body');
    tableBody.innerHTML = '';
    window.allTeamData = teamData;
    
    if (teamData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="13">No data available</td></tr>';
        return;
    }
    
    teamData.forEach(item => {
        const row = `
            <tr class='tr-shadow'>
                <td>${esc(item.emp_id)}</td>
                <td>${esc(item.emp_name)}</td>
                <td>${esc(item.emp_post)}</td>
                <td><img src="../../../${esc(item.emp_img)}" alt="${esc(item.emp_name)}" width="50"></td>
                <td><a href="${esc(item.insta_link)}" target="_blank">Instagram</a></td>
                <td><a href="${esc(item.github_link)}" target="_blank">GitHub</a></td>
                <td><a href="${esc(item.linkedin_link)}" target="_blank">LinkedIn</a></td>
                <td><a href="${esc(item.x_link)}" target="_blank">X</a></td>
                <td><a href="${esc(item.web_link)}" target="_blank">Website</a></td>
                <td>${esc(item.date_added)}</td>
                <td>${esc(item.last_modified)}</td>
                <td>${esc(item.status)}</td>
                <td class="text-center">
                    <button class="btn btn-primary btn-edit" data-id="${esc(item.emp_id)}">Edit</button>
                    <button class="btn btn-danger btn-delete" data-id="${esc(item.emp_id)}">Delete</button>
                </td>
            </tr>
            <tr class='spacer'></tr>
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

// Event delegation for edit and delete buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit')) {
        const id = e.target.getAttribute('data-id');
        editTeamMember(id);
    } else if (e.target.classList.contains('btn-delete')) {
        const id = e.target.getAttribute('data-id');
        deleteTeamMember(id);
    }
});

// Function to handle edit action
function editTeamMember(id) {
    console.log('Edit button clicked for ID:', id);
    const item = (window.allTeamData || []).find(i => i.emp_id == id);
    console.log('Found item:', item);
    
    if (!item) {
        alert('Team member not found!');
        return;
    }
    
    // Set form values
    document.getElementById('editEmpName').value = item.emp_name;
    document.getElementById('editEmpPost').value = item.emp_post;
    document.getElementById('editInstaLink').value = item.insta_link;
    document.getElementById('editGithubLink').value = item.github_link;
    document.getElementById('editLinkedinLink').value = item.linkedin_link;
    document.getElementById('editXLink').value = item.x_link;
    document.getElementById('editWebLink').value = item.web_link;
    document.getElementById('editStatus').value = item.status;
    document.getElementById('currentEmpImg').src = item.emp_img;
    document.getElementById('editTeamForm').setAttribute('data-id', item.emp_id);
    
    // Show the modal
    $('#editTeamModal').modal('show');
}

// Function to handle delete action
function deleteTeamMember(id) {
    if (confirm('Are you sure you want to delete this team member?')) {
        console.log('Delete button clicked for ID:', id);
        alert('Delete functionality would be implemented here (Demo only)');
    }
}

// Handle form submission
document.getElementById('editTeamForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Form submitted');
    const empId = this.getAttribute('data-id');
    const empName = document.getElementById('editEmpName').value;
    const empPost = document.getElementById('editEmpPost').value;
    const instaLink = document.getElementById('editInstaLink').value;
    const githubLink = document.getElementById('editGithubLink').value;
    const linkedinLink = document.getElementById('editLinkedinLink').value;
    const xLink = document.getElementById('editXLink').value;
    const webLink = document.getElementById('editWebLink').value;
    const status = document.getElementById('editStatus').value;
    
    console.log('Submitting:', { empId, empName, empPost, instaLink, githubLink, linkedinLink, xLink, webLink, status });
    alert('Submitted!\nID: ' + empId + '\nName: ' + empName + '\nPost: ' + empPost + '\nStatus: ' + status + '\n(Demo only, not saved)');
    $('#editTeamModal').modal('hide');
});

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing team management');
    
    // Initialize modal events
    $('#editTeamModal').on('shown.bs.modal', function () {
        console.log('Modal is now visible');
    });
    
    $('#editTeamModal').on('hidden.bs.modal', function () {
        console.log('Modal is now hidden');
        // Reset form when modal is closed
        document.getElementById('editTeamForm').reset();
    });
    
    // Start polling
    startPolling();
});
</script>