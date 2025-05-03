<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Dapat Di Akses - 403</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-404 {
            background: linear-gradient(135deg, #f0fdff 0%, #e0f7fa 100%);
        }
        .primary-color {
            color: #00b8d4;
        }
        .primary-bg {
            background-color: #00b8d4;
        }
        .primary-border {
            border-color: #00b8d4;
        }
        .primary-hover:hover {
            background-color: #00a3bc;
        }
        .animation-float {
            animation: float 6s ease-in-out infinite;
        }
        .animation-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        @keyframes tear-drop {
            0% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(20px); opacity: 0; }
        }
        .tear-drop {
            animation: tear-drop 1.5s infinite ease-out;
        }
        .svg-container {
            position: relative;
            display: inline-block;
        }
    </style>
</head>
<body class="bg-404 min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto text-center">
            <!-- Animasi SVG yang lebih menarik -->
            <div class="animation-float mb-8 svg-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 200 200" class="mx-auto">
                    <!-- Background circle -->
                    <circle cx="100" cy="100" r="90" fill="#00b8d4" opacity="0.1"/>

                    <!-- Floating dots -->
                    <circle cx="40" cy="40" r="3" fill="#00b8d4" class="animation-float" style="animation-delay: 0.3s; animation-duration: 5s"/>
                    <circle cx="160" cy="50" r="4" fill="#00b8d4" class="animation-float" style="animation-delay: 0.7s; animation-duration: 7s"/>
                    <circle cx="30" cy="150" r="3" fill="#00b8d4" class="animation-float" style="animation-delay: 1s; animation-duration: 6s"/>
                    <circle cx="100" cy="20" r="3" fill="#00b8d4" class="animation-float" style="animation-delay: 0.3s; animation-duration: 5s"/>
                    <circle cx="160" cy="180" r="4" fill="#00b8d4" class="animation-float" style="animation-delay: 0.7s; animation-duration: 7s"/>
                    <circle cx="30" cy="150" r="3" fill="#00b8d4" class="animation-float" style="animation-delay: 1s; animation-duration: 6s"/>

                    <!-- Baby image centered in the circle and enlarged -->
                    <image href="image/baby.png" x="30" y="30" width="160" height="160" class="animation-float" style="animation-duration: 7s"/>
                </svg>
            </div>

            <h1 class="text-5xl font-bold primary-color mb-4">403</h1>
<h2 class="text-2xl font-semibold text-gray-800 mb-6">Oops! Akses Ditolak</h2>
<p class="text-gray-600 mb-8">
    Sepertinya kamu mencoba masuk ke pesta VIP tanpa undangan. Tenang, kita bisa pulang dan cari acara lain yang lebih ramah!
</p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ url('/') }}" class="px-6 py-3 primary-bg text-white rounded-lg shadow hover:primary-hover transition duration-300 transform hover:scale-105">
                    <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                </a>
                <a href="javascript:history.back()" class="px-6 py-3 primary-border border text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali Sebelumnya
                </a>
            </div>
        </div>
    </div>

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</body>
</html>


