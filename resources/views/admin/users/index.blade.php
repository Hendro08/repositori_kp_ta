@extends('layouts.admin')

@section('content')
<style>
    .card {
        border: 1px solid #e6edf3;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
    }
    .card-header {
        background: linear-gradient(90deg, #0ea5a4, #059669);
        color: #fff;
        padding: 15px 20px;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    

    .input-group .form-control {
        border-radius: 8px 0 0 8px;
    }
    .input-group .btn {
        border-radius: 0 8px 8px 0;
    }

    .table thead th {
        background: #f8fafc;
        font-weight: 700;
        border-bottom: 0;
    }
    .table tbody tr:hover {
        background: #f1f5f9;
    }
    .table td, .table th {
        vertical-align: middle;
        padding: 10px 12px;
        white-space: nowrap;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 8px;
    }

    .badge {
        font-size: 0.78rem;
        padding: 6px 8px;
        border-radius: 8px;
    }

    .d-flex .btn {
        padding: 6px 8px;
        font-size: 0.85rem;
    }

   
    .modal .form-label {
        font-weight: 600;
    }

    @media (max-width: 767px) {
        .card-header h4 {
            font-size: 1rem;
        }
        .table td, .table th {
            padding: 8px 10px;
            font-size: 0.92rem;
        }
        .input-group .form-control {
            font-size: 0.95rem;
        }
        .table {
            min-width: 900px; 
        }
    }

    .btn-back {
        background: rgba(255,255,255,0.12);
        color: white;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.16);
    }
</style>

<div class="container-fluid">
    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center gap-3">
                <h4 class="mb-0">Kelola User (Mahasiswa)</h4>
            </div>
        </div>

        <div class="card-body">
            {{-- Search --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari berdasarkan NIM, Nama, atau Email..." value="{{ $search }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 18%;">NIM</th>
                            <th style="width: 30%;">Nama</th>
                            <th style="width: 32%;">Email</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->nim }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Edit (open modal) -->
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary btn-open-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserModal"
                                            data-userid="{{ $user->user_id }}"
                                            data-nama="{{ $user->nama }}"
                                            data-nim="{{ $user->nim }}"
                                            data-email="{{ $user->email }}"
                                            data-action="{{ route('admin.users.update', $user->user_id) }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- Delete with SweetAlert -->
                                    <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST" class="d-inline form-delete">
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
                            <td colspan="4" class="text-center py-3 text-muted">
                                <i class="bi bi-exclamation-circle me-1"></i>Data user tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

{{-- ================= Modal Edit User ================= --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="edit_userid" name="user_id">

                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="edit_nim" name="nim" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editUserModalEl = document.getElementById('editUserModal');
    editUserModalEl.addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget
        var actionUrl = btn.getAttribute('data-action')
        var nama = btn.getAttribute('data-nama') || ''
        var nim = btn.getAttribute('data-nim') || ''
        var email = btn.getAttribute('data-email') || ''
        var userid = btn.getAttribute('data-userid') || ''

        document.getElementById('edit_nama').value = nama
        document.getElementById('edit_nim').value = nim
        document.getElementById('edit_email').value = email
        document.getElementById('edit_userid').value = userid

        var form = document.getElementById('editUserForm')
        form.action = actionUrl;
    });

    document.querySelectorAll('.btn-delete').forEach(function(btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault()
            var form = this.closest('form')

            Swal.fire({
                title: 'Hapus user?',
                text: 'PERINGATAN: Menghapus user ini akan menghapus semua data KP, TA, dan Log terkait.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.getElementById('editUserForm').addEventListener('submit', function(e){
        var name = document.getElementById('edit_nama').value.trim()
        var nim = document.getElementById('edit_nim').value.trim()
        var email = document.getElementById('edit_email').value.trim()

        if (!name || !nim || !email) {
            e.preventDefault()
            Swal.fire({
                icon: 'warning',
                title: 'Lengkapi data',
                text: 'Nama, NIM, dan Email wajib diisi.'
            })
        }
    })
})
</script>

@endsection
