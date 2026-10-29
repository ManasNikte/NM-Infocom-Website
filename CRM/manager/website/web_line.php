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
                    <h3 class="text-primary">Web Line Management</h3>
                    <small class="text-muted">Manage web line data</small>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover" id="webLineTable">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-primary">ID</th>
                            <th class="text-primary">Site Name</th>
                            <th class="text-primary">Why Us Intro</th>
                            <th class="text-primary">Team Intro</th>
                            <th class="text-primary">Address</th>
                            <th class="text-primary">Contact No</th>
                            <th class="text-primary">Email</th>
                            <th class="text-primary">Map Link</th>
                            <th class="text-primary">Twitter</th>
                            <th class="text-primary">Facebook</th>
                            <th class="text-primary">Instagram</th>
                            <th class="text-primary">LinkedIn</th>
                            <th class="text-primary">Last Updated</th>
                            <th class="text-primary text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody id="web-line-table-body">
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

.table-data2 th:nth-child(2), /* Site Name */
.table-data2 td:nth-child(2) {
    width: 150px;
}

.table-data2 th:nth-child(3), /* Why Us Intro */
.table-data2 td:nth-child(3) {
    width: 200px;
}

.table-data2 th:nth-child(4), /* Team Intro */
.table-data2 td:nth-child(4) {
    width: 200px;
}

.table-data2 th:nth-child(5), /* Address */
.table-data2 td:nth-child(5) {
    width: 250px;
}

.table-data2 th:nth-child(6), /* Contact No */
.table-data2 td:nth-child(6) {
    width: 150px;
}

.table-data2 th:nth-child(7), /* Email */
.table-data2 td:nth-child(7) {
    width: 200px;
}

.table-data2 th:nth-child(8), /* Map Link */
.table-data2 td:nth-child(8) {
    width: 200px;
}

.table-data2 th:nth-child(9), /* Twitter */
.table-data2 td:nth-child(9) {
    width: 150px;
}

.table-data2 th:nth-child(10), /* Facebook */
.table-data2 td:nth-child(10) {
    width: 150px;
}

.table-data2 th:nth-child(11), /* Instagram */
.table-data2 td:nth-child(11) {
    width: 150px;
}

.table-data2 th:nth-child(12), /* LinkedIn */
.table-data2 td:nth-child(12) {
    width: 150px;
}

.table-data2 th:nth-child(13), /* Last Updated */
.table-data2 td:nth-child(13) {
    width: 150px;
}

