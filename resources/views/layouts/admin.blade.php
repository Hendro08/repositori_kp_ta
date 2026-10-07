<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Repository D3TI') }} - Admin Panel</title>
    <link rel="icon" href="{{ asset('images/logoD3TI.png') }}" type="image/png">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --text-muted: #858796;
            --primary-soft: #e0e7ff;
            --primary-dark: #4338ca;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(30, 64, 175, 0.85));
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #ffff;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .sidebar-logo img {
            height: 60px;
        }

        .admin-profile {
            text-align: center;
            padding: 2rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            position: relative;
            overflow: hidden;
        }

        .admin-profile::before {
            content: " ";
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.35);
            z-index: 1;
        }

        .admin-profile .profile-icon {
            position: absolute;
            bottom: 10px;
            left: 10px;
            font-size: 2rem;
            color: white;
            z-index: 2;
        }

        .admin-profile img {
            width: 120px;
            height: 120px;
            border-radius: 15px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .sidebar-menu {
            flex: 1;
            padding: 1rem 0;
        }

        .sidebar-menu .nav-link {
            padding: 0.875rem 1.5rem;
            color: #4b5563;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-menu .nav-link:hover {
            background: #f9fafb;
            color: #2563eb;
            border-left-color: #2563eb;
        }

        .sidebar-menu .nav-link.active {
            background: linear-gradient(90deg, #4fd1c5 0%, #38b2ac 100%);
            color: white;
            border-left-color: #319795;
            font-weight: 600;
        }

        .sidebar-menu .nav-link i {
            font-size: 1.25rem;
            margin-right: 0.75rem;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
            margin-top: auto;
        }

        .sidebar-footer .dropdown-toggle {
            padding: 0.75rem;
            background: #f3f4f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #1f2937;
            text-decoration: none;
        }

        .sidebar-footer .dropdown-toggle:hover {
            background: #e5e7eb;
        }

        .admin-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f0f2f5;
        }

        .admin-navbar {
            display: none;
            background: linear-gradient(135deg, #2196f3, #1976d2);
            color: white;
            padding: 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .offcanvas-admin {
            width: 280px !important;
        }

        @media (max-width: 767px) {
            .admin-sidebar {
                display: none;
            }

            .admin-content {
                margin-left: 0;
                padding-top: 70px;
            }

            .admin-navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .admin-navbar .navbar-brand {
                color: white;
                font-weight: 700;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .admin-navbar .navbar-brand img {
                height: 35px;
            }

            .admin-navbar .btn-logout {
                background: red;
                border: none;
                color: white;
                padding: 0.3rem 0.8rem;
                border-radius: 8px;
                font-size: 0.9rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }

            .admin-profile .profile-icon {
                position: absolute;
                bottom: 10px;
                left: 10px;
                font-size: 2rem;
                color: white;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .admin-profile .profile-icon h5 {
                margin: 0;
                margin-top: 5px;
                font-size: 1rem;
                font-weight: 700;
            }

            .admin-profile .profile-icon i {
                font-size: 1.5rem;
            }

            .sidebar-menu .nav-link.active {
                background: rgba(33, 150, 243, 0.2);
                color: #1976d2 !important;
            }

            .btn-logout:hover {
                opacity: 0.85;
                transform: scale(1.05);
                transition: all 0.2s ease-in-out;
            }
            .admin-content {
                padding: 90px 0 1rem 0 !important;
            }
        }
        .badge-notif {
            background: #10b981;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .nav-link.active .badge-notif {
            background: rgba(255,255,255,0.3);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div id="app">
        <div class="admin-sidebar d-none d-lg-flex">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <img src="{{ asset('images/logoD3TI.png') }}" alt="Logo">
                    <span>SISTEM UPLOAD<br>KP & TA</span>
                </a>
            </div>

            <div class="admin-profile" style="background: url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat;">
                <i class="bi bi-person-fill profile-icon"></i>
            </div>

            <div class="sidebar-menu">
                @include('admin.partials.sidebar')
            </div>

            <div class="sidebar-footer">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        <div>
                            <small class="d-block text-muted">Masuk Sebagai</small>
                            <strong>{{ Auth::user()->nama }}</strong>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <nav class="admin-navbar d-lg-none">
            <button class="btn btn-link text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <i class="bi bi-list" style="font-size: 1.5rem;"></i>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                <img src="{{ asset('images/logoD3TI.png') }}" alt="Logo">
                SISTEM UPLOAD KP & TA
            </a>
            <button class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                Logout
            </button>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>
        <div class="offcanvas offcanvas-start offcanvas-admin" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Menu Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <div class="admin-profile" style="background: url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat;">
                    <div class="profile-icon">
                        <i class="bi bi-person-fill"></i>
                        <h5>ADMIN</h5>
                    </div>
                   
                </div>
                <div class="sidebar-menu">
                    @include('admin.partials.sidebar')
                </div>
            </div>
        </div>

        <main class="admin-content py-4">
            @yield('content')
        </main>
    </div>

    <script>
        document.querySelectorAll('#sidebarOffcanvas .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                const offcanvas = bootstrap.Offcanvas.getInstance(
                    document.getElementById('sidebarOffcanvas')
                );
                if(offcanvas) offcanvas.hide()
            });
        });
    </script>

</body>
</html>