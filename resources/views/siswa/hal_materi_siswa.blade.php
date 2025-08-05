<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pembelajaran - Nama Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0A2B7A;
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
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

        .materi-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .materi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        
        .materi-card .card-body {
            flex-grow: 1;
        }
        
        .materi-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.75rem;
        }
        
        .pagination .page-link {
            color: var(--primary-blue);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
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
                <li class="nav-item"><a href="{{ route('siswa.materi.index') }}" class="nav-link active"><i class="bi bi-book-half me-2"></i>Materi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.nilai.index') }}" class="nav-link {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}"><i class="bi bi-bar-chart-line-fill me-2"></i>Nilai</a></li>
                <li class="nav-item"><a href="{{ route('siswa.kelas.index') }}" class="nav-link {{ request()->routeIs('siswa.kelas.*') ? 'active' : '' }}"><i class="bi bi-people-fill me-2"></i>Kelas Saya</a></li>
            </ul>
            <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2 fs-4"></i>
                <strong>{{ $user->nama ?? 'Siswa' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{ route('siswa.profil.show') }}">Profil Saya</a></li>
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
                <h5 class="mb-0 text-dark fw-bold">Materi Pembelajaran</h5>
            </header>

            <main class="p-4">
                <!-- Filter Form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('siswa.materi.index') }}" method="GET" class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label for="search" class="form-label">Cari Judul Materi</label>
                                <input type="text" class="form-control" id="search" name="search" placeholder="Contoh: Bab 1 Aljabar" value="{{ $request->search ?? '' }}">
                            </div>
                            <div class="col-md-5">
                                <label for="mata_pelajaran_id" class="form-label">Filter Mata Pelajaran</label>
                                <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id">
                                    <option value="">Semua Mata Pelajaran</option>
                                    @foreach($mataPelajarans as $mapel)
                                        <option value="{{ $mapel->id }}" {{ ($request->mata_pelajaran_id == $mapel->id) ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-grid">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i> Cari</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($materis->isEmpty())
                    <div class="text-center p-5 bg-white rounded-3 border">
                        <i class="bi bi-journal-x fs-1 text-muted"></i>
                        <h3 class="mt-3 fw-bold">Materi Tidak Ditemukan</h3>
                        <p class="lead text-muted">Tidak ada materi yang sesuai dengan kriteria pencarian Anda.</p>
                        <a href="{{ route('siswa.materi.index') }}" class="btn btn-outline-primary mt-3">Tampilkan Semua Materi</a>
                    </div>
                @else
                    <div class="materi-card-grid">
                        @foreach($materis as $materi)
                            <div class="card materi-card">
                                <div class="card-body p-4">
                                    <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill mb-3 align-self-start">{{ $materi->mataPelajaran->nama_mapel ?? 'Umum' }}</span>
                                    <h5 class="card-title fw-bold mb-2">{{ $materi->judul }}</h5>
                                    <p class="card-text text-muted small mb-4">Diunggah pada: {{ $materi->created_at->isoFormat('D MMMM YYYY') }}</p>
                                    <p class="card-text text-body-secondary flex-grow-1">{{ Str::limit($materi->deskripsi, 120) }}</p>
                                    <a href="{{ route('siswa.materi.show', $materi->id) }}" class="btn btn-outline-primary mt-3 align-self-start">
                                        <i class="bi bi-book-half me-1"></i> Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $materis->appends(request()->query())->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
