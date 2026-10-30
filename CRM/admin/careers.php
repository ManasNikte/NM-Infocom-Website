<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content" style="min-height: 100vh;">
        <div class="section__content section__content--p30">
          <div class="container-fluid" style="min-height: 90vh; display: flex; flex-direction: column; justify-content: flex-start;">
          <?php require_once __DIR__ . '/Analytics/career_analytics_cards.php'; ?>

            <!-- Jobs Application Table Card -->
            <div class="row mt-6" style="margin-bottom: 32px;">
              <div class="col-md-12">
                <div class="card shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f5f7ff);">
                  <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                    <h3 class="mb-0 text-white">Jobs Applications</h3>
                  </div>
                  <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="searchJobApplications" class="form-control" placeholder="Search by any column" onkeyup="searchJobApplicationsTable()">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="zmdi zmdi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-center text-primary">ID</th>
                            <th class="text-center text-primary">Job ID</th>
                            <th class="text-center text-primary">Full Name</th>
                            <th class="text-center text-primary">Email</th>
                            <th class="text-center text-primary">Contact</th>
                            <th class="text-center text-primary">Location</th>
                            <th class="text-center text-primary">Resume</th>
                            <th class="text-center text-primary">Status</th>
                            <th class="text-center text-primary">Date Applied</th>
                            <th class="text-center text-primary">Action</th>
                          </tr>
                        </thead>
                        <tbody id="jobApplicantsTableBody">
                          <tr><td colspan="9" class="text-center text-muted">Loading...</td></tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- Applicants Pagination Controls -->
                    <nav aria-label="Applicants pagination" class="mt-2">
                      <ul class="pagination justify-content-center" id="applicantsPagination"></ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>

            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 24px; display: flex; align-items: center; min-height: 60px;">
                    <h3 class="mb-0 text-white">Jobs</h3>
                    <small class="text-white-50 ml-3">Manage jobs</small>
                  </div>
                  <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="searchBar" class="form-control" placeholder="Search by any column" onkeyup="searchSubmissions()">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="zmdi zmdi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-block" id="addNewLead" type="button">
                                <i class="zmdi zmdi-plus mr-2"></i>Add New Job
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                      <table class="table table-data2 table-hover">
                        <thead class="bg-light">
                          <tr>
                            <th class="text-center text-primary">ID</th>
                            <th class="text-center text-primary">Title</th>
                            <th class="text-center text-primary">Category</th>
                            <th class="text-center text-primary">Type</th>
                            <th class="text-center text-primary">Location</th>
                            <th class="text-center text-primary">Salary</th>
                            <th class="text-center text-primary">Description</th>
                            <th class="text-center text-primary">Skills</th>
                            <th class="text-center text-primary">Icon</th>
                            <th class="text-center text-primary">Date Posted</th>
                            <th class="text-center text-primary">Deadline</th>
                            <th class="text-center text-primary">Experience</th>
                            <th class="text-center text-primary">Education</th>
                            <th class="text-center text-primary">Responsibilities</th>
                            <th class="text-center text-primary">Requirements</th>
                            <th class="text-center text-primary">Date Added</th>
                            <th class="text-center text-primary">Last Modified</th>
                            <th class="text-center text-primary">Action</th>
                          </tr>
                        </thead>
                        <tbody id="careerTableBody">
                          <!-- Data will be inserted here -->
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
      </div>
      <!-- END MAIN CONTENT-->

      <!-- Edit Job Modal -->
      <div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editJobModalLabel">Edit Job</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="editJobForm">
                <input type="hidden" id="editJobId" name="id">
                <div class="form-group">
                  <label for="editJobTitle">Title</label>
                  <input type="text" class="form-control" id="editJobTitle" name="title" required>
                </div>
                <div class="form-group">
                  <label for="editJobCategory">Category</label>
                  <input type="text" class="form-control" id="editJobCategory" name="category" required>
                </div>
                <div class="form-group">
                  <label for="editJobType">Type</label>
                  <input type="text" class="form-control" id="editJobType" name="type" required>
                </div>
                <div class="form-group">
                  <label for="editJobLocation">Location</label>
                  <input type="text" class="form-control" id="editJobLocation" name="location" required>
                </div>
                <div class="form-group">
                  <label for="editJobSalary">Salary (INR)</label>
                  <input type="text" class="form-control" id="editJobSalary" name="salary" placeholder="e.g. ₹25,000 - ₹40,000 per month or 6 - 9 LPA" required>
                </div>
                <div class="form-group">
                  <label for="editJobDescription">Description</label>
                  <textarea class="form-control" id="editJobDescription" name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                  <label for="editJobSkills">Skills</label>
                  <textarea class="form-control" id="editJobSkills" name="skills" rows="3" required></textarea>
                </div>
                <div class="form-group">
                  <label for="editJobIcon">Icon</label>
                  <input type="text" class="form-control" id="editJobIcon" name="icon" required>
                </div>
                <div class="form-group">
                  <label for="editJobDatePosted">Date Posted</label>
                  <input type="date" class="form-control" id="editJobDatePosted" name="date_posted" required>
                </div>
                <div class="form-group">
                  <label for="editJobDeadline">Deadline</label>
                  <input type="date" class="form-control" id="editJobDeadline" name="deadline" required>
                </div>
                <div class="form-group">
                  <label for="editJobExperience">Experience</label>
                  <input type="text" class="form-control" id="editJobExperience" name="experience" required>
                </div>
                <div class="form-group">
                  <label for="editJobEducation">Education</label>
                  <input type="text" class="form-control" id="editJobEducation" name="education" required>
                </div>
                <div class="form-group">
                  <label for="editJobResponsibilities">Responsibilities</label>
                  <textarea class="form-control" id="editJobResponsibilities" name="responsibilities" rows="3" required></textarea>
                </div>
                <div class="form-group">
                  <label for="editJobRequirements">Requirements</label>
                  <textarea class="form-control" id="editJobRequirements" name="requirements" rows="3" required></textarea>
                </div>
                <div class="form-group">
                  <label for="editJobStatus">Status</label>
                  <input type="text" class="form-control" id="editJobStatus" name="status" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Job</button>
              </form>
            </div>
          </div>
        </div>
      </div>

