<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Nama Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0A2B7A;
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            height: 100vh;
            overflow-x: hidden;
            background-color: var(--light-gray);
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 280px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-right: 1px solid var(--border-color);
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
            transition: background-color 0.2s, color 0.2s;
        }

        .sidebar .nav-link:hover {
            color: var(--primary-blue);
            background-color: #e9ecef;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--primary-blue);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-blue);
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0 d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-none d-md-flex flex-column p-3 bg-white">
            <a href="{{ route('siswa.dashboard') }}"
                class="d-flex flex-column align-items-center mb-3 text-dark text-decoration-none">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
                <span class="fs-5 fw-bold text-center">SMKS OTTO ISKANDAR DINATA BANDUNG</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="{{ route('siswa.dashboard') }}" class="nav-link"><i
                            class="bi bi-house-door-fill me-2"></i>Beranda</a></li>
                <li class="nav-item"><a href="{{ route('siswa.presensi.index') }}" class="nav-link"><i
                            class="bi bi-person-check-fill me-2"></i>Presensi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.tugas.index') }}" class="nav-link"><i
                            class="bi bi-card-checklist me-2"></i>Tugas</a></li>
                <li class="nav-item"><a href="{{ route('siswa.materi.index') }}" class="nav-link"><i
                            class="bi bi-book-half me-2"></i>Materi</a></li>
                <li class="nav-item"><a href="{{ route('siswa.nilai.index') }}" class="nav-link"><i
                            class="bi bi-bar-chart-line-fill me-2"></i>Nilai</a></li>
                <li class="nav-item"><a href="{{ route('siswa.kelas.index') }}" class="nav-link"><i
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
                    <li><a class="dropdown-item active" href="{{ route('siswa.profil.show') }}">Profil Saya</a></li>
                    <li>
                        <hr class="dropdown-divider">
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

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <header class="p-3 mb-4 bg-white border-bottom sticky-top">
                <h5 class="mb-0 text-dark fw-bold">Profil Saya</h5>
            </header>

            <main class="p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="{{ $user->profile && $user->profile->foto_profil ? Storage::url($user->profile->foto_profil) : 'https://placehold.co/120x120/0A2B7A/FFFFFF?text=' . strtoupper(substr($user->nama, 0, 1)) }}"
                                    alt="Foto Profil" class="rounded-circle profile-avatar mb-3">
                                <h4 class="fw-bold mb-1">{{ $user->nama }}</h4>
                                <p class="text-muted mb-0">{{ $user->kelas->nama_kelas ?? 'Belum ada kelas' }}</p>
                            </div>
                            <div class="col-md-9">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-akun-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-akun" type="button" role="tab"
                                            aria-controls="pills-akun" aria-selected="true">Informasi Akun</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-pribadi-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-pribadi" type="button" role="tab"
                                            aria-controls="pills-pribadi" aria-selected="false">Data Pribadi</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-akun" role="tabpanel"
                                        aria-labelledby="pills-akun-tab" tabindex="0">
                                        <form action="{{ route('siswa.profil.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                                    <input type="text" class="form-control" id="nama" name="nama"
                                                        value="{{ old('nama', $user->nama) }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" value="{{ old('username', $user->username) }}"
                                                        required>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="email" class="form-label">Alamat Email</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        value="{{ old('email', $user->email) }}" required>
                                                </div>
                                                <h6 class="mt-3">Ubah Password (Opsional)</h6>
                                                <div class="col-md-6 mb-3">
                                                    <label for="password" class="form-label">Password Baru</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="password_confirmation" class="form-label">Konfirmasi
                                                        Password</label>
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation" name="password_confirmation">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan
                                                Akun</button>
                                    </div>
                                    <div class="tab-pane fade" id="pills-pribadi" role="tabpanel"
                                        aria-labelledby="pills-pribadi-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                                <input type="text" class="form-control" id="no_telepon"
                                                    name="no_telepon"
                                                    value="{{ old('no_telepon', $user->profile->no_telepon ?? '') }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="tanggal_lahir"
                                                    name="tanggal_lahir"
                                                    value="{{ old('tanggal_lahir', optional($user->profile)->tanggal_lahir ? $user->profile->tanggal_lahir->format('Y-m-d') : '') }}">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat"
                                                    rows="3">{{ old('alamat', $user->profile->alamat ?? '') }}</textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="foto_profil" class="form-label">Ganti Foto Profil
                                                    (Opsional)</label>
                                                <input class="form-control" type="file" id="foto_profil"
                                                    name="foto_profil">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan
                                            Data</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>