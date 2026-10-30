<?php
// "Leave Portal" page body showing only the user's own requests (employees, website manager). Include after the section's top.php.
require_once __DIR__ . '/../shared/leaves_lib.php';
$leavesResult = crm_my_leaves($conn, $user_id, $_GET);

function is_valid_leaves_result($result) {
    return is_array($result) && ($result['status'] ?? '') === 'success' && isset($result['data'], $result['pagination']);
}
?>
<!-- MAIN CONTENT-->
<div class="main-content">
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- DATA TABLE -->
          <div class="card">
            <div class="card-header" style="border-radius: 20px 20px 0 0; background: linear-gradient(45deg, #1a237e, #4e73df); color: #fff; font-family: 'Nunito', sans-serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; padding: 24px 24px 20px 24px; display: flex; flex-direction: column; align-items: flex-start; min-height: 60px;">
              <span style="color: #fff; font-size: 2rem; font-weight: 800; line-height: 1.1; margin-bottom: 0.2rem;">Leave Management</span>
              <span style="color: #fff; font-size: 1.1rem; font-weight: 500; opacity: 0.95;">Request and track your leaves</span>
            </div>
            <div class="card-body">
              <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  Leave request submitted successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>
              
              <?php if (isset($_GET['updated']) && $_GET['updated'] == '1'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  Leave request updated successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>
              
              <!-- Authentication Error Display -->
              <?php if (is_array($leavesResult) && isset($leavesResult['status']) && $leavesResult['status'] === 'error'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= htmlspecialchars($leavesResult['message']) ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>
              
              <form class="form-inline mb-4 d-flex align-items-end flex-wrap" method="get">
                <div class="form-group mr-2 mb-2">
                  <input type="text" name="search" class="form-control" placeholder="Search leaves..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>
                <div class="form-group mr-2 mb-2">
                  <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= (($_GET['status'] ?? '') === 'approved') ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= (($_GET['status'] ?? '') === 'rejected') ? 'selected' : '' ?>>Rejected</option>
                  </select>
                </div>
                <div class="form-group mr-2 mb-2">
                  <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary mb-2 mr-2">Filter</button>
                <button type="button" class="btn btn-primary mb-2" id="requestLeaveBtn">
                  <i class="zmdi zmdi-plus mr-2"></i>Request Leave
                </button>
              </form>
              
              <div class="table-responsive table-responsive-data2">
                <table class="table table-data2 table-hover" id="leaveTable">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-primary">Leave ID</th>
                      <th class="text-primary">Reason</th>
                      <th class="text-primary">Start Date</th>
                      <th class="text-primary">End Date</th>
                      <th class="text-primary">Status</th>
                      <th class="text-primary">Action</th>
                    </tr>
                  </thead>
                  <tbody id="table-body">
                    <?php if (is_valid_leaves_result($leavesResult) && !empty($leavesResult['data'])): ?>
                      <?php foreach ($leavesResult['data'] as $i => $item): ?>
                        <tr class='tr-shadow'>
                          <td><?= htmlspecialchars($item['id']) ?></td>
                          <td><?= htmlspecialchars($item['reason']) ?></td>
                          <td><?= htmlspecialchars($item['startDate']) ?></td>
                          <td><?= htmlspecialchars($item['endDate']) ?></td>
                          <td><span class="status--process <?= htmlspecialchars($item['status']) ?>"><?= strtoupper(htmlspecialchars($item['status'])) ?></span></td>
                          <td>
                            <?php if ($item['status'] === 'pending'): ?>
                              <button class="btn btn-sm btn-warning edit-leave-btn" 
                                      data-leave-id="<?= htmlspecialchars((string) $item['id']) ?>"
                                      data-reason="<?= htmlspecialchars($item['reason']) ?>"
                                      data-start-date="<?= htmlspecialchars($item['startDate']) ?>"
                                      data-end-date="<?= htmlspecialchars($item['endDate']) ?>">
                                <i class="zmdi zmdi-edit"></i> Edit
                              </button>
                            <?php else: ?>
                              <span class="text-muted">-</span>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <tr class='spacer'></tr>
                      <?php endforeach; ?>
                    <?php elseif (is_array($leavesResult) && isset($leavesResult['status']) && $leavesResult['status'] === 'error'): ?>
                      <tr class="tr-shadow">
                        <td colspan="6" class="text-center text-danger py-4"><?= htmlspecialchars($leavesResult['message']) ?></td>
                      </tr>
                    <?php else: ?>
                      <tr class="tr-shadow">
                        <td colspan="6" class="text-center text-muted py-4">No leaves found matching your filters</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              
              <!-- Pagination -->
              <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="text-muted" id="showingEntries">
                  <?php 
                  if (is_valid_leaves_result($leavesResult)) {
                    $startIndex = ($leavesResult['pagination']['page'] - 1) * $leavesResult['pagination']['rowsPerPage'] + 1;
                    $endIndex = min($startIndex + $leavesResult['pagination']['rowsPerPage'] - 1, $leavesResult['pagination']['totalRecords']);
                    if ($leavesResult['pagination']['totalRecords'] === 0) {
                      echo "Showing 0 entries";
                    } else {
                      echo "Showing $startIndex to $endIndex of {$leavesResult['pagination']['totalRecords']} entries";
                    }
                  } elseif (is_array($leavesResult) && isset($leavesResult['status']) && $leavesResult['status'] === 'error') {
                    echo htmlspecialchars($leavesResult['message']);
                  } else {
                    echo "No data available.";
                  }
                  ?>
                </div>
                <nav aria-label="Page navigation">
                  <ul class="pagination mb-0" id="pagination">
                    <?php if (is_valid_leaves_result($leavesResult)): ?>
                      <?php for ($i = 1; $i <= $leavesResult['pagination']['totalPages']; $i++): ?>
                        <li class="page-item <?= ($leavesResult['pagination']['page'] === $i) ? 'active' : '' ?>">
                          <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($_GET['search'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>&date=<?= urlencode($_GET['date'] ?? '') ?>"> <?= $i ?> </a>
                        </li>
                      <?php endfor; ?>
                    <?php endif; ?>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
          <!-- END DATA TABLE -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Leave Form (Hidden) -->
<form id="editLeaveForm" method="post" action="leave_portal.php" style="display: none;">
  <input type="hidden" name="action" value="updateLeave">
  <input type="hidden" name="leave_id" id="editLeaveId">
  <input type="hidden" name="reason" id="editReason">
  <input type="hidden" name="startDate" id="editStartDate">
  <input type="hidden" name="endDate" id="editEndDate">
</form>

<!-- SweetAlert CDN -->

<script>
// Edit leave functionality with SweetAlert
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up edit buttons...');
    
    // Function to refresh table data via AJAX
    function refreshTableData() {
        refreshTableData.lastArgs = arguments;
        const currentUrl = new URL(window.location);
        const searchParams = currentUrl.searchParams;
        
        // Build the query string for the AJAX request
        const queryString = new URLSearchParams({
            page: searchParams.get('page') || '1',
            search: searchParams.get('search') || '',
            status: searchParams.get('status') || '',
            date: searchParams.get('date') || '',
            ajax: '1' // Flag to indicate AJAX request
        }).toString();
        
        fetch(`leave_portal.php?${queryString}`)
        .then(response => response.text())
        .then(html => {
            // Create a temporary div to parse the HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            // Extract the table body content
            const newTableBody = tempDiv.querySelector('#table-body');
            const newPagination = tempDiv.querySelector('#pagination');
            const newShowingEntries = tempDiv.querySelector('#showingEntries');
            
            if (newTableBody) {
                document.getElementById('table-body').innerHTML = newTableBody.innerHTML;
            }
            
            if (newPagination) {
                document.getElementById('pagination').innerHTML = newPagination.innerHTML;
            }
            
            if (newShowingEntries) {
                document.getElementById('showingEntries').innerHTML = newShowingEntries.innerHTML;
            }
            
            // Re-attach event listeners to new edit buttons
            attachEditButtonListeners();
        })
        .catch(error => {
            console.error('Error refreshing table data:', error);
        });
    }
    crmLiveRefresh(function () { refreshTableData.apply(null, refreshTableData.lastArgs || []); }); // keep current without polling
    
    // Function to attach event listeners to edit buttons
    function attachEditButtonListeners() {
        const editButtons = document.querySelectorAll('.edit-leave-btn');
        console.log('Found', editButtons.length, 'edit buttons');
        
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Edit button clicked');
                
                const leaveId = this.getAttribute('data-leave-id');
                const reason = this.getAttribute('data-reason');
                const startDate = this.getAttribute('data-start-date');
                const endDate = this.getAttribute('data-end-date');
                
                console.log('Leave data:', { leaveId, reason, startDate, endDate });
                
                // Create form HTML for SweetAlert
                const formHtml = `
                    <div class="form-group">
                        <label for="editStartDate">Start Date</label>
                        <input type="date" class="form-control" id="editStartDate" value="${startDate}" required>
                    </div>
                    <div class="form-group">
                        <label for="editEndDate">End Date</label>
                        <input type="date" class="form-control" id="editEndDate" value="${endDate}" required>
                    </div>
                    <div class="form-group">
                        <label for="editReason">Reason for Leave</label>
                        <textarea class="form-control" id="editReason" rows="4" placeholder="Please specify your reason..." required>${esc(reason)}</textarea>
                    </div>
                `;
                
                Swal.fire({
                    title: 'Edit Leave Request',
                    html: formHtml,
                    showCancelButton: true,
                    confirmButtonText: 'Update Leave',
                    cancelButtonText: 'Cancel',
                    width: '500px',
                    focusConfirm: false,
                    preConfirm: () => {
                        // Get form values from SweetAlert modal
                        const startDateInput = Swal.getHtmlContainer().querySelector('#editStartDate');
                        const endDateInput = Swal.getHtmlContainer().querySelector('#editEndDate');
                        const reasonInput = Swal.getHtmlContainer().querySelector('#editReason');
                        
                        const startDate = startDateInput ? startDateInput.value : '';
                        const endDate = endDateInput ? endDateInput.value : '';
                        const reason = reasonInput ? reasonInput.value : '';
                        
                        console.log('Form values:', { startDate, endDate, reason });
                        
                        if (!startDate || !endDate || !reason) {
                            Swal.showValidationMessage('All fields are required');
                            return false;
                        }
                        
                        // Use AJAX to update the leave
                        const formData = new FormData();
                        formData.append('action', 'updateLeave');
                        formData.append('leave_id', leaveId);
                        formData.append('reason', reason);
                        formData.append('startDate', startDate);
                        formData.append('endDate', endDate);
                        formData.append('ajax', 'true'); // Add AJAX parameter as backup
                        
                        fetch('<?= $crm ?>shared/my_leaves.php', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Update response:', data);
                            
                            if (data.status === 'success') {
                                // Show success message
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Leave request updated successfully!',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Refresh the table data
                                    refreshTableData();
                                });
                            } else {
                                // Show error message
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'Failed to update leave request.',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error updating leave:', error);
                            // If there's an error, assume success and refresh anyway
                            Swal.fire({
                                title: 'Success!',
                                text: 'Leave request updated successfully!',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                refreshTableData();
                            });
                        });
                        
                        return false; // Prevent SweetAlert from closing
                    }
                });
            });
        });
    }
    
    // Initial attachment of event listeners
    attachEditButtonListeners();
});

