<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Anak: {{ $anak->nama }} - Portal Orang Tua</title>

    {{-- CSS dari CDN Bootstrap & Google Fonts --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #0dcaf0;
            --light-bg: #f8f9fa;
            --white-bg: #ffffff;
            --border-color: #e0e0e0;
            --text-dark: #212529;
            --text-muted: #6c757d;
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

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .navbar .btn-outline-secondary {
            border-color: var(--border-color);
            color: var(--secondary-color);
            transition: all 0.3s ease;
        }
        .navbar .btn-outline-secondary:hover {
            background-color: var(--secondary-color);
            color: var(--white-bg);
        }

        .hero-section {
            background: linear-gradient(to right, var(--primary-color), #007bff);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .hero-section h1 {
            font-weight: 700;
            font-size: 2.8rem;
            margin-bottom: 0.5rem;
        }
        .hero-section p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        .hero-section .lead {
            font-weight: 500;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card-header {
            background-color: var(--white-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
        }
        .card-header i {
            margin-right: 10px;
            font-size: 1.5rem;
            color: var(--primary-color); /* Default icon color */
        }
        .card-header.bg-success i { color: var(--success-color); }
        .card-header.bg-info i { color: var(--info-color); }
        .card-header.bg-warning i { color: var(--warning-color); }
        .card-header.bg-danger i { color: var(--danger-color); }


        .card-body {
            padding: 1.5rem;
        }

        .table-responsive {
            margin-top: 1rem;
        }
        .table {
            --bs-table-bg: var(--white-bg);
            --bs-table-border-color: var(--border-color);
            --bs-table-striped-bg: #f2f4f6;
            font-size: 0.95rem;
        }
        .table thead th {
            font-weight: 600;
            background-color: #f0f2f5;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
        }
        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .list-group-item {
            border-color: var(--border-color);
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .list-group-item:first-child { border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem; }
        .list-group-item:last-child { border-bottom-left-radius: 0.75rem; border-bottom-right-radius: 0.75rem; }

        .progress-bar {
            border-radius: 5px;
        }

        /* Status badges */
        .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.3em 0.7em;
            border-radius: 0.5rem;
        }
        .status-hadir { background-color: var(--success-color); color: white; }
        .status-sakit { background-color: var(--warning-color); color: var(--text-dark); }
        .status-izin { background-color: var(--info-color); color: white; }
        .status-alfa { background-color: var(--danger-color); color: white; }
        .status-terkumpul { background-color: var(--success-color); color: white; }
        .status-belum-kumpul { background-color: var(--warning-color); color: var(--text-dark); }
        .status-dinilai { background-color: var(--primary-color); color: white; }
        .status-dikerjakan { background-color: var(--info-color); color: white; } /* Tambah status dikerjakan */


        .avg-score {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .grade-display {
            font-size: 2.5rem; /* Ukuran grade */
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .grade-A { color: var(--success-color); }
        .grade-B { color: #28a745; } /* Slightly darker green than success */
        .grade-C { color: var(--info-color); }
        .grade-D { color: var(--warning-color); }
        .grade-E { color: var(--danger-color); }


        /* Responsive adjustments */
        @media (max-width: 992px) {
            .hero-section h1 {
                font-size: 2.2rem;
            }
            .hero-section p {
                font-size: 1.1rem;
            }
            .grade-display {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 0;
                margin-bottom: 1.5rem;
                border-radius: 0;
            }
            .hero-section h1 {
                font-size: 2rem;
            }
            .hero-section p {
                font-size: 1rem;
            }
            .container {
                padding-left: var(--bs-gutter-x, 0.75rem);
                padding-right: var(--bs-gutter-x, 0.75rem);
            }
            .card {
                margin-bottom: 1.5rem;
            }
            .card-header {
                padding: 1rem 1.25rem;
            }
            .card-header i {
                font-size: 1.3rem;
            }
            .card-body {
                padding: 1.25rem;
            }
            .table {
                font-size: 0.9rem;
            }
            .grade-display {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.1rem !important;
            }
            .hero-section h1 {
                font-size: 1.75rem;
            }
            .hero-section p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('orangtua.dashboard') }}">Portal Orang Tua</a>
            <div class="ms-auto">
                <a href="{{ route('orangtua.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="hero-section">
        <div class="container text-center">
            <h1>Profil Anak</h1>
            <p class="lead mb-0">Memantau Perkembangan: <span class="fw-bold">{{ $anak->nama }}</span></p>
            <p class="mb-0">Kelas: <span class="fw-medium">{{ $anak->kelas->nama_kelas ?? 'N/A' }}</span></p>
            <p class="mb-0">Wali Kelas: <span class="fw-medium">{{ $anak->kelas->waliKelas->nama ?? 'N/A' }}</span></p>
        </div>
    </div>

    <main class="container py-4">
        <div class="row g-4">
            {{-- Kartu Ringkasan Nilai --}}
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-bar-chart-fill me-2"></i>Ringkasan Nilai
                    </div>
                    <div class="card-body">
                        @if ($rataRataNilaiPerMapel->isNotEmpty())
                            <h5 class="mb-3">Rata-rata Nilai Per Mata Pelajaran:</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($rataRataNilaiPerMapel as $mapel => $rataRata)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $mapel }}</span>
                                        <span class="badge bg-primary rounded-pill avg-score">{{ round($rataRata, 1) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <h5 class="mt-4 mb-3">5 Nilai Akademik Terbaru:</h5> {{-- Perbarui judul --}}
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Mapel</th>
                                            <th>Jenis</th>
                                            <th>Nilai</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nilaiTerbaru as $nilai)
                                            <tr>
                                                <td>{{ $nilai->mataPelajaran->nama_mapel ?? 'N/A' }}</td>
                                                <td>{{ $nilai->jenis_nilai }}</td>
                                                <td><span class="fw-bold">{{ $nilai->nilai }}</span></td>
                                                <td>{{ \Carbon\Carbon::parse($nilai->created_at)->format('d M Y') }}</td> {{-- Menggunakan created_at --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>Belum ada data nilai akademik untuk anak Anda.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kartu Ringkasan Absensi --}}
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-calendar-check-fill me-2"></i>Ringkasan Absensi (30 Hari Terakhir)
                    </div>
                    <div class="card-body">
                        @if ($rekapAbsensi->isNotEmpty())
                            <div class="row text-center mb-4">
                                @php
                                    $totalAbsensi = $rekapAbsensi->sum();
                                    $hadir = $rekapAbsensi['hadir'] ?? 0;
                                    $sakit = $rekapAbsensi['sakit'] ?? 0;
                                    $izin = $rekapAbsensi['izin'] ?? 0;
                                    $alfa = $rekapAbsensi['alfa'] ?? 0;
                                @endphp
                                <div class="col-3">
                                    <h4 class="fw-bold text-success">{{ $hadir }}</h4>
                                    <p class="text-muted mb-0">Hadir</p>
                                </div>
                                <div class="col-3">
                                    <h4 class="fw-bold text-warning">{{ $sakit }}</h4>
                                    <p class="text-muted mb-0">Sakit</p>
                                </div>
                                <div class="col-3">
                                    <h4 class="fw-bold text-info">{{ $izin }}</h4>
                                    <p class="text-muted mb-0">Izin</p>
                                </div>
                                <div class="col-3">
                                    <h4 class="fw-bold text-danger">{{ $alfa }}</h4>
                                    <p class="text-muted mb-0">Alfa</p>
                                </div>
                            </div>

                            <h5 class="mb-3">Riwayat Absensi Terbaru:</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Mapel</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($presensiTerbaru as $presensi)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d M Y') }}</td>
                                                <td>{{ $presensi->mataPelajaran->nama_mapel ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="status-badge status-{{ strtolower($presensi->status) }}">
                                                        {{ ucfirst($presensi->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>Belum ada data absensi untuk anak Anda.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kartu Tugas & Pengumpulan --}}
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-header bg-warning text-dark">
                        <i class="bi bi-journal-check me-2"></i>Tugas dan Pengumpulan
                    </div>
                    <div class="card-body">
                        @if ($tugasTerbaru->isNotEmpty() || $jumlahTugasDinilai > 0) {{-- Tambahkan cek jumlah tugas dinilai --}}
                            <div class="row align-items-center mb-4 text-center">
                                <div class="col-md-6 border-end">
                                    <p class="text-muted mb-1">Rata-rata Nilai Tugas</p>
                                    <h2 class="grade-display text-primary">{{ round($persentaseNilaiTugas, 1) }}%</h2>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1">Grade Keseluruhan Tugas</p>
                                    <h2 class="grade-display grade-{{ $gradeTugas }}"> {{ $gradeTugas }}</h2>
                                </div>
                                @if ($jumlahTugasDinilai > 0)
                                    <div class="col-12 mt-3">
                                        <p class="text-muted mb-0"><small>Berdasarkan {{ $jumlahTugasDinilai }} tugas yang sudah dinilai.</small></p>
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <h5 class="mb-3">Tugas Terbaru & Status Pengumpulan:</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tugas</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Batas Waktu</th>
                                            <th>Status</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tugasTerbaru as $pengumpulan)
                                            <tr>
                                                <td>{{ $pengumpulan->tugas->judul ?? 'N/A' }}</td>
                                                <td>{{ $pengumpulan->tugas->mataPelajaran->nama_mapel ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pengumpulan->tugas->deadline)->format('d M Y H:i') }}</td>
                                                <td>
                                                    @if ($pengumpulan->status == 'terkumpul')
                                                        <span class="status-badge status-terkumpul">Terkumpul</span>
                                                    @elseif ($pengumpulan->status == 'dinilai')
                                                        <span class="status-badge status-dinilai">Dinilai</span>
                                                    @else
                                                        <span class="status-badge status-belum-kumpul">Belum Terkumpul</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($pengumpulan->nilai)
                                                        <span class="fw-bold text-primary">{{ $pengumpulan->nilai }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>Belum ada data tugas atau tugas yang sudah dinilai untuk anak Anda.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>

    {{-- JavaScript dari CDN Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>