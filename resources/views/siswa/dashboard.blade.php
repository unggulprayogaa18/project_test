<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Nama Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Letakkan di bagian bawah file dashboard.blade.php --}}
    <script>
        // Cek jika ada sesi 'sweet_success'
        @if (session('sweet_success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('sweet_success') }}",
                showConfirmButton: false,
                timer: 2500 // Notifikasi akan hilang setelah 2.5 detik
            });
        @endif

        // Cek jika ada sesi 'sweet_error'
        @if (session('sweet_error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('sweet_error') }}",
                confirmButtonColor: '#0A2B7A' // Menyesuaikan warna tombol dengan tema
            });
        @endif

        // Cek jika ada sesi 'sweet_info'
        @if (session('sweet_info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: "{{ session('sweet_info') }}",
                confirmButtonColor: '#0A2B7A'
            });
        @endif
    </script>
    <style>
        :root {
            --primary-blue: #0A2B7A;
            --secondary-blue: #4a69bd;
            /* Ditambahkan untuk gradient */
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            height: 100vh;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 280px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-right: 1px solid #dee2e6;
        }

        .main-content {
            overflow-y: auto;
            height: 100vh;
            width: calc(100% - 280px);
        }

        .sidebar .nav-link {
            color: #495057;
            font-weight: 500;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }

        .sidebar .nav-link:hover {
            color: #0d6efd;
            background-color: #e9ecef;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--primary-blue);
        }

        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.4em 0.7em;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0 d-flex">

        <!-- Sidebar -->
        <div class="sidebar d-none d-md-flex flex-column p-3 bg-white">
            <a href="/" class="d-flex flex-column align-items-center mb-3 text-dark text-decoration-none">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
                <span class="fs-5 fw-bold text-center">SMKS OTTO ISKANDAR DINATA BANDUNG</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="{{ route('siswa.dashboard') }}" class="nav-link active"><i
                            class="bi bi-house-door-fill me-2"></i>Beranda</a></li>
                <li class="nav-item"><a href="{{ route('siswa.presensi.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.presensi.*') ? 'active' : '' }}"><i
                            class="bi bi-person-check-fill me-2"></i>Presensi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.tugas.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}"><i
                            class="bi bi-card-checklist me-2"></i>Tugas</a></li>
                <li class="nav-item"><a href="{{ route('siswa.materi.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}"><i
                            class="bi bi-book-half me-2"></i>Materi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.nilai.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}"><i
                            class="bi bi-bar-chart-line-fill me-2"></i>Nilai</a></li>
                <li class="nav-item"><a href="{{ route('siswa.kelas.index') }}"
                        class="nav-link {{ request()->routeIs('siswa.kelas.*') ? 'active' : '' }}"><i
                            class="bi bi-people-fill me-2"></i>Kelas Saya</a></li>
              
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2 fs-4"></i>
                    <strong>{{ $user->nama ?? 'Siswa' }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="{{ route('siswa.profil.show') }}">
                                <i class="bi bi-person-fill-gear me-2"></i>Profil Saya
                            </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bi bi-box-arrow-right me-2"></i>Keluar</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="main-content flex-grow-1">
            <header class="p-3 mb-4 header sticky-top">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-bold">Dashboard Siswa</h5>
                </div>
            </header>

            <main class="p-4">
                <div class="p-5 mb-4 rounded-3 text-white"
                    style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                    <div class="container-fluid py-4">
                        <h1 class="display-5 fw-bold">Selamat Datang, {{ $user->nama ?? 'Siswa' }}!</h1>
                        <p class="col-md-8 fs-4">Semangat belajar hari ini. Mari kita lihat apa saja yang perlu kamu
                            selesaikan.</p>
                    </div>
                </div>

                <!-- Kartu Ringkasan -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi bi-list-check text-primary fs-1 me-3"></i>
                                <div>
                                    <h5 class="card-title">Tugas Belum Selesai</h5>
                                    <p class="card-text fs-2 fw-bold">{{ $tugasBelumSelesaiCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi bi-journal-text text-success fs-1 me-3"></i>
                                <div>
                                    <h5 class="card-title">Materi Baru</h5>
                                    <p class="card-text fs-2 fw-bold">{{ $materiBaruCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi bi-calendar-check text-danger fs-1 me-3"></i>
                                <div>
                                    <h5 class="card-title">Kehadiran Bulan Ini</h5>
                                    <p class="card-text fs-2 fw-bold">{{ $kehadiranPercentage ?? 100 }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Tugas dan Ujian -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-card-checklist me-2"></i>Tugas & Ujian Mendatang</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Judul</th>
                                        <th>Jenis</th>
                                        <th>Batas Waktu</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tugasMendatang as $tugas)
                                        <tr>
                                            <td>{{ $tugas->mataPelajaran->nama_mapel ?? 'N/A' }}</td>
                                            <td>{{ $tugas->judul }}</td>
                                            <td>
                                                @if ($tugas->kuis_id)
                                                    <span class="badge bg-info-subtle text-info-emphasis">Kuis</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning-emphasis">Tugas</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}</td>
                                            <td>
                                                @php $pengumpulan = $tugas->pengumpulan->where('user_id', $user->id)->first(); @endphp
                                                @if ($pengumpulan)
                                                    <span class="badge bg-success-subtle text-success-emphasis">Selesai</span>
                                                @elseif (now()->gt($tugas->batas_waktu))
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary-emphasis">Ditutup</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger-emphasis">Belum
                                                        Dikerjakan</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($pengumpulan)
                                                    {{-- Siswa SUDAH mengerjakan. Cek jenis tugas untuk link HASIL. --}}

                                                    @if($tugas->kuis_id)
                                                        {{-- Jika ini adalah kuis, arahkan ke HASIL KUIS --}}
                                                        <a href="{{ route('siswa.kuis.hasil', $tugas->kuis_id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="bi bi-patch-check-fill me-1"></i> Lihat Hasil Kuis
                                                        </a>
                                                    @else
                                                        {{-- Jika ini tugas biasa, arahkan ke HASIL TUGAS --}}
                                                        <a href="{{ route('siswa.tugas.hasil', $tugas->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="bi bi-eye-fill me-1"></i> Lihat Hasil Tugas
                                                        </a>
                                                    @endif

                                                @elseif (now()->gt($tugas->batas_waktu))
                                                    {{-- Batas waktu sudah lewat dan siswa BELUM mengerjakan. --}}

                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        <i class="bi bi-x-circle-fill me-1"></i> Terlambat
                                                    </button>

                                                @else
                                                    {{-- Siswa BELUM mengerjakan dan waktu masih ada. Cek jenis tugas untuk link
                                                    "KERJAKAN". --}}

                                                    @if($tugas->kuis_id)
                                                        {{-- Jika ini adalah kuis, arahkan ke halaman untuk MENGERJAKAN KUIS --}}
                                                        <a href="{{ route('siswa.kuis.kerjakan', $tugas->kuis_id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="bi bi-pencil-square me-1"></i> Kerjakan Kuis
                                                        </a>
                                                    @else
                                                        {{-- Jika ini tugas biasa, arahkan ke halaman detail/upload --}}
                                                        <a href="{{ route('siswa.tugas.show', $tugas->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="bi bi-upload me-1"></i> Kerjakan Tugas
                                                        </a>
                                                    @endif

                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center p-4">
                                                <p class="mb-0">Hore! Tidak ada tugas yang akan datang.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Rekap Presensi dan Materi -->
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-header"><i class="bi bi-person-check me-2"></i>Rekap Presensi Bulan Ini
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Hadir
                                        <span
                                            class="badge bg-success rounded-pill">{{ $rekapPresensi['hadir'] ?? 0 }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Izin
                                        <span
                                            class="badge bg-warning rounded-pill">{{ $rekapPresensi['izin'] ?? 0 }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Sakit
                                        <span
                                            class="badge bg-info rounded-pill">{{ $rekapPresensi['sakit'] ?? 0 }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">Alpha
                                        <span
                                            class="badge bg-danger rounded-pill">{{ $rekapPresensi['alpha'] ?? 0 }}</span>
                                    </li>
                                </ul>
                                <div class="text-end mt-3">
                                    <a href="{{ route('siswa.presensi.index') }}"
                                        class="btn btn-outline-primary btn-sm">Lihat Riwayat Presensi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-header"><i class="bi bi-book me-2"></i>Materi Pembelajaran Terbaru</div>
                            <div class="card-body">
                                <div class="list-group">
                                    @forelse ($materiTerbaru as $materi)
                                        <!-- DIUPDATE: Menambahkan class dan data-attribute untuk JS -->
                                        <a href="{{ route('siswa.materi.show', $materi->id) }}"
                                            class="list-group-item list-group-item-action materi-item"
                                            data-created-at="{{ $materi->created_at->toIso8601String() }}">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 fw-bold">
                                                    {{ $materi->judul }}
                                                    <!-- Placeholder untuk badge 'Baru' -->
                                                    <span class="new-materi-badge"></span>
                                                </h6>
                                                <small
                                                    class="text-muted">{{ $materi->mataPelajaran->nama_mapel ?? 'N/A' }}</small>
                                            </div>
                                            <p class="mb-1 text-muted">{{ Str::limit($materi->deskripsi, 100) }}</p>
                                            <small class="text-muted">Diunggah pada:
                                                {{ $materi->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</small>
                                        </a>
                                    @empty
                                        <div class="text-center p-4">
                                            <p class="mb-0">Belum ada materi baru yang ditambahkan.</p>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="text-end mt-3">
                                    <a href="{{ route('siswa.materi.index') }}"
                                        class="btn btn-outline-primary btn-sm">Lihat Semua Materi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript untuk Cek Materi Baru -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Tentukan batas waktu (7 hari yang lalu)
            const sevenDaysAgo = new Date();
            sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);

            // 2. Ambil semua elemen materi
            const materiItems = document.querySelectorAll('.materi-item');

            materiItems.forEach(item => {
                // 3. Ambil tanggal unggah dari data-attribute
                const createdAtString = item.dataset.createdAt;
                if (createdAtString) {
                    const createdAtDate = new Date(createdAtString);

                    // 4. Bandingkan tanggal unggah dengan batas waktu
                    if (createdAtDate > sevenDaysAgo) {
                        // 5. Jika materi baru, tambahkan badge
                        const badgeContainer = item.querySelector('.new-materi-badge');
                        if (badgeContainer) {
                            const newBadge = document.createElement('span');
                            newBadge.className = 'badge bg-info-subtle text-info-emphasis ms-2 fw-normal';
                            newBadge.textContent = 'Baru diunggah';
                            badgeContainer.appendChild(newBadge);
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>