<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
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
        color: #D21F3C;
    }

    .pagination .page-item.active .page-link {
        background-color: #D21F3C;
        border-color: #D21F3C;
        color: white;
    }

    .table-responsive {
        overflow-x: auto;
        transition: opacity 0.3s ease;
    }

    .table-loading {
        opacity: 0.5;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(210, 31, 60, 0.05);
    }

    /* Smooth transition for tab content */
    .tab-content > .tab-pane {
        transition: opacity 0.3s ease;
    }

    .tab-content > .tab-pane:not(.active) {
        display: none;
        opacity: 0;
    }

    .tab-content > .tab-pane.active {
        display: block;
        opacity: 1;
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
        border-bottom: 3px solid #D21F3C;
        color: #D21F3C;
        background-color: transparent;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        border-bottom: 3px solid #f0f0f0;
    }

    .tab-content {
        padding: 20px 0;
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
            overflow-y: auto;
            padding: 20px;
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
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            margin: auto;
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
            flex-shrink: 0;
        }

        .modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex: 1;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            flex-shrink: 0;
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
            gap: 0.5rem;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-add-event:hover {
            background-color: #a00922;
            transform: translateY(-2px);
        }

        .btn-add-event:active {
            transform: translateY(0);
        }

        .header-with-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;

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

        <div class="nav-icon active">
            <a href="menu2">
            <i class="far fa-user"></i>
            </a>
        </div>

        <div class="nav-icon">
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
            <h2 class="fs-3 fw-bold m-0">Users</h2>
        </div>
    <!-- Modal Edit Pasien Form -->
<div class="modal-overlay" id="editPasienModal">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="fw-bold m-0">Edit Pasien</h5>
            <button type="button" class="close-modal" id="closeEditPasienModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <!-- Form tanpa action - akan diatur oleh JavaScript -->
            <form id="editPasienForm" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Method POST untuk rute Laravel -->
                <input type="hidden" name="_method" value="POST">
                <!-- Pastikan ID tersimpan dan terkirim dengan benar -->
                <input type="hidden" id="editPasienId" name="user_id">

                <div class="mb-3">
                    <label for="editPasienName" class="form-label">Nama Pasien</label>
                    <input type="text" class="form-control" id="editPasienName" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="editPasienEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editPasienEmail" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="editPasienPhoneNumber" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="editPasienPhoneNumber" name="phone_number" required>
                </div>

                <div class="mb-3">
                    <label for="editPasienAddress" class="form-label">Alamat</label>
                    <textarea class="form-control" id="editPasienAddress" name="address" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="editPasienPassword" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="editPasienPassword" name="password">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                </div>

                <div class="mb-3">
                    <label for="editPasienPasswordConfirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="editPasienPasswordConfirmation" name="password_confirmation">
                </div>

                <div class="mb-3">
                    <label for="editPasienPhoto" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" id="editPasienPhoto" name="profile_picture" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>

                    <div class="mt-2">
                        <div id="currentPasienPhotoContainer" class="d-none">
                            <p class="mb-1">Foto Saat Ini:</p>
                            <img id="currentPasienPhoto" src="" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                        <div id="editPasienPhotoPreview" class="d-none mt-2">
                            <p class="mb-1">Foto Baru:</p>
                            <img src="" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelEditPasienBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="updatePasienBtn" style="background-color: #0400d4">Update</button>
        </div>
    </div>
