@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 767px) {
    .min-vh-100 {
        padding-top: 120px !important;
        padding-bottom: 8rem !important;
    }

    /* Heading lebih kecil */
    .text-center h2 {
        font-size: 1.5rem !important;
    }

    /* Paragraf welcome */
    .text-center p {
        font-size: 0.9rem !important;
        line-height: 1.4;
        padding: 0 10px;
    }

    .card {
        transform: scale(0.95);
        margin: -5px auto !important;
        border-radius: 12px !important;
    }

    /* Body card */
    .card .card-body {
        padding: 2rem 1.5rem !important;
    }

    /* Ikon KP/TA */
    .card .bi:not(.btn i) {
        font-size: 3.5rem !important;
        margin-bottom: 1rem !important;
    }

    /* Judul card */
    .card-title {
        font-size: 1.25rem !important;
        margin-bottom: 1.5rem !important;
        letter-spacing: 0.5px;
    }

    /* Button styling */
    .card .btn {
        padding: 0.75rem 1.5rem !important;
        font-size: 1rem !important;
        border-radius: 10px !important;
        width: 90%;
        max-width: 250px;
        margin: 0 auto;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-weight: 600 !important;
    }

    /* Icon di button */
    .card .btn i {
        font-size: 1.1rem !important;
        margin: 0 !important;
    }

}
</style>

<div class="min-vh-100 d-flex align-items-center mb-0" style="background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(30, 64, 175, 0.85)), url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat; padding-top: 80px; padding-bottom: 3rem;">
    <div class="container">
        <!-- Welcome Text -->
        <div class="text-center text-white mb-5">
            <h2 class="display-5 fw-bold mb-3">Hallo, {{ $user->nama }} ({{ $user->nim }})</h2>
            <p class="lead mx-auto" style="max-width: 800px;">
                Website ini untuk mengumpulkan hasil Kerja Praktik dan Tugas Akhir mahasiswa D3 Teknik Informatika Fakultas Teknologi Informasi Universitas Kristen Satya Wacana
            </p>
        </div>

        <!-- Cards KP & TA -->
        <div class="row justify-content-center g-4">
            <!-- Kerja Praktik -->
            <div class="col-md-6 col-lg-5">
                <div class="card h-100 shadow-lg border-20 border-start border-primary border-5">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-briefcase-fill text-primary mb-4" style="font-size: 4rem;"></i>
                        <h3 class="card-title fw-bold mb-4">KERJA PRAKTIK</h3>
                        
                        @if($cekStatusKP)
                            <button class="btn btn-secondary btn-lg disabled" disabled>
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Sudah Disetujui
                            </button>
                        @else
                            <a href="{{ route('user.kp.create') }}" class="btn btn-success btn-lg">
                                <i class="bi bi-upload me-2"></i>
                                Kumpulkan
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tugas Akhir -->
            <div class="col-md-6 col-lg-5">
                <div class="card h-100 shadow-lg border-20 border-start border-success border-5">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-mortarboard-fill text-success mb-4" style="font-size: 4rem;"></i>
                        <h3 class="card-title fw-bold mb-4">TUGAS AKHIR</h3>
                        
                        @if($cekStatusTA)
                            <button class="btn btn-secondary btn-lg disabled" disabled>
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Sudah Disetujui
                            </button>
                        @else
                            <a href="{{ route('user.ta.create') }}" class="btn btn-success btn-lg">
                                <i class="bi bi-upload me-2"></i>
                                Kumpulkan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection