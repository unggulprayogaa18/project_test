<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tugas - SMK Otista Bandung</title>

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

        .navbar-nav .nav-link:hover {
            color: var(--biru-otista);
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

        .item-judul {
            font-weight: 500;
            color: var(--teks-utama);
        }

        .badge-mapel {
            background-color: var(--kuning-pucat);
            color: #856404;
            font-weight: 500;
            padding: 0.4em 0.7em;
        }

        .deadline-info {
            font-size: 0.9em;
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
                            <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link">
                                <i class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.materi.index') }}"><i
                                    class="bi bi-file-earmark-text-fill me-2"></i>Materi</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('guru.tugas.index') }}"><i
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
                <li class="breadcrumb-item active" aria-current="page">Kelola Tugas</li>
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
                    <h3 class="mb-3 mb-md-0 fw-bold">Daftar Tugas Siswa</h3>
                    <div class="d-flex w-100 w-md-auto">
                        <form class="d-flex me-2 flex-grow-1" role="search" method="GET"
                            action="{{ route('guru.tugas.index') }}">
                            <input class="form-control" type="search" placeholder="Cari tugas..." aria-label="Search"
                                name="search" value="{{ request('search') }}">
                        </form>
                        <button class="btn btn-primary text-nowrap" data-bs-toggle="modal"
                            data-bs-target="#addTugasModal">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Tugas
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
                                <th scope="col" style="width: 30%;">Tugas</th>
                                <th scope="col" style="width: 20%;">Batas Waktu</th>
                                <th scope="col" style="width: 20%;">Terhubung Ke</th>
                                <th scope="col" class="text-center pe-4" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tugas as $index => $item)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $tugas->firstItem() + $index }}</td>
                                    <td>
                                        <div class="item-judul">{{ $item->judul }}</div>
                                        <div class="mt-1">
                                            <span
                                                class="badge rounded-pill badge-mapel">{{ $item->mataPelajaran->nama_mapel ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if (\Carbon\Carbon::now()->gt($item->batas_waktu))
                                            <span class="badge rounded-pill text-bg-danger">Telah Berakhir</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-success">Aktif</span>
                                        @endif
                                        <div class="deadline-info mt-1">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ \Carbon\Carbon::parse($item->batas_waktu)->isoFormat('dddd, D MMMM Y') }}
                                            <br>
                                            <i class="bi bi-clock"></i> Pukul
                                            {{ \Carbon\Carbon::parse($item->batas_waktu)->format('H:i') }} WIB
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->materi)
                                            <span class="badge rounded-pill text-bg-primary mb-1 d-block">
                                                <i class="bi bi-file-earmark-text-fill me-1"></i>
                                                Materi: {{ Str::limit($item->materi->judul, 15) }}
                                            </span>
                                        @endif
                                        @if($item->kuis)
                                            <span class="badge rounded-pill text-bg-info d-block">
                                                <i class="bi bi-patch-check-fill me-1"></i>
                                                Kuis: {{ Str::limit($item->kuis->judul_kuis, 15) }}
                                            </span>
                                        @else
                                            @if(!$item->materi)
                                                <span class="badge text-bg-secondary">Tidak ada</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="pe-4">
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-edit" data-bs-toggle="modal"
                                                data-bs-target="#editTugasModal" data-id="{{ $item->id }}"
                                                data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}"
                                                data-bataswaktu="{{ $item->batas_waktu }}"
                                                data-kuisid="{{ $item->kuis_id }}" data-materiid="{{ $item->materi_id }}"
                                                data-matapelajaranid="{{ $item->mata_pelajaran_id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('guru.tugas.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada tugas ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-center">
                    {{ $tugas->links() }}
                </div>
            </div>
        </div>
    </main>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTugasModal" tabindex="-1" aria-labelledby="addTugasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTugasModalLabel">Tambah Tugas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('guru.tugas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addJudul" class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control" id="addJudul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="addDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="addDeskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="addBatasWaktu" class="form-label">Batas Waktu</label>
                            <input type="datetime-local" class="form-control" id="addBatasWaktu" name="batas_waktu"
                                required>
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
                            <label for="addMateriId" class="form-label">Materi Terkait (Opsional)</label>
                            <select class="form-select" id="addMateriId" name="materi_id" disabled>
                                <option value="">Pilih mata pelajaran dulu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addKuisId" class="form-label">Kuis (Opsional)</label>
                            <select class="form-select" id="addKuisId" name="kuis_id">
                                <option value="">Tanpa Kuis</option>
                                @foreach ($kuisList as $kuis)
                                    <option value="{{ $kuis->id }}">{{ $kuis->judul_kuis }}</option>
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

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTugasModal" tabindex="-1" aria-labelledby="editTugasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTugasModalLabel">Edit Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTugasForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editTugasId" name="id">
                        <div class="mb-3">
                            <label for="editJudul" class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control" id="editJudul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editBatasWaktu" class="form-label">Batas Waktu</label>
                            <input type="datetime-local" class="form-control" id="editBatasWaktu" name="batas_waktu"
                                required>
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
                            <label for="editMateriId" class="form-label">Materi Terkait (Opsional)</label>
                            <select class="form-select" id="editMateriId" name="materi_id">
                                <option value="">Pilih mata pelajaran dulu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editKuisId" class="form-label">Kuis (Opsional)</label>
                            <select class="form-select" id="editKuisId" name="kuis_id">
                                <option value="">Tanpa Kuis</option>
                                @foreach ($kuisList as $kuis)
                                    <option value="{{ $kuis->id }}">{{ $kuis->judul_kuis }}</option>
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
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // --- Reusable function to fetch and populate materials ---
            async function fetchAndPopulateMateri(mapelId, materiSelectElement, selectedMateriId = null) {
                if (!mapelId) {
                    materiSelectElement.innerHTML = '<option value="">Pilih mata pelajaran dulu</option>';
                    materiSelectElement.disabled = true;
                    return;
                }

                materiSelectElement.disabled = true;
                materiSelectElement.innerHTML = '<option value="">Memuat materi...</option>';

                try {
                    const response = await fetch(`{{ route('guru.tugas.getMateriByMapel') }}?mata_pelajaran_id=${mapelId}`);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const materis = await response.json();

                    materiSelectElement.innerHTML = '<option value="">Tanpa Materi</option>'; // Default option
                    materis.forEach(materi => {
                        const option = new Option(materi.judul, materi.id);
                        materiSelectElement.add(option);
                    });

                    if (selectedMateriId) {
                        materiSelectElement.value = selectedMateriId;
                    }

                    materiSelectElement.disabled = false;
                } catch (error) {
                    console.error('Error fetching materials:', error);
                    materiSelectElement.innerHTML = '<option value="">Gagal memuat materi</option>';
                    materiSelectElement.disabled = true;
                }
            }

            // --- Logic for Add Modal ---
            const addMapelSelect = document.getElementById('addMataPelajaranId');
            const addMateriSelect = document.getElementById('addMateriId');

            addMapelSelect.addEventListener('change', function () {
                fetchAndPopulateMateri(this.value, addMateriSelect);
            });


            // --- Logic for Edit Modal ---
            const editTugasModal = document.getElementById('editTugasModal');
            editTugasModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var judul = button.getAttribute('data-judul');
                var deskripsi = button.getAttribute('data-deskripsi');
                var batasWaktu = button.getAttribute('data-bataswaktu');
                var mataPelajaranId = button.getAttribute('data-matapelajaranid');
                var materiId = button.getAttribute('data-materiid');
                var kuisId = button.getAttribute('data-kuisid');

                var formattedBatasWaktu = batasWaktu ? batasWaktu.replace(' ', 'T').substring(0, 16) : '';

                var modalJudulInput = editTugasModal.querySelector('#editJudul');
                var modalDeskripsiInput = editTugasModal.querySelector('#editDeskripsi');
                var modalBatasWaktuInput = editTugasModal.querySelector('#editBatasWaktu');
                var modalMataPelajaranSelect = editTugasModal.querySelector('#editMataPelajaranId');
                var modalMateriSelect = editTugasModal.querySelector('#editMateriId');
                var modalKuisSelect = editTugasModal.querySelector('#editKuisId');
                var form = editTugasModal.querySelector('#editTugasForm');

                modalJudulInput.value = judul;
                modalDeskripsiInput.value = deskripsi;
                modalBatasWaktuInput.value = formattedBatasWaktu;
                modalMataPelajaranSelect.value = mataPelajaranId;
                modalKuisSelect.value = kuisId || '';
                form.action = '{{ url('guru/tugas') }}/' + id;

                // Fetch materials for the selected subject when modal opens
                fetchAndPopulateMateri(mataPelajaranId, modalMateriSelect, materiId);

                // Add event listener for mapel change within the edit modal
                modalMataPelajaranSelect.addEventListener('change', function () {
                    fetchAndPopulateMateri(this.value, modalMateriSelect);
                });
            });
        });
    </script>
</body>

</html>