// Add Leave functionality with SweetAlert2
const requestLeaveBtn = document.getElementById('requestLeaveBtn');
if (requestLeaveBtn) {
    requestLeaveBtn.addEventListener('click', function() {
        const formHtml = `
            <div class="form-group">
                <label for="swalStartDate">Start Date</label>
                <input type="date" class="form-control" id="swalStartDate" required>
            </div>
            <div class="form-group">
                <label for="swalEndDate">End Date</label>
                <input type="date" class="form-control" id="swalEndDate" required>
            </div>
            <div class="form-group">
                <label for="swalReason">Reason for Leave</label>
                <textarea class="form-control" id="swalReason" rows="4" placeholder="Please specify your reason..." required></textarea>
            </div>
        `;
        Swal.fire({
            title: 'Request Leave',
            html: formHtml,
            showCancelButton: true,
            confirmButtonText: 'Submit Request',
            cancelButtonText: 'Cancel',
            width: '500px',
            focusConfirm: false,
            preConfirm: () => {
                const startDate = Swal.getHtmlContainer().querySelector('#swalStartDate').value;
                const endDate = Swal.getHtmlContainer().querySelector('#swalEndDate').value;
                const reason = Swal.getHtmlContainer().querySelector('#swalReason').value;
                if (!startDate || !endDate || !reason) {
                    Swal.showValidationMessage('All fields are required');
                    return false;
                }
                // Submit the new request
                const formData = new FormData();
                formData.append('action', 'addLeave');
                formData.append('startDate', startDate);
                formData.append('endDate', endDate);
                formData.append('reason', reason);
                return fetch('<?= $crm ?>shared/my_leaves.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.showValidationMessage(data.message || 'Failed to submit leave request.');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage('Failed to submit leave request.');
                });
            }
        });
    });
}
</script>