.table-data2 th:nth-child(14), /* Action */
.table-data2 td:nth-child(14) {
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

/* Add/Update custom CSS for action buttons and modal styling */
const style = document.createElement('style');
style.innerHTML = `
  .btn-group .btn-custom-webline {
    min-width: 90px;
    max-width: 100px;
    margin-right: 12px;
    padding: 0.45rem 0.85rem;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: box-shadow 0.2s;
  }
  .btn-group .btn-custom-webline:last-child {
    margin-right: 0;
  }
  .btn-edit-webline {
    background: linear-gradient(90deg, #36d1c4 0%, #5b86e5 100%);
    color: #fff;
    border: none;
  }
  .btn-edit-webline:hover, .btn-edit-webline:focus {
    box-shadow: 0 2px 8px rgba(54,209,196,0.15);
    color: #fff;
  }
  .btn-delete-webline {
    background: linear-gradient(90deg, #ff5858 0%, #f09819 100%);
    color: #fff;
    border: none;
  }
  .btn-delete-webline:hover, .btn-delete-webline:focus {
    box-shadow: 0 2px 8px rgba(255,88,88,0.15);
    color: #fff;
  }
  .modal-content.webline-modal {
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(54,209,196,0.12);
    border: none;
  }
  .modal-header.webline-header {
    background: linear-gradient(90deg, #36d1c4 0%, #5b86e5 100%);
    color: #fff;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    border-bottom: none;
  }
  .modal-footer.webline-footer {
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 16px;
    background: #f8f9fa;
    border-top: none;
  }
  .modal-body.webline-body {
    padding-top: 1.2rem;
    padding-bottom: 1.2rem;
    background: #fff;
  }
  .modal-body.webline-body .form-group label {
    margin-bottom: 0.3rem;
  }
`;
document.head.appendChild(style);
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;
let pollingInterval;

// Function to load table data
function loadTableData(page = 1) {
    fetch(`./data/web_line_data.php?page=${page}&rowsPerPage=${rowsPerPage}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data fetched:', data); // Debugging information
            renderTable(data);
        })
        .catch(error => console.error('Error loading data:', error));
}

// Function to render table
function renderTable(webLineData) {
    const tableBody = document.getElementById('web-line-table-body');
    tableBody.innerHTML = '';
    window.allWebLineData = webLineData;
    if (webLineData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="14">No data available</td></tr>';
        return;
    }
    webLineData.forEach(item => {
        const row = `
            <tr class='tr-shadow'>
                <td>${esc(item.web_id)}</td>
                <td>${esc(item.site_name)}</td>
                <td>${esc(item.whyus_introline)}</td>
                <td>${esc(item.team_introline)}</td>
                <td>${esc(item.address)}</td>
                <td>${esc(item.contact_no)}</td>
                <td>${esc(item.email)}</td>
                <td>${esc(item.map_link)}</td>
                <td>${esc(item.twitter_link)}</td>
                <td>${esc(item.facebook_link)}</td>
                <td>${esc(item.instagram_link)}</td>
                <td>${esc(item.linkedin_link)}</td>
                <td>${esc(item.last_updated)}</td>
                <td class="text-center">
                    <div class="btn-group" role="group" aria-label="Web Line Actions">
                      <button class="btn btn-custom-webline btn-edit-webline" data-id="${esc(item.web_id)}"><i class="fa fa-edit mr-1"></i>Edit</button>
                      <button class="btn btn-custom-webline btn-delete-webline" data-id="${esc(item.web_id)}"><i class="fa fa-trash mr-1"></i>Delete</button>
                    </div>
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

// Function to handle edit action
function editWebLine(id) {
    // Redirect to edit page or open a modal for editing
    window.location.href = `edit_web_line.php?id=${id}`;
}

// Start polling when the page loads
document.addEventListener('DOMContentLoaded', () => {
    startPolling();
});

// Event delegation for edit and delete buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit-webline')) {
        const id = e.target.getAttribute('data-id');
        editWebLinePopup(id);
    } else if (e.target.classList.contains('btn-delete-webline')) {
        const id = e.target.getAttribute('data-id');
        deleteWebLine(id);
    }
});

// Edit Web Line popup logic
function editWebLinePopup(id) {
    const item = (window.allWebLineData || []).find(i => i.web_id == id);
    if (!item) {
        alert('Web Line not found!');
        return;
    }
    document.getElementById('editWebId').value = item.web_id;
    document.getElementById('editSiteName').value = item.site_name;
    document.getElementById('editWhyUsIntro').value = item.whyus_introline;
    document.getElementById('editTeamIntro').value = item.team_introline;
    document.getElementById('editAddress').value = item.address;
    document.getElementById('editContactNo').value = item.contact_no;
    document.getElementById('editEmail').value = item.email;
    document.getElementById('editMapLink').value = item.map_link;
    document.getElementById('editTwitter').value = item.twitter_link;
    document.getElementById('editFacebook').value = item.facebook_link;
    document.getElementById('editInstagram').value = item.instagram_link;
    document.getElementById('editLinkedIn').value = item.linkedin_link;
    document.getElementById('editLastUpdated').value = item.last_updated;
    document.getElementById('editWebLineForm').setAttribute('data-id', item.web_id);
    $('#editWebLineModal').modal('show');
}

// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('editWebLineForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const webId = this.getAttribute('data-id');
        const siteName = document.getElementById('editSiteName').value;
        const whyUsIntro = document.getElementById('editWhyUsIntro').value;
        const teamIntro = document.getElementById('editTeamIntro').value;
        const address = document.getElementById('editAddress').value;
        const contactNo = document.getElementById('editContactNo').value;
        const email = document.getElementById('editEmail').value;
        const mapLink = document.getElementById('editMapLink').value;
        const twitter = document.getElementById('editTwitter').value;
        const facebook = document.getElementById('editFacebook').value;
        const instagram = document.getElementById('editInstagram').value;
        const linkedin = document.getElementById('editLinkedIn').value;
        alert('Submitted!\nID: ' + webId + '\nSite Name: ' + siteName + '\nWhy Us Intro: ' + whyUsIntro + '\nTeam Intro: ' + teamIntro + '\nAddress: ' + address + '\nContact No: ' + contactNo + '\nEmail: ' + email + '\nMap Link: ' + mapLink + '\nTwitter: ' + twitter + '\nFacebook: ' + facebook + '\nInstagram: ' + instagram + '\nLinkedIn: ' + linkedin + '\n(Demo only, not saved)');
        $('#editWebLineModal').modal('hide');
    });
});

// Delete Web Line logic
function deleteWebLine(id) {
    if (confirm('Are you sure you want to delete this web line entry?')) {
        alert('Delete functionality would be implemented here (Demo only)');
    }
}
</script>

<!-- Edit Web Line Modal -->
<div class="modal fade" id="editWebLineModal" tabindex="-1" role="dialog" aria-labelledby="editWebLineModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content webline-modal">
      <div class="modal-header webline-header">
        <h5 class="modal-title" id="editWebLineModalLabel">
          <i class="fa fa-edit mr-2"></i>Edit Web Line
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editWebLineForm">
        <div class="modal-body webline-body" style="max-height: 70vh; overflow-y: auto;">
          <div class="form-group mb-2">
            <label class="font-weight-bold text-primary">ID</label>
            <input type="text" class="form-control-plaintext" id="editWebId" readonly>
          </div>
          <div class="form-group mb-2">
            <label for="editSiteName" class="font-weight-bold text-primary">Site Name</label>
            <input type="text" class="form-control" id="editSiteName" name="site_name" required>
          </div>
          <div class="form-group mb-2">
            <label for="editWhyUsIntro" class="font-weight-bold text-primary">Why Us Intro</label>
            <input type="text" class="form-control" id="editWhyUsIntro" name="whyus_introline" required>
          </div>
          <div class="form-group mb-2">
            <label for="editTeamIntro" class="font-weight-bold text-primary">Team Intro</label>
            <input type="text" class="form-control" id="editTeamIntro" name="team_introline" required>
          </div>
          <div class="form-group mb-2">
            <label for="editAddress" class="font-weight-bold text-primary">Address</label>
            <input type="text" class="form-control" id="editAddress" name="address" required>
          </div>
          <div class="form-group mb-2">
            <label for="editContactNo" class="font-weight-bold text-primary">Contact No</label>
            <input type="text" class="form-control" id="editContactNo" name="contact_no" required>
          </div>
          <div class="form-group mb-2">
            <label for="editEmail" class="font-weight-bold text-primary">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>
          <div class="form-group mb-2">
            <label for="editMapLink" class="font-weight-bold text-primary">Map Link</label>
            <input type="url" class="form-control" id="editMapLink" name="map_link">
          </div>
          <div class="form-group mb-2">
            <label for="editTwitter" class="font-weight-bold text-primary">Twitter</label>
            <input type="url" class="form-control" id="editTwitter" name="twitter_link">
          </div>
          <div class="form-group mb-2">
            <label for="editFacebook" class="font-weight-bold text-primary">Facebook</label>
            <input type="url" class="form-control" id="editFacebook" name="facebook_link">
          </div>
          <div class="form-group mb-2">
            <label for="editInstagram" class="font-weight-bold text-primary">Instagram</label>
            <input type="url" class="form-control" id="editInstagram" name="instagram_link">
          </div>
          <div class="form-group mb-2">
            <label for="editLinkedIn" class="font-weight-bold text-primary">LinkedIn</label>
            <input type="url" class="form-control" id="editLinkedIn" name="linkedin_link">
          </div>
          <div class="form-group mb-2">
            <label class="font-weight-bold text-primary">Last Updated</label>
            <input type="text" class="form-control-plaintext" id="editLastUpdated" readonly>
          </div>
        </div>
        <div class="modal-footer webline-footer">
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