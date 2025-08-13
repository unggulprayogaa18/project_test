<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Presensi - Nama Sekolah</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 280px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-right: 1px solid #dee2e6;
        }
        .main-content {
            overflow-y: auto;
            height: 100vh;
            width: calc(100% - 280px);
        }
        .sidebar .nav-link {
            color: #495057;
            font-weight: 500;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }
        .sidebar .nav-link:hover {
            color: #123891;
            background-color: #e9ecef;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0A2B7A;
        }
        .sidebar .nav-link .bi {
            font-size: 1.1rem;
        }
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .badge {
            font-size: 0.8rem;
            padding: 0.4em 0.7em;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0 d-flex">

    <!-- Sidebar (Sama seperti di dashboard) -->
    <div class="sidebar d-none d-md-flex flex-column p-3 bg-white">
        <a href="/" class="d-flex flex-column align-items-center mb-3 text-dark text-decoration-none">
            <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
                <span class="fs-5 fw-bold text-center">SMKS OTTO ISKANDAR DINATA BANDUNG</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" aria-current="page">
                    <i class="bi bi-house-door-fill me-2"></i>Beranda
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.presensi.index') }}" class="nav-link {{ request()->routeIs('siswa.presensi.*') ? 'active' : '' }}">
                    <i class="bi bi-person-check-fill me-2"></i>Presensi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.tugas.index') }}" class="nav-link {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}">
                    <i class="bi bi-card-checklist me-2"></i>Tugas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.materi.index') }}" class="nav-link {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}">
                    <i class="bi bi-book-half me-2"></i>Materi
                </a>
            </li>
             <li class="nav-item">
                <a href="{{ route('siswa.nilai.index') }}" class="nav-link {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line-fill me-2"></i>Nilai
                </a>
            </li>
             <li class="nav-item">
                <a href="{{ route('siswa.kelas.index') }}" class="nav-link {{ request()->routeIs('siswa.kelas.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-2"></i>Kelas Saya
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2 fs-4"></i>
                <strong>{{ $user->nama ?? 'Siswa' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><hr class="dropdown-divider">
                  <li>
                    <a class="dropdown-item" href="{{ route('siswa.profil.show') }}">
                        <i class="bi bi-person-fill-gear me-2"></i>Profil Saya
                    </a>
                </li>
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

    <!-- Konten Utama -->
    <div class="main-content flex-grow-1">
        <header class="p-3 mb-4 header sticky-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light d-md-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <h5 class="mb-0 text-dark fw-bold">Riwayat Presensi</h5>
                </div>
                <div class="d-flex align-items-center">
                    <button class="btn btn-light rounded-circle" type="button" style="width: 40px; height: 40px;">
                        <i class="bi bi-bell-fill fs-5"></i>
                    </button>
                </div>
            </div>
        </header>

        <main class="p-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-calendar-check me-2"></i>
                        Data Kehadiran Saya
                    </div>
                </div>
                <div class="card-body">
                    <!-- Formulir Filter -->
                    <form method="GET" action="{{ route('siswa.presensi.index') }}" class="mb-4 p-3 bg-light rounded-3 border">
                        <div class="row align-items-end g-3">
                            <div class="col-md-5">
                                <label for="mata_pelajaran_id" class="form-label fw-bold">Filter Mata Pelajaran</label>
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select">
                                    <option value="">-- Semua Mata Pelajaran --</option>
                                    @foreach ($mataPelajaranOptions as $mapel)
                                        <option value="{{ $mapel->id }}" {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                                </button>
                                <a href="{{ route('siswa.presensi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-repeat me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel Riwayat Presensi -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Mata Pelajaran</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayatPresensi as $absensi)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</td>
                                    <td>{{ $absensi->mataPelajaran->nama_mapel ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @switch($absensi->status)
                                            @case('Hadir')
                                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill">{{ $absensi->status }}</span>
                                                @break
                                            @case('Izin')
                                                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">{{ $absensi->status }}</span>
                                                @break
                                            @case('Sakit')
                                                <span class="badge bg-info-subtle text-info-emphasis rounded-pill">{{ $absensi->status }}</span>
                                                @break
                                            @case('Alpha')
                                                <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">{{ $absensi->status }}</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">{{ $absensi->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $absensi->keterangan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center p-5">
                                        <i class="bi bi-folder2-open fs-3 d-block mb-2"></i>
                                        <p class="mb-0">Data presensi tidak ditemukan.</p>
                                        <small>Coba ubah filter atau hubungi wali kelas jika ada kesalahan.</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
