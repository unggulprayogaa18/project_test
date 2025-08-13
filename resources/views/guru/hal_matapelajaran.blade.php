<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Pelajaran - SMK Otista Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --putih: #ffffff;
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

        .mapel-nama {
            font-weight: 500;
        }

        .mapel-kode {
            font-size: 0.85em;
            color: var(--teks-sekunder);
        }
        .badge-kelas {
            background-color: var(--hover-bg);
            color: var(--teks-sekunder);
            font-weight: 500;
            padding: 0.4em 0.7em;
            border-radius: 0.375rem;
        }
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

        .btn-primary:hover {
            background-color: #082261;
            border-color: #082261;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #343a40;
            border: none;
        }

        .btn-edit:hover {
            background-color: #ffca2c;
        }

        .btn-danger {
            background-color: var(--merah-menyala);
            border-color: var(--merah-menyala);
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
                    <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link active">
                        <i class="bi bi-journal-bookmark-fill"></i>Mata Pelajaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.hal_tugas') }}">
                        <i class="bi bi-card-checklist"></i>Tugas Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.hal_buat_kuis') }}">
                        <i class="bi bi-patch-check-fill"></i>Kuis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.nilai.index') }}">
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
                            <strong class="d-block">{{ Auth::user()->name ?? 'Guru Hebat' }}</strong>
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
                        <li class="breadcrumb-item active" aria-current="page">Mata Pelajaran</li>
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
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <h3 class="mb-3 mb-md-0 fw-bold">Kelola Mata Pelajaran</h3>
                            <div class="d-flex w-100 w-md-auto">
                                <form class="d-flex me-2 flex-grow-1" role="search" method="GET" action="{{ route('guru.mata-pelajaran.index') }}">
                                    <input class="form-control" type="search" placeholder="Cari mata pelajaran..." aria-label="Search" name="search" value="{{ request('search') }}">
                                </form>
                                <button class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#addMataPelajaranModal">
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
                                                {{-- [FIXED] Looping untuk handle multi-kelas --}}
                                                @forelse($mapel->kelas as $kelas)
                                                    <span class="badge-kelas mb-1 d-inline-block">{{ $kelas->nama_kelas }}</span>
                                                @empty
                                                    <span class="badge bg-secondary">Belum ada kelas</span>
                                                @endforelse
                                            </td>
                                            <td class="text-muted">
                                                {{ \Illuminate\Support\Str::limit($mapel->deskripsi, 60, '...') }}
                                            </td>
                                            <td class="pe-4">
                                                <div class="action-buttons">
                                                    {{-- [FIXED] Mengambil ID kelas pertama untuk default di modal edit --}}
                                                    <button class="btn btn-sm btn-edit" data-bs-toggle="modal"
                                                        data-bs-target="#editMataPelajaranModal" data-id="{{ $mapel->id }}"
                                                        data-nama="{{ $mapel->nama_mapel }}" data-kode="{{ $mapel->kode_mapel }}"
                                                        data-deskripsi="{{ $mapel->deskripsi }}" data-kelas-id="{{ $mapel->kelas->first()->id ?? '' }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <form action="{{ route('guru.mata-pelajaran.destroy', $mapel->id) }}" method="POST" class="d-inline">
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
                    @if(isset($mataPelajaran) && $mataPelajaran->hasPages())
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-center">
                                {{ $mataPelajaran->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="addMataPelajaranModal" tabindex="-1" aria-labelledby="addMataPelajaranModalLabel" aria-hidden="true">
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

    <div class="modal fade" id="editMataPelajaranModal" tabindex="-1" aria-labelledby="editMataPelajaranModalLabel" aria-hidden="true">
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
                        {{-- [FIXED] Dropdown kelas ditambahkan di sini --}}
                        <div class="mb-3">
                            <label for="edit_kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" name="kelas_id" id="edit_kelas_id" required>
                                <option value="" disabled>Pilih Kelas</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Script untuk toggle sidebar di mode mobile
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function () {
                    sidebar.classList.toggle('active');
                });
            }

            // [FIXED] Script untuk mengisi data modal edit, termasuk kelas
            var editMataPelajaranModal = document.getElementById('editMataPelajaranModal');
            editMataPelajaranModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var nama = button.getAttribute('data-nama');
                var kode = button.getAttribute('data-kode');
                var deskripsi = button.getAttribute('data-deskripsi');
                var kelasId = button.getAttribute('data-kelas-id'); // Ambil data kelas-id

                var form = editMataPelajaranModal.querySelector('#editMataPelajaranForm');
                var modalNamaInput = editMataPelajaranModal.querySelector('#editNamaMapel');
                var modalKodeInput = editMataPelajaranModal.querySelector('#editKodeMapel');
                var modalDeskripsiInput = editMataPelajaranModal.querySelector('#editDeskripsi');
                var modalKelasSelect = editMataPelajaranModal.querySelector('#edit_kelas_id'); // Target dropdown kelas

                var url = "{{ route('guru.mata-pelajaran.update', ':id') }}";
                url = url.replace(':id', id);
                form.action = url;

                modalNamaInput.value = nama;
                modalKodeInput.value = kode;
                modalDeskripsiInput.value = deskripsi;
                modalKelasSelect.value = kelasId; // Set value dari dropdown
            });
        });
    </script>
</body>

</html>