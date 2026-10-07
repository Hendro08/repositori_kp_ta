@extends('layouts.admin')

@section('content')
<style>
    .card {
        border-radius: 8px;
        border: none;
    }

    .card-header {
        color: white;
        border-bottom: none;
        padding: 15px 20px;
    }

    .detail-table th {
        width: 35%;
        background: #f8fafc !important;
        font-weight: 600;
    }

    .detail-table td {
        background: #ffffff;
    }

    .timeline-log {
        max-height: 240px;
        overflow-y: auto;
        border-radius: 6px;
        padding-right: 5px;
    }

    .timeline-log .list-group-item {
        border-left: 3px solid #0d6efd;
        border-radius: 4px;
        margin-bottom: 4px;
        background: #f8f9fc;
    }

    .table-input {
        border: none;
        background: transparent;
        padding: 0;
        height: auto;
        font-size: inherit;
    }

    .table-input:focus {
        border: 1px solid #007bff;
        background: #eef6ff;
        padding: .25rem .35rem;
        border-radius: 4px;
        outline: none;
    }

    @media (max-width: 767px) {
        .detail-table th, .detail-table td {
            font-size: 13px;
            padding: 6px;
        }
        h5 {
            font-size: 15px;
        }
        .container-fluid {
            padding-top: 2rem;
        }
    }
</style>
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center bg-success">
            <i class="bi bi-pencil-square me-2 fs-5"></i>
            <h4 class="mb-0">Review Data Tugas Akhir</h4>
        </div>
        <form action="{{ route('admin.ta.updateStatus', $ta->id_ta) }}" method="POST" id="reviewForm">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <h5>Detail Pengumpulan</h5>
                        <table class="table table-bordered table-sm detail-table">
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <td>{{ $ta->user->nama ?? 'N/A' }} ({{ $ta->user->nim ?? 'N/A' }})</td>
                            </tr>
                            <tr>
                                <th>Judul<br>
                                    <small class="text-muted">(Jika sudah fix, kembalikan judul ke semula)</small>
                                </th>
                                <td>
                                    <input type="text" name="judul" id="judul" 
                                    class="form-control form-control-sm table-input @error('judul') is-invalid  @enderror"
                                    value="{{ old('judul', $ta->judul) }}">
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th>Jenis TA</th>
                                <td>{{ $ta->jenis_ta }}</td>
                            </tr>
                            <tr>
                                <th>Pembimbing</th>
                                <td>{{ $ta->pembimbing }}</td>
                            </tr>
                            <tr>
                                <th>Kata Kunci</th>
                                <td>{{ $ta->kata_kunci }}</td>
                            </tr>
                            <tr>
                                <th>Latar Belakang</th>
                                <td>{{ $ta->latar_belakang }}</td>
                            </tr>
                            <tr>
                                <th>Download Files</th>
                                <td>
                                    <a href="{{ asset('storage/' . $ta->abstrak_file) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-download me-1"></i> Abstrak
                                    </a>
                                    <a href="{{ asset('storage/' . $ta->file_ta) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-download me-1"></i> File Lengkap
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <h5 class="mt-4">Riwayat Log</h5>
                        <div class="timeline-log">
                            <ul class="list-group list-group-flush small">
                                @forelse ($logs as $log)
                                    <li class="list-group-item">
                                        <strong>{{ $log->created_at->format('d M Y, H:i') }}</strong>
                                        <span class="text-primary">({{ $log->activity }})</span>
                                        <br>Oleh: {{ $log->actor }}
                                        @if ($log->notes)
                                            <br><small class="text-muted">Catatan: {{ $log->notes }}</small>
                                        @endif
                                    </li>
                                @empty
                                    <li class="list-group-item text-center text-muted">Belum ada riwayat.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card bg-light border">
                            <div class="card-body">
                                <h5 class="card-title">Aksi Admin</h5>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Ubah Status:</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="terkumpul" {{ $ta->status == 'terkumpul' ? 'selected' : '' }}>
                                            Terkumpul (Pending)
                                        </option>
                                        <option value="revisi" {{ $ta->status == 'revisi' ? 'selected' : '' }}>
                                            Minta Revisi
                                        </option>
                                        <option value="disetujui" {{ $ta->status == 'disetujui' ? 'selected' : '' }}>
                                            Disetujui
                                        </option>
                                    </select>
                                </div>
                                <label class="form-label mt-2">Catatan</label>
                                <textarea name="catatan_admin" class="form-control form-control-sm" rows="6"
                                          placeholder="Isi catatan bila revisi ...">{{ $ta->catatan_admin }}</textarea>

                                <div class="mt-4 d-flex flex-column gap-2">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                                    </button>

                                    <a href="{{ route('admin.ta.index') }}" class="btn btn-outline-secondary w-100 py-2">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('reviewForm').addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: 'Status TA & catatan akan diperbarui!',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Simpan!'
        }).then((result) => {
            if(result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endsection