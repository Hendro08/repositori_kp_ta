<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Repository D3TI') }}</title>
    <link rel="icon" href="{{ asset('images/logoD3TI.png') }}" type="image/png">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-green: #10b981;
            --dark-blue: #1e40af;
            --light-bg: #f8fafc;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
        }

        .navbar-custom {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 0.4rem 0;
            z-index: 9999;
            transition: all 0.3s ease;
        }

        .navbar-transparent {
            background: transparent !important;
            box-shadow: none !important;
        }

        .navbar-solid {
            background: white !important;
            box-shadow: 0 10px 10px rgba(0,0,0,0.08) !important;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: color 0.3s ease;
        }

        .navbar-solid .navbar-brand,
        .navbar-brand {
            color: #1f2937 !important;
        }

        .navbar-transparent .navbar-brand {
            color: white !important;
        }

        .logo-circle {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        @media (max-width: 767px) {
            .navbar .container{
                justify-content: center !important;
                position: relative;
            }

            .mobile-notif-icon {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #1f2937;
            }

            .mobile-badge {
                position: absolute;
                top: -5px;
                right: -6px;
                background: #dc3545;
                color: white;
                font-size: 0.55rem;
                font-weight: bold;
                padding: 1px 4px;
                border-radius: 10px;
                line-height: 1;
            }

        
            .navbar-transparent .mobile-notif-icon {
                color: white;
            }

            .navbar-custom {
                padding: 0.5rem 0;
            }

            .navbar-custom .container {
                display: flex;
                justify-content: space-between !important;
                align-items: center;
            }

            .navbar-brand {
                margin-left: auto;
                margin-right: auto;
                text-align: center;
            }

            .navbar-brand img {
                height: 45px !important;
            }

            .navbar-brand span {
                max-width: 100px;
                font-size: 0.65rem;
                line-height: 1.2;
            }

            .logo-circle {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }

            .btn-login {
                padding: 0.3rem 0.6rem;
                font-size: 0.7rem;
                border-radius: 5px;
            }

            .hamburger-icon {
                font-size: 1.5rem;
                color: #1f2937;
                transition: color 0.3s ease;
            }

            .navbar-transparent .hamburger-icon {
                color: white !important;
            }

            .navbar-solid .hamburger-icon {
                color: #1f2937 !important;
            }

            .navbar-toggler {
                display: block !important;
                border: none;
                padding: 0.25rem 0.5rem;
                font-size: 18px
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }

            body.guest-page .navbar-toggler {
                display: none !important;
            }

            body.guest-page .navbar-collapse {
                display: flex !important;
                justify-content: flex-end !important;
                flex-basis: auto !important;
            }

            body.guest-page .navbar-nav.me-auto {
                display: none !important;
            }

            body.guest-page .navbar-nav.ms-auto {
                flex-direction: row !important;
                align-items: center;
                margin-left: auto;
            }

            body.guest-page .navbar-nav.ms-auto .nav-item {
                margin: 0;
            }

            .footer .col-md-4 {
                text-align: center;
            }
        
            .footer-logo {
                width: 60px;
                height: 60px;
                margin-bottom: 0.75rem;
            }
        
            .footer-title {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }
        
            .footer-text {
                font-size: 0.85rem;
                line-height: 1.4;
                margin-bottom: 0.5rem;
            }
        
            /* Link margin kecil */
            .footer-link {
                margin-bottom: 0.3rem;
            }
        
            .footer-bottom {
                font-size: 0.75rem;
                margin-top: 1.5rem;
                padding-top: 0.75rem;
            }
        
            .footer {
                padding: 1.5rem 0 0.5rem;
            }

            div.swal2-popup {
                font-size: 0.8rem !important; 
                width: 90% !important;       
                padding: 1em !important;    
            }
            
            div.swal2-title {
                font-size: 1.4em !important; 
            }

            div.swal2-confirm, div.swal2-cancel {
                width: 100% !important;      
                margin: 5px 0 !important;   
                padding: 10px !important;    
            }
            
            div.swal2-actions {
                flex-direction: column;     
                width: 100% !important;
            }

        }

        .offcanvas {
            width: 280px !important;
             z-index: 99999 !important;
        }

        .offcanvas-header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
        }

        .offcanvas-body {
            padding: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu .nav-item {
            border-bottom: 1px solid #e5e7eb;
        }

        .sidebar-menu .nav-link {
            padding: 1rem 1.5rem;
            color: #1f2937 !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background: #f3f4f6;
            color: #2563eb !important;
        }

        .sidebar-menu .nav-link i {
            font-size: 1.2rem;
            width: 24px;
        }

        .sidebar-logout {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem;
            background: #f9fafb;
        }

        .sidebar-logout .btn {
            width: 100%;
        }

        .nav-link {
            color: #4b5563 !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s ease;
        }

        .navbar-transparent .nav-link {
            color: white !important;
        }

        .navbar-transparent .nav-link:hover {
            color: #ffffff !important;
            text-shadow: 0 0 6px rgba(255, 255, 255, 0.7);
        }

        .navbar-solid .nav-link {
            position: relative;
            transition: color 0.2s ease;
        }

        .navbar-solid .nav-link:hover {
            color: #1e40af !important;
        }

        .btn-login {
            background: var(--primary-green);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .notification-bell {
            position: relative;
            font-size: 1.3rem;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .navbar-transparent .notification-bell {
            color: white;
        }

        .notification-bell:hover {
            color: var(--primary-blue);
        }

        .dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            transition: background 0.2s ease;
        }

        .dropdown-item:hover {
            background: var(--light-bg);
        }

        main {
            min-height: calc(100vh - 76px);
            padding-top: 0 !important;
            margin: 0 !important;
        }


        .footer {
            background: #1f2937;
            color: white;
            padding: 2rem 0 1rem;
            margin-top: 0;
        }

        .footer a {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        .footer-logo {
            width: 80px;
            margin-bottom: 1rem;
        }

        .footer-title {
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .footer-text {
            color: #9ca3af;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .footer-link {
            display: block;
            margin-bottom: 0.5rem;
            color: #9ca3af;
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            margin-top: 2rem;
            padding-top: 1rem;
            text-align: center;
            color: #9ca3af;
            font-size: 0.85rem;
        }


        
    </style>
</head>
<body class="{{ Auth::guest() && Request::is('/') ? 'guest-page' : '' }}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-custom navbar-transparent" id="mainNavbar">
            <div class="container">
                @auth
                    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                        <i class="bi bi-list hamburger-icon"></i>
                    </button>
                    <a href="{{ route('user.notifications') }}"
                       class="mobile-notif-icon d-md-none ms-auto">
                        <i class="bi bi-bell-fill" style="font-size: 1rem;"></i>
                        @if($unreadNotifications > 0)
                            <span class="mobile-badge">{{ $unreadNotifications }}</span>
                        @endif
                    </a>
                @endauth

                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logoD3TI.png') }}" alt="Logo FTI UKSW" style="height: 50px;">
                    <span>SISTEM UPLOAD KP & TA</span>
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="btn btn-login" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            @if(Auth::user()->role == 'user')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.home') }}">HOME</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        HISTORY
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('user.history.kp') }}"><i class="bi bi-briefcase-fill text-primary me-2"></i> Kerja Praktik</a></li>
                                        <li><a class="dropdown-item" href="{{ route('user.history.ta') }}"><i class="bi bi-mortarboard-fill text-success me-2"></i> Tugas Akhir</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ strtoupper(Auth::user()->nama) }}

                                    @if($unreadNotifications > 0)
                                        <span class="badge bg-danger rounded-pill position-absolute"
                                              style="top: 2px; right: -10px; font-size: 0.6em;">
                                            {{ $unreadNotifications }}
                                        </span>
                                    @endif
                                </a>
        
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role == 'admin')
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endif

                                    <a class="dropdown-item position-relative" href="{{ route('user.notifications') }}">
                                        <i class="bi bi-bell-fill me-2"></i>
                                        Notifikasi

                                        @if($unreadNotifications > 0)
                                            <span class="badge bg-danger rounded-pill position-absolute"
                                                  style="right: 15px; top: 50%; transform: translateY(-50%); font-size: 0.7em;">
                                                {{ $unreadNotifications }}
                                            </span>
                                        @endif
                                    </a>
        
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                                    </a>
        
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @auth
            @if(Auth::user()->role == 'user')
            <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header">
                    <div>
                        <h5 class="mb-0" id="sidebarMenuLabel">Menu</h5>
                        <small>{{ Auth::user()->nama }}</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <ul class="sidebar-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user/home') ? 'active' : '' }}" href="{{ route('user.home') }}">
                                <i class="bi bi-house-door-fill"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user/history/kp') ? 'active' : '' }}" href="{{ route('user.history.kp') }}">
                                <i class="bi bi-briefcase-fill"></i>
                                <span>History Kerja Praktik</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user/history/ta') ? 'active' : '' }}" href="{{ route('user.history.ta') }}">
                                <i class="bi bi-mortarboard-fill"></i>
                                <span>History Tugas Akhir</span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-logout">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        @endauth

        <main>
            @yield('content')
        </main>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <img src="{{ asset('images/logoD3TI.png') }}" alt="Logo FTI" class="footer-logo" style="height: 135px; width: 135px;">
                        <h5 class="footer-title">D3 Teknik Informatika</h5>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5 class="footer-title">Fakultas Teknologi Informasi</h5>
                        <p class="footer-text">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Gedung Fakultas Teknologi Informasi<br>
                            Kampus III Universitas Kristen Satya Wacana<br>
                            Jl. Dr. O. Notohamidjojo, Blotongan, Sidorejo,<br>
                            Kota Salatiga, 50715, Indonesia
                        </p>
                        <h5 class="footer-title">Email</h5>
                        <p class="footer-text">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <a href="mailto:fti@uksw.edu">fti@uksw.edu</a>
                        </p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5 class="footer-title">Tentang Sistem</h5>
                        <p class="footer-text">
                            Sistem repository untuk pengumpulan dan pengelolaan dokumen Tugas Akhir dan Kerja Praktik mahasiswa Program Studi D3 Teknik Informatika.
                        </p>
                    </div>
                </div>
                <div class="footer-bottom">
                    © 2025 Project Repository D3 TI UKSW. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener("scroll", function () {
            const navbar = document.getElementById("mainNavbar")

            if (window.scrollY > 50) {
                navbar.classList.add("navbar-solid")
                navbar.classList.remove("navbar-transparent")
            } else {
                navbar.classList.add("navbar-transparent")
                navbar.classList.remove("navbar-solid")
            }
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                timer: 4000, 
                timerProgressBar: true 
            })
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            })
        @endif
    </script>
</body>
</html>