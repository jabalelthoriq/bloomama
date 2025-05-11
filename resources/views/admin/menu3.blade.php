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
    <title>Content</title>
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

        <div class="nav-icon">
            <a href="menu2">
            <i class="far fa-user"></i>
            </a>
        </div>

        <div class="nav-icon">
            <a href="acara">
                <i class="far fa-calendar-alt"></i>
            </a>
        </div>

        <div class="nav-icon active">
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
            <h2 class="fs-3 fw-bold m-0">Content</h2>
        </div>

        <!-- Modal Event Form -->
        <div class="modal-overlay" id="eventModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h5 class="fw-bold m-0">Input Content Baru</h5>
                    <button class="close-modal" id="closeModalBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.event') }}" method="POST" id="eventForm">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Content</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul content">
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">Media Url</label>
                            <input type="url" class="form-control" id="url" name="url" placeholder="Masukkan media url">
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="" selected disabled>Select a category </option>
                                <option value="nutrition">Nutrition</option>
                                <option value="exercise">Exercise</option>
                                <option value="health_tips">Health Tips</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan deskripsi content"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                <label class="input-group-text" for="thumbnail">
                                    <i class="fas fa-upload"></i>
                                </label>
                            </div>
                            <small class="text-muted">Upload image thumbnail (Max: 2MB, Format: JPG, PNG)</small>
                            <div id="thumbnailPreview" class="mt-2 d-none">
                                <div class="position-relative" style="max-width: 200px;">
                                    <img src="" alt="Thumbnail Preview" class="img-thumbnail">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" id="removeThumbnail">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitBtn" style="background-color: #0400d4">Submit</button>
                </div>
            </div>
        </div>


      <!-- Modal Edit Content Form -->
<div class="modal-overlay" id="editContentModal">
    <div class="modal-container">
        <div class="modal-header">
            
            <h5 class="fw-bold m-0">Edit Content</h5>
            <button class="close-modal" id="closeEditModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="editContentForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editContentId" name="content_id">
                <div class="mb-3">
                    <label for="editTitle" class="form-label">Judul Content</label>
                    <input type="text" class="form-control" id="editTitle" name="title" placeholder="Masukkan judul content">
                </div>
                <div class="mb-3">
                    <label for="editUrl" class="form-label">Media Url</label>
                    <input type="url" class="form-control" id="editUrl" name="url" placeholder="Masukkan media url">
                </div>

                <div class="mb-3">
                    <label for="editCategory" class="form-label">Category</label>
                    <select class="form-control" id="editCategory" name="category">
                        <option value="" selected disabled>Select a category </option>
                        <option value="nutrition">Nutrition</option>
                        <option value="exercise">Exercise</option>
                        <option value="health_tips">Health Tips</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="editDescription" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="editDescription" name="description" rows="3" placeholder="Masukkan deskripsi content"></textarea>
                </div>
                <div class="mb-3">
                    <label for="editThumbnail" class="form-label">Thumbnail</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="editThumbnail" name="thumbnail" accept="image/*">
                        <label class="input-group-text" for="editThumbnail">
                            <i class="fas fa-upload"></i>
                        </label>
                    </div>
                    <small class="text-muted">Upload image thumbnail (Max: 2MB, Format: JPG, PNG)</small>
                    <div class="d-flex align-items-center mt-2">
                        <div id="currentThumbnailContainer" class="me-3">
                            <p class="mb-1">Current thumbnail:</p>
                            <img id="currentThumbnail" src="" alt="Current Thumbnail" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div id="editThumbnailPreview" class="d-none">
                            <div class="position-relative" style="max-width: 100px;">
                                <p class="mb-1">New thumbnail:</p>
                                <img src="" alt="Thumbnail Preview" class="img-thumbnail">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" id="removeEditThumbnail">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelEditBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="updateBtn" style="background-color: #0400d4">Update</button>
        </div>
    </div>
