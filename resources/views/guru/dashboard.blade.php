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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --putih: #ffffff;
            --latar-utama: #f4f7fc;
            --teks-utama: #343a40;
            --teks-sekunder: #6c757d;
            --border-color: #e9ecef;
            --hover-bg: #eef2ff;
            --sidebar-width: 260px;
        }

        body {
            background-color: var(--latar-utama);
            color: var(--teks-utama);
            font-family: 'Poppins', sans-serif;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background-color: var(--putih);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .sidebar-header span {
            font-weight: 600;
            color: var(--teks-utama);
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex-grow: 1;
        }

        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            color: var(--teks-sekunder);
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .sidebar-menu .nav-link i {
            margin-right: 1rem;
            font-size: 1.2rem;
            width: 25px;
            text-align: center;
        }
        
        .sidebar-menu .nav-link:hover {
            color: var(--biru-otista);
            background-color: var(--hover-bg);
        }
        
        .sidebar-menu .nav-link.active {
            color: var(--biru-otista);
            background-color: var(--hover-bg);
            border-left-color: var(--biru-otista);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        .profile-dropdown .dropdown-toggle {
            color: var(--teks-sekunder);
            text-decoration: none;
        }
        .profile-dropdown .dropdown-toggle:hover {
            color: var(--biru-otista);
        }
        .profile-dropdown .dropdown-menu {
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Content & Topbar Styling */
        #content {
            flex-grow: 1;
            padding: 1.5rem 2.5rem;
            overflow-y: auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .sidebar-toggler {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--teks-sekunder);
            display: none;
        }
        .topbar-right {
            display: flex;
            align-items: center;
        }
        .btn-notification {
            background: none;
            border: none;
            color: var(--teks-sekunder);
        }
        .btn-notification:hover {
            color: var(--biru-otista);
        }

        /* Card & Other Styles (Unchanged) */
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
            background-color: #f8f9fa;
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
        .btn-primary {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }
        .btn-primary:hover {
            background-color: #082261;
            border-color: #082261;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -var(--sidebar-width);
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                padding: 1.5rem;
            }
            .sidebar-toggler {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="40" class="me-3">
                <span class="fs-5">Guru Panel</span>
            </div>
            <ul class="nav flex-column sidebar-menu">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">
                        <i class="bi bi-house-door-fill"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('guru.hal_matapelajaran') }}" class="nav-link">
                        <i class="bi bi-journal-bookmark-fill"></i>Mata Pelajaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.hal_tugas') }}">
                        <i class="bi bi-card-checklist"></i>Tugas Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.hal_buat_kuis') }}">
                        <i class="bi bi-patch-check-fill"></i>Kuis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guru.nilai.index') ? 'active' : '' }}" href="{{ route('guru.nilai.index') }}">
                        <i class="bi bi-collection-fill"></i>Kelola Nilai
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.absensi.index') }}">
                        <i class="bi bi-clipboard-check-fill"></i>Absensi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('guru.chat.index') }}">
                        <i class="bi bi-chat-left-dots-fill"></i>Konsultasi Ortu
                    </a>
                </li>
            </ul>
             <div class="sidebar-footer">
                <div class="dropdown profile-dropdown">
                    <a href="#" class="d-flex w-100 align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2 fs-2"></i>
                        <div>
                            <strong class="d-block">{{ $guru->nama ?? 'Guru Hebat' }}</strong>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow w-100">
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="content">
            <div class="topbar">
                <button type="button" id="sidebarCollapse" class="sidebar-toggler">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-right">
                    <div class="dropdown notification-dropdown">
                        <button class="btn btn-notification position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell-fill fs-4"></i>
                            @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                    {{ $unreadMessagesCount }}
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 350px;">
                            <li class="p-2 border-bottom">
                                <h6 class="dropdown-header">Notifikasi Pesan</h6>
                            </li>
                            <div style="max-height: 400px; overflow-y: auto;">
                                @forelse($unreadMessages as $message)
                                <li>
                                    <a class="dropdown-item notification-item p-3" href="{{ route('guru.chat.show', $message->user) }}">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-person-circle fs-3 me-3"></i>
                                            <div>
                                                <div class="fw-bold">{{ $message->user->nama }}</div>
                                                <div class="text-muted text-truncate" style="max-width: 250px;">{{ $message->body }}</div>
                                                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @empty
                                <li><p class="text-center text-muted p-3 mb-0">Tidak ada notifikasi baru.</p></li>
                                @endforelse
                            </div>
                            <li class="p-2 text-center border-top">
                                <a href="{{ route('guru.chat.index') }}">Lihat Semua Konsultasi</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <main>
                <div class="p-4 mb-4 text-white rounded-3" style="background-color: var(--biru-otista);">
                    <h2>Selamat Datang, {{ $guru->nama ?? 'Guru Hebat' }}!</h2>
                    <p class="lead">Ini adalah ringkasan aktivitas mengajar Anda. Mari kita mulai hari dengan semangat! 🌞</p>
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
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');

            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function () {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
</body>

</html>