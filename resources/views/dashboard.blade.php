<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
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
        }

        .nav-icon.active {
            background-color: #00b8d4;
            color: white;
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
            display: flex;
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

        /* Chart styling with consistent aspect ratio */
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

        /* Table styling with consistent padding */
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

        /* Added spacing between main cards */
        .mb-5 {
            margin-bottom: 3rem !important;
        }

        /* Responsive adjustments */
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

            .stats-card {
                height: 120px;
            }
        }
    </style>
</head>

<body>
    <div class="vertical-navbar">
        <div class="nav-icon">
            <img src="{{ asset('image/logo.png') }}" alt="Logo">
        </div>

        <div class="nav-icon active">
            <i class="fas fa-th-large"></i>
        </div>

        <div class="nav-icon">
            <i class="far fa-calendar-alt"></i>
        </div>

        <div class="nav-icon">
            <i class="far fa-comment-alt"></i>
        </div>

        <div class="nav-icon">
            <i class="far fa-clock"></i>
        </div>

        <div class="nav-icon">
            <i class="fas fa-cog"></i>
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
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card shadow-sm stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Card 1</p>
                            <h2 class="fs-1 fw-bold mb-0">1000</h2>
                        </div>
                        <div class="icon-container bg-success bg-opacity-10">
                            <svg class="text-success" style="width: 28px; height: 28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="card shadow-sm stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Card 2</p>
                            <h2 class="fs-1 fw-bold mb-0">2000</h2>
                        </div>
                        <div class="icon-container bg-warning bg-opacity-10">
                            <svg class="text-warning" style="width: 28px; height: 28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="card shadow-sm stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Card 3</p>
                            <h2 class="fs-1 fw-bold mb-0">2399</h2>
                        </div>
                        <div class="icon-container bg-primary bg-opacity-10">
                            <svg class="text-primary" style="width: 28px; height: 28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
                            <h5 class="card-title m-0 fw-bold">Hospital Survey</h5>
                            <small class="text-muted">Patients 2020</small>
                        </div>
                        <div class="chart-container">
                            <svg class="chart" viewBox="0 0 500 200">
                                <!-- Grid lines -->
                                <line x1="0" y1="0" x2="500" y2="0" stroke="#eee" stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="50" x2="500" y2="50" stroke="#eee" stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="100" x2="500" y2="100" stroke="#eee" stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="150" x2="500" y2="150" stroke="#eee" stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="200" x2="500" y2="200" stroke="#eee" stroke-width="1" stroke-dasharray="2" />

                                <!-- Labels Y axis -->
                                <text x="10" y="200" fill="#888" font-size="10">0</text>
                                <text x="10" y="150" fill="#888" font-size="10">50</text>
                                <text x="10" y="100" fill="#888" font-size="10">100</text>
                                <text x="5" y="50" fill="#888" font-size="10">150</text>
                                <text x="5" y="15" fill="#888" font-size="10">200</text>

                                <!-- Labels X axis -->
                                <text x="20" y="195" fill="#888" font-size="10">10</text>
                                <text x="70" y="195" fill="#888" font-size="10">15</text>
                                <text x="120" y="195" fill="#888" font-size="10">20</text>
                                <text x="170" y="195" fill="#888" font-size="10">25</text>
                                <text x="220" y="195" fill="#888" font-size="10">30</text>
                                <text x="270" y="195" fill="#888" font-size="10">35</text>
                                <text x="320" y="195" fill="#888" font-size="10">40</text>
                                <text x="370" y="195" fill="#888" font-size="10">45</text>
                                <text x="420" y="195" fill="#888" font-size="10">50</text>
                                <text x="470" y="195" fill="#888" font-size="10">55</text>

                                <!-- Chart data -->
                                <path d="M0,120 C20,100 40,60 80,70 S130,130 180,120 S230,90 270,95 S310,110 340,90 S380,60 500,30"
                                      fill="rgba(79, 198, 219, 0.4)" stroke="#4FC6DB" stroke-width="2" />
                            </svg>
                            <div class="chart-point"></div>
                            <div class="chart-value">160</div>
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
                                <line x1="0" y1="0" x2="500" y2="0" stroke="#eee" stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="50" x2="500" y2="50" stroke="#eee" stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="100" x2="500" y2="100" stroke="#eee" stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="150" x2="500" y2="150" stroke="#eee" stroke-width="1" stroke-dasharray="2" />
                                <line x1="0" y1="200" x2="500" y2="200" stroke="#eee" stroke-width="1" stroke-dasharray="2" />

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
                                <rect x="20" y="80" width="30" height="120" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                                <rect x="70" y="100" width="30" height="100" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                                <rect x="120" y="50" width="30" height="150" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                                <rect x="170" y="90" width="30" height="110" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                                <rect x="220" y="40" width="30" height="160" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                                <rect x="270" y="70" width="30" height="130" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                                <rect x="320" y="100" width="30" height="100" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                                <rect x="370" y="60" width="30" height="140" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                                <rect x="420" y="80" width="30" height="120" fill="rgba(146, 109, 222, 0.8)" rx="4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 fw-bold">Appointment Activity</h5>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Visit Time</th>
                                        <th>Doctor</th>
                                        <th>Conditions</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary">LA</div>
                                                <span>Leslie Alexander</span>
                                            </div>
                                        </td>
                                        <td>09:15-09:45am</td>
                                        <td>Dr. Jacob Jones</td>
                                        <td>Mumps Stage II</td>
                                        <td class="text-end">
                                            <i class="bi bi-pencil action-icon"></i>
                                            <i class="bi bi-trash action-icon"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-info">RR</div>
                                                <span>Ronald Richards</span>
                                            </div>
                                        </td>
                                        <td>12:00-12:45pm</td>
                                        <td>Dr. Theresa Webb</td>
                                        <td>Depression</td>
                                        <td class="text-end">
                                            <i class="bi bi-pencil action-icon"></i>
                                            <i class="bi bi-trash action-icon"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-warning">JC</div>
                                                <span>Jane Cooper</span>
                                            </div>
                                        </td>
                                        <td>01:15-01:45pm</td>
                                        <td>Dr. Jacob Jones</td>
                                        <td>Arthritis</td>
                                        <td class="text-end">
                                            <i class="bi bi-pencil action-icon"></i>
                                            <i class="bi bi-trash action-icon"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-success">RF</div>
                                                <span>Robert Fox</span>
                                            </div>
                                        </td>
                                        <td>02:00-02:45pm</td>
                                        <td>Dr. Arlene McCoy</td>
                                        <td>Fracture</td>
                                        <td class="text-end">
                                            <i class="bi bi-pencil action-icon"></i>
                                            <i class="bi bi-trash action-icon"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-danger">JW</div>
                                                <span>Jenny Wilson</span>
                                            </div>
                                        </td>
                                        <td>12:00-12:45pm</td>
                                        <td>Dr. Esther Howard</td>
                                        <td>Depression</td>
                                        <td class="text-end">
                                            <i class="bi bi-pencil action-icon"></i>
                                            <i class="bi bi-trash action-icon"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                    localStorage.removeItem('token');
                    sessionStorage.clear();
                    window.location.href = '/test';
                }
            });
        }
    </script>
</body>

</html>