</div>



        <!-- Content Table -->
        <div class="tab-pane fade show active" id="bidan-content" role="tabpanel" aria-labelledby="bidan-tab">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="header-with-actions">
                                <h5 class="card-title fw-bold">Tabel Data Content</h5>
                                <div class="d-flex align-items-center">
                                    <div class="search-container me-3" style="width: 250px;">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="form-control" id="contentSearch" placeholder="Search content...">
                                    </div>
                                    <button class="btn-add-event" id="openModalBtn">
                                        <i class="fas fa-plus"></i>
                                        <span>Tambah Content</span>
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
                <th>Title</th>
                <th>Url</th>
                <th>Category</th>
                <th>Thumbnail</th>
                <th>Created At</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contents as $content)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <span>{{ $content->title }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span>{{ $content->url }}</span>
                        </div>
                    </td>
                    <td>{{ ucfirst(str_replace('_', ' ', $content->category)) }}</td>
                    <td>
                        @if($content->thumbnail)
                            <img src="{{ asset('storage/' . $content->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                        @else
                            <span class="badge bg-secondary">No image</span>
                        @endif
                    </td>
                    <td>{{ $content->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-primary edit-content-btn"
                            data-id="{{ $content->id }}"
                            data-title="{{ $content->title }}"
                            data-url="{{ $content->url }}"
                            data-category="{{ $content->category }}"
                            data-description="{{ $content->description }}"
                            data-thumbnail="{{ $content->thumbnail ? asset('storage/' . $content->thumbnail) : '' }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('content.destroy', $content->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('Are you sure you want to delete this content?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No content available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination for Contents -->
    @if($contents->hasPages())
    <nav aria-label="Page navigation for contents">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            <li class="page-item {{ $contents->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $contents->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                </a>
            </li>

            {{-- Pagination Elements --}}
            @foreach($contents->getUrlRange(1, $contents->lastPage()) as $page => $url)
                <li class="page-item {{ $contents->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Next Page Link --}}
            <li class="page-item {{ $contents->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $contents->nextPageUrl() }}" aria-label="Next">
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
        });


        // Edit Content Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    // Edit Content Modal functionality
    const editModal = document.getElementById('editContentModal');
    const closeEditModalBtn = document.getElementById('closeEditModalBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const updateBtn = document.getElementById('updateBtn');
    const editContentForm = document.getElementById('editContentForm');

    // Edit thumbnail preview functionality
    const editThumbnailInput = document.getElementById('editThumbnail');
    const editThumbnailPreview = document.getElementById('editThumbnailPreview');
    const editThumbnailImage = editThumbnailPreview.querySelector('img');
    const removeEditThumbnailBtn = document.getElementById('removeEditThumbnail');
    const currentThumbnailContainer = document.getElementById('currentThumbnailContainer');

    // Close edit modal functions
    function closeEditModal() {
        editModal.classList.remove('active');
        document.body.style.overflow = '';
        // Reset form
        editContentForm.reset();
        editThumbnailPreview.classList.add('d-none');
    }

    closeEditModalBtn.addEventListener('click', closeEditModal);
    cancelEditBtn.addEventListener('click', closeEditModal);

    // Close modal when clicking outside
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    // Show edit modal when edit button is clicked
    document.querySelectorAll('.edit-content-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            // Get content data from data attributes
            const contentId = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const url = this.getAttribute('data-url');
            const category = this.getAttribute('data-category');
            const description = this.getAttribute('data-description');
            const thumbnailUrl = this.getAttribute('data-thumbnail');

            // Populate form fields
            document.getElementById('editContentId').value = contentId;
            document.getElementById('editTitle').value = title;
            document.getElementById('editUrl').value = url;
            document.getElementById('editCategory').value = category;
            document.getElementById('editDescription').value = description;

            // Show current thumbnail if exists
            if (thumbnailUrl && thumbnailUrl !== '') {
                document.getElementById('currentThumbnail').src = thumbnailUrl;
                currentThumbnailContainer.classList.remove('d-none');
            } else {
                currentThumbnailContainer.classList.add('d-none');
            }

            // Update form action to include the content ID
            editContentForm.action = `/content/${contentId}`;

            // Open modal
            editModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Edit thumbnail preview when file is selected
    editThumbnailInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];

            // Check file type
            if (!file.type.match('image.*')) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select an image file (JPG, PNG)',
                    icon: 'error'
                });
                this.value = '';
                return;
            }

            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Image size should be less than 2MB',
                    icon: 'error'
                });
                this.value = '';
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                editThumbnailImage.src = e.target.result;
                editThumbnailPreview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // Remove edit thumbnail
    removeEditThumbnailBtn.addEventListener('click', function() {
        editThumbnailInput.value = '';
        editThumbnailPreview.classList.add('d-none');
        editThumbnailImage.src = '';
    });

    // Submit edit form
    updateBtn.addEventListener('click', function() {
        const contentId = document.getElementById('editContentId').value;

        // Use FormData to handle file uploads
        const formData = new FormData(editContentForm);

        // Add method spoofing for Laravel since fetch doesn't support PUT natively
        formData.append('_method', 'PUT');

        // Send AJAX request
        fetch(`/content/${contentId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                title: 'Success!',
                text: 'Content updated successfully',
                icon: 'success'
            });
            closeEditModal();

            // Reload page to show updated content
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update content',
                icon: 'error'
            });
            console.error('Error:', error);
        });
    });
});

// Add this inside your existing DOMContentLoaded event listener or create a new one
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality for content table
    const searchInput = document.getElementById('contentSearch');
    const contentTable = document.querySelector('.table');
    const contentRows = contentTable.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        contentRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let rowMatches = false;
            
            // Skip the last cell (actions column)
            for (let i = 0; i < cells.length - 1; i++) {
                const cellText = cells[i].textContent.toLowerCase();
                if (cellText.includes(searchTerm)) {
                    rowMatches = true;
                    break;
                }
            }
            
            row.style.display = rowMatches ? '' : 'none';
        });
    });
});
    </script>
</body>
</html>
