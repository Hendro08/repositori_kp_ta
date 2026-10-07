@extends('layouts.auth')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(30, 64, 175, 0.85)), url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logoD3TI.png') }}" alt="Logo FTI" style="height: 80px;" class="mb-3">
                            <h4 class="fw-bold mb-2">LOGIN REPOSITORI D3 TI</h4>
                            <p class="text-muted small">Silakan login ke akun Anda</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email Anda">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                                    <span class="input-group-text bg-light border-start-0 toggle-password-btn" data-target = "password" style="cursor: pointer;">
                                        <i class="bi bi-eye-slash toggle-icon"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-end mb-4">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none small text-primary">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-lg fw-semibold">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Login
                                </button>
                            </div>

                            @if (Route::has('register'))
                                <div class="text-center">
                                    <hr class="my-3">
                                    <p class="text-muted small mb-0">
                                        Belum punya akun? 
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">
                                            Daftar Sekarang
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="text-white text-decoration-none">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection