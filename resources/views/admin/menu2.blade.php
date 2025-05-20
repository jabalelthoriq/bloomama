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
             <form id="editPasienForm"
      action="#"
       @foreach($users as $user)
      data-base-url-{{ $user->user_id }}="{{ route('admin.pasien.update', ['id' => $user->user_id]) }}"
      @endforeach
      method="POST"
      enctype="multipart/form-data">
    @csrf
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

        <!-- Modal Input Bidan Form -->
<div class="modal-overlay" id="eventModal">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="fw-bold m-0">Input Bidan Baru</h5>
            <button class="close-modal" id="closeModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('store.midwife') }}" method="POST" id="eventForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Bidan</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama bidan" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Bidan</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email bidan" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan nomor telepon" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="midwife" selected>Bidan</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" selected>Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="available_day" class="form-label">Hari Kerja</label>
                    <input type="text" class="form-control" id="available_day" name="available_day" placeholder="Contoh: Senin-Jumat">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" id="start_time" name="start_time">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
            <button type="submit" form="eventForm" class="btn btn-primary" style="background-color: #0400d4">Submit</button>
        </div>
    </div>
</div>


        <!-- Modal Edit Bidan Form -->
<div class="modal-overlay" id="editBidanModal">
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="fw-bold m-0">Edit Bidan</h5>
            <button class="close-modal" id="closeEditBidanModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="editBidanForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editBidanId" name="midwife_id">
                <div class="mb-3">
                    <label for="editName" class="form-label">Nama Bidan</label>
                    <input type="text" class="form-control" id="editName" name="name" placeholder="Masukkan nama bidan">
                </div>
                <div class="mb-3">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editEmail" name="email" placeholder="Masukkan email">
                </div>
                <div class="mb-3">
                    <label for="editPhoneNumber" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="editPhoneNumber" name="phone_number" placeholder="Masukkan nomor telepon">
                </div>
                <div class="mb-3">
                    <label for="editStatus" class="form-label">Status</label>
                    <select class="form-control" id="editStatus" name="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="editPassword" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" class="form-control" id="editPassword" name="password" placeholder="Masukkan password baru">
                </div>
                <div class="mb-3">
                    <label for="editPasswordConfirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="editPasswordConfirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                </div>
                <div class="mb-3">
                    <label for="editPhoto" class="form-label">Foto Profil</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="editPhoto" name="photo" accept="image/*">
                        <label class="input-group-text" for="editPhoto">
                            <i class="fas fa-upload"></i>
                        </label>
                    </div>
                    <small class="text-muted">Upload foto profil (Max: 2MB, Format: JPG, PNG)</small>
                    <div class="d-flex align-items-center mt-2">
                        <div id="currentPhotoContainer" class="me-3">
                            <p class="mb-1">Foto saat ini:</p>
                            <img id="currentPhoto" src="" alt="Current Photo" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div id="editPhotoPreview" class="d-none">
                            <div class="position-relative" style="max-width: 100px;">
                                <p class="mb-1">Foto baru:</p>
                                <img src="" alt="Photo Preview" class="img-thumbnail">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" id="removeEditPhoto">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
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
                                                            data-id="{{ $midwife->id }}"
                                                            data-name="{{ $midwife->name }}"
                                                            data-email="{{ $midwife->email }}"
                                                            data-phone-number="{{ $midwife->phone_number }}"
                                                            data-status="{{ $midwife->midwifeDetail ? $midwife->midwifeDetail->status : 'Active' }}"
                                                            data-photo="{{ $midwife->photo ? asset('storage/' . $midwife->photo) : '' }}">
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
                                                        data-id="{{ $user->id }}"
                                                        data-name="{{ $user->name }}"
                                                        data-email="{{ $user->email }}"
                                                        data-phone-number="{{ $user->phone_number }}"
                                                        data-address="{{ $user->address }}"
                                                        data-photo="{{ $user->photo ? asset('storage/' . $user->photo) : '' }}">
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



    // === EDIT BIDAN MODAL ===
    const editBidanModal = document.getElementById('editBidanModal');
    const closeEditBidanModalBtn = document.getElementById('closeEditBidanModalBtn');
    const cancelEditBidanBtn = document.getElementById('cancelEditBidanBtn');
    const editBidanForm = document.getElementById('editBidanForm');
    const editPhoto = document.getElementById('editPhoto');
    const editPhotoPreview = document.getElementById('editPhotoPreview');
    const removeEditPhoto = document.getElementById('removeEditPhoto');
    const currentPhoto = document.getElementById('currentPhoto');
    const currentPhotoContainer = document.getElementById('currentPhotoContainer');
    const updateBidanBtn = document.getElementById('updateBidanBtn');

    document.querySelectorAll('.edit-pasien-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const email = this.dataset.email;
        const phoneNumber = this.dataset.phoneNumber;
        const address = this.dataset.address;
        const photoUrl = this.dataset.photo;

        // Ambil URL dari atribut data yang sesuai
        const baseUrl = editPasienForm.getAttribute(`data-base-url-${id}`);

        // Pastikan URL ditemukan
        if (!baseUrl) {
            console.error(`URL not found for user ID: ${id}`);
            return;
        }

        // Update form action
        editPasienForm.action = baseUrl;

        // Isi form fields
        document.getElementById('editPasienId').value = id;
        document.getElementById('editPasienName').value = name;
        document.getElementById('editPasienEmail').value = email;
        document.getElementById('editPasienPhoneNumber').value = phoneNumber;
        document.getElementById('editPasienAddress').value = address || '';

        // Handle photo preview
        if (photoUrl && photoUrl !== 'null') {
            currentPasienPhoto.src = photoUrl;
            currentPasienPhotoContainer.classList.remove('d-none');
        } else {
            currentPasienPhotoContainer.classList.add('d-none');
        }

        // Reset fields
        editPasienPhotoPreview.classList.add('d-none');
        editPasienPhoto.value = '';
        document.getElementById('editPasienPassword').value = '';
        document.getElementById('editPasienPasswordConfirmation').value = '';

        // Show modal
        editPasienModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});

