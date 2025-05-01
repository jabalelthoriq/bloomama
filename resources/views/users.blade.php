<!-- resources/views/users.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Users</title>
</head>
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

        .bi-pencil, .bi-trash {
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

   /* Tab styles */
   .nav-tabs {
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 20px;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #777;
        font-weight: 600;
        padding: 12px 20px;
        margin-right: 5px;
        border-radius: 0;
    }

    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #00b8d4;
        color: #00b8d4;
        background-color: transparent;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        border-bottom: 3px solid #f0f0f0;
    }

    .tab-content {
        padding: 20px 0;
    }
   </style>
<body>
    <div class="vertical-navbar">
        <div class="nav-logo" >
            <img src="{{ asset('image/logo.png') }}" alt="Logo">
        </div>
        <div class="nav-icon">
            <a href="{{ route('dashboard') }}">
                <i class="fas fa-th-large"></i>
            </a>
        </div>



        <div class="nav-icon">
            <a href="/chat">
            <i class="far fa-comment-alt"></i>
            </a>
        </div>

        <div class="nav-icon active">
            <a href="{{ route('user') }}">
            <i class="far fa-user"></i>
            </a>
        </div>

        <div class="nav-icon">
            <a href="/setting">
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
        <h2 class="fs-3 fw-bold m-0">Users</h2>
    </div>

    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="bidan-tab" data-bs-toggle="tab" data-bs-target="#bidan-content" type="button" role="tab" aria-controls="bidan-content" aria-selected="true">
                <i class="fas fa-user-md me-2"></i>Bidan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pasien-tab" data-bs-toggle="tab" data-bs-target="#pasien-content" type="button" role="tab" aria-controls="pasien-content" aria-selected="false">
                <i class="fas fa-user me-2"></i>Pasien
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pregnancies-tab" data-bs-toggle="tab" data-bs-target="#pregnancies-content" type="button" role="tab" aria-controls="pregnancies-content" aria-selected="false">
                <i class="fas fa-baby me-2"></i>Kehamilan
            </button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="userTabsContent">
        <!-- Bidan Content -->
        <div class="tab-pane fade show active" id="bidan-content" role="tabpanel" aria-labelledby="bidan-tab">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold">Tabel Data Bidan</h5>

                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone number</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($midwives as $midwife)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary">{{ substr($midwife->name, 0, 2) }}</div>
                                                <span class="ms-2">{{ $midwife->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $midwife->email }}</td>
                                        <td>{{ $midwife->phone_number }}</td>
                                        <td>
                                            <span class="badge bg-{{ $midwife->status ? 'success' : 'danger' }}">
                                                {{ $midwife->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data bidan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination for Midwives -->
                    @if($midwives->hasPages())
                    <div class="mt-3">
                        <nav aria-label="Page navigation for midwives">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $midwives->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $midwives->appends(['user_page' => request('user_page', 1)])->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @foreach($midwives->getUrlRange(1, $midwives->lastPage()) as $page => $url)
                                    <li class="page-item {{ $midwives->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $midwives->appends(['user_page' => request('user_page', 1)])->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                <li class="page-item {{ $midwives->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $midwives->appends(['user_page' => request('user_page', 1)])->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pasien Content -->
        <div class="tab-pane fade" id="pasien-content" role="tabpanel" aria-labelledby="pasien-tab">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold">Tabel Data Pasien</h5>
                    </div>

                    @if(session('user_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('user_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary">{{ substr($user->name, 0, 2) }}</div>
                                                <span class="ms-2">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->address }}</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data pasien</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination for Users -->
                    @if($users->hasPages())
                    <div class="mt-3">
                        <nav aria-label="Page navigation for users">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $users->appends(['midwife_page' => request('midwife_page', 1)])->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $users->appends(['midwife_page' => request('midwife_page', 1)])->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $users->appends(['midwife_page' => request('midwife_page', 1)])->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pregnancies Content -->
        <div class="tab-pane fade" id="pregnancies-content" role="tabpanel" aria-labelledby="pregnancies-tab">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold">Tabel Data Kehamilan</h5>
                    </div>

                    @if(session('pregnancy_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('pregnancy_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Pasien</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Perkiraan Kelahiran</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pregnancies ?? [] as $pregnancy)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary">{{ substr($pregnancy->user->name ?? '', 0, 2) }}</div>
                                                <span class="ms-2">{{ $pregnancy->user->name ?? 'Unknown' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $pregnancy->start_date ? date('d M Y', strtotime($pregnancy->start_date)) : '-' }}</td>
                                        <td>{{ $pregnancy->due_date ? date('d M Y', strtotime($pregnancy->due_date)) : '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $pregnancy->status == 'active' ? 'success' : ($pregnancy->status == 'completed' ? 'info' : 'warning') }}">
                                                {{ ucfirst($pregnancy->status ?? 'unknown') }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('pregnancies.show', $pregnancy->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pregnancies.edit', $pregnancy->id) }}" class="btn btn-sm btn-outline-primary ms-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pregnancies.destroy', $pregnancy->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('Apakah Anda yakin ingin menghapus data kehamilan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data kehamilan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination for Pregnancies -->
                    @if(isset($pregnancies) && $pregnancies->hasPages())
                    <div class="mt-3">
                        <nav aria-label="Page navigation for pregnancies">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $pregnancies->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $pregnancies->appends(['midwife_page' => request('midwife_page', 1), 'user_page' => request('user_page', 1)])->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @foreach($pregnancies->getUrlRange(1, $pregnancies->lastPage()) as $page => $url)
                                    <li class="page-item {{ $pregnancies->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $pregnancies->appends(['midwife_page' => request('midwife_page', 1), 'user_page' => request('user_page', 1)])->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                <li class="page-item {{ $pregnancies->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $pregnancies->appends(['midwife_page' => request('midwife_page', 1), 'user_page' => request('user_page', 1)])->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
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
            // Remove token and clear session
            localStorage.removeItem('token');
            sessionStorage.clear();

            // Create a flash message about successful logout
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
                icon: 'success',
                title: 'Logged out successfully!'
            });

            // Allow the notification to be seen before redirecting
            setTimeout(() => {
                window.location.href = '/';
            }, 1000);
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

        function confirmDelete(event, button) {
    event.preventDefault();

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus bidan ini?',
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

function confirmDeleteUser(event, button) {
    event.preventDefault();

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus user ini?',
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Save the scroll position before page reload
            const userPaginationLinks = document.querySelectorAll('nav[aria-label="Page navigation for users"] .page-link');

            userPaginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Store current scroll position in sessionStorage
                    sessionStorage.setItem('scrollPosition', window.pageYOffset);

                    // Add a hash to the URL to identify the users table section
                    const url = new URL(this.href);
                    url.hash = 'users-table';

                    // Navigate to the modified URL
                    window.location.href = url.toString();
                });
            });

            // Restore scroll position after page load if we're coming back from pagination
            if (window.location.hash === '#users-table' && sessionStorage.getItem('scrollPosition')) {
                window.scrollTo(0, parseInt(sessionStorage.getItem('scrollPosition')));
            }
        });
    </script>
</body>
</html>
