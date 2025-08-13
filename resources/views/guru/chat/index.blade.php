<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Konsultasi - SMK Otista Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --biru-otista: #0A2B7A;
            --putih: #ffffff;
            --latar-utama: #f4f7fc;
            --teks-utama: #343a40;
            --teks-sekunder: #6c757d;
            --border-color: #e9ecef;
            --hover-bg: #eef2ff;
            --sidebar-width: 260px;
        }

        body {
            background-color: var(--latar-utama);
            color: var(--teks-utama);
            font-family: 'Poppins', sans-serif;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background-color: var(--putih);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .sidebar-header span {
            font-weight: 600;
            color: var(--teks-utama);
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex-grow: 1;
        }

        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            color: var(--teks-sekunder);
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .sidebar-menu .nav-link i {
            margin-right: 1rem;
            font-size: 1.2rem;
            width: 25px;
            text-align: center;
        }
        
        .sidebar-menu .nav-link:hover {
            color: var(--biru-otista);
            background-color: var(--hover-bg);
        }
        
        .sidebar-menu .nav-link.active {
            color: var(--biru-otista);
            background-color: var(--hover-bg);
            border-left-color: var(--biru-otista);
            font-weight: 600;
        }
        
        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        
        .profile-dropdown .dropdown-toggle {
            color: var(--teks-sekunder);
            text-decoration: none;
        }
        
        /* Content & Topbar Styling */
        #content {
            flex-grow: 1;
            padding: 1.5rem 2.5rem;
            overflow-y: auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .sidebar-toggler {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--teks-sekunder);
            display: none;
        }
        
        /* Specific styles for consultation list card */
        .consultation-card {
            background: var(--putih);
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .consultation-card .list-group-item-action:hover {
            transform: translateX(5px);
            transition: transform 0.2s ease-in-out;
            background-color: var(--hover-bg);
        }
        .consultation-card .list-group-item {
            border-color: var(--border-color);
        }
        .consultation-card .list-group-item:last-child {
            border-bottom: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -var(--sidebar-width);
                position: absolute;
                top: 0;
                bottom: 0;
                z-index: 1045;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                padding: 1.5rem;
            }
            .sidebar-toggler {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/bg.png') }}" alt="Logo Sekolah" width="40" class="me-3">
                <span class="fs-5">Guru Panel</span>
            </div>
            <ul class="nav flex-column sidebar-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <i class="bi bi-house-door-fill"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('guru.mata-pelajaran.index') }}" class="nav-link">
                        <i class="bi bi-journal-bookmark-fill"></i>Mata Pelajaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.tugas.index') }}">
                        <i class="bi bi-card-checklist"></i>Tugas Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.buatkuis.index') }}">
                        <i class="bi bi-patch-check-fill"></i>Kuis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.nilai.index') }}">
                        <i class="bi bi-collection-fill"></i>Kelola Nilai
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.absensi.index') }}">
                        <i class="bi bi-clipboard-check-fill"></i>Absensi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative active" href="{{ route('guru.chat.index') }}">
                        <i class="bi bi-chat-left-dots-fill"></i>Konsultasi Ortu
                        @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span class="badge rounded-pill bg-danger ms-auto">{{ $unreadMessagesCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <div class="dropdown profile-dropdown">
                    <a href="#" class="d-flex w-100 align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2 fs-2"></i>
                        <div>
                            <strong class="d-block">{{ Auth::user()->nama ?? 'Guru Hebat' }}</strong>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow w-100">
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="content">
            <header class="topbar">
                 <button type="button" id="sidebarCollapse" class="sidebar-toggler">
                    <i class="bi bi-list"></i>
                </button>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Konsultasi Orang Tua</li>
                    </ol>
                </nav>
            </header>

            <main>
                <div class="card consultation-card">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h1 class="h4 fw-bold">Daftar Konsultasi</h1>
                        <p class="text-muted">Berikut adalah daftar percakapan Anda dengan orang tua siswa.</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="list-group list-group-flush">
                            @forelse ($conversations as $conversation)
                                @php
                                    $guru = Auth::user();
                                    $orangTua = ($conversation->participant_one_id == $guru->id)
                                        ? $conversation->participantTwo
                                        : $conversation->participantOne;
                                    
                                    $lastMessage = $conversation->messages->last();
                                @endphp
                                
                                @if($orangTua)
                                    <a href="{{ route('guru.chat.show', $orangTua) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle fs-2 me-3 text-secondary"></i>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $orangTua->nama }}</h6>
                                                
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Script untuk toggle sidebar di mode mobile
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function () {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
</body>

</html>