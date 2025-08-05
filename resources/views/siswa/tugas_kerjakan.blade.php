<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kerjakan Tugas: Laporan Observasi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --bs-primary-rgb: 76, 175, 80;
            /* Warna hijau sebagai primer */
            --bs-body-font-family: 'Poppins', sans-serif;
            --bs-body-bg: #f8f9fa;
        }

        body {
            font-family: var(--bs-body-font-family);
            background-color: var(--bs-body-bg);
            color: #495057;
        }

        .main-container {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .task-card {
            border: none;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            height: 100%;
        }

        .task-details,
        .submission-form {
            padding: 2rem;
        }

        .task-details {
            background-color: #fdfdff;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .btn-back {
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .detail-item .icon {
            font-size: 1.2rem;
            width: 30px;
            color: var(--bs-primary);
        }

        .instructions {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            font-size: 0.95rem;
            border-left: 4px solid var(--bs-primary);
        }

        .file-upload-zone {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 2.5rem;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .file-upload-zone.drag-over {
            background-color: #e9ecef;
            border-color: var(--bs-primary);
        }

        .file-upload-zone .icon {
            font-size: 3rem;
            color: #adb5bd;
        }

        .file-upload-zone p {
            margin: 0.5rem 0 0;
            font-weight: 500;
        }

        .file-upload-zone small {
            font-size: 0.85rem;
        }

        .btn-primary {
            font-weight: 600;
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
    </style>
</head>

<body>

    <div class="container main-container">
        {{-- 1. Menampilkan Pesan Sukses (Session 'success') --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fw-medium" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- 2. Menampilkan Pesan Error (Session 'error') --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show fw-medium" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- 3. Menampilkan Error Validasi (jika ada) --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="fw-bold">Terdapat Kesalahan:</h6>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <header class="page-header d-flex justify-content-between align-items-center">
            <h1 class="h3 fw-bold mb-0">Pengumpulan Tugas</h1>
            <a href="{{ route('siswa.tugas.index') }}" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </header>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="task-card">
                    <div class="task-details">
                        <h4 class="fw-bold mb-4">Form Pengumpulan Tugas</h4>

                        <div class="detail-item">
                            <i class="fas fa-book icon"></i>
                            <div>
                                <h6 class="mb-0 fw-semibold">Mata Pelajaran</h6>
                                <p class="mb-0 text-muted">{{ $tugas->mataPelajaran->nama_mapel }}</p>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-calendar-alt icon"></i>
                            <div>
                                <h6 class="mb-0 fw-semibold">Batas Waktu</h6>
                                <p class="mb-0 text-danger fw-medium">
                                    {{ \Carbon\Carbon::parse($tugas->batas_waktu)->translatedFormat('l, d F Y, H:i') }}
                                    WIB</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-semibold mb-3">Deskripsi & Petunjuk</h6>
                        <div class="instructions">
                            <p>{{ $sapaan }}, anak-anak.</p>
                            <p>{!! $tugas->deskripsi !!}</p>
                            <p class="mb-0"><strong>Ketentuan:</strong></p>
                            <ul>
                                <li>Laporan diketik dalam format .DOCX atau .PDF.</li>
                                <li>Minimal 2 halaman.</li>
                                <li>Sertakan minimal 1 foto hasil observasi Anda.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="task-card">
                    <div class="submission-form">
                        <form action="{{ route('siswa.tugas.kumpulkan', $tugas->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="file_tugas" class="form-label">Unggah Jawaban Anda</label>
                                <div id="file-upload-zone" class="file-upload-zone">
                                    <input type="file" id="file_tugas" name="file_tugas" class="d-none" required>
                                    <i class="fas fa-cloud-upload-alt icon"></i>
                                    <p id="file-name">Klik atau seret file ke sini</p>
                                    <small class="text-muted">PDF, DOCX, ZIP (Maks. 10MB)</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="catatan_siswa" class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" id="catatan_siswa" name="catatan_siswa" rows="5"
                                    placeholder="Tambahkan catatan untuk guru jika perlu..."></textarea>
                            </div>

                            <div class="alert alert-info small" role="alert">
                                <i class="fas fa-info-circle me-1"></i>
                                Harap teliti dalam pengumpulan tugas ini.
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Kumpulkan Tugas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadZone = document.getElementById('file-upload-zone');
            const fileInput = document.getElementById('file_tugas');
            const fileNameDisplay = document.getElementById('file-name');

            // Buka file dialog saat zona diklik
            uploadZone.addEventListener('click', () => fileInput.click());

            // Update nama file saat dipilih
            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) {
                    fileNameDisplay.textContent = fileInput.files[0].name;
                }
            });

            // Efek visual untuk Drag & Drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadZone.addEventListener(eventName, () => {
                    uploadZone.classList.add('drag-over');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadZone.addEventListener(eventName, () => {
                    uploadZone.classList.remove('drag-over');
                }, false);
            });

            // Menangani file yang di-drop
            uploadZone.addEventListener('drop', (e) => {
                let dt = e.dataTransfer;
                let files = dt.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    fileNameDisplay.textContent = files[0].name;
                }
            }, false);
        });
    </script>
</body>

</html>