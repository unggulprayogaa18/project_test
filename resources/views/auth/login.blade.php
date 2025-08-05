<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS SMK Otista Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --kuning-pucat: #FDEEAA;
            --putih: #FFFFFF;
            --latar-utama: #f8f9fa;
            --teks-utama: #212529;
            --teks-sekunder: #6c757d;
            --border-color: #dee2e6;
        }

        .h-100 {
            height: 100vh !important;
        }

        body,
        html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background-color: var(--latar-utama);
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-branding {
            background: linear-gradient(45deg, var(--biru-otista), #0d3a9e);
            color: var(--putih);
            padding: 2rem;
        }

        .login-branding .logo-img {
            width: 120px;
            margin-bottom: 1.5rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            padding: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .login-branding h1 {
            font-weight: 700;
            font-size: 2.25rem;
        }

        .login-branding p {
            font-size: 1.1rem;
            max-width: 400px;
            text-align: center;
            opacity: 0.9;
        }

        .login-form-panel {
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form-container {
            max-width: 450px;
            width: 100%;
        }

        .login-form-container h2 {
            font-weight: 700;
            color: var(--teks-utama);
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.85rem 1.1rem;
            font-size: 1rem;
            border: 1px solid var(--border-color);
        }

        .form-control:focus {
            border-color: var(--biru-otista);
            box-shadow: 0 0 0 0.25rem rgba(10, 43, 122, 0.25);
        }

        .btn-primary {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
            font-weight: 600;
            padding: 0.85rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #082261;
            border-color: #082261;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(10, 43, 122, 0.3);
        }

        .input-group-text {
            background-color: var(--putih);
            border-left: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="container-fluid g-0 h-100">
            <div class="row g-0 h-100">
                <div
                    class="col-lg-6 d-none d-lg-flex flex-column justify-content-center align-items-center login-branding">
                    <img src="{{ asset('images/bg.png') }}" class="logo-img" alt="Logo Sekolah">
                    <h1>SMKS Otto Iskandar Dinata Bandung</h1>
                    <p class="mt-2">Learning Management System untuk mendukung proses belajar mengajar yang lebih
                        efektif.</p>
                </div>

                <div class="col-lg-6 login-form-panel">
                    <div class="login-form-container">
                        <div class="text-center mb-4 d-lg-none">
                            <img src="{{ asset('images/bg.png') }}" width="80px" alt="Logo Sekolah" class="mb-3">
                        </div>
                        <h2 class="text-center text-lg-start">Selamat Datang!</h2>
                        <p class="text-muted text-center text-lg-start mb-4">Silakan masuk untuk melanjutkan.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Username atau password yang Anda masukkan salah.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Masukkan password" required>
                                    <span class="input-group-text" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Masuk</button>
                            </div>
                        </form>

                        <div class="text-center mt-5">
                            <p class="text-muted">&copy; {{ date('Y') }} LMS SMK Otista Bandung</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }
    </script>
</body>

</html>