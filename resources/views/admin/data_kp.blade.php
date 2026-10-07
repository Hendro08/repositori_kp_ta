@extends('layouts.admin')

@section('content')

<style>
    .card {
        border: none;
        border-radius: 5px;
        overflow: hidden;
    }

    .card-header {
        color: #fff;
        border-bottom: none;
        padding: 15px 20px;
    }

    table thead {
        background: #f8f9fc;
        font-size: 14px;
    }

    table tbody tr:hover {
        background: #f1f5f9;
        transition: 0.2s;
    }

    .badge {
        font-size: 12px !important;
        padding: 6px 10px !important;
        border-radius: 6px;
    }

    .table-responsive {
        border-radius: 10px;
    }

    .kp-mahasiswa .nama {
        display: block;
    }

    .kp-mahasiswa .nim {
        display: block;
        font-size: 12px;
        color: #6b7280;
    }

    @media (max-width: 767px) {

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 10px;
        }

        table {
            min-width: 640px; 
        }

        table td, table th {
            padding: 6px; 
            font-size: 13px;
            white-space: nowrap; 
        }

        .action-btns > * {
            padding: 4px 6px;
            font-size: 12px;
        }

        .btn-delete {
            padding: 4px 6px;
            font-size: 12px;
        }

        .btn-delete i {
            font-size: 14px;
        }

        table {
            font-size: 13px;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .container-fluid {
            padding-top: 2rem;
        }

        .table td:nth-child(2),
        .table td:nth-child(3) {
            white-space: normal !important;
            word-break: break-word;
            max-width: 220px;
        }

        .table td:not(:nth-child(2)):not(:nth-child(3)) {
            white-space: nowrap !important;
        }
    }


</style>

<div class="container-fluid">
    {{-- Alert Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary">
            <h4 class="mb-0"><i class="bi bi-folder2-open me-2"></i>Data Kerja Praktik</h4>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('admin.kp.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="search_nama" class="form-control form-control-sm" 
                            placeholder="Cari Nama Mahasiswa..." value="{{ $search_nama }}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="search_judul" class="form-control form-control-sm" 
                            placeholder="Cari Judul KP..." value="{{ $search_judul }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Mahasiswa</th>
                            <th>Judul</th>
                            <th>Kumpul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_kp as $index => $kp)
                        <tr>
                            <td>{{ $data_kp->firstItem() + $index }}</td>

                            <td class="kp-mahasiswa">
                                <span class="nama">{{ $kp->user->nama ?? 'N/A' }}</span>
                                <span class="nim">({{ $kp->user->nim ?? '' }})</span>
                            </td>

                            <td>{{ $kp->judul }}</td>

                            <td>
                                {{ $kp->tgl_kumpul->format('d M Y') }}
                            </td>

                            <td>
                                @if ($kp->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($kp->status == 'revisi')
                                    <span class="badge bg-warning text-dark">Revisi</span>
                                @else
                                    <span class="badge bg-secondary">Terkumpul</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.kp.review', $kp->id_kp) }}"
                                        class="btn btn-sm btn-outline-primary" title="Review/Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="{{ asset('storage/' . $kp->file_kp) }}" target="_blank"
                                        class="btn btn-sm btn-outline-info" title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>

                                    <form action="{{ route('admin.kp.destroy', $kp->id_kp) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-muted">
                                <i class="bi bi-exclamation-circle me-1"></i>Data tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $data_kp->links() }}
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e){
                let form = this.closest('form')

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    backdrop: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if(result.isConfirmed) {
                        form.submit()
                    }
                })
            })
        })
    })
</script>

@endsection