</div>

        <!-- Modal Edit Bidan Form - Improved to match pasien form -->
    <div class="modal-overlay" id="editBidanModal">
        <div class="modal-container">
            <div class="modal-header">
                <h5 class="fw-bold m-0">Edit Bidan</h5>
                <button type="button" class="close-modal" id="closeEditBidanModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBidanForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" id="editBidanId" name="midwife_id">

                    <div class="mb-3">
                        <label for="editBidanName" class="form-label">Nama Bidan</label>
                        <input type="text" class="form-control" id="editBidanName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editBidanEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editBidanEmail" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="editBidanPhoneNumber" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="editBidanPhoneNumber" name="phone_number" required>
                    </div>

                    <div class="mb-3">
                        <label for="editBidanStatus" class="form-label">Status</label>
                        <select class="form-control" id="editBidanStatus" name="status" required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editBidanAvailableDay" class="form-label">Hari Kerja</label>
                        <input type="text" class="form-control" id="editBidanAvailableDay" name="available_day">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editBidanStartTime" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="editBidanStartTime" name="start_time">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editBidanEndTime" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="editBidanEndTime" name="end_time">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editBidanPassword" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="editBidanPassword" name="password">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="mb-3">
                        <label for="editBidanPasswordConfirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="editBidanPasswordConfirmation" name="password_confirmation">
                    </div>

                    <div class="mb-3">
                        <label for="editBidanPhoto" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="editBidanPhoto" name="profile_picture" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>

                        <div class="mt-2">
                            <div id="currentBidanPhotoContainer" class="d-none">
                                <p class="mb-1">Foto Saat Ini:</p>
                                <img id="currentBidanPhoto" src="" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            <div id="editBidanPhotoPreview" class="d-none mt-2">
                                <p class="mb-1">Foto Baru:</p>
                                <img src="" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelEditBidanBtn">Batal</button>
                <button type="button" class="btn btn-primary" id="updateBidanBtn" style="background-color: #0400d4">Update</button>
            </div>
        </div>
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
        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="userTabsContent">
            <!-- Bidan Content -->
            <div class="tab-pane fade show active" id="bidan-content" role="tabpanel" aria-labelledby="bidan-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="header-with-actions">
                                <h5 class="card-title fw-bold">Tabel Data Bidan</h5>
                                <div class="d-flex align-items-center">
                                    <div class="search-container me-3" style="width: 250px;">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="form-control" id="searchBidan" placeholder="Cari bidan...">
                                    </div>
                                    <button class="btn-add-event" id="openModalBtn">
                                        <i class="fas fa-plus"></i>
                                        <span>Tambah Bidan</span>
                                    </button>
                                </div>
                            </div>

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
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
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($midwives as $midwife)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-primary">{{ substr($midwife->name, 0, 2) }}</div>
                                                            <span>{{ $midwife->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $midwife->email }}</td>
                                                    <td>{{ $midwife->phone_number }}</td>
                                                    <td>
                                                        <span class="badge bg-success">
                                                            {{ $midwife->midwifeDetail ? $midwife->midwifeDetail->status : 'Active' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                       <button type="button" class="btn btn-sm btn-outline-primary edit-bidan-btn"
                                                            data-id="{{ $midwife->midwife_id }}"
                                                            data-name="{{ $midwife->name }}"
                                                            data-email="{{ $midwife->email }}"
                                                            data-phone-number="{{ $midwife->phone_number }}"
                                                            data-status="{{ $midwife->status }}"
                                                            data-available-day="{{ $midwife->available_day }}"
                                                            data-start-time="{{ $midwife->start_time }}"
                                                            data-end-time="{{ $midwife->end_time }}"
                                                            data-photo="{{ $midwife->profile_picture ? asset('storage/' . $midwife->profile_picture) : '' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="confirmDelete(event, this)">
                                                                <i class="bi bi-trash"></i>
                                                            </button>

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

                                <!-- Pagination for Midwives with separate query parameter -->
                                @if($midwives->hasPages())
                                <nav aria-label="Page navigation for midwives">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        <li class="page-item {{ $midwives->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link"
                                            href="{{ $midwives->appends(['user_page' => request('user_page')])->previousPageUrl() }}#bidan-content"
                                            aria-label="Previous"
                                            onclick="handlePaginationClick(event, this, 'bidan-content')">
                                                <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                            </a>
                                        </li>

                                        {{-- Pagination Elements --}}
                                        @foreach($midwives->getUrlRange(1, $midwives->lastPage()) as $page => $url)
                                            <li class="page-item {{ $midwives->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link"
                                                href="{{ $url }}#bidan-content"
                                                onclick="handlePaginationClick(event, this, 'bidan-content')">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        <li class="page-item {{ $midwives->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link"
                                            href="{{ $midwives->appends(['user_page' => request('user_page')])->nextPageUrl() }}#bidan-content"
                                            aria-label="Next"
                                            onclick="handlePaginationClick(event, this, 'bidan-content')">
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

            <!-- Pasien Content -->
            <div class="tab-pane fade" id="pasien-content" role="tabpanel" aria-labelledby="pasien-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title fw-bold">Tabel Data Pasien</h5>
                                <div class="search-container" style="width: 250px;">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" id="searchPasien" placeholder="Cari pasien...">
                                </div>
                            </div>

                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Address</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-primary">{{ substr($user->name, 0, 2) }}</div>
                                                            <span>{{ $user->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone_number }}</td>
                                                    <td>{{ $user->address }}</td>
                                                    <td class="text-end">

                                                    <button type="button" class="btn btn-sm btn-outline-primary edit-pasien-btn"
                                                            data-id="{{ $user->user_id }}"
                                                            data-name="{{ $user->name }}"
                                                            data-email="{{ $user->email }}"
                                                            data-phone-number="{{ $user->phone_number }}"
                                                            data-address="{{ $user->address }}"
                                                            data-photo="{{ $user->profile_picture_url }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="confirmDeleteUser(event, this)">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data pasien</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination for Users with separate query parameter -->
                                @if($users->hasPages())
                                <nav aria-label="Page navigation for users">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link"
                                            href="{{ $users->appends(['midwife_page' => request('midwife_page')])->previousPageUrl() }}#pasien-content"
                                            aria-label="Previous"
                                            onclick="handlePaginationClick(event, this, 'pasien-content')">
                                                <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                            </a>
                                        </li>

                                        {{-- Pagination Elements --}}
                                        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link"
                                                href="{{ $url }}#pasien-content"
                                                onclick="handlePaginationClick(event, this, 'pasien-content')">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link"
                                            href="{{ $users->appends(['midwife_page' => request('midwife_page')])->nextPageUrl() }}#pasien-content"
                                            aria-label="Next"
                                            onclick="handlePaginationClick(event, this, 'pasien-content')">
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

        function confirmDelete(event, button) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        function confirmDeleteUser(event, button) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
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





        document.addEventListener('DOMContentLoaded', function() {
    // === INPUT BIDAN MODAL ===
    const modal = document.getElementById('eventModal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const submitBtn = document.getElementById('submitBtn');
    const eventForm = document.getElementById('eventForm');

    // Clear form fields function
    function clearInputForm() {
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('phone_number').value = '';
        document.getElementById('password').value = '';
    }

    // Open modal with cleared fields
    openModalBtn.addEventListener('click', function() {
        clearInputForm(); // Clear any previous data
        modal.classList.add('active');
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
    });


// === EDIT BIDAN FUNCTIONALITY ===
document.addEventListener('DOMContentLoaded', function() {
    const editBidanModal = document.getElementById('editBidanModal');
    const editBidanForm = document.getElementById('editBidanForm');
    const editBidanPhoto = document.getElementById('editBidanPhoto');
    const editBidanPhotoPreview = document.getElementById('editBidanPhotoPreview');
    const currentBidanPhoto = document.getElementById('currentBidanPhoto');
    const currentBidanPhotoContainer = document.getElementById('currentBidanPhotoContainer');
    const updateBidanBtn = document.getElementById('updateBidanBtn');
    const closeEditBidanModalBtn = document.getElementById('closeEditBidanModalBtn');
    const cancelEditBidanBtn = document.getElementById('cancelEditBidanBtn');

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
            'admin.midwife.update': '{{ route("admin.midwife.update", ["id" => "__id__"]) }}'.replace('__id__', '')
        }
    };

    // Handle edit buttons for bidan - Switched to getAttribute() to match user edit functionality
    document.querySelectorAll('.edit-bidan-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const phoneNumber = this.getAttribute('data-phone-number');
            const status = this.getAttribute('data-status');
            const availableDay = this.getAttribute('data-available-day');
            const startTime = this.getAttribute('data-start-time');
            const endTime = this.getAttribute('data-end-time');
            const photoUrl = this.getAttribute('data-photo');

            console.log("Opening edit modal for bidan ID:", id); // Debug

            // Set form action
            editBidanForm.action = `/midwife/update/${id}`;

            // Populate form fields
            document.getElementById('editBidanId').value = id;
            document.getElementById('editBidanName').value = name;
            document.getElementById('editBidanEmail').value = email;
            document.getElementById('editBidanPhoneNumber').value = phoneNumber;
            document.getElementById('editBidanStatus').value = status;
            document.getElementById('editBidanAvailableDay').value = availableDay || '';
            document.getElementById('editBidanStartTime').value = startTime || '';
            document.getElementById('editBidanEndTime').value = endTime || '';

            // Handle photo preview
            if (photoUrl && photoUrl !== 'null') {
                currentBidanPhoto.src = photoUrl;
                currentBidanPhotoContainer.classList.remove('d-none');
            } else {
                currentBidanPhotoContainer.classList.add('d-none');
            }

            // Reset fields
            editBidanPhotoPreview.classList.add('d-none');
            editBidanPhoto.value = '';
            document.getElementById('editBidanPassword').value = '';
            document.getElementById('editBidanPasswordConfirmation').value = '';

            // Show modal
            editBidanModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Handle file input change for photo preview
    editBidanPhoto.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            const previewContainer = document.getElementById('editBidanPhotoPreview');
            const previewImage = previewContainer.querySelector('img');

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');
            };

            reader.readAsDataURL(file);
        }
    });

    // Close modal handlers
    closeEditBidanModalBtn.addEventListener('click', closeEditBidanModal);
    cancelEditBidanBtn.addEventListener('click', closeEditBidanModal);

    // Close edit modal when clicking outside
    editBidanModal.addEventListener('click', function(e) {
        if (e.target === editBidanModal) {
            closeEditBidanModal();
        }
    });


    // Close edit modal function
    function closeEditBidanModal() {
        editBidanModal.classList.remove('active');
        document.body.style.overflow = '';
    }

   // Handle form submission for bidan with SweetAlert2
            updateBidanBtn.addEventListener('click', async function() {
                const formData = new FormData(editBidanForm);
                const midwifeId = document.getElementById('editBidanId').value;

                if (!midwifeId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'ID Bidan tidak ditemukan. Silakan coba lagi.'
                    });
                    return;
                }

                // Validate password confirmation
                const password = document.getElementById('editBidanPassword').value;
                const passwordConfirmation = document.getElementById('editBidanPasswordConfirmation').value;

                if (password && password !== passwordConfirmation) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Password dan konfirmasi password tidak sama'
                    });
                    return;
                }

                // Loading state with SweetAlert2
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang memperbarui data bidan',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    const response = await fetch(editBidanForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal memperbarui data bidan');
                    }

                    if (data.success) {
                        closeEditBidanModal();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Data bidan berhasil diperbarui',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Gagal memperbarui data bidan');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message || 'Terjadi kesalahan saat memperbarui data bidan'
                    });
                }
            });
        });