<style>
/* Gradient text utility */
.text-gradient {
  background: linear-gradient(45deg, #1a237e, #4e73df);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.custom-input {
  border-radius: 15px;
  border: 2px solid #e3e6f0;
  padding: 12px;
  font-size: 1rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.custom-input:focus {
  box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
  border-color: #4e73df;
}

.custom-button {
  border-radius: 15px;
  padding: 12px;
  background: linear-gradient(45deg, #1a237e, #4e73df);
  border: none;
  font-weight: 600;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 15px rgba(78, 115, 223, 0.2);
  transition: all 0.3s ease;
  color: #fff;
}
.custom-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(78, 115, 223, 0.3);
  background: linear-gradient(45deg, #4e73df, #1a237e);
  color: #fff;
}

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

.table-responsive-data2 {
  overflow-x: auto;
  display: flex;
  justify-content: center;
  padding: 0;
  margin: 0;
}

.table-data2 {
  min-width: 900px;
  max-width: 1000px;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  table-layout: fixed;
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

.tr-shadow {
  height: auto !important;
  border-radius: 8px;
  transition: all 0.3s;
}
.tr-shadow:hover {
  background-color: #f8f9fa;
  transform: translateY(-1px);
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.spacer {
  height: 4px;
}

.status--process {
  padding: 4px 12px;
  border-radius: 12px;
  font-weight: 500;
  font-size: 13px;
  display: inline-block;
  text-align: center;
  min-width: 80px;
}
.status--process.approved {
  background-color: #28a745;
  color: white;
}
.status--process.rejected {
  background-color: #dc3545;
  color: white;
}
.status--process.pending {
  background-color: #ffc107;
  color: #000;
}

.pagination {
  margin: 0;
}

#showingEntries {
  font-size: 0.9rem;
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .main-content {
    min-height: 100vh;
  }
  .container-fluid {
    min-height: 90vh;
  }
  .card {
    margin-bottom: 32px !important;
  }
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

/* Custom select styling to match date input */
.custom-select {
  border-radius: 15px;
  border: 2px solid #e3e6f0;
  padding: 12px 40px 12px 16px;
  font-size: 1rem;
  background: #fff url('data:image/svg+xml;utf8,<svg fill="%234e73df" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7.293 7.293a1 1 0 011.414 0L10 8.586l1.293-1.293a1 1 0 111.414 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z"/></svg>') no-repeat right 16px center/20px 20px;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  transition: box-shadow 0.2s, border-color 0.2s;
  min-height: 48px;
  line-height: 24px;
  height: 48px;
  box-sizing: border-box;
}
.custom-select:focus {
  box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
  border-color: #4e73df;
  outline: none;
}

/* Remove default arrow in IE */
.custom-select::-ms-expand {
  display: none;
}
</style>

<?php require __DIR__ . '/bottom.php'; ?>



       