<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <title>Event</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
  
    <style>
        .flasher {
    background-color: #ffffff;
    color: #333;
    border: 1px solid #ddd;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
.flasher .flasher-title {
    font-weight: bold;
    color: #000;
}
.flasher-success {
    border-left: 5px solid #28a745;
}
.flasher-error {
    border-left: 5px solid #dc3545;
}
.flasher-warning {
    border-left: 5px solid #ffc107;
}
.flasher-info {
    border-left: 5px solid #17a2b8;
}

        body {
            margin: 0;
            padding: 0;
            background-color: #F6F8FB;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            overflow-x: hidden;
        }

        .vertical-navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 80px;
            height: 92vh;
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            z-index: 1000;
            border-radius: 15px 15px 15px 15px;
            margin: 30px 30px;
        }

        .nav-icon a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .nav-indicator {
            position: absolute;
            left: 0;
            width: 4px;
            height: 48px;
            background-color: #D21F3C;
            border-radius: 0 4px 4px 0;
            transition: top 0.3s ease;
            pointer-events: none;
        }

        .nav-icon {
            width: 48px;
            height: 48px;
            margin: 12px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: #777;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-icon:hover {
            background-color: #f0f0f0;
            transform: scale(1.2);
        }

        .nav-icon.active {
            background-color: #D21F3C;
            color: white;
            transition: background-color 1s ease;
        }

        .nav-icon.logout {
            margin-top: auto;
            color: #f44336;
        }

        .main-content {
            margin-left: 80px;
            padding-left: 5rem;
            padding-top: 3rem;
            width: calc(100% - 80px);
            max-width: 1440px;
            margin-right: auto;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
            align-items: center;
        }

        .icon-container {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .table>:not(caption)>*>* {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        .action-icon {
            cursor: pointer;
            color: #6c757d;
            margin-left: 12px;
            font-size: 16px;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 0px;
        }

        .pagination .page-item .page-link {
            color: #D21F3C;
        }

        .pagination .page-item.active .page-link {
            background-color: #D21F3C;
            border-color: #D21F3C;
            color: white;
        }

        .search-container {
            position: relative;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .search-container input {
            padding-left: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .search-container i {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table>:not(caption)>*>* {
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
            font-size: 14px;
        }

        .action-icon {
            cursor: pointer;
            color: #6c757d;
            margin-left: 12px;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .vertical-navbar {
                width: 60px;
            }

            .main-content {
                margin-left: 60px;
                width: calc(100% - 60px);
                padding: 1rem;
            }

            .nav-icon {
                width: 40px;
                height: 40px;
            }
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            height: 100%;
        }

        .stats-card {
            height: 140px;
            display: flex;
            align-items: center;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .bi-pencil,
        .bi-trash {
            cursor: pointer;
        }

        .nav-logo {
            width: 48px;
            height: 48px;
            margin: 12px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: #777;
            font-size: 20px;
            transition: all 0.2s ease;
        }

        /* Modal styling */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background-color: #fff;
            width: 100%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-50px);
            opacity: 0;
            transition: transform 0.4s ease-out, opacity 0.4s ease;
        }

        .modal-overlay.active .modal-container {
            transform: translateY(0);
            opacity: 1;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6c757d;
            transition: color 0.2s;
        }

        .close-modal:hover {
            color: #343a40;
        }

        .btn-add-event {
            background-color: #D21F3C;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            display: flex;
            align-items: center;
           justify-content: space-between;
           margin-left: auto;
            gap: 0.5rem;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-add-event:hover {
            background-color: #D21F3C;
            transform: translateY(-2px);
        }

        .btn-add-event:active {
            transform: translateY(0);
        }
        .space{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding :1rem;
            border-bottom: 1px solid #e9ecef;
            gap: 1rem;
        }

        .search-container {
    position: relative;
    margin-bottom: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.search-container input {
    padding-left: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #dee2e6;
    height: 38px;
    width: 100%;
}

.search-container i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 1;
}

    </style>
</head>

<body>



    <div class="vertical-navbar">
        <div class="nav-logo" >
            <img src="{{ asset('image/logo2.png') }}" alt="Logo">
        </div>
        <div class="nav-icon">
            <a href="menu1">
                <i class="fas fa-th-large" ></i>
            </a>
        </div>

        <div class="nav-icon">
            <a href="menu2">
            <i class="far fa-user"></i>
            </a>
        </div>

        <div class="nav-icon active">
            <a href="acara">
                <i class="far fa-calendar-alt"></i>
            </a>
        </div>

        <div class="nav-icon">
            <a href="content">
            <i class="fas fa-photo-video"></i>
            </a>
        </div>
        <div class="nav-icon logout" onclick="handleLogout()">
            <i class="fas fa-sign-out-alt"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header-container">
            <h2 class="fs-3 fw-bold m-0">Event</h2>
        </div>

        <!-- Modal Edit Event Form -->
<div class="modal-overlay" id="editEventModal">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="fw-bold m-0">Edit Event</h5>
            <button class="close-modal" id="closeEditEventModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="editEventForm"  method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editEventId" name="event_id">
                <div class="mb-3">
                    <label for="editEventTitle" class="form-label">Nama Acara</label>
                    <input type="text" class="form-control" id="editEventTitle" name="title" placeholder="Masukkan nama acara">
                </div>
                <div class="mb-3">
                    <label for="editStartDateTime" class="form-label">Tanggal Dimulai</label>
                    <input type="datetime-local" class="form-control" id="editStartDateTime" name="start_date_time">
                </div>
                <div class="mb-3">
                    <label for="editEndDateTime" class="form-label">Tanggal Selesai</label>
                    <input type="datetime-local" class="form-control" id="editEndDateTime" name="end_date_time">
                </div>
                <div class="mb-3">
                    <label for="editEventDescription" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="editEventDescription" name="description" rows="3" placeholder="Masukkan deskripsi acara"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelEditEventBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="updateEventBtnText" style="background-color: #0400d4">Update</button>
        </div>
    </div>
</div>

        <!-- Modal Event Form -->
        <div class="modal-overlay" id="eventModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h5 class="fw-bold m-0">Input Event Baru</h5>
                    <button class="close-modal" id="closeModalBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.event') }}" method="POST" id="eventForm">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Nama Acara</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan nama acara">
                        </div>
                        <div class="mb-3">
                            <label for="start_date_time" class="form-label">Tanggal Dimulai</label>
                            <input type="datetime-local" class="form-control" id="start_date_time" name="start_date_time">
                        </div>
                        <div class="mb-3">
                            <label for="end_date_time" class="form-label">Tanggal Selesai</label>
                            <input type="datetime-local" class="form-control" id="end_date_time" name="end_date_time">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan deskripsi acara"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitBtn" style="background-color: #0700d4">Submit</button>
                </div>
            </div>
        </div>

        <!-- Event Table -->
        <div class="row" id="events-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="space">
                        <h5 class="card-title mb-4 fw-bold">Upcoming Event</h5>
                        <div style="display: flex; gap: 1rem;">
                            <div class="search-container" style="width: 250px;">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" id="searchEvent" placeholder="Cari event...">
                            </div>
                            <button class="btn-add-event" id="openModalBtn">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Event</span>
                            </button>
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary">{{ substr($event->title, 0, 2) }}</div>
                                                <span>{{ $event->title }}</span>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($event->start_date_time)->format('d M Y, H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->end_date_time)->format('d M Y, H:i') }}</td>
                                        <td>{{ Str::limit($event->description, 50) }}</td>
                                        <td>
                                            <span class="badge {{ $event->status == 'up coming' ? 'bg-primary' : 'bg-danger' }}">
                                                {{ $event->status }}
                                            </span>
                                        </td>
                                        <th>
                                             <button type="button" class="btn btn-sm btn-outline-primary edit-event-btn"
                                                data-id="{{ $event->event_id }}"
                                                data-title="{{ $event->title }}"
                                                data-start-datetime="{{ $event->start_date_time }}"
                                                data-end-datetime="{{ $event->end_date_time }}"
                                                data-description="{{ $event->description }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('event.destroy', ['id' => $event->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-1" onclick="confirmDelete(event, this)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </th>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada acara yang tersedia</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        @if($events->hasPages())
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $events->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $events->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @foreach($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                                <li class="page-item {{ $events->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                <li class="page-item {{ $events->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $events->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleLogout() {
    Swal.fire({
        title: 'Logout Confirmation',
        text: 'Are you sure you want to logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Logout',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Create form data instead of JSON
            const formData = new FormData();
            formData.append('_token', csrfToken);

            // Send logout request to server
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    // Don't set Content-Type to let browser set it with boundary for FormData
                },
                body: formData,
                credentials: 'same-origin' // Include cookies in the request
            })
            .then(response => {
                if (response.ok) {
                    return response.json().catch(() => {
                        // If not JSON, treat as successful anyway
                        return { success: true };
                    });
                } else {
                    throw new Error('Server returned ' + response.status);
                }
            })
            .then(data => {
                // Clear client-side storage
                localStorage.removeItem('token');
                sessionStorage.clear();

                // Show success message
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                swal.fire({
                    icon: 'success',
                    title: 'Logged out successfully!'
                });

                // Allow notification to be seen before redirecting
                setTimeout(() => {
                    window.location.href = '/'; // Redirect to login page
                }, 1000);
            })
            .catch(error => {
                console.error('Logout error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Logout Failed',
                    text: 'There was an issue connecting to the server. Please try again.'
                });
            });
        }
    });
}

        // Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('eventModal');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const submitBtn = document.getElementById('submitBtn');
            const eventForm = document.getElementById('eventForm');

            // Open modal
            openModalBtn.addEventListener('click', function() {
                modal.classList.add('active');
                // Add animation class to body to prevent scrolling
                document.body.style.overflow = 'hidden';
            });

            // Close modal functions
            function closeModal() {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Submit form
            submitBtn.addEventListener('click', function() {
                eventForm.submit();
            });

            // Add navbar animation code
            // Get all nav icons except logo and logout
            const navIcons = document.querySelectorAll('.nav-icon:not(:first-child):not(.logout)');

            // Create the sliding indicator element
            const indicator = document.createElement('div');
            indicator.className = 'nav-indicator';
            document.querySelector('.vertical-navbar').appendChild(indicator);

            // Position the indicator at the currently active menu item on load
            const activeIcon = document.querySelector('.nav-icon.active');
            if (activeIcon) {
                positionIndicator(activeIcon);
            }

            // Add click event listeners to all nav icons
            navIcons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    // If clicking on the icon itself
                    if (e.target.tagName === 'I') {
                        e.preventDefault();

                        // Get the parent anchor href
                        const href = this.querySelector('a').getAttribute('href');

                        // Handle the active class and animation
                        handleNavClick(this, href);
                    }
                });
            });

            // Add click event listeners to all anchors within nav icons
            document.querySelectorAll('.nav-icon a').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const navIcon = this.parentElement;
                    const href = this.getAttribute('href');

                    // Handle the active class and animation
                    handleNavClick(navIcon, href);
                });
            });

            // Function to handle nav click animation and navigation
            function handleNavClick(clickedIcon, href) {
                // Skip if already active
                if (clickedIcon.classList.contains('active')) return;

                // Remove active class from current active icon
                const currentActive = document.querySelector('.nav-icon.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }

                // Add active class to clicked icon
                clickedIcon.classList.add('active');

                // Animate the indicator
                positionIndicator(clickedIcon);

                // Navigate after animation completes
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            }

            // Function to position the indicator
            function positionIndicator(targetIcon) {
                const rect = targetIcon.getBoundingClientRect();
                const navbarRect = document.querySelector('.vertical-navbar').getBoundingClientRect();

                // Calculate position relative to navbar
                const top = rect.top - navbarRect.top;

                // Update indicator position
                indicator.style.top = top + 'px';
            }
        });

        // Delete confirmation
        function confirmDelete(event, button) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus acara ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        // Save & restore scroll position for pagination
        document.addEventListener('DOMContentLoaded', function() {
            // Save the scroll position before page reload for events pagination
            const eventPaginationLinks = document.querySelectorAll('nav[aria-label="Page navigation"] .page-link');

            eventPaginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Store current scroll position in sessionStorage
                    sessionStorage.setItem('eventScrollPosition', window.pageYOffset);

                    // Add a hash to the URL to identify the events table section
                    const url = new URL(this.href);
                    url.hash = 'events-table';

                    // Navigate to the modified URL
                    window.location.href = url.toString();
                });
            });

            // Restore scroll position after page load if we're coming back from pagination
            if (window.location.hash === '#events-table' && sessionStorage.getItem('eventScrollPosition')) {
                window.scrollTo(0, parseInt(sessionStorage.getItem('eventScrollPosition')));
            }
        });
    