///edit users
const editPasienModal = document.getElementById('editPasienModal');
const closeEditPasienModalBtn = document.getElementById('closeEditPasienModalBtn');
const cancelEditPasienBtn = document.getElementById('cancelEditPasienBtn');
const editPasienForm = document.getElementById('editPasienForm');
const editPasienPhoto = document.getElementById('editPasienPhoto');
const editPasienPhotoPreview = document.getElementById('editPasienPhotoPreview');
const removeEditPasienPhoto = document.getElementById('removeEditPasienPhoto');
const currentPasienPhoto = document.getElementById('currentPasienPhoto');
const currentPasienPhotoContainer = document.getElementById('currentPasienPhotoContainer');
const updatePasienBtn = document.getElementById('updatePasienBtn');


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
            'admin.pasien.update': '{{ route("admin.pasien.update", ["id" => "__id__"]) }}'.replace('__id__', '')
        }
    };


// Function to handle edit buttons for patients
document.querySelectorAll('.edit-pasien-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Ambil data dari atribut data- pada tombol
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const email = this.getAttribute('data-email');
        const phoneNumber = this.getAttribute('data-phone-number');
        const address = this.getAttribute('data-address');
        const photoUrl = this.getAttribute('data-photo');

        console.log("Opening edit modal for user ID:", id); // Debug

        // Populate the form fields
        document.getElementById('editPasienId').value = id;
        document.getElementById('editPasienName').value = name;
        document.getElementById('editPasienEmail').value = email;
        document.getElementById('editPasienPhoneNumber').value = phoneNumber;
        document.getElementById('editPasienAddress').value = address || '';

        // Handle photo preview
        const currentPasienPhotoContainer = document.getElementById('currentPasienPhotoContainer');
        const currentPasienPhoto = document.getElementById('currentPasienPhoto');
        const editPasienPhotoPreview = document.getElementById('editPasienPhotoPreview');
        const editPasienPhoto = document.getElementById('editPasienPhoto');

        if (photoUrl && photoUrl !== '') {
            currentPasienPhoto.src = photoUrl;
            currentPasienPhotoContainer.classList.remove('d-none');
        } else {
            currentPasienPhotoContainer.classList.add('d-none');
        }

        // Reset new photo preview and password fields
        editPasienPhotoPreview.classList.add('d-none');
        editPasienPhoto.value = '';
        document.getElementById('editPasienPassword').value = '';
        document.getElementById('editPasienPasswordConfirmation').value = '';

        // Show modal
        const editPasienModal = document.getElementById('editPasienModal');
        editPasienModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});

