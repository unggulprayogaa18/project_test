<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Siswa - Nama Sekolah</title>

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

        .task-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .task-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .task-card .card-footer {
            background-color: transparent;
            border-top: 1px solid var(--border-color);
        }

        .task-detail {
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            color: #6c757d;
        }

        .task-detail i {
            width: 20px;
            text-align: center;
            margin-right: 0.75rem;
            color: var(--primary-blue);
        }

        .task-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
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
            <a href="{{ route('siswa.dashboard') }}"
                class="d-flex flex-column align-items-center mb-3 text-dark text-decoration-none">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
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
                <li class="nav-item"><a href="{{ route('siswa.tugas.index') }}" class="nav-link active"><i
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
                <h5 class="mb-0 text-dark fw-bold">Daftar Tugas</h5>
            </header>

            <main class="p-4">
                @if($tugasList->isEmpty())
                    <div class="text-center p-5 bg-white rounded-3 border">
                        <i class="bi bi-check2-circle fs-1 text-success"></i>
                        <h3 class="mt-3 fw-bold">Kerja Bagus!</h3>
                        <p class="lead text-muted">Saat ini tidak ada tugas yang perlu dikerjakan.</p>
                    </div>
                @else
                    <div class="task-card-grid">
                        @foreach($tugasList as $tugas)
                            <div class="card task-card">
                                <div class="card-body p-4">
                                    <span
                                        class="badge bg-primary-subtle text-primary-emphasis rounded-pill mb-3 align-self-start">{{ $tugas->mataPelajaran->nama_mapel ?? 'Mata Pelajaran Umum' }}</span>
                                    <h5 class="card-title fw-bold mb-3">{{ $tugas->judul }}</h5>

                                    <div class="task-detail">
                                        <i class="bi bi-person-fill"></i>
                                        <span>Oleh: {{ $tugas->guru->nama ?? 'N/A' }}</span>
                                    </div>
                                    <div class="task-detail">
                                        <i class="bi bi-tag-fill"></i>
                                        <span>Jenis: {{ $tugas->kuis_id ? 'Kuis Online' : 'Tugas Biasa' }}</span>
                                    </div>
                                    <div class="task-detail">
                                        <i class="bi bi-calendar-event"></i>
                                        <span>Deadline: {{ $tugas->batas_waktu->isoFormat('D MMM Y, HH:mm') }}</span>
                                    </div>
                                    <div
                                        class="task-detail fw-semibold {{ $tugas->batas_waktu->isPast() ? 'text-danger' : 'text-success' }}">
                                        <i class="bi bi-clock-history"></i>
                                        <span>Sisa Waktu: {{ $tugas->sisa_waktu_display }}</span>
                                    </div>

                                    <div class="mt-auto"></div> <!-- Spacer -->
                                </div>
                                <div class="card-footer p-3 d-flex justify-content-between align-items-center">
                                    @php
                                        $statusConfig = [
                                            'belum_dikerjakan' => ['class' => 'danger', 'text' => 'Belum Dikerjakan'],
                                            'sudah_dikumpulkan' => ['class' => 'success', 'text' => 'Sudah Dikumpulkan'],
                                            'terlambat' => ['class' => 'secondary', 'text' => 'Terlambat'],
                                        ];
                                        $currentStatus = $tugas->status_display;
                                        $config = $statusConfig[$currentStatus] ?? ['class' => 'light', 'text' => 'N/A'];
                                    @endphp
                                    <span
                                        class="badge bg-{{$config['class']}}-subtle text-{{$config['class']}}-emphasis rounded-pill">{{ $config['text'] }}</span>

                                    <a href="{{ route('siswa.tugas.show', $tugas->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $tugasList->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>