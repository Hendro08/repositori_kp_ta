<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Repository D3TI') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoD3TI.png') }}">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtns = document.querySelectorAll(".toggle-password-btn");
            toggleBtns.forEach(function (toggleBtn) {
                toggleBtn.addEventListener("click", function () {
                    const targetId = this.getAttribute("data-target");
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector("i");
                    const type =
                        passwordInput.getAttribute("type") === "password"
                            ? "text"
                            : "password";
                    passwordInput.setAttribute("type", type);
                    if (type === "password") {
                        icon.classList.remove("bi-eye");
                        icon.classList.add("bi-eye-slash");
                    } else {
                        icon.classList.remove("bi-eye-slash");
                        icon.classList.add("bi-eye");
                    }
                });
            });
        });
    </script>
</body>
</html>