<?php require_once './top.php'; ?>
      <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <?php require './analytics/events_analytics_cards.php'; ?>
            <!-- Do not delete this div -->
            <div class="row">
              <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                  <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                      <h3 class="text-white mb-1">
                        <i class="fa fa-calendar me-2"></i><span> </span>Event Management
                      </h3>
                      <small class="text-white-50">Manage and organize your events</small>
                    </div>
                    <button type="button" class="btn btn-light" id="addNewEvent" data-toggle="modal" data-target="#addEventModal">
                      <i class="fa fa-plus me-2"></i>Add New Event
                    </button>
                  </div>
                  <div class="card-body p-4">
                    <!-- Enhanced Search and Filter Section -->
                    <div class="filter-section mb-4">
                      <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                          <div class="filter-group">
                            <label for="eventTypeFilter" class="form-label fw-semibold">
                              <i class="fa fa-filter me-1 text-primary"></i>Event Type
                            </label>
                            <select id="eventTypeFilter" class="form-select form-select-modern" onchange="applyFilters()">
                              <option value="">All Types</option>
                              <option value="In-Person">In-Person</option>
                              <option value="Virtual">Virtual</option>
                              <option value="Hybrid">Hybrid</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-8">
                          <div class="filter-group">
                            <label for="searchBar" class="form-label fw-semibold">
                              <i class="fa fa-search me-1 text-primary"></i>Search
                            </label>
                            <div class="search-input-group">
                              <input type="text" id="searchBar" class="form-control form-control-modern" 
                                     placeholder="Search events by title, description, or speaker..." onkeyup="searchSubmissions()">
                              <span class="search-icon">
                                <i class="fa fa-search"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                          <div class="filter-group">
                            <label class="form-label fw-semibold text-transparent">Action</label>
                            <button type="button" class="btn btn-outline-primary w-100" onclick="clearFilters()" 
                                    title="Clear all filters and reset search">
                              <i class="fa fa-refresh"></i> Reset
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-hover table-modern" id="eventsTable">
                        <thead class="table-light">
                          <tr>
                            <th class="text-center" style="width: 80px;">
                              <i class="fa fa-hashtag me-1"></i>ID
                            </th>
                            <th style="width: 100px;">
                              <i class="fa fa-image me-1"></i>Image
                            </th>
                            <th style="min-width: 200px;">
                              <i class="fa fa-calendar me-1"></i>Event Title
                            </th>
                            <th style="width: 150px;">
                              <i class="fa fa-user me-1"></i>Author
                            </th>
                            <th style="min-width: 250px;">
                              <i class="fa fa-align-left me-1"></i>Description
                            </th>
                            <th style="width: 150px;">
                              <i class="fa fa-tags me-1"></i>Topics
                            </th>
                            <th class="text-center" style="width: 120px;">
                              <i class="fa fa-tag me-1"></i>Type
                            </th>
                            <th class="text-center" style="width: 120px;">
                              <i class="fa fa-calendar me-1"></i>Date
                            </th>
                            
                            <th style="width: 150px;">
                              <i class="fa fa-map-marker me-1"></i>Location
                            </th>
                            <th style="width: 150px;">
                              <i class="fa fa-users me-1"></i>Speakers
                            </th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                          </tr>
                        </thead>
                        <tbody id="events-table-body" class="table-group-divider">
                          <tr>
                            <td colspan="12" class="text-center py-5">
                              <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                              <p class="mt-2 mb-0 text-muted">Loading events...</p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      
                      <!-- Pagination -->
                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted" id="pagination-info">
                          Showing <span id="start-count">0</span> to <span id="end-count">0</span> of <span id="total-count">0</span> entries
                        </div>
                        <nav aria-label="Event pagination">
                          <ul class="pagination mb-0" id="pagination">
                            <!-- Pagination will be inserted here by JavaScript -->
                          </ul>
                        </nav>
                      </div>
                      
                      <!-- Empty State -->
                      <div class="text-center py-5 d-none" id="empty-state">
                        <div class="mb-3">
                          <i class="fa fa-calendar fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted mb-2">No events found</h5>
                        <p class="text-muted mb-3">Try adjusting your search or filter to find what you're looking for.</p>
                        <button class="btn btn-primary" onclick="clearFilters()">
                          <i class="fa fa-refresh me-2"></i>Clear filters
                        </button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <!-- Add rows here -->
          
        <!-- End the main code above this line -->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        <script>
            // Global variables for event management
            let currentEventId = null;
            let currentEventData = {};
            let currentPage = 1;
            const rowsPerPage = 6;
            let totalEvents = 0;
            let isLoading = false;

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Show toast notification using SweetAlert2
            function showToast(title, message, type = 'info') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: type,
                    title: title,
                    text: message
                });
            }

            // Handle add event button click
            document.getElementById('addNewEvent')?.addEventListener('click', function() {
                currentEventId = null;
                currentEventData = {};
                showAddEditEventModal();
            });

            // Show Add/Edit Event Modal using SweetAlert2
            function showAddEditEventModal(eventData = null) {
                const isEdit = eventData !== null;
                const title = isEdit ? 'Edit Event' : 'Add New Event';
                const buttonText = isEdit ? 'Update Event' : 'Save Event';

                Swal.fire({
                    title: title,
                    html: `
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="swal-eventTitle" class="form-label text-start d-block">Event Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="swal-eventTitle" value="${esc(eventData?.event_title || '')}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="swal-eventCategory" class="form-label text-start d-block">Category <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="swal-eventCategory" value="${esc(eventData?.event_category || '')}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="swal-eventDate" class="form-label text-start d-block">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="swal-eventDate" value="${esc(eventData?.event_date || '')}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="swal-eventTime" class="form-label text-start d-block">Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="swal-eventTime" value="${esc(eventData?.event_time || '')}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="swal-eventDescription" class="form-label text-start d-block">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="swal-eventDescription" rows="3" required>${esc(eventData?.event_description || '')}</textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="swal-eventMode" class="form-label text-start d-block">Event Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="swal-eventMode" required>
                                        <option value="">Select Type</option>
                                        <option value="In-Person" ${esc(eventData?.event_mode === 'In-Person' ? 'selected' : '')}>In-Person</option>
                                        <option value="Virtual" ${esc(eventData?.event_mode === 'Virtual' ? 'selected' : '')}>Virtual</option>
                                        <option value="Hybrid" ${esc(eventData?.event_mode === 'Hybrid' ? 'selected' : '')}>Hybrid</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="swal-eventLocation" class="form-label text-start d-block">Location/Platform</label>
                                    <input type="text" class="form-control" id="swal-eventLocation" value="${esc(eventData?.location || '')}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="swal-eventSpeakers" class="form-label text-start d-block">Speakers (comma separated)</label>
                                <input type="text" class="form-control" id="swal-eventSpeakers" value="${eventData?.speakers ? eventData.speakers.join(', ') : ''}">
                            </div>
                            <div class="mb-3">
                                <label for="swal-eventImage" class="form-label text-start d-block">Event Image</label>
                                <input type="file" class="form-control" id="swal-eventImage" accept="image/*">
                                <div class="form-text">Recommended size: 800x450px. Max size: 2MB</div>
                                ${eventData?.event_image ? `<div class="mt-2 text-center"><img src="../uploads/events/${esc(eventData.event_image)}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;"></div>` : ''}
                            </div>
                        </div>
                    `,
                    width: '800px',
                    showCancelButton: true,
                    confirmButtonText: buttonText,
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#6c757d',
                    preConfirm: () => {
                        // Validate required fields
                        const title = document.getElementById('swal-eventTitle').value.trim();
                        const category = document.getElementById('swal-eventCategory').value.trim();
                        const date = document.getElementById('swal-eventDate').value;
                        const time = document.getElementById('swal-eventTime').value;
                        const description = document.getElementById('swal-eventDescription').value.trim();
                        const mode = document.getElementById('swal-eventMode').value;

                        if (!title || !category || !date || !time || !description || !mode) {
                            Swal.showValidationMessage('Please fill in all required fields');
                            return false;
                        }

                        return {
                            title,
                            category,
                            date,
                            time,
                            description,
                            mode,
                            location: document.getElementById('swal-eventLocation').value.trim(),
                            speakers: document.getElementById('swal-eventSpeakers').value.trim(),
                            image: document.getElementById('swal-eventImage').files[0]
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        saveEvent(result.value, isEdit);
                    }
                });
            }

            // Save event function
            async function saveEvent(eventData, isEdit) {
                try {
                    // Show loading
                    Swal.fire({
                        title: isEdit ? 'Updating Event...' : 'Saving Event...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const formData = new FormData();
                    formData.append('eventTitle', eventData.title);
                    formData.append('eventCategory', eventData.category);
                    formData.append('eventDate', eventData.date);
                    formData.append('eventTime', eventData.time);
                    formData.append('eventDescription', eventData.description);
                    formData.append('eventMode', eventData.mode);
                    formData.append('eventLocation', eventData.location);
                    formData.append('eventSpeakers', eventData.speakers);
                    
                    if (isEdit && currentEventId) {
                        formData.append('eventId', currentEventId);
                    }
                    
                    if (eventData.image) {
                        formData.append('eventImage', eventData.image);
                    }

                    const response = await fetch('data/save_event.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        Swal.close();
                        showToast('Success', result.message || (isEdit ? 'Event updated successfully!' : 'Event saved successfully!'), 'success');
                        loadTableData(currentPage);
                    } else {
                        Swal.close();
                        showToast('Error', result.message || 'Failed to save event', 'error');
                    }
                } catch (error) {
                    console.error('Error saving event:', error);
                    Swal.close();
                    showToast('Error', 'An error occurred while saving the event', 'error');
                }
            }

            // Edit event handler
            window.editEvent = function(eventId) {
                // Show loading
                Swal.fire({
                    title: 'Loading Event Data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Fetch event data
                fetch(`data/get_event.php?id=${eventId}`)
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            currentEventId = eventId;
                            currentEventData = data.event;
                            showAddEditEventModal(data.event);
                        } else {
                            showToast('Error', data.message || 'Failed to load event data', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching event data:', error);
                        Swal.close();
                        showToast('Error', 'An error occurred while loading event data', 'error');
                    });
            };

            // Delete event handler
            window.deleteEvent = function(eventId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        performDelete(eventId);
                    }
                });
            };

            // Perform delete function
            async function performDelete(eventId) {
                try {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting Event...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const response = await fetch('data/delete_event.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: eventId })
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        Swal.close();
                        showToast('Success', result.message || 'Event deleted successfully!', 'success');
                        loadTableData(currentPage);
                    } else {
                        Swal.close();
                        showToast('Error', result.message || 'Failed to delete event', 'error');
                    }
                } catch (error) {
                    console.error('Error deleting event:', error);
                    Swal.close();
                    showToast('Error', 'An error occurred while deleting the event', 'error');
                }
            }

            // Main function to load table data
            function loadTableData(page = 1) {
                if (isLoading) return;
                
                console.log('Loading table data for page:', page);
                currentPage = page;
                
                const searchTerm = document.getElementById('searchBar')?.value?.toLowerCase() || '';
                const eventType = document.getElementById('eventTypeFilter')?.value || '';
                
                // Show loading state
                const tbody = document.getElementById('events-table-body');
                const emptyState = document.getElementById('empty-state');
                const table = document.getElementById('eventsTable');
                
                if (!tbody) {
                    console.error('Table body element not found');
                    return;
                }
                
                isLoading = true;
                
                // Show loading state
                tbody.innerHTML = `
                    <tr>
                        <td colspan="12" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 mb-0 text-muted">Loading events...</p>
                            <div class="small text-muted mt-2" id="loading-status">Connecting to server...</div>
                        </td>
                    </tr>`;
                
                // Hide empty state and show table
                if (emptyState) emptyState.classList.add('d-none');
                if (table) table.classList.remove('d-none');
                
                // Build API URL with filters
                let apiUrl = `./data/events_data.php?page=${page}&per_page=${rowsPerPage}`;
                if (searchTerm) {
                    apiUrl += `&search=${encodeURIComponent(searchTerm)}`;
                }
                if (eventType) {
                    apiUrl += `&type=${encodeURIComponent(eventType)}`;
                }
                
                console.log('Fetching data from:', apiUrl);
                updateLoadingStatus('Fetching data from server...');
                
                // Add timestamp to prevent caching
                apiUrl += `&_t=${new Date().getTime()}`;
                
                fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    cache: 'no-cache'
                })
                .then(response => {
                    console.log('Response status:', response.status, response.statusText);
                    updateLoadingStatus(`Server responded with status: ${esc(response.status)} ${esc(response.statusText)}`);
                    
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Response text:', text);
                            throw new Error(`HTTP error! status: ${esc(response.status)} - ${esc(response.statusText)}`);
                        });
                    }
                    return response.json().catch(e => {
                        console.error('JSON parse error:', e);
                        throw new Error('Failed to parse server response');
                    });
                })
                .then(data => {
                    console.log('Data received:', data);
                    if (!data) {
                        throw new Error('No data received from server');
                    }
                    
                    const events = data.events || [];
                    updateLoadingStatus(`Received ${esc(events.length)} events`);
                    
                    if (events.length > 0) {
                        // Ensure the table is visible
                        if (table) {
                            table.classList.remove('d-none');
                            table.style.display = 'table';
                        }
                        if (emptyState) emptyState.classList.add('d-none');
                        
                        // Render the table with the data
                        renderTable(events);
                        
                        // Update pagination if pagination data is available
                        if (data.pagination) {
                            console.log('Using pagination data from API:', data.pagination);
                            totalEvents = data.pagination.total_events || events.length;
                            // Calculate per_page from total_events and total_pages
                            const perPage = data.pagination.total_pages > 0 ? 
                                Math.ceil(data.pagination.total_events / data.pagination.total_pages) : 
                                rowsPerPage;
                            updatePagination({
                                current_page: data.pagination.current_page,
                                per_page: perPage,
                                total: data.pagination.total_events,
                                total_pages: data.pagination.total_pages
                            });
                        } else {
                            // Fallback to default pagination if not provided
                            console.log('Using fallback pagination data');
                            totalEvents = data.total_events || events.length;
                            updatePagination({
                                current_page: page,
                                per_page: rowsPerPage,
                                total: totalEvents,
                                total_pages: Math.ceil(totalEvents / rowsPerPage)
                            });
                        }
                    } else {
                        showEmptyState();
                    }
                })
                .catch(error => {
                    console.error('Error loading table data:', error);
                    updateLoadingStatus(`Error: ${esc(error.message)}`);
                    showErrorState(error, page);
                })
                .finally(() => {
                    isLoading = false;
                });
            }

            // Helper function to update loading status
            function updateLoadingStatus(message) {
                const statusElement = document.getElementById('loading-status');
                if (statusElement) {
                    statusElement.textContent = message;
                    console.log('Status:', message);
                }
            }

            // Function to show empty state
            function showEmptyState() {
                const tbody = document.getElementById('events-table-body');
                const emptyState = document.getElementById('empty-state');
                const table = document.getElementById('eventsTable');
                
                tbody.innerHTML = '';
                table.classList.add('d-none');
                emptyState.classList.remove('d-none');
                
                // Update pagination info for empty state
                document.getElementById('start-count').textContent = '0';
                document.getElementById('end-count').textContent = '0';
                document.getElementById('total-count').textContent = '0';
                
                // Hide pagination
                const paginationContainer = document.getElementById('pagination');
                if (paginationContainer) {
                    paginationContainer.innerHTML = '';
                }
            }

            // Helper function to escape HTML
            function escapeHtml(unsafe) {
                if (!unsafe) return '';
                return unsafe
                    .toString()
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // Function to show error state
            function showErrorState(error, page) {
                console.error('Showing error state:', error);
                const tbody = document.getElementById('events-table-body');
                const table = document.getElementById('eventsTable');
                const emptyState = document.getElementById('empty-state');
                
                if (!tbody) {
                    console.error('Table body element not found');
                    return;
                }
                
                // Show detailed error in console
                if (error.response) {
                    console.error('Error response:', error.response);
                }
                
                const errorMessage = error.message || 'An unknown error occurred';
                
                if (table) table.classList.add('d-none');
                if (emptyState) emptyState.classList.add('d-none');
                
                tbody.innerHTML = `
                    <tr>
                        <td colspan="12" class="text-center py-5">
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle fa-2x mb-3 d-block"></i>
                                <h5>Error Loading Events</h5>
                                <p class="mb-2">${escapeHtml(errorMessage)}</p>
                                <div class="mt-3">
                                    <button class="btn btn-primary me-2" onclick="loadTableData(${page})">
                                        <i class="fa fa-refresh me-1"></i> Try Again
                                    </button>
                                    <button class="btn btn-outline-secondary" onclick="console.error('Full error:', ${JSON.stringify(error, Object.getOwnPropertyNames(error))})">
                                        <i class="fa fa-bug me-1"></i> Show Details
                                    </button>
                                </div>
                            </div>
                            <div class="mt-3 text-start small">
                                <p class="mb-1"><strong>Troubleshooting steps:</strong></p>
                                <ol class="text-start ps-3">
                                    <li>Check your internet connection</li>
                                    <li>Verify the server is running</li>
                                    <li>Check browser console for detailed error (F12 > Console)</li>
                                    <li>Try refreshing the page</li>
                                </ol>
                            </div>
                        </td>
                    </tr>`;
            }

            // Function to update pagination
            function updatePagination(pagination) {
                console.log('Updating pagination with data:', pagination);
                const paginationContainer = document.getElementById('pagination');
                
                // Ensure we have valid numeric values
                const currentPage = parseInt(pagination.current_page) || 1;
                const perPage = parseInt(pagination.per_page) || rowsPerPage;
                const total = parseInt(pagination.total) || 0;
                
                const start = ((currentPage - 1) * perPage) + 1;
                const end = Math.min(start + perPage - 1, total);
                
                console.log('Pagination calculation:', { currentPage, perPage, total, start, end });
                
                // Update pagination info
                const startCountElement = document.getElementById('start-count');
                const endCountElement = document.getElementById('end-count');
                const totalCountElement = document.getElementById('total-count');
                
                console.log('Pagination elements found:', {
                    startCountElement: !!startCountElement,
                    endCountElement: !!endCountElement,
                    totalCountElement: !!totalCountElement
                });
                
                if (startCountElement) {
                    startCountElement.textContent = start;
                    console.log('Updated start count to:', start);
                } else {
                    console.warn('Start count element not found');
                }
                
                if (endCountElement) {
                    endCountElement.textContent = end;
                    console.log('Updated end count to:', end);
                } else {
                    console.warn('End count element not found');
                }
                
                if (totalCountElement) {
                    totalCountElement.textContent = total;
                    console.log('Updated total count to:', total);
                } else {
                    console.warn('Total count element not found');
                }
                
                // Test with hardcoded values to see if the issue is with calculation
                if (startCountElement && endCountElement && totalCountElement) {
                    console.log('Testing with hardcoded values...');
                    startCountElement.textContent = '1';
                    endCountElement.textContent = '6';
                    totalCountElement.textContent = '7';
                    console.log('Set hardcoded values: 1 to 6 of 7');
                }
                
                // Generate pagination links
                let paginationHTML = '';
                const totalPages = Math.ceil(pagination.total / pagination.per_page);
                
                if (totalPages <= 1) {
                    paginationContainer.innerHTML = '';
                    return;
                }
                
                // Previous button
                paginationHTML += `
                    <li class="page-item ${esc(pagination.current_page === 1 ? 'disabled' : '')}">
                        <a class="page-link" href="#" onclick="loadTableData(${esc(pagination.current_page - 1)}); return false;">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>`;
                
                // Page numbers
                const maxPagesToShow = 5;
                let startPage = Math.max(1, pagination.current_page - Math.floor(maxPagesToShow / 2));
                let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);
                
                if (endPage - startPage + 1 < maxPagesToShow) {
                    startPage = Math.max(1, endPage - maxPagesToShow + 1);
                }
                
                if (startPage > 1) {
                    paginationHTML += `
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="loadTableData(1); return false;">1</a>
                        </li>`;
                    if (startPage > 2) {
                        paginationHTML += `
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>`;
                    }
                }
                
                for (let i = startPage; i <= endPage; i++) {
                    paginationHTML += `
                        <li class="page-item ${esc(i === pagination.current_page ? 'active' : '')}">
                            <a class="page-link" href="#" onclick="loadTableData(${i}); return false;">${i}</a>
                        </li>`;
                }
                
                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        paginationHTML += `
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>`;
                    }
                    paginationHTML += `
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="loadTableData(${totalPages}); return false;">${totalPages}</a>
                        </li>`;
                }
                
                // Next button
                paginationHTML += `
                    <li class="page-item ${esc(pagination.current_page === totalPages ? 'disabled' : '')}">
                        <a class="page-link" href="#" onclick="loadTableData(${esc(pagination.current_page + 1)}); return false;">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>`;
                
                paginationContainer.innerHTML = paginationHTML;
            }

            // Function to render table with data
            function renderTable(events) {
                console.log('Rendering table with events:', events);
                const tbody = document.getElementById('events-table-body');
                
                if (!tbody) {
                    console.error('Table body element not found');
                    return;
                }
                
                // Clear existing content
                tbody.innerHTML = '';
                
                if (!events || !Array.isArray(events) || events.length === 0) {
                    console.log('No events to display');
                    showEmptyState();
                    return;
                }
                
                // Helper function to escape HTML
                const escapeHtml = (unsafe) => {
                    if (!unsafe) return '';
                    return unsafe
                        .toString()
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#039;');
                };

                // Helper function to truncate text with ellipsis
                const truncateWithTooltip = (text, maxLength = 50) => {
                    if (!text) return 'N/A';
                    const str = String(text);
                    if (str.length <= maxLength) return escapeHtml(str);
                    return `<span data-bs-toggle="tooltip" title="${escapeHtml(str)}">
                        ${escapeHtml(str.substring(0, maxLength))}...
                    </span>`;
                };

                // Helper function to format date
                const formatDate = (dateString) => {
                    if (!dateString) return 'N/A';
                    try {
                        const date = new Date(dateString);
                        return isNaN(date.getTime()) ? 'N/A' : date.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                    } catch (e) {
                        console.error('Error formatting date:', e);
                        return 'N/A';
                    }
                };
                
                // Helper function to format time
                const formatTime = (timeString) => {
                    if (!timeString) return 'N/A';
                    try {
                        const [hours, minutes] = String(timeString).split(':');
                        const time = new Date();
                        time.setHours(parseInt(hours, 10), parseInt(minutes || '0', 10));
                        return time.toLocaleTimeString('en-US', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });
                    } catch (e) {
                        console.error('Error formatting time:', e);
                        return 'N/A';
                    }
                };
                
                // Process each event
                events.forEach(event => {
                    try {
                        if (!event) return; // Skip null/undefined events
                        
                        const eventId = event.id || 'N/A';
                        const eventTitle = event.title || 'Untitled Event';
                        const eventDate = formatDate(event.date);
                        const eventTime = formatTime(event.time);
                        const eventType = event.type || 'N/A';
                        const eventSpeakers = event.speakers && String(event.speakers).toLowerCase() !== 'no speakers' 
                            ? event.speakers 
                            : 'No speakers';
                            
                        // Determine badge classes
                        const timingBadge = event.status === 'upcoming'
                            ? '<span class="badge badge-success">Upcoming</span>'
                            : '<span class="badge badge-secondary">Past</span>';
                                          
                        const typeClass = event.type === 'Virtual' ? 'primary' :
                                        event.type === 'In-Person' ? 'success' :
                                        event.type === 'Hybrid' ? 'warning' : 'info';
                        
                        // Create row element
                        const row = document.createElement('tr');
                        row.className = 'event-row align-middle';
                        row.setAttribute('data-id', eventId);
                        
                        // Build action buttons
                        const actionButtons = `
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-sm btn-icon btn-outline-primary edit-event" 
                                        data-id="${eventId}"
                                        data-bs-toggle="tooltip"
                                        title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-outline-danger delete-event" 
                                        data-id="${eventId}"
                                        data-bs-toggle="tooltip"
                                        title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>`;
                        
                        // Build row HTML
                        row.innerHTML = `
                            <td class="text-center">
                                <span class="event-id">#${eventId}</span>
                            </td>
                            <td>
                                <div class="event-image-container">
                                    <img src="../../../uploads/events/${escapeHtml(event.image || 'default-event.jpg')}" 
                                         alt="${escapeHtml(eventTitle)}" 
                                         class="img-fluid rounded"
                                         onerror="this.onerror=null; this.src='../../images/placeholder/image.svg'"
                                         style="width: 60px; height: 40px; object-fit: cover;">
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <div class="fw-medium">${escapeHtml(eventTitle)}</div>
                                <small class="text-muted">${escapeHtml(eventType)}</small>
                            </td>
                            <td>${escapeHtml(event.author || 'N/A')}</td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" 
                                     data-bs-toggle="tooltip" 
                                     title="${escapeHtml(event.description || 'No description')}">
                                    ${event.description ? escapeHtml(event.description.substring(0, 30) + (event.description.length > 30 ? '...' : '')) : 'N/A'}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">${escapeHtml(event.key_topics || 'N/A')}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-${typeClass}">${escapeHtml(eventType)}</span>
                            </td>
                            <td class="text-nowrap">
                                <div class="fw-medium">${eventDate} ${timingBadge}</div>
                                <div class="small text-muted">${eventTime}</div>
                            </td>
                            <td>${escapeHtml(event.location || 'N/A')}</td>
                            <td>${escapeHtml(eventSpeakers)}</td>
                            <td class="text-center">
                                ${actionButtons}
                            </td>`;
                        
                        // Append row to table body
                        tbody.appendChild(row);
                    } catch (error) {
                        console.error('Error rendering event:', error, event);
                    }
                });
                
                // Initialize tooltips
                try {
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.forEach(tooltipTriggerEl => {
                        try {
                            new bootstrap.Tooltip(tooltipTriggerEl);
                        } catch (e) {
                            console.error('Error initializing tooltip:', e);
                        }
                    });
                } catch (e) {
                    console.error('Error initializing tooltips:', e);
                }
                
                // Initialize event listeners for action buttons
                try {
                    document.querySelectorAll('.edit-event').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const eventId = this.getAttribute('data-id');
                            editEvent(eventId);
                        });
                    });
                    
                    document.querySelectorAll('.delete-event').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const eventId = this.getAttribute('data-id');
                            deleteEvent(eventId); // This will trigger SweetAlert2 confirmation
                        });
                    });
                } catch (e) {
                    console.error('Error initializing event listeners:', e);
                }
            }

            // Search and filter functions
            function searchSubmissions() {
                loadTableData(1);
            }

            function applyFilters() {
                loadTableData(1);
            }

            function clearFilters() {
                const searchBar = document.getElementById('searchBar');
                const eventTypeFilter = document.getElementById('eventTypeFilter');
                
                if (searchBar) searchBar.value = '';
                if (eventTypeFilter) eventTypeFilter.value = '';
                
                loadTableData(1);
            }

            // Load table data when the page loads
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM fully loaded');
                
                // Test if pagination elements exist
                const startCountElement = document.getElementById('start-count');
                const endCountElement = document.getElementById('end-count');
                const totalCountElement = document.getElementById('total-count');
                
                console.log('Pagination elements on load:', {
                    startCountElement: !!startCountElement,
                    endCountElement: !!endCountElement,
                    totalCountElement: !!totalCountElement
                });
                
                // Initialize event listeners
                const searchBar = document.getElementById('searchBar');
                const eventTypeFilter = document.getElementById('eventTypeFilter');
                
                if (searchBar) {
                    searchBar.addEventListener('input', function() {
                        loadTableData(1);
                    });
                }
                
                if (eventTypeFilter) {
                    eventTypeFilter.addEventListener('change', () => loadTableData(1));
                }
                
                // Load initial data
                loadTableData(1);
            });
        </script>
