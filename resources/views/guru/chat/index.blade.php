<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Konsultasi - SMK Otista Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* =================================
            PALET WARNA & VARIABEL
        ==================================== */
        :root {
            --biru-otista: #0A2B7A;
            --putih: #ffffff;
            --latar-utama: #f8f9fa;
            --teks-utama: #212529; /* Adjusted for better contrast on white cards */
            --teks-sekunder: #6c757d;
            --border-color: #dee2e6;
            --hover-bg: #e9ecef;
        }

        /* =================================
            GAYA DASAR
        ==================================== */
        body {
            height: 100vh;
            overflow-x: hidden;
            background-color: var(--latar-utama);
            color: var(--teks-utama);
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
        }

        /* =================================
            NAVBAR ATAS
        ==================================== */
        .navbar {
            background-color: var(--putih);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand span {
            font-weight: 600;
            color: var(--teks-utama);
        }

        .profile-dropdown .dropdown-toggle,
        .navbar-nav .nav-link {
            color: var(--teks-sekunder);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .profile-dropdown .dropdown-toggle:hover {
            color: var(--biru-otista);
        }

        .navbar-nav .nav-link.active {
            color: var(--biru-otista);
            font-weight: 700;
        }

        .profile-dropdown .dropdown-menu {
            background-color: var(--putih);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-dropdown .dropdown-item {
            color: var(--teks-utama);
        }

        .profile-dropdown .dropdown-item:hover {
            background-color: var(--hover-bg);
            color: var(--biru-otista);
        }

        .profile-dropdown .dropdown-divider {
            border-color: var(--border-color);
        }

        .btn-notification {
            background: none;
            border: none;
            color: var(--teks-sekunder);
            transition: color 0.3s;
        }

        .btn-notification:hover {
            color: var(--biru-otista);
        }

        /* =================================
            OFFCANVAS (SIDEBAR MOBILE)
        ==================================== */
        .offcanvas {
            background-color: var(--putih);
        }

        .offcanvas-header {
            border-bottom: 1px solid var(--border-color);
        }

        .offcanvas-title {
            color: var(--biru-otista);
            font-weight: 600;
        }

        .offcanvas-body .nav-link {
            color: var(--teks-utama);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Active navigation in sidebar */
        .offcanvas-body .nav-link.active,
        .offcanvas-body .nav-link:hover {
            background-color: var(--biru-otista);
            color: var(--putih);
        }

        /* Background on hover */
        .offcanvas-body .nav-link:not(.active):hover {
            background-color: var(--hover-bg);
            color: var(--biru-otista);
        }

        /* =================================
            MAIN CONTENT
        ==================================== */
        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 2.5rem;
        }

        .breadcrumb a {
            color: var(--teks-sekunder);
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb a:hover {
            color: var(--biru-otista);
        }

        .breadcrumb-item.active {
            color: var(--teks-utama);
            font-weight: 500;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--teks-sekunder);
        }

        /* Specific styles for consultation list card */
        .consultation-card {
            background: var(--putih);
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Reusing style for cards */
        }
        .consultation-card .list-group-item-action:hover {
            transform: translateX(5px);
            transition: transform 0.2s ease-in-out;
            background-color: var(--hover-bg); /* Use theme variable */
        }
        .consultation-card .list-group-item {
            border-color: var(--border-color); /* Consistent border */
        }
        .consultation-card .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="50" class="me-3">
                <span class="fs-5 d-none d-sm-inline">SMKS Otto Iskandar Dinata Bandung</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.dashboard') }}"><i
                                    class="bi bi-house-door-fill me-2"></i>Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link">
                                <i class="bi bi-journal-bookmark-fill me-2"></i>Mata Pelajaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.tugas.index') }}"><i
                                    class="bi bi-card-checklist me-2"></i>Tugas Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.buatkuis.index') }}"><i
                                    class="bi bi-patch-check-fill me-2"></i> Kuis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('guru.nilai.index') }}"><i class="bi bi-collection-fill me-2"></i>Kelola
                                Nilai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.absensi.index') }}"><i
                                    class="bi bi-clipboard-check-fill me-2"></i>Absensi</a>
                        </li>
                        <li class="nav-item">
                            {{-- Set the 'active' class based on the current route --}}
                            <a class="nav-link position-relative {{ request()->routeIs('guru.chat.*') ? 'active' : '' }}" href="{{ route('guru.chat.index') }}">
                                <i class="bi bi-chat-left-dots-fill me-2"></i>
                                Konsultasi Ortu
                                @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                    <span id="notification-badge"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                        {{ $unreadMessagesCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center">
                {{-- NEW NOTIFICATION BUTTON --}}
                
                <div class="dropdown profile-dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{-- Display authenticated user's name --}}
                        <strong>{{ Auth::user()->nama ?? 'Guru Hebat' }}</strong>
                        <i class="bi bi-person-circle ms-2 fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-light text-small shadow dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Konsultasi Orang Tua</li>
            </ol>
        </nav>

        <div class="card consultation-card">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h1 class="h4 fw-bold">Daftar Konsultasi</h1>
                <p class="text-muted">Berikut adalah daftar percakapan Anda dengan orang tua siswa.</p>
            </div>
            <div class="card-body p-4">
                <div class="list-group">
                    @forelse ($conversations as $conversation)
                        @php
                            $guru = Auth::user();
                            $orangTua = ($conversation->participant_one_id == $guru->id)
                                ? $conversation->participantTwo
                                : $conversation->participantOne;
                            
                            // POINT PENTING 1: Mengambil pesan TERAKHIR, bukan pertama
                            $lastMessage = $conversation->messages->last();
                        @endphp
                        
                        @if($orangTua)
                            <a href="{{ route('guru.chat.show', $orangTua) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle fs-2 me-3 text-secondary"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $orangTua->nama }}</h6>
                                        
                                        {{-- POINT PENTING 2: Memeriksa apakah koleksi 'anak' ada isinya sebelum mengambil nama --}}
                                        @if($orangTua->anak->isNotEmpty())
                                            <small class="text-muted">Orang Tua dari: {{ $orangTua->anak->first()->nama ?? 'Siswa' }}</small>
                                        @endif

                                        @if($lastMessage)
                                            <p class="mb-0 text-muted text-truncate" style="max-width: 250px;">{{ $lastMessage->body }}</p>
                                        @endif
                                    </div>
                                </div>
                                @if($lastMessage)
                                    <small class="text-muted">{{ $lastMessage->created_at->diffForHumans() }}</small>
                                @endif
                            </a>
                        @endif
                    @empty
                        <div class="text-center p-5">
                            <i class="bi bi-chat-quote-fill fs-1 text-muted"></i>
                            <p class="mt-3 text-muted">Belum ada percakapan yang dimulai.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
