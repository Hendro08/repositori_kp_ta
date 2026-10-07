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

    .ta-mahasiswa .nama {
        display: block;
    }

    .ta-mahasiswa .nim {
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
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow">
        <div class="card-header bg-success">
            <h4 class="mb-0"><i class="bi bi-folder2-open me-2"></i>Data Tugas Akhir</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ta.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="search_nama" class="form-control form-control-sm" 
                               placeholder="Cari Nama Mahasiswa..." value="{{ $search_nama }}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="search_judul" class="form-control form-control-sm" 
                               placeholder="Cari Judul TA..." value="{{ $search_judul }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Mahasiswa</th>
                            <th>Judul</th>
                            <th>Tgl. Kumpul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_ta as $index => $ta)
                        <tr>
                            <td>{{ $data_ta->firstItem() + $index }}</td>
                            <td class="ta-mahasiswa">
                                <span class="nama">{{ $ta->user->nama ?? 'N/A' }}</span>
                                <span class="nim">({{ $ta->user->nim ?? '' }})</span>
                            </td>
                            <td>{{ $ta->judul }}</td>
                            <td>{{ $ta->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($ta->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($ta->status == 'revisi')
                                    <span class="badge bg-warning text-dark">Perlu Revisi</span>
                                @else
                                    <span class="badge bg-secondary">Terkumpul</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.ta.review', $ta->id_ta) }}"
                                       class="btn btn-sm btn-outline-primary" title="Review/Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ asset('storage/' . $ta->file_ta) }}" target="_blank" 
                                       class="btn btn-sm btn-outline-info" title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form action="{{ route('admin.ta.destroy', $ta->id_ta) }}" method="POST">
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
            <div class="mt-3">
                {{ $data_ta->links() }}
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