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
    <script src="https://cdn.ably.com/lib/ably.min-1.js"></script>
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
    /* Ensure messages take up available space */
    display: flex;
    flex-direction: column;
}

   .message {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
    max-width: 70%;
    width: 100%; /* Add this to ensure full width control */
}

.message.received {
    align-items: flex-start;
    margin-right: auto; /* Push received messages to left */
}

.message.sent {
    align-items: flex-end;
    margin-left: auto; /* Push sent messages to right */
    text-align: right; /* Align text to right */
}

.message-content {
    padding: 12px 15px;
    border-radius: 18px;
    margin-bottom: 5px;
    position: relative;
    word-wrap: break-word;
    max-width: 100%;
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
    display: flex;
    justify-content: flex-end; /* Align timestamp to right */
}

    .message-time {
        margin-left: 5px;
    }

    .chat-input {
    padding: 10px 15px;
    border-top: 1px solid #eaeaea;
    background-color: #fff;
    position: sticky; /* This keeps it at bottom */
    bottom: 0;
    width: 100%;
    z-index: 10; /* Ensure it stays above messages */
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
        width: calc(100% - 80px);
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

    /* Typing indicator */
    .typing-indicator {
        display: flex;
        padding: 10px 15px;
        background-color: #fff;
        border-radius: 18px;
        margin-bottom: 15px;
        width: fit-content;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .typing-dot {
        width: 8px;
        height: 8px;
        background-color: #aaa;
        border-radius: 50%;
        margin: 0 2px;
        animation: typingAnimation 1.4s infinite ease-in-out;
    }

    .typing-dot:nth-child(1) {
        animation-delay: 0s;
    }

    .typing-dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-dot:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typingAnimation {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-5px); }
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
            display: flex;
            height: calc(100vh - 80px);
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            position: relative; /* Add this */

        }

        .chat-sidebar {
            width: 100%;
            height: 350px;
            border-right: none;
            border-bottom: 1px solid #eaeaea;
        }

        .chat-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100%; /* Add this */
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
        <div class="chat-container">
            <!-- Chat Sidebar -->
            <div class="chat-sidebar">
                <div class="chat-sidebar-header">
                    <h4>Recent Chats</h4>
                </div>
                <div class="chat-list">
                    <!-- Active chat -->
                    <div class="chat-item active" data-user-id="user2">
                        <div class="chat-avatar">
                            <img src="/api/placeholder/42/42" alt="User avatar">
                        </div>
                        <div class="chat-info">
                            <h5 class="chat-name">Sarah Johnson</h5>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-time">10:45 AM</div>
                            <div class="chat-badge">2</div>
                        </div>
                    </div>
                    <!-- Additional contacts -->
                    <div class="chat-item" data-user-id="user3">
                        <div class="chat-avatar">
                            <img src="/api/placeholder/42/42" alt="User avatar">
                        </div>
                        <div class="chat-info">
                            <h5 class="chat-name">Michael Brown</h5>
                            <p class="chat-last-message">See you tomorrow!</p>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-time">Yesterday</div>
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
                        <h5 class="chat-name" id="current-chat-name">Sarah Johnson</h5>
                        <div class="user-status">
                            <span class="status-dot" id="user-status"></span>
                            <span id="status-text">Online</span>
                        </div>
                    </div>
                    <div class="user-actions">
                        <i class="fas fa-phone action-icon"></i>
                        <i class="fas fa-video action-icon"></i>
                        <i class="fas fa-info-circle action-icon"></i>
                    </div>
                </div>

                <div class="chat-messages" id="chat-messages">
                    <!-- Messages will be displayed here -->
                </div>

                <div class="chat-input">
                    <div class="input-container">
                        <div class="input-attachments">
                            <i class="far fa-smile attachment-icon"></i>
                            <i class="fas fa-paperclip attachment-icon"></i>
                        </div>
                        <input type="text" class="message-input" id="message-input" placeholder="Type a message..." autocomplete="off">
                        <button class="send-button" id="send-button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // User data - in a real app, this would come from your backend
        const currentUser = {
            id: 'user1',
            name: 'You',
            avatar: '/api/placeholder/42/42'
        };

        // Contacts data
        const contacts = {
            'user2': {
                id: 'user2',
                name: 'Sarah Johnson',
                avatar: '/api/placeholder/42/42',
                status: 'online'
            },
            'user3': {
                id: 'user3',
                name: 'Michael Brown',
                avatar: '/api/placeholder/42/42',
                status: 'offline'
            }
        };

        // Ably configuration
        let ably;
        let chatChannel;
        let currentChatUserId = 'user2'; // Default to Sarah Johnson

        // Initialize the chat
        document.addEventListener('DOMContentLoaded', function() {
            initializeNavbar();
            initializeChat();

            // Set up event listeners for chat items
            document.querySelectorAll('.chat-item').forEach(item => {
                item.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    switchChat(userId);
                });
            });

            // Set up event listeners for sending messages
            const messageInput = document.getElementById('message-input');
            const sendButton = document.getElementById('send-button');

            sendButton.addEventListener('click', sendMessage);
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        });

        function initializeNavbar() {
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
                    if (e.target.tagName === 'I') {
                        e.preventDefault();
                        const href = this.querySelector('a').getAttribute('href');
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
                    handleNavClick(navIcon, href);
                });
            });

            function handleNavClick(clickedIcon, href) {
                if (clickedIcon.classList.contains('active')) return;

                const currentActive = document.querySelector('.nav-icon.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }

                clickedIcon.classList.add('active');
                positionIndicator(clickedIcon);

                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            }

            function positionIndicator(targetIcon) {
                const rect = targetIcon.getBoundingClientRect();
                const navbarRect = document.querySelector('.vertical-navbar').getBoundingClientRect();
                const top = rect.top - navbarRect.top;
                indicator.style.top = top + 'px';
            }
        }

        function initializeChat() {
            // Initialize Ably (in a real app, you'd get this from your backend)
            // Note: This is a client-side only example. In production, you should:
            // 1. Have your server generate Ably tokens for each user
            // 2. Never expose your API key in client-side code
            ably = new Ably.Realtime('ooLakg.FjeVTg:aQwgKFtS-8JKmogyEl3Hj1iq5jU0An4aMidPJ5_-i0w'); // Replace with your Ably API key

            ably.connection.on('connected', function() {
                console.log('Connected to Ably');
                // Subscribe to the current chat channel
                subscribeToChannel(currentChatUserId);

                // Load initial messages (in a real app, you'd fetch these from your backend)
                loadInitialMessages(currentChatUserId);
            });
        }

        function subscribeToChannel(userId) {
            // Unsubscribe from previous channel if exists
            if (chatChannel) {
                chatChannel.unsubscribe();
            }

            // Create a unique channel name for this conversation
            const channelName = getChannelName(currentUser.id, userId);

            // Get the channel and subscribe
            chatChannel = ably.channels.get(channelName);

            chatChannel.subscribe('message', function(message) {
                // Check if the message is from the current chat user
                if (message.data.senderId === currentChatUserId) {
                    displayMessage(message.data, false);
                }
            });

            // Subscribe to presence events
            chatChannel.presence.subscribe('enter', function(member) {
                if (member.clientId === userId) {
                    updateUserStatus(userId, 'online');
                }
            });

            chatChannel.presence.subscribe('leave', function(member) {
                if (member.clientId === userId) {
                    updateUserStatus(userId, 'offline');
                }
            });

            // Enter presence for the current user
            chatChannel.presence.enter({ userId: currentUser.id });
        }

        function getChannelName(userId1, userId2) {
            // Create a consistent channel name for any two users
            const ids = [userId1, userId2].sort();
            return `private-chat-${ids[0]}-${ids[1]}`;
        }

        function switchChat(userId) {
            // Update active chat in sidebar
            document.querySelectorAll('.chat-item').forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('data-user-id') === userId) {
                    item.classList.add('active');
                }
            });

            // Update current chat user
            currentChatUserId = userId;

            // Update chat header
            const contact = contacts[userId];
            document.getElementById('current-chat-name').textContent = contact.name;
            updateUserStatus(userId, contact.status);

            // Clear messages and load new ones
            document.getElementById('chat-messages').innerHTML = '';

            // Subscribe to the new channel
            subscribeToChannel(userId);

            // Load messages for this chat (in a real app, fetch from backend)
            loadInitialMessages(userId);
        }

        function loadInitialMessages(userId) {
            // In a real app, you would fetch messages from your backend API
            // For this example, we'll just add some sample messages

            const messages = [
                {
                    id: 'msg1',
                    senderId: userId,
                    text: 'Hi there! How are you doing?',
                    timestamp: new Date(Date.now() - 3600000) // 1 hour ago
                },
                {
                    id: 'msg2',
                    senderId: currentUser.id,
                    text: "I'm doing great! How about you?",
                    timestamp: new Date(Date.now() - 1800000) // 30 minutes ago
                },
                {
                    id: 'msg3',
                    senderId: userId,
                    text: "I'm good too. Just wanted to check in.",
                    timestamp: new Date(Date.now() - 900000) // 15 minutes ago
                }
            ];

            messages.forEach(message => {
                const isCurrentUser = message.senderId === currentUser.id;
                displayMessage(message, isCurrentUser);
            });
        }

        function displayMessage(message, isCurrentUser) {
            const messagesContainer = document.getElementById('chat-messages');

            const messageElement = document.createElement('div');
            messageElement.className = `message ${isCurrentUser ? 'sent' : 'received'}`;

            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            messageContent.textContent = message.text;

            const messageMeta = document.createElement('div');
            messageMeta.className = 'message-meta';

            const timeElement = document.createElement('span');
            timeElement.className = 'message-time';
            timeElement.textContent = formatTime(message.timestamp);

            messageMeta.appendChild(timeElement);
            messageElement.appendChild(messageContent);
            messageElement.appendChild(messageMeta);

            messagesContainer.appendChild(messageElement);

            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function formatTime(date) {
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }

        function sendMessage() {
            const input = document.getElementById('message-input');
            const messageText = input.value.trim();

            if (messageText === '') return;

            // Create message object
            const message = {
                id: 'msg' + Date.now(),
                senderId: currentUser.id,
                receiverId: currentChatUserId,
                text: messageText,
                timestamp: new Date()
            };

            // Display the message immediately
            displayMessage(message, true);

            // Publish the message via Ably
            const channelName = getChannelName(currentUser.id, currentChatUserId);
            ably.channels.get(channelName).publish('message', message);

            // Clear input
            input.value = '';

            // In a real app, you would also save the message to your backend database
            // saveMessageToBackend(message);
        }

        function updateUserStatus(userId, status) {
            const contact = contacts[userId];
            contact.status = status;

            const statusDot = document.getElementById('user-status');
            const statusText = document.getElementById('status-text');

            if (status === 'online') {
                statusDot.style.backgroundColor = '#4CAF50';
                statusText.textContent = 'Online';
            } else {
                statusDot.style.backgroundColor = '#aaa';
                statusText.textContent = 'Offline';
            }

            // Update status in sidebar if this is the current chat
            if (userId === currentChatUserId) {
                const chatItem = document.querySelector(`.chat-item[data-user-id="${userId}"]`);
                if (chatItem) {
                    const statusIndicator = chatItem.querySelector('.status-indicator');
                    if (statusIndicator) {
                        statusIndicator.style.backgroundColor = status === 'online' ? '#4CAF50' : '#aaa';
                    }
                }
            }
        }

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
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const formData = new FormData();
                    formData.append('_token', csrfToken);

                    // Disconnect from Ably
                    if (ably) {
                        ably.connection.close();
                    }

                    fetch('/logout', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: formData,
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json().catch(() => ({ success: true }));
                        } else {
                            throw new Error('Server returned ' + response.status);
                        }
                    })
                    .then(data => {
                        localStorage.removeItem('token');
                        sessionStorage.clear();

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

                        setTimeout(() => {
                            window.location.href = '/';
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
</body>
</html>
