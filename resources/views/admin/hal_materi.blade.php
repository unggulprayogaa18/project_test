<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi Pelajaran - LMS Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                            <li><a class="dropdown-item active" href="{{ route('admin.hal_materi') }}">Materi</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.hal_kelas') }}">Kelas</a></li>
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
                    <h1>Kelola Materi Pelajaran</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Kelola Data</li>
                            <li class="breadcrumb-item active" aria-current="page">Materi</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#materiModal">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Materi
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
                                <th style="width: 45%;">Materi</th>
                                <th style="width: 15%;">Tipe</th>
                                <th class="text-center" style="width: 15%;">Lihat Dokumen</th>
                                <th class="text-center pe-4" style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($materis as $key => $materi)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $materis->firstItem() + $key }}</td>
                                    <td>
                                        <div class="item-utama">{{ $materi->judul }}</div>
                                        <div class="item-sekunder">
                                            Mata Pelajaran: {{ $materi->mataPelajaran->nama_mapel ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($materi->tipe_materi == 'link')
                                            <span class="badge text-bg-success">Link Eksternal</span>
                                        @else
                                            <span class="badge text-bg-primary">File Upload</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($materi->file_path)
                                            {{-- Jika materinya adalah LINK EKSTERNAL --}}
                                            @if ($materi->tipe_materi == 'link')
                                                <a href="{{ $materi->file_path }}" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="bi bi-link-45deg me-1"></i> Buka Link
                                                </a>
                                                {{-- Jika materinya adalah FILE UPLOAD --}}
                                            @else
                                                <a href="{{ Storage::url($materi->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-secondary">
                                                    <i class="bi bi-eye me-1"></i> Lihat File
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-sm btn-warning"
                                                onclick="editMateri({{ json_encode($materi) }})">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.materis.destroy', $materi->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash3-fill"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <p>Tidak ada data materi pelajaran.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-end">
                    {{ $materis->links() }}
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="materiModal" tabindex="-1" aria-labelledby="materiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materiModalLabel">Formulir Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="materiForm" action="{{ route('admin.materis.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Materi</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                @foreach ($mataPelajaranList as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipe_materi" class="form-label">Tipe Materi</label>
                            <select class="form-select" id="tipe_materi" name="tipe_materi" required>
                                <option value="file">File Upload</option>
                                <option value="link">Link Eksternal</option>
                            </select>
                        </div>
                        <div class="mb-3" id="input-file">
                            <label for="file_path_file" class="form-label">Unggah File</label>
                            <input class="form-control" type="file" id="file_path_file" name="file_path">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file.</small>
                        </div>
                        <div class="mb-3" id="input-link" style="display: none;">
                            <label for="file_path_link" class="form-label">URL Materi</label>
                            <input type="url" class="form-control" id="file_path_link" name="file_path_link"
                                placeholder="https://contoh.com/materi">
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
        const materiModal = new bootstrap.Modal(document.getElementById('materiModal'));
        const materiForm = document.getElementById('materiForm');
        const modalLabel = document.getElementById('materiModalLabel');
        const formMethod = document.getElementById('formMethod');
        const tipeMateriSelect = document.getElementById('tipe_materi');
        const inputFileDiv = document.getElementById('input-file');
        const inputLinkDiv = document.getElementById('input-link');
        const filePathFileInput = document.getElementById('file_path_file');
        const filePathLinkInput = document.getElementById('file_path_link');

        // [UBAH] Fungsi untuk handle perubahan tipe materi
        function handleTipeChange() {
            if (tipeMateriSelect.value === 'link') {
                inputLinkDiv.style.display = 'block';
                inputFileDiv.style.display = 'none';
                filePathFileInput.removeAttribute('name');
                filePathLinkInput.setAttribute('name', 'file_path_link'); // Ganti nama agar divalidasi controller
            } else {
                inputLinkDiv.style.display = 'none';
                inputFileDiv.style.display = 'block';
                filePathLinkInput.removeAttribute('name');
                filePathFileInput.setAttribute('name', 'file_path');
            }
        }

        tipeMateriSelect.addEventListener('change', handleTipeChange);

        // [UBAH] Fungsi editMateri yang lebih lengkap
        function editMateri(materi) {
            // Set action form dan method
            materiForm.action = `/admin/materis/${materi.id}`;
            formMethod.value = 'PUT';

            // Isi data form
            modalLabel.textContent = 'Edit Materi Pelajaran';
            document.getElementById('judul').value = materi.judul;
            document.getElementById('deskripsi').value = materi.deskripsi;
            document.getElementById('mata_pelajaran_id').value = materi.mata_pelajaran_id;
            tipeMateriSelect.value = materi.tipe_materi;

            // Atur input file/link berdasarkan tipe materi
            handleTipeChange();

            // Jika tipenya link, isi value linknya
            if (materi.tipe_materi === 'link') {
                filePathLinkInput.value = materi.file_path;
            } else {
                filePathLinkInput.value = ''; // Kosongkan field link jika tipe file
            }

            // Tampilkan modal
            materiModal.show();
        }

        // [UBAH] Event listener saat modal ditutup untuk reset form
        document.getElementById('materiModal').addEventListener('hidden.bs.modal', function () {
            materiForm.reset();
            materiForm.action = "{{ route('admin.materis.store') }}";
            formMethod.value = 'POST';
            modalLabel.textContent = 'Tambah Materi Pelajaran';

            // Reset ke kondisi awal (tipe file)
            tipeMateriSelect.value = 'file';
            handleTipeChange();
        });

    </script>
</body>

</html>