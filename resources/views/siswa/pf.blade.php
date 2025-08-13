<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Nama Sekolah</title>
    {{-- Salin semua link CSS & font dari file dashboard siswa Anda --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- Salin semua style dari file dashboard siswa Anda --}}
    <style>
        :root { --primary-blue: #0A2B7A; --secondary-blue: #4a69bd; --light-gray: #f8f9fa; --border-color: #dee2e6; }
        body { height: 100vh; overflow-x: hidden; font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { width: 280px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border-right: 1px solid #dee2e6; }
        .main-content { overflow-y: auto; height: 100vh; width: calc(100% - 280px); }
        .sidebar .nav-link { color: #495057; font-weight: 500; border-radius: 0.375rem; margin-bottom: 0.25rem; }
        .sidebar .nav-link:hover { color: #0d6efd; background-color: #e9ecef; }
        .sidebar .nav-link.active { color: #fff; background-color: var(--primary-blue); }
        .header { background-color: #ffffff; border-bottom: 1px solid #dee2e6; }
        .card { border: none; border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        .card-header { background-color: transparent; border-bottom: 1px solid #dee2e6; font-weight: 600; }
        .form-label { font-weight: 500; }
        .profile-pic-wrapper { position: relative; width: 150px; height: 150px; }
        .profile-pic-wrapper .profile-pic { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .profile-pic-wrapper .upload-button { position: absolute; bottom: 5px; right: 5px; width: 40px; height: 40px; border-radius: 50%; background-color: var(--primary-blue); color: white; display: flex; align-items: center; justify-content: center; border: 2px solid white; cursor: pointer; }
        #fileUpload { display: none; }
    </style>
</head>

<body>
    <div class="container-fluid p-0 d-flex">

        @include('siswa.partials.sidebar') {{-- Asumsi Anda punya file sidebar terpisah --}}

        <div class="main-content flex-grow-1">
            <header class="p-3 mb-4 header sticky-top">
                <h5 class="mb-0 text-dark fw-bold">Profil Saya</h5>
            </header>

            <main class="p-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-person-fill me-2"></i>Informasi Akun
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('siswa.profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="profile-pic-wrapper mx-auto">
                                        <img id="profile-pic-preview" class="profile-pic" src="{{ $user->profile && $user->profile->foto_profil ? asset('storage/' . $user->profile->foto_profil) : 'https://via.placeholder.com/150' }}" alt="Foto Profil">
                                        <div class="upload-button" onclick="document.getElementById('fileUpload').click();">
                                            <i class="bi bi-camera-fill"></i>
                                        </div>
                                        <input type="file" id="fileUpload" name="foto_profil" onchange="previewImage(event)">
                                    </div>
                                    <h5 class="mt-3">{{ $user->nama }}</h5>
                                    <p class="text-muted">{{ $user->kelas->nama_kelas ?? 'Belum ada kelas' }}</p>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nama" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', optional($user->profile)->no_telepon) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($user->profile)->tanggal_lahir ? $user->profile->tanggal_lahir->format('Y-m-d') : '') }}">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', optional($user->profile)->alamat) }}</textarea>
                                        </div>
                                        <hr class="my-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password Baru (opsional)</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i>Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Script untuk notifikasi
        @if (session('sweet_success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('sweet_success') }}", showConfirmButton: false, timer: 2500 });
        @endif
        @if (session('sweet_error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('sweet_error') }}", confirmButtonColor: '#0A2B7A' });
        @endif

        // Script untuk preview gambar
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profile-pic-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>