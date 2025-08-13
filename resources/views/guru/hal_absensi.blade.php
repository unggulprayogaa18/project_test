<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Absensi - SMK Otista Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --putih: #FFFFFF;
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
        
        /* Card, Table, and Other Styles */
        .content-card {
            background-color: var(--putih);
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        }
        .content-card .card-header, .content-card .card-body, .content-card .card-footer {
            padding: 1.5rem;
        }
        .content-card .card-header {
            border-bottom: 1px solid var(--border-color);
            background-color: transparent;
        }
         .content-card .card-footer {
            border-top: 1px solid var(--border-color);
            background-color: transparent;
        }

        .table-custom thead {
            background-color: var(--biru-otista);
            color: var(--putih);
        }

        .table-custom th,
        .table-custom td {
            vertical-align: middle;
        }

        .item-utama {
            font-weight: 500;
        }
        .item-sekunder {
            font-size: 0.85em;
            color: var(--teks-sekunder);
        }
        
        /* Radio button styles */
        .btn-check:checked+.btn-outline-success { background-color: #198754; color: white; }
        .btn-check:checked+.btn-outline-warning { background-color: #ffc107; color: black; }
        .btn-check:checked+.btn-outline-info { background-color: #0dcaf0; color: black; }
        .btn-check:checked+.btn-outline-danger { background-color: #dc3545; color: white; }

        .btn-primary { background-color: var(--biru-otista); border-color: var(--biru-otista); }
        .btn-primary:hover { background-color: #082261; border-color: #082261; }
        
        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -var(--sidebar-width);
                position: absolute;
                top: 0;
                bottom: 0;
                z-index: 1045;
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
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <i class="bi bi-house-door-fill"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link">
                        <i class="bi bi-journal-bookmark-fill"></i>Mata Pelajaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.tugas.index') }}">
                        <i class="bi bi-card-checklist"></i>Tugas Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.buatkuis.index') }}">
                        <i class="bi bi-patch-check-fill"></i>Kuis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.nilai.index') }}">
                        <i class="bi bi-collection-fill"></i>Kelola Nilai
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('guru.absensi.index') }}">
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
                            <strong class="d-block">{{ Auth::user()->nama ?? 'Guru Hebat' }}</strong>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow w-100">
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
        </nav>

        <div id="content">
            <header class="topbar">
                 <button type="button" id="sidebarCollapse" class="sidebar-toggler">
                    <i class="bi bi-list"></i>
                </button>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Absensi</li>
                    </ol>
                </nav>
            </header>

            <main>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card content-card">
                    <div class="card-header">
                        <h4 class="fw-bold">Absensi Siswa</h4>
                        <p class="text-muted">Pilih kelas dan tanggal untuk melakukan absensi.</p>
                        <form class="row g-3" role="search" method="GET" action="{{ route('guru.absensi.index') }}">
                            <div class="col-md-5">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select class="form-select" name="kelas_id" id="kelas_id" onchange="this.form.submit()" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ $selectedTanggal ?? date('Y-m-d') }}" onchange="this.form.submit()" required>
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-filter"></i> Tampilkan</button>
                            </div>
                        </form>
                    </div>

                    @if ($siswaList->isNotEmpty())
                    <form action="{{ route('guru.absensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tanggal" value="{{ $selectedTanggal }}">
                        <input type="hidden" name="kelas_id" value="{{ $selectedKelasId }}">
                        
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="mata_pelajaran_id" class="form-label fw-bold">Pilih Mata Pelajaran untuk Sesi Absensi Ini</label>
                                <select class="form-select" name="mata_pelajaran_id" id="mata_pelajaran_id" required>
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($mataPelajaranList as $mapel)
                                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th class="ps-4" style="width: 5%;">#</th>
                                            <th style="width: 30%;">Nama Siswa</th>
                                            <th style="width: 45%;">Status Kehadiran</th>
                                            <th style="width: 20%;">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswaList as $index => $siswa)
                                        @php
                                            $absen = $siswa->absensi->where('tanggal', $selectedTanggal)->first();
                                            $status = $absen->status ?? 'Hadir'; // Default ke Hadir
                                        @endphp
                                        <tr>
                                            <td class="ps-4 fw-bold">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="item-utama">{{ $siswa->nama }}</div>
                                                <div class="item-sekunder">NIS: {{ $siswa->nis ?? '-' }}</div>
                                                <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $siswa->id }}">
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <input type="radio" class="btn-check" name="absensi[{{ $index }}][status]" id="hadir-{{$siswa->id}}" value="Hadir" autocomplete="off" {{ $status == 'Hadir' ? 'checked' : '' }}>
                                                    <label class="btn btn-sm btn-outline-success" for="hadir-{{$siswa->id}}">Hadir</label>

                                                    <input type="radio" class="btn-check" name="absensi[{{ $index }}][status]" id="sakit-{{$siswa->id}}" value="Sakit" autocomplete="off" {{ $status == 'Sakit' ? 'checked' : '' }}>
                                                    <label class="btn btn-sm btn-outline-warning" for="sakit-{{$siswa->id}}">Sakit</label>
                                                    
                                                    <input type="radio" class="btn-check" name="absensi[{{ $index }}][status]" id="izin-{{$siswa->id}}" value="Izin" autocomplete="off" {{ $status == 'Izin' ? 'checked' : '' }}>
                                                    <label class="btn btn-sm btn-outline-info" for="izin-{{$siswa->id}}">Izin</label>

                                                    <input type="radio" class="btn-check" name="absensi[{{ $index }}][status]" id="alpa-{{$siswa->id}}" value="Alpa" autocomplete="off" {{ $status == 'Alpa' ? 'checked' : '' }}>
                                                    <label class="btn btn-sm btn-outline-danger" for="alpa-{{$siswa->id}}">Alpa</label>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="absensi[{{ $index }}][keterangan]" value="{{ $absen->keterangan ?? '' }}" placeholder="Opsional">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Absensi
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="card-body">
                        <div class="text-center py-5">
                            <i class="bi bi-people" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="mt-2 text-muted">Silakan pilih kelas dan tanggal untuk menampilkan daftar siswa.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Script untuk toggle sidebar di mode mobile
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