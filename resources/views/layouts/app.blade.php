<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Presensi RFID - @yield('title')</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @livewireStyles

    <style>
    body {
        background: #f4f7fb;
        font-family: 'Nunito', sans-serif;
    }

    .sidebar {
        width: 240px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: #0a61e4;
        color: white;
        z-index: 1000;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        padding-bottom: 1rem;
    }

    .sidebar-brand {
        padding: 28px 22px;
        text-align: left;
    }

    .sidebar-brand h4 {
        font-size: 1.05rem;
        letter-spacing: 0.02em;
        margin-bottom: 0.2rem;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.88);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.2s ease;
        margin: 6px 12px;
        border-radius: 14px;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.16);
        color: #fff;
        transform: translateX(2px);
    }

    .sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
        font-weight: 600;
    }

    .sidebar .nav-link i {
        margin-right: 12px;
        font-size: 1.2rem;
    }

    .sidebar-footer {
        margin-top: auto;
        padding: 0 18px;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.45);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .sidebar-overlay.show {
        display: block;
        opacity: 1;
    }

    .content {
        margin-left: 240px;
        min-height: 100vh;
        padding: 0 20px 40px;
        transition: margin-left 0.3s ease;
    }

    .topbar {
        background: white;
        border-radius: 20px;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        margin: 20px 0;
        padding: 18px 22px;
        align-items: center;
    }

    .topbar .page-title {
        margin-bottom: 0;
        font-size: 1.15rem;
    }

    .topbar .page-subtitle {
        margin-bottom: 0;
        color: #6d7585;
        font-size: 0.92rem;
    }

    .topbar .user-summary {
        min-width: 220px;
        align-items: center;
        margin-left: auto;
        gap: 0.75rem;
    }

    .topbar .user-summary .avatar {
        width: 44px;
        height: 44px;
        display: grid;
        place-items: center;
    }

    .topbar .user-summary .date-label {
        font-size: 0.82rem;
        color: #6d7585;
    }

    @media (max-width: 992px) {
        .content {
            margin-left: 0;
            padding: 0 16px 30px;
        }
        .topbar {
            padding: 16px 16px;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.show {
            transform: translateX(0);
            box-shadow: 8px 0 40px rgba(0, 0, 0, 0.12);
        }
        .content {
            padding: 0 14px 30px;
        }
        .topbar {
            margin: 16px 0;
            min-height: 84px;
        }
        .topbar .page-subtitle,
        .topbar .user-details {
            display: none;
        }
        .topbar .user-summary {
            position: absolute;
            top: 14px;
            right: 14px;
            margin: 0;
            flex-direction: column;
            align-items: center;
        }
        .topbar .user-summary .date-label {
            display: block;
        }
        .sidebar-overlay {
            display: none;
        }
        .sidebar-overlay.show {
            display: block;
        }
    }
    </style>
</head>

<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand p-4 mb-2 text-center border-bottom border-white border-opacity-10">
        <img src="{{ asset('assets/img/logo.png') }}" 
             alt="Logo" 
             style="width: 105px; height: auto; object-fit: contain;" 
             class="mb-3">
        <h4 class="fw-bold mb-0 text-white fs-10">Al Magfiroh</h4>
        <small class="text-white-50" style="font-size: 0.9rem;">Sistem Presensi RFID</small>
    </div>

    <div class="nav flex-column">
        <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="/presensi" class="nav-link {{ Request::is('presensi*') ? 'active' : '' }}">
            <i class="bi bi-list-check"></i> Log Presensi
        </a>

        @if(auth()->user()->role == 'superadmin' || auth()->user()->role == 'admin')
            <a href="{{ route('santri.index') }}" class="nav-link {{ Request::is('santri*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Santri
            </a>
        @endif

        @if(auth()->user()->role == 'superadmin')
            <a href="{{ route('kegiatan.index') }}" class="nav-link {{ request()->is('kegiatan*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event me-2"></i> Kegiatan
            </a>
        @endif

        @if(auth()->user()->role == 'superadmin')
            <div class="sidebar-heading text-white-50 small text-uppercase px-3 mt-4 mb-1">
                Management
            </div>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Manajemen User
            </a>
        @endif
        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <div class="sidebar-footer p-4 text-center">
        <div class="pt-3 border-top border-white border-opacity-10">
            <small class="text-white-50 d-block" style="font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase;">Dikembangkan Oleh</small>
            <p class="mb-0 fw-bold text-white" style="font-size: 0.85rem;">Bagus Technology</p>
        </div>
    </div>
</div>

<div class="content">
    <nav class="topbar">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-primary d-md-none p-2 rounded-3" onclick="toggleSidebar()" style="border: 1px solid rgba(0,0,0,.08); background: #fff;">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div>
                    <h5 class="page-title fw-bold text-dark mb-1">@yield('title', 'Aplikasi Presensi')</h5>
                    <p class="page-subtitle mb-0">Halaman pengelolaan data sistem</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 user-summary">
                <div class="avatar bg-primary bg-opacity-10 rounded-circle">
                    <i class="bi bi-person-badge-fill text-primary fs-5"></i>
                </div>
                <div class="text-end user-details">
                    <div class="fw-semibold text-primary small text-uppercase" style="line-height: 1.1;">{{ auth()->user()->role }}</div>
                    <small class="text-muted" style="font-size: 0.82rem;">{{ auth()->user()->name }}</small>
                </div>
                <div class="date-label text-muted small d-flex align-items-center gap-1" style="font-size: 0.82rem;">
                    <i class="bi bi-calendar3"></i>
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@livewireScripts
@yield('scripts')

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const content = document.querySelector('.content');
    
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
    
    // Prevent body scroll when sidebar is open on mobile
    if (window.innerWidth <= 768) {
        if (sidebar.classList.contains('show')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = event.target.closest('button[onclick="toggleSidebar()"]');
    
    if (!sidebar.contains(event.target) && !toggleBtn && sidebar.classList.contains('show')) {
        toggleSidebar();
    }
});

// Handle window resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (window.innerWidth > 768) {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
});
</script>
</body>
</html>