<?php require './bottom.php'; ?>

<style>
/* Modern Card Styles */
.card {
  border-radius: 20px;
  box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
  background: #fff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  min-height: 100%;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(44, 62, 80, 0.13) !important;
}
/* Add gap between stacked cards */
.card + .card {
  margin-top: 32px;
}
.card-header {
  border-radius: 20px 20px 0 0;
  background: linear-gradient(45deg, #1a237e, #4e73df);
  color: #fff;
  font-family: 'Nunito', sans-serif;
  font-size: 1.2rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  padding: 16px 24px;
  display: flex;
  align-items: center;
  min-height: 60px;
}
.card-body {
  font-family: 'Nunito', sans-serif;
  font-size: 1rem;
  color: #2c3e50;
}

/* Table Styles */
.table-responsive-data2 {
    overflow-x: auto;
    margin: 0 -15px;
    padding: 0 15px;
    display: block;
    width: 100%;
}
.table-data2 {
    min-width: 1800px;
    width: auto;
    margin-left: 0;
    margin-right: 0;
    table-layout: auto;
    border-collapse: separate;
    border-spacing: 0;
}
.table-data2 td, .table-data2 th {
    white-space: normal !important;
    overflow: visible !important;
    text-overflow: initial !important;
    word-break: break-word;
    padding: 12px 8px !important;
    vertical-align: middle !important;
    font-size: 0.98rem;
    line-height: 1.5;
    text-align: center;
}
.table-data2 thead th {
    font-weight: 600;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle !important;
    position: sticky;
    top: 0;
    z-index: 1;
    padding: 14px 8px !important;
}
.table-data2 tbody tr {
    transition: background 0.2s, box-shadow 0.2s;
}
.table-data2 tbody tr:nth-child(even) {
    background: #f8faff;
}
.table-data2 tbody tr:hover {
    background: #f1f6ff !important;
    box-shadow: 0 4px 18px rgba(78,115,223,0.10);
    z-index: 2;
    position: relative;
}
.tr-shadow {
    height: auto !important;
    border-radius: 8px;
    transition: all 0.3s;
}
.spacer {
    height: 4px;
}

/* Column widths (adjust as needed) */
.table-data2 th, .table-data2 td {
    min-width: 100px;
}
.table-data2 th:nth-child(1), .table-data2 td:nth-child(1) { width: 50px; }
.table-data2 th:nth-child(2), .table-data2 td:nth-child(2) { width: 150px; }
.table-data2 th:nth-child(3), .table-data2 td:nth-child(3) { width: 100px; }
.table-data2 th:nth-child(4), .table-data2 td:nth-child(4) { width: 100px; }
.table-data2 th:nth-child(5), .table-data2 td:nth-child(5) { width: 150px; }
.table-data2 th:nth-child(6), .table-data2 td:nth-child(6) { width: 100px; }
.table-data2 th:nth-child(7), .table-data2 td:nth-child(7) { width: 200px; }
.table-data2 th:nth-child(8), .table-data2 td:nth-child(8) { width: 200px; }
.table-data2 th:nth-child(9), .table-data2 td:nth-child(9) { width: 100px; }
.table-data2 th:nth-child(10), .table-data2 td:nth-child(10) { width: 150px; }
.table-data2 th:nth-child(11), .table-data2 td:nth-child(11) { width: 150px; }
.table-data2 th:nth-child(12), .table-data2 td:nth-child(12) { width: 150px; }
.table-data2 th:nth-child(13), .table-data2 td:nth-child(13) { width: 150px; }
.table-data2 th:nth-child(14), .table-data2 td:nth-child(14) { width: 200px; }
.table-data2 th:nth-child(15), .table-data2 td:nth-child(15) { width: 200px; }
.table-data2 th:nth-child(16), .table-data2 td:nth-child(16) { width: 150px; }
.table-data2 th:nth-child(17), .table-data2 td:nth-child(17) { width: 150px; }

/* Responsive adjustments */
@media (max-width: 992px) {
    .table-data2 {
        min-width: 800px;
    }
    .table-data2 td, .table-data2 th {
        padding: 10px 6px !important;
        font-size: 0.92rem;
    }
    .card-header, .card-body {
        padding: 1rem;
    }
}
@media (max-width: 768px) {
    .table-data2 {
        min-width: 600px;
        font-size: 0.9rem;
    }
    .table-data2 th, .table-data2 td {
        padding: 8px 4px !important;
    }
    .card-header, .card-body {
        padding: 0.7rem;
    }
}
@media (max-width: 576px) {
    .table-data2 {
        min-width: 400px;
        font-size: 0.88rem;
    }
    .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
    .showing-entries {
        text-align: center;
    }
    .pagination {
        justify-content: center;
    }
    .card-header h3, .card-header small {
        font-size: 1.1rem;
    }
    .card {
        margin-bottom: 24px !important;
    }
}

/* Input and Button Styles */
.input-group .form-control, .form-control, .custom-select {
    border-radius: 15px;
    border: 2px solid #e3e6f0;
    padding: 12px;
    font-size: 1rem;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.input-group .form-control:focus, .form-control:focus, .custom-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    border-color: #4e73df;
}
.btn-primary, .btn-primary:focus, .btn-primary:active {
    background: linear-gradient(45deg, #1a237e, #4e73df);
    border: none;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 2px 8px rgba(44,62,80,0.08);
    transition: box-shadow 0.2s, transform 0.2s;
}
.btn-primary:hover {
    background: linear-gradient(45deg, #4e73df, #1a237e);
    box-shadow: 0 4px 16px rgba(44,62,80,0.18);
    transform: scale(1.04);
}
.btn-custom {
    width: 40px;
    padding: 5px;
    border-radius: 10px;
}

/* Modal Styles */
.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 1rem);
}
.modal-content {
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}
.modal-header {
    background: linear-gradient(45deg, #1a237e, #4e73df);
    color: white;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}
.modal-body {
    max-height: 400px;
    overflow-y: auto;
}
.modal-footer {
    border-top: none;
}

/* Pagination styles */
.pagination {
  margin: 0;
}
#showingEntries {
  font-size: 0.9rem;
}
.swal2-modern-popup {
  max-width: 950px !important;
  width: 95vw !important;
  margin-left: auto !important;
  margin-right: auto !important;
  padding-left: 24px !important;
  padding-right: 24px !important;
  box-sizing: border-box;
  overflow-x: hidden !important;
  /* Add for fixed height and vertical scroll */
  max-height: 90vh !important;
  display: flex !important;
  flex-direction: column !important;
}
.add-job-premium-popup {
  background: #f6f8fc !important;
  box-shadow: 0 8px 40px rgba(44,62,80,0.13) !important;
  border-radius: 22px !important;
  padding-top: 18px !important;
  padding-bottom: 18px !important;
}
#addJobFormSwal > div[style*='linear-gradient'] {
  text-align: left;
  font-size: 1.32rem !important;
  font-weight: 900 !important;
  margin-top: 18px !important;
  margin-bottom: 18px !important;
  padding-left: 0 !important;
}
#addJobFormSwal label {
  font-weight: 700 !important;
  margin-bottom: 7px !important;
  color: #222 !important;
  text-align: left !important;
  font-size: 1.08rem !important;
}
#addJobFormSwal input, #addJobFormSwal textarea {
  margin-bottom: 0;
  font-size: 1.09rem;
  border-radius: 10px;
  background: #fafdff;
  border: 2px solid #e3e6f0;
  box-shadow: 0 1px 4px rgba(44,62,80,0.04);
  transition: border-color 0.18s, box-shadow 0.18s;
}
#addJobFormSwal input:focus, #addJobFormSwal textarea:focus {
  border-color: #4e73df;
  box-shadow: 0 0 0 0.18rem rgba(78, 115, 223, 0.13);
}
#addJobFormSwal input:hover, #addJobFormSwal textarea:hover {
  border-color: #1a237e;
}
#addJobFormSwal .swal2-textarea, #addJobFormSwal .swal2-input {
  width: 100% !important;
  box-sizing: border-box !important;
}
#addJobFormSwal .details-card {
  background: #fafdff;
  border-radius: 14px;
  box-shadow: 0 2px 8px rgba(44,62,80,0.04);
  border: 1.5px solid #e3e9fc;
  padding: 22px 18px 18px 18px;
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-bottom: 24px;
  max-width: 500px;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  box-sizing: border-box;
  overflow: hidden;
}
@media (max-width: 900px) {
  .add-job-premium-popup {
    padding-left: 2px !important;
    padding-right: 2px !important;
  }
  #addJobFormSwal .details-card {
    padding: 16px 4px 14px 4px;
  }
}
.swal2-actions {
  margin-top: 28px !important;
  width: 100%;
  display: flex;
  gap: 16px;
  justify-content: flex-end;
}
.swal2-actions .swal2-confirm, .swal2-actions .swal2-cancel {
  min-width: 140px;
  font-size: 1.12rem;
  border-radius: 10px;
  padding: 12px 0;
  font-weight: 800;
  box-shadow: 0 2px 8px rgba(44,62,80,0.08);
  transition: box-shadow 0.18s, background 0.18s, color 0.18s;
}
.swal2-actions .swal2-confirm {
  background: linear-gradient(45deg, #1a237e, #4e73df);
  color: #fff;
  border: none;
}
.swal2-actions .swal2-confirm:hover {
  background: linear-gradient(45deg, #4e73df, #1a237e);
  color: #fff;
  box-shadow: 0 4px 16px rgba(44,62,80,0.18);
}
.swal2-actions .swal2-cancel {
  background: #f3f6fa;
  color: #1a237e;
  border: 1.5px solid #e3e6f0;
}
@media (max-width: 600px) {
  .swal2-actions {
    flex-direction: column;
    gap: 10px;
    align-items: stretch;
  }
  .swal2-actions .swal2-confirm, .swal2-actions .swal2-cancel {
    width: 100%;
    min-width: 0;
  }
}

#editJobForm {
  /* Make the form scrollable if content overflows */
  overflow-y: auto !important;
  max-height: 65vh !important;
  padding-bottom: 16px;
}
@media (max-width: 900px) {
  .swal2-modern-popup {
    max-width: 98vw !important;
    padding-left: 8px !important;
    padding-right: 8px !important;
  }
  #editJobForm {
    gap: 8px !important;
  }
}
.modal-dialog {
  margin-left: auto;
  margin-right: auto;
}
.modal-content {
  margin-left: auto;
  margin-right: auto;
  max-width: 700px;
  width: 95vw;
  box-sizing: border-box;
}
@media (max-width: 900px) {
  .modal-content {
    max-width: 98vw;
  }
}

