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
        background: #f8f9fc;
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
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px; /* Sedikit disesuaikan agar proporsional dengan margin */
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: 0.2s;
        /* Tambahan margin agar efek rounded tidak menempel ke pinggir sidebar */
        margin: 4px 12px;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-radius: 10px; /* Efek melengkung saat hover */
    }

    .sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.32); /* Warna lebih terang */
        color: white;
        font-weight: bold;
        /* INI PERUBAHAN UTAMANYA */
        border-radius: 10px; /* Membuat kotak melengkung */
    }

    .sidebar .nav-link i {
        margin-right: 12px;
        font-size: 1.1rem;
    }

    .sidebar-footer {
        margin-top: auto;
    }

    .content {
        margin-left: 240px; 
        min-height: 100vh;
        padding: 0 10px;
        padding-bottom: 50px;
    }

    .topbar {
        background: white;
        height: 70px;
        display: flex;
        align-items: center;
        margin-left: 20px; 
        margin-right: 20px;
        margin-top: 15px; 
        margin-bottom: 25px; 
        border-radius: 10px; 
        box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
    }
    </style>
</head>

<body>

<div class="sidebar">
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

        <a href="/santri" class="nav-link {{ Request::is('santri*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Santri
        </a>

        <a href="#" class="nav-link">
            <i class="bi bi-calendar-event"></i> Kegiatan
        </a>
    </div>

    <div class="sidebar-footer p-4 text-center">
        <div class="pt-3 border-top border-white border-opacity-10">
            <small class="text-white-50 d-block" style="font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase;">Dikembangkan Oleh</small>
            <p class="mb-0 fw-bold text-white" style="font-size: 0.85rem;">Bagus Technology</p>
        </div>
    </div>
</div>

<div class="content">
    <nav class="topbar px-4">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-bold mb-0 text-dark">@yield('title', 'Aplikasi Presensi')</h5>
                <p class="text-muted small mb-0 d-none d-sm-block">Halaman pengelolaan data sistem</p>
            </div>
            <div class="text-muted small fw-medium">
                <i class="bi bi-calendar3 me-1"></i> 
                {{ Carbon\Carbon::now()->translatedFormat('d F Y') }}
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
</body>
</html>