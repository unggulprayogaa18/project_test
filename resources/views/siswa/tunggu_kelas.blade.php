<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Penempatan Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="card shadow-sm p-4 mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <i class="bi bi-hourglass-split text-primary" style="font-size: 4rem;"></i>
                <h1 class="h3 fw-bold mt-3">Akun Anda Hampir Siap!</h1>
                <p class="text-muted">
                    Selamat datang, <strong>{{ $user->nama }}</strong>.
                    Saat ini Anda belum terdaftar di kelas manapun. Mohon tunggu administrator untuk menempatkan Anda di kelas yang sesuai.
                </p>
                <div class="mt-4">
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
