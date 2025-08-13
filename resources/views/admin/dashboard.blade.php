<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIKS OTISTA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A; --putih: #FFFFFF; --latar-utama: #f8f9fa;
            --teks-utama: #1e293b; --teks-sekunder: #64748b; --border-color: #e2e8f0; --sidebar-width: 260px;
            --warna-siswa: #3b82f6; --warna-guru: #10b981; --warna-materi: #8b5cf6;
        }
        body { background-color: var(--latar-utama); font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        .app-wrapper { display: flex; min-height: 100vh; }
        .sidebar {
            width: var(--sidebar-width); min-width: var(--sidebar-width); background-color: var(--putih);
            border-right: 1px solid var(--border-color); display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; height: 100vh; z-index: 1030; transition: transform 0.3s ease-in-out;
        }
        .sidebar-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); }
        .sidebar-header .navbar-brand { font-weight: 600; font-size: 1.25rem; color: var(--teks-utama); }
        .sidebar-nav { flex-grow: 1; padding: 1rem 0; }
        .nav-link {
            display: flex; align-items: center; padding: 0.85rem 1.5rem; color: var(--teks-sekunder);
            font-weight: 500; border-left: 4px solid transparent; transition: all 0.2s; text-decoration: none;
        }
        .nav-link i { font-size: 1.2rem; width: 25px; margin-right: 1rem; color: #94a3b8; transition: all 0.2s; }
        .nav-link:hover { background-color: var(--latar-utama); color: var(--biru-otista); }
        .nav-link:hover i { color: var(--biru-otista); }
        .nav-link.active {
            color: var(--biru-otista); background-color: #eef2ff; font-weight: 600; border-left-color: var(--biru-otista);
        }
        .nav-link.active i { color: var(--biru-otista); }
        .nav-link[data-bs-toggle="collapse"]::after {
            content: '\F282'; font-family: 'bootstrap-icons'; font-weight: bold;
            margin-left: auto; transition: transform 0.2s ease-in-out;
        }
        .nav-link[data-bs-toggle="collapse"][aria-expanded="true"]::after { transform: rotate(-180deg); }
        .sidebar-submenu { padding-left: 1.5rem; background-color: #fafbff; }
        .sidebar-submenu .nav-link { padding-top: 0.65rem; padding-bottom: 0.65rem; font-size: 0.9rem; }
        .sidebar-submenu .nav-link::before { content: "—"; margin-right: 1.2rem; color: #cbd5e1; }
        .sidebar-submenu .nav-link.active, .sidebar-submenu .nav-link:hover { color: var(--biru-otista); background: none; border-left-color: transparent; font-weight: 600; }
        .sidebar-submenu .nav-link.active::before { color: var(--biru-otista); }
        .sidebar-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); }
        .sidebar-footer .dropdown-toggle::after { display: none; }
        .main-content {
            flex-grow: 1; margin-left: var(--sidebar-width); display: flex;
            flex-direction: column; transition: margin-left 0.3s ease-in-out;
        }
        .topbar {
            background-color: var(--putih); border-bottom: 1px solid var(--border-color); padding: 0.75rem 1.5rem;
            display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1020;
        }
        .sidebar-toggler { font-size: 1.5rem; display: none; color: var(--teks-sekunder); }
        .page-header { padding: 1.5rem; border-bottom: 1px solid var(--border-color); background-color: var(--putih); }
        .page-header h1 { font-weight: 700; font-size: 1.75rem; }
        .summary-card {
            border-radius: 0.75rem; background-color: var(--putih); transition: all 0.2s ease-in-out;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03); border: 1px solid var(--border-color);
        }
        .summary-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.07); }
        .summary-card .icon-bg {
            height: 60px; width: 60px; border-radius: 0.5rem; display: flex;
            align-items: center; justify-content: center; font-size: 1.75rem;
        }
        .card-siswa .icon-bg { background-color: rgba(59, 130, 246, 0.1); color: var(--warna-siswa); }
        .card-guru .icon-bg { background-color: rgba(16, 185, 129, 0.1); color: var(--warna-guru); }
        .card-materi .icon-bg { background-color: rgba(139, 92, 246, 0.1); color: var(--warna-materi); }
        .summary-card .card-title { font-weight: 600; font-size: 1.5rem; }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            body.sidebar-visible .sidebar { transform: translateX(0); box-shadow: 0 0 2rem rgba(0,0,0,0.15); }
            .main-content { margin-left: 0; }
            .sidebar-toggler { display: block; }
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('images/bg.png') }}" alt="Logo" width="40" height="40" class="me-2">
                    <span><strong style="color: var(--biru-otista);">SIKS</strong> OTISTA</span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-1x2-fill"></i><span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#submenu-kelola" role="button" aria-expanded="false">
                            <i class="bi bi-stack"></i><span>Kelola Data</span>
                        </a>
                        <div class="collapse" id="submenu-kelola">
                            <ul class="nav flex-column sidebar-submenu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.hal_matapelajaran') }}">Mata Pelajaran</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.hal_materi') }}">Materi</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.hal_kelas') }}">Kelas</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Pengguna</a></li>
                            </ul>
                        </div>
                    </li>
                    {{-- ===== BAGIAN YANG DIUBAH (Laporan menjadi accordion) ===== --}}
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#submenu-laporan" role="button" aria-expanded="false">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i><span>Laporan</span>
                        </a>
                        <div class="collapse" id="submenu-laporan">
                             <ul class="nav flex-column sidebar-submenu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.laporan.index') }}">Raport Siswa</a></li>
                             </ul>
                        </div>
                    </li>
                    {{-- ========================================================== --}}
                    <li class="nav-item">
                    </li>
                </ul>
            </nav>
            {{-- ===== BAGIAN YANG DIPINDAHKAN (Profil Pengguna) ===== --}}
            <div class="sidebar-footer">
                <div class="dropdown dropup">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-2 text-secondary"></i>
                        <div class="text-start ms-3">
                            <div class="fw-bold">{{ Auth::user()->nama ?? 'Admin User' }}</div>
                            <small class="text-muted">Administrator</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a><form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form></li>
                    </ul>
                </div>
            </div>
            {{-- ====================================================== --}}
        </aside>

        <div class="main-content">
            <header class="topbar">
                <button class="btn border-0 sidebar-toggler"><i class="bi bi-list"></i></button>
                {{-- KOSONGKAN BAGIAN INI KARENA PROFIL SUDAH PINDAH --}}
                <div></div> 
            </header>

            <div class="page-header">
                <div class="container-fluid">
                    <h1>Dashboard</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <main class="container-fluid p-4">
                <div class="row g-4">
                    <div class="col-md-6 col-xl-4">
                        <div class="card summary-card card-siswa">
                            <div class="card-body d-flex align-items-center p-4">
                                <div class="icon-bg me-4"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <h5 class="card-title">{{ $totalSiswa ?? 0 }}</h5>
                                    <h6 class="card-subtitle text-muted">Total Siswa</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card summary-card card-guru">
                            <div class="card-body d-flex align-items-center p-4">
                                <div class="icon-bg me-4"><i class="bi bi-person-video3"></i></div>
                                <div>
                                    <h5 class="card-title">{{ $totalGuru ?? 0 }}</h5>
                                    <h6 class="card-subtitle text-muted">Total Guru</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card summary-card card-materi">
                            <div class="card-body d-flex align-items-center p-4">
                                <div class="icon-bg me-4"><i class="bi bi-book-half"></i></div>
                                <div>
                                    <h5 class="card-title">{{ $totalMateri ?? 0 }}</h5>
                                    <h6 class="card-subtitle text-muted">Total Materi</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggler = document.querySelector('.sidebar-toggler');
            if (sidebarToggler) {
                sidebarToggler.addEventListener('click', function () {
                    document.body.classList.toggle('sidebar-visible');
                });
            }
        });
    </script>
</body>
</html>