// === EDIT EVENT FUNCTIONALITY ===
document.addEventListener('DOMContentLoaded', function() {
    const editEventModal = document.getElementById('editEventModal');
    const editEventForm = document.getElementById('editEventForm');
    const closeEditEventModalBtn = document.getElementById('closeEditEventModalBtn');
    const cancelEditEventBtn = document.getElementById('cancelEditEventBtn');
    const updateEventBtnText = document.getElementById('updateEventBtnText');

    // Definisikan fungsi route di JavaScript
    function route(name, params = {}) {
        // Ambil data rute dari meta tag yang disediakan Laravel
        let routes = window.Laravel.routes || {};
        let route = routes[name] || '';

        // Ganti parameter dalam route
        if (typeof params === 'object') {
            for (let key in params) {
                route = route.replace(new RegExp(`{${key}}`, 'g'), params[key]);
            }
        } else {
            // Jika params bukan object, anggap sebagai parameter tunggal
            route = route.replace(/{[^}]+}/, params);
        }

        return route;
    }

    window.Laravel = {
        routes: {
            'admin.event.update': '{{ route("admin.event.update", ["id" => "__id__"]) }}'.replace('__id__', '')
        }
    };

    // Handle edit buttons for event
    document.querySelectorAll('.edit-event-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const startDateTime = this.getAttribute('data-start-datetime');
            const endDateTime = this.getAttribute('data-end-datetime');
            const description = this.getAttribute('data-description');

            // Format dates for datetime-local input
            const formatForDateTimeInput = (dateString) => {
                const date = new Date(dateString);
                const pad = (num) => num.toString().padStart(2, '0');
                return `${date.getFullYear()}-${pad(date.getMonth()+1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
            };

            console.log("Opening edit modal for event ID:", id); // Debug

            // Set form action
            editEventForm.action = `/event/update/${id}`;
          
            // Populate form fields
            document.getElementById('editEventId').value = id;
            document.getElementById('editEventTitle').value = title;
            document.getElementById('editStartDateTime').value = formatForDateTimeInput(startDateTime);
            document.getElementById('editEndDateTime').value = formatForDateTimeInput(endDateTime);
            document.getElementById('editEventDescription').value = description;

            // Show modal
            editEventModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal handlers
    closeEditEventModalBtn.addEventListener('click', closeEditEventModal);
    cancelEditEventBtn.addEventListener('click', closeEditEventModal);

    // Close edit modal when clicking outside
    editEventModal.addEventListener('click', function(e) {
        if (e.target === editEventModal) {
            closeEditEventModal();
            
        }
    });

    // Close edit modal function
    function closeEditEventModal() {
        editEventModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Handle form submission for event
updateEventBtnText.addEventListener('click', async function() {
    const formData = new FormData(editEventForm);
    const eventId = document.getElementById('editEventId').value;

    console.log("Event ID being submitted:", eventId); // Debug

    // Validate required fields
    const title = document.getElementById('editEventTitle').value;
    const startDateTime = document.getElementById('editStartDateTime').value;
    const endDateTime = document.getElementById('editEndDateTime').value;

    if (!title || !startDateTime || !endDateTime) {
        await Swal.fire({
            title: 'Error!',
            text: 'Harap isi semua field yang wajib diisi',
            icon: 'error',
            confirmButtonColor: '#D21F3C'
        });
        return;
    }

    // Validate date sequence
    if (new Date(startDateTime) >= new Date(endDateTime)) {
        await Swal.fire({
            title: 'Error!',
            text: 'Tanggal selesai harus setelah tanggal mulai',
            icon: 'error',
            confirmButtonColor: '#D21F3C'
        });
        return;
    }

    // Show loading state with SweetAlert2
    const swalInstance = Swal.fire({
        title: 'Memproses...',
        html: 'Sedang menyimpan perubahan event',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const response = await fetch(editEventForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        console.log("Response data:", data);

        if (!response.ok) {
            throw new Error(data.message || 'Gagal memperbarui data event');
        }

        // Close loading dialog
        await swalInstance.close();

        if (data.status === 'success') {
            // Show success notification
            await Swal.fire({
                title: 'Sukses!',
                text: data.message || 'Event berhasil diperbarui',
                icon: 'success',
                confirmButtonColor: '#D21F3C',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            });

            // Close modal and reload
            closeEditEventModal();
            window.location.reload();
        } else {
            throw new Error(data.message || 'Gagal memperbarui data event');
        }
    } catch (error) {
        console.error('Error:', error);
        
        // Close loading dialog if still open
        if (swalInstance.isOpen) {
            await swalInstance.close();
        }

        // Show error notification
        await Swal.fire({
            title: 'Error!',
            text: error.message || 'Gagal memperbarui data event',
            icon: 'error',
            confirmButtonColor: '#D21F3C'
        });
    } finally {
        // Reset button state
        updateEventBtnText.disabled = false;
        updateEventBtnText.innerHTML = 'Update';
    }
    });

});
    




// Search functionality for Event table
document.addEventListener('DOMContentLoaded', function() {
    const searchEvent = document.getElementById('searchEvent');
    if (searchEvent) {
        searchEvent.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#events-table tbody tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const startDate = row.cells[1].textContent.toLowerCase();
                const endDate = row.cells[2].textContent.toLowerCase();
                const description = row.cells[3].textContent.toLowerCase();
                const status = row.cells[4].textContent.toLowerCase();

                if (name.includes(searchTerm) ||
                    startDate.includes(searchTerm) ||
                    endDate.includes(searchTerm) ||
                    description.includes(searchTerm) ||
                    status.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
    </script>
</body>
</html>