// Handle file input change for photo preview
document.getElementById('editPasienPhoto').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        const previewContainer = document.getElementById('editPasienPhotoPreview');
        const previewImage = previewContainer.querySelector('img');

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('d-none');
        };

        reader.readAsDataURL(file);
    }
});

// Alternatif jika flasher tidak tersedia
function showFlasherAlert(type, title, message) {
    // Pastikan library flasher tersedia, jika tidak gunakan alternatif
    if (typeof flasher !== 'undefined') {
        flasher[type](title, message);
    } else {
        // Alternatif jika flasher tidak tersedia
        alert(message);
    }
}

// Handle the update button click with SweetAlert2
        document.getElementById('updatePasienBtn').addEventListener('click', async function() {
            const form = document.getElementById('editPasienForm');
            const userId = document.getElementById('editPasienId').value;

            if (!userId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID Pasien tidak ditemukan. Silakan coba lagi.'
                });
                return;
            }

            // Set action URL
            form.action = `/pasien/update/${userId}`;
            const formData = new FormData(form);

            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                html: 'Sedang memperbarui data pasien',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Gagal memperbarui data pasien');
                }

                if (data.success) {
                    closeEditPasienModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message || 'Data pasien berhasil diperbarui',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Gagal memperbarui data pasien');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.message || 'Terjadi kesalahan saat memperbarui data pasien'
                });
            }
        });

