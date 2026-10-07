@extends('layouts.app')

@section('content')
<style>
    .modern-container {
        max-width: 1100px;
        padding-top: 40px;
        padding-bottom: 40px;
    }

    /* Card modern */
    .card {
        border: none !important;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* Card header modern */
    .card-header {
        padding: 1.1rem 1.5rem;
        font-weight: 600;
        border: none !important;
        font-size: 1.2rem;
    }

    /* Input modern */
    .form-control {
        border-radius: 8px;
        padding: 0.7rem;
        border: 1px solid #d1d5db;
        transition: 0.2s ease;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    /* Label modern */
    .form-label {
        font-weight: 600;
        color: #374151;
    }

    /* Buttons */
    .btn {
        padding: 0.55rem 1.1rem;
        font-weight: 600;
        border-radius: 8px;
    }

    .btn-primary {
        background-color: #2563eb;
        border-color: #2563eb;
    }

    .btn-primary:hover {
        background-color: #1e40af;
    }

    /* Footer card */
    .card-footer {
        border-top: 1px solid #e5e7eb !important;
        padding: 1rem 1.5rem;
    }

    /* Mobile styling */
    @media (max-width: 576px) {
         /* Card mengecil */
        .card {
            transform: scale(0.95);
            border-radius: 12px;
        }

        /* Header card */
        .card-header h4 {
            font-size: 1.1rem !important;
        }

        /* Body card padding lebih kecil */
        .card-body {
            padding: 1.2rem !important;
        }

        /* Label form lebih kecil */
        .form-label {
            font-size: 0.85rem !important;
            margin-bottom: 4px;
        }

        /* Input, textarea lebih kecil */
        .form-control {
            font-size: 0.85rem !important;
            padding: 0.45rem 0.7rem !important;
        }

        /* Textarea height lebih pendek */
        textarea.form-control {
            min-height: 90px !important;
        }

        /* Text helper (file saat ini) */
        .form-text {
            font-size: 0.75rem !important;
        }

        /* Footer tombol lebih kecil */
        .footer-actions .action-btn {
            font-size: 0.85rem !important;
            padding: 0.6rem !important;
            border-radius: 6px !important;
        }

        /* Icon tombol diperkecil */
        .footer-actions .action-btn i {
            font-size: 0.95rem !important;
        }

        .swal2-popup {
            width: 90% !important;
            padding: 1.2rem !important;
            font-size: 0.9rem !important;
        }

        .swal2-title {
            font-size: 1.2rem !important;
        }

        .swal2-actions button {
            width: 100% !important;
            margin: 5px 0 !important;
        }
    }
</style>
<div class="min-vh-100 d-flex align-items-center mb-0" style="background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(30, 64, 175, 0.85)), url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat; padding-top: 45px; padding-bottom: 3rem;">
    <div class="container modern-container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Revisi Kerja Praktik</h4>
                    </div>
                    
                    <form id="kpForm" action="{{ route('user.kp.update_revisi', $kp->id_kp) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Kerja Praktik</label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $kp->judul ?? '') }}">
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="mb-3">
                                        <label for="pembimbing" class="form-label">Daftar Pembimbing Akademik</label>
                                        <input type="text" class="form-control @error('pembimbing') is-invalid @enderror" id="pembimbing" name="pembimbing" value="{{ old('pembimbing', $kp->pembimbing ?? '') }}" placeholder="Contoh: Dr. Nama Dosen, S.Kom., M.Cs.">
                                        @error('pembimbing')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="mb-3">
                                        <label for="kata_kunci" class="form-label">Kata Kunci (Keyword)</label>
                                        <input type="text" class="form-control @error('kata_kunci') is-invalid @enderror" id="kata_kunci" name="kata_kunci" value="{{ old('kata_kunci', $kp->kata_kunci ?? '') }}" placeholder="Pisahkan dengan koma (3-5 kata)">
                                        @error('kata_kunci')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="mb-3">
                                        <label for="abstrak_file" class="form-label">Upload Abstrak (PDF/Word)</label>
                                        <input class="form-control @error('abstrak_file') is-invalid @enderror" type="file" id="abstrak_file" name="abstrak_file">
                                        @error('abstrak_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if(isset($kp) && $kp->abstrak_file)
                                            <div class="form-text mt-2">
                                                File saat ini: <a href="{{ asset('storage/' .$kp->abstrak_file) }}" target="_blank">Lihat Abstrak</a>
                                                <br><small class="text-muted">Kosongkan jika tidak ingin mengubah file.</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tgl_mulai" class="form-label">Tanggal Mulai KP</label>
                                                <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror" id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai', $kp->tgl_mulai ? $kp->tgl_mulai->format('Y-m-d') : '') }}">
                                                @error('tgl_mulai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tgl_selesai" class="form-label">Tanggal Selesai KP</label>
                                                <input type="date" class="form-control @error('tgl_selesai') is-invalid @enderror" id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai', $kp->tgl_selesai ? $kp->tgl_selesai->format('Y-m-d') : '') }}">
                                                @error('tgl_selesai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="mb-3">
                                        <label for="file_kp" class="form-label">Upload Laporan KP Lengkap</label>
                                        <input class="form-control @error('file_kp') is-invalid @enderror" type="file" id="file_kp" name="file_kp">
                                        @error('file_kp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if(isset($kp) && $kp->file_kp)
                                            <div class="form-text mt-2">
                                                File saat ini: <a href="{{ asset('storage/' .$kp->file_kp) }}" target="_blank">Lihat File Kerja Praktik</a>
                                                <br><small class="text-muted">Kosongkan jika tidak ingin mengubah file.</small>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="latar_belakang" class="form-label">Latar Belakang Singkat</label>
                                        <textarea class="form-control @error('latar_belakang') is-invalid @enderror" id="latar_belakang" name="latar_belakang" rows="4">{{ old('latar_belakang', $kp->latar_belakang ?? '') }}</textarea>
                                        @error('latar_belakang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
    
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between align-item-center flex-wrap gap-2">
                            <a href="{{ route('user.history.kp') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <div class="d-flex gap-2">
                                <button type="submit" id="submitBtn" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitBtn').addEventListener('click', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah kamu yakin ingin mengirim Kerja Praktik ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Submit',
            cancelButtonText: 'Batal',
            reverseButtonText: true,
            heightAuto: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('kpForm').submit()
            }
        })
    })
</script>
@endsection