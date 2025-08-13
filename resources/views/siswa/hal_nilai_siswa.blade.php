<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai - SMKS Otto Iskandar Dinata Bandung</title> {{-- Sesuaikan Judul --}}

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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-right: 1px solid var(--border-color);
            flex-shrink: 0; /* Mencegah sidebar mengecil */
        }

        .main-content {
            overflow-y: auto;
            height: 100vh;
            /* width: calc(100% - 280px); /* Ini bisa bermasalah di responsivitas */
            flex-grow: 1; /* Biarkan dia mengisi sisa ruang */
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

        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }

        .pagination .page-link {
            color: var(--primary-blue);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .nilai-badge {
            font-size: 1.1rem;
            font-weight: 700;
            padding: 0.5em 0.7em;
            min-width: 60px;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 0; /* Sembunyikan sidebar di mobile */
                padding: 0 !important;
                overflow: hidden;
            }
            .d-md-flex { /* Override d-flex for sidebar */
                display: none !important;
            }
            .main-content {
                width: 100% !important; /* Main content ambil 100% lebar */
            }
            .header-toggle { /* Tombol toggle navbar di mobile */
                display: block !important;
            }
            .sidebar.show { /* Tampilkan sidebar saat toggle */
                width: 280px;
                display: flex !important;
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 1050; /* Di atas konten lain */
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0 d-flex">
        <div class="sidebar d-none d-md-flex flex-column p-3 bg-white" id="sidebarMenu">
            <a href="{{ route('siswa.dashboard') }}"
                class="d-flex flex-column align-items-center mb-3 text-dark text-decoration-none">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="mb-2">
                <span class="fs-5 fw-bold text-center">SMKS OTTO ISKANDAR DINATA BANDUNG</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="{{ route('siswa.dashboard') }}"
                        class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"><i
                            class="bi bi-house-door-fill me-2"></i>Beranda</a></li>
                <li class="nav-item"><a href="{{ route('siswa.presensi.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.presensi.*') ? 'active' : '' }}"><i
                            class="bi bi-person-check-fill me-2"></i>Presensi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.tugas.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}"><i
                            class="bi bi-card-checklist me-2"></i>Tugas</a></li>
                <li class="nav-item"><a href="{{ route('siswa.materi.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}"><i
                            class="bi bi-book-half me-2"></i>Materi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.nilai.index') }}" class="nav-link active"><i
                            class="bi bi-bar-chart-line-fill me-2"></i>Nilai</a></li>
                <li class="nav-item"><a href="{{ route('siswa.kelas.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.kelas.*') ? 'active' : '' }}"><i
                            class="bi bi-people-fill me-2"></i>Kelas Saya</a></li>
            </ul>
            <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2 fs-4"></i>
                <strong>{{ $user->nama ?? 'Siswa' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><hr class="dropdown-divider">  <li>
                    <a class="dropdown-item" href="{{ route('siswa.profil.show') }}">
                        <i class="bi bi-person-fill-gear me-2"></i>Profil Saya
                    </a>
                </li></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
        </div>

        <div class="main-content flex-grow-1">
            <header class="p-3 mb-4 bg-white border-bottom sticky-top d-flex align-items-center justify-content-between">
                <button class="btn btn-outline-secondary d-md-none header-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0 text-dark fw-bold ms-md-0 ms-3">Rekapitulasi Nilai</h5>
                 <div class="dropdown ms-auto">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-end me-3 d-none d-sm-block">
                            <div class="fw-bold">{{ Auth::user()->nama ?? 'Siswa' }}</div>
                            <small class="text-muted">{{ Auth::user()->role ?? 'Siswa' }}</small>
                        </div>
                        <i class="bi bi-person-circle fs-2 text-secondary"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2"></i>Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="bi bi-box-arrow-right me-2"></i>Keluar</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </header>

            <main class="p-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('siswa.nilai.index') }}" method="GET" class="row g-3 align-items-end">
                            <div class="col-md-10">
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
                                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill me-1"></i>
                                    Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-4" style="width: 5%;">#</th>
                                        <th scope="col" style="width: 25%;">Mata Pelajaran</th>
                                        <th scope="col" style="width: 40%;">Judul Tugas</th>
                                        <th scope="col" style="width: 20%;">Tanggal Dinilai</th>
                                        <th scope="col" class="text-center pe-4" style="width: 10%;">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($nilais as $index => $nilai)
                                        <tr>
                                            <td class="ps-4 fw-bold">{{ $nilais->firstItem() + $index }}</td>
                                            {{-- Perbaiki akses relasi: $nilai->tugas->mataPelajaran->nama_mapel --}}
                                            <td>{{ $nilai->tugas->mataPelajaran->nama_mapel ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('siswa.tugas.show', $nilai->tugas->id) }}"
                                                    class="text-decoration-none fw-semibold">
                                                    {{ $nilai->tugas->judul ?? 'Tugas tidak ditemukan' }}
                                                </a>
                                            </td>
                                            {{-- Perbaiki akses tanggal: $nilai->created_at --}}
                                            <td>{{ $nilai->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</td>
                                            <td class="text-center pe-4">
                                                @php
                                                    $nilaiAngka = $nilai->nilai;
                                                    $badgeClass = 'bg-danger';
                                                    if ($nilaiAngka >= 85)
                                                        $badgeClass = 'bg-success';
                                                    elseif ($nilaiAngka >= 75)
                                                        $badgeClass = 'bg-primary';
                                                    elseif ($nilaiAngka >= 60)
                                                        $badgeClass = 'bg-warning text-dark';
                                                @endphp
                                                <span
                                                    class="badge rounded-pill nilai-badge {{ $badgeClass }}">{{ $nilaiAngka }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center p-5">
                                                <i class="bi bi-journal-x fs-1 text-muted"></i>
                                                <h4 class="mt-3">Belum Ada Nilai</h4>
                                                <p class="text-muted">Tidak ada data nilai yang sesuai dengan filter Anda.</p>
                                                <a href="{{ route('siswa.nilai.index') }}"
                                                    class="btn btn-sm btn-outline-primary mt-2">Tampilkan Semua Nilai</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($nilais->hasPages())
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-center">
                                {{ $nilais->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    {{-- Offcanvas for mobile sidebar --}}
    <div class="offcanvas offcanvas-start bg-white" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu Navigasi</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-3">
             <a href="{{ route('siswa.dashboard') }}"
                class="d-flex flex-column align-items-center mb-3 text-dark text-decoration-none">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="mb-2">
                <span class="fs-5 fw-bold text-center">SMKS OTTO ISKANDAR DINATA BANDUNG</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="{{ route('siswa.dashboard') }}"
                        class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"><i
                            class="bi bi-house-door-fill me-2"></i>Beranda</a></li>
                <li class="nav-item"><a href="{{ route('siswa.presensi.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.presensi.*') ? 'active' : '' }}"><i
                            class="bi bi-person-check-fill me-2"></i>Presensi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.tugas.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}"><i
                            class="bi bi-card-checklist me-2"></i>Tugas</a></li>
                <li class="nav-item"><a href="{{ route('siswa.materi.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}"><i
                            class="bi bi-book-half me-2"></i>Materi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.nilai.index') }}" class="nav-link active"><i
                            class="bi bi-bar-chart-line-fill me-2"></i>Nilai</a></li>
                <li class="nav-item"><a href="{{ route('siswa.kelas.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.kelas.*') ? 'active' : '' }}"><i
                            class="bi bi-people-fill me-2"></i>Kelas Saya</a></li>
            </ul>
        
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>