// Close modal handlers
document.getElementById('closeEditPasienModalBtn').addEventListener('click', function() {
    document.getElementById('editPasienModal').classList.remove('active');
    document.body.style.overflow = 'auto';
});

document.getElementById('cancelEditPasienBtn').addEventListener('click', function() {
    document.getElementById('editPasienModal').classList.remove('active');
    document.body.style.overflow = 'auto';
});

// Handle file input change for photo preview
document.getElementById('editPasienPhoto').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        const previewContainer = document.getElementById('editPasienPhotoPreview');
        const previewImage = previewContainer.querySelector('img');

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('d-none');
        };

        reader.readAsDataURL(file);
    }
});

// Handle the update button click
document.getElementById('updatePasienBtn').addEventListener('click', function() {
    const form = document.getElementById('editPasienForm');
    const userId = document.getElementById('editPasienId').value;

    console.log("User ID being submitted:", userId); // Debug

    // Pastikan userId tidak kosong
    if (!userId) {
        console.error("Error: User ID is empty!");
        alert("ID Pasien tidak ditemukan. Silakan coba lagi.");
        return;
    }

    // Set action URL dengan ID yang sudah dipastikan ada
    form.action = `/pasien/update/${userId}`;
    console.log("Form action set to:", form.action); // Debug
    form.submit();
});

// Close modal handlers
document.getElementById('closeEditPasienModalBtn').addEventListener('click', function() {
    document.getElementById('editPasienModal').classList.remove('active');
    document.body.style.overflow = 'auto';
});

document.getElementById('cancelEditPasienBtn').addEventListener('click', function() {
    document.getElementById('editPasienModal').classList.remove('active');
    document.body.style.overflow = 'auto';
});

