<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi - SMK Otista Bandung</title>

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

        .offcanvas-title {
            color: var(--biru-otista);
            font-weight: 600;
        }

        .offcanvas-body .nav-link.active,
        .offcanvas-body .nav-link:hover {
            background-color: var(--biru-otista);
            color: var(--putih);
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

        /* STYLE: Menggunakan style tabel kustom yang sama */
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

        /* Style untuk judul utama di tabel (Judul Materi) */
        .item-judul {
            font-weight: 500;
            color: var(--teks-utama);
        }

        /* Style untuk teks sekunder di tabel (Deskripsi singkat) */
        .item-deskripsi-singkat {
            font-size: 0.85em;
            color: var(--teks-sekunder);
        }

        /* Style untuk badge Mata Pelajaran */
        .badge-mapel {
            background-color: var(--kuning-pucat);
            color: #856404;
            font-weight: 500;
            padding: 0.4em 0.7em;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

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

        .btn-edit:hover {
            background-color: #ffca2c;
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
                            <a class="nav-link" aria-current="page" href="{{ route('guru.dashboard') }}"><i
                                    class="bi bi-house-door-fill me-2"></i>Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link">
                                <i class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link active" href="{{ route('guru.materi.index') }}"><i
                                    class="bi bi-file-earmark-text-fill me-2"></i>Materi</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.hal_tugas') }}"><i
                                    class="bi bi-card-checklist me-2"></i>Tugas Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.buatkuis.index') }}"><i
                                    class="bi bi-patch-check-fill me-2"></i>Kuis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guru.nilai.index') ? 'active' : '' }}"
                                href="{{ route('guru.nilai.index') }}"><i class="bi bi-collection-fill me-2"></i>Kelola
                                Nilai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.hal_absensi') }}"><i
                                    class="bi bi-clipboard-check-fill me-2"></i>Absensi</a>
                        </li>
 <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.chat.index') }}"><i
                                    class="bi bi-chat-left-dots-fill me-2"></i>Konsultasi Ortu</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center">
                <button class="btn btn-notification me-3" type="button">
                    <i class="bi bi-bell-fill fs-4"></i>
                </button>
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
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kelola Materi</li>
            </ol>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card content-card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h3 class="mb-3 mb-md-0 fw-bold">Daftar Materi Pembelajaran</h3>
                    <div class="d-flex w-100 w-md-auto">
                        <form class="d-flex me-2 flex-grow-1" role="search" method="GET"
                            action="{{ route('guru.materi.index') }}">
                            <input class="form-control" type="search" placeholder="Cari materi..." aria-label="Search"
                                name="search" value="{{ request('search') }}">
                        </form>
                        <button class="btn btn-primary text-nowrap" data-bs-toggle="modal"
                            data-bs-target="#addMateriModal">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Materi
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
                                <th scope="col" style="width: 40%;">Materi</th>
                                <th scope="col" style="width: 25%;">Mata Pelajaran</th>
                                <th scope="col" style="width: 15%;">Kuis</th>
                                <th scope="col" class="text-center pe-4" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($materis as $index => $item)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $materis->firstItem() + $index }}</td>
                                    <td>
                                        <div class="item-judul">{{ $item->judul }}</div>
                                        <div class="item-deskripsi-singkat">
                                            {{ \Illuminate\Support\Str::limit($item->deskripsi, 70, '...') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill badge-mapel">{{ $item->mataPelajaran->nama_mapel ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($item->kuis)
                                            <span class="badge rounded-pill text-bg-success"><i
                                                    class="bi bi-check-circle-fill me-1"></i>
                                                {{ $item->kuis->judul_kuis }}</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-secondary">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="pe-4">
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-info text-white edit-btn" data-bs-toggle="modal"
                                                data-bs-target="#editMateriModal" data-id="{{ $item->id }}"
                                                data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}"
                                                data-konten="{{ $item->konten }}"
                                                data-matapelajaranid="{{ $item->mata_pelajaran_id }}"
                                                data-kuisid="{{ $item->kuis_id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('guru.materi.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada materi ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-center">
                    {{ $materis->links() }}
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="addMateriModal" tabindex="-1" aria-labelledby="addMateriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMateriModalLabel">Tambah Materi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('guru.materi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addJudul" class="form-label">Judul Materi</label>
                            <input type="text" class="form-control" id="addJudul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="addDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="addDeskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="addKonten" class="form-label">Konten (Text)</label>
                            <textarea class="form-control" id="addKonten" name="konten" rows="5"
                                placeholder="Isi materi atau tautan ke file"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="addMataPelajaranId" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="addMataPelajaranId" name="mata_pelajaran_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($mataPelajaranList as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addKuisId" class="form-label">Kuis Terkait (Opsional)</label>
                            <select class="form-select" id="addKuisId" name="kuis_id">
                                <option value="">Tidak Ada Kuis</option>
                                @foreach ($kuisList as $kuisItem)
                                    <option value="{{ $kuisItem->id }}">{{ $kuisItem->judul_kuis }}</option>
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

    <div class="modal fade" id="editMateriModal" tabindex="-1" aria-labelledby="editMateriModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMateriModalLabel">Edit Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editMateriForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editMateriId" name="id">
                        <div class="mb-3">
                            <label for="editJudul" class="form-label">Judul Materi</label>
                            <input type="text" class="form-control" id="editJudul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editKonten" class="form-label">Konten (Text)</label>
                            <textarea class="form-control" id="editKonten" name="konten" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editMataPelajaranId" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="editMataPelajaranId" name="mata_pelajaran_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($mataPelajaranList as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editKuisId" class="form-label">Kuis Terkait (Opsional)</label>
                            <select class="form-select" id="editKuisId" name="kuis_id">
                                <option value="">Tidak Ada Kuis</option>
                                @foreach ($kuisList as $kuisItem)
                                    <option value="{{ $kuisItem->id }}">{{ $kuisItem->judul_kuis }}</option>
                                @endforeach
                            </select>
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
        // SCRIPT: Tidak ada perubahan, fungsionalitas modal tetap sama
        document.addEventListener('DOMContentLoaded', function () {
            var editMateriModal = document.getElementById('editMateriModal');
            editMateriModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var judul = button.getAttribute('data-judul');
                var deskripsi = button.getAttribute('data-deskripsi');
                var konten = button.getAttribute('data-konten');
                var mataPelajaranId = button.getAttribute('data-matapelajaranid');
                var kuisId = button.getAttribute('data-kuisid');

                var modalIdInput = editMateriModal.querySelector('#editMateriId');
                var modalJudulInput = editMateriModal.querySelector('#editJudul');
                var modalDeskripsiInput = editMateriModal.querySelector('#editDeskripsi');
                var modalKontenInput = editMateriModal.querySelector('#editKonten');
                var modalMataPelajaranSelect = editMateriModal.querySelector('#editMataPelajaranId');
                var modalKuisSelect = editMateriModal.querySelector('#editKuisId');
                var form = editMateriModal.querySelector('#editMateriForm');

                modalIdInput.value = id;
                modalJudulInput.value = judul;
                modalDeskripsiInput.value = deskripsi;
                modalKontenInput.value = konten;
                modalMataPelajaranSelect.value = mataPelajaranId;
                modalKuisSelect.value = kuisId;

                form.action = '{{ route('guru.materi.update', ':id') }}'.replace(':id', id);
            });
        });
    </script>
</body>

</html>