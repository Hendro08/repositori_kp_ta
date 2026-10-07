@extends('layouts.auth')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(30, 64, 175, 0.85)), url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logoD3TI.png') }}" alt="Logo FTI" style="height: 80px;" class="mb-3">
                            <h4 class="fw-bold mb-2">REGISTRASI FORM</h4>
                            <p class="text-muted small">Lengkapi form untuk membuat akun baru</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input id="name" type="text" class="form-control border-start-0 @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required autocomplete="name" autofocus placeholder="Masukkan nama lengkap Anda">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label fw-semibold">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </span>
                                    <input id="nim" type="text" class="form-control border-start-0 @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" required autocomplete="nim" placeholder="Masukkan NIM Anda">
                                    @error('nim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Masukkan email Anda">
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
                                    <input id="password" type="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Masukkan password Anda">
                                    <span class="input-group-text bg-light border-start-0 toggle-password-btn" style="cursor: pointer;" data-target="password">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-semibold">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control border-start-0 border-end-0" name="password_confirmation" required autocomplete="new-password" placeholder="Masukkan ulang password Anda">
                                    <span class="input-group-text bg-light border-start-0 toggle-password-btn" style="cursor: pointer;" data-target="password-confirm">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-lg fw-semibold">
                                    <i class="bi bi-person-plus me-2"></i>
                                    Daftar
                                </button>
                            </div>

                            @if (Route::has('login'))
                                <div class="text-center">
                                    <hr class="my-3">
                                    <p class="text-muted small mb-0">
                                        Sudah punya akun? 
                                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">
                                            Login Sekarang
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