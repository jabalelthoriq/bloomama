<!-- resources/views/users.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1050;
    justify-content: center;
    align-items: center;
}

.modal-container {
    background-color: white;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 20px;
    animation: modalFadeIn 0.3s;
}

@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6c757d;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    gap: 10px;
}

.tab-content .table-container {
            transition: opacity 0.3s ease;
        }

        .tab-content .table-loading {
            opacity: 0.5;
        }

        /* Pagination styling */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-item .page-link {
            color: #00b8d4;
            border: 1px solid #dee2e6;
            margin: 0 2px;
            border-radius: 4px;
        }

        .pagination .page-item.active .page-link {
            background-color: #00b8d4;
            border-color: #00b8d4;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
        }

        /* Loading spinner */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 10px;
        }

        .loading-spinner.active {
            display: block;
        }

        /* Health Tracking Modal Styles */
.vital-stats-card {
    border-radius: 10px;
    border-left: 4px solid #00b8d4;
    transition: transform 0.2s;
    height: 100%;
}

.vital-stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 184, 212, 0.2);
}

.health-stat-value {
    font-size: 1.8rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.health-stat-label {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 3px;
}

.health-stat-unit {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

#healthTrackingTable tbody tr {
    cursor: pointer;
    transition: background-color 0.2s;
}

#healthTrackingTable tbody tr:hover {
    background-color: rgba(0, 184, 212, 0.05);
}

/* Timeline style for health tracking */
.health-timeline {
    position: relative;
    padding-left: 30px;
    margin-top: 20px;
}

.health-timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #00b8d4;
}

.health-timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.health-timeline-item::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #00b8d4;
    border: 2px solid white;
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

/* Appointment button style */
.appointment-btn {
    color: #17a2b8;
    border-color: #17a2b8;
}

.appointment-btn:hover {
    color: white;
    background-color: #17a2b8;
}

/* Modal input styles */
.modal-container input[type="datetime-local"],
.modal-container select,
.modal-container textarea {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 10px 15px;
}

