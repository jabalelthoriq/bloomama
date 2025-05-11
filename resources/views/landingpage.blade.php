<?php
// resources/views/landingpage.blade.php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomama - Pendamping Setia Ibu Hamil</title>
    <style>
        /* Your existing CSS styles remain the same */
        :root {
            --primary: #11B3CF;
            --dark: #333333;
            --light: #ffffff;
            --secondary: #F5F9FA;
            --accent: #FF85A2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
            margin: 0; /* Ensure no margin on body */
            padding: 0; /* Ensure no padding on body */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            padding: 20px 0;
            background-color: var(--light);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 24px;
            color: var(--primary);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
            cursor: pointer;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: width 0.3s;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-links a.active {
            color: var(--primary);
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--dark);
        }

        /* Hero Section */
        .hero {
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .hero-text {
            flex: 1;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 48px;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-text h1 span {
            color: var(--primary);
        }

        .hero-text p {
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #666;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .hero-image {
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .hero-image img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 40px;
            height: 40px;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
        }

        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: var(--secondary);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 36px;
            margin-bottom: 15px;
        }

        .section-header p {
            font-size: 18px;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background-color: rgba(17, 179, 207, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .feature-icon svg {
            width: 35px;
            height: 35px;
            color: var(--primary);
        }

        .feature-card h3 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* About Us Section */
        .about-us {
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .about-content {
            display: flex;
            align-items: center;
            gap: 60px;
        }

        .about-image {
            flex: 1;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .about-text {
            flex: 1;
        }

        .about-text h2 {
            font-size: 36px;
            margin-bottom: 20px;
            position: relative;
        }

        .about-text h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--primary);
        }

        .about-text p {
            font-size: 16px;
            line-height: 1.8;
            color: #666;
            margin-bottom: 20px;
        }

        .mission-vision {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }

        .mission, .vision {
            flex: 1;
            background-color: var(--secondary);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .mission h3, .vision h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .mission p, .vision p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* Contact Us Section */
        .contact-us {
            padding: 80px 0;
            background-color: var(--secondary);
        }

        .contact-content {
            display: flex;
            gap: 50px;
        }

        .contact-info {
            flex: 1;
        }

        .contact-info h2 {
            font-size: 36px;
            margin-bottom: 20px;
            position: relative;
        }

        .contact-info h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--primary);
        }

        .contact-info p {
            font-size: 16px;
            line-height: 1.8;
            color: #666;
            margin-bottom: 30px;
        }

        .contact-details {
            margin-bottom: 30px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(17, 179, 207, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .contact-text h4 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .contact-text p {
            font-size: 14px;
            margin-bottom: 0;
        }

        .contact-form {
            flex: 1;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-logo {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-about p {
            line-height: 1.6;
            margin-bottom: 20px;
            color: #ccc;
        }

        .footer-heading {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #ccc;
            font-size: 14px;
        }

        /* Mobile responsive */
        @media (max-width: 992px) {
            .hero-content, .about-content, .contact-content {
                flex-direction: column;
            }

            .features-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }

            .mission-vision {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                position: fixed;
                top: 80px;
                left: 0;
                width: 100%;
                flex-direction: column;
                gap: 0;
                background-color: white;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                padding: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out;
            }

            .nav-links.show {
                max-height: 400px;
            }

            .nav-links a {
                padding: 15px 20px;
                display: block;
                border-bottom: 1px solid #eee;
            }

            .nav-links a::after {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .auth-buttons {
                display: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 36px;
            }
        }

      /* Animasi Fade */
.fade-in {
    opacity: 0;
    animation: fadeIn 2s ease forwards;
}

.fade-out {
    opacity: 1;
    animation: fadeOut 2s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}

/* Variasi fade dengan gerakan */
.fade-in-up {
    opacity: 0;
    transform: translateY(50px);
    animation: fadeInUp 1.5s ease forwards;
}

.fade-in-down {
    opacity: 0;
    transform: translateY(-50px);
    animation: fadeInDown 1.5s ease forwards;
}

.fade-in-left {
    opacity: 0;
    transform: translateX(-50px);
    animation: fadeInLeft 1.5s ease forwards;
}

.fade-in-right {
    opacity: 0;
    transform: translateX(50px);
    animation: fadeInRight 1.5s ease forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Animasi dengan delay */
.delay-100 { animation-delay: 0.1s; }
.delay-200 { animation-delay: 0.2s; }
.delay-300 { animation-delay: 0.3s; }
.delay-400 { animation-delay: 0.4s; }
.delay-500 { animation-delay: 0.5s; }
.delay-600 { animation-delay: 0.6s; }

    </style>
</head>
<body>
    <!-- Scroll to top button -->
    <div class="scroll-top">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </div>

    <!-- Header -->
    <header id="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <div>
                        <img src="{{ asset('image/logo.png') }}" alt="Logo">
                    </div>
                    Bloomama
                </div>
                <div class="nav-links">
                    <a href="#beranda" class="nav-link active" data-section="beranda">Beranda</a>
                    <a href="#fitur" class="nav-link" data-section="fitur">Fitur</a>
                    <a href="#about-us" class="nav-link" data-section="about-us">About Us</a>
                    <a href="#contact-us" class="nav-link" data-section="contact-us">Contact Us</a>
                </div>
                <div class="auth-buttons">
                    <a href="login" class="btn btn-outline">Login</a>
                </div>
                <button class="mobile-menu-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Temani Perjalanan <span>Kehamilan Anda</span> Dengan Informasi Terpercaya</h1>
                <p>Bloomama hadir sebagai sahabat terpercaya untuk ibu hamil, memberikan informasi terkini, tips kesehatan, dan dukungan selama masa kehamilan hingga persalinan.</p>
                <div class="hero-buttons">
                    <a href="#" class="btn btn-primary">Unduh Aplikasi</a>

                </div>
            </div>
            <div class="hero-image">
                <div id="animation-container" style="width: 100%; height: 400px;"></div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="shape shape-circle primary"></div>
        <div class="shape shape-circle secondary"></div>
        <div class="shape shape-ring left"></div>
    </section>

    <!-- Features Section -->
    <section class="features" id="fitur">
        <div class="container">
            <div class="section-header">
                <h2>Fitur Unggulan Bloomama</h2>
                <p>Dapatkan berbagai manfaat untuk mendukung perjalanan kehamilan Anda dengan fitur-fitur terbaik kami</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3>Artikel Kesehatan</h3>
                    <p>Dapatkan informasi kesehatan terkini dari para ahli kandungan dan dokter spesialis anak untuk mendukung kehamilan sehat.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3>Perkembangan Janin</h3>
                    <p>Pantau perkembangan janin Anda dari minggu ke minggu dengan informasi detail dan visualisasi yang lengkap.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <h3>Konsultasi Online</h3>
                    <p>Konsultasikan kehamilan Anda dengan dokter spesialis kandungan terpercaya tanpa perlu keluar rumah.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3>Nutrisi & Diet</h3>
                    <p>Dapatkan rekomendasi nutrisi dan menu makanan sehat yang dibutuhkan selama masa kehamilan.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3>Pengingat & Jadwal</h3>
                    <p>Atur jadwal pemeriksaan kehamilan, kontrol dokter, dan pengingat konsumsi vitamin penting.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3>Komunitas Ibu Hamil</h3>
                    <p>Bergabung dengan komunitas ibu hamil untuk berbagi pengalaman dan mendapatkan dukungan selama kehamilan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-us" id="about-us">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Tentang Bloomama</h2>
                    <p>Bloomama adalah platform digital kesehatan ibu hamil terdepan di Indonesia. Didirikan pada tahun 2023, kami berkomitmen untuk memberikan pendampingan terbaik bagi ibu hamil di seluruh Indonesia melalui teknologi yang inovatif dan tim medis yang berpengalaman.</p>
                    <p>Dengan lebih dari 100 dokter spesialis kandungan dan 50 bidan profesional, kami telah membantu lebih dari 10.000 ibu hamil menjalani kehamilan yang sehat dan aman. Bloomama hadir sebagai solusi untuk memudahkan akses informasi kesehatan maternal yang terpercaya.</p>

                    <div class="mission-vision">
                        <div class="mission">
                            <h3>Misi Kami</h3>
                            <p>Menyediakan informasi kesehatan terpercaya dan dukungan yang komprehensif untuk setiap ibu hamil di Indonesia, memastikan perjalanan kehamilan yang sehat dan aman hingga persalinan.</p>
                        </div>
                        <div class="vision">
                            <h3>Visi Kami</h3>
                            <p>Menjadi platform kesehatan maternal terpercaya yang dapat diakses oleh semua ibu hamil di Indonesia, menurunkan angka kematian ibu dan bayi melalui edukasi dan layanan kesehatan yang berkualitas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section class="contact-us" id="contact-us">
        <div class="container">
            <div class="section-header">
                <h2>Hubungi Kami</h2>
                <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, tim kami siap membantu Anda</p>
            </div>

            <div class="contact-content">
                <div class="contact-info">
                    <h2>Informasi Kontak</h2>
                    <p>Kami senang mendengar dari Anda. Silakan hubungi kami melalui informasi berikut atau isi formulir untuk mengirimkan pesan langsung.</p>

                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="contact-text">
                                <h4>Telepon</h4>
                                <p>+62 21 1234 5678</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h4>Email</h4>
                            <p>info@Bloomama.id</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h4>Alamat</h4>
                            <p>Jl. Kesehatan No. 123, Jakarta Selatan, Indonesia</p>
                        </div>
                    </div>
                </div>

                <div class="social-media">
                    <h4>Ikuti Kami</h4>
                    <div class="social-icons" style="display: flex; gap: 15px; margin-top: 10px;">
                        <a href="#" style="color: var(--primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="#" style="color: var(--primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="#" style="color: var(--primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h3 style="margin-bottom: 20px; font-size: 24px;">Kirim Pesan</h3>
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" id="subject" name="subject" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" name="message" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</section>



<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-about">
                <div class="footer-logo">
                    <div >
            <img src="{{ asset('image/logo.png') }}" alt="Logo">
        </div>
                    Bloomama
                </div>
                <p>Platform pendamping kehamilan terpercaya yang menyediakan informasi kesehatan ibu hamil, perkembangan janin, dan konsultasi dengan dokter spesialis.</p>
            </div>

            <div class="footer-links-section">
                <h3 class="footer-heading">Menu</h3>
                <ul class="footer-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#about-us">Tentang Kami</a></li>
                    <li><a href="#contact-us">Kontak</a></li>
                </ul>
            </div>

            <div class="footer-links-section">
                <h3 class="footer-heading">Fitur</h3>
                <ul class="footer-links">
                    <li><a href="#">Artikel Kesehatan</a></li>
                    <li><a href="#">Perkembangan Janin</a></li>
                    <li><a href="#">Konsultasi Online</a></li>
                    <li><a href="#">Komunitas Ibu Hamil</a></li>
                </ul>
            </div>

            <div class="footer-links-section">
                <h3 class="footer-heading">Dukungan</h3>
                <ul class="footer-links">
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2025 Bloomama. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- JavaScript for toggle menu and scroll to top -->
<script>
     // Fungsi untuk mengaktifkan animasi fade saat elemen terlihat di viewport
     document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan kelas untuk elemen yang ingin dianimasikan
        const heroText = document.querySelector('.hero-text');
        heroText.classList.add('fade-in-left');

        const heroImage = document.querySelector('.hero-image');
        heroImage.classList.add('fade-in-right');

        // Observer untuk animasi saat scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, {threshold: 0.2});

        // Terapkan untuk elemen-elemen yang ingin dianimasikan saat scroll
        document.querySelectorAll('.feature-card').forEach((card, index) => {
            card.classList.add('delay-' + ((index % 6) + 1) + '00');
            observer.observe(card);
        });

        document.querySelectorAll('.section-header').forEach(header => {
            header.classList.add('fade-in-up');
            observer.observe(header);
        });

        document.querySelectorAll('.about-text, .about-image').forEach(element => {
            element.classList.add('fade-in-up');
            observer.observe(element);
        });

        document.querySelectorAll('.mission, .vision').forEach((element, index) => {
            element.classList.add('fade-in-up');
            element.classList.add('delay-' + ((index + 1) * 2) + '00');
            observer.observe(element);
        });

        document.querySelectorAll('.contact-info, .contact-form').forEach((element, index) => {
            element.classList.add('fade-in');
            element.classList.add('delay-' + ((index + 1) * 2) + '00');
            observer.observe(element);
        });
    });
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');

    mobileMenuBtn.addEventListener('click', () => {
        navLinks.classList.toggle('show');
    });

    // Scroll to top button
    const scrollTopBtn = document.querySelector('.scroll-top');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollTopBtn.classList.add('active');
        } else {
            scrollTopBtn.classList.remove('active');
        }
    });

    scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Active nav link
    const sections = document.querySelectorAll('section');
    const navItems = document.querySelectorAll('.nav-link');

    window.addEventListener('scroll', () => {
        let current = '';

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;

            if (window.pageYOffset >= (sectionTop - sectionHeight / 3)) {
                current = section.getAttribute('id');
            }
        });

        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-section') === current) {
                item.classList.add('active');
            }
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    lottie.loadAnimation({
        container: document.getElementById('animation-container'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '{{ asset("animation/landingpage.json") }}'
    });
});
</script>

