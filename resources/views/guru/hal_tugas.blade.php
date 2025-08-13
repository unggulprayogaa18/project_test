<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Tugas - SMK Otista Bandung</title>

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
            --kuning-pucat: #FDEEAA;
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

        .item-judul {
            font-weight: 500;
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
                    <a class="nav-link active" href="{{ route('guru.tugas.index') }}">
                        <i class="bi bi-card-checklist"></i>Tugas Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.buatkuis.index') }}">
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
                        <li class="breadcrumb-item active" aria-current="page">Kelola Tugas</li>
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
                @if ($errors->any())
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card content-card">
                    <div class="card-header">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <h3 class="mb-3 mb-md-0 fw-bold">Daftar Tugas Siswa</h3>
                            <div class="d-flex w-100 w-md-auto">
                                <form class="d-flex me-2 flex-grow-1" role="search" method="GET" action="{{ route('guru.tugas.index') }}">
                                    <input class="form-control" type="search" placeholder="Cari tugas..." aria-label="Search" name="search" value="{{ request('search') }}">
                                </form>
                                <button class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#addTugasModal">
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
                                                    <span class="badge rounded-pill badge-mapel">{{ $item->mataPelajaran->nama_mapel ?? 'N/A' }}</span>
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
                                                    {{ \Carbon\Carbon::parse($item->batas_waktu)->isoFormat('dddd, D MMMM YYYY') }}
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
                                                @elseif(!$item->materi && !$item->kuis)
                                                    <span class="badge text-bg-secondary">Tidak Terhubung</span>
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
                                                    <form action="{{ route('guru.tugas.destroy', $item->id) }}" method="POST" class="d-inline">
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
                                            <td colspan="5">
                                                <div class="text-center py-5">
                                                    <i class="bi bi-journal-x" style="font-size: 4rem; color: #ccc;"></i>
                                                    <h4 class="mt-3">Belum Ada Tugas Dibuat</h4>
                                                    <p class="text-muted">Klik tombol "Tambah Tugas" untuk membuat tugas baru.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($tugas->hasPages())
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-center">
                            {{ $tugas->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

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
                            <input type="datetime-local" class="form-control" id="addBatasWaktu" name="batas_waktu" required>
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
                        {{-- [PERBAIKAN 1] Tambahkan blok if untuk pesan --}}
                        <div class="mb-3">
                            <label for="addKuisId" class="form-label">Kuis (Opsional)</label>
                            <select class="form-select" id="addKuisId" name="kuis_id">
                                <option value="">Tanpa Kuis</option>
                                @foreach ($kuisList as $kuis)
                                    <option value="{{ $kuis->id }}">{{ $kuis->judul_kuis }}</option>
                                @endforeach
                            </select>
                            {{-- Pesan ini akan muncul jika tidak ada kuis yang tersedia --}}
                            @if($kuisList->isEmpty())
                                <div class="form-text text-warning mt-2">
                                    <i class="bi bi-info-circle-fill me-1"></i>
                                    Semua kuis sudah terhubung. Anda bisa <a href="{{ route('guru.buatkuis.index') }}">buat kuis baru</a>.
                                </div>
                            @endif
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
                            <input type="datetime-local" class="form-control" id="editBatasWaktu" name="batas_waktu" required>
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
                        {{-- [PERBAIKAN 2] Tambahkan blok if juga di modal edit --}}
                        <div class="mb-3">
                            <label for="editKuisId" class="form-label">Kuis (Opsional)</label>
                            <select class="form-select" id="editKuisId" name="kuis_id">
                                <option value="">Tanpa Kuis</option>
                                {{-- Opsi kuis akan di-handle oleh JavaScript --}}
                            </select>
                            <div id="edit-kuis-info" class="form-text text-warning mt-2 d-none">
                                <i class="bi bi-info-circle-fill me-1"></i>
                                Semua kuis lain sudah terhubung. Anda bisa <a href="{{ route('guru.buatkuis.index') }}">buat kuis baru</a>.
                            </div>
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
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', () => sidebar.classList.toggle('active'));
            }

            async function fetchAndPopulateMateri(mapelId, materiSelectEl, selectedMateriId = null) {
                if (!mapelId) {
                    materiSelectEl.innerHTML = '<option value="">Pilih mata pelajaran dulu</option>';
                    materiSelectEl.disabled = true;
                    return;
                }
                materiSelectEl.disabled = true;
                materiSelectEl.innerHTML = '<option value="">Memuat materi...</option>';
                try {
                    const response = await fetch(`{{ route('guru.tugas.getMateriByMapel') }}?mata_pelajaran_id=${mapelId}&tugas_id=${materiSelectEl.dataset.tugasId || ''}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const materis = await response.json();
                    materiSelectEl.innerHTML = '<option value="">Tanpa Materi</option>';
                    materis.forEach(materi => {
                        const option = new Option(materi.judul, materi.id);
                        materiSelectEl.add(option);
                    });
                    if (selectedMateriId) {
                        materiSelectEl.value = selectedMateriId;
                    }
                    materiSelectEl.disabled = false;
                } catch (error) {
                    materiSelectEl.innerHTML = '<option value="">Gagal memuat materi</option>';
                }
            }

            // --- Logic for Add Modal ---
            const addMapelSelect = document.getElementById('addMataPelajaranId');
            if(addMapelSelect) {
                const addMateriSelect = document.getElementById('addMateriId');
                addMapelSelect.addEventListener('change', () => fetchAndPopulateMateri(this.value, addMateriSelect));
            }

            // --- Logic for Edit Modal ---
            const editTugasModal = document.getElementById('editTugasModal');
            if(editTugasModal) {
                editTugasModal.addEventListener('show.bs.modal', async function (event) {
                    const button = event.relatedTarget;
                    const id = button.dataset.id;
                    const { judul, deskripsi, bataswaktu, matapelajaranid, materiid, kuisid } = button.dataset;
                    
                    const form = editTugasModal.querySelector('#editTugasForm');
                    form.action = `{{ url('guru/tugas') }}/${id}`;
                    
                    editTugasModal.querySelector('#editJudul').value = judul;
                    editTugasModal.querySelector('#editDeskripsi').value = deskripsi;
                    editTugasModal.querySelector('#editBatasWaktu').value = bataswaktu ? bataswaktu.replace(' ', 'T').substring(0, 16) : '';
                    
                    const modalMataPelajaranSelect = editTugasModal.querySelector('#editMataPelajaranId');
                    modalMataPelajaranSelect.value = matapelajaranid;

                    const modalMateriSelect = editTugasModal.querySelector('#editMateriId');
                    modalMateriSelect.dataset.tugasId = id; // Set tugas ID for fetching
                    await fetchAndPopulateMateri(matapelajaranid, modalMateriSelect, materiid);

                    // [PERBAIKAN 3] Logika untuk dropdown Kuis di modal EDIT
                    const modalKuisSelect = editTugasModal.querySelector('#editKuisId');
                    const kuisInfo = editTugasModal.querySelector('#edit-kuis-info');
                    
                    // Isi dropdown kuis dengan daftar yang belum terpakai
                    modalKuisSelect.innerHTML = '<option value="">Tanpa Kuis</option>';
                    @foreach ($kuisList as $kuis)
                        modalKuisSelect.add(new Option("{{ $kuis->judul_kuis }}", "{{ $kuis->id }}"));
                    @endforeach

                    // Jika tugas ini SUDAH punya kuis, tambahkan kuis tsb ke daftar agar bisa dipilih
                    @if ($item->kuis)
                        const currentKuis = { id: "{{ $item->kuis->id }}", judul: "{{ $item->kuis->judul_kuis }}" };
                        // Cek jika kuis saat ini tidak ada di daftar (karena sudah terpakai)
                        if (!modalKuisSelect.querySelector(`option[value="${currentKuis.id}"]`)) {
                             modalKuisSelect.add(new Option(currentKuis.judul, currentKuis.id));
                        }
                    @endif
                    
                    modalKuisSelect.value = kuisid || '';

                    // Tampilkan pesan jika hanya ada opsi "Tanpa Kuis" dan kuis yang sedang diedit
                    if (modalKuisSelect.options.length <= 2 && !kuisid) {
                        kuisInfo.classList.remove('d-none');
                    } else {
                        kuisInfo.classList.add('d-none');
                    }

                    modalMataPelajaranSelect.onchange = () => fetchAndPopulateMateri(modalMataPelajaranSelect.value, modalMateriSelect);
                });
            }
        });
    </script>
</body>

</html>