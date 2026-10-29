<style>
    .min-h-150 { min-height: 150px; }
    .card-body { padding: 1.5rem; }
    .opacity-50 { opacity: 0.5; }
    .analytics-card { border: none; border-radius: 1rem; transition: transform 0.2s ease; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); }
    .analytics-card:hover { transform: translateY(-5px); }
    .bg-brown-gradient { background: linear-gradient(45deg,rgb(60, 36, 21) 0%,rgb(118, 81, 78) 100%); }
    .card-icon { font-size: 2.5rem; opacity: 0.8; }
    .card-title { font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem; color: #111 !important; }
    .card-value { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; color: #111 !important; }
    .change-indicator { padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; background: rgba(255, 255, 255, 0.2); color: #111 !important; }
    .change-indicator i { margin-right: 0.25rem; }
    .text-black, .text-black * { color: #111 !important; }
    .percent-up { color: #28a745 !important; }
    .percent-down { color: #dc3545 !important; }
    @media (max-width: 768px) { .analytics-card { margin-bottom: 1rem; } }
</style>
<!-- Analytics Cards Row -->
<div class="row mb-4">
    <!-- Jobs Added Card -->
    <div class="col-sm-6 col-lg-3 d-flex">
        <div class="card bg-brown-gradient w-100 analytics-card">
            <div class="card-body d-flex flex-column min-h-150">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <p class="mb-1 text-uppercase font-weight-bold card-title">Jobs Added This Month</p>
                        <h4 id="jobs-count" class="mb-2 font-weight-bolder card-value">--</h4>
                        <div class="mt-auto">
                          <span id="jobs-percent" class="change-indicator text-black">
                            <i class="fas" id="jobs-arrow"></i> --%
                          </span>
                          <small class="ml-1 text-black">vs last month</small>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <i class="fas fa-briefcase fa-3x opacity-50 text-black"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Applicants Card -->
    <div class="col-sm-6 col-lg-3 d-flex">
        <div class="card bg-brown-gradient w-100 analytics-card">
            <div class="card-body d-flex flex-column min-h-150">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <p class="mb-1 text-uppercase font-weight-bold card-title">Applicants This Month</p>
                        <h4 id="applicants-count" class="mb-2 font-weight-bolder card-value">--</h4>
                        <div class="mt-auto">
                          <span id="applicants-percent" class="change-indicator text-black">
                            <i class="fas" id="applicants-arrow"></i> --%
                          </span>
                          <small class="ml-1 text-black">vs last month</small>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <i class="fas fa-users fa-3x opacity-50 text-black"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shortlisted Card -->
    <div class="col-sm-6 col-lg-3 d-flex">
        <div class="card bg-brown-gradient w-100 analytics-card">
            <div class="card-body d-flex flex-column min-h-150">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <p class="mb-1 text-uppercase font-weight-bold card-title">Shortlisted This Month</p>
                        <h4 id="shortlisted-count" class="mb-2 font-weight-bolder card-value">--</h4>
                        <div class="mt-auto">
                          <span id="shortlisted-percent" class="change-indicator text-black">
                            <i class="fas" id="shortlisted-arrow"></i> --%
                          </span>
                          <small class="ml-1 text-black">vs last month</small>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <i class="fas fa-check-circle fa-3x opacity-50 text-black"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Rejected Card -->
    <div class="col-sm-6 col-lg-3 d-flex">
        <div class="card bg-brown-gradient w-100 analytics-card">
            <div class="card-body d-flex flex-column min-h-150">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div>
                        <p class="mb-1 text-uppercase font-weight-bold card-title">Rejected This Month</p>
                        <h4 id="rejected-count" class="mb-2 font-weight-bolder card-value">--</h4>
                        <div class="mt-auto">
                          <span id="rejected-percent" class="change-indicator text-black">
                            <i class="fas" id="rejected-arrow"></i> --%
                          </span>
                          <small class="ml-1 text-black">vs last month</small>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <i class="fas fa-times-circle fa-3x opacity-50 text-black"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
window.onload = function() {
    const cardMap = [
        { key: 'jobs_added', count: 'jobs-count', percent: 'jobs-percent', arrow: 'jobs-arrow' },
        { key: 'applicants', count: 'applicants-count', percent: 'applicants-percent', arrow: 'applicants-arrow' },
        { key: 'shortlisted', count: 'shortlisted-count', percent: 'shortlisted-percent', arrow: 'shortlisted-arrow' },
        { key: 'rejected', count: 'rejected-count', percent: 'rejected-percent', arrow: 'rejected-arrow' }
    ];
    var xhr = new XMLHttpRequest();
    xhr.open('GET', './analytics/career_analytics_data.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var d = response.data;
                        cardMap.forEach(function(card) {
                            var value = d[card.key];
                            var countElem = document.getElementById(card.count);
                            var percentElem = document.getElementById(card.percent);
                            var arrowElem = document.getElementById(card.arrow);
                            if (countElem && percentElem && arrowElem) {
                                countElem.textContent = value.count;
                                var up = value.percent_change >= 0;
                                percentElem.innerHTML = `<i class='fas fa-arrow-${up ? "up" : "down"} ${up ? "percent-up" : "percent-down"}'></i> <span class='${up ? "percent-up" : "percent-down"}'>${esc(Math.abs(value.percent_change))}%</span>`;
                                arrowElem.className = `fas fa-arrow-${up ? "up" : "down"} ${up ? "percent-up" : "percent-down"}`;
                            }
                        });
                    } else { setError(); }
                } catch (e) { setError(); }
            } else { setError(); }
        }
    };
    xhr.send();
    function setError() {
        cardMap.forEach(function(card) {
            var countElem = document.getElementById(card.count);
            if (countElem) countElem.textContent = 'Error';
        });
    }
}
</script>