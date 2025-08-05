<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LMS Otista</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --putih: #FFFFFF;
            --latar-utama: #f5f7fa;
            --teks-utama: #1e293b;
            --teks-sekunder: #64748b;
            --border-color: #e2e8f0;

            /* Warna ikon yang beragam */
            --warna-siswa: #3b82f6;
            --warna-guru: #10b981;
            --warna-materi: #8b5cf6;
        }

        body {
            background-color: var(--latar-utama);
            font-family: 'Poppins', sans-serif;
            color: var(--teks-utama);
        }

        /* STRUKTUR UTAMA: Navigasi Atas */
        .app-header {
            background-color: var(--putih);
            border-bottom: 1px solid var(--border-color);
            padding: 0 1.5rem;
        }

        .app-header .navbar-brand {
            font-weight: 700;
            color: var(--teks-utama);
        }

        .app-header .nav-link {
            color: var(--teks-sekunder);
            font-weight: 500;
            padding: 1.5rem 1rem;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease-in-out;
        }

        .app-header .nav-link:hover {
            color: var(--teks-utama);
        }

        .app-header .nav-link.active {
            color: var(--biru-otista);
            font-weight: 600;
            border-bottom-color: var(--biru-otista);
        }

        .app-header .dropdown-menu {
            border-radius: 0.5rem;
            border-color: var(--border-color);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        /* Header Halaman (di bawah navigasi) */
        .page-header {
            background-color: var(--putih);
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
        }

        /* Kartu Statistik dengan Warna Berbeda */
        .summary-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            background-color: var(--putih);
            box-shadow: none;
            transition: all 0.2s ease-in-out;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.07);
        }

        .summary-card .icon-bg {
            height: 60px;
            width: 60px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }

        .card-siswa .icon-bg {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--warna-siswa);
        }

        .card-guru .icon-bg {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--warna-guru);
        }

        .card-materi .icon-bg {
            background-color: rgba(139, 92, 246, 0.1);
            color: var(--warna-materi);
        }

        .card-title {
            font-weight: 600;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <header class="app-header sticky-top">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/bg.png') }}" alt="Logo" width="32" class="me-2">
                LMS Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Kelola Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="{{ route('admin.hal_matapelajaran') }}">Mata
                                    Pelajaran</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.hal_materi') }}">Materi</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.hal_kelas') }}">Kelas</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Pengguna</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pengaturan</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-end me-3">
                            <div class="fw-bold">{{ Auth::user()->name ?? 'Admin User' }}</div>
                            <small class="text-muted">Administrator</small>
                        </div>
                        <i class="bi bi-person-circle fs-2 text-secondary"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Dashboard</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                    <i class="bi bi-people-fill me-2"></i> Kelola Pengguna
                </a>
            </div>
        </div>
    </div>

    <main class="container-fluid">
        <div class="row g-4">
            <div class="col-md-6 col-xl-4">
                <div class="card summary-card card-siswa">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="icon-bg me-4">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h5 class="card-title">1,250</h5>
                            <h6 class="card-subtitle text-muted">Total Siswa</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card summary-card card-guru">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="icon-bg me-4">
                            <i class="bi bi-person-video3"></i>
                        </div>
                        <div>
                            <h5 class="card-title">75</h5>
                            <h6 class="card-subtitle text-muted">Total Guru</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card summary-card card-materi">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="icon-bg me-4">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <div>
                            <h5 class="card-title">342</h5>
                            <h6 class="card-subtitle text-muted">Total Materi</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>