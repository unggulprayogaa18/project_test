<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Nilai Siswa - SMK Otista Bandung</title>

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
            overflow: hidden;
        }

        .content-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .table-custom thead th {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            background-color: var(--biru-otista);
            color: var(--putih);
        }

        .table-custom td {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .item-utama {
            font-weight: 500;
            color: var(--teks-utama);
        }

        .item-sekunder {
            font-size: 0.85em;
            color: var(--teks-sekunder);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        /* STYLE: Badge khusus untuk nilai dengan warna dinamis */
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

        .nilai-lulus {
            background-color: #198754;
        }

        /* Hijau */
        .nilai-cukup {
            background-color: #ffc107;
        }

        /* Kuning */
        .nilai-kurang {
            background-color: #dc3545;
        }

        /* Merah */
        .nilai-kosong {
            background-color: #6c757d;
        }

        /* Abu-abu */


        .modal-header {
            background-color: var(--biru-otista);
            color: var(--putih);
        }

        .modal-header .btn-close {
            filter: invert(1) brightness(2);
        }

        .btn-primary {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }

        .btn-primary:hover {
            background-color: #082261;
            border-color: #082261;
        }

        .btn-edit {
            background-color: #ffc107;
            color: var(--hitam);
            border: none;
        }

        .btn-danger {
            background-color: var(--merah-menyala);
            border-color: var(--merah-menyala);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }

        .pagination .page-link {
            color: var(--biru-otista);
        }

        .profile-dropdown .dropdown-toggle,
        .navbar-nav .nav-link {
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
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.dashboard') }}"><i
                                    class="bi bi-house-door-fill me-2"></i>Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link"><i
                                    class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.tugas.index') }}"><i
                                    class="bi bi-card-checklist me-2"></i>Tugas Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.buatkuis.index') }}"><i
                                    class="bi bi-patch-check-fill me-2"></i>Kuis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('guru.nilai.index') }}"><i
                                    class="bi bi-collection-fill me-2"></i>Kelola Nilai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.absensi.index') }}"><i
                                    class="bi bi-clipboard-check-fill me-2"></i>Absensi</a>
                        </li> <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.chat.index') }}"><i
                                    class="bi bi-chat-left-dots-fill me-2"></i>Konsultasi Ortu</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center">
                <div class="dropdown profile-dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>{{ Auth::user()->nama ?? 'Guru Hebat' }}</strong>
                        <i class="bi bi-person-circle ms-2 fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-light text-small shadow dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
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
                <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kelola Nilai</li>
            </ol>
        </nav>

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
                <p class="text-muted">Pilih kelas dan mata pelajaran untuk menampilkan daftar siswa dan mengelola nilai.
                </p>

                <form method="GET" action="{{ route('guru.nilai.index') }}" class="row g-3 mt-2">
                    <div class="col-md-5">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        {{-- Add onchange="this.form.submit()" here --}}
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
                        {{-- Add onchange="this.form.submit()" here --}}
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
                                    // Get the PengumpulanTugas object for the specific student and task
                                    $pengumpulan = $tugas ? $siswa->pengumpulanTugas->where('tugas_id', $tugas->id)->first() : null;
                                    // Get the score directly from the collection object, or null if not available
                                    $nilai = $pengumpulan ? $pengumpulan->nilai : null;

                                    $badgeClass = 'nilai-kosong';
                                    if ($nilai !== null) {
                                        if ($nilai >= 75)
                                            $badgeClass = 'nilai-lulus';
                                        elseif ($nilai >= 60)
                                            $badgeClass = 'nilai-cukup';
                                        else
                                            $badgeClass = 'nilai-kurang';
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
                                            <span class="badge rounded-pill text-bg-success"><i
                                                    class="bi bi-check-circle-fill me-1"></i>Sudah Mengumpulkan</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-danger"><i
                                                    class="bi bi-x-circle-fill me-1"></i>Belum Mengumpulkan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="nilai-badge {{ $badgeClass }}">
                                            {{ $nilai ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="pe-4">
                                        <div class="action-buttons">
                                            {{-- Only show buttons if a task is selected AND a submission exists for this student --}}
                                            @if ($tugas && $pengumpulan)
                                                {{-- If a score exists, show the Edit button --}}
                                                @if ($nilai !== null)
                                                    <button class="btn btn-sm btn-edit edit-nilai-btn" data-bs-toggle="modal"
                                                        data-bs-target="#editNilaiModal"
                                                        data-nilai-id="{{ $pengumpulan->id }}" {{-- CORRECT: Get ID from the $pengumpulan object --}}
                                                        data-nilai-value="{{ $pengumpulan->nilai }}" {{-- CORRECT: Get score from the $pengumpulan object --}}
                                                        data-siswa-nama="{{ $siswa->nama }}">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </button>
                                                {{-- If no score yet (but submitted), show the Give Score button --}}
                                                @else
                                                    <button class="btn btn-sm btn-success add-nilai-btn" data-bs-toggle="modal"
                                                        data-bs-target="#addNilaiModal"
                                                        data-pengumpulan-id="{{ $pengumpulan->id }}" {{-- CORRECT: Get ID from the $pengumpulan object --}}
                                                        data-siswa-nama="{{ $siswa->nama }}">
                                                        <i class="bi bi-plus-circle"></i> Beri Nilai
                                                    </button>
                                                @endif
                                            @else
                                                {{-- Disable button if no task selected or student hasn't submitted yet --}}
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
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-center">
                    {{ $siswas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="addNilaiModal" tabindex="-1" aria-labelledby="addNilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNilaiModalLabel">Beri Nilai untuk <span id="addSiswaNama"
                            class="fw-bold"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('guru.nilai.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="pengumpulan_tugas_id" id="addPengumpulanId">
                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai (0-100)</label>
                            <input type="number" class="form-control" id="nilai" name="nilai" required min="0"
                                max="100">
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
                    <h5 class="modal-title" id="editNilaiModalLabel">Edit Nilai untuk <span id="editSiswaNama"
                            class="fw-bold"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editNilaiForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nilai" class="form-label">Nilai (0-100)</label>
                            <input type="number" class="form-control" id="edit_nilai" name="nilai" required min="0"
                                max="100">
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

            const editModal = document.getElementById('editNilaiModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const nilaiId = button.getAttribute('data-nilai-id'); // This is the pengumpulan_tugas ID
                    const nilaiValue = button.getAttribute('data-nilai-value');
                    const siswaNama = button.getAttribute('data-siswa-nama');
                    const form = editModal.querySelector('#editNilaiForm');

                    // Set the form action dynamically for the PUT request
                    // Laravel's Route Model Binding in NilaiController expects this ID
                    form.action = `/guru/nilai/${nilaiId}`;
                    editModal.querySelector('#edit_nilai').value = nilaiValue;
                    editModal.querySelector('#editSiswaNama').textContent = siswaNama;
                });
            }
        });
    </script>
</body>

</html>