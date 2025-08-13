<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Nilai Siswa - SMK Otista Bandung</title>

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
            --merah-menyala: #F20000;
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

        /* Card & Table Styles */
        .content-card {
            background-color: var(--putih);
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .content-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .table-custom thead {
            background-color: var(--biru-otista);
            color: var(--putih);
        }

        .table-custom th,
        .table-custom td {
            vertical-align: middle;
            padding: 1rem;
        }

        .table-custom tbody tr:hover {
            background-color: var(--hover-bg);
        }
        .item-utama {
            font-weight: 500;
        }
        .item-sekunder {
            font-size: 0.85em;
            color: var(--teks-sekunder);
        }
        .nilai-badge {
            display: inline-block;
            font-weight: 700;
            color: white;
            text-align: center;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            line-height: 40px;
            font-size: 1em;
        }
        .nilai-lulus { background-color: #198754; }
        .nilai-cukup { background-color: #ffc107; }
        .nilai-kurang { background-color: #dc3545; }
        .nilai-kosong { background-color: #6c757d; }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        /* Button & Modal Styles */
        .btn-primary {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }
        .modal-header {
            background-color: var(--biru-otista);
            color: var(--putih);
        }
        .modal-header .btn-close {
            filter: invert(1) brightness(2);
        }
        .pagination .page-item.active .page-link {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }
        .pagination .page-link {
            color: var(--biru-otista);
        }

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
                    <a class="nav-link active" href="{{ route('guru.nilai.index') }}">
                        <i class="bi bi-collection-fill"></i>Kelola Nilai
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.absensi.index') }}">
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
                        <li class="breadcrumb-item active" aria-current="page">Kelola Nilai</li>
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
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card content-card">
                    <div class="card-header">
                        <h4 class="fw-bold">Input Nilai Siswa</h4>
                        <p class="text-muted mb-0">Pilih kelas dan mata pelajaran untuk menampilkan daftar siswa dan mengelola nilai.</p>
                        <form method="GET" action="{{ route('guru.nilai.index') }}" class="row g-3 mt-2">
                            <div class="col-md-5">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select class="form-select" id="kelas_id" name="kelas_id" onchange="this.form.submit()">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                                <select class="form-select" id="mapel_id" name="mapel_id" onchange="this.form.submit()">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($mataPelajaran as $mapel)
                                        <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        @if ($tugas)
                            <div class="alert alert-info">
                                Menampilkan nilai untuk tugas: <strong>{{ $tugas->judul }}</strong>
                                <br>
                                <small>Batas Waktu:
                                    {{ \Carbon\Carbon::parse($tugas->batas_waktu)->isoFormat('dddd, D MMMM Y, HH:mm') }} WIB</small>
                            </div>
                        @elseif(request('mapel_id'))
                            <div class="alert alert-warning">
                                Tidak ada tugas yang ditemukan untuk mata pelajaran ini dalam bulan ini.
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-custom">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 5%;">#</th>
                                        <th style="width: 35%;">Nama Siswa</th>
                                        <th style="width: 25%;">Status Pengumpulan</th>
                                        <th class="text-center" style="width: 15%;">Nilai</th>
                                        <th class="text-center pe-4" style="width: 20%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($siswas as $index => $siswa)
                                        @php
                                            $pengumpulan = $tugas ? $siswa->pengumpulanTugas->where('tugas_id', $tugas->id)->first() : null;
                                            $nilai = $pengumpulan ? $pengumpulan->nilai : null;
                                            $badgeClass = 'nilai-kosong';
                                            if ($nilai !== null) {
                                                if ($nilai >= 75) $badgeClass = 'nilai-lulus';
                                                elseif ($nilai >= 60) $badgeClass = 'nilai-cukup';
                                                else $badgeClass = 'nilai-kurang';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="ps-4 fw-bold">{{ $siswas->firstItem() + $index }}</td>
                                            <td>
                                                <div class="item-utama">{{ $siswa->nama }}</div>
                                                <div class="item-sekunder">NIS: {{ $siswa->nis ?? '-' }}</div>
                                            </td>
                                            <td>
                                                @if ($pengumpulan)
                                                    <span class="badge rounded-pill text-bg-success"><i class="bi bi-check-circle-fill me-1"></i>Sudah Mengumpulkan</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Belum Mengumpulkan</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="nilai-badge {{ $badgeClass }}">{{ $nilai ?? '-' }}</span>
                                            </td>
                                            <td class="pe-4">
                                                <div class="action-buttons">
                                                    @if ($tugas && $pengumpulan)
                                                        @if ($nilai !== null)
                                                            <button class="btn btn-sm btn-warning edit-nilai-btn" data-bs-toggle="modal"
                                                                data-bs-target="#editNilaiModal"
                                                                data-nilai-id="{{ $pengumpulan->id }}"
                                                                data-nilai-value="{{ $pengumpulan->nilai }}"
                                                                data-siswa-nama="{{ $siswa->nama }}">
                                                                <i class="bi bi-pencil-square"></i> Edit
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-success add-nilai-btn" data-bs-toggle="modal"
                                                                data-bs-target="#addNilaiModal"
                                                                data-pengumpulan-id="{{ $pengumpulan->id }}"
                                                                data-siswa-nama="{{ $siswa->nama }}">
                                                                <i class="bi bi-plus-circle"></i> Beri Nilai
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-sm btn-secondary" disabled>Beri Nilai</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <p class="mb-1">Silakan pilih kelas dan mata pelajaran terlebih dahulu.</p>
                                                <i class="bi bi-search fs-2 text-muted"></i>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($siswas->hasPages())
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-center">
                            {{ $siswas->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="addNilaiModal" tabindex="-1" aria-labelledby="addNilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNilaiModalLabel">Beri Nilai untuk <span id="addSiswaNama" class="fw-bold"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('guru.nilai.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="pengumpulan_tugas_id" id="addPengumpulanId">
                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai (0-100)</label>
                            <input type="number" class="form-control" id="nilai" name="nilai" required min="0" max="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editNilaiModal" tabindex="-1" aria-labelledby="editNilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNilaiModalLabel">Edit Nilai untuk <span id="editSiswaNama" class="fw-bold"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editNilaiForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nilai" class="form-label">Nilai (0-100)</label>
                            <input type="number" class="form-control" id="edit_nilai" name="nilai" required min="0" max="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
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
            
            // Script untuk modal Tambah Nilai
            const addModal = document.getElementById('addNilaiModal');
            if (addModal) {
                addModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const pengumpulanId = button.getAttribute('data-pengumpulan-id');
                    const siswaNama = button.getAttribute('data-siswa-nama');
                    addModal.querySelector('#addPengumpulanId').value = pengumpulanId;
                    addModal.querySelector('#addSiswaNama').textContent = siswaNama;
                });
            }
            
            // Script untuk modal Edit Nilai
            const editModal = document.getElementById('editNilaiModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const nilaiId = button.getAttribute('data-nilai-id'); // pengumpulan_tugas ID
                    const nilaiValue = button.getAttribute('data-nilai-value');
                    const siswaNama = button.getAttribute('data-siswa-nama');
                    const form = editModal.querySelector('#editNilaiForm');
                    
                    form.action = `/guru/nilai/${nilaiId}`;
                    editModal.querySelector('#edit_nilai').value = nilaiValue;
                    editModal.querySelector('#editSiswaNama').textContent = siswaNama;
                });
            }
        });
    </script>
</body>

</html>