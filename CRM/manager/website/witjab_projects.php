<?php require_once './top.php'; ?>

<style>
/* Container and Table Wrapper */
.table-container {
    width: 100%;
    margin: 0;
    padding: 0;
}

.table-responsive {
    overflow-x: auto;
    width: 100%;
    margin: 0;
    padding: 0;
    border-radius: 8px;
}

/* Table Core Styles */
.table-data2 {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

/* Fixed Column Widths and Alignment */
.table-data2 th,
.table-data2 td {
    padding: 12px;
    text-align: center !important;
    vertical-align: middle;
    height: 60px; /* Fixed height for consistent alignment */
    display: table-cell;
}

/* Title and Text Column Specific Styles */
.table-data2 th:nth-child(2),
.table-data2 td:nth-child(2),
.table-data2 th:nth-child(3),
.table-data2 td:nth-child(3) {
    display: table-cell;
    vertical-align: middle;
    line-height: 1.4;
}

/* Column Content Wrapper */
.column-content {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

/* Text alignment exceptions */
.table-data2 th:nth-child(2),
.table-data2 td:nth-child(2),
.table-data2 th:nth-child(3),
.table-data2 td:nth-child(3) {
    text-align: left !important; /* Title and Text columns left-aligned */
}

/* Column Widths */
.table-data2 th:nth-child(1), .table-data2 td:nth-child(1) { width: 4%; }   /* ID */
.table-data2 th:nth-child(2), .table-data2 td:nth-child(2) { width: 10%; }  /* Title */
.table-data2 th:nth-child(3), .table-data2 td:nth-child(3) { width: 20%; }  /* Text */
.table-data2 th:nth-child(4), .table-data2 td:nth-child(4) { width: 7%; }   /* Date */
.table-data2 th:nth-child(5), .table-data2 td:nth-child(5) { width: 7%; }   /* Status */
.table-data2 th:nth-child(6), .table-data2 td:nth-child(6) { width: 15%; }  /* File */
.table-data2 th:nth-child(7), .table-data2 td:nth-child(7) { width: 10%; }   /* Colorful */
.table-data2 th:nth-child(8), .table-data2 td:nth-child(8) { width: 10%; }   /* Visibility */
.table-data2 th:nth-child(9), .table-data2 td:nth-child(9) { width: 10%; }  /* Web URL */
.table-data2 th:nth-child(10), .table-data2 td:nth-child(10) { width: 8%; } /* Created At */
.table-data2 th:nth-child(11), .table-data2 td:nth-child(11) { width: 8%; } /* Updated At */
.table-data2 th:nth-child(12), .table-data2 td:nth-child(12) { width: 15%; } /* Actions */

/* Text Truncation */
.truncate {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Actions Column Buttons */
.table-data2 .btn {
    padding: 5px 10px;
    margin: 0 2px;
}

/* Card and Table Base Styles */
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    border-radius: 8px;
}

.table-responsive-data2 {
    overflow-x: auto;
    overflow-y: auto;
    margin: 0 -15px;
    padding: 0 15px;
}

.table-data2 {
    min-width: 1500px;
    width: 100%;
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
}

/* Cell Styles */
.table-data2 td {
    white-space: normal !important;
    overflow: visible !important;
    text-overflow: initial !important;
    word-break: break-word;
    padding: 12px !important;
    vertical-align: middle !important;
    font-size: 0.9rem;
    line-height: 1.4;
}

/* Header Styles */
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

/* Hover Effect */
.table-data2 tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
    transition: background-color 0.2s ease;
}

/* Text column style */
.text-content {
    white-space: pre-wrap;
    max-height: 150px;
    overflow-y: auto;
}

/* Pagination styles */
.pagination {
  margin: 0;
}

#showingEntries {
  font-size: 0.9rem;
}

/* Add this CSS */
.btn-add-project {
    width: 120px; /* Decrease button width */
    padding-right: 1.5rem !important; /* Increase right padding */
    margin-left: 10px; /* Add gap between search and button */
}

/* Update existing styles */
.search-box {
    width: 750px; /* Increase search box width */
    margin-right: 15px; /* Add gap between search and button */
}

/* Update flex container */
.d-flex.align-items-center {
    gap: 15px; /* Consistent gap between elements */
}