<?php require './bottom.php'; ?>
<style>
    /* Modern Table Styles */
    .table-modern {
        --bs-table-bg: transparent;
        --bs-table-striped-bg: rgba(0, 0, 0, 0.01);
        --bs-table-hover-bg: rgba(0, 0, 0, 0.03);
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-modern thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        padding: 1rem 0.75rem;
    }
    
    .table-modern tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }
    
    .table-modern tbody tr:hover td {
        background-color: #f8f9fa;
    }
    
    /* Card Styles */
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    /* Form Controls */
    .form-control, .form-select {
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    
    /* Buttons */
    .btn {
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    
    /* Badges */
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        border-radius: 0.25rem;
    }
    
    /* Event Image */
    .event-image-container {
        width: 60px;
        height: 40px;
        border-radius: 0.25rem;
        overflow: hidden;
    }
    
    .event-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Filter Section */
    .filter-section {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-group {
        margin-bottom: 0.5rem;
    }
    
    /* Search Input */
    .search-input-group {
        position: relative;
    }
    
    .search-input-group .search-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    
    /* Pagination */
    .pagination .page-link {
        border: none;
        color: #495057;
        margin: 0 0.25rem;
        border-radius: 0.25rem !important;
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 1199.98px) {
        .table-responsive {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            overflow: hidden;
        }
    }
    
    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    /* Avatar */
    .avatar-xs {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Empty State */
    #empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
    }
    
    #empty-state i {
        opacity: 0.5;
        margin-bottom: 1rem;
    }
    
    /* Card Styling */
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.08);
        border-radius: 8px;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 20px;
    }
    
    /* Table container */
    .table-responsive-data2 {
        overflow-x: auto;
        margin: 0 -15px;
        padding: 0 15px;
    }
    
    /* Base table styles */
.card-header {
    background-color: #fff;
    border-bottom: 1px solid #f0f0f0;
    padding: 20px;
}

/* Table container */
.table-responsive-data2 {
    overflow-x: auto;
    margin: 0 -15px;
    padding: 0 15px;
}

/* Base table styles */
.table-data2 {
    min-width: 900px;
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

.table-data2 th:nth-child(2), /* Image */
.table-data2 td:nth-child(2) {
    width: 100px;
}

.table-data2 th:nth-child(3), /* Title */
.table-data2 td:nth-child(3) {
    width: 150px;
}

.table-data2 th:nth-child(4), /* Author */
.table-data2 td:nth-child(4) {
    width: 120px;
}

.table-data2 th:nth-child(5), /* Description */
.table-data2 td:nth-child(5) {
    width: 200px;
}

.table-data2 th:nth-child(6), /* Key Topics */
.table-data2 td:nth-child(6) {
    width: 150px;
}

.table-data2 th:nth-child(7), /* Date */
.table-data2 td:nth-child(7) {
    width: 100px;
}

.table-data2 th:nth-child(8), /* Time */
.table-data2 td:nth-child(8) {
    width: 100px;
}

.table-data2 th:nth-child(9), /* Type */
.table-data2 td:nth-child(9) {
    width: 100px;
}

.table-data2 th:nth-child(10), /* Speakers */
.table-data2 td:nth-child(10) {
    width: 150px;
}

.table-data2 th:nth-child(11), /* Link */
.table-data2 td:nth-child(11) {
    width: 150px;
}

.table-data2 th:nth-child(12), /* Date Added */
.table-data2 td:nth-child(12) {
    width: 120px;
}

.table-data2 th:nth-child(13), /* Last Modified */
.table-data2 td:nth-child(13) {
    width: 120px;
}

.table-data2 th:nth-child(14), /* Actions */
.table-data2 td:nth-child(14) {
    width: 100px;
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

/* Add ellipsis for very long text */
.table-data2 td:nth-child(5) {
    position: relative;
}

/* Optional: Add tooltip for long text */
.table-data2 td:nth-child(5)[title] {
    cursor: help;
}

/* Ensure table cells align properly */
.table-data2 th,
.table-data2 td {
    vertical-align: middle !important;
}

/* Add styles for action buttons */
.action-buttons {
  display: flex;
  gap: 5px;
}

.action-btn {
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
  border: none;
}

.edit-btn {
  background: #007bff;
  color: white;
}

.delete-btn {
  background: #dc3545;
  color: white;
}

/* Style for images in table */
.event-thumbnail {
  width: 80px;
  height: 60px;
  object-fit: cover;
  border-radius: 4px;
}

/* Update the column widths */
.table-data2 th:nth-child(1), .table-data2 td:nth-child(1) { width: 50px; }  /* ID */
.table-data2 th:nth-child(2), .table-data2 td:nth-child(2) { width: 100px; } /* Image */
.table-data2 th:nth-child(3), .table-data2 td:nth-child(3) { width: 150px; } /* Title */
.table-data2 th:nth-child(4), .table-data2 td:nth-child(4) { width: 120px; } /* Author */
.table-data2 th:nth-child(5), .table-data2 td:nth-child(5) { width: 200px; } /* Description */
.table-data2 th:nth-child(6), .table-data2 td:nth-child(6) { width: 150px; } /* Key Topics */
.table-data2 th:nth-child(7), .table-data2 td:nth-child(7) { width: 100px; } /* Date */
.table-data2 th:nth-child(8), .table-data2 td:nth-child(8) { width: 100px; } /* Time */
.table-data2 th:nth-child(9), .table-data2 td:nth-child(9) { width: 100px; } /* Type */
.table-data2 th:nth-child(10), .table-data2 td:nth-child(10) { width: 150px; } /* Speakers */
.table-data2 th:nth-child(11), .table-data2 td:nth-child(11) { width: 100px; } /* Link */
.table-data2 th:nth-child(12), .table-data2 td:nth-child(12) { width: 100px; } /* Status */
.table-data2 th:nth-child(13), .table-data2 td:nth-child(13) { width: 120px; } /* Date Added */
.table-data2 th:nth-child(14), .table-data2 td:nth-child(14) { width: 120px; } /* Last Modified */
.table-data2 th:nth-child(15), .table-data2 td:nth-child(15) { width: 120px; } /* Actions */

/* Update action buttons container */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    min-width: 100px; /* Ensure minimum width */
}

/* Make the table header text wrap properly */
.table-data2 th {
    white-space: normal;
    vertical-align: middle;
    text-align: center;
    padding: 12px 6px !important;
}

/* Ensure consistent cell padding */
.table-data2 td {
    padding: 12px 6px !important;
    text-align: center;
    vertical-align: middle !important;
}

/* Make modal non-scrollable and smaller */
.modal-dialog {
    max-width: 50%;
}

.modal-body {
    overflow-y: hidden;
}

/* Ensure form fields are in two columns */
.form-row {
    display: flex;
    flex-wrap: wrap;
}

.form-group {
    flex: 1;
    min-width: 45%;
    margin-right: 10px;
}

.form-group:last-child {
    margin-right: 0;
}

/* Style the submit button */
.form-row.justify-content-end {
    margin-top: 20px;
}

.form-row.justify-content-end .btn {
    padding: 10px 20px;
    font-size: 1rem;
}

/* Make badge text white by default, but black in topics column */
.badge {
    color: white !important;
}

/* Target badges specifically in the topics column */
td:nth-child(6) .badge {
    color: black !important;
    background-color: #e9ecef !important;
    border: 1px solid #dee2e6;
}
</style>

