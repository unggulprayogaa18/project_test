<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Desain Profesional</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --putih: #ffffff;
            --latar-utama: #f8f9fa;
            --teks-utama: #495057;
            --teks-sekunder: #6c757d;
            --border-color: #dee2e6;
            --hover-bg: #e9ecef;
        }
        body {
            height: 100vh;
            overflow-x: hidden;
            background-color: var(--latar-utama);
            color: var(--teks-utama);
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: var(--putih);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .navbar-brand span {
            font-weight: 600;
            color: var(--teks-utama);
        }
        .profile-dropdown .dropdown-toggle,
        .navbar-nav .nav-link {
            color: var(--teks-sekunder);
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover,
        .profile-dropdown .dropdown-toggle:hover {
            color: var(--biru-otista);
        }
        .navbar-nav .nav-link.active {
            color: var(--biru-otista);
            font-weight: 700;
        }
        .profile-dropdown .dropdown-menu {
            background-color: var(--putih);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .profile-dropdown .dropdown-item {
            color: var(--teks-utama);
        }
        .profile-dropdown .dropdown-item:hover {
            background-color: var(--hover-bg);
            color: var(--biru-otista);
        }
        .profile-dropdown .dropdown-divider {
            border-color: var(--border-color);
        }
        .btn-notification {
            background: none;
            border: none;
            color: var(--teks-sekunder);
            transition: color 0.3s;
        }
        .btn-notification:hover {
            color: var(--biru-otista);
        }
        .offcanvas {
            background-color: var(--putih);
        }
        .offcanvas-header {
            border-bottom: 1px solid var(--border-color);
        }
        .offcanvas-title {
            color: var(--biru-otista);
            font-weight: 600;
        }
        .offcanvas-body .nav-link {
            color: var(--teks-utama);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s, color 0.3s;
        }
        .offcanvas-body .nav-link.active,
        .offcanvas-body .nav-link:hover {
            background-color: var(--biru-otista);
            color: var(--putih);
        }
        .offcanvas-body .nav-link:not(.active):hover {
            background-color: var(--hover-bg);
            color: var(--biru-otista);
        }
        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 2.5rem;
        }
        .stat-card {
            background: var(--putih);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        .stat-card .card-body {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stat-card .icon-wrapper {
            font-size: 2.5rem;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(13, 110, 253, 0.1);
            color: var(--biru-otista);
            margin-right: 1rem;
        }
        .stat-card.accent-green .icon-wrapper {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        .stat-card.accent-yellow .icon-wrapper {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        .stat-card .text-content {
            text-align: right;
        }
        .stat-card .card-subtitle {
            font-size: 0.9rem;
            color: var(--teks-sekunder);
            font-weight: 400;
        }
        .stat-card .card-title {
            font-size: 2.2rem;
            color: var(--teks-utama);
            font-weight: 700;
        }
        .stat-card .card-footer {
            background-color: var(--latar-utama);
            border-top: 1px solid var(--border-color);
            font-size: 0.9rem;
        }
        .stat-card .card-footer a {
            color: var(--teks-sekunder);
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.5rem;
            transition: color 0.3s, background-color 0.3s;
        }
        .stat-card .card-footer a:hover {
            background-color: var(--hover-bg);
            color: var(--biru-otista);
        }
        .activity-card {
            background: var(--putih);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
        }
        .activity-card .card-header {
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            background-color: transparent;
        }
        .list-group-item {
            background: none;
            color: var(--teks-sekunder);
            border-bottom: 1px solid var(--hover-bg);
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
        .btn-primary {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }
        .btn-primary:hover {
            background-color: #082261;
            border-color: #082261;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
                <span class="fs-5 d-none d-sm-inline">SMKS Otto Iskandar Dinata Bandung</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><i
                                    class="bi bi-house-door-fill me-2"></i>Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.hal_matapelajaran') }}" class="nav-link">
                                <i class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.hal_tugas') }}"><i
                                    class="bi bi-card-checklist me-2"></i>Tugas Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.hal_buat_kuis') }}"><i
                                    class="bi bi-patch-check-fill me-2"></i> Kuis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guru.nilai.index') ? 'active' : '' }}"
                                href="{{ route('guru.nilai.index') }}"><i class="bi bi-collection-fill me-2"></i>Kelola
                                Nilai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.absensi.index') }}"><i
                                    class="bi bi-clipboard-check-fill me-2"></i>Absensi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('guru.chat.index') }}">
                                <i class="bi bi-chat-left-dots-fill me-2"></i>
                                Konsultasi Ortu
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center">
                <div class="dropdown notification-dropdown me-3">
                    <button class="btn btn-notification position-relative" type="button" id="notificationDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell-fill fs-4"></i>
                        @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span id="notification-badge"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                {{ $unreadMessagesCount }}
                            </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                        <li class="p-2 border-bottom">
                            <h6 class="dropdown-header">Notifikasi Pesan</h6>
                        </li>
                        <div style="max-height: 400px; overflow-y: auto;">
                            @forelse($unreadMessages as $message)
                                <li>
                                    <a class="dropdown-item notification-item p-3"
                                        href="{{ route('guru.chat.show', $message->user) }}">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-person-circle fs-3 me-3"></i>
                                            <div>
                                                <div class="fw-bold">{{ $message->user->nama }}</div>
                                                <div class="text-muted text-truncate" style="max-width: 250px;">
                                                    {{ $message->body }}
                                                </div>
                                                <small
                                                    class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <p class="text-center text-muted p-3 mb-0">Tidak ada notifikasi baru.</p>
                                </li>
                            @endforelse
                        </div>
                        <li class="p-2 text-center">
                            <a href="{{ route('guru.chat.index') }}">Lihat Semua Konsultasi</a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown profile-dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>{{ $guru->nama ?? 'Guru Hebat' }}</strong>
                        <i class="bi bi-person-circle ms-2 fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow dropdown-menu-end">
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="p-4 mb-4 text-white rounded-3" style="background-color: var(--biru-otista);">
            <h2>Selamat Datang, {{ $guru->nama ?? 'Guru Hebat' }}!</h2>
            <p class="lead">Ini adalah ringkasan aktivitas mengajar Anda. Mari kita mulai hari dengan semangat!</p>
        </div>

        <h3 class="mb-4 fw-bold">Ringkasan Anda Hari Ini</h3>

        <div class="row g-4 mb-5">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper"><i class="bi bi-journal-bookmark-fill"></i></div>
                        <div class="text-content">
                            <h6 class="card-subtitle">Jumlah Pelajaran</h6>
                            <h2 class="card-title">{{ $jumlahMataPelajaran ?? 0 }}</h2>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <a href="{{ route('guru.hal_matapelajaran') }}">
                            <span>Lihat Semua</span>
                            <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card h-100 accent-green">
                    <div class="card-body">
                        <div class="icon-wrapper"><i class="bi bi-card-checklist"></i></div>
                        <div class="text-content">
                            <h6 class="card-subtitle">Tugas Dibuat</h6>
                            <h2 class="card-title">{{ $jumlahTugas ?? 0 }}</h2>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <a href="{{ route('guru.hal_tugas') }}">
                            <span>Kelola Tugas</span>
                            <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card h-100 accent-yellow">
                    <div class="card-body">
                        <div class="icon-wrapper"><i class="bi bi-file-earmark-text-fill"></i></div>
                        <div class="text-content">
                            <h6 class="card-subtitle">Materi Tersedia</h6>
                            <h2 class="card-title">{{ $jumlahMateri ?? 0 }}</h2>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <a href="{{-- route('guru.hal_materi') --}}">
                            <span>Buka Materi</span>
                            <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper"><i class="bi bi-patch-check-fill"></i></div>
                        <div class="text-content">
                            <h6 class="card-subtitle">Kuis Dibuat</h6>
                            <h2 class="card-title">{{ $jumlahKuis ?? 0 }}</h2>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <a href="{{ route('guru.hal_buat_kuis') }}">
                            <span>Kelola Kuis</span>
                            <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card activity-card">
            <div class="card-header">
                Aktivitas Terbaru & Pemberitahuan
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($aktivitasTerbaru as $aktivitas)
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <i class="bi {{ $aktivitas->icon }} {{ $aktivitas->color }} me-3"></i>
                                {{ $aktivitas->deskripsi }}
                            </div>
                            <small>{{ $aktivitas->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-center p-3">
                            Tidak ada aktivitas terbaru.
                        </li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer bg-transparent border-0 p-3 text-center">
                <a href="#" class="btn btn-primary">Lihat Semua Aktivitas</a>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
