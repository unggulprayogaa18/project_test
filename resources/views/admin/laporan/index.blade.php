<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - SIKS OTISTA</title>
    {{-- Link CSS dan Font --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --biru-otista: #0A2B7A; --putih: #FFFFFF; --latar-utama: #f8f9fa;
            --teks-utama: #1e293b; --teks-sekunder: #64748b; --border-color: #e2e8f0; --sidebar-width: 260px;
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
        .card { border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.03); }
        .table-custom thead th { background-color: #f8f9fa; color: var(--teks-utama); font-weight: 600; border-bottom: 2px solid var(--border-color); }
        .table-custom td { vertical-align: middle; }
        
        .raport-header { border-bottom: 2px solid #dee2e6; padding-bottom: 1rem; margin-bottom: 1.5rem; }
        .table-raport th { background-color: #f8f9fa; }
        @media print {
            body * { visibility: hidden; }
            .sidebar, .topbar, .page-header, .no-print { display: none; }
            .main-content { margin-left: 0 !important; }
            .print-area, .print-area * { visibility: visible; }
            .print-area { position: absolute; left: 0; top: 0; width: 100%; padding: 1rem; }
        }
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
        {{-- ===== SIDEBAR BARU YANG SESUAI DENGAN DASHBOARD ===== --}}
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/bg.png') }}" alt="Logo" width="40" height="40" class="me-2">
                    <span><strong style="color: var(--biru-otista);">SIKS</strong> OTISTA</span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-1x2-fill"></i><span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#submenu-kelola" role="button" aria-expanded="false">
                            <i class="bi bi-stack"></i><span>Kelola Data</span>
                        </a>
                        <div class="collapse" id="submenu-kelola">
                            <ul class="nav flex-column sidebar-submenu">
                                {{-- Ganti route() di bawah ini sesuai nama rute Anda jika berbeda --}}
                                <li class="nav-item"><a class="nav-link" href="#">Mata Pelajaran</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Materi</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Kelas</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Pengguna</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        {{-- Menu Laporan menjadi aktif dan terbuka --}}
                        <a class="nav-link active" data-bs-toggle="collapse" href="#submenu-laporan" role="button" aria-expanded="true">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i><span>Laporan</span>
                        </a>
                        {{-- Submenu Laporan ditampilkan --}}
                        <div class="collapse show" id="submenu-laporan">
                             <ul class="nav flex-column sidebar-submenu">
                                 {{-- Submenu Raport Siswa menjadi aktif --}}
                                 <li class="nav-item"><a class="nav-link active" href="{{ route('admin.laporan.index') }}">Raport Siswa</a></li>
                             </ul>
                        </div>
                    </li>
                </ul>
            </nav>
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
        </aside>

        <div class="main-content">
            <header class="topbar">
                 <button class="btn border-0 sidebar-toggler"><i class="bi bi-list"></i></button>
                 <div></div> 
            </header>

            <div class="page-header">
                <div class="container-fluid">
                    <h1>Laporan</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <main class="container-fluid p-4">
                {{-- BAGIAN 1: FORM PEMILIHAN & TAMPILAN RAPOR --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title fw-bold mb-0">Tampilkan Rapor Siswa</h5>
                    </div>
                    <div class="card-body">
                        {{-- Form untuk memilih siswa --}}
                        <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-3 align-items-end no-print">
                            <div class="col-md-5">
                                <label for="kelasFilter" class="form-label">1. Pilih Kelas</label>
                                <select class="form-select" id="kelasFilter" name="kelas_id" required>
                                    <option value="" selected disabled>-- Pilih Kelas --</option>
                                    @foreach($kelasList as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="siswaFilter" class="form-label">2. Pilih Siswa</label>
                                <select class="form-select" id="siswaFilter" name="siswa_id" required>
                                    <option value="" selected disabled>-- Pilih Kelas Dahulu --</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                            </div>
                        </form>

                        {{-- Tampilkan hasil rapor jika data ada --}}
                        @if(isset($raportData))
                            <hr class="my-4 no-print">
                            <div class="print-area">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('images/bg.png') }}" alt="Logo" style="width: 80px;" class="d-print-block d-none mx-auto">
                                    <h4 class="mt-2 mb-0">LAPORAN HASIL BELAJAR SISWA</h4>
                                    <h5 class="fw-normal">TAHUN AJARAN {{ $kelas->tahun_ajaran ?? '' }}</h5>
                                </div>
                                <table class="table table-borderless table-sm mb-4" style="max-width: 500px;">
                                    <tbody>
                                        <tr><td style="width: 150px;"><strong>Nama Siswa</strong></td><td>:</td><td>{{ $siswa->nama }}</td></tr>
                                        <tr><td><strong>Nomor Induk</strong></td><td>:</td><td>{{ $siswa->nomor_induk }}</td></tr>
                                        <tr><td><strong>Kelas</strong></td><td>:</td><td>{{ $kelas->nama_kelas }}</td></tr>
                                        <tr><td><strong>Wali Kelas</strong></td><td>:</td><td>{{ $kelas->waliKelas->nama ?? 'N/A' }}</td></tr>
                                    </tbody>
                                </table>
                                <button onclick="window.print()" class="btn btn-success float-end mb-2 no-print">
                                    <i class="bi bi-printer-fill me-2"></i>Cetak Rapor
                                </button>
                                <h5 class="mb-3">A. Nilai Akademik</h5>
                                <table class="table table-bordered table-raport">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru Pengajar</th>
                                            <th style="width: 15%;">Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($raportData as $index => $data)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $data['nama_mapel'] }}</td>
                                                <td>{{ $data['nama_guru'] }}</td>
                                                <td class="text-center fw-bold">{{ $data['nilai_akhir'] }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center py-4">Belum ada nilai yang dapat ditampilkan.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- BAGIAN 2: TABEL DAFTAR PENGGUNA (Dihapus agar fokus ke rapor) --}}
                
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggler = document.querySelector('.sidebar-toggler');
        if (sidebarToggler) {
            sidebarToggler.addEventListener('click', function () {
                document.body.classList.toggle('sidebar-visible');
            });
        }
        
        const kelasFilter = document.getElementById('kelasFilter');
        const siswaFilter = document.getElementById('siswaFilter');
        const selectedSiswaId = '{{ request("siswa_id") }}';

        function fetchSiswa(kelasId) {
            if (!kelasId) return;
            siswaFilter.disabled = true;
            siswaFilter.innerHTML = '<option value="">Memuat siswa...</option>';

            fetch(`{{ route('admin.laporan.getSiswa') }}?kelas_id=${kelasId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="" selected disabled>-- Pilih Siswa --</option>';
                    if (data.length > 0) {
                        data.forEach(siswa => {
                            const isSelected = siswa.id == selectedSiswaId ? 'selected' : '';
                            options += `<option value="${siswa.id}" ${isSelected}>${siswa.nama} (${siswa.nomor_induk})</option>`;
                        });
                        siswaFilter.disabled = false;
                    } else {
                        options = '<option value="" disabled>-- Tidak ada siswa --</option>';
                    }
                    siswaFilter.innerHTML = options;
                });
        }

        if (kelasFilter.value) {
            fetchSiswa(kelasFilter.value);
        }

        kelasFilter.addEventListener('change', function() {
            fetchSiswa(this.value);
        });
    });
    </script>
</body>
</html>