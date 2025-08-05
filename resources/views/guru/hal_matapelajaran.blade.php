<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Pelajaran - SMK Otista Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* =================================
           PALET WARNA & VARIABEL (TEMA SMK OTISTA)
        ==================================== */
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

        /* =================================
           GAYA DASAR
        ==================================== */
        body {
            background-color: var(--latar-utama);
            color: var(--hitam);
            font-family: 'Poppins', sans-serif;
        }

        /* =================================
           NAVBAR ATAS
        ==================================== */
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

        .profile-dropdown .dropdown-toggle,
        .navbar-nav .nav-link {
            color: var(--teks-sekunder);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .profile-dropdown .dropdown-toggle:hover {
            color: var(--biru-otista);
        }

        .navbar-nav .nav-link.active {
            color: var(--biru-otista);
            font-weight: 700;
        }

        .profile-dropdown .dropdown-menu {
            background-color: var(--putih);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-dropdown .dropdown-item {
            color: var(--teks-utama);
        }

        .profile-dropdown .dropdown-item:hover {
            background-color: var(--hover-bg);
            color: var(--biru-otista);
        }

        .profile-dropdown .dropdown-divider {
            border-color: var(--border-color);
        }

        .btn-notification {
            background: none;
            border: none;
            color: var(--teks-sekunder);
            transition: color 0.3s;
        }

        .btn-notification:hover {
            color: var(--biru-otista);
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

        /* =================================
           KONTEN UTAMA & CARD
        ==================================== */
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

        /* =================================
           TABEL
        ==================================== */
        .table thead {
            background-color: var(--biru-otista);
            color: var(--putih);
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 1rem;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
        }

        .btn-edit {
            background-color: #ffc107;
            color: var(--hitam);
            border: none;
        }

        .btn-edit:hover {
            background-color: #ffca2c;
        }

        .btn-danger {
            background-color: var(--merah-menyala);
            border-color: var(--merah-menyala);
        }

        /* =================================
           MODAL & ELEMEN LAINNYA
        ==================================== */
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

        .pagination .page-item.active .page-link {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }

        .pagination .page-link {
            color: var(--biru-otista);
        }

        .pagination .page-link:hover {
            color: #082261;
        }

        /* =================================
           TABEL KUSTOM
        ==================================== */
        .table-custom thead th {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .table-custom td {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .mapel-nama {
            font-weight: 500;
            color: var(--teks-utama);
        }

        .mapel-kode {
            font-size: 0.85em;
            color: var(--teks-sekunder);
        }

        .badge-kelas {
            background-color: var(--kuning-pucat);
            color: #856404;
            /* Warna teks gelap agar kontras */
            font-weight: 500;
            padding: 0.4em 0.7em;
            border-radius: 0.375rem;
            /* samakan dengan radius bootstrap */
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            /* Memberi jarak antar tombol */
            justify-content: center;
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
                            <a class="nav-link" aria-current="page" href="{{ route('guru.dashboard') }}"><i
                                    class="bi bi-house-door-fill me-2"></i>Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link active">
                                <i class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.hal_materi') }}"><i
                                    class="bi bi-file-earmark-text-fill me-2"></i>Materi</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.hal_tugas') }}"><i
                                    class="bi bi-card-checklist me-2"></i>Tugas Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.hal_buat_kuis') }}"><i
                                    class="bi bi-patch-check-fill me-2"></i> Kuis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guru.nilai.index') ? 'active' : '' }}"
                                href="{{ route('guru.nilai.index') }}"><i class="bi bi-collection-fill me-2"></i>Kelola
                                Nilai</a>
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
                        <strong>{{ Auth::user()->name ?? 'Guru Hebat' }}</strong>
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
                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mata Pelajaran</li>
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
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h3 class="mb-3 mb-md-0 fw-bold">Kelola Mata Pelajaran</h3>
                    <div class="d-flex w-100 w-md-auto">
                        <form class="d-flex me-2 flex-grow-1" role="search" method="GET"
                            action="{{ route('guru.mata-pelajaran.index') }}">
                            <input class="form-control" type="search" placeholder="Cari mata pelajaran..."
                                aria-label="Search" name="search" value="{{ request('search') }}">
                        </form>
                        <button class="btn btn-primary text-nowrap" data-bs-toggle="modal"
                            data-bs-target="#addMataPelajaranModal">
                            <i class="bi bi-plus-circle me-1"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-custom">
                        <thead>
                            <tr>
                                <th scope="col" class="ps-4" style="width: 5%;">#</th>
                                <th scope="col" style="width: 30%;">Mata Pelajaran</th>
                                <th scope="col" style="width: 15%;">Kelas</th>
                                <th scope="col" style="width: 35%;">Deskripsi</th>
                                <th scope="col" class="text-center pe-4" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mataPelajaran as $index => $mapel)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $mataPelajaran->firstItem() + $index }}</td>
                                    <td>
                                        <div class="mapel-nama">{{ $mapel->nama_mapel }}</div>
                                        <div class="mapel-kode">Kode: {{ $mapel->kode_mapel ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge-kelas">{{ $mapel->nama_kelas ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-muted">
                                        {{ \Illuminate\Support\Str::limit($mapel->deskripsi, 60, '...') }}
                                    </td>
                                    <td class="pe-4">
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-edit" data-bs-toggle="modal"
                                                data-bs-target="#editMataPelajaranModal" data-id="{{ $mapel->id }}"
                                                data-nama="{{ $mapel->nama_mapel }}" data-kode="{{ $mapel->kode_mapel }}"
                                                data-deskripsi="{{ $mapel->deskripsi }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('guru.mata-pelajaran.destroy', $mapel->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada mata pelajaran ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-center">
                    @if(isset($mataPelajaran) && $mataPelajaran->hasPages())
                        {{ $mataPelajaran->links() }}
                    @endif
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="addMataPelajaranModal" tabindex="-1" aria-labelledby="addMataPelajaranModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMataPelajaranModalLabel">Tambah Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('guru.mata-pelajaran.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addNamaMapel" class="form-label">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="addNamaMapel" name="nama_mapel" required>
                        </div>
                        <div class="mb-3">
                            <label for="addKodeMapel" class="form-label">Kode Mata Pelajaran</label>
                            <input type="text" class="form-control" id="addKodeMapel" name="kode_mapel" required>
                        </div>
                        <div class="mb-3">
                            <label for="addDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="addDeskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" name="kelas_id" id="kelas_id" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
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

    <div class="modal fade" id="editMataPelajaranModal" tabindex="-1" aria-labelledby="editMataPelajaranModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMataPelajaranModalLabel">Edit Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editMataPelajaranForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editMataPelajaranId" name="id">
                        <div class="mb-3">
                            <label for="editNamaMapel" class="form-label">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="editNamaMapel" name="nama_mapel" required>
                        </div>
                        <div class="mb-3">
                            <label for="editKodeMapel" class="form-label">Kode Mata Pelajaran</label>
                            <input type="text" class="form-control" id="editKodeMapel" name="kode_mapel" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3"></textarea>
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
            var editMataPelajaranModal = document.getElementById('editMataPelajaranModal');
            editMataPelajaranModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var nama = button.getAttribute('data-nama');
                var kode = button.getAttribute('data-kode');
                var deskripsi = button.getAttribute('data-deskripsi');

                var form = editMataPelajaranModal.querySelector('#editMataPelajaranForm');
                var modalIdInput = editMataPelajaranModal.querySelector('#editMataPelajaranId');
                var modalNamaInput = editMataPelajaranModal.querySelector('#editNamaMapel');
                var modalKodeInput = editMataPelajaranModal.querySelector('#editKodeMapel');
                var modalDeskripsiInput = editMataPelajaranModal.querySelector('#editDeskripsi');

                // Set form action dynamically
                var url = "{{ route('guru.mata-pelajaran.update', ':id') }}";
                url = url.replace(':id', id);
                form.action = url;

                // Populate form fields
                modalIdInput.value = id;
                modalNamaInput.value = nama;
                modalKodeInput.value = kode;
                modalDeskripsiInput.value = deskripsi;
            });
        });
    </script>
</body>

</html>