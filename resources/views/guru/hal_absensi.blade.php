<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Absensi - SMK Otista Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* THEME: Menggunakan tema biru Otista yang konsisten */
        :root {
            --biru-otista: #0A2B7A;
            --merah-menyala: #F20000;
            --kuning-pucat: #FDEEAA;
            --putih: #FFFFFF;
            --hitam: #000000;
            --latar-utama: #f8f9fa;
            --teks-utama: #212529;
            --teks-sekunder: #6c757d;
            --border-color: #dee2e6;
            --hover-bg: #f1f3f5;
        }

        body {
            background-color: var(--latar-utama);
            color: var(--hitam);
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: var(--putih);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand span {
            font-weight: 600;
            color: var(--teks-utama);
        }

        .navbar-nav .nav-link {
            color: var(--teks-sekunder);
            font-weight: 500;
        }

        .navbar-nav .nav-link.active {
            color: var(--biru-otista);
            font-weight: 700;
        }

        .main-content {
            padding: 2.5rem;
        }

        .content-card {
            background-color: var(--putih);
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        }

        .content-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .content-card .card-body {
            padding: 1.5rem;
        }
        
        .content-card .card-footer {
            background-color: transparent;
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }

        .table-custom thead th {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            background-color: var(--biru-otista);
            color: var(--putih);
            border: none;
        }
        
        .table-custom td, .table-custom th {
             vertical-align: middle;
        }

        .item-utama {
            font-weight: 500;
            color: var(--teks-utama);
        }

        .item-sekunder {
            font-size: 0.85em;
            color: var(--teks-sekunder);
        }

        /* STYLE: Tombol radio untuk status absensi */
        .btn-check:checked+.btn-outline-success {
            background-color: #198754;
            color: white;
        }
        .btn-check:checked+.btn-outline-warning {
            background-color: #ffc107;
            color: black;
        }
        .btn-check:checked+.btn-outline-info {
            background-color: #0dcaf0;
            color: black;
        }
        .btn-check:checked+.btn-outline-danger {
            background-color: #dc3545;
            color: white;
        }

        .modal-header { background-color: var(--biru-otista); color: var(--putih); }
        .modal-header .btn-close { filter: invert(1) brightness(2); }
        .btn-primary { background-color: var(--biru-otista); border-color: var(--biru-otista); }
        .btn-primary:hover { background-color: #082261; border-color: #082261; }
              .pagination .page-item.active .page-link {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }

        .pagination .page-link {
            color: var(--biru-otista);
        }
.profile-dropdown .dropdown-toggle, .navbar-nav .nav-link {
    color: var(--teks-sekunder);
    font-weight: 500;
    transition: color 0.3s ease;
}
        /* =================================
           OFFCANVAS (SIDEBAR MOBILE)
        ==================================== */
        .offcanvas {
            background-color: var(--putih);
        }

        .offcanvas-header {
            border-bottom: 1px solid var(--border-color);
        }

        .offcanvas-title {
            color: var(--biru-otista);
            font-weight: 600;
        }

        .offcanvas-body .nav-link {
            color: var(--teks-utama);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .offcanvas-body .nav-link.active,
        .offcanvas-body .nav-link:hover {
            background-color: var(--biru-otista);
            color: var(--putih);
        }

        .offcanvas-body .nav-link:not(.active):hover {
            background-color: var(--hover-bg);
            color: var(--biru-otista);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
                <span class="fs-5 d-none d-sm-inline">SMKS Otto Iskandar Dinata Bandung</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menu Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.dashboard') }}"><i class="bi bi-house-door-fill me-2"></i>Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link"><i class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.materi.index') }}"><i class="bi bi-file-earmark-text-fill me-2"></i>Materi</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.tugas.index') }}"><i class="bi bi-card-checklist me-2"></i>Tugas Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.buatkuis.index') }}"><i class="bi bi-patch-check-fill me-2"></i>Kuis</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.nilai.index') }}"><i class="bi bi-collection-fill me-2"></i>Kelola Nilai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('guru.absensi.index') }}"><i class="bi bi-clipboard-check-fill me-2"></i>Absensi</a>
                        </li> <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.chat.index') }}"><i
                                    class="bi bi-chat-left-dots-fill me-2"></i>Konsultasi Ortu</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center">
                
                <div class="dropdown profile-dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>{{ Auth::user()->nama ?? 'Guru Hebat' }}</strong>
                        <i class="bi bi-person-circle ms-2 fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-light text-small shadow dropdown-menu-end">
                        <li><hr class="dropdown-divider"></li>
                         <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="main-content">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kelola Absensi</li>
            </ol>
        </nav>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>