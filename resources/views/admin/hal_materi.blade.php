<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi - SIKS OTISTA</title>

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
        .table-custom thead th { background-color: #f8f9fa; color: var(--teks-utama); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border-bottom: 2px solid var(--border-color); }
        .table-custom td { vertical-align: middle; }
        .action-buttons { display: flex; gap: 0.5rem; justify-content: center; }
        .modal-header { background-color: var(--biru-otista); color: var(--putih); }
        .modal-header .btn-close { filter: invert(1) brightness(2); }
        .btn-primary { background-color: var(--biru-otista); border-color: var(--biru-otista); }
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
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="navbar-brand d-flex align-items-center" href="#">
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
                        <a class="nav-link" data-bs-toggle="collapse" href="#submenu-kelola" role="button" aria-expanded="true">
                            <i class="bi bi-stack"></i><span>Kelola Data</span>
                        </a>
                        <div class="collapse show" id="submenu-kelola">
                            <ul class="nav flex-column sidebar-submenu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.hal_matapelajaran') }}">Mata Pelajaran</a></li>
                                <li class="nav-item"><a class="nav-link active" href="{{ route('admin.hal_materi') }}">Materi</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.hal_kelas') }}">Kelas</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Pengguna</a></li>
                            </ul>
                        </div>
                    </li>
                    {{-- Laporan diubah menjadi Accordion --}}
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#submenu-laporan" role="button" aria-expanded="false">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i><span>Laporan</span>
                        </a>
                        <div class="collapse" id="submenu-laporan">
                             <ul class="nav flex-column sidebar-submenu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.laporan.pengguna') }}">Laporan Pengguna</a></li>
                             </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                    </li>
                </ul>
            </nav>
            {{-- Profil pengguna dipindahkan ke bawah --}}
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

            {{-- KONTEN UTAMA HALAMAN KELOLA MATERI --}}
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

            <main class="container-fluid p-4">
                 @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Terdapat kesalahan pada input Anda.
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
                                                <div class="fw-bold">{{ $materi->judul }}</div>
                                                <div class="small text-muted">Mapel: {{ $materi->mataPelajaran->nama_mapel ?? 'N/A' }}</div>
                                            </td>
                                            <td>
                                                @if ($materi->tipe_materi == 'link')
                                                    <span class="badge text-bg-success">Link Eksternal</span>
                                                @else
                                                    <span class="badge text-bg-primary">File Upload</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($materi->tipe_materi == 'link')
                                                    <a href="{{ $materi->file_path }}" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-link-45deg me-1"></i> Buka</a>
                                                @elseif ($materi->file_path)
                                                    <a href="{{ Storage::url($materi->file_path) }}" target="_blank" class="btn btn-sm btn-secondary"><i class="bi bi-eye me-1"></i> Lihat</a>
                                                @else
                                                    <span class="text-muted">Tidak ada</span>
                                                @endif
                                            </td>
                                            <td class="text-center pe-4">
                                                <div class="action-buttons">
                                                    <button type="button" class="btn btn-sm btn-warning" onclick="editMateri({{ json_encode($materi) }})"><i class="bi bi-pencil-square"></i></button>
                                                    <form action="{{ route('admin.materis.destroy', $materi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center py-5"><p>Tidak ada data materi pelajaran.</p></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent"><div class="d-flex justify-content-end">{{ $materis->links() }}</div></div>
                </div>
            </main>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="materiModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materiModalLabel">Formulir Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="materiForm" action="{{ route('admin.materis.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="mb-3"><label for="judul" class="form-label">Judul Materi</label><input type="text" class="form-control" id="judul" name="judul" required></div>
                        <div class="mb-3"><label for="deskripsi" class="form-label">Deskripsi</label><textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea></div>
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
                            <label for="file_path_link" class="form-label">URL Materi</gabel>
                            <input type="url" class="form-control" id="file_path_link" name="file_path_link" placeholder="https://contoh.com/materi">
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
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggler = document.querySelector('.sidebar-toggler');
            if(sidebarToggler) {
                sidebarToggler.addEventListener('click', function() {
                    document.body.classList.toggle('sidebar-visible');
                });
            }
        });

        const materiModal = new bootstrap.Modal(document.getElementById('materiModal'));
        const materiForm = document.getElementById('materiForm');
        const modalLabel = document.getElementById('materiModalLabel');
        const formMethod = document.getElementById('formMethod');
        const tipeMateriSelect = document.getElementById('tipe_materi');
        const inputFileDiv = document.getElementById('input-file');
        const inputLinkDiv = document.getElementById('input-link');
        const filePathFileInput = document.getElementById('file_path_file');
        const filePathLinkInput = document.getElementById('file_path_link');

        function handleTipeChange() {
            if (tipeMateriSelect.value === 'link') {
                inputLinkDiv.style.display = 'block';
                inputFileDiv.style.display = 'none';
                filePathFileInput.name = '';
                filePathLinkInput.name = 'file_path';
            } else {
                inputLinkDiv.style.display = 'none';
                inputFileDiv.style.display = 'block';
                filePathLinkInput.name = '';
                filePathFileInput.name = 'file_path';
            }
        }
        tipeMateriSelect.addEventListener('change', handleTipeChange);

        function editMateri(materi) {
            materiForm.action = `/admin/materis/${materi.id}`;
            formMethod.value = 'PUT';
            modalLabel.textContent = 'Edit Materi Pelajaran';
            document.getElementById('judul').value = materi.judul;
            document.getElementById('deskripsi').value = materi.deskripsi;
            document.getElementById('mata_pelajaran_id').value = materi.mata_pelajaran_id;
            tipeMateriSelect.value = materi.tipe_materi;
            handleTipeChange();
            if (materi.tipe_materi === 'link') {
                filePathLinkInput.value = materi.file_path;
            } else {
                filePathLinkInput.value = '';
            }
            materiModal.show();
        }

        document.getElementById('materiModal').addEventListener('hidden.bs.modal', function () {
            materiForm.reset();
            materiForm.action = "{{ route('admin.materis.store') }}";
            formMethod.value = 'POST';
            modalLabel.textContent = 'Tambah Materi Pelajaran';
            tipeMateriSelect.value = 'file';
            handleTipeChange();
        });

         @if ($errors->any())
            materiModal.show();
        @endif
    </script>
</body>
</html>