// Handle form submission
updatePasienBtn.addEventListener('click', async function() {
    const formData = new FormData(editPasienForm);

    // Loading state
    updatePasienBtn.disabled = true;
    updatePasienBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    try {
        const response = await fetch(editPasienForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal memperbarui data');
        }

        if (data.success) {
            alertify.success(data.message || 'Data berhasil diperbarui');
            closeEditPasienModal();

            // Refresh data table atau halaman
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Gagal memperbarui data');
        }
    } catch (error) {
        console.error('Error:', error);
        alertify.error(error.message || 'Terjadi kesalahan saat memperbarui data');
    } finally {
        updatePasienBtn.disabled = false;
        updatePasienBtn.innerHTML = 'Update';
    }
});

    // Close edit modal functions
    function closeEditModal() {
        editBidanModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeEditBidanModalBtn.addEventListener('click', closeEditModal);
    cancelEditBidanBtn.addEventListener('click', closeEditModal);

    // Close edit modal when clicking outside
    editBidanModal.addEventListener('click', function(e) {
        if (e.target === editBidanModal) {
            closeEditModal();
        }
    });

    // Handle photo preview
    editPhoto.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                editPhotoPreview.querySelector('img').src = e.target.result;
                editPhotoPreview.classList.remove('d-none');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Remove selected new photo
    removeEditPhoto.addEventListener('click', function() {
        editPhoto.value = '';
        editPhotoPreview.classList.add('d-none');
    });

    // Handle form submission
    updateBidanBtn.addEventListener('click', function() {
        const formData = new FormData(editBidanForm);
        const midwifeId = document.getElementById('editBidanId').value;

        // Add the _method field for Laravel to recognize this as a PUT request
        formData.append('_method', 'PUT');

        fetch(`/midwives/${midwifeId}`, {
            method: 'POST', // Still using POST but Laravel will treat it as PUT
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                // Handle errors
                console.error('Error updating bidan:', data.message);
                alert('Error updating bidan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the bidan.');
        });
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

// Function to handle edit buttons for patients
document.querySelectorAll('.edit-pasien-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const email = this.dataset.email;
        const phoneNumber = this.dataset.phoneNumber;
        const address = this.dataset.address;
        const photoUrl = this.dataset.photo;

        // Populate the form fields
        document.getElementById('editPasienId').value = id;
        document.getElementById('editPasienName').value = name;
        document.getElementById('editPasienEmail').value = email;
        document.getElementById('editPasienPhoneNumber').value = phoneNumber;
        document.getElementById('editPasienAddress').value = address || '';

        // Handle photo preview
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
        editPasienModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
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
