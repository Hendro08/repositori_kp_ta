@extends('layouts.admin')

@section('content')
<style>
    .container-fluid {
        padding-bottom: 2rem;
    }

    .page-header {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }

    .page-header h5 {
        margin: 0;
        color: #1f2937;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .stat-card {
        border: none;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        transition: transform 0.3s ease;
        overflow: hidden;
        height: 100%;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card .card-body {
        padding: 1.5rem;
        z-index: 2;
        position: relative;
    }

    .bg-icon {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 8rem;
        opacity: 0.1;
        z-index: 1;
        transform: rotate(-15deg);
    }

    .stat-title {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #5a5c69;
    }

    .btn-detail {
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        margin-top: 1rem;
    }
    
    .chart-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-top: 2rem;
    }

    .chart-header {
        background: transparent;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.175);
    }
    .modal-header {
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1.5rem;
    }
    .nav-tabs .nav-link {
        border: none;
        color: var(--text-muted);
        font-weight: 600;
    }
    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
        background: transparent;
    }

    #modalSearchInput {
        font-size: 0.85rem;
    }

    @media (max-width: 767px) {
        #modalSearchInput {
            position: sticky;
            top: 56px;
            z-index: 1055;
            background: #fff;
            padding: 0.75rem;
            border-radius: 0.5rem;
        }

        .modal-header {
            position: sticky;
            top: 0;
            z-index: 1055;
            padding: 1rem;
            background: #fff;
        }

        .modal-dialog.modal-dialog-scrollable {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }

        .mobile-padding {
            padding-top: 20px;
        }
    }

    .table-responsive-mobile {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    .table td, .table th {
        white-space: nowrap;
        font-size: 0.82rem;
    }

    .badge-status {
        padding: 6px 10px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .td-nim {
        font-weight: 700;
        padding-left: 6px;
    }

</style>

<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mobile-padding page-header">
        <h5 class="h3 mb-0 text-gray-800 fw-bold"> <i class="bi bi-house-door-fill"></i> Dashboard Admin</h5>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card stat-card border-start border-4 border-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-title text-primary">
                                Mahasiswa (KP)
                            </div>
                            <div class="stat-value">
                                {{ $kp_students }}
                            </div>
                            <a href="#" class="btn-detail text-primary" 
                               data-bs-toggle="modal" data-bs-target="#studentDetailModal" data-type="kp">
                                Lihat Detail <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-briefcase-fill bg-icon text-primary"></i>
                            <i class="bi bi-briefcase-fill text-gray-300" style="font-size: 3rem; color: #dddfeb;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card stat-card border-start border-4 border-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-title text-success">
                                Mahasiswa (TA)
                            </div>
                            <div class="stat-value">
                                {{ $ta_students }}
                            </div>
                            <a href="#" class="btn-detail text-success"
                               data-bs-toggle="modal" data-bs-target="#studentDetailModal" data-type="ta">
                                Lihat Detail <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-mortarboard-fill bg-icon text-success"></i>
                            <i class="bi bi-mortarboard-fill text-gray-300" style="font-size: 3rem; color: #dddfeb;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card chart-card mb-4">
                <div class="card-header chart-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Kerja Praktik</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="position: relative; height: 300px; width: 100%;">
                        <canvas id="kpChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card chart-card mb-4">
                <div class="card-header chart-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">Statistik Tugas Akhir</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="position: relative; height: 300px; width: 100%;">
                        <canvas id="taChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="studentDetailModal" tabindex="-1" aria-labelledby="studentDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="studentDetailModalLabel">Detail Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="modalSearchInput" class="form-control border-start-0" placeholder="Cari berdasarkan NIM atau Nama Mahasiswa...">
                    </div>
                </div>
                
                <ul class="nav nav-tabs mb-3" id="studentTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="semester-ini-tab" data-bs-toggle="tab" data-bs-target="#semester-ini-pane" type="button">
                            Semester Ini
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="semua-data-tab" data-bs-toggle="tab" data-bs-target="#semua-data-pane" type="button">
                            Semua Data
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="studentTabContent">
                    <div class="tab-pane fade show active" id="semester-ini-pane" role="tabpanel">
                        <div class="table-responsive-mobile">
                            <table class="table table-sm table-striped mt-2 align-middle text-start">
                                <thead class="table-light">
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="modalStudentListThisSemester"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="semua-data-pane" role="tabpanel">
                        <div class="table-responsive-mobile">
                            <table class="table table-sm table-striped mt-2 align-middle text-start">
                                <thead class="table-light">
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="modalStudentListAllTime"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const studentModal = document.getElementById('studentDetailModal')
        const modalTitle = document.getElementById('studentDetailModalLabel')
        const modalSearchInput = document.getElementById('modalSearchInput')
        const listBodyThisSemester = document.getElementById('modalStudentListThisSemester')
        const listBodyAllTime = document.getElementById('modalStudentListAllTime')
        let currentDataType = null

        function populateTable(tbody, students) {
            if (students.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-3">Data tidak ditemukan.</td></tr>'
                return
            }
            let html = ''
            students.forEach(student => {
                let badgeClass = 'badge-status bg-secondary'
                if (student.status?.toLowerCase() === 'disetujui') badgeClass = 'badge-status bg-success'
                if (student.status?.toLowerCase() === 'terkumpul') badgeClass = 'badge-status bg-secondary'
                if (student.status?.toLowerCase() === 'revisi') badgeClass = 'badge-status bg-warning text-dark'

                html += `
                    <tr>
                        <td class="fw-bold">${student.nim}</td>
                        <td>${student.nama}</td>
                        <td class="text-left"><span class="badge ${badgeClass}">${student.status || '_'}</span></td>
                    </tr>
                `;
            });
            tbody.innerHTML = html
        }

        async function fetchStudentData(type, search = '') {
            const loadingHTML = '<tr><td colspan="3" class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></td></tr>'
            listBodyThisSemester.innerHTML = loadingHTML
            listBodyAllTime.innerHTML = loadingHTML
            
            const url = new URL("{{ route('admin.student.details') }}")
            url.searchParams.append('type', type)
            if (search) url.searchParams.append('search', search)

            try {
                const response = await fetch(url)
                if (!response.ok) throw new Error('Network response error')
                const data = await response.json()
                
                populateTable(listBodyThisSemester, data.this_semester)
                populateTable(listBodyAllTime, data.all_time)
            } catch (error) {
                console.error('Fetch error:', error)
                const errorHTML = '<tr><td colspan="3" class="text-center text-danger py-3">Gagal memuat data.</td></tr>'
                listBodyThisSemester.innerHTML = errorHTML
                listBodyAllTime.innerHTML = errorHTML
            }
        }

        studentModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget
            currentDataType = button.getAttribute('data-type')
            const title = (currentDataType === 'kp') ? 'Detail Mahasiswa - Kerja Praktik' : 'Detail Mahasiswa - Tugas Akhir'
            modalTitle.textContent = title;
            modalSearchInput.value = ''
            fetchStudentData(currentDataType);
            document.getElementById('semester-ini-tab').click()
        });

        let searchTimeout;
        modalSearchInput.addEventListener('keyup', function () {
            clearTimeout(searchTimeout)
            const searchValue = this.value
            searchTimeout = setTimeout(() => {
                fetchStudentData(currentDataType, searchValue);
            }, 300)
        });

        const colorDisetujui = '#1cc88a'
        const colorTerkumpul = '#858796'
        const colorRevisi = '#f6c23e'

        const kpCtx = document.getElementById('kpChart').getContext('2d');
        new Chart(kpCtx, {
            type: 'doughnut', 
            data: {
                labels: ['Disetujui', 'Terkumpul', 'Revisi'],
                datasets: [{
                    data: [
                        {{ $approved_kp }},
                        {{ $terkumpul_kp }},
                        {{ $revisi_kp }}
                    ],
                    backgroundColor: [colorDisetujui, colorTerkumpul, colorRevisi],
                    hoverOffset: 5,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true 
                        }
                    }
                },
                cutout: '60%', 
            }
        });

        const taCtx = document.getElementById('taChart').getContext('2d');
        new Chart(taCtx, {
            type: 'doughnut',
            data: {
                labels: ['Disetujui', 'Terkumpul', 'Revisi'],
                datasets: [{
                    data: [
                        {{ $approved_ta }},
                        {{ $terkumpul_ta }},
                        {{ $revisi_ta }}
                    ],
                    backgroundColor: [colorDisetujui, colorTerkumpul, colorRevisi],
                    hoverOffset: 5,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                },
                cutout: '60%',
            }
        });

    });
</script>
@endsection