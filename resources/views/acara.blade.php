<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Acara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
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
            transition: all 0.2s ease;
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
            color: #00b8d4;
        }

        .pagination .page-item.active .page-link {
            background-color: #00b8d4;
            border-color: #00b8d4;
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

        .bi-pencil, .bi-trash {
        cursor: pointer;
        }



    </style>
</head>
<body>
    <div class="vertical-navbar">
        <div class="nav-icon">
            <img src="{{ asset('image/logo.png') }}" alt="Logo">
        </div>
        <div class="nav-icon">
            <a href="dashboard">
                <i class="fas fa-th-large" ></i>
            </a>
        </div>

        <div class="nav-icon active">
            <a href="acara">
            <i class="far fa-calendar-alt"></i>
            </a>
        </div>

        <div class="nav-icon">
            <a href="chat">
            <i class="far fa-comment-alt"></i>
            </a>
        </div>

        <div class="nav-icon">
            <a href="user">
            <i class="far fa-clock"></i>
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
            <h2 class="fs-3 fw-bold m-0">Event</h2>
        </div>

        <!-- Input Event Form -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 fw-bold">Input Event</h5>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Acara</label>
                                <input type="text" class="form-control" id="name" placeholder="Masukkan nama acara">
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal Dimulai</label>
                                <input type="date" class="form-control" id="date">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Masukkan deskripsi acara"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="background-color: #00b3db">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row">
            <div class="col-12">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Cari acara...">
                </div>
            </div>
        </div>

        <!-- Event Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 fw-bold">Upcoming Event</h5>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Waktu</th>
                                        <th>Jenis Acara</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="text-primary me-2">12</div>
                                        <span>Leslie Alexander</span>
                                    </div>
                                </td>
                                <td>09:15-09:45am</td>
                                <td>Dr. Jacob Jones</td>
                                <td>Mumps Stage II</td>
                                <td class="text-end">
                                    <i class="bi bi-pencil text-primary"></i>
                                    <i class="bi bi-trash text-danger ms-2"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="text-primary me-2">12</div>
                                        <span>Ronald Richards</span>
                                    </div>
                                </td>
                                <td>12:00-12:45pm</td>
                                <td>Dr. Theresa Webb</td>
                                <td>Depression</td>
                                <td class="text-end">
                                    <i class="bi bi-pencil text-primary"></i>
                                    <i class="bi bi-trash text-danger ms-2"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="text-primary me-2">12</div>
                                        <span>Jane Cooper</span>
                                    </div>
                                </td>
                                <td>01:15-01:45pm</td>
                                <td>Dr. Jacob Jones</td>
                                <td>Arthritis</td>
                                <td class="text-end">
                                    <i class="bi bi-pencil text-primary"></i>
                                    <i class="bi bi-trash text-danger ms-2"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="text-primary me-2">12</div>
                                        <span>Robert Fox</span>
                                    </div>
                                </td>
                                <td>02:00-02:45pm</td>
                                <td>Dr. Arlene McCoy</td>
                                <td>Fracture</td>
                                <td class="text-end">
                                    <i class="bi bi-pencil text-primary"></i>
                                    <i class="bi bi-trash text-danger ms-2"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="text-primary me-2">12</div>
                                        <span>Jenny Wilson</span>
                                    </div>
                                </td>
                                <td>12:00-12:45pm</td>
                                <td>Dr. Esther Howard</td>
                                <td>Depression</td>
                                <td class="text-end">
                                    <i class="bi bi-pencil text-primary"></i>
                                    <i class="bi bi-trash text-danger ms-2"></i>
                                </td>
                            </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
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
                    window.location.href = '/login';
                }
            });
        }

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
    </script>
</body>
</html>