/* Optional: Make search input fill the search box */
.search-box .form-control {
    width: 100%;
}
</style>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary">Projects Management</h3>
                    <small class="text-muted">Manage all projects</small>
                </div>
                <div class="card-body">
                    <!-- Search Bar and Add Button -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="search-box">
                            <input type="text" id="searchBar" class="form-control" placeholder="Search by any column" onkeyup="searchProjects()">
                        </div>
                        <button class="btn btn-primary btn-sm btn-add-project">
                            <i class="fas fa-plus"></i> Add Project
                        </button>
                    </div>
                    
                    <!-- Table -->
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-primary">ID</th>
                                    <th class="text-primary">Title</th>
                                    <th class="text-primary">Text</th>
                                    <th class="text-primary">Date</th>
                                    <th class="text-primary">Status</th>
                                    <th class="text-primary">File</th>
                                    <th class="text-primary">Colorful</th>
                                    <th class="text-primary">Visibility</th>
                                    <th class="text-primary">Web URL</th>
                                    <th class="text-primary">Created At</th>
                                    <th class="text-primary">Updated At</th>
                                    <th class="text-primary">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="projectsTableBody"></tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div class="text-muted" id="showingEntries">
                            <!-- Pagination info will be populated by JavaScript -->
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0" id="paginationContainer"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentPage = 1;
const rowsPerPage = 3;

function loadProjects() {
    const tableBody = document.getElementById('projectsTableBody');
    if (!tableBody) {
        console.error('Table body element not found');
        return;
    }

    tableBody.innerHTML = '<tr><td colspan="12" class="text-center">Loading...</td></tr>';

    const searchTerm = document.getElementById('searchBar').value.toLowerCase();
    fetch(`./data/witjab_projects_data.php?page=${currentPage}&limit=${rowsPerPage}&search=${searchTerm}`)
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.error);
            }
            renderTable(response.data);
            updatePagination(response.pagination);
        })
        .catch(error => {
            console.error('Error:', error);
            if (tableBody) {
                tableBody.innerHTML = `<tr><td colspan="12" class="text-center text-danger">
                    Error loading projects: ${esc(error.message)}</td></tr>`;
            }
        });
}

function renderTable(data) {
    const tableBody = document.getElementById('projectsTableBody');
    if (!tableBody) {
        console.error('Table body element not found');
        return;
    }

    if (!data || data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="12" class="text-center">No projects found</td></tr>';
        return;
    }

    tableBody.innerHTML = data.map(project => `
        <tr>
            <td>${esc(project.id)}</td>
            <td>${esc(project.title)}</td>
            <td>${esc(project.text)}</td>
            <td>${esc(project.date)}</td>
            <td>${esc(project.status)}</td>
            <td>${esc(project.file || '-')}</td>
            <td>${esc(project.colorful ? 'Yes' : 'No')}</td>
            <td>${esc(project.visibility)}</td>
            <td>${esc(project.weburl || '-')}</td>
            <td>${esc(new Date(project.createdAt).toLocaleString())}</td>
            <td>${esc(new Date(project.updatedAt).toLocaleString())}</td>
            <td>
                <button class="btn btn-sm btn-primary mr-1" onclick="editProject(${esc(project.id)})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteProject(${esc(project.id)})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

function updatePagination(pagination) {
    const paginationContainer = document.getElementById('paginationContainer');
    if (!paginationContainer) {
        console.error('Pagination container element not found');
        return;
    }

    let paginationHTML = `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">&laquo;</a>
        </li>`;

    for (let i = 1; i <= pagination.total_pages; i++) {
        paginationHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>`;
    }

    paginationHTML += `
        <li class="page-item ${esc(currentPage === pagination.total_pages ? 'disabled' : '')}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">&raquo;</a>
        </li>`;

    paginationContainer.innerHTML = paginationHTML;
}

function changePage(page) {
    currentPage = page;
    loadProjects();
}

function searchProjects() {
    currentPage = 1;
    loadProjects();
}

// Make sure addProject function has access to Swal
function addProject() {
    Swal.fire({
        title: 'Add New Project',
        html: `
            <form id="addProjectForm" class="swal2-compact">
                <div class="form-group mb-2">
                    <label for="title" class="small">Title</label>
                    <input type="text" class="form-control form-control-sm" id="title" required>
                </div>
                <div class="form-group mb-2">
                    <label for="text" class="small">Text</label>
                    <textarea class="form-control form-control-sm" id="text" rows="2" required></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="date" class="small">Date</label>
                    <input type="date" class="form-control form-control-sm" id="date" required>
                </div>
                <div class="form-group mb-2">
                    <label for="status" class="small">Status</label>
                    <select class="form-control form-control-sm" id="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="file" class="small">File URL</label>
                    <input type="text" class="form-control form-control-sm" id="file">
                </div>
                <div class="form-group mb-2">
                    <label for="colorful" class="small">Colorful</label>
                    <select class="form-control form-control-sm" id="colorful" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="visibility" class="small">Visibility</label>
                    <select class="form-control form-control-sm" id="visibility" required>
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="weburl" class="small">Web URL</label>
                    <input type="url" class="form-control form-control-sm" id="weburl">
                </div>
            </form>
        `,
        customClass: {
            popup: 'swal2-large',
            content: 'p-2'
        },
        width: '600px', // Increase width
        padding: '1rem',
        showCancelButton: true,
        confirmButtonText: 'Add Project',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const formData = {
                title: document.getElementById('title').value,
                text: document.getElementById('text').value,
                date: document.getElementById('date').value,
                status: document.getElementById('status').value,
                file: document.getElementById('file').value,
                colorful: document.getElementById('colorful').value === '1',
                visibility: document.getElementById('visibility').value,
                weburl: document.getElementById('weburl').value
            };

            return fetch('./data/add_project.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.error || 'Failed to add project');
                return data;
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Success', 'Project added successfully', 'success');
            loadProjects(); // Refresh table
        }
    }).catch(error => {
        Swal.showValidationMessage(`Failed to add project: ${esc(error.message)}`);
    });
}

