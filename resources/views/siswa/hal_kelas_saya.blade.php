<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas Saya - {{ $kelas->nama_kelas ?? 'Nama Sekolah' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0A2B7A;
            --secondary-blue: #4a69bd;
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
            --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }
        
        body {
            height: 100vh;
            overflow-x: hidden;
            background-color: var(--light-gray);
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 280px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-right: 1px solid var(--border-color);
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
            transition: background-color 0.2s, color 0.2s;
        }
        .sidebar .nav-link:hover {
            color: var(--primary-blue);
            background-color: #e9ecef;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--primary-blue);
        }
        
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: var(--card-shadow);
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0 d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-none d-md-flex flex-column p-3 bg-white">
            <a href="{{ route('siswa.dashboard') }}" class="d-flex flex-column align-items-center mb-3 text-dark text-decoration-none">
                 <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
                <span class="fs-5 fw-bold text-center">SMKS OTTO ISKANDAR DINATA BANDUNG</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"><i class="bi bi-house-door-fill me-2"></i>Beranda</a></li>
                <li class="nav-item"><a href="{{ route('siswa.presensi.index') }}" class="nav-link {{ request()->routeIs('siswa.presensi.*') ? 'active' : '' }}"><i class="bi bi-person-check-fill me-2"></i>Presensi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.tugas.index') }}" class="nav-link {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}"><i class="bi bi-card-checklist me-2"></i>Tugas</a></li>
                <li class="nav-item"><a href="{{ route('siswa.materi.index') }}" class="nav-link {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}"><i class="bi bi-book-half me-2"></i>Materi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.nilai.index') }}" class="nav-link {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}"><i class="bi bi-bar-chart-line-fill me-2"></i>Nilai</a></li>
                <li class="nav-item"><a href="{{ route('siswa.kelas.index') }}" class="nav-link active"><i class="bi bi-people-fill me-2"></i>Kelas Saya</a></li>
            </ul>
            <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2 fs-4"></i>
                <strong>{{ $user->nama ?? 'Siswa' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <header class="p-3 mb-4 bg-white border-bottom sticky-top">
                <h5 class="mb-0 text-dark fw-bold">Informasi Kelas Saya</h5>
            </header>

            <main class="p-4">
                <!-- Jumbotron Header Kelas -->
                <div class="p-5 mb-4 rounded-3" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white;">
                    <div class="container-fluid py-3">
                        <h1 class="display-4 fw-bold">{{ $kelas->nama_kelas }}</h1>
                        <p class="fs-5 col-md-8">Tahun Ajaran {{ $kelas->tahun_ajaran }} - Tingkat {{ $kelas->tingkat }}</p>
                        <hr class="my-4">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-video3 fs-4 me-2"></i>
                                <div>
                                    <small class="d-block" style="opacity: 0.8;">Wali Kelas</small>
                                    <strong class="d-block">{{ $kelas->waliKelas->nama ?? 'Belum ditentukan' }}</strong>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people-fill fs-4 me-2"></i>
                                <div>
                                    <small class="d-block" style="opacity: 0.8;">Jumlah Siswa</small>
                                    <strong class="d-block">{{ $kelas->siswas->count() }} Orang</strong>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-book-fill fs-4 me-2"></i>
                                <div>
                                    <small class="d-block" style="opacity: 0.8;">Mata Pelajaran</small>
                                    <strong class="d-block">{{ $kelas->mataPelajarans->count() }} Mapel</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Kolom Kiri: Daftar Siswa -->
                    <div class="col-lg-7">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                               <h6 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Daftar Anggota Kelas</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless align-middle mb-0">
                                        <tbody>
                                            @foreach ($kelas->siswas as $index => $teman)
                                                <tr class="{{ $teman->id == $user->id ? 'table-light' : '' }}">
                                                    <td class="text-center" style="width: 10%;">
                                                        <span class="fw-bold text-muted">{{ $index + 1 }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold">{{ $teman->nama }}</div>
                                                        <small class="text-muted">{{ $teman->nomor_induk ?? 'N/A' }}</small>
                                                    </td>
                                                    <td class="text-end pe-3">
                                                         @if ($teman->id == $user->id)
                                                            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Ini Anda</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan: Mata Pelajaran -->
                    <div class="col-lg-5">
                        <div class="card h-100">
                             <div class="card-header bg-white">
                                <h6 class="mb-0 fw-bold"><i class="bi bi-journal-bookmark-fill me-2 text-primary"></i>Mata Pelajaran & Guru</h6>
                            </div>
                            <div class="list-group list-group-flush">
                                @forelse ($kelas->mataPelajarans as $mapel)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $mapel->nama_mapel }}</h6>
                                            <small class="text-muted">
                                                {{ $mapel->gurus->first()->nama ?? 'N/A' }}
                                            </small>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </div>
                                @empty
                                    <div class="list-group-item text-center p-4">
                                        <p class="mb-0 text-muted">Belum ada mata pelajaran yang ditambahkan.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
