<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Orang Tua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd; /* Bootstrap Blue */
            --secondary-color: #6c757d; /* Bootstrap Gray */
            --success-color: #198754; /* Bootstrap Green */
            --info-color: #0dcaf0; /* Bootstrap Cyan */
            --light-bg: #f8f9fa; /* Light background */
            --white-bg: #ffffff; /* White background */
            --border-color: #e0e0e0; /* Light border */
            --text-dark: #212529; /* Dark text */
            --text-muted: #6c757d; /* Muted text */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

        .navbar {
            background-color: var(--white-bg) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .navbar-brand .fs-5 {
            font-weight: 600;
            color: var(--text-dark);
        }

        .hero-section {
            background: linear-gradient(to right, var(--primary-color), #007bff); /* Gradient biru */
            color: white;
            padding: 4rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px; /* Sudut bawah membulat */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .hero-section h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); /* Shadow lebih halus */
            transition: all 0.3s ease;
            overflow: hidden; /* Penting untuk border-radius */
        }

        .card-link {
            text-decoration: none;
            color: inherit; /* Tetap menggunakan warna teks default */
            display: block; /* Agar link menutupi seluruh kartu */
            height: 100%; /* Agar card-link mengambil tinggi penuh kolom */
        }

        .card-link .card:hover {
            transform: translateY(-8px); /* Efek angkat lebih jelas */
            box-shadow: 0 12px 30px rgba(0,0,0,0.18); /* Shadow lebih kuat saat hover */
        }

        .card-body {
            padding: 25px;
        }

        .card-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .card-title i {
            font-size: 1.8rem; /* Ukuran ikon judul */
            margin-right: 10px;
            color: var(--primary-color); /* Warna ikon sesuai primary */
        }
        .card-title.chat-icon i {
            color: var(--success-color); /* Ikon chat warna hijau */
        }


        .card p.text-muted {
            font-size: 0.95rem;
            color: var(--text-muted) !important;
            line-height: 1.5;
        }

        /* Spesifik untuk kartu informasi anak */
        .info-anak .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-anak h4 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        .info-anak p.mb-2 {
            font-size: 1.05rem;
            color: var(--secondary-color);
        }
        .info-anak .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .info-anak .btn-primary:hover {
            background-color: #0a58ca;
            border-color: #0a58ca;
            transform: translateY(-2px);
        }

        /* Spesifik untuk kartu konsultasi guru */
        .konsultasi-guru .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .konsultasi-guru .card-body i {
            font-size: 4rem; /* Ikon sangat besar */
            color: var(--success-color);
            margin-bottom: 20px;
        }

        .konsultasi-guru h5 {
            color: var(--text-dark); /* Judul konsultasi warna gelap */
            margin-bottom: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .hero-section {
                padding: 3rem 0;
            }
            .hero-section h1 {
                font-size: 2rem;
            }
            .hero-section p {
                font-size: 1rem;
            }
            .card-title {
                font-size: 1.25rem;
            }
            .card-title i {
                font-size: 1.5rem;
            }
            .info-anak h4 {
                font-size: 1.75rem;
            }
            .konsultasi-guru .card-body i {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 0;
                margin-bottom: 1.5rem;
                border-radius: 0; /* Tanpa radius di mobile penuh */
            }
            .hero-section h1 {
                font-size: 1.75rem;
            }
            .hero-section p {
                font-size: 0.95rem;
            }
            .container {
                padding-left: var(--bs-gutter-x, 0.75rem); /* Tambahkan padding default bootstrap */
                padding-right: var(--bs-gutter-x, 0.75rem);
            }
            .col-md-6 {
                width: 100%; /* Kartu menjadi stack vertikal */
            }
            .card {
                margin-bottom: 1rem; /* Tambah jarak antar kartu */
            }
            .card-body {
                padding: 20px;
            }
            .card-title {
                font-size: 1.15rem;
            }
            .card-title i {
                font-size: 1.3rem;
            }
            .info-anak h4 {
                font-size: 1.5rem;
            }
            .info-anak .btn-primary {
                width: 100%; /* Tombol memenuhi lebar kartu */
            }
            .konsultasi-guru .card-body i {
                font-size: 3rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand .fs-5 {
                font-size: 1.1rem !important; /* Ukuran teks nama sekolah di navbar */
            }
            .navbar-brand img {
                width: 40px; /* Ukuran logo lebih kecil */
                margin-right: 10px !important;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('orangtua.dashboard') }}">
                {{-- Pastikan path image benar --}}
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
                <span class="fs-5 d-none d-sm-inline">SMKS Otto Iskandar Dinata Bandung</span>
            </a>
            <div class="ms-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container text-center">
            <h1 class="mb-2">Selamat Datang, {{ $orangTua->nama }}!</h1>
            <p class="lead">Siap untuk memantau perkembangan belajar anak Anda?</p>
        </div>
    </div>

    <main class="container py-4"> {{-- Gunakan py-4 agar tidak terlalu mepet ke hero section --}}
        <div class="row g-4">
            {{-- Kartu Informasi Anak --}}
            <div class="col-lg-6 col-md-6 info-anak"> {{-- Tambah col-lg-6 untuk desktop besar --}}
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="bi bi-person-fill"></i>Informasi Anak</h5>
                        <p class="text-muted flex-grow-1">Lihat detail perkembangan akademis dan non-akademis anak Anda, termasuk nilai dan kehadiran.</p>
                        <div class="mt-auto pt-3 border-top"> {{-- Tambah border-top dan pt --}}
                            <h4 class="fw-bold text-primary">{{ $anak->nama }}</h4> {{-- Nama anak lebih menonjol --}}
                            <p class="mb-3">Kelas: <span class="fw-medium">{{ $anak->kelas->nama_kelas ?? 'Belum ada kelas' }}</span></p>
                            <a href="{{ route('orangtua.anak.show') }}" class="btn btn-primary">Lihat Detail Perkembangan <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Konsultasi Guru --}}
            <div class="col-lg-6 col-md-6 konsultasi-guru"> {{-- Tambah col-lg-6 untuk desktop besar --}}
                <a href="{{ route('orangtua.chat.index') }}" class="card-link">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <i class="bi bi-chat-left-text-fill"></i> {{-- Warna ikon sudah diatur di CSS --}}
                            <h5 class="card-title text-center chat-icon">Konsultasi dengan Guru</h5> {{-- Hapus flex dan icon dari h5 --}}
                            <p class="text-muted">Mulai percakapan atau lihat riwayat konsultasi penting dengan para guru secara langsung.</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Anda bisa menambahkan kartu lain di sini jika ada fitur tambahan --}}
            {{-- Contoh Kartu Pengumuman/Berita Sekolah --}}
            <div class="col-lg-6 col-md-6">
                <a href="#" class="card-link"> {{-- Ganti dengan route yang sesuai --}}
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column text-center justify-content-center">
                            <i class="bi bi-megaphone-fill text-info fs-1 mb-3"></i>
                            <h5 class="card-title text-center text-info">Pengumuman Sekolah</h5>
                            <p class="text-muted">Dapatkan informasi terbaru seputar kegiatan dan pengumuman dari sekolah.</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Contoh Kartu Jadwal Pelajaran --}}
            <div class="col-lg-6 col-md-6">
                <a href="#" class="card-link"> {{-- Ganti dengan route yang sesuai --}}
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column text-center justify-content-center">
                            <i class="bi bi-calendar-check-fill text-warning fs-1 mb-3"></i>
                            <h5 class="card-title text-center text-warning">Jadwal Pelajaran</h5>
                            <p class="text-muted">Lihat jadwal pelajaran anak Anda untuk hari dan minggu ini.</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>