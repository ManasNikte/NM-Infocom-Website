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

    /* Apply the blue background color directly to the .lg-3 class */
    .data-item.lg-3 {
        background-color: #007bff !important; /* Blue background */
        color: white !important; /* White text */
        font-weight: 600;
        border: 1px solid #e5e9f2;
    }

    /* More specific targeting for the Hero Slides section */
    .section .row .col-md-3 .data-item.lg-3 {
        background-color: #007bff !important; /* Ensure blue background */
        color: white !important; /* White text */
    }

    .data-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        border-color: #d0d7e6;
    }

    .crossed-out {
        text-decoration: line-through;
        color: #a0aec0;
        background: linear-gradient(135deg, #f8faff, #fff5f5);
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

    /* Statistics section specific styling */
    .section:nth-child(3) .data-item {
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.4;
    }

    /* Heading styling */
    .page-heading {
        font-size: 2rem;
        font-weight: bold;
        color: blue;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Adjust padding and heading color for NM Web Data */
    .nm-web-data-heading {
        margin-top: -20px;
        margin-bottom: 20px;
        color: #007bff; /* Same blue color applied here */
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }

    /* Make sure the blue background is applied to the Hero Slides section */
    .section .data-item.lg-3 {
        background-color: #007bff !important; /* Ensure it applies correctly */
        color: white !important;
    }
</style>


      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="text-primary">NM Web Data</h3>
                    <small class="text-muted">Overview of data counts</small>
                  </div>

                  
                  <div class="card-body">

                  <div class="section" onClick="window.location.href = './stats.php';" style="cursor: pointer;">
                        <div class="section-title">Statistics</div>
                            <div class="data-grid">
                                <div class="data-item lg-3" id="clients_stat">
                                    <span class="stat-count">0</span><br> clients
                                </div>
                                <div class="data-item lg-3" id="websites_stat">
                                    <span class="stat-count">0</span><br> Websites developed
                                </div>
                                <div class="data-item lg-3" id="hours_of_support_stat">
                                    <span class="stat-count">0</span><br> hours of support
                                </div>
                                <div class="data-item lg-3" id="employees_stat">
                                    <span class="stat-count">0</span><br> Employees
                                </div>
                            </div>
                    </div>


                    <div class="section">
                      <div class="row" onClick="window.location.href = './hero_slides.php';" style="cursor: pointer;">
                        <div class="col-md-8">
                          <div class="section-title">Hero Slides</div>
                        </div>
                        <div class="col-md-3 ml-auto">
                          <div class="data-item lg-3" id="hero_slides_count">01</div>
                        </div>
                      </div>
                    </div>

                    <div class="section">
                      <div class="row" onClick="window.location.href = './about_slides.php';" style="cursor: pointer;">
                        <div class="col-md-8">
                          <div class="section-title">About Slides</div>
                        </div>
                        <div class="col-md-3 ml-auto">
                          <div class="data-item lg-3" id="about_count">01</div>
                        </div>
                      </div>
                    </div>


                    <div class="section">
                      <div class="row" onClick="window.location.href = './client_logos.php';" style="cursor: pointer;">
                        <div class="col-md-8">
                          <div class="section-title">Clients</div>
                        </div>
                        <div class="col-md-3 ml-auto">
                          <div class="data-item lg-3" id="clients_count">01</div>
                        </div>
                      </div>
                    </div>

                    <div class="section">
                      <div class="row" onClick="window.location.href = './faqs.php';" style="cursor: pointer;">
                        <div class="col-md-8">
                          <div class="section-title">FAQs</div>
                        </div>
                        <div class="col-md-3 ml-auto">
                          <div class="data-item lg-3" id="faqs_count">01</div>
                        </div>
                      </div>
                    </div>

                    <div class="section">
                      <div class="row" onClick="window.location.href = './nm_reviews.php';" style="cursor: pointer;">
                        <div class="col-md-8">
                          <div class="section-title">Reviews</div>
                        </div>
                        <div class="col-md-3 ml-auto">
                          <div class="data-item lg-3" id="reviews_count">01</div>
                        </div>
                      </div>
                    </div>

                    <div class="section">
                      <div class="row" onClick="window.location.href = './team.php';" style="cursor: pointer;">
                        <div class="col-md-8">
                          <div class="section-title">Team Members</div>
                        </div>
                        <div class="col-md-3 ml-auto">
                          <div class="data-item lg-3" id="team_members_count">01</div>
                        </div>
                      </div>
                    </div>

                    <div class="section">
                      <div class="row" onClick="window.location.href = './web_line.php';" style="cursor: pointer;">
                        <div class="col-md-8">
                          <div class="section-title">Web Data</div>
                        </div>
                        <div class="col-md-3 ml-auto">
                          <div class="data-item lg-3" id="web_data_count">01</div>
                        </div>
                      </div>
                    </div>

                    <div class="section">
                      <div class="row" onClick="window.location.href = './why_us.php';" style="cursor: pointer;">
                        <div class="col-md-8">
                          <div class="section-title">Why Us</div>
                        </div>
                        <div class="col-md-3 ml-auto">
                          <div class="data-item lg-3" id="why_us_count">01</div>
                        </div>
                      </div>
                    </div>
            </div>
          </div>
      </div>
      
        <!-- Add rows here -->
          
        <!-- End the main code above this line -->
<?php require './bottom.php'; ?>

<script>
// Function to load data counts
function loadDataCounts() {
    loadDataCounts.lastArgs = arguments;
    fetch('./data/nm_web_data_counts.php')
        .then(response => {
            return response.text(); // Get raw text first
        })
        .then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('Invalid JSON response');
            }
        })
        .then(data => {
            renderDataCounts(data);
        })
        .catch(error => {
            console.error('Error loading data counts:', error);
            document.getElementById('errorMessage').textContent = 'Error loading data';
        });
}
crmLiveRefresh(function () { loadDataCounts.apply(null, loadDataCounts.lastArgs || []); }); // keep current without polling

// Function to render data counts
function renderDataCounts(counts) {
    const sections = {
        'about': 'about_count',
        'clients': 'clients_count',
        'faqs': 'faqs_count',
        'hero_slides': 'hero_slides_count',
        'reviews': 'reviews_count',
        'stats_total': 'stats_total_count',
        'team_members': 'team_members_count',
        'web_data': 'web_data_count',
        'why_us': 'why_us_count'
    };

    for (const [table, count] of Object.entries(counts)) {
        const elementId = sections[table];
        const element = document.getElementById(elementId);
        

        
        if (element) {
            element.innerText = count;
        }
    }
}

// Function to load statistics
function loadStatistics() {
    loadStatistics.lastArgs = arguments;
    fetch('./data/nm_web_data_stats.php')
        .then(response => response.json())
        .then(data => {
            renderStatistics(data);
        })
}
crmLiveRefresh(function () { loadStatistics.apply(null, loadStatistics.lastArgs || []); }); // keep current without polling

// Function to render statistics
function renderStatistics(stats) {
    document.querySelector('#clients_stat .stat-count').textContent = stats.clients;
    document.querySelector('#websites_stat .stat-count').textContent = stats.websites;
    document.querySelector('#hours_of_support_stat .stat-count').textContent = stats.hours_of_support;
    document.querySelector('#employees_stat .stat-count').textContent = stats.employees;
}

// Load data counts and statistics when the page loads
document.addEventListener('DOMContentLoaded', () => {
    loadDataCounts();
    loadStatistics();
});
</script>
