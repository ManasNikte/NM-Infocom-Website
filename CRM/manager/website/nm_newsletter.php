<?php require_once './top.php'; ?>

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <?php require './analytics/nm_newsletter_analytics_cards.php'; ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Newsletter Table Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="text-primary mb-0">Newsletter</h3>
                            <div class="d-flex justify-content-end align-items-center mt-2">
                                <input type="text" id="newsletterSearchBar" class="form-control form-control-sm" style="max-width: 260px;" placeholder="Search Newsletter..." onkeyup="searchNewsletterTable()">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-responsive-data2 mb-2">
                                <table class="table table-data2 table-hover table-striped table-sm align-middle">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white">ID</th>
                                            <th class="text-white">Date</th>
                                            <th class="text-white">Title</th>
                                            <th class="text-white">Subscribers</th>
                                            <th class="text-white">PDF</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2024-05-01</td>
                                            <td>Spring Updates</td>
                                            <td>1200</td>
                                            <td><a href="#" target="_blank">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2024-04-01</td>
                                            <td>April Announcements</td>
                                            <td>1150</td>
                                            <td><a href="#" target="_blank">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>2024-03-01</td>
                                            <td>March Insights</td>
                                            <td>1100</td>
                                            <td><a href="#" target="_blank">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>2024-02-15</td>
                                            <td>Valentine Special</td>
                                            <td>1080</td>
                                            <td><a href="#" target="_blank">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>2024-01-10</td>
                                            <td>New Year Kickoff</td>
                                            <td>1050</td>
                                            <td><a href="#" target="_blank">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>2023-12-20</td>
                                            <td>Year End Review</td>
                                            <td>1000</td>
                                            <td><a href="#" target="_blank">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>2023-11-05</td>
                                            <td>Autumn Edition</td>
                                            <td>980</td>
                                            <td><a href="#" target="_blank">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>2023-10-01</td>
                                            <td>October News</td>
                                            <td>950</td>
                                            <td><a href="#" target="_blank">PDF</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination for Newsletter Table -->
                            <div class="mt-2 d-flex justify-content-between align-items-center">
                                <div></div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0" id="newsletterPagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- End Newsletter Table Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-primary mb-0">Newsletter Subscribers</h3>
                            <small class="text-muted">Manage newsletter subscriptions</small>
                            <div class="d-flex justify-content-end align-items-center mt-2">
                                <input type="text" id="searchBar" class="form-control form-control-sm" style="max-width: 260px;" placeholder="Search Subscribers..." onkeyup="searchNewsletter()">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-responsive-data2 mb-2">
                                <table class="table table-data2 table-hover table-striped table-sm align-middle" id="newsletterTable">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white">ID</th>
                                            <th class="text-white">Name</th>
                                            <th class="text-white">Email</th>
                                            <th class="text-white">Date Added</th>
                                            <th class="text-white">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="newsletter-table-body">
                                        <!-- Data will be loaded dynamically -->
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <div class="mt-2 d-flex justify-content-between align-items-center">
                                <div class="text-muted" id="showingEntries">
                                    <!-- Pagination info will be populated by JavaScript -->
                                </div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0" id="pagination">
                                        <!-- Pagination buttons will be populated by JavaScript -->
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

<?php require './bottom.php'; ?>

<style>
/* Card Styling */
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    border-radius: 8px;
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #f0f0f0;
    padding: 20px 20px 10px 20px;
}

.table-responsive-data2 {
    overflow-x: auto;
    overflow-y: auto;
    margin: 0 -15px;
    padding: 0 15px;
}

.table-data2 {
    min-width: 900px;
    width: 100%;
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
}

.table-data2 td, .table-data2 th {
    white-space: normal !important;
    overflow: visible !important;
    text-overflow: initial !important;
    word-break: break-word;
    padding: 8px 6px !important;
    vertical-align: middle !important;
    font-size: 0.92rem;
    line-height: 1.4;
}

.table-data2 thead th {
    font-weight: 600;
    background-color: #007bff;
    color: #fff;
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle !important;
    position: sticky;
    top: 0;
    z-index: 1;
}

.table-data2 tbody tr:hover {
    background-color: rgba(54,209,196,0.07);
    transition: background-color 0.2s ease;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}

.form-control-sm {
    font-size: 0.95rem;
    padding: 0.3rem 0.7rem;
    border-radius: 6px;
}

.pagination-sm .page-link {
    padding: 0.25rem 0.7rem;
    font-size: 0.95rem;
    border-radius: 6px;
}

.mt-2 {
    margin-top: 0.7rem !important;
}
.mb-2 {
    margin-bottom: 0.7rem !important;
}
</style>

<script>
let currentPage = 1;
const rowsPerPage = 5;

// Function to load table data
function loadTableData() {
    const searchTerm = document.getElementById('searchBar').value.toLowerCase();
    fetch('./data/nm_newsletter_data.php')
        .then(response => response.json())
        .then(data => {
            renderTable(data, searchTerm);
            renderPagination(data.length);
        })
        .catch(error => console.error('Error loading data:', error.message));
}