// Handle file input change for photo preview
document.getElementById('editPasienPhoto').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        const previewContainer = document.getElementById('editPasienPhotoPreview');
        const previewImage = previewContainer.querySelector('img');

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('d-none');
        };

        reader.readAsDataURL(file);
    }
});

// Handle the update button click
document.getElementById('updatePasienBtn').addEventListener('click', function() {
    document.getElementById('editPasienForm').submit();
});

// Close modal handlers
document.getElementById('closeEditPasienModalBtn').addEventListener('click', function() {
    document.getElementById('editPasienModal').classList.remove('active');
    document.body.style.overflow = 'auto';
});

document.getElementById('cancelEditPasienBtn').addEventListener('click', function() {
    document.getElementById('editPasienModal').classList.remove('active');
    document.body.style.overflow = 'auto';
});

// Handle file input change for photo preview
document.getElementById('editPasienPhoto').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        const previewContainer = document.getElementById('editPasienPhotoPreview');
        const previewImage = previewContainer.querySelector('img');

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('d-none');
        };

        reader.readAsDataURL(file);
    }
});

// Handle the update button click
document.getElementById('updatePasienBtn').addEventListener('click', function() {
    document.getElementById('editPasienForm').submit();
});

// Close modal handlers
document.getElementById('closeEditPasienModalBtn').addEventListener('click', function() {
    document.getElementById('editPasienModal').classList.remove('active');
    document.body.style.overflow = 'auto';
});

document.getElementById('cancelEditPasienBtn').addEventListener('click', function() {
    document.getElementById('editPasienModal').classList.remove('active');
    document.body.style.overflow = 'auto';
});

// Close edit modal functions
function closeEditPasienModal() {
    editPasienModal.classList.remove('active');
    document.body.style.overflow = '';
}

closeEditPasienModalBtn.addEventListener('click', closeEditPasienModal);
cancelEditPasienBtn.addEventListener('click', closeEditPasienModal);

// Close edit modal when clicking outside
editPasienModal.addEventListener('click', function(e) {
    if (e.target === editPasienModal) {
        closeEditPasienModal();
    }
});

// Handle photo preview
editPasienPhoto.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            editPasienPhotoPreview.querySelector('img').src = e.target.result;
            editPasienPhotoPreview.classList.remove('d-none');
        };
        reader.readAsDataURL(this.files[0]);
    }
});

// Remove selected new photo
removeEditPasienPhoto.addEventListener('click', function() {
    editPasienPhoto.value = '';
    editPasienPhotoPreview.classList.add('d-none');
});

// Handle form submission
updatePasienBtn.addEventListener('click', function() {
    const formData = new FormData(editPasienForm);

    // Show loading state
    updatePasienBtn.disabled = true;
    updatePasienBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

    fetch(editPasienForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success message
            alertify.success(data.message || 'Data pasien berhasil diperbarui');

            // Close modal
            closeEditPasienModal();

            // Reload the page to see changes
            window.location.reload();
        } else {
            throw new Error(data.message || 'Gagal memperbarui data pasien');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alertify.error(error.message || 'Terjadi kesalahan saat memperbarui data pasien');
    })
    .finally(() => {
        updatePasienBtn.disabled = false;
        updatePasienBtn.innerHTML = 'Update';
    });
});





        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // ... (keep all existing DOMContentLoaded code) ...

            // Check URL hash on page load
            if (window.location.hash) {
                const tabId = window.location.hash.substring(1);
                if (tabId === 'pasien-content') {
                    document.getElementById('pasien-tab').click();
                }
            }

            // Initialize all buttons
            initializeEditButtons();
        });

        // Handle back/forward navigation
        window.addEventListener('popstate', function() {
            if (window.location.hash) {
                const tabId = window.location.hash.substring(1);
                if (tabId === 'pasien-content') {
                    document.getElementById('pasien-tab').click();
                } else {
                    document.getElementById('bidan-tab').click();
                }
            }
        });



        // Search functionality for Bidan table
const searchBidan = document.getElementById('searchBidan');
if (searchBidan) {
    searchBidan.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#bidan-content tbody tr');

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
        const rows = document.querySelectorAll('#pasien-content tbody tr');

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
    </script>
</body>
</html>
