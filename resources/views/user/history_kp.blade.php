@extends('layouts.app')

@section('content')
<style>
    /* --- Card Styling --- */
    .card {
        border-radius: 12px;
        overflow: hidden;
        border: none;
    }

    .card-header {
        padding: 1rem 1.2rem;
        font-weight: 600;
    }

    /* --- Table Styling --- */
    .table th {
        background: #f8f9fa;
        font-weight: 600;
    }

    .table td, .table th {
        vertical-align: middle;
        padding: 0.75rem;
    }

    /* Badge style upgrade */
    .badge {
        padding: 0.45em 0.75em;
        font-size: 0.75rem;
        border-radius: 6px;
    }

    /* Download / Edit / Delete buttons */
    .table .btn {
        padding: 6px 10px;
        border-radius: 6px;
    }

    .table .btn i {
        font-size: 0.9rem;
    }

    /* Hover row effect */
    .table-hover tbody tr:hover {
        background-color: #f1f5f9;
    }

    .btn-revisi {
        background-color: #f7c948; /* soft yellow */
        color: #3d3d3d;
        border: none;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
        transition: 0.2s ease;
    }

    .btn-revisi:hover {
        background-color: #f4b500;
        color: #000;
    }

    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch; /* smooth di mobile */
    }

    /* Membuat tabel tidak mengecil dan tetap panjang */
    .table-responsive table {
        min-width: 900px; /* bisa ubah sesuai kebutuhan */
    }

    /* Mobile improvements */
    @media (max-width: 768px) {
        h4 {
            font-size: 1.1rem;
        }

        .table td,
        .table th {
            font-size: 0.75rem;
            padding: 0.4rem;
        }

        .table .btn {
            padding: 4px 6px;
        }

        .badge {
            font-size: 0.65rem;
        }

        .card {
            margin-bottom: 1.5rem;
        }

        .btn-revisi {
            padding: 4px 8px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .table-responsive table {
            min-width: 650px;
        }

        .swal2-popup {
            width: 90% !important;
            font-size: 0.9rem !important;
        }

        .swal2-title {
            font-size: 1.1rem !important;
        }

        .swal2-actions {
            flex-direction: column;
        }

        .swal2-actions button {
            width: 100% !important;
            margin: 4px 0 !important;
        }
    }
</style>
<div class="min-vh-100 d-flex align-items-center mb-0" style="background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(30, 64, 175, 0.85)), url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat; padding-top: 100px; padding-bottom: 3rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Status Kerja Praktik</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Judul</th>
                                        <th>Tgl. Kumpul</th>
                                        <th>Status</th>
                                        <th>Catatan Admin</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data_kp as $index => $kp)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $kp->judul }}</td>
                                        <td>{{ $kp->tgl_kumpul->format('d M Y') }}</td>
                                        <td>
                                            @if ($kp->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($kp->status == 'revisi')
                                                <span class="badge bg-warning text-dark">Perlu Revisi</span>
                                            @else
                                                <span class="badge bg-secondary">Terkumpul</span>
                                            @endif
                                        </td>
                                        <td style="white-space: pre-wrap;">{{ $kp->catatan_admin ?? '-' }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $kp->file_kp) }}" target="_blank" class="btn btn-sm btn-info" title="Download File KP">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            
                                            @if ($kp->status == 'terkumpul')
                                                <a href="{{ route('user.kp.edit', $kp->id_kp) }}" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('user.kp.destroy', $kp->id_kp) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @elseif ($kp->status == 'revisi')
                                                <a href="{{ route('user.kp.revisi', $kp->id_kp) }}" class="btn btn-sm btn-warning text-dark" title="Kumpulkan Revisi">
                                                    <i class="bi bi-upload me-1"></i> Kumpulkan Revisi
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Anda belum pernah mengumpulkan Kerja Praktik.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mt-5">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">History Activitas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Aktivitas</th>
                                        <th>Oleh</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data_logs as $log)
                                    <tr>
                                        <td>{{ $log->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $log->activity }}</span>
                                        </td>
                                        <td>{{ $log->actor }}</td>
                                        <td style="white-space: pre-wrap;">{{ $log->notes ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada catatan aktivitas.</td>
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

<script>
    document.addEventListener("DOMContentLoaded", function (e){
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function (e) {
                let form = this.closest('.delete-form');
                e.preventDefault();

                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'Data yang dihapus tidak bisa dikembalikan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    heightAuto: false
                }).then((result) => {
                    if(result.isConfirmed) {
                        form.submit();
                    }
                })
            })
        })
    })
</script>
@endsection