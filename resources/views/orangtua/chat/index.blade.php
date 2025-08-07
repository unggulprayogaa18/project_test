<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Konsultasi - Portal Orang Tua</title>

    {{-- CSS dari CDN Bootstrap & Google Fonts --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* [ BARU ] Variabel Warna yang Didesain Ulang untuk Tampilan Modern */
        :root {
            --primary-color: #4A90E2;      /* Biru yang lebih lembut */
            --primary-light: #EAF2FB;     /* Latar belakang biru muda */
            --secondary-color: #50E3C2;   /* Aksen Mint Green (opsional) */
            --text-dark: #333;            /* Hitam yang tidak terlalu pekat */
            --text-muted: #888;           /* Abu-abu yang lebih jelas */
            --light-bg: #F7F9FC;          /* Latar belakang utama yang lebih bersih */
            --white-bg: #FFFFFF;
            --border-color: #EAEAEA;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            --item-hover-shadow: 0 8px 25px rgba(74, 144, 226, 0.2);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

        /* [ BARU ] Navbar dengan gaya lebih minimalis */
        .navbar {
            background-color: var(--white-bg);
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .navbar .btn-outline-secondary {
            border-color: var(--border-color);
            color: var(--text-muted);
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .navbar .btn-outline-secondary:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
            border-color: var(--primary-light);
        }

        /* [ BARU ] Kartu utama dengan gaya yang lebih menonjol */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-top: 1rem;
        }

        /* [ BARU ] Header kartu dengan gradien halus */
        .card-header {
            background: linear-gradient(135deg, var(--white-bg) 0%, var(--primary-light) 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 2rem 2.5rem;
        }

        .card-header h1 {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
        }

        /* [ BARU ] Input pencarian yang lebih stylish */
        .search-box {
            position: relative;
            margin-top: 1.5rem;
        }
        .search-box .form-control {
            border-radius: 0.75rem;
            padding-left: 3rem;
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
            border: 1px solid var(--border-color);
            box-shadow: none !important;
            transition: border-color 0.3s ease;
        }
        .search-box .form-control:focus {
            border-color: var(--primary-color);
        }
        .search-box .bi-search {
            position: absolute;
            top: 50%;
            left: 1.25rem;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none; /* Agar tidak bisa diklik */
        }

        .card-body {
            padding: 1.5rem 2.5rem 2.5rem;
        }

        /* [ BARU ] Item daftar guru dengan efek hover yang elegan */
        .list-group-item-action {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            padding: 1rem 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .list-group-item-action:hover {
            transform: translateY(-5px);
            box-shadow: var(--item-hover-shadow);
            border-color: var(--primary-color);
            background-color: var(--white-bg); /* Jaga agar background tetap putih */
        }
        
        /* [ BARU ] Avatar ikon guru yang lebih menarik */
        .guru-avatar {
            font-size: 1.75rem;
            width: 50px;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary-color);
            margin-right: 1rem;
        }

        .list-group-item-action h6 {
            font-weight: 600;
            color: var(--text-dark);
        }
        .list-group-item-action small {
            color: var(--text-muted);
        }
        .list-group-item-action .bi-chevron-right {
            color: var(--text-muted);
            transition: transform 0.3s ease;
        }
        .list-group-item-action:hover .bi-chevron-right {
            transform: translateX(5px);
            color: var(--primary-color);
        }

        /* [ BARU ] Styling untuk pesan 'empty state' yang lebih baik */
        #emptyStateMessage {
            display: none; /* Sembunyikan secara default, diatur oleh JS */
            text-align: center;
            padding: 3rem 1rem;
            border: 2px dashed var(--border-color);
            border-radius: 0.75rem;
            margin-top: 1rem;
        }
        #emptyStateMessage .bi {
            font-size: 3rem;
            color: var(--primary-color);
            opacity: 0.6;
        }
        #emptyStateMessage p {
            margin-top: 1rem;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        /* [ BARU ] Pagination yang disesuaikan dengan tema */
        .pagination-container {
            margin-top: 2rem;
        }
        .pagination .page-link {
            border: none;
            border-radius: 0.5rem !important; /* Override Bootstrap */
            margin: 0 0.25rem;
            color: var(--primary-color);
            background-color: var(--primary-light);
            font-weight: 500;
        }
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            color: var(--white-bg);
            box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3);
        }
        .pagination .page-item.disabled .page-link {
            background-color: #F0F0F0;
            color: #BBB;
        }
        .pagination .page-link:hover {
            background-color: var(--primary-color);
            color: var(--white-bg);
        }
        
        /* Penyesuaian Responsif */
        @media (max-width: 768px) {
            .card-header, .card-body { padding: 1.5rem; }
            .card-header h1 { font-size: 1.5rem; }
        }

    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-person-hearts me-2"></i>Portal Orang Tua
            </a>
          <a href="{{ route('orangtua.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
        </div>
    </nav>

    <main class="container py-4">
        <div class="card">
            <div class="card-header">
                <h1>Mulai Konsultasi</h1>
                <p class="text-muted">Pilih guru untuk memulai atau melanjutkan percakapan.</p>
                
                {{-- [BARU] Struktur input pencarian yang lebih baik --}}
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari nama guru...">
                </div>
            </div>

            <div class="card-body">
                <div class="list-group list-group-flush" id="guruListContainer">
                    {{-- Loop untuk menampilkan daftar guru dari backend --}}
                    @forelse ($guruList as $guru)
                        <a href="{{ route('orangtua.chat.show', $guru->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center guru-item">
                            <div class="d-flex align-items-center">
                                <div class="guru-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 guru-nama">{{ $guru->nama }}</h6>
                                    <small>Guru</small>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @empty
                        {{-- Data awal kosong. JS akan menangani ini. --}}
                    @endforelse
                </div>

                {{-- [BARU] Container untuk pesan 'empty state' yang dikontrol oleh JS --}}
                <div id="emptyStateMessage">
                    <i class="bi bi-person-x-fill"></i>
                    <p id="emptyStateText"></p>
                </div>
                
                {{-- Laravel Pagination Links --}}
                @if ($guruList->hasPages())
                <div class="pagination-container d-flex justify-content-center">
                    {{ $guruList->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </main>

    {{-- JavaScript dari CDN Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- [BARU] Script yang disederhanakan dan lebih efisien --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const guruItems = document.querySelectorAll('.guru-item');
            const emptyStateMessage = document.getElementById('emptyStateMessage');
            const emptyStateText = document.getElementById('emptyStateText');
            const paginationContainer = document.querySelector('.pagination-container');

            function updateListVisibility() {
                const filter = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;

                guruItems.forEach(item => {
                    const namaGuru = item.querySelector('.guru-nama').textContent.toLowerCase();
                    const isVisible = namaGuru.includes(filter);
                    item.style.display = isVisible ? 'flex' : 'none';
                    if (isVisible) {
                        visibleCount++;
                    }
                });

                // Sembunyikan/Tampilkan pagination berdasarkan hasil filter
                if (paginationContainer) {
                    paginationContainer.style.display = filter ? 'none' : 'flex';
                }

                // Logika untuk menampilkan pesan 'empty state'
                if (visibleCount === 0) {
                    if (guruItems.length === 0) {
                        // Kondisi jika dari awal memang tidak ada guru sama sekali
                        emptyStateText.textContent = 'Tidak ada data guru yang tersedia saat ini.';
                    } else {
                        // Kondisi jika tidak ada hasil dari pencarian
                        emptyStateText.textContent = 'Tidak ada guru yang cocok dengan pencarian Anda.';
                    }
                    emptyStateMessage.style.display = 'block';
                } else {
                    emptyStateMessage.style.display = 'none';
                }
            }

            // Panggil fungsi saat ada input di search box
            searchInput.addEventListener('keyup', updateListVisibility);
            
            // Panggil fungsi saat halaman dimuat untuk menangani kasus daftar kosong dari awal
            updateListVisibility(); 
        });
    </script>
</body>
</html>
```</body>
</html>