<script>
    // Handle navbar click events for smooth scrolling and animations
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();

        // Get the target section
        const targetId = this.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);

        // Smooth scroll to the section
        window.scrollTo({
            top: targetSection.offsetTop - 80, // Adjust for header height
            behavior: 'smooth'
        });

        // Reset animations on the target section elements
        resetAndTriggerAnimations(targetId);
    });
});

// Function to reset and trigger animations for a specific section
function resetAndTriggerAnimations(sectionId) {
    // Define elements to animate based on section
    let elementsToAnimate = [];

    switch(sectionId) {
        case 'beranda':
            elementsToAnimate = [
                { element: document.querySelector('.hero-text'), classes: ['fade-in-left'] },
                { element: document.querySelector('.hero-image'), classes: ['fade-in-right'] }
            ];
            break;
        case 'fitur':
            elementsToAnimate = [
                { element: document.querySelector('#fitur .section-header'), classes: ['fade-in-up'] }
            ];
            // Add feature cards with delay
            document.querySelectorAll('#fitur .feature-card').forEach((card, index) => {
                elementsToAnimate.push({
                    element: card,
                    classes: ['fade-in', `delay-${((index % 6) + 1)}00`]
                });
            });
            break;
        case 'about-us':
            elementsToAnimate = [
                { element: document.querySelector('.about-text'), classes: ['fade-in-up'] },
                { element: document.querySelector('.mission'), classes: ['fade-in-up', 'delay-200'] },
                { element: document.querySelector('.vision'), classes: ['fade-in-up', 'delay-400'] }
            ];
            break;
        case 'contact-us':
            elementsToAnimate = [
                { element: document.querySelector('#contact-us .section-header'), classes: ['fade-in-up'] },
                { element: document.querySelector('.contact-info'), classes: ['fade-in', 'delay-200'] },
                { element: document.querySelector('.contact-form'), classes: ['fade-in', 'delay-400'] }
            ];
            break;
    }

    // Reset and trigger animations
    elementsToAnimate.forEach(item => {
        if (item.element) {
            // Reset by removing classes
            item.element.classList.remove(...item.classes);

            // Force reflow
            void item.element.offsetWidth;

            // Add classes back to trigger animation
            setTimeout(() => {
                item.element.classList.add(...item.classes);
            }, 10);
        }
    });
}
</script>

  </body>
  </html>