.swal2-modern-popup * {
  box-sizing: border-box !important;
  max-width: 100% !important;
}

#editJobForm, #editJobForm > div, #editJobForm input, #editJobForm textarea {
  max-width: 100% !important;
  width: 100% !important;
  box-sizing: border-box !important;
}
.add-job-premium-popup {
  background: linear-gradient(135deg, #f6f8fc 80%, #e3e9fc 100%) !important;
  box-shadow: 0 12px 48px rgba(44,62,80,0.16) !important;
  border-radius: 26px !important;
  padding-top: 22px !important;
  padding-bottom: 22px !important;
  animation: fadeInUp 0.5s cubic-bezier(.39,.575,.565,1.000);
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(40px); }
  to { opacity: 1; transform: translateY(0); }
}
#addJobFormSwal > div[style*='linear-gradient'] {
  text-align: left;
  font-size: 1.38rem !important;
  font-weight: 900 !important;
  margin-top: 22px !important;
  margin-bottom: 22px !important;
  padding-left: 0 !important;
  background: linear-gradient(90deg, #e3e9fc 60%, #f5f7ff 100%);
  border-radius: 10px;
    position: sticky;
    top: 0;
  z-index: 2;
  box-shadow: 0 2px 8px rgba(44,62,80,0.04);
}
#addJobFormSwal .section-divider {
  height: 1px;
  background: linear-gradient(90deg, #e3e9fc 0%, #fafdff 100%);
  margin: 18px 0 18px 0;
  border: none;
}
#addJobFormSwal label {
  font-weight: 700 !important;
  margin-bottom: 7px !important;
  color: #222 !important;
  text-align: left !important;
  font-size: 1.11rem !important;
}
#addJobFormSwal input, #addJobFormSwal textarea {
  margin-bottom: 0;
  font-size: 1.13rem;
  border-radius: 10px;
  background: #fafdff;
  border: 2px solid #e3e6f0;
  box-shadow: 0 1px 4px rgba(44,62,80,0.04);
  transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
}
#addJobFormSwal input:focus, #addJobFormSwal textarea:focus {
  border-color: #4e73df;
  box-shadow: 0 0 0 0.19rem rgba(78, 115, 223, 0.15);
  background: #f0f4ff;
}
#addJobFormSwal input:hover, #addJobFormSwal textarea:hover {
  border-color: #1a237e;
}
#addJobFormSwal .swal2-textarea, #addJobFormSwal .swal2-input {
  width: 100% !important;
  box-sizing: border-box !important;
    }
#addJobFormSwal .details-card {
  background: #fafdff;
  border-radius: 14px;
  box-shadow: 0 2px 8px rgba(44,62,80,0.04);
  border: 1.5px solid #e3e9fc;
  padding: 26px 20px 22px 20px;
  display: flex;
  flex-direction: column;
  gap: 22px;
  margin-bottom: 32px;
  max-width: 520px;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  box-sizing: border-box;
  overflow: hidden;
  animation: fadeInUp 0.7s cubic-bezier(.39,.575,.565,1.000);
    }
@media (max-width: 900px) {
  .add-job-premium-popup {
    padding-left: 2px !important;
    padding-right: 2px !important;
  }
  #addJobFormSwal .details-card {
    padding: 16px 4px 14px 4px;
  }
}
.swal2-actions {
  margin-top: 36px !important;
  width: 100%;
  display: flex;
  gap: 18px;
  justify-content: flex-end;
}
.swal2-actions .swal2-confirm, .swal2-actions .swal2-cancel {
  min-width: 150px;
  font-size: 1.16rem;
  border-radius: 10px;
  padding: 14px 0;
  font-weight: 900;
  box-shadow: 0 2px 8px rgba(44,62,80,0.10);
  transition: box-shadow 0.18s, background 0.18s, color 0.18s;
}
.swal2-actions .swal2-confirm {
  background: linear-gradient(45deg, #1a237e, #4e73df);
  color: #fff;
  border: none;
  box-shadow: 0 0 8px 2px #4e73df33;
}
.swal2-actions .swal2-confirm:hover {
  background: linear-gradient(45deg, #4e73df, #1a237e);
  color: #fff;
  box-shadow: 0 4px 24px #4e73df44;
}
.swal2-actions .swal2-cancel {
  background: #f3f6fa;
  color: #1a237e;
  border: 1.5px solid #e3e6f0;
}
@media (max-width: 600px) {
  .swal2-actions {
    flex-direction: column;
    gap: 12px;
    align-items: stretch;
  }
  .swal2-actions .swal2-confirm, .swal2-actions .swal2-cancel {
    width: 100%;
    min-width: 0;
  }
}

.modern-job-form {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px rgba(60, 80, 180, 0.10);
  padding: 32px 28px 20px 28px;
  max-width: 650px;
  margin: 0 auto;
}

.form-section {
  margin-bottom: 18px;
}

.section-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #3a4b8a;
  background: linear-gradient(90deg, #e3eaff 0%, #f7f8fa 100%);
  border-radius: 10px 10px 0 0;
  padding: 12px 18px;
  margin-bottom: 18px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 18px 24px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-weight: 500;
  color: #2a2a2a;
  margin-bottom: 6px;
  font-size: 1rem;
}

.form-group input,
.form-group select,
.form-group textarea {
  background: #f7f8fa;
  border: 1.5px solid #e0e3eb;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 1.05rem;
  color: #222;
  box-sizing: border-box;
  transition: border 0.2s, box-shadow 0.2s;
  box-shadow: 0 1px 3px rgba(30, 34, 90, 0.04);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: #4f8cff;
  outline: none;
  box-shadow: 0 0 0 2px #e3edff;
}

.form-actions {
    display: flex;
  justify-content: flex-end;
  gap: 16px;
  margin-top: 18px;
}

.btn-primary {
  background: linear-gradient(90deg, #4f8cff 0%, #3358e0 100%);
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 10px 28px;
  font-size: 1.08rem;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(79, 140, 255, 0.08);
  transition: background 0.2s, box-shadow 0.2s;
}

.btn-primary:hover {
  background: linear-gradient(90deg, #3358e0 0%, #4f8cff 100%);
  box-shadow: 0 4px 16px rgba(79, 140, 255, 0.13);
}

.btn-secondary {
  background: #f7f8fa;
  color: #3a4b8a;
  border: 1.5px solid #e0e3eb;
  border-radius: 8px;
  padding: 10px 24px;
  font-size: 1.08rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s, border 0.2s;
}

.btn-secondary:hover {
  background: #e3eaff;
  border-color: #b6c6f5;
}

.swal2-popup input,
.swal2-popup select,
.swal2-popup textarea {
  background: #f7f8fa;
  border: 1.5px solid #e0e3eb;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 1.05rem;
  color: #222;
  margin-bottom: 10px;
  box-sizing: border-box;
  transition: border 0.2s, box-shadow 0.2s;
  box-shadow: 0 1px 3px rgba(30, 34, 90, 0.04);
}

.swal2-popup input:focus,
.swal2-popup select:focus,
.swal2-popup textarea:focus {
  border-color: #4f8cff;
  outline: none;
  box-shadow: 0 0 0 2px #e3edff;
}

.swal2-popup label {
  font-weight: 500;
  color: #222;
  margin-bottom: 4px;
  display: block;
  font-size: 1rem;
  letter-spacing: 0.01em;
}
.even-row { background: #f8faff; }
.odd-row { background: #fff; }
.badge-success { background: #28a745; color: #fff; }
.badge-danger { background: #dc3545; color: #fff; }
.badge-secondary { background: #6c757d; color: #fff; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function truncateText(text, maxLength = 24) {
    if (!text) return '';
    return text.length > maxLength ? text.slice(0, maxLength) + '…' : text;
}

function renderApplicantRow(applicant, idx) {
    const rowClass = idx % 2 === 0 ? 'even-row' : 'odd-row';
    const pdfPath = applicant.pdf_link ? '../../uploads/' + applicant.pdf_link : '';
    return `
        <tr class="tr-shadow ${rowClass}">
            <td class="text-center">${esc(applicant.id)}</td>
            <td class="text-center">${esc(applicant.job_id ?? '')}</td>
            <td class="text-center" title="${esc(applicant.full_name)}">${truncateText(applicant.full_name, 18)}</td>
            <td class="text-center" title="${esc(applicant.email)}">${truncateText(applicant.email, 18)}</td>
            <td class="text-center">${truncateText(applicant.contact, 14)}</td>
            <td class="text-center" title="${esc(applicant.location)}">${truncateText(applicant.location, 14)}</td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-outline-primary view-pdf-btn" data-pdf="${pdfPath}">View PDF</a>
            </td>
            <td class="text-center">
                <span class="badge badge-${esc(applicant.status === 'Shortlisted' ? 'success' : applicant.status === 'Rejected' ? 'danger' : 'secondary')}">${esc(applicant.status)}</span>
            </td>
            <td class="text-center">${esc(new Date(applicant.date_applied).toLocaleString())}</td>
            <td class="text-center">
                <button class="btn btn-success btn-sm shortlist-btn" data-id="${esc(applicant.id)}">Shortlist</button>
                <button class="btn btn-danger btn-sm reject-btn" data-id="${esc(applicant.id)}">Reject</button>
            </td>
        </tr>
    `;
}

function showApplicantsLoading() {
    $('#jobApplicantsTableBody').html('<tr><td colspan="9" class="text-center text-muted"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
}

function showApplicantsEmpty() {
    $('#jobApplicantsTableBody').html('<tr><td colspan="9" class="text-center text-muted">No job applicants found.</td></tr>');
}

function renderApplicantsPagination(pagination) {
    const pag = $('#applicantsPagination');
    pag.empty();
    if (pagination.total_pages <= 1) return;
    for (let i = 1; i <= pagination.total_pages; i++) {
        pag.append(`<li class="page-item${esc(i === pagination.current_page ? ' active' : '')}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`);
    }
}
function loadJobApplicants(page = 1) {
    showApplicantsLoading();
    $.ajax({
        url: 'data/job_applicants_data.php?page=' + page,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response.data) && response.data.length > 0) {
                let html = '';
                response.data.forEach((applicant, idx) => {
                    html += renderApplicantRow(applicant, idx);
                });
                $('#jobApplicantsTableBody').html(html);
            } else {
                showApplicantsEmpty();
            }
            renderApplicantsPagination(response.pagination);
        },
        error: function(xhr, status, error) {
            $('#jobApplicantsTableBody').html('<tr><td colspan="9" class="text-center text-danger">Error loading applicants.</td></tr>');
        }
    });
}
$(function() {
    loadJobApplicants();
    $('#applicantsPagination').on('click', 'a.page-link', function(e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if (!isNaN(page)) {
            loadJobApplicants(page);
        }
    });
});

// Ensure SweetAlert2 is loaded only once
if (typeof Swal === 'undefined') {
  var script = document.createElement('script');
  script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
  document.head.appendChild(script);
}

$(document).off('click', '.view-pdf-btn').on('click', '.view-pdf-btn', function(e) {
    e.preventDefault();
    const pdfUrl = $(this).data('pdf');
    console.log('View PDF clicked:', pdfUrl); // Debug log
    if (pdfUrl && pdfUrl !== '-') {
        Swal.fire({
            title: 'Resume PDF',
            html: `<iframe src='${pdfUrl}' width='100%' height='500px' style='border:none;'></iframe>`,
            width: 700,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: { popup: 'swal2-popup-custom' }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'No PDF',
            text: 'No resume PDF available for this applicant.'
        });
    }
});

$(document).off('click', '.shortlist-btn').on('click', '.shortlist-btn', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Shortlist Applicant?',
        text: 'Are you sure you want to shortlist this applicant?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Shortlist',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#28a745',
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('data/shortlist_applicant.php', { id }, function(response) {
                if (response.success) {
                    Swal.fire('Shortlisted!', 'Applicant has been shortlisted.', 'success');
                    loadJobApplicants();
                } else {
                    Swal.fire('Error', response.message || 'Failed to shortlist applicant', 'error');
                }
            }, 'json');
        }
    });
});

$(document).off('click', '.reject-btn').on('click', '.reject-btn', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Reject Applicant?',
        text: 'Are you sure you want to reject this applicant?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Reject',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc3545',
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('data/reject_applicant.php', { id }, function(response) {
                if (response.success) {
                    Swal.fire('Rejected!', 'Applicant has been rejected.', 'success');
                    loadJobApplicants();
                } else {
                    Swal.fire('Error', response.message || 'Failed to reject applicant', 'error');
                }
            }, 'json');
        }
    });
});

