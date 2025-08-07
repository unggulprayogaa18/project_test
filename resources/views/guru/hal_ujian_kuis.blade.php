<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Nama Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            height: 100vh;
            overflow-x: hidden;
            background-color: #f8f9fa;
            /* Warna latar belakang umum */
        }

        .sidebar {
            width: 280px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            overflow-y: auto;
            height: 100vh;
        }

        .nav-link {
            color: rgba(255, 255, 255, .75);
        }

        .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: white;
            background-color: #0d6efd;
        }

        .offcanvas-body .nav-link {
            color: #212529;
        }

        .offcanvas-body .nav-link:hover {
            background-color: #e9ecef;
        }

        .offcanvas-body .nav-link.active {
            color: white;
            background-color: #0d6efd;
        }

        /* Custom Buttons */
        .btn-custom-blue {
            background-color: #133869;
            color: white;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-custom-blue:hover {
            background-color: #0c2b53;
            /* Slightly darker blue */
            color: white;
            transform: translateY(-2px);
            /* Slight lift effect */
        }

        .btn-custom-green {
            background-color: #136937;
            /* Bootstrap success green */
            color: white;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-custom-green:hover {
            background-color: #218838;
            /* Slightly darker green */
            color: white;
            transform: translateY(-2px);
        }

        .btn-edit {
            background-color: #ffc107;
            /* Bootstrap warning yellow */
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #e0a800;
            /* Darker yellow */
        }

        .btn-delete {
            background-color: #dc3545;
            /* Bootstrap danger red */
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #c82333;
            /* Darker red */
        }

        /* Card enhancements */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background-color: #133869;
            /* Warna header card */
            color: white;
            padding: 1rem 1.5rem;
            font-size: 1.15rem;
            font-weight: 600;
        }

        /* Table styling */
        .table {
            margin-bottom: 0;
            /* Remove default margin */
        }

        .table thead th {
            background-color: #e9ecef;
            /* Warna header tabel */
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }

        .table tbody tr:hover {
            background-color: #f2f2f2;
            /* Hover effect for table rows */
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .03);
        }

        /* Modal styling */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background-color: #0d6efd;
            /* Primary blue for modal header */
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
            padding-top: 1rem;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0 d-flex">

        <div class="sidebar d-none d-md-flex flex-column p-3 text-white bg-dark">
            <a href="/" class="d-flex flex-column align-items-center mb-3 text-white text-decoration-none">
                <i class="bi bi-buildings-fill mb-2 fs-2"></i>
                <span class="fs-5">Nama Sekolah</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                 <li class="nav-item mb-1">
                            <a class="nav-link" href="{{ route('guru.dashboard') }}"><i
                                    class="bi bi-house-door-fill me-2"></i>Beranda</a>
                        </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('matapelajaran.halaman_mata_pelajaran') }}" class="nav-link">
                        <i class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('materi.halamanMateri') }}" class="nav-link">
                        <i class="bi bi-file-earmark-text-fill me-2"></i>Materi
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('tugas.hal_tugas') }}" class="nav-link">
                        <i class="bi bi-card-checklist me-2"></i>Tugas Siswa
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link">
                        <i class="bi bi-patch-check-fill me-2"></i>Kuis
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="{{ route('guru.hal_absensi') }}"><i
                            class="bi bi-clipboard-check-fill me-2"></i>Absensi</a>
                </li>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="{{ route('guru.chat.index') }}"><i
                            class="bi bi-chat-left-dots-fill me-2"></i>Konsultasi Ortu</a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2 fs-4"></i>
                    <strong>{{ Auth::user()->name ?? 'Guru Hebat' }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarOffcanvas"
            aria-labelledby="sidebarOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Menu Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-1"><a href="#" class="nav-link active"><i
                                class="bi bi-house-door-fill me-2"></i>Beranda</a></li>
                    <li class="nav-item mb-1"><a href="#" class="nav-link"><i
                                class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran</a></li>
                    <li class="nav-item mb-1"><a href="#" class="nav-link"><i
                                class="bi bi-file-earmark-text-fill me-2"></i>Materi</a></li>
                    <li class="nav-item mb-1"><a href="#" class="nav-link"><i
                                class="bi bi-card-checklist me-2"></i>Tugas Siswa</a></li>
                    <li class="nav-item mb-1"><a href="#" class="nav-link"><i
                                class="bi bi-patch-check-fill me-2"></i>Kuis</a></li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2 fs-4"></i>
                        <strong>{{ Auth::user()->name ?? 'Guru Hebat' }}</strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow">
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


        <div class="main-content flex-grow-1">
            <header class="p-3 mb-3 border-bottom  sticky-top" style="background-color: #133869;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-dark d-md-none me-3" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                            <i class="bi bi-list"></i>
                        </button>
                        <h5 class="mb-0 text-white">Dashboard Guru</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light" type="button">
                            <i class="bi bi-bell-fill fs-5"></i>
                        </button>
                    </div>
                </div>
            </header>

            <main class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Data Ujian / Kuis</h1>
                    <button type="button" class="btn btn-custom-green shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#ujianModal" data-action="add">
                        <i class="bi bi-plus-circle-fill me-2"></i>
                        Tambah Ujian
                    </button>
                </div>

                {{-- Notifikasi Sukses/Error --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        Daftar Ujian Aktif
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                Menunjukkan
                                <select class="form-select form-select-sm d-inline-block w-auto">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                </select>
                                Masuk
                            </div>
                            <div>
                                Cari
                                <input type="text" class="form-control d-inline-block w-auto ms-2"
                                    placeholder="Cari...">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Jenis Soal</th>
                                        <th>Tipe Soal</th>
                                        <th>Tanggal Ujian</th>
                                        <th>Soal</th>
                                        <th>Status</th>
                                        <th>Pilih Kelas Ujian</th>
                                        <th class="text-center">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Contoh data ujian. Di aplikasi nyata, ini dari database --}}
                                    <tr>
                                        <td>1.</td>
                                        <td>Matematika</td>
                                        <td>Pilihan Ganda</td>
                                        <td>Ulangan Harian</td>
                                        <td>2024-06-10</td>
                                        <td><a href="#" class="btn btn-sm btn-outline-info"><i
                                                    class="bi bi-file-earmark-text"></i> Lihat</a></td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                        <td>
                                            <select class="form-select form-select-sm">
                                                <option>X IPA 1</option>
                                                <option>X IPA 2</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-edit me-1"
                                                data-bs-toggle="modal" data-bs-target="#ujianModal" data-action="edit"
                                                data-id="1" data-mapel="Matematika" data-jenis="Pilihan Ganda"
                                                data-tipe="Ulangan Harian" data-tanggal="2024-06-10" data-status="aktif"
                                                data-kelas="X IPA 1">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-delete">
                                                <i class="bi bi-trash"></i> Del
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Bahasa Indonesia</td>
                                        <td>Esai</td>
                                        <td>Ujian Akhir Semester</td>
                                        <td>2024-12-15</td>
                                        <td><a href="#" class="btn btn-sm btn-outline-info"><i
                                                    class="bi bi-file-earmark-text"></i> Lihat</a></td>
                                        <td><span class="badge bg-secondary">Draft</span></td>
                                        <td>
                                            <select class="form-select form-select-sm">
                                                <option>Semua Kelas</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-edit me-1"
                                                data-bs-toggle="modal" data-bs-target="#ujianModal" data-action="edit"
                                                data-id="2" data-mapel="Bahasa Indonesia" data-jenis="Esai"
                                                data-tipe="Ujian Akhir Semester" data-tanggal="2024-12-15"
                                                data-status="draft" data-kelas="Semua Kelas">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-delete">
                                                <i class="bi bi-trash"></i> Del
                                            </button>
                                        </td>
                                    </tr>
                                    {{-- Tambahkan baris data ujian lainnya di sini --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- Petunjuk Langkah (opsional) --}}
                        <div class="alert alert-info mt-4" role="alert">
                            <h4 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i>Petunjuk Langkah!</h4>
                            <p>Untuk menambahkan ujian baru, klik tombol "Tambah Ujian". Untuk mengedit, klik tombol
                                "Edit" pada baris ujian yang sesuai.</p>
                            <hr>
                            <p class="mb-0">Pastikan semua data terisi dengan benar sebelum menyimpan.</p>
                        </div>
                    </div>
                </div>



                {{-- Modal Tambah/Edit Ujian --}}
                <div class="modal fade" id="ujianModal" tabindex="-1" aria-labelledby="ujianModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ujianModalLabel">Tambah Ujian Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="ujianForm" method="POST" action=""> {{-- Action akan diset via JS --}}
                                @csrf
                                <div class="modal-body">
                                    {{-- Field tersembunyi untuk method PUT/PATCH saat edit --}}
                                    <div id="methodContainer"></div>
                                    <input type="hidden" id="ujianId" name="id"> {{-- Untuk menyimpan ID saat edit --}}

                                    <div class="mb-3">
                                        <label for="guru_pembuat" class="form-label">Guru Pembuat</label>
                                        <input type="text" class="form-control" id="guru_pembuat"
                                            value="{{ Auth::user()->nama ?? '' }}" readonly
                                            style="background-color: #e9ecef;">
                                    </div>

                                    <div class="mb-3">
                                        <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
                                        <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                            <option value="">Pilih Mata Pelajaran</option>
                                            @php
                                                $mataPelajaranOptions = ['Matematika', 'Bahasa Indonesia', 'Ilmu Pengetahuan Alam', 'Sejarah', 'Seni Budaya'];
                                            @endphp
                                            @foreach($mataPelajaranOptions as $mp)
                                                <option value="{{ $mp }}">{{ $mp }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenis_soal" class="form-label">Jenis Soal</label>
                                        <select class="form-select" id="jenis_soal" name="jenis_soal" required>
                                            <option value="">Pilih Jenis Soal</option>
                                            <option value="Pilihan Ganda">Pilihan Ganda</option>
                                            <option value="Esai">Esai</option>
                                            <option value="Isian Singkat">Isian Singkat</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tipe_soal" class="form-label">Tipe Soal</label>
                                        <select class="form-select" id="tipe_soal" name="tipe_soal" required>
                                            <option value="">Pilih Tipe Soal</option>
                                            <option value="Ulangan Harian">Ulangan Harian</option>
                                            <option value="Ujian Tengah Semester">Ujian Tengah Semester</option>
                                            <option value="Ujian Akhir Semester">Ujian Akhir Semester</option>
                                            <option value="Latihan">Latihan</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_ujian" class="form-label">Tanggal Ujian</label>
                                        <input type="date" class="form-control" id="tanggal_ujian" name="tanggal_ujian"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="draft">Draft</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="selesai">Selesai</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kelas_ujian" class="form-label">Pilih Kelas Ujian</label>
                                        <select class="form-select" id="kelas_ujian" name="kelas_ujian" required>
                                            <option value="">Pilih Kelas</option>
                                            @php
                                                $kelasOptions = ['X IPA 1', 'X IPS 1', 'XI IPA 2', 'XI IPS 2', 'XII IPA 3', 'XII IPS 3', 'Semua Kelas'];
                                            @endphp
                                            @foreach($kelasOptions as $kelas)
                                                <option value="{{ $kelas }}">{{ $kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Untuk upload/link soal akan lebih kompleks. Untuk sementara ini teks area atau
                                    input file --}}
                                    <div class="mb-3">
                                        <label for="deskripsi_soal" class="form-label">Deskripsi Soal (Opsional)</label>
                                        <textarea class="form-control" id="deskripsi_soal" name="deskripsi_soal"
                                            rows="3" placeholder="Deskripsi singkat atau link soal"></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" id="submitUjianButton">Simpan
                                        Ujian</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const ujianModal = document.getElementById('ujianModal');
                        ujianModal.addEventListener('show.bs.modal', function (event) {
                            const button = event.relatedTarget; // Button that triggered the modal
                            const action = button.getAttribute('data-action'); // 'add' or 'edit'
                            const modalTitle = ujianModal.querySelector('.modal-title');
                            const ujianForm = ujianModal.querySelector('#ujianForm');
                            const methodContainer = ujianModal.querySelector('#methodContainer');
                            const submitButton = ujianModal.querySelector('#submitUjianButton');

                            // Clear previous validation errors (if any)
                            ujianForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                            ujianForm.querySelectorAll('.text-danger').forEach(el => el.remove());

                            // Reset form fields
                            ujianForm.reset(); // Resets all form fields to their initial state

                            if (action === 'add') {
                                modalTitle.textContent = 'Tambah Ujian Baru';
                                ujianForm.action = "{{ route('ujian.store') }}"; // Ganti dengan route store ujian Anda
                                methodContainer.innerHTML = ''; // Remove _method for POST
                                submitButton.textContent = 'Simpan Ujian';
                            } else if (action === 'edit') {
                                modalTitle.textContent = 'Edit Data Ujian';
                                methodContainer.innerHTML = "@method('PUT')"; // Add _method for PUT/PATCH

                                const id = button.getAttribute('data-id');
                                const mapel = button.getAttribute('data-mapel');
                                const jenis = button.getAttribute('data-jenis');
                                const tipe = button.getAttribute('data-tipe');
                                const tanggal = button.getAttribute('data-tanggal');
                                const status = button.getAttribute('data-status');
                                const kelas = button.getAttribute('data-kelas');
                                // const deskripsi = button.getAttribute('data-deskripsi'); // Jika ada deskripsi soal

                                ujianForm.action = `/ujian/${id}`; // Ganti dengan route update ujian Anda

                                // Populate form fields for editing
                                ujianModal.querySelector('#ujianId').value = id;
                                ujianModal.querySelector('#mata_pelajaran').value = mapel;
                                ujianModal.querySelector('#jenis_soal').value = jenis;
                                ujianModal.querySelector('#tipe_soal').value = tipe;
                                ujianModal.querySelector('#tanggal_ujian').value = tanggal;
                                ujianModal.querySelector('#status').value = status;
                                ujianModal.querySelector('#kelas_ujian').value = kelas;
                                // if (deskripsi) {
                                //     ujianModal.querySelector('#deskripsi_soal').value = deskripsi;
                                // }

                                submitButton.textContent = 'Simpan Perubahan';
                            }
                        });
                    });
                </script>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>