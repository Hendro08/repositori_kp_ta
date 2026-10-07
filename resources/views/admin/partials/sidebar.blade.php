<nav class="nav flex-column">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" 
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span>
            <i class="bi bi-house-door-fill"></i>
            Dashboard
        </span>
    </a>

    <!-- Data Kerja Praktik -->
    <a href="{{ route('admin.kp.index') }}" 
       class="nav-link {{ request()->routeIs('admin.kp.*') ? 'active' : '' }}">
        <span>
            <i class="bi bi-briefcase-fill"></i>
            Data Kerja Praktik
        </span>
        @if($pendingKpCount > 0)
            <span class="badge-notif">{{ $pendingKpCount }}</span>
        @endif
    </a>

    <!-- Data Tugas Akhir -->
    <a href="{{ route('admin.ta.index') }}" 
       class="nav-link {{ request()->routeIs('admin.ta.*') ? 'active' : '' }}">
        <span>
            <i class="bi bi-mortarboard-fill"></i>
            Data Tugas Akhir
        </span>
        @if($pendingTaCount > 0)
            <span class="badge-notif">{{ $pendingTaCount }}</span>
        @endif
    </a>

    <!-- Kelola User -->
    <a href="{{ route('admin.users.index') }}" 
       class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <span>
            <i class="bi bi-people-fill"></i>
            Kelola User
        </span>
    </a>
</nav>