$(document).ready(function() {
    let currentPage = 1;
    const rowsPerPage = 6;
    let totalPages = 1;

    // Function to render table row
    function renderTableRow(career) {
        // Show only the first 7 words of the description, responsibilities, requirements, and skills
        function truncateWords(text) {
            if (!text) return '';
            // If it's a JSON array string, parse and join
            let str = text;
            try {
                const arr = JSON.parse(text);
                if (Array.isArray(arr)) str = arr.join(', ');
            } catch (e) { /* not JSON, use as is */ }
            const words = str.split(/\s+/);
            if (words.length <= 7) return str;
            return words.slice(0, 7).join(' ') + '...';
        }
        return `
            <tr class="tr-shadow">
                <td class="text-center">${esc(career.id)}</td>
                <td class="text-center">${esc(career.title)}</td>
                <td class="text-center">${esc(career.category)}</td>
                <td class="text-center">${esc(career.type)}</td>
                <td class="text-center">${esc(career.location)}</td>
                <td class="text-center">${esc(career.salary)}</td>
                <td class="text-center">${truncateWords(career.description)}</td>
                <td class="text-center">${truncateWords(career.skills)}</td>
                <td class="text-center"><i class="${esc(career.icon)}"></i></td>
                <td class="text-center">${esc(career.date_posted)}</td>
                <td class="text-center">${esc(career.deadline)}</td>
                <td class="text-center">${esc(career.experience)}</td>
                <td class="text-center">${esc(career.education)}</td>
                <td class="text-center">${truncateWords(career.responsibilities)}</td>
                <td class="text-center">${truncateWords(career.requirements)}</td>
                <td class="text-center">${esc(career.date_added)}</td>
                <td class="text-center">${esc(career.last_modified)}</td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-primary btn-custom" onclick="editCareer(${esc(career.id)})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-custom" onclick="deleteCareer(${esc(career.id)})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="spacer"></tr>`;
    }

    // Function to format date
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }

    // Function to update table body
    function updateTableBody(careers) {
        const tableBody = $('#careerTableBody');
        if (!careers || careers.length === 0) {
            tableBody.html('<tr><td colspan="18" class="text-center text-muted">No jobs found.</td></tr>');
            return;
        }
        let html = '';
        careers.forEach(career => {
            html += renderTableRow(career);
        });
        tableBody.html(html);
    }

    // Function to render pagination
    function renderPagination(totalItems) {
        totalPages = Math.ceil(totalItems / rowsPerPage);
        const pagination = $('#pagination');
        pagination.empty();
        if (totalPages <= 1) return;
        for (let i = 1; i <= totalPages; i++) {
            pagination.append(`
                <li class="page-item${i === currentPage ? ' active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `);
        }
    }

    // Function to update page info
    function updatePageInfo(start, end, total) {
        $('#showingEntries').text(`Showing ${start} to ${end} of ${total} entries`);
    }

    // Function to load page data
    function loadPage(page) {
        $.ajax({
            url: `data/career_data.php?page=${page}&rowsPerPage=${rowsPerPage}`,
            method: 'GET',
            success: function(response) {
                if (response.totalItems) {
                    updateTableBody(response.pageData);
                    renderPagination(response.totalItems);
                    const start = (page - 1) * rowsPerPage + 1;
                    const end = Math.min(page * rowsPerPage, response.totalItems);
                    updatePageInfo(start, end, response.totalItems);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
                console.error(xhr.responseText);
            }
        });
    }

    // Initialize the page on load
    loadPage(currentPage);

    // Handle pagination click
    $('#pagination').on('click', 'a.page-link', function(e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if (page !== currentPage) {
            currentPage = page;
            loadPage(currentPage);
        }
    });

    // Handle form submission for adding a new job
    $('#addNewLead').on('click', function() {
        // Add Job popup with same structure as Edit Job
        let formHtml = `
<form id="add-job-form" class="modern-job-form">
  <div class="form-section">
    <div class="section-title"><i class="bi bi-briefcase"></i> Basic Info</div>
    <div class="form-grid">
      <div class="form-group">
        <label>Title</label>
        <input class="swal2-input" name="title" value="" required>
      </div>
      <div class="form-group">
        <label>Category</label>
        <select class="swal2-input" name="category" id="job-category" required>
          <option value="">Select Category</option>
          <option value="data">Data Science</option>
          <option value="design">Design</option>
          <option value="development">Development</option>
          <option value="security">Security</option>
        </select>
      </div>
      <div class="form-group">
        <label>Type</label>
        <select class="swal2-input" name="type" required>
          <option value="">Select Type</option>
          <option value="Full Time">Full Time</option>
          <option value="Part Time">Part Time</option>
          <option value="Contract">Contract</option>
          <option value="Internship">Internship</option>
          <option value="Remote">Remote</option>
        </select>
      </div>
      <div class="form-group">
        <label>Location</label>
        <input class="swal2-input" name="location" value="" required>
      </div>
      <div class="form-group">
        <label>Salary (INR)</label>
        <input class="swal2-input" name="salary" value="" placeholder="e.g. ₹25,000 - ₹40,000 per month or 6 - 9 LPA" required>
      </div>
      <div class="form-group">
        <label>Icon</label>
        <input class="swal2-input" name="icon" id="job-icon" value="fas fa-code" readonly>
      </div>
    </div>
  </div>
  <div class="form-section">
    <div class="section-title"><i class="bi bi-calendar"></i> Dates</div>
    <div class="form-grid">
      <div class="form-group">
        <label>Deadline</label>
        <input class="swal2-input" type="date" name="deadline" value="" required>
      </div>
      <div class="form-group">
        <label>Experience</label>
        <input class="swal2-input" name="experience" value="" required>
      </div>
      <div class="form-group">
        <label>Education</label>
        <input class="swal2-input" name="education" value="" required>
      </div>
    </div>
  </div>
  <div class="form-section">
    <div class="section-title"><i class="bi bi-file-text"></i> Details</div>
    <div class="form-grid">
      <div class="form-group">
        <label>Description</label>
        <textarea class="swal2-textarea" name="description" required style="min-height:60px;"></textarea>
      </div>
      <div class="form-group">
        <label>Skills</label>
        <textarea class="swal2-textarea" name="skills" required rows="4" placeholder="One skill per line, e.g.&#10;PHP&#10;MySQL"></textarea>
      </div>
      <div class="form-group">
        <label>Responsibilities</label>
        <textarea class="swal2-textarea" name="responsibilities" required rows="4" placeholder="One responsibility per line"></textarea>
      </div>
      <div class="form-group">
        <label>Requirements</label>
        <textarea class="swal2-textarea" name="requirements" required rows="4" placeholder="One requirement per line"></textarea>
      </div>
    </div>
  </div>
</form>
`;

        Swal.fire({
            title: 'Add New Job',
            html: formHtml,
            width: '100%',
            customClass: {
                popup: 'swal2-modern-popup'
            },
            showCancelButton: true,
            confirmButtonText: 'Add Job',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            allowOutsideClick: false,
            didOpen: () => {
                // Auto-populate icon based on selected category
                const categorySelect = document.getElementById('job-category');
                const iconInput = document.getElementById('job-icon');
                
                const categoryIcons = {
                    'data': 'fas fa-chart-line',
                    'design': 'fas fa-paint-brush',
                    'development': 'fas fa-code',
                    'security': 'fas fa-shield-alt'
                };
                
                // Set initial icon based on default selected category
                const selectedCategory = categorySelect.value;
                if (categoryIcons[selectedCategory]) {
                    iconInput.value = categoryIcons[selectedCategory];
                }
                
                categorySelect.addEventListener('change', function() {
                    const selectedCategory = this.value;
                    if (categoryIcons[selectedCategory]) {
                        iconInput.value = categoryIcons[selectedCategory];
                    } else {
                        iconInput.value = '';
                    }
                });
                
                // Set default date posted to today if not already set
                const datePostedInput = Swal.getPopup().querySelector('input[name="date_posted"]');
                if (datePostedInput && !datePostedInput.value) {
                    const today = new Date().toISOString().split('T')[0];
                    datePostedInput.value = today;
                }
                
                // Set minimum deadline to tomorrow if not already set
                const deadlineInput = Swal.getPopup().querySelector('input[name="deadline"]');
                if (!deadlineInput.value) {
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    const tomorrowStr = tomorrow.toISOString().split('T')[0];
                    deadlineInput.value = tomorrowStr;
                }
            },
            preConfirm: () => {
                // Show loading state
                Swal.showLoading();
                
                // Validate form before submission
                const form = document.getElementById('add-job-form');
                const formData = new FormData(form);
                
                // Client-side validation
                const validationErrors = [];
                
                // Check required fields
                for (let [key, value] of formData.entries()) {
                    if (!value || value.trim() === '') {
                        const fieldName = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        validationErrors.push(`${fieldName} is required`);
                    }
                }
                
                // Check date logic
                const datePosted = formData.get('date_posted');
                const deadline = formData.get('deadline');
                
                if (datePosted && deadline && new Date(datePosted) >= new Date(deadline)) {
                    validationErrors.push('Deadline must be after Date Posted');
                }
                
                if (validationErrors.length > 0) {
                    Swal.hideLoading();
                    Swal.showValidationMessage(validationErrors.join('\n'));
                    return false;
                }
                
                // Convert FormData to URL-encoded string
                const serializedData = new URLSearchParams(formData).toString();
                
                return fetch('data/add_job.php', {
            method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: serializedData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP ${esc(response.status)}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.error || 'Failed to add job');
                    }
                    return data;
                })
                .catch(error => {
                    Swal.hideLoading();
                    Swal.showValidationMessage(`Request failed: ${esc(error.message)}`);
                    throw error;
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show success message with job details
                const jobData = result.value;
                Swal.fire({
                    icon: 'success',
                    title: 'Job Added Successfully!',
                    html: `
                        <div style="text-align: left;">
                            <p><strong>Job ID:</strong> ${esc(jobData.job_id)}</p>
                            <p><strong>Category:</strong> ${esc(jobData.category_name)}</p>
                        </div>
                    `,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reload the table
                    loadPage(currentPage);
                });
            }
        });
    });
});