function editProject(id) {
    const project = projectsData.find(p => p.id === id);
    if (!project) return;

    Swal.fire({
        title: 'Edit Project',
        html: `
            <form id="editProjectForm" class="swal2-compact">
                <div class="form-group mb-2">
                    <label for="title" class="small">Title</label>
                    <input type="text" class="form-control form-control-sm" id="title" value="${esc(project.title)}" required>
                </div>
                <div class="form-group mb-2">
                    <label for="text" class="small">Text</label>
                    <textarea class="form-control form-control-sm" id="text" rows="2" required>${esc(project.text)}</textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="date" class="small">Date</label>
                    <input type="date" class="form-control form-control-sm" id="date" value="${esc(project.date)}" required>
                </div>
                <div class="form-group mb-2">
                    <label for="status" class="small">Status</label>
                    <select class="form-control form-control-sm" id="status" required>
                        <option value="active" ${esc(project.status === 'active' ? 'selected' : '')}>Active</option>
                        <option value="inactive" ${esc(project.status === 'inactive' ? 'selected' : '')}>Inactive</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="file" class="small">File URL</label>
                    <input type="text" class="form-control form-control-sm" id="file" value="${esc(project.file)}">
                </div>
                <div class="form-group mb-2">
                    <label for="colorful" class="small">Colorful</label>
                    <select class="form-control form-control-sm" id="colorful" required>
                        <option value="1" ${esc(project.colorful ? 'selected' : '')}>Yes</option>
                        <option value="0" ${esc(!project.colorful ? 'selected' : '')}>No</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="visibility" class="small">Visibility</label>
                    <select class="form-control form-control-sm" id="visibility" required>
                        <option value="public" ${esc(project.visibility === 'public' ? 'selected' : '')}>Public</option>
                        <option value="private" ${esc(project.visibility === 'private' ? 'selected' : '')}>Private</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="weburl" class="small">Web URL</label>
                    <input type="url" class="form-control form-control-sm" id="weburl" value="${esc(project.weburl)}">
                </div>
            </form>
        `,
        customClass: {
            popup: 'swal2-large',
            content: 'p-2'
        },
        width: '600px', // Increase width
        padding: '1rem',
        showCancelButton: true,
        confirmButtonText: 'Update Project',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const formData = {
                id: project.id,
                title: document.getElementById('title').value,
                text: document.getElementById('text').value,
                date: document.getElementById('date').value,
                status: document.getElementById('status').value,
                file: document.getElementById('file').value,
                colorful: document.getElementById('colorful').value === '1',
                visibility: document.getElementById('visibility').value,
                weburl: document.getElementById('weburl').value
            };

            return fetch('./data/update_project.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.error || 'Failed to update project');
                return data;
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Success', 'Project updated successfully', 'success');
            loadProjects(); // Refresh table
        }
    }).catch(error => {
        Swal.showValidationMessage(`Failed to update project: ${esc(error.message)}`);
    });
}

function deleteProject(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`./data/delete_project.php?id=${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.error || 'Failed to delete project');
                Swal.fire('Deleted!', 'Project has been deleted.', 'success');
                loadProjects(); // Refresh table
            })
            .catch(error => {
                Swal.fire('Error!', `Failed to delete project: ${esc(error.message)}`, 'error');
            });
        }
    });
}

// Add custom CSS
const style = document.createElement('style');
style.textContent = `
.swal2-large {
    max-height: 80vh !important;
    overflow-y: auto !important; /* Add vertical scrollbar */
}
.swal2-compact .form-control-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
`;
document.head.appendChild(style);

document.addEventListener('DOMContentLoaded', () => {
    // Initialize the add project button
    const addProjectBtn = document.querySelector('.btn-add-project');
    if (addProjectBtn) {
        addProjectBtn.addEventListener('click', addProject);
    } else {
        console.error('Add project button not found');
    }
    
    // Load initial projects
    loadProjects();
});

console.log(typeof Swal);  // Should output "function" if loaded correctly
</script>

<!-- Add this in the head section or before your closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<?php require './bottom.php'; ?>