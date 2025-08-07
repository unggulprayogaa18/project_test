<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIKS Otto Iskandar Dinata</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --putih: #FFFFFF;
            --latar-utama: #f0f2f5; /* Warna latar lebih soft */
            --teks-utama: #212529;
            --teks-sekunder: #6c757d;
            --border-color: #dee2e6;
        }

        body,
        html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background-color: var(--latar-utama);
        }

        /* Wrapper utama untuk menengahkan konten */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* Kontainer untuk form login */
        .login-container {
            max-width: 450px;
            width: 100%;
        }

        /* Header yang berisi logo dan nama sistem */
        .login-header {
            display: flex;
            align-items: center;
            justify-content: center; /* Logo di tengah untuk estetika */
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .login-header .logo-img {
            width: 60px; /* Ukuran logo disesuaikan */
            height: 60px;
        }

        .login-header .app-name-container {
           margin-left: 1rem;
           text-align: left;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--biru-otista);
            margin-bottom: 0;
        }

        .login-header p {
            font-size: 1rem;
            color: var(--teks-sekunder);
            margin-bottom: 0;
        }

        /* Kartu Form Login */
        .login-card {
            background-color: var(--putih);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
        }

        .login-card-title {
            font-weight: 600;
            color: var(--teks-utama);
        }

        /* Ikon Belajar */
        .login-card-title .bi-mortarboard-fill {
            color: var(--biru-otista);
            vertical-align: middle;
            font-size: 1.5rem;
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
        }

        .input-group-text {
            background-color: var(--putih);
            border-left: 0;
            cursor: pointer;
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
        .form-control:not(:last-child) {
            border-right: 0;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">

            <div class="login-header">
                <img src="{{ asset('images/bg.png') }}" class="logo-img" alt="Logo Sekolah" style="border-radius: 30px;">
                <div class="app-name-container">
                    <h1>SIKS OTISTA</h1>
                    <p>SMK Otto Iskandar Dinata</p>
                </div>
            </div>

            <div class="login-card">
                <h2 class="text-center mb-2 login-card-title">
                    <i class="bi bi-mortarboard-fill"></i>
                    Login Akun
                </h2>
                <p class="text-muted text-center mb-4">Silakan masuk untuk melanjutkan.</p>

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
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted">&copy; {{ date('Y') }} LMS SMK Otista Bandung</p>
            </div>

        </div>
    </div>

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