// Function to edit career
function editCareer(id) {
    // Fetch the job data for the given ID (from your API or loaded data)
    $.get(`data/career_data.php?id=${id}`, function(job) {
        // job is now a single object, not an array
        let formHtml = `
<form id="edit-job-form" class="modern-job-form">
  <div class="form-section">
    <div class="section-title"><i class="bi bi-briefcase"></i> Basic Info</div>
    <div class="form-grid">
      <div class="form-group">
        <label>Title</label>
        <input class="swal2-input" name="title" value="${esc(job.title || '')}" required>
      </div>
      <div class="form-group">
        <label>Category</label>
        <input type="text" class="form-control" id="editJobCategory" name="category" value="${esc(job.category || '')}" required>
      </div>
      <div class="form-group">
        <label>Type</label>
        <input type="text" class="form-control" id="editJobType" name="type" value="${esc(job.type || '')}" required>
      </div>
      <div class="form-group">
        <label>Location</label>
        <input type="text" class="form-control" id="editJobLocation" name="location" value="${esc(job.location || '')}" required>
      </div>
      <div class="form-group">
        <label>Salary (INR)</label>
        <input type="text" class="form-control" id="editJobSalary" name="salary" value="${esc(job.salary || '')}" placeholder="e.g. ₹25,000 - ₹40,000 per month or 6 - 9 LPA" required>
      </div>
      <div class="form-group">
        <label>Icon</label>
        <input type="text" class="form-control" id="editJobIcon" name="icon" value="${esc(job.icon || '')}" required>
      </div>
    </div>
  </div>
  <div class="form-section">
    <div class="section-title"><i class="bi bi-calendar"></i> Dates</div>
    <div class="form-grid">
      <div class="form-group">
        <label>Date Posted</label>
        <input type="date" class="form-control" id="editJobDatePosted" name="date_posted" value="${esc(job.date_posted || '')}" required>
      </div>
      <div class="form-group">
        <label>Deadline</label>
        <input type="date" class="form-control" id="editJobDeadline" name="deadline" value="${esc(job.deadline || '')}" required>
      </div>
      <div class="form-group">
        <label>Experience</label>
        <input type="text" class="form-control" id="editJobExperience" name="experience" value="${esc(job.experience || '')}" required>
      </div>
      <div class="form-group">
        <label>Education</label>
        <input type="text" class="form-control" id="editJobEducation" name="education" value="${esc(job.education || '')}" required>
      </div>
    </div>
  </div>
  <div class="form-section">
    <div class="section-title"><i class="bi bi-file-text"></i> Details</div>
    <div class="form-grid">
      <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" id="editJobDescription" name="description" rows="3" required>${esc(job.description || '')}</textarea>
      </div>
      <div class="form-group">
        <label>Skills</label>
        <textarea class="form-control" id="editJobSkills" name="skills" rows="3" required>${esc(crmListLines(job.skills))}</textarea>
      </div>
      <div class="form-group">
        <label>Responsibilities</label>
        <textarea class="form-control" id="editJobResponsibilities" name="responsibilities" rows="3" required>${esc(crmListLines(job.responsibilities))}</textarea>
      </div>
      <div class="form-group">
        <label>Requirements</label>
        <textarea class="form-control" id="editJobRequirements" name="requirements" rows="3" required>${esc(crmListLines(job.requirements))}</textarea>
      </div>
    </div>
  </div>
</form>
`;

        Swal.fire({
            title: 'Edit Job',
            html: formHtml,
            width: '100%',
            customClass: {
                popup: 'swal2-modern-popup'
            },
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                const form = document.getElementById('edit-job-form');
                const formData = new FormData(form);
                formData.append('id', id);
                
                // Convert FormData to URL-encoded string
                const serializedData = new URLSearchParams(formData).toString();
                
                return fetch('data/edit_job.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: serializedData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP ${esc(response.status)}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.error || 'Failed to update job');
                    }
                    return data;
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${esc(error.message)}`);
                    throw error;
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Job Updated Successfully!',
                    text: 'The job has been updated and the table has been refreshed.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Refresh the table data
                    loadPage(currentPage);
                });
            }
        });
    });
}

// Function to delete career

function deleteCareer(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete the job.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'data/delete_job.php',
                method: 'POST',
                data: { id: id },
                success: function() {
                    Swal.fire('Deleted!', 'Job has been deleted.', 'success');
                    loadPage(currentPage);
                }
            });
        }
    });
}

function searchJobApplicationsTable() {
    var input = document.getElementById("searchJobApplications");
    var filter = input.value.toLowerCase();
    var table = document.querySelectorAll(".card-body")[0].querySelector("table");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) { // skip header row
        var tds = tr[i].getElementsByTagName("td");
        var rowText = "";
        for (var j = 0; j < tds.length; j++) {
            rowText += tds[j].textContent.toLowerCase() + " ";
        }
        if (rowText.indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>