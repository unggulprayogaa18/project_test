<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - LMS Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A; --putih: #FFFFFF; --latar-utama: #f5f7fa;
            --teks-utama: #1e293b; --teks-sekunder: #64748b; --border-color: #e2e8f0;
        }
        body { background-color: var(--latar-utama); font-family: 'Poppins', sans-serif; }
        .app-header { background-color: var(--putih); border-bottom: 1px solid var(--border-color); padding: 0 1.5rem; }
        .app-header .navbar-brand { font-weight: 700; color: var(--teks-utama); }
        .app-header .nav-link { color: var(--teks-sekunder); font-weight: 500; padding: 1.5rem 1rem; border-bottom: 3px solid transparent; transition: all 0.2s ease-in-out; }
        .app-header .nav-link:hover { color: var(--teks-utama); }
        .app-header .dropdown-toggle.active, .app-header .nav-link.active { color: var(--biru-otista); font-weight: 600; border-bottom-color: var(--biru-otista); }
        .app-header .dropdown-menu .dropdown-item.active { background-color: var(--biru-otista); color: var(--putih); }
        .page-header { background-color: var(--putih); padding: 1.5rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05); margin-bottom: 2rem; }
        .page-header h1 { font-weight: 700; font-size: 1.75rem; }
        .card { border: 1px solid var(--border-color); border-radius: 0.75rem; box-shadow: none; }
        .card-header { background-color: var(--putih) !important; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color); }
        .table-custom thead th { background-color: var(--biru-otista); color: var(--putih); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: none; }
        .table-custom td { vertical-align: middle; }
        .item-utama { font-weight: 500; }
        .item-sekunder { font-size: 0.85em; color: var(--teks-sekunder); }
        .action-buttons { display: flex; gap: 0.5rem; justify-content: center; }
        .badge-role-admin { background-color: #fee2e2; color: #b91c1c; }
        .badge-role-guru { background-color: #dcfce7; color: #166534; }
        .badge-role-siswa { background-color: #dbeafe; color: #1e40af; }
        .badge-role-orangtua { background-color: #fffbeb; color: #b45309; }
        .modal-header { background-color: var(--biru-otista); color: var(--putih); }
        .modal-header .btn-close { filter: invert(1) brightness(2); }
        .btn-primary { background-color: var(--biru-otista); border-color: var(--biru-otista); }
        .filter-nav .nav-link { color: var(--teks-sekunder); padding: 0.5rem 1rem; border-radius: 0.5rem; }
        .filter-nav .nav-link.active { color: var(--putih); background-color: var(--biru-otista); }
        /* Style untuk pesan error validasi */
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { display: block; }
    </style>
</head>

<body>
    {{-- ... (Header dan Navigasi Anda tidak berubah) ... --}}
    <header class="app-header sticky-top">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/bg.png') }}" alt="Logo" width="32" class="me-2"> LMS Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Beranda</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kelola Data</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.hal_matapelajaran') }}">Mata Pelajaran</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.hal_materi') }}">Materi</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.hal_kelas') }}">Kelas</a></li>
                            <li><a class="dropdown-item active" href="{{ route('admin.users.index') }}">Pengguna</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pengaturan</a></li>
                </ul>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-end me-3">
                            <div class="fw-bold">{{ Auth::user()->nama ?? 'Admin User' }}</div>
                            <small class="text-muted">Administrator</small>
                        </div>
                        <i class="bi bi-person-circle fs-2 text-secondary"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Kelola Pengguna</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Kelola Data</li>
                            <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Pengguna
                </button>
            </div>
        </div>
    </div>

    <main class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        {{-- Pesan error umum tidak lagi diperlukan karena kita akan menampilkannya per field --}}

        <div class="card">
            {{-- ... (Card Header dan Tabel tidak berubah) ... --}}
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                <ul class="nav nav-pills filter-nav">
                    <li class="nav-item"><a class="nav-link {{ !request('role') ? 'active' : '' }}" href="{{ route('admin.users.index', ['search' => request('search')]) }}">Semua</a></li>
                    <li class="nav-item"><a class="nav-link {{ request('role') == 'admin' ? 'active' : '' }}" href="{{ route('admin.users.index', ['role' => 'admin', 'search' => request('search')]) }}">Admin</a></li>
                    <li class="nav-item"><a class="nav-link {{ request('role') == 'guru' ? 'active' : '' }}" href="{{ route('admin.users.index', ['role' => 'guru', 'search' => request('search')]) }}">Guru</a></li>
                    <li class="nav-item"><a class="nav-link {{ request('role') == 'siswa' ? 'active' : '' }}" href="{{ route('admin.users.index', ['role' => 'siswa', 'search' => request('search')]) }}">Siswa</a></li>
                    <li class="nav-item"><a class="nav-link {{ request('role') == 'orangtua' ? 'active' : '' }}" href="{{ route('admin.users.index', ['role' => 'orangtua', 'search' => request('search')]) }}">Orang Tua</a></li>
                </ul>
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex">
                    <input type="hidden" name="role" value="{{ request('role') }}">
                    <input class="form-control me-2" type="search" placeholder="Cari pengguna..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 5%;">#</th>
                                <th style="width: 25%;">Pengguna</th>
                                <th style="width: 15%;">Nomor Induk</th>
                                <th style="width: 15%;">Kelas/Anak Terkait</th>
                                <th class="text-center" style="width: 10%;">Role</th>
                                <th class="text-center pe-4" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $users->firstItem() + $key }}</td>
                                    <td>
                                        <div class="item-utama">{{ $user->nama }}</div>
                                        <div class="item-sekunder">{{ $user->email }}</div>
                                    </td>
                                    <td>{{ $user->nomor_induk ?? '-' }}</td>
                                    <td>
                                        @if ($user->role == 'siswa')
                                            {{ $user->kelas->nama_kelas ?? 'N/A' }}
                                        @elseif ($user->role == 'orangtua')
                                            {{ $user->anak->first()->nama ?? 'N/A' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($user->role == 'admin') <span class="badge rounded-pill badge-role-admin">Admin</span>
                                        @elseif($user->role == 'guru') <span class="badge rounded-pill badge-role-guru">Guru</span>
                                        @elseif($user->role == 'siswa') <span class="badge rounded-pill badge-role-siswa">Siswa</span>
                                        @elseif($user->role == 'orangtua') <span class="badge rounded-pill badge-role-orangtua">Orang Tua</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-sm btn-warning" onclick="editUser({{ $user->toJson() }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5"><p>Tidak ada data pengguna ditemukan.</p></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-end">{{ $users->appends(request()->query())->links() }}</div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Formulir Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="userForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            {{-- EMAIL --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- USERNAME --}}
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            {{-- ROLE --}}
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="" disabled selected>Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="orangtua" {{ old('role') == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- KELAS --}}
                            <div class="col-md-6 mb-3" id="kelasWrapper" style="display: none;">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select class="form-select @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- ANAK --}}
                            <div class="col-md-6 mb-3" id="anakWrapper" style="display: none;">
                                <label for="anak_id" class="form-label">Anak yang Dipantau</label>
                                <select class="form-select @error('anak_id') is-invalid @enderror" id="anak_id" name="anak_id">
                                    <option value="">Pilih Anak</option>
                                    @foreach($siswaTanpaOrtu as $siswa)
                                        <option value="{{ $siswa->id }}" {{ old('anak_id') == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }} ({{ $siswa->kelas->nama_kelas ?? 'N/A' }})</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hanya siswa yang belum punya orang tua.</small>
                                @error('anak_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- NOMOR INDUK --}}
                        <div class="mb-3">
                            <label for="nomor_induk" class="form-label">Nomor Induk (NIP/NIS)</label>
                            <input type="text" class="form-control @error('nomor_induk') is-invalid @enderror" id="nomor_induk" name="nomor_induk" value="{{ old('nomor_induk') }}">
                            @error('nomor_induk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            {{-- PASSWORD --}}
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                <small class="text-muted" id="passwordHelp" style="display: none;">Kosongkan jika tidak ingin mengubah password.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- KONFIRMASI PASSWORD --}}
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
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
        const userModal = new bootstrap.Modal(document.getElementById('userModal'));
        const userForm = document.getElementById('userForm');
        const modalLabel = document.getElementById('userModalLabel');
        const formMethod = document.getElementById('formMethod');
        const passwordInput = document.getElementById('password');
        const passwordHelp = document.getElementById('passwordHelp');
        const roleSelect = document.getElementById('role');
        const kelasWrapper = document.getElementById('kelasWrapper');
        const kelasSelect = document.getElementById('kelas_id');
        const anakWrapper = document.getElementById('anakWrapper');
        const anakSelect = document.getElementById('anak_id');

        function toggleRelatedDropdowns(selectedRole) {
            kelasWrapper.style.display = 'none';
            kelasSelect.required = false;
            anakWrapper.style.display = 'none';
            anakSelect.required = false;

            if (selectedRole === 'siswa') {
                kelasWrapper.style.display = 'block';
                kelasSelect.required = true;
            } else if (selectedRole === 'orangtua') {
                anakWrapper.style.display = 'block';
                anakSelect.required = true;
            }
        }

        roleSelect.addEventListener('change', function () {
            toggleRelatedDropdowns(this.value);
        });

        function clearValidationErrors() {
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        }

        function resetForm() {
            clearValidationErrors();
            userForm.reset();
            userForm.action = "{{ route('admin.users.store') }}";
            formMethod.value = 'POST';
            modalLabel.textContent = 'Tambah Pengguna';
            passwordHelp.style.display = 'none';
            passwordInput.required = true;
            toggleRelatedDropdowns('');
        }

        function editUser(user) {
            clearValidationErrors();
            userForm.reset();
            userForm.action = `/admin/users/${user.id}`;
            formMethod.value = 'PUT';
            modalLabel.textContent = 'Edit Pengguna';

            document.getElementById('nama').value = user.nama;
            document.getElementById('email').value = user.email;
            document.getElementById('username').value = user.username;
            document.getElementById('role').value = user.role;
            document.getElementById('nomor_induk').value = user.nomor_induk;

            toggleRelatedDropdowns(user.role);

            if (user.role === 'siswa') {
                kelasSelect.value = user.kelas_id;
            } else if (user.role === 'orangtua' && user.anak && user.anak.length > 0) {
                // Tambahkan opsi anak saat ini jika tidak ada di daftar
                const anakId = user.anak[0].id;
                if (!anakSelect.querySelector(`option[value="${anakId}"]`)) {
                    const option = new Option(`${user.anak[0].nama} (Anak saat ini)`, anakId, true, true);
                    anakSelect.add(option, anakSelect.options[1]);
                }
                anakSelect.value = anakId;
            }

            passwordInput.required = false;
            passwordHelp.style.display = 'block';
            userModal.show();
        }

        @if ($errors->any())
            userModal.show();
            toggleRelatedDropdowns("{{ old('role') }}");
        @endif
    </script>
</body>
</html>
