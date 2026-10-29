<?php require_once './top.php'; ?>
<style>
    body {
        font-family: 'Inter', Arial, sans-serif;
        margin: 20px;
        padding: 0;
        background-color: #f0f2f5;
    }

    .section {
        border: none;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .section:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .section:nth-child(even) {
        background: linear-gradient(to right, #ffffff, #f8faff);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        text-align: left;
        margin-bottom: 0;
        color: #007bff; /* Blue color applied here */
        letter-spacing: -0.02em;
    }

    .data-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 15px;
    }

    .data-item {
        text-align: center;
        border: 1px solid #e5e9f2;
        border-radius: 8px;
        padding: 14px;
        font-size: 0.95rem;
        background-color: #ffffff;
        color: #4a5568;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .data-item.lg-3 {
        background-color: #007bff !important; /* Blue background */
        color: white !important; /* White text */
        font-weight: 600;
        border: 1px solid #e5e9f2;
    }

    .data-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        border-color: #d0d7e6;
    }

    .row {
        align-items: center;
        min-height: 60px;
    }

    .col-md-8 {
        padding-left: 10px;
    }

    .col-md-3 {
        padding-right: 10px;
    }

    .page-heading {
        font-size: 2rem;
        font-weight: bold;
        color: blue;
        text-align: center;
        margin-bottom: 20px;
    }

    .nm-web-data-heading {
        margin-top: -20px;
        margin-bottom: 20px;
        color: #007bff; /* Same blue color applied here */
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }
</style>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-primary">WitJab Web Data</h3>
                            <small class="text-muted">Overview of data counts</small>
                        </div>
                
                        
                            <div class="section">
                                <div class="row" onClick="window.location.href = './witjab_projects.php';" style="cursor: pointer;">
                                    <div class="col-md-8">
                                        <div class="section-title">Projects</div>
                                    </div>
                                    <div class="col-md-3 ml-auto">
                                        <div class="data-item lg-3" id="witjab_projects_count">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row" onClick="window.location.href = './reviews.php';" style="cursor: pointer;">
                                    <div class="col-md-8">
                                        <div class="section-title">Reviews</div>
                                    </div>
                                    <div class="col-md-3 ml-auto">
                                        <div class="data-item lg-3" id="reviews_count">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row" onClick="window.location.href = './socials.php';" style="cursor: pointer;">
                                    <div class="col-md-8">
                                        <div class="section-title">Socials</div>
                                    </div>
                                    <div class="col-md-3 ml-auto">
                                        <div class="data-item lg-3" id="socials_count">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row" onClick="window.location.href = './contact_forms.php';" style="cursor: pointer;">
                                    <div class="col-md-8">
                                        <div class="section-title">Contact Forms</div>
                                    </div>
                                    <div class="col-md-3 ml-auto">
                                        <div class="data-item lg-3" id="contact_forms_count">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './bottom.php'; ?>

<script>
// Function to load data counts
function loadDataCounts() {
    fetch('./data/witjab_counts.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            document.getElementById('newsletter_subscribers_count').textContent = data.newsletter_subscribers;
            document.getElementById('witjab_projects_count').textContent = data.projects;
            document.getElementById('reviews_count').textContent = data.reviews;
            document.getElementById('socials_count').textContent = data.socials;
            document.getElementById('contact_forms_count').textContent = data.contact_forms;
        })
        .catch(error => {
            console.error('Error loading counts:', error);
        });
}

// Load data counts when the page loads
document.addEventListener('DOMContentLoaded', loadDataCounts);
</script>
