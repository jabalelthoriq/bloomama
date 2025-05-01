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
    <title>Chatting</title>
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
       margin-left: 140px;
       padding: 30px;
       width: calc(100% - 140px);
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

    /* Live chat styles */
    .chat-container {
        display: flex;
        height: calc(100vh - 100px);
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .chat-sidebar {
        width: 300px;
        background-color: #fff;
        border-right: 1px solid #eaeaea;
        display: flex;
        flex-direction: column;
    }

    .chat-sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #eaeaea;
    }

    .chat-sidebar-header h4 {
        margin: 0;
        color: #333;
    }

    .chat-list {
        overflow-y: auto;
        flex-grow: 1;
    }

    .chat-item {
        padding: 15px 20px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #f5f5f5;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .chat-item:hover {
        background-color: #f9f9f9;
    }

    .chat-item.active {
        background-color: #e6f7ff;
        border-left: 3px solid #00b8d4;
    }

    .chat-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background-color: #f0f0f0;
        margin-right: 15px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .chat-info {
        flex-grow: 1;
    }

    .chat-name {
        font-weight: 600;
        margin: 0;
        color: #333;
    }

    .chat-last-message {
        font-size: 13px;
        color: #888;
        margin: 5px 0 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 180px;
    }

    .chat-meta {
        text-align: right;
    }

    .chat-time {
        font-size: 12px;
        color: #aaa;
    }

    .chat-badge {
        background-color: #00b8d4;
        color: #fff;
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 10px;
        margin-top: 5px;
        display: inline-block;
    }

    .chat-main {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eaeaea;
        display: flex;
        align-items: center;
    }

    .user-info {
        flex-grow: 1;
    }

    .user-status {
        display: flex;
        align-items: center;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #4CAF50;
        margin-right: 5px;
    }

    .user-actions {
        display: flex;
        gap: 15px;
    }

    .action-icon {
        color: #777;
        cursor: pointer;
        font-size: 18px;
    }

    .action-icon:hover {
        color: #00b8d4;
    }

    .chat-messages {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto;
        background-color: #f9fafb;
    }

    .message {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        max-width: 70%;
    }

    .message.received {
        align-items: flex-start;
    }

    .message.sent {
        align-items: flex-end;
        align-self: flex-end;
    }

    .message-content {
        padding: 12px 15px;
        border-radius: 18px;
        margin-bottom: 5px;
        position: relative;
    }

    .received .message-content {
        background-color: #ffffff;
        color: #333;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .sent .message-content {
        background-color: #00b8d4;
        color: #fff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .message-meta {
        font-size: 11px;
        color: #aaa;
    }

    .sent .message-meta {
        text-align: right;
    }

    .message-time {
        margin-left: 5px;
    }

    .chat-input {
        padding: 15px 20px;
        border-top: 1px solid #eaeaea;
        background-color: #fff;
    }

    .input-container {
        display: flex;
        align-items: center;
        background-color: #f5f5f5;
        border-radius: 24px;
        padding: 8px;
    }

    .input-attachments {
        display: flex;
        margin-right: 10px;
    }

    .attachment-icon {
        color: #777;
        font-size: 18px;
        cursor: pointer;
        padding: 5px;
    }

    .attachment-icon:hover {
        color: #00b8d4;
    }

    .message-input {
        flex-grow: 1;
        border: none;
        background: transparent;
        outline: none;
        padding: 8px;
    }

    .send-button {
        background-color: #00b8d4;
        color: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .send-button:hover {
        background-color: #008ba3;
    }

    /* Responsive styles */
    @media (max-width: 992px) {
        .chat-sidebar {
            width: 250px;
        }
    }

    @media (max-width: 768px) {
        .vertical-navbar {
            width: 60px;
            margin: 15px;
        }

        .main-content {
            margin-left: 90px;
            width: calc(100% - 90px);
            padding: 15px;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
        }

        .chat-sidebar {
            width: 220px;
        }

        .chat-last-message {
            max-width: 120px;
        }
    }

    @media (max-width: 576px) {
        .vertical-navbar {
            width: 50px;
            margin: 10px;
        }

        .main-content {
            margin-left: 70px;
            width: calc(100% - 70px);
            padding: 10px;
        }

        .chat-container {
            flex-direction: column;
            height: calc(100vh - 80px);
        }

        .chat-sidebar {
            width: 100%;
            height: 350px;
            border-right: none;
            border-bottom: 1px solid #eaeaea;
        }

        .chat-main {
            height: calc(100vh - 350px - 80px);
        }
    }
</style>
<body>
    <div class="vertical-navbar">
        <div class="nav-logo" >
            <img src="{{ asset('image/logo.png') }}" alt="Logo">
        </div>
        <div class="nav-icon">
            <a href="dashboard">
                <i class="fas fa-th-large" ></i>
            </a>
        </div>

        <div class="nav-icon active">
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

    <div class="main-content">
        <div class="header-container">
            <h2>Live Chat</h2>
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" placeholder="Search messages...">
            </div>
        </div>

        <div class="chat-container">
            <!-- Chat Sidebar -->
            <div class="chat-sidebar">
                <div class="chat-sidebar-header">
                    <h4>Recent Chats</h4>
                </div>
                <div class="chat-list">
                    <!-- Active chat -->
                    <div class="chat-item active">
                        <div class="chat-avatar">
                            <img src="/api/placeholder/42/42" alt="User avatar">
                        </div>
                        <div class="chat-info">
                            <h5 class="chat-name">Sarah Johnson</h5>
                            <p class="chat-last-message">Thanks for your help yesterday!</p>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-time">10:45 AM</div>
                            <div class="chat-badge">2</div>
                        </div>
                    </div>

                    <!-- Other chats -->
                    <div class="chat-item">
                        <div class="chat-avatar">
                            <img src="/api/placeholder/42/42" alt="User avatar">
                        </div>
                        <div class="chat-info">
                            <h5 class="chat-name">Michael Brown</h5>
                            <p class="chat-last-message">Can we schedule a meeting?</p>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-time">9:32 AM</div>
                        </div>
                    </div>

                    <div class="chat-item">
                        <div class="chat-avatar">
                            <img src="/api/placeholder/42/42" alt="User avatar">
                        </div>
                        <div class="chat-info">
                            <h5 class="chat-name">Jessica Taylor</h5>
                            <p class="chat-last-message">I've sent you the files via email</p>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-time">Yesterday</div>
                            <div class="chat-badge">1</div>
                        </div>
                    </div>

                    <div class="chat-item">
                        <div class="chat-avatar">
                            <img src="/api/placeholder/42/42" alt="User avatar">
                        </div>
                        <div class="chat-info">
                            <h5 class="chat-name">David Wilson</h5>
                            <p class="chat-last-message">Perfect! See you tomorrow at 2 PM</p>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-time">Yesterday</div>
                        </div>
                    </div>

                    <div class="chat-item">
                        <div class="chat-avatar">
                            <img src="/api/placeholder/42/42" alt="User avatar">
                        </div>
                        <div class="chat-info">
                            <h5 class="chat-name">Emma Garcia</h5>
                            <p class="chat-last-message">How is the project going?</p>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-time">Apr 28</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="chat-main">
                <div class="chat-header">
                    <div class="chat-avatar">
                        <img src="/api/placeholder/42/42" alt="User avatar">
                    </div>
                    <div class="user-info">
                        <h5 class="chat-name">Sarah Johnson</h5>
                        <div class="user-status">
                            <span class="status-dot"></span>
                            <span>Online</span>
                        </div>
                    </div>
                    <div class="user-actions">
                        <i class="fas fa-phone action-icon"></i>
                        <i class="fas fa-video action-icon"></i>
                        <i class="fas fa-info-circle action-icon"></i>
                    </div>
                </div>

                <div class="chat-messages">
                    <!-- Received messages -->
                    <div class="message received">
                        <div class="message-content">
                            Hi there! How can I help you today?
                        </div>
                        <div class="message-meta">
                            <span class="message-status">Sarah Johnson</span>
                            <span class="message-time">10:30 AM</span>
                        </div>
                    </div>

                    <!-- Sent messages -->
                    <div class="message sent">
                        <div class="message-content">
                            I'm trying to figure out how to use the new reporting feature. Could you walk me through it?
                        </div>
                        <div class="message-meta">
                            <span class="message-status">Delivered</span>
                            <span class="message-time">10:32 AM</span>
                        </div>
                    </div>

                    <div class="message received">
                        <div class="message-content">
                            Of course! I'd be happy to help you with that. The reporting feature can be accessed from the dashboard by clicking on the "Reports" tab in the left sidebar.
                        </div>
                        <div class="message-meta">
                            <span class="message-status">Sarah Johnson</span>
                            <span class="message-time">10:35 AM</span>
                        </div>
                    </div>

                    <div class="message received">
                        <div class="message-content">
                            Once you're there, you'll see several report templates to choose from. Which specific report are you interested in?
                        </div>
                        <div class="message-meta">
                            <span class="message-status">Sarah Johnson</span>
                            <span class="message-time">10:36 AM</span>
                        </div>
                    </div>

                    <div class="message sent">
                        <div class="message-content">
                            I need to create a monthly sales summary for my team. Is there a template for that?
                        </div>
                        <div class="message-meta">
                            <span class="message-status">Delivered</span>
                            <span class="message-time">10:40 AM</span>
                        </div>
                    </div>

                    <div class="message received">
                        <div class="message-content">
                            Yes, there is! Look for the "Monthly Sales Analysis" template. It has all the charts and data tables you'll need. You can also customize it based on your specific requirements.
                        </div>
                        <div class="message-meta">
                            <span class="message-status">Sarah Johnson</span>
                            <span class="message-time">10:42 AM</span>
                        </div>
                    </div>

                    <div class="message sent">
                        <div class="message-content">
                            Thanks for your help yesterday!
                        </div>
                        <div class="message-meta">
                            <span class="message-status">Delivered</span>
                            <span class="message-time">10:45 AM</span>
                        </div>
                    </div>
                </div>

                <div class="chat-input">
                    <div class="input-container">
                        <div class="input-attachments">
                            <i class="far fa-smile attachment-icon"></i>
                            <i class="fas fa-paperclip attachment-icon"></i>
                        </div>
                        <input type="text" class="message-input" placeholder="Type a message...">
                        <button class="send-button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
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

            // Add event listeners for chat items
            document.querySelectorAll('.chat-item').forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from current active chat
                    const currentActive = document.querySelector('.chat-item.active');
                    if (currentActive) {
                        currentActive.classList.remove('active');
                    }

                    // Add active class to clicked chat
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
