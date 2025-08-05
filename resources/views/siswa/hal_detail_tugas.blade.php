<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tugas: {{ $tugas->judul }} - SMKS OTTO ISKANDAR DINATA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* CSS ini diambil dari halaman Dashboard Anda yang sudah benar */
        :root {
            --primary-blue: #0A2B7A;
            --secondary-blue: #4a69bd;
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            height: 100vh;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 280px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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
            color: var(--primary-blue);
            background-color: #e9ecef;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--primary-blue);
        }

        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0 d-flex">

        <div class="sidebar d-none d-md-flex flex-column p-3 bg-white">
            <a href="{{ route('siswa.dashboard') }}" class="d-flex flex-column align-items-center mb-3 text-dark text-decoration-none">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="mb-2">
                <span class="fs-6 fw-bold text-center">SMKS OTTO ISKANDAR DINATA</span>
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
                <li class="nav-item"><a href="{{ route('siswa.nilai.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}"><i
                            class="bi bi-bar-chart-line-fill me-2"></i>Nilai</a></li>
                <li class="nav-item"><a href="{{ route('siswa.kelas.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.kelas.*') ? 'active' : '' }}"><i
                            class="bi bi-people-fill me-2"></i>Kelas Saya</a></li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2 fs-4"></i>
                    <strong>{{ $user->nama ?? 'Siswa' }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="{{ route('siswa.profil.show') }}">Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bi bi-box-arrow-right me-2"></i>Keluar</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content flex-grow-1">
            <header class="p-3 mb-4 header sticky-top">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('siswa.tugas.index') }}">Tugas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($tugas->judul, 30) }}</li>
                    </ol>
                </nav>
            </header>

            <main class="p-4">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <span class="badge bg-primary-subtle text-primary-emphasis mb-3">{{ $tugas->mataPelajaran->nama_mapel ?? 'Mata Pelajaran Umum' }}</span>
                                <h1 class="h3 fw-bold mb-3">{{ $tugas->judul }}</h1>
                                <div class="d-flex align-items-center text-muted mb-4">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    <span>Batas Waktu: {{ \Carbon\Carbon::parse($tugas->batas_waktu)->isoFormat('dddd, D MMMM YYYY, HH:mm') }} WIB</span>
                                    @if(now()->gt($tugas->batas_waktu))
                                        <span class="badge bg-danger-subtle text-danger-emphasis ms-3">Telah Berakhir</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success-emphasis ms-3">Aktif</span>
                                    @endif
                                </div>

                                <h5 class="fw-semibold">Deskripsi Tugas</h5>
                                <div class="text-body-secondary mb-4">
                                    {!! nl2br(e($tugas->deskripsi)) !!}
                                </div>

                                <div class="text-center mt-5">
                                    @if ($pengumpulan)
                                        <div class="alert alert-success">
                                            <i class="bi bi-check-circle-fill me-2"></i>Anda sudah mengerjakan tugas ini pada {{ $pengumpulan->created_at->isoFormat('D MMMM YYYY, HH:mm') }}.
                                        </div>
                                        @if($tugas->kuis_id)
                                            <a href="{{ route('siswa.kuis.hasil', $tugas->kuis_id) }}" class="btn btn-lg btn-outline-info">
                                                <i class="bi bi-patch-check-fill me-2"></i>Lihat Hasil Kuis
                                            </a>
                                        @else
                                            <a href="{{ route('siswa.tugas.hasil', $tugas->id) }}" class="btn btn-lg btn-outline-success">
                                                <i class="bi bi-eye-fill me-2"></i>Lihat Hasil Pengumpulan
                                            </a>
                                        @endif
                                    @elseif (now()->gt($tugas->batas_waktu))
                                        <button class="btn btn-lg btn-secondary" disabled>
                                            <i class="bi bi-x-circle-fill me-2"></i>Waktu Pengerjaan Habis
                                        </button>
                                    @else
                                        @if($tugas->kuis_id)
                                            <a href="{{ route('siswa.kuis.kerjakan', $tugas->kuis_id) }}" class="btn btn-lg btn-primary">
                                                <i class="bi bi-pencil-square me-2"></i> Kerjakan Kuis
                                            </a>
                                        @else
                                            <a href="{{ route('siswa.tugas.kerjakan', $tugas->id) }}" class="btn btn-lg btn-primary">
                                                <i class="bi bi-upload me-2"></i> Kerjakan Tugas
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <i class="bi bi-paperclip me-2"></i>Materi & Kuis Terkait
                            </div>
                            <div class="card-body">
                                @if(!$tugas->materi && !$tugas->kuis)
                                    <p class="text-muted text-center p-3">Tidak ada materi atau kuis yang terhubung.</p>
                                @else
                                    <ul class="list-group list-group-flush">
                                        @if($tugas->materi)
                                            <li class="list-group-item">
                                                <h6 class="fw-semibold">Materi Pendukung</h6>
                                                <p class="mb-2 text-muted">{{ $tugas->materi->judul }}</p>
                                                <a href="{{ route('siswa.materi.show', $tugas->materi->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-book-half me-1"></i> Buka Materi
                                                </a>
                                            </li>
                                        @endif
                                        @if($tugas->kuis)
                                            <li class="list-group-item">
                                                <h6 class="fw-semibold">Kuis Terhubung</h6>
                                                <p class="mb-2 text-muted">{{ $tugas->kuis->judul_kuis }}</p>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
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