.modal-container input[type="datetime-local"]:focus,
.modal-container select:focus,
.modal-container textarea:focus {
    border-color: #00b8d4;
    box-shadow: 0 0 0 0.25rem rgba(0, 184, 212, 0.25);
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
                    <div class="search-container" style="width: 250px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchBidan" placeholder="Cari bidan...">
                    </div>
                </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive table-container" id="bidan-table-container">
                        <table class="table table-hover mb-0" id="bidanTable">
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
                    <div class="pagination-container">
                        <nav aria-label="Page navigation for midwives">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $midwives->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link"
                                       href="{{ $midwives->appends(['user_page' => request('user_page', 1)])->previousPageUrl() }}#bidan-content"
                                       aria-label="Previous"
                                       onclick="handlePagination(event, this, 'bidan')">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @foreach($midwives->getUrlRange(1, $midwives->lastPage()) as $page => $url)
                                    <li class="page-item {{ $midwives->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link"
                                           href="{{ $url }}#bidan-content"
                                           onclick="handlePagination(event, this, 'bidan')">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                <li class="page-item {{ $midwives->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link"
                                       href="{{ $midwives->appends(['user_page' => request('user_page', 1)])->nextPageUrl() }}#bidan-content"
                                       aria-label="Next"
                                       onclick="handlePagination(event, this, 'bidan')">
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
                    <div class="search-container" style="width: 250px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchPasien" placeholder="Cari pasien...">
                    </div>
                </div>

                    @if(session('user_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('user_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive table-container" id="pasien-table-container">
                        <table class="table table-hover mb-0" id="pasienTable">
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
                <div class="pagination-container">
                    <nav aria-label="Page navigation for users">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link"
                                   href="{{ $users->appends(['midwife_page' => request('midwife_page', 1)])->previousPageUrl() }}#pasien-content"
                                   aria-label="Previous"
                                   onclick="handlePagination(event, this, 'pasien')">
                                    <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                </a>
                            </li>

                            {{-- Pagination Elements --}}
                            @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link"
                                       href="{{ $url }}#pasien-content"
                                       onclick="handlePagination(event, this, 'pasien')">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            {{-- Next Page Link --}}
                            <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link"
                                   href="{{ $users->appends(['midwife_page' => request('midwife_page', 1)])->nextPageUrl() }}#pasien-content"
                                   aria-label="Next"
                                   onclick="handlePagination(event, this, 'pasien')">
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
                    <div class="search-container" style="width: 250px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchPregnancy" placeholder="Cari kehamilan...">
                    </div>
                </div>

                    @if(session('pregnancy_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('pregnancy_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive table-container" id="pregnancies-table-container">
                        <table class="table table-hover mb-0" id="pregnanciesTable">
                            <thead>
                                <tr>
                                    <th>Pasien</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Minggu Kehamilan</th>
                                    <th>Tanggal Cek Terakhir</th>
                                    <th class="text-center" colspan="4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userPregnancies as $userPregnancy)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary">{{ substr($userPregnancy->user->name ?? '??', 0, 2) }}</div>
                                                <span class="ms-2">{{ $userPregnancy->user->name ?? 'Unknown User' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $userPregnancy->start_date ? date('d M Y', strtotime($userPregnancy->start_date)) : '-' }}</td>
                                        <td>{{ $userPregnancy->pregnancy_week ?? '-' }}</td>
                                        <td>{{ $userPregnancy->last_check_date ? date('d M Y', strtotime($userPregnancy->last_check_date)) : '-' }}</td>

                                        <td>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" class="btn btn-sm btn-outline-warning ms-1 view-pregnancy-btn"
                                                    data-patient="{{ $userPregnancy->user->name ?? 'Unknown User' }}"
                                                    data-gravida="{{ $userPregnancy->gravida ?? '-' }}"
                                                    data-para="{{ $userPregnancy->para ?? '-' }}"
                                                    data-abortus="{{ $userPregnancy->abortus ?? '-' }}"
                                                    data-start-date="{{ $userPregnancy->start_date ? date('d M Y', strtotime($userPregnancy->start_date)) : '-' }}"
                                                    data-due-date="{{ $userPregnancy->due_date ? date('d M Y', strtotime($userPregnancy->due_date)) : '-' }}"
                                                    data-pregnancy-week="{{ $userPregnancy->pregnancy_week ?? '-' }}"
                                                    data-last-check="{{ $userPregnancy->last_check_date ? date('d M Y', strtotime($userPregnancy->last_check_date)) : '-' }}"
                                                    data-notes="{{ $userPregnancy->notes ?? '-' }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary ms-1 edit-pregnancy-btn"
                                                        data-id="{{ $userPregnancy->id }}"
                                                        data-patient-id="{{ $userPregnancy->user_id ?? '' }}"
                                                        data-patient-name="{{ $userPregnancy->user->name ?? 'Unknown User' }}"
                                                        data-gravida="{{ $userPregnancy->gravida ?? '0' }}"
                                                        data-para="{{ $userPregnancy->para ?? '0' }}"
                                                        data-abortus="{{ $userPregnancy->abortus ?? '0' }}"
                                                        data-start-date="{{ $userPregnancy->start_date ?? '' }}"
                                                        data-due-date="{{ $userPregnancy->due_date ?? '' }}"
                                                        data-pregnancy-week="{{ $userPregnancy->pregnancy_week ?? '' }}"
                                                        data-last-check="{{ $userPregnancy->last_check_date ?? '' }}"
                                                        data-notes="{{ $userPregnancy->notes ?? '' }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-outline-success ms-1 health-tracking-btn"
                                                        data-id="{{ $userPregnancy->id }}" data-user-id="{{ $userPregnancy->user_id }}" title="Health Tracking">
                                                        <i class="fas fa-heartbeat"></i>
                                                    </button>
                                                    <!-- In the pregnancies table actions column, after the health tracking button -->
                                                    <button type="button" class="btn btn-sm btn-outline-info ms-1 appointment-btn"
                                                        data-id="{{ $userPregnancy->id }}"
                                                        data-user-id="{{ $userPregnancy->user_id }}"
                                                        data-patient-name="{{ $userPregnancy->user->name ?? 'Unknown User' }}"
                                                        title="Appointment">
                                                        <i class="fas fa-calendar-check"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary ms-1 live-chat-btn"
                                                        data-id="{{ $userPregnancy->id }}" title="Live Chat">
                                                        <i class="fas fa-comment-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data kehamilan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination for User Pregnancies -->
                    @if($userPregnancies->hasPages())
                    <div class="pagination-container">
                        <nav aria-label="Page navigation for pregnancies">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $userPregnancies->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link"
                                       href="{{ $userPregnancies->previousPageUrl() }}#pregnancies-content"
                                       aria-label="Previous"
                                       onclick="handlePagination(event, this, 'pregnancies')">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @foreach($userPregnancies->getUrlRange(1, $userPregnancies->lastPage()) as $page => $url)
                                    <li class="page-item {{ $userPregnancies->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link"
                                           href="{{ $url }}#pregnancies-content"
                                           onclick="handlePagination(event, this, 'pregnancies')">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                <li class="page-item {{ $userPregnancies->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link"
                                       href="{{ $userPregnancies->nextPageUrl() }}#pregnancies-content"
                                       aria-label="Next"
                                       onclick="handlePagination(event, this, 'pregnancies')">
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

<!-- Health Tracking Modal -->
<div class="modal-overlay" id="healthTrackingModal">
    <div class="modal-container" style="max-width: 800px;">
        <div class="modal-header">
            <h5 class="fw-bold m-0">Health Tracking</h5>
            <button class="close-modal" id="closeHealthTrackingModalBtn">
                <i class="fas fa-times"></i>
            </button>

        </div>
        <div class="modal-body">
            <!-- Header Info -->
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h6 class="text-muted">Pasien</h6>
                    <h5 id="htPatientName">-</h5>
                </div>
                <div>
                    <h6 class="text-muted">Minggu Kehamilan</h6>
                    <h5 id="htPregnancyWeek">-</h5>
                </div>
                <div>
                    <h6 class="text-muted">Tanggal Terakhir Diperbarui</h6>
                    <h5 id="htLastUpdated">-</h5>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card vital-stats-card">
                        <div class="card-body text-center">
                            <div class="health-stat-value" id="htWeight">-</div>
                            <div class="health-stat-label">Berat Badan</div>
                            <div class="health-stat-unit">kg</div>
                            <small class="text-muted" id="htWeightDate"></small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card vital-stats-card">
                        <div class="card-body text-center">
                            <div class="health-stat-value" id="htBloodPressure">-</div>
                            <div class="health-stat-label">Tekanan Darah</div>
                            <div class="health-stat-unit">mmHg</div>
                            <small class="text-muted" id="htBloodPressureDate"></small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card vital-stats-card">
                        <div class="card-body text-center">
                            <div class="health-stat-value" id="htHeartRate">-</div>
                            <div class="health-stat-label">Denyut Jantung</div>
                            <div class="health-stat-unit">bpm</div>
                            <small class="text-muted" id="htHeartRateDate"></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <h6 class="text-muted mb-3">Catatan Kesehatan</h6>
                <div class="card">
                    <div class="card-body">
                        <p id="htNotes" class="mb-0">-</p>
                    </div>
                </div>
            </div>

            <!-- History -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="m-0">Riwayat Pemeriksaan</h6>
                <button class="btn btn-sm btn-primary" id="addNewTrackingBtn">
                    <i class="fas fa-plus me-1"></i> Tambah Data
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="healthTrackingTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Berat (kg)</th>
                            <th>Tekanan Darah</th>
                            <th>Denyut Jantung</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="healthTrackingTableBody">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeHealthTrackingBtn">Tutup</button>
        </div>
    </div>
</div>

<!-- Add/Edit Health Tracking Form Modal -->
<div class="modal-overlay" id="healthTrackingFormModal">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="fw-bold m-0" id="healthTrackingFormTitle">Tambah Data Health Tracking</h5>
            <button class="close-modal" id="closeHealthTrackingFormModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="healthTrackingForm">
                @csrf
                <input type="hidden" id="htFormTrackingId" name="tracking_id">
                <input type="hidden" id="htFormPregnancyId" name="pregnancy_id">

                <div class="mb-3">
                    <label for="htFormDateRecorded" class="form-label">Tanggal Pencatatan*</label>
                    <input type="date" class="form-control" id="htFormDateRecorded" name="date_recorded" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="htFormWeight" class="form-label">Berat Badan (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="htFormWeight" name="weight" placeholder="50.5">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="htFormBloodPressure" class="form-label">Tekanan Darah</label>
                        <input type="text" class="form-control" id="htFormBloodPressure" name="blood_pressure" placeholder="120/80">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="htFormHeartRate" class="form-label">Denyut Jantung (bpm)</label>
                        <input type="number" class="form-control" id="htFormHeartRate" name="heart_rate" placeholder="72">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="htFormNotes" class="form-label">Catatan</label>
                    <textarea class="form-control" id="htFormNotes" name="notes" rows="3" placeholder="Masukkan catatan kesehatan..."></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelHealthTrackingFormBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="submitHealthTrackingFormBtn">Simpan</button>
        </div>
    </div>
</div>

<!-- View Pregnancy Details Modal -->
<div class="modal-overlay" id="viewPregnancyModal">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="fw-bold m-0">Detail Kehamilan</h5>
            <button class="close-modal" id="closeViewModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Pasien</label>
                <p id="viewPatientName" class="form-control-static"></p>
            </div>
            <div class="mb-3" >
                <label class="form-label fw-bold" >GPA</label>
                <div style="display: flex;">
                    <p id="G" class="form-control-static"></p>/
                    <p id="P" class="form-control-static"></p>/
                    <p id="A" class="form-control-static"></p>
                  </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Mulai</label>
                <p id="viewStartDate" class="form-control-static"></p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Berakhir</label>
                <p id="viewDuetDate" class="form-control-static"></p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Minggu Kehamilan</label>
                <p id="viewPregnancyWeek" class="form-control-static"></p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Cek Terakhir</label>
                <p id="viewLastCheckDate" class="form-control-static"></p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Catatan</label>
                <p id="viewNotes" class="form-control-static"></p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeViewBtn">Tutup</button>
        </div>
    </div>
</div>

<!-- Edit Pregnancy Modal -->
<div class="modal-overlay" id="editPregnancyModal">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="fw-bold m-0">Edit Data Kehamilan</h5>
            <button class="close-modal" id="closeEditPregnancyModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="editPregnancyForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editPregnancyId" name="pregnancy_id">

                <div class="mb-3">
                    <label class="form-label fw-bold">Pasien</label>
                    <p id="editPatientName" class="form-control-static"></p>
                    <input type="hidden" id="editPregnancyPatient" name="user_id">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Gravida (G)</label>
                        <input type="number" class="form-control" id="editGravida" name="gravida" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Para (P)</label>
                        <input type="number" class="form-control" id="editPara" name="para" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Abortus (A)</label>
                        <input type="number" class="form-control" id="editAbortus" name="abortus" min="0" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="editStartDate" name="start_date" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Berakhir</label>
                        <input type="date" class="form-control" id="editDueDate" name="due_date">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Minggu Kehamilan</label>
                        <input type="number" class="form-control" id="editPregnancyWeek" name="pregnancy_week" min="1" max="42" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Cek Terakhir</label>
                        <input type="date" class="form-control" id="editLastCheckDate" name="last_check_date">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan</label>
                    <textarea class="form-control" id="editNotes" name="notes" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelEditPregnancyBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="updatePregnancyBtn">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- Appointment Modal -->
<div class="modal-overlay" id="appointmentModal">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="fw-bold m-0">Buat Janji Temu</h5>
            <button class="close-modal" id="closeAppointmentModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="appointmentForm">
                @csrf
                <input type="hidden" id="appointmentPregnancyId" name="pregnancy_id">
                <input type="hidden" id="appointmentUserId" name="user_id">

                <div class="mb-3">
                    <label class="form-label fw-bold">Pasien</label>
                    <p id="appointmentPatientName" class="form-control-static"></p>
                </div>

                <div class="mb-3">
                    <label for="appointmentDateTime" class="form-label fw-bold">Tanggal & Waktu*</label>
                    <input type="datetime-local" class="form-control" id="appointmentDateTime" name="date_time" required>
                </div>
{{--
                <div class="mb-3">
                    <label for="appointmentMidwife" class="form-label">Bidan*</label>
                    <select class="form-select" id="appointmentMidwife" name="midwife_id" required>
                        <option value="">Pilih Bidan</option>
                        @foreach($midwives as $midwife)
                            <option value="{{ $midwife->id }}">{{ $midwife->name }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="mb-3">
                    <label for="appointmentNotes" class="form-label fw-bold">Catatan</label>
                    <textarea class="form-control" id="appointmentNotes" name="notes" rows="3" placeholder="Masukkan catatan janji temu..."></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelAppointmentBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="submitAppointmentBtn">Simpan Janji</button>
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
    // View Pregnancy Modal
    const viewModal = document.getElementById('viewPregnancyModal');
    const closeViewModalBtn = document.getElementById('closeViewModalBtn');
    const closeViewBtn = document.getElementById('closeViewBtn');

    // Open view modal
    document.querySelectorAll('.view-pregnancy-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Get data from button attributes
        document.getElementById('viewPatientName').textContent = this.dataset.patient;
        document.getElementById('G').textContent = this.dataset.gravida;
        document.getElementById('P').textContent = this.dataset.para;
        document.getElementById('A').textContent = this.dataset.abortus;
        document.getElementById('viewStartDate').textContent = this.dataset.startDate;
        document.getElementById('viewDuetDate').textContent = this.dataset.dueDate;
        document.getElementById('viewPregnancyWeek').textContent = this.dataset.pregnancyWeek;
        document.getElementById('viewLastCheckDate').textContent = this.dataset.lastCheck;
        document.getElementById('viewNotes').textContent = this.dataset.notes;

        // Show modal
        viewModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
});

    // Close view modal
    function closeViewModal() {
        viewModal.style.display = 'none';
        document.body.style.overflow = '';
    }
    closeViewModalBtn.addEventListener('click', closeViewModal);
    closeViewBtn.addEventListener('click', closeViewModal);
    viewModal.addEventListener('click', function(e) {
        if (e.target === viewModal) closeViewModal();
    });
});


    // Edit Pregnancy Modal
    const editPregnancyModal = document.getElementById('editPregnancyModal');
    const closeEditPregnancyModalBtn = document.getElementById('closeEditPregnancyModalBtn');
    const cancelEditPregnancyBtn = document.getElementById('cancelEditPregnancyBtn');
    const updatePregnancyBtn = document.getElementById('updatePregnancyBtn');
    const editPregnancyForm = document.getElementById('editPregnancyForm');

   // Open edit modal
document.querySelectorAll('.edit-pregnancy-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Set form action with the correct route
       const pregnancyId = this.dataset.id;
        editPregnancyForm.action = `/api/pregnancies/${pregnancyId}`;


        // Set hidden pregnancy ID
        document.getElementById('editPregnancyId').value = pregnancyId;

        // Set patient info
        document.getElementById('editPatientName').textContent = this.dataset.patientName;
        document.getElementById('editPregnancyPatient').value = this.dataset.patientId;

        // Set GPA fields
        document.getElementById('editGravida').value = this.dataset.gravida;
        document.getElementById('editPara').value = this.dataset.para;
        document.getElementById('editAbortus').value = this.dataset.abortus;

        // Format dates for input fields
        const formatDateForInput = (dateString) => {
            if (!dateString || dateString === '-') return '';
            const date = new Date(dateString);
            return date.toISOString().split('T')[0];
        };

        // Set date fields
        document.getElementById('editStartDate').value = formatDateForInput(this.dataset.startDate);
        document.getElementById('editDueDate').value = formatDateForInput(this.dataset.dueDate);
        document.getElementById('editLastCheckDate').value = formatDateForInput(this.dataset.lastCheck);

        // Set other fields
        document.getElementById('editPregnancyWeek').value = this.dataset.pregnancyWeek || '';
        document.getElementById('editNotes').value = this.dataset.notes || '';

        // Show modal
        editPregnancyModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
});

// Handle form submission
document.getElementById('updatePregnancyBtn').addEventListener('click', async function() {
    const form = document.getElementById('editPregnancyForm');
    const formData = new FormData(form);
    const submitBtn = this;

    // Disable button during submission
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    try {
        const response = await fetch(form.action, {
            method: 'PUT', // Laravel will handle PUT via method spoofing
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        if (response.redirected) {
            // Handle redirect response (non-AJAX)
            window.location.href = response.url;
            return;
        }

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Terjadi kesalahan');
        }

        // Show success message and reload
        alert('Data berhasil diperbarui');
        window.location.reload();

    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Gagal memperbarui data');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Simpan Perubahan';
    }
});

// Close modal handlers
document.getElementById('closeEditPregnancyModalBtn').addEventListener('click', function() {
    editPregnancyModal.style.display = 'none';
    document.body.style.overflow = 'auto';
});

document.getElementById('cancelEditPregnancyBtn').addEventListener('click', function() {
    editPregnancyModal.style.display = 'none';
    document.body.style.overflow = 'auto';
});
    </script>
    <script>
        // Global function to handle pagination
        function handlePagination(event, element, tabType) {
            event.preventDefault();

            // Show loading state
            const container = document.getElementById(`${tabType}-table-container`);
            container.classList.add('table-loading');

            // Get the URL and tab to activate
            const url = element.getAttribute('href').split('#')[0];

            // Store current scroll position
            const scrollPosition = window.scrollY;

            // Fetch the new page
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Create a temporary DOM element to parse the response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extract the table content
                const newContent = doc.querySelector(`#${tabType}-content`).innerHTML;

                // Update the content
                document.getElementById(`${tabType}-content`).innerHTML = newContent;

                // Reinitialize event listeners for the new content
                initializeEventListeners();

                // Remove loading state
                container.classList.remove('table-loading');

                // Activate the correct tab
                document.getElementById(`${tabType}-tab`).click();

                // Restore scroll position
                window.scrollTo(0, scrollPosition);

                // Update browser history
                history.pushState(null, null, url + `#${tabType}-content`);
            })
            .catch(error => {
                console.error('Error:', error);
                container.classList.remove('table-loading');
                window.location.href = url + `#${tabType}-content`;
            });
        }

        // Function to initialize all event listeners
        function initializeEventListeners() {
            // Reinitialize all buttons and event listeners
            // (include all your existing button initialization code here)

            // Reinitialize pagination click handlers
            document.querySelectorAll('.page-link').forEach(link => {
                const href = link.getAttribute('href');
                if (href.includes('#bidan-content')) {
                    link.onclick = (e) => handlePagination(e, link, 'bidan');
                } else if (href.includes('#pasien-content')) {
                    link.onclick = (e) => handlePagination(e, link, 'pasien');
                } else if (href.includes('#pregnancies-content')) {
                    link.onclick = (e) => handlePagination(e, link, 'pregnancies');
                }
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL hash on page load
            if (window.location.hash) {
                const tabId = window.location.hash.substring(1);
                if (tabId === 'pasien-content') {
                    document.getElementById('pasien-tab').click();
                } else if (tabId === 'pregnancies-content') {
                    document.getElementById('pregnancies-tab').click();
                }
            }

            // Initialize all event listeners
            initializeEventListeners();
        });

        // Handle back/forward navigation
        window.addEventListener('popstate', function() {
            if (window.location.hash) {
                const tabId = window.location.hash.substring(1);
                if (tabId === 'pasien-content') {
                    document.getElementById('pasien-tab').click();
                } else if (tabId === 'pregnancies-content') {
                    document.getElementById('pregnancies-tab').click();
                } else {
                    document.getElementById('bidan-tab').click();
                }
            }
        });


    </script>
    <script>
     // Health Tracking Modal
const healthTrackingModal = document.getElementById('healthTrackingModal');
const closeHealthTrackingModalBtn = document.getElementById('closeHealthTrackingModalBtn');
const closeHealthTrackingBtn = document.getElementById('closeHealthTrackingBtn');
const healthTrackingFormModal = document.getElementById('healthTrackingFormModal');
const closeHealthTrackingFormModalBtn = document.getElementById('closeHealthTrackingFormModalBtn');
const cancelHealthTrackingFormBtn = document.getElementById('cancelHealthTrackingFormBtn');
const submitHealthTrackingFormBtn = document.getElementById('submitHealthTrackingFormBtn');
const addNewTrackingBtn = document.getElementById('addNewTrackingBtn');
const healthTrackingForm = document.getElementById('healthTrackingForm');
const healthTrackingTableBody = document.getElementById('healthTrackingTableBody');

let currentPregnancyId = null;
let currentTrackingData = [];

// Open health tracking modal
document.querySelectorAll('.health-tracking-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        currentPregnancyId = this.dataset.id;
        currentUserId = this.dataset.userId; // Get user ID from data attribute

        // Set patient info in modal
        const row = this.closest('tr');
        const patientName = row.querySelector('td:first-child span').textContent;
        const pregnancyWeek = row.querySelector('td:nth-child(3)').textContent;

        document.getElementById('htPatientName').textContent = patientName;
        document.getElementById('htPregnancyWeek').textContent = pregnancyWeek;

        // Load data
        loadHealthTrackingData(currentPregnancyId, currentUserId);

        // Show modal
        healthTrackingModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
});

// Load health tracking data from API
function loadHealthTrackingData(pregnancyId, userId) {
    // Show loading state
    healthTrackingTableBody.innerHTML = '<tr><td colspan="5">Memuat data...</td></tr>';

    // Build URL with user_id parameter if available
    let url = `/api/health-tracking/${pregnancyId}`;
    if (userId) {
        url += `${userId}`;
    }

    console.log('Fetching health tracking data from URL:', url);

    fetch(url)
        .then(response => {
    console.log('HTTP status code:', response.status);
    if (!response.ok) {
        throw new Error(`Network response was not ok (status: ${response.status})`);
    }
    return response.json();
})

        .then(data => {
            console.log('Data received from server:', data);

            if (data.success && data.data) {
                currentTrackingData = data.data.trackings || [];
                console.log('Tracking data:', currentTrackingData);

                renderHealthTrackingTable(currentTrackingData);

                // Update patient info
                document.getElementById('htPatientName').textContent = data.data.patient_name;
                document.getElementById('htPregnancyWeek').textContent = data.data.pregnancy_week;

                // Update last updated date
                document.getElementById('htLastUpdated').textContent =
                    data.data.last_updated ? formatDate(data.data.last_updated) : '-';

                // Show latest data in cards
                if (data.data.latest_stats) {
                    console.log('Latest stats:', data.data.latest_stats);

                    showTrackingDetails({
                        weight: data.data.latest_stats.weight,
                        blood_pressure: data.data.latest_stats.blood_pressure,
                        heart_rate: data.data.latest_stats.heart_rate,
                        notes: data.data.latest_stats.notes || 'Tidak ada catatan',
                        date_recorded: data.data.last_updated
                    });
                } else {
                    console.warn('Tidak ada data latest_stats yang ditemukan.');
                    showTrackingDetails({
                        weight: null,
                        blood_pressure: null,
                        heart_rate: null,
                        notes: 'Tidak ada data kesehatan',
                        date_recorded: null
                    });
                }
            } else {
                console.warn('Data tidak valid atau response success = false:', data);
                throw new Error(data.message || 'Invalid data format');
            }
        })
        .catch(error => {
            console.error('Error loading health tracking data:', error);
            healthTrackingTableBody.innerHTML = `<tr><td colspan="5">Gagal memuat data: ${error.message}</td></tr>`;

            // Show error in cards
            showTrackingDetails({
                weight: null,
                blood_pressure: null,
                heart_rate: null,
                notes: 'Gagal memuat data kesehatan',
                date_recorded: null
            });
        });
}


// Render health tracking table with updated field names
function renderHealthTrackingTable(data) {
    if (data.length === 0) {
        healthTrackingTableBody.innerHTML = '<tr><td colspan="5">Tidak ada data kesehatan</td></tr>';
        return;
    }

    healthTrackingTableBody.innerHTML = data.map(tracking => `
        <tr>
            <td>${formatDate(tracking.date_recorded)}</td>
            <td>${tracking.weight || '-'}</td>
            <td>${tracking.blood_pressure || '-'}</td>
            <td>${tracking.heart_rate || '-'}</td>
            <td class="text-end">
                <button class="btn btn-sm btn-outline-primary edit-tracking-btn" data-id="${tracking.tracking_id}">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger delete-tracking-btn" data-id="${tracking.tracking_id}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');

    // Add event listeners to buttons in the table
    addHealthTrackingTableEventListeners();
}

// Show tracking details in cards
function showTrackingDetails(tracking) {
    if (!tracking) {
        tracking = {
            weight: null,
            blood_pressure: null,
            heart_rate: null,
            notes: 'Tidak ada data',
            date_recorded: null
        };
    }

    // Weight card
    const weight = tracking.weight !== null && tracking.weight !== undefined ? tracking.weight : '-';
    document.getElementById('htWeight').textContent = weight;
    document.getElementById('htWeightDate').textContent = tracking.date_recorded ? formatDate(tracking.date_recorded) : '';

    // Blood pressure card
    const bloodPressure = tracking.blood_pressure || '-';
    document.getElementById('htBloodPressure').textContent = bloodPressure;
    document.getElementById('htBloodPressureDate').textContent = tracking.date_recorded ? formatDate(tracking.date_recorded) : '';

    // Heart rate card
    const heartRate = tracking.heart_rate || '-';
    document.getElementById('htHeartRate').textContent = heartRate;
    document.getElementById('htHeartRateDate').textContent = tracking.date_recorded ? formatDate(tracking.date_recorded) : '';

    // Notes
    document.getElementById('htNotes').textContent = tracking.notes || 'Tidak ada catatan';
}

// Open form modal for adding/editing
function openHealthTrackingFormModal(tracking = null) {
    document.getElementById('healthTrackingFormTitle').textContent = tracking ? 'Edit Data Kesehatan' : 'Tambah Data Kesehatan';
    document.getElementById('htFormPregnancyId').value = currentPregnancyId;

    // Add user_id to the form
    if (!document.getElementById('htFormUserId')) {
        const userIdInput = document.createElement('input');
        userIdInput.type = 'hidden';
        userIdInput.id = 'htFormUserId';
        userIdInput.name = 'user_id';
        healthTrackingForm.appendChild(userIdInput);
    }
    document.getElementById('htFormUserId').value = currentUserId;

    if (tracking) {
        document.getElementById('htFormTrackingId').value = tracking.tracking_id;
        document.getElementById('htFormDateRecorded').value = tracking.date_recorded.split('T')[0]; // Format date for input
        document.getElementById('htFormWeight').value = tracking.weight || '';
        document.getElementById('htFormBloodPressure').value = tracking.blood_pressure || '';
        document.getElementById('htFormHeartRate').value = tracking.heart_rate || '';
        document.getElementById('htFormNotes').value = tracking.notes || '';
    } else {
        document.getElementById('htFormTrackingId').value = '';
        document.getElementById('htFormDateRecorded').value = new Date().toISOString().split('T')[0]; // Today's date
        document.getElementById('htFormWeight').value = '';
        document.getElementById('htFormBloodPressure').value = '';
        document.getElementById('htFormHeartRate').value = '';
        document.getElementById('htFormNotes').value = '';
    }

    healthTrackingFormModal.style.display = 'flex';
}

// Submit health tracking form (always using POST)
function submitHealthTrackingForm() {
    const formData = new FormData(healthTrackingForm);
    const trackingId = document.getElementById('htFormTrackingId').value;
    const pregnancyId = document.getElementById('htFormPregnancyId').value;

    // Always use POST, route includes pregnancyId
    const url = `/api/health-tracking/Store/${pregnancyId}`;

    // Include tracking_id in form data if editing
    if (trackingId) {
        formData.append('_method', 'PUT'); // Laravel's way to simulate PUT with POST
        formData.append('tracking_id', trackingId);
    }

    fetch(url, {
        method: 'POST', // Always POST
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data kesehatan berhasil disimpan'
            });
            closeHealthTrackingFormModal();
            loadHealthTrackingData(currentPregnancyId, currentUserId);
        } else {
            throw new Error(data.message || 'Failed to save data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal menyimpan',
            text: error.message || 'Terjadi kesalahan saat menyimpan data kesehatan'
        });
    });
}

// Confirm delete tracking
function confirmDeleteTracking(trackingId) {
    Swal.fire({
        title: 'Hapus Data Kesehatan?',
        text: "Anda tidak akan dapat mengembalikan data ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/api/health-tracking/${trackingId}?user_id=${currentUserId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Terhapus!',
                        'Data kesehatan telah dihapus.',
                        'success'
                    );
                    loadHealthTrackingData(currentPregnancyId, currentUserId);
                } else {
                    throw new Error(data.message || 'Failed to delete');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menghapus',
                    text: 'Terjadi kesalahan saat menghapus data kesehatan'
                });
            });
        }
    });
}

// Format date to DD MMM YYYY
function formatDate(dateString) {
    if (!dateString) return '';

    const date = new Date(dateString);
    if (isNaN(date.getTime())) return dateString;

    const options = { day: '2-digit', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('id-ID', options);
}

// Event listeners for buttons in the table
function addHealthTrackingTableEventListeners() {
    // Edit buttons
    document.querySelectorAll('.edit-tracking-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const trackingId = this.dataset.id;
            const tracking = currentTrackingData.find(t => t.tracking_id == trackingId);
            openHealthTrackingFormModal(tracking);
        });
    });

    // Delete buttons
    document.querySelectorAll('.delete-tracking-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const trackingId = this.dataset.id;
            confirmDeleteTracking(trackingId);
        });
    });

    // Row click to view details
    document.querySelectorAll('#healthTrackingTable tbody tr').forEach(row => {
        row.addEventListener('click', function() {
            const trackingId = this.querySelector('.edit-tracking-btn')?.dataset.id;
            if (trackingId) {
                const tracking = currentTrackingData.find(t => t.tracking_id == trackingId);
                showTrackingDetails(tracking);
            }
        });
    });
}

// Modal close functions
function closeHealthTrackingModal() {
    healthTrackingModal.style.display = 'none';
    document.body.style.overflow = '';
}

function closeHealthTrackingFormModal() {
    healthTrackingFormModal.style.display = 'none';
}

// Event listeners for modal buttons
closeHealthTrackingModalBtn.addEventListener('click', closeHealthTrackingModal);
closeHealthTrackingBtn.addEventListener('click', closeHealthTrackingModal);
healthTrackingModal.addEventListener('click', function(e) {
    if (e.target === healthTrackingModal) closeHealthTrackingModal();
});

closeHealthTrackingFormModalBtn.addEventListener('click', closeHealthTrackingFormModal);
cancelHealthTrackingFormBtn.addEventListener('click', closeHealthTrackingFormModal);
healthTrackingFormModal.addEventListener('click', function(e) {
    if (e.target === healthTrackingFormModal) closeHealthTrackingFormModal();
});

addNewTrackingBtn.addEventListener('click', function() {
    openHealthTrackingFormModal();
});

submitHealthTrackingFormBtn.addEventListener('click', submitHealthTrackingForm);





document.addEventListener('DOMContentLoaded', function() {
    // Search functionality for Bidan table
    const searchBidan = document.getElementById('searchBidan');
    if (searchBidan) {
        searchBidan.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#bidanTable tbody tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                const phone = row.cells[2].textContent.toLowerCase();
                const status = row.cells[3].textContent.toLowerCase();

                if (name.includes(searchTerm) ||
                    email.includes(searchTerm) ||
                    phone.includes(searchTerm) ||
                    status.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Search functionality for Pasien table
    const searchPasien = document.getElementById('searchPasien');
    if (searchPasien) {
        searchPasien.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#pasienTable tbody tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                const phone = row.cells[2].textContent.toLowerCase();
                const address = row.cells[3].textContent.toLowerCase();

                if (name.includes(searchTerm) ||
                    email.includes(searchTerm) ||
                    phone.includes(searchTerm) ||
                    address.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Search functionality for Pregnancies table
    const searchPregnancy = document.getElementById('searchPregnancy');
    if (searchPregnancy) {
        searchPregnancy.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#pregnanciesTable tbody tr');

            rows.forEach(row => {
                const patient = row.cells[0].textContent.toLowerCase();
                const startDate = row.cells[1].textContent.toLowerCase();
                const pregnancyWeek = row.cells[2].textContent.toLowerCase();
                const lastCheck = row.cells[3].textContent.toLowerCase();

                if (patient.includes(searchTerm) ||
                    startDate.includes(searchTerm) ||
                    pregnancyWeek.includes(searchTerm) ||
                    lastCheck.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});

// Appointment Modal
const appointmentModal = document.getElementById('appointmentModal');
const closeAppointmentModalBtn = document.getElementById('closeAppointmentModalBtn');
const cancelAppointmentBtn = document.getElementById('cancelAppointmentBtn');
const submitAppointmentBtn = document.getElementById('submitAppointmentBtn');
const appointmentForm = document.getElementById('appointmentForm');

// Open appointment modal
document.querySelectorAll('.appointment-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const pregnancyId = this.dataset.id;
        const userId = this.dataset.userId;
        const patientName = this.dataset.patientName;

        // Set form values
        document.getElementById('appointmentPregnancyId').value = pregnancyId;
        document.getElementById('appointmentUserId').value = userId;
        document.getElementById('appointmentPatientName').textContent = patientName;

        // Set default date/time (next hour)
        const now = new Date();
        now.setHours(now.getHours() + 1);
        now.setMinutes(0);
        now.setSeconds(0);
        document.getElementById('appointmentDateTime').value = now.toISOString().slice(0, 16);

        // Show modal
        appointmentModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
});

// Close appointment modal
function closeAppointmentModal() {
    appointmentModal.style.display = 'none';
    document.body.style.overflow = '';
}

closeAppointmentModalBtn.addEventListener('click', closeAppointmentModal);
cancelAppointmentBtn.addEventListener('click', closeAppointmentModal);
appointmentModal.addEventListener('click', function(e) {
    if (e.target === appointmentModal) closeAppointmentModal();
});

// Submit appointment form
submitAppointmentBtn.addEventListener('click', function() {
    const formData = new FormData(appointmentForm);

    // Disable button during submission
    submitAppointmentBtn.disabled = true;
    submitAppointmentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    fetch('/appointments', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Janji temu berhasil dibuat'
            });
            closeAppointmentModal();
        } else {
            throw new Error(data.message || 'Failed to create appointment');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal membuat janji',
            text: error.message || 'Terjadi kesalahan saat membuat janji temu'
        });
    })
    .finally(() => {
        submitAppointmentBtn.disabled = false;
        submitAppointmentBtn.innerHTML = 'Simpan Janji';
    });
});

        </script>
</body>
</html>
