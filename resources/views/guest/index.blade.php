@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 767px) {
        .search-input {
            font-size: 0.8rem !important;
            padding: 0.5rem 0.75rem !important;
        }
        
        .search-input::placeholder {
            font-size: 0.75rem;
        }
        
        .search-btn {
            font-size: 0.8rem !important;
            padding: 0.5rem 0.75rem !important;
        }
        
        .search-text {
            display: none;
        }
        
        .search-btn i {
            margin: 0 !important;
        }
    }

    html {
        scroll-behavior: smooth;
    }

    .btn-lihat-dokumen {
        background: white;
        color: #2563eb;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .btn-lihat-dokumen:hover {
        background: #f0f9ff;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        color: #1e40af;
    }

    #dokumen-section {
        scroll-margin-top: 100px;
        margin-bottom: 150px
    }
</style>


<div class="position-relative text-white d-flex align-items-center" style="background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(30, 64, 175, 0.85)), url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat; min-height: 100vh;">
    <div class="container">
        <div class="text-center">
            <h1 class="display-5 fw-bold mb-3">Selamat Datang Di Sistem Pengumpulan Dokumen<br>Tugas Akhir Dan Kerja Praktik</h1>
            <p class="lead mb-4">Repositori untuk dokumen Tugas Akhir dan Kerja Praktik Program Studi D3 Teknik Informatika Fakultas Teknologi Informasi Universitas Kristen Satya Wacana</p>
            <a href="#dokumen-section" class="btn btn-lihat-dokumen">
                <i class="bi bi-arrow-down-circle me-2"></i>
                Lihat Dokumen
            </a>
        </div>
    </div>
</div>

<div class="container pb-5 pt-5" id="dokumen-section">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            <div class="text-center mb-4">
                <h4 class="fw-bold">List Dokumen Kerja Praktik dan Tugas Akhir</h4>
                <p class="text-muted">Pilih kategori dokumen yang ingin Anda lihat</p>
            </div>

            <div class="mb-4">
                <form method="GET" action="{{ route('guest.index') }}">
                    <div class="input-group shadow-sm">
                        <input type="text" class="form-control form-control-lg search-input" name="search" placeholder="Cari berdasarkan Nama Mahasiswa, NIM, atau Judul..." value="{{ $search ?? '' }}">
                        <button class="btn btn-primary btn-lg search-btn" type="submit">
                            <i class="bi bi-search me-1"></i> <span class="search-text">Cari</span>
                        </button>
                    </div>
                </form>
            </div>

            <ul class="nav nav-tabs nav-fill mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="kp-tab" data-bs-toggle="tab" data-bs-target="#kp-tab-pane" type="button" role="tab" aria-controls="kp-tab-pane" aria-selected="true">
                        <i class="bi bi-briefcase-fill me-2"></i>
                        Kerja Praktik
                        <span class="badge bg-success ms-2">{{ $data_kp->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="ta-tab" data-bs-toggle="tab" data-bs-target="#ta-tab-pane" type="button" role="tab" aria-controls="ta-tab-pane" aria-selected="false">
                        <i class="bi bi-mortarboard-fill me-2"></i>
                        Tugas Akhir
                        <span class="badge bg-success ms-2">{{ $data_ta->count() }}</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kp-tab-pane" role="tabpanel" aria-labelledby="kp-tab" tabindex="0">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-briefcase-fill me-2"></i>
                                Daftar Kerja Praktik
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col" style="width: 5%;">No</th>
                                            <th scope="col" style="width: 12%;">NIM</th>
                                            <th scope="col" style="width: 20%;">Nama Mahasiswa</th>
                                            <th scope="col" style="width: 40%;">Judul</th>
                                            <th scope="col" style="width: 23%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data_kp as $index => $kp)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $kp->user->nim ?? 'N/A' }}</td>
                                            <td>{{ $kp->user->nama ?? 'N/A' }}</td>
                                            <td class="fw-semibold">{{ $kp->judul }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $kp->abstrak_file) }}" class="btn btn-success btn-sm" target="_blank">
                                                    <i class="bi bi-download me-1"></i>
                                                    Download Abstrak
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                                <p class="text-muted">Belum ada data Kerja Praktik yang disetujui</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="ta-tab-pane" role="tabpanel" aria-labelledby="ta-tab" tabindex="0">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-mortarboard-fill me-2"></i>
                                Daftar Tugas Akhir
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col" style="width: 5%;">No</th>
                                            <th scope="col" style="width: 12%;">NIM</th>
                                            <th scope="col" style="width: 20%;">Nama Mahasiswa</th>
                                            <th scope="col" style="width: 40%;">Judul</th>
                                            <th scope="col" style="width: 23%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data_ta as $index => $ta)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $ta->user->nim ?? 'N/A' }}</td>
                                            <td>{{ $ta->user->nama ?? 'N/A' }}</td>
                                            <td class="fw-semibold">{{ $ta->judul }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $ta->abstrak_file) }}" class="btn btn-success btn-sm" target="_blank">
                                                    <i class="bi bi-download me-1"></i>
                                                    Download Abstrak
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                                <p class="text-muted">Belum ada data Tugas Akhir yang disetujui</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection