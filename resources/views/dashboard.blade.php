<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Bidan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
            background-color: #00b8d4;
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
            transition: all 0.3s ease;
            position: relative;

        }

        .nav-icon:hover {
            background-color: #f0f0f0;

            transform: scale(1.2);
        }

        .nav-icon.active {
            background-color: #00b8d4;
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


        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            height: 100%;
        }

        .stats-card {
            height: 140px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            border-radius: 12px;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .icon-container {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .stats-card:hover .icon-container {
            transform: scale(1.1);
        }

        .card-body {
            padding: 1.5rem !important;
        }

        @media (max-width: 992px) {
            .stats-card {
                height: 120px;
            }

            .icon-container {
                width: 56px;
                height: 56px;
            }

            .display-6 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 768px) {
            .stats-card {
                height: auto;
                min-height: 120px;
            }
        }

        .chart-container {
            position: relative;
            aspect-ratio: 2.5/1;
            max-height: 250px;
            margin-bottom: 16px;
        }

        .chart {
            height: 100%;
            width: 100%;
            position: relative;
        }

        .chart-value {
            position: absolute;
            background-color: white;
            border: 1px solid #4FC6DB;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .chart-point {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: white;
            border: 2px solid #4FC6DB;
            border-radius: 50%;
            top: 42%;
            left: 50%;
            transform: translate(-50%, -50%);
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


        .mb-5 {
            margin-bottom: 3rem !important;
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

        .pagination {
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 0px;
        }

        .pagination .page-item .page-link {
            color: #00b8d4;
        }

        .pagination .page-item.active .page-link {
            background-color: #00b8d4;
            border-color: #00b8d4;
            color: white;
        }

        .bi-pencil,
        .bi-trash {
            cursor: pointer;
        }



        /* Enhanced chart styling */
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 1rem;
        }

        .chart {
            width: 100%;
            height: 100%;
            overflow: visible;
        }

        .chart-point {
            position: absolute;
            width: 12px;
            height: 12px;
            background-color: white;
            border: 3px solid #4FC6DB;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            display: none;
            pointer-events: none;
            z-index: 5;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.1s ease;
        }

        .chart-value {
            position: absolute;
            background-color: #333;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            transform: translate(-50%, -100%);
            display: none;
            pointer-events: none;
            z-index: 6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            min-width: 120px;
            text-align: center;
        }

        .chart-value::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -6px;
            border-width: 6px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        /* Animation for the chart */
        @keyframes draw-line {
            0% {
                stroke-dashoffset: 1000;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        #pregnant-users-chart path {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: draw-line 1.5s ease-in-out forwards;
        }

        #pregnant-users-chart circle {
            opacity: 0;
            animation: fade-in 0.5s ease-in-out forwards;
            animation-delay: 1.2s;
        }

        #pregnant-users-chart text {
            opacity: 0;
            animation: fade-in 0.5s ease-in-out forwards;
            animation-delay: 0.5s;
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
    </style>
</head>

<body>
    <div class="vertical-navbar">
        <div class="nav-logo" >
            <img src="{{ asset('image/logo.png') }}" alt="Logo">
        </div>

        <div class="nav-icon active">
            <a href="dashboard">
                <i class="fas fa-th-large"></i>
            </a>
        </div>



        <div class="nav-icon">
            <a href="chat">
                <i class="far fa-comment-alt"></i>
            </a>
        </div>

        <div class="nav-icon">
            <a href="user">
                <i class="far fa-user"></i>
            </a>
        </div>

        <div class="nav-icon">
            <a href="setting">
                <i class="fas fa-cog"></i>
            </a>
        </div>

        <div class="nav-icon logout" onclick="handleLogout()">
            <i class="fas fa-sign-out-alt"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header-container">
            <h2 class="fs-3 fw-bold m-0">Dashboard</h2>
        </div>


        <div class="row g-4 mb-4">
            <!-- Card 1 - Total Users -->
            <div class="col-md-4">
                <div class="card shadow-sm stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <p class="text-muted small text-uppercase fw-semibold mb-2">Total Users</p>
                            <h2 class="display-6 fw-bold mb-0">{{ number_format($totalUsers) }}</h2>
                        </div>
                        <div class="icon-container bg-primary bg-opacity-10 rounded-circle p-3">
                            <svg class="text-primary" style="width: 32px; height: 32px;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 - User Pregnant -->
            <div class="col-md-4">
                <div class="card shadow-sm stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <p class="text-muted small text-uppercase fw-semibold mb-2">User Pregnant</p>
                            <h2 class="display-6 fw-bold mb-0">{{ number_format($totalPregnant) }}</h2>
                        </div>
                        <div class="icon-container bg-warning bg-opacity-10 rounded-circle p-3">
                            <svg class="text-warning" style="width: 32px; height: 32px;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 - Total Appointment -->
            <div class="col-md-4">
                <div class="card shadow-sm stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <p class="text-muted small text-uppercase fw-semibold mb-2">Total Appointment</p>
                            <h2 class="display-6 fw-bold mb-0">{{ number_format($totalAppointment) }}</h2>
                        </div>
                        <div class="icon-container bg-success bg-opacity-10 rounded-circle p-3">
                            <svg class="text-success" style="width: 32px; height: 32px;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title m-0 fw-bold">Pregnant Users Statistics</h5>
                            <small class="text-muted">Last 12 months</small>
                        </div>
                        <div class="chart-container">
                            <svg class="chart" viewBox="0 0 500 200" id="pregnant-users-chart">

                            </svg>
                            <div class="chart-point"></div>
                            <div class="chart-value"></div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title m-0 fw-bold">Patient Statistics</h5>
                            <small class="text-muted">Monthly Data</small>
                        </div>
                        <div class="chart-container">
                            <svg class="chart" viewBox="0 0 500 200">
                                <!-- Grid lines -->
                                <line x1="0" y1="0" x2="500" y2="0" stroke="#eee"
                                    stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="50" x2="500" y2="50" stroke="#eee"
                                    stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="100" x2="500" y2="100" stroke="#eee"
                                    stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="150" x2="500" y2="150" stroke="#eee"
                                    stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="200" x2="500" y2="200" stroke="#eee"
                                    stroke-width="1" stroke-dasharray="2" />

                                <!-- Labels Y axis -->
                                <text x="10" y="200" fill="#888" font-size="10">0</text>
                                <text x="10" y="150" fill="#888" font-size="10">25</text>
                                <text x="10" y="100" fill="#888" font-size="10">50</text>
                                <text x="5" y="50" fill="#888" font-size="10">75</text>
                                <text x="5" y="15" fill="#888" font-size="10">100</text>

                                <!-- Labels X axis -->
                                <text x="20" y="195" fill="#888" font-size="10">Jan</text>
                                <text x="70" y="195" fill="#888" font-size="10">Feb</text>
                                <text x="120" y="195" fill="#888" font-size="10">Mar</text>
                                <text x="170" y="195" fill="#888" font-size="10">Apr</text>
                                <text x="220" y="195" fill="#888" font-size="10">May</text>
                                <text x="270" y="195" fill="#888" font-size="10">Jun</text>
                                <text x="320" y="195" fill="#888" font-size="10">Jul</text>
                                <text x="370" y="195" fill="#888" font-size="10">Aug</text>
                                <text x="420" y="195" fill="#888" font-size="10">Sep</text>
                                <text x="470" y="195" fill="#888" font-size="10">Oct</text>

                                <!-- Bar chart data -->
                                <rect x="20" y="80" width="30" height="120" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                                <rect x="70" y="100" width="30" height="100" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                                <rect x="120" y="50" width="30" height="150" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                                <rect x="170" y="90" width="30" height="110" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                                <rect x="220" y="40" width="30" height="160" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                                <rect x="270" y="70" width="30" height="130" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                                <rect x="320" y="100" width="30" height="100" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                                <rect x="370" y="60" width="30" height="140" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                                <rect x="420" y="80" width="30" height="120" fill="rgba(146, 109, 222, 0.8)"
                                    rx="4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4 fw-bold">Appointment Activity</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Visit Time</th>
                                        <th>Status</th>
                                        <th>Conditions</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary">{{ $appointment->getInitials() }}
                                                    </div>
                                                    <span>User {{ $appointment->user_id }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $appointment->getFormattedVisitTime() }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $appointment->status == 'Completed' ? 'success' : ($appointment->status == 'Cancelled' ? 'danger' : 'warning') }}">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td>{{ $appointment->notes }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form
                                                    action="{{ route('appointments.destroy', ['appointment' => $appointment->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger ms-1"
                                                        onclick="confirmDelete(event, this)">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" class="mt-4">
                            @if ($appointments->hasPages())
                                <ul class="pagination justify-content-center">
                                    {{-- Previous Page Link --}}
                                    @if ($appointments->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $appointments->previousPageUrl() }}"
                                                onclick="handlePaginationClick(event, '{{ $appointments->previousPageUrl() }}')"
                                                aria-label="Previous">
                                                <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($appointments->getUrlRange(1, $appointments->lastPage()) as $page => $url)
                                        <li
                                            class="page-item {{ $page == $appointments->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}"
                                                onclick="handlePaginationClick(event, '{{ $url }}')">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($appointments->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $appointments->nextPageUrl() }}"
                                                onclick="handlePaginationClick(event, '{{ $appointments->nextPageUrl() }}')"
                                                aria-label="Next">
                                                <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add this to your existing JavaScript section
        document.addEventListener('DOMContentLoaded', function() {
            // Store scroll position in session storage before page unload/refresh
            window.addEventListener('beforeunload', function() {
                sessionStorage.setItem('scrollPosition', window.scrollY);
            });

            // Set up pagination links to use AJAX if possible, or fallback to regular navigation
            document.querySelectorAll('.pagination .page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Store the current scroll position
                    sessionStorage.setItem('scrollPosition', window.scrollY);
                });
            });

            // Restore scroll position after page loads
            const savedScrollPosition = sessionStorage.getItem('scrollPosition');
            if (savedScrollPosition) {
                window.scrollTo(0, parseInt(savedScrollPosition));
                // Optional: Clear the stored position after restoring
                // sessionStorage.removeItem('scrollPosition');
            }
        });
    </script>
    <script>
        function confirmDelete(event, element) {
            event.preventDefault();
            Swal.fire({
                title: 'Delete Confirmation',
                text: 'Are you sure you want to delete this appointment?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    element.closest('form').submit();
                }
            });
        }
    </script>
    <script>
        // Add navbar animation code
        document.addEventListener('DOMContentLoaded', function() {
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart data from server
            const monthlyData = @json($monthlyData);

            // Calculate appropriate max for Y-axis (round to nearest multiple of 50)
            const maxValue = Math.max(...monthlyData.map(item => item.count));
            const roundedMax = Math.max(3, Math.ceil(maxValue / 3) * 3); // Ensure minimum of 50 for proper scale

            // Get SVG element and clear previous content
            const svg = document.getElementById('pregnant-users-chart');
            svg.innerHTML = '';

            // Chart settings
            const chartWidth = 500;
            const chartHeight = 200;
            const padding = {
                top: 10,
                right: 20,
                bottom: 30,
                left: 40
            };
            const innerWidth = chartWidth - padding.left - padding.right;
            const innerHeight = chartHeight - padding.top - padding.bottom;

            // Create group for chart elements with correct positioning
            const g = document.createElementNS("http://www.w3.org/2000/svg", "g");
            g.setAttribute("transform", `translate(${padding.left}, ${padding.top})`);
            svg.appendChild(g);

            // Add grid lines
            for (let i = 0; i <= 4; i++) {
                const y = innerHeight - (i * (innerHeight / 4));
                const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
                line.setAttribute("x1", "0");
                line.setAttribute("y1", y);
                line.setAttribute("x2", innerWidth);
                line.setAttribute("y2", y);
                line.setAttribute("stroke", "#eee");
                line.setAttribute("stroke-width", "1");
                line.setAttribute("stroke-dasharray", "2");
                g.appendChild(line);

                // Add Y-axis labels
                const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                text.setAttribute("x", "-5");
                text.setAttribute("y", y + 4); // +4 for vertical centering
                text.setAttribute("fill", "#888");
                text.setAttribute("font-size", "10");
                text.setAttribute("text-anchor", "end");
                text.textContent = Math.round((roundedMax / 4) * i);
                g.appendChild(text);
            }

            // Add title for Y-axis
            const yAxisTitle = document.createElementNS("http://www.w3.org/2000/svg", "text");
            yAxisTitle.setAttribute("transform", "rotate(-90)");
            yAxisTitle.setAttribute("x", -(innerHeight / 2));
            yAxisTitle.setAttribute("y", -30);
            yAxisTitle.setAttribute("fill", "#666");
            yAxisTitle.setAttribute("font-size", "10");
            yAxisTitle.setAttribute("text-anchor", "middle");
            yAxisTitle.textContent = "New Pregnancies";
            g.appendChild(yAxisTitle);

            // Add X-axis labels
            monthlyData.forEach((item, index) => {
                // Display fewer labels on smaller screens
                if (index % Math.ceil(monthlyData.length / 12) === 0 || index === monthlyData.length - 1) {
                    const x = (index * (innerWidth / (monthlyData.length - 1)));
                    const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                    text.setAttribute("x", x);
                    text.setAttribute("y", innerHeight + 15);
                    text.setAttribute("fill", "#888");
                    text.setAttribute("font-size", "10");
                    text.setAttribute("text-anchor", "middle");
                    text.textContent = item.month_year; // Use month and year
                    g.appendChild(text);
                }
            });

            // Create area path for fill
            let areaPathData = "";
            monthlyData.forEach((item, index) => {
                const x = (index * (innerWidth / (monthlyData.length - 1)));
                const y = innerHeight - ((item.count / roundedMax) * innerHeight);

                if (index === 0) {
                    areaPathData += `M${x},${y} `;
                } else {
                    // Create smooth curve
                    const prevX = ((index - 1) * (innerWidth / (monthlyData.length - 1)));
                    const prevY = innerHeight - ((monthlyData[index - 1].count / roundedMax) * innerHeight);
                    const cpX1 = prevX + (x - prevX) / 3;
                    const cpX2 = prevX + 2 * (x - prevX) / 3;

                    areaPathData += `C${cpX1},${prevY} ${cpX2},${y} ${x},${y} `;
                }
            });

            // Close the path to create area
            const lastX = ((monthlyData.length - 1) * (innerWidth / (monthlyData.length - 1)));
            areaPathData += `L${lastX},${innerHeight} L0,${innerHeight} Z`;

            // Add area to SVG
            const areaPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            areaPath.setAttribute("d", areaPathData);
            areaPath.setAttribute("fill", "rgba(79, 198, 219, 0.2)");
            areaPath.setAttribute("stroke", "none");
            g.appendChild(areaPath);

            // Create line path
            let linePathData = "";
            monthlyData.forEach((item, index) => {
                const x = (index * (innerWidth / (monthlyData.length - 1)));
                const y = innerHeight - ((item.count / roundedMax) * innerHeight);

                if (index === 0) {
                    linePathData += `M${x},${y} `;
                } else {
                    // Create smooth curve
                    const prevX = ((index - 1) * (innerWidth / (monthlyData.length - 1)));
                    const prevY = innerHeight - ((monthlyData[index - 1].count / roundedMax) * innerHeight);
                    const cpX1 = prevX + (x - prevX) / 3;
                    const cpX2 = prevX + 2 * (x - prevX) / 3;

                    linePathData += `C${cpX1},${prevY} ${cpX2},${y} ${x},${y} `;
                }
            });

            // Add line to SVG
            const linePath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            linePath.setAttribute("d", linePathData);
            linePath.setAttribute("fill", "none");
            linePath.setAttribute("stroke", "#4FC6DB");
            linePath.setAttribute("stroke-width", "3");
            g.appendChild(linePath);

            // Add data points
            monthlyData.forEach((item, index) => {
                const x = (index * (innerWidth / (monthlyData.length - 1)));
                const y = innerHeight - ((item.count / roundedMax) * innerHeight);

                const point = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                point.setAttribute("cx", x);
                point.setAttribute("cy", y);
                point.setAttribute("r", "4");
                point.setAttribute("fill", "#ffffff");
                point.setAttribute("stroke", "#4FC6DB");
                point.setAttribute("stroke-width", "2");
                point.setAttribute("data-value", item.count);
                point.setAttribute("data-month", item.month_year);
                g.appendChild(point);
            });

            // Set up hover interaction
            const chartContainer = document.querySelector('.chart-container');
            const chartPoint = document.querySelector('.chart-point');
            const chartValue = document.querySelector('.chart-value');

            // Add mouse events to track hover position
            chartContainer.addEventListener('mousemove', function(e) {
                const svgRect = svg.getBoundingClientRect();
                const mouseX = e.clientX - svgRect.left - padding.left;

                // Find closest point
                const xPoints = monthlyData.map((_, index) => index * (innerWidth / (monthlyData.length -
                    1)));
                const closestPointIndex = xPoints.reduce((closest, x, index) => {
                    return Math.abs(x - mouseX) < Math.abs(xPoints[closest] - mouseX) ? index :
                        closest;
                }, 0);

                // Get data for closest point
                const data = monthlyData[closestPointIndex];
                const pointX = xPoints[closestPointIndex] + padding.left;
                const pointY = innerHeight - ((data.count / roundedMax) * innerHeight) + padding.top;

                // Position pointer
                chartPoint.style.left = `${pointX}px`;
                chartPoint.style.top = `${pointY}px`;
                chartPoint.style.display = 'block';

                // Update tooltip
                chartValue.innerHTML = `<strong>${data.month_year}</strong>: ${data.count} pregnancies`;
                chartValue.style.left = `${pointX}px`;
                chartValue.style.top = `${pointY - 30}px`;
                chartValue.style.display = 'block';
            });

            chartContainer.addEventListener('mouseleave', function() {
                chartPoint.style.display = 'none';
                chartValue.style.display = 'none';
            });
        });
    </script>

    <script>
        import React, {
            useState
        } from 'react';

        const MonthlyAppointmentChart = () => {
            // Sample monthly data for a full year (January - December)
            const [monthlyData, setMonthlyData] = useState([{
                    month: 1,
                    name: 'Jan',
                    count: 45
                },
                {
                    month: 2,
                    name: 'Feb',
                    count: 38
                },
                {
                    month: 3,
                    name: 'Mar',
                    count: 65
                },
                {
                    month: 4,
                    name: 'Apr',
                    count: 42
                },
                {
                    month: 5,
                    name: 'May',
                    count: 74
                },
                {
                    month: 6,
                    name: 'Jun',
                    count: 58
                },
                {
                    month: 7,
                    name: 'Jul',
                    count: 39
                },
                {
                    month: 8,
                    name: 'Aug',
                    count: 62
                },
                {
                    month: 9,
                    name: 'Sep',
                    count: 45
                },
                {
                    month: 10,
                    name: 'Oct',
                    count: 53
                },
                {
                    month: 11,
                    name: 'Nov',
                    count: 49
                },
                {
                    month: 12,
                    name: 'Dec',
                    count: 41
                }
            ]);

            // Calculate the maximum count for scaling
            const maxCount = Math.max(...monthlyData.map(item => item.count));
            const scaleFactor = 150 / maxCount; // 150 is the max height for bars

            return ( <
                div className = "w-full p-4 rounded-lg shadow bg-white" >
                <
                div className = "flex justify-between items-center mb-3" >
                <
                h5 className = "text-lg font-bold" > Patient Statistics < /h5> <
                small className = "text-gray-500" > Monthly Data(Jan - Dec) < /small> <
                /div>

                <
                div className = "overflow-x-auto" >
                <
                svg className = "w-full"
                viewBox = "0 0 600 220"
                style = "min-width: 580px;" > {
                    /* Grid lines */ } <
                line x1 = "50"
                y1 = "0"
                x2 = "550"
                y2 = "0"
                stroke = "#eee"
                strokeWidth = "1"
                strokeDasharray = "2" / >
                <
                line x1 = "50"
                y1 = "50"
                x2 = "550"
                y2 = "50"
                stroke = "#eee"
                strokeWidth = "1"
                strokeDasharray = "2" / >
                <
                line x1 = "50"
                y1 = "100"
                x2 = "550"
                y2 = "100"
                stroke = "#eee"
                strokeWidth = "1"
                strokeDasharray = "2" / >
                <
                line x1 = "50"
                y1 = "150"
                x2 = "550"
                y2 = "150"
                stroke = "#eee"
                strokeWidth = "1"
                strokeDasharray = "2" / >
                <
                line x1 = "50"
                y1 = "200"
                x2 = "550"
                y2 = "200"
                stroke = "#eee"
                strokeWidth = "1"
                strokeDasharray = "2" / >

                {
                    /* Y-axis labels */ } <
                text x = "10"
                y = "200"
                fill = "#888"
                fontSize = "10" > 0 < /text> <
                text x = "10"
                y = "150"
                fill = "#888"
                fontSize = "10" > 25 < /text> <
                text x = "10"
                y = "100"
                fill = "#888"
                fontSize = "10" > 50 < /text> <
                text x = "10"
                y = "50"
                fill = "#888"
                fontSize = "10" > 75 < /text> <
                text x = "5"
                y = "15"
                fill = "#888"
                fontSize = "10" > 100 < /text>

                {
                    /* X-axis labels and bars */ } {
                    monthlyData.map((data, index) => {
                        const barX = 60 + (index * 40);
                        const barHeight = data.count * scaleFactor;
                        const barY = 200 - barHeight;

                        return ( <
                            g key = {
                                data.month
                            } > {
                                /* Month label */ } <
                            text x = {
                                barX + 15
                            }
                            y = "215"
                            fill = "#888"
                            fontSize = "10"
                            textAnchor = "middle" > {
                                data.name
                            } <
                            /text>

                            {
                                /* Count label on top of bar */ } <
                            text x = {
                                barX + 15
                            }
                            y = {
                                barY - 5
                            }
                            fill = "#666"
                            fontSize = "10"
                            textAnchor = "middle" >
                            {
                                data.count
                            } <
                            /text>

                            {
                                /* Bar */ } <
                            rect x = {
                                barX
                            }
                            y = {
                                barY
                            }
                            width = "30"
                            height = {
                                barHeight
                            }
                            fill = "rgba(146, 109, 222, 0.8)"
                            rx = "4" /
                            >
                            <
                            /g>
                        );
                    })
                }

                {
                    /* Y-axis line */ } <
                line x1 = "50"
                y1 = "0"
                x2 = "50"
                y2 = "200"
                stroke = "#ddd"
                strokeWidth = "1" / >

                {
                    /* X-axis line */ } <
                line x1 = "50"
                y1 = "200"
                x2 = "550"
                y2 = "200"
                stroke = "#ddd"
                strokeWidth = "1" / >
                <
                /svg> <
                /div>

                <
                div className = "mt-3 text-sm text-gray-600" >
                <
                p className = "text-center" > Appointments per Month(Current Year) < /p> <
                /div> <
                /div>
            );
        };

        export default MonthlyAppointmentChart;
    </script>
</body>

</html>