// Function to render table rows
function renderTable(newsletters, searchTerm = '') {
    const tableBody = document.getElementById('newsletter-table-body');
    tableBody.innerHTML = '';

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    const filteredNewsletters = newsletters.filter(newsletter => {
        const id = newsletter.id.toString().toLowerCase();
        const name = newsletter.name.toLowerCase();
        const email = newsletter.email.toLowerCase();
        const dateAdded = newsletter.date_added.toLowerCase();
        const status = newsletter.status.toLowerCase();

        return (
            id.includes(searchTerm) ||
            name.includes(searchTerm) ||
            email.includes(searchTerm) ||
            dateAdded.includes(searchTerm) ||
            status.includes(searchTerm)
        );
    });

    const paginatedNewsletters = filteredNewsletters.slice(start, end);

    paginatedNewsletters.forEach(newsletter => {
        const row = `
            <tr>
                <td>${esc(newsletter.id)}</td>
                <td>${esc(newsletter.name)}</td>
                <td>${esc(newsletter.email)}</td>
                <td>${esc(newsletter.date_added)}</td>
                <td>${esc(newsletter.status)}</td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
}

// Function to render pagination
function renderPagination(totalItems) {
    const paginationContainer = document.getElementById('pagination');
    const totalPages = Math.ceil(totalItems / rowsPerPage);

    let paginationHTML = `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">&laquo;</a>
        </li>
    `;

    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>
        `;
    }

    paginationHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">&raquo;</a>
        </li>
    `;

    paginationContainer.innerHTML = paginationHTML;
}

// Function to change the current page
function changePage(page) {
    currentPage = page;
    loadTableData();
}

// Function to handle search
function searchNewsletter() {
    currentPage = 1;
    loadTableData();
}

// Initialize table
document.addEventListener('DOMContentLoaded', () => {
    loadTableData();
});

// Newsletter Table Pagination
const newsletterRows = [
    {id: 1, date: '2024-05-01', title: 'Spring Updates', subscribers: 1200, pdf: '#'},
    {id: 2, date: '2024-04-01', title: 'April Announcements', subscribers: 1150, pdf: '#'},
    {id: 3, date: '2024-03-01', title: 'March Insights', subscribers: 1100, pdf: '#'},
    {id: 4, date: '2024-02-15', title: 'Valentine Special', subscribers: 1080, pdf: '#'},
    {id: 5, date: '2024-01-10', title: 'New Year Kickoff', subscribers: 1050, pdf: '#'},
    {id: 6, date: '2023-12-20', title: 'Year End Review', subscribers: 1000, pdf: '#'},
    {id: 7, date: '2023-11-05', title: 'Autumn Edition', subscribers: 980, pdf: '#'},
    {id: 8, date: '2023-10-01', title: 'October News', subscribers: 950, pdf: '#'}
];
const newsletterRowsPerPage = 4;
let newsletterCurrentPage = 1;

function renderNewsletterTable(page = 1) {
    const start = (page - 1) * newsletterRowsPerPage;
    const end = start + newsletterRowsPerPage;
    const rows = newsletterRows.slice(start, end);
    const tbody = document.querySelector('.card.mb-4 tbody');
    tbody.innerHTML = rows.map(row => `
        <tr>
            <td>${esc(row.id)}</td>
            <td>${esc(row.date)}</td>
            <td>${esc(row.title)}</td>
            <td>${esc(row.subscribers)}</td>
            <td><a href="${esc(row.pdf)}" target="_blank">PDF</a></td>
        </tr>
    `).join('');
}

function renderNewsletterPagination() {
    const totalPages = Math.ceil(newsletterRows.length / newsletterRowsPerPage);
    const pagination = document.getElementById('newsletterPagination');
    let html = '';
    html += `<li class="page-item${newsletterCurrentPage === 1 ? ' disabled' : ''}"><a class="page-link" href="#" onclick="changeNewsletterPage(${newsletterCurrentPage - 1});return false;">&laquo;</a></li>`;
    for (let i = 1; i <= totalPages; i++) {
        html += `<li class="page-item${newsletterCurrentPage === i ? ' active' : ''}"><a class="page-link" href="#" onclick="changeNewsletterPage(${i});return false;">${i}</a></li>`;
    }
    html += `<li class="page-item${newsletterCurrentPage === totalPages ? ' disabled' : ''}"><a class="page-link" href="#" onclick="changeNewsletterPage(${newsletterCurrentPage + 1});return false;">&raquo;</a></li>`;
    pagination.innerHTML = html;
}

function changeNewsletterPage(page) {
    const totalPages = Math.ceil(newsletterRows.length / newsletterRowsPerPage);
    if (page < 1 || page > totalPages) return;
    newsletterCurrentPage = page;
    renderNewsletterTable(page);
    renderNewsletterPagination();
}

document.addEventListener('DOMContentLoaded', function() {
    renderNewsletterTable(newsletterCurrentPage);
    renderNewsletterPagination();
});

// Newsletter Table (first table) search
function searchNewsletterTable() {
    const searchTerm = document.getElementById('newsletterSearchBar').value.toLowerCase();
    const rows = document.querySelectorAll('.card.mb-4 tbody tr');
    rows.forEach(row => {
        const cells = Array.from(row.querySelectorAll('td'));
        const match = cells.some(cell => cell.textContent.toLowerCase().includes(searchTerm));
        row.style.display = match ? '' : 'none';
    });
}
</script>
