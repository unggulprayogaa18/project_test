<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tugas: {{ $tugas->judul }}</title>

    {{-- CSS dari CDN Bootstrap & Google Fonts --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }

        .grade-box {
            background-color: #e9ecef;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .grade-box .score {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <main class="container py-4 py-md-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('siswa.tugas.index') }}">Tugas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hasil Pengumpulan</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-body p-4 p-md-5">
                <div class="row g-5">

                    {{-- KOLOM KIRI: DETAIL TUGAS --}}
                    <div class="col-lg-7">
                        <span class="badge bg-primary-subtle text-primary-emphasis mb-2 fs-6">
                            {{ $tugas->mataPelajaran->nama_mapel ?? 'Umum' }}
                        </span>
                        <h1 class="h2 fw-bold mb-3">{{ $tugas->judul }}</h1>
                        <p class="text-muted">
                            <i class="bi bi-calendar-event me-2"></i>Batas Waktu:
                            {{ \Carbon\Carbon::parse($tugas->batas_waktu)->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
                        </p>
                        <hr>
                        <h5 class="fw-semibold mt-4">Deskripsi Tugas Asli</h5>
                        <div class="text-body-secondary">
                            {!! nl2br(e($tugas->deskripsi)) !!}
                        </div>
                    </div>

                    {{-- KOLOM KANAN: HASIL PENGUMPULAN --}}
                    {{-- KOLOM KANAN: HASIL PENGUMPULAN --}}
                    <div class="col-lg-5">
                        <div class="border rounded-3 p-4 bg-light">
                            <h4 class="fw-semibold text-center mb-4">Hasil Pengumpulan Anda</h4>

                            {{-- ===== BAGIAN YANG DIUBAH ===== --}}

                            {{-- 1. Cek dulu apakah kolom 'nilai' SUDAH ADA ISINYA --}}
                            @if(!is_null($pengumpulan->nilai))

                                {{-- Jika nilai sudah ada, tampilkan skor --}}
                                <div class="grade-box mb-3">
                                    <span class="score">{{ $pengumpulan->nilai }}</span>
                                </div>
                                <p class="text-center text-muted fw-bold">SKOR AKHIR</p>

                                {{-- Tampilkan status berdasarkan kolom 'status' --}}
                                <div class="text-center">
                                    @if($pengumpulan->status == 'dinilai')
                                        <span class="badge bg-success-subtle text-success-emphasis fs-6">
                                            <i class="bi bi-check-circle-fill me-1"></i> Telah Dinilai
                                        </span>
                                    @else
                                        {{-- Status lain jika diperlukan, misal "Proses Verifikasi" --}}
                                        <span class="badge bg-warning-subtle text-warning-emphasis fs-6">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu Konfirmasi
                                        </span>
                                    @endif
                                </div>

                            @else

                                {{-- 2. Jika kolom 'nilai' KOSONG, baru tampilkan pesan "menunggu penilaian" --}}
                                <div class="text-center py-4">
                                    <div class="spinner-border text-primary mb-3" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-muted fw-bold">Tugas Anda sedang menunggu penilaian dari guru.</p>
                                </div>

                            @endif

                            {{-- =============================== --}}

                            <hr class="my-4">

                            {{-- Tampilkan Catatan dari Guru --}}
                            @if(!empty($pengumpulan->catatan))
                                <h6 class="fw-semibold"><i class="bi bi-chat-left-text-fill me-2"></i>Catatan dari Guru:
                                </h6>
                                <blockquote class="blockquote bg-white p-3 rounded">
                                    <p class="mb-0 fst-italic">"{{ $pengumpulan->catatan }}"</p>
                                </blockquote>
                            @endif

                            {{-- Tampilkan File yang Diunggah --}}
                            @if(!empty($pengumpulan->file_path))
                                <h6 class="fw-semibold mt-4"><i class="bi bi-paperclip me-2"></i>File yang Anda Kumpulkan:
                                </h6>
                                <a href="{{ Storage::url($pengumpulan->file_path) }}" target="_blank"
                                    class="btn btn-outline-primary w-100">
                                    <i class="bi bi-download me-2"></i>Unduh File
                                </a>
                            @else
                                <p class="text-muted text-center mt-4">Tidak ada file yang diunggah.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('siswa.tugas.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Tugas
            </a>
        </div>
    </main>

    {{-- JavaScript dari CDN Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>