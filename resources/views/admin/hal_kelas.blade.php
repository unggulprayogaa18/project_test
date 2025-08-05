<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelas - LMS Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --putih: #FFFFFF;
            --latar-utama: #f5f7fa;
            --teks-utama: #1e293b;
            --teks-sekunder: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--latar-utama);
            font-family: 'Poppins', sans-serif;
        }

        /* STRUKTUR UTAMA: Navigasi Atas */
        .app-header {
            background-color: var(--putih);
            border-bottom: 1px solid var(--border-color);
            padding: 0 1.5rem;
        }

        .app-header .navbar-brand {
            font-weight: 700;
            color: var(--teks-utama);
        }

        .app-header .nav-link {
            color: var(--teks-sekunder);
            font-weight: 500;
            padding: 1.5rem 1rem;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease-in-out;
        }

        .app-header .nav-link:hover {
            color: var(--teks-utama);
        }

        /* Style untuk link dropdown yang parent-nya aktif */
        .app-header .dropdown-toggle.active {
            color: var(--biru-otista);
            font-weight: 600;
            border-bottom-color: var(--biru-otista);
        }

        .app-header .dropdown-menu .dropdown-item.active {
            background-color: var(--biru-otista);
            color: var(--putih);
        }

        .app-header .dropdown-menu {
            border-radius: 0.5rem;
            border-color: var(--border-color);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        /* Header Halaman */
        .page-header {
            background-color: var(--putih);
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
        }

        /* Table Custom */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: none;
        }

        .table-custom thead th {
            background-color: var(--biru-otista);
            color: var(--putih);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            border: none;
        }

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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        /* Modal Custom */
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
    </style>
</head>

<body>
    <header class="app-header sticky-top">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/bg.png') }}" alt="Logo" width="32" class="me-2">
                LMS Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Kelola Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="{{ route('admin.hal_matapelajaran') }}">Mata
                                    Pelajaran</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.hal_materi') }}">Materi</a></li>
                            <li><a class="dropdown-item active" href="{{ route('admin.hal_kelas') }}">Kelas</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Pengguna</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pengaturan</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-end me-3">
                            <div class="fw-bold">{{ Auth::user()->name ?? 'Admin User' }}</div>
                            <small class="text-muted">Administrator</small>
                        </div>
                        <i class="bi bi-person-circle fs-2 text-secondary"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Kelola Kelas</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Kelola Data</li>
                            <li class="breadcrumb-item active" aria-current="page">Kelas</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kelasModal">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Kelas
                </button>
            </div>
        </div>
    </div>

    <main class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Terdapat kesalahan pada input Anda.
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 5%;">#</th>
                                <th style="width: 45%;">Nama Kelas</th>
                                <th style="width: 30%;">Tahun Ajaran</th>
                                <th class="text-center pe-4" style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelas as $key => $item)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $kelas->firstItem() + $key }}</td>
                                    <td>
                                        <div class="item-utama">{{ $item->nama_kelas }}</div>
                                        <div class="item-sekunder">Tingkat: {{ $item->tingkat }}</div>
                                    </td>
                                    <td>{{ $item->tahun_ajaran }}</td>
                                    <td class="text-center pe-4">
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-sm btn-warning"
                                                onclick="editKelas({{ $item }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <p>Tidak ada data kelas ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-end">
                    {{ $kelas->links() }}
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="kelasModal" tabindex="-1" aria-labelledby="kelasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kelasModalLabel">Formulir Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="kelasForm" action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas"
                                placeholder="Contoh: X RPL 1" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran"
                                placeholder="Contoh: 2024/2025" required>
                        </div>
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat</label>
                            <input type="text" class="form-control" id="tingkat" name="tingkat"
                                placeholder="Contoh: X, XI, XII" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const kelasModal = new bootstrap.Modal(document.getElementById('kelasModal'));
        const kelasForm = document.getElementById('kelasForm');
        const modalLabel = document.getElementById('kelasModalLabel');
        const formMethod = document.getElementById('formMethod');

        function editKelas(kelas) {
            kelasForm.action = `/admin/kelas/${kelas.id}`;
            formMethod.value = 'PUT';
            document.getElementById('nama_kelas').value = kelas.nama_kelas;
            document.getElementById('tahun_ajaran').value = kelas.tahun_ajaran;
            document.getElementById('tingkat').value = kelas.tingkat;
            modalLabel.textContent = 'Edit Kelas';
            kelasModal.show();
        }

        document.getElementById('kelasModal').addEventListener('hidden.bs.modal', function () {
            kelasForm.reset();
            kelasForm.action = "{{ route('admin.kelas.store') }}";
            formMethod.value = 'POST';
            modalLabel.textContent = 'Tambah Kelas';
        });
    </script>
</body>

</html>