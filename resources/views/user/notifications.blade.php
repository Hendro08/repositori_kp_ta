@extends('layouts.app')

@section('content')
<style>
    /* Notification Item Styling */
    .notif-title {
        font-size: 25px
    }

    .notif-badge {
        font-size: 1rem !important; 
        padding: 0.4rem 0.8rem !important;
    }

    .notification-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        background: #f8f9fa;
        border-left-color: #2563eb;
        transform: translateX(5px);
    }

    /* Status Colors */
    .notification-item.status-revisi {
        background: #fef3c7;
        border-left-color: #f59e0b;
    }

    .notification-item.status-revisi:hover {
        background: #fde68a;
        border-left-color: #d97706;
    }

    .notification-item.status-disetujui {
        background: #d1fae5;
        border-left-color: #10b981;
    }

    .notification-item.status-disetujui:hover {
        background: #a7f3d0;
        border-left-color: #059669;
    }

    .notification-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.3rem;
    }

    .notification-icon.ta {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #059669;
    }

    .notification-icon.kp {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #2563eb;
    }

    .notification-time {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .notification-message {
        color: #4b5563;
        line-height: 1.5;
    }

    /* Mobile Responsive */
    @media (max-width: 767px) {
        .notif-title {
            font-size: 20px
        }

        .notif-badge {
            font-size: 0.8rem !important; 
            padding: 0.2rem 0.6rem !important;
        }

        .notification-item {
            padding: 0.8rem !important;
        }

        .notification-icon {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .notification-title {
            font-size: 0.8rem;
        }

        .notification-message {
            font-size: 0.7rem;
        }

        .notification-time {
            font-size: 0.6rem;
        }
    }
</style>

<div class="min-vh-100 d-flex align-items-center mb-0" style="background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(30, 64, 175, 0.85)), url('{{ asset('images/fti_uksw.jpg') }}') center/cover no-repeat; padding-top: 100px; padding-bottom: 3rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <!-- Notifications Card -->
                <div class="card shadow-lg border border-2 border-primary">
                    <div class="card-header bg-white border-bottom py-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold notif-title">
                                <i class="bi bi-bell-fill me-2 text-primary "></i>
                                Notifikasi Anda
                            </h4>
                            @if($notifications->count() > 0)
                                <span class="badge bg-primary rounded-pill px-3 py-2 fs-6 notif-badge">
                                    {{ $notifications->count() }} Notifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse ($notifications as $notif)
                                @php
                                    // Tentukan status class berdasarkan message
                                    $statusClass = '';
                                    if (str_contains(strtolower($notif->message), 'disetujui')) {
                                        $statusClass = 'status-disetujui';
                                    } elseif (str_contains(strtolower($notif->message), 'revisi')) {
                                        $statusClass = 'status-revisi';
                                    }
                                @endphp
                                <a href="{{ $notif->type == 'ta' ? route('user.history.ta') : route('user.history.kp') }}" 
                                   class="list-group-item list-group-item-action notification-item {{ $statusClass }} p-4">
                                    <div class="d-flex gap-3">
                                        <!-- Icon -->
                                        <div class="notification-icon {{ $notif->type }}">
                                            @if($notif->type == 'ta')
                                                <i class="bi bi-mortarboard-fill"></i>
                                            @else
                                                <i class="bi bi-briefcase-fill"></i>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <h6 class="mb-0 fw-semibold notification-title">
                                                    @if($notif->type == 'ta')
                                                        Update Tugas Akhir
                                                    @else
                                                        Update Kerja Praktik
                                                    @endif
                                                </h6>
                                                <small class="notification-time">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ $notif->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <p class="mb-0 notification-message">{{ $notif->message }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="list-group-item text-center py-5">
                                    <i class="bi bi-bell-slash fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted mb-0">Tidak ada notifikasi saat ini</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection