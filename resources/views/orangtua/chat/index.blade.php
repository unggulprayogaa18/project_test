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
        :root {
            --primary-color: #0d6efd; /* Bootstrap Blue */
            --secondary-color: #6c757d; /* Bootstrap Gray */
            --success-color: #198754; /* Bootstrap Green */
            --light-bg: #f8f9fa; /* Light background */
            --white-bg: #ffffff; /* White background */
            --border-color: #e0e0e0; /* Light border */
            --text-dark: #212529; /* Dark text */
            --text-muted: #6c757d; /* Muted text */
            --card-hover-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            --list-item-hover-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            min-height: 100vh; /* Agar body selalu setinggi viewport */
            display: flex;
            flex-direction: column; /* Untuk sticky footer/main content */
        }

        .navbar {
            background-color: var(--white-bg) !important;
            border-bottom: 1px solid var(--border-color);
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .navbar .btn-outline-secondary {
            border-color: var(--border-color);
            color: var(--secondary-color);
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }
        .navbar .btn-outline-secondary:hover {
            background-color: var(--secondary-color);
            color: var(--white-bg);
        }

        main {
            flex-grow: 1; /* Agar main content mengisi sisa ruang */
        }

        .card {
            border: none;
            border-radius: 1rem; /* Sudut lebih membulat */
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); /* Shadow lebih menonjol */
            overflow: hidden; /* Penting untuk border-radius */
        }

        .card-header {
            background-color: var(--white-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem 2rem; /* Padding lebih besar */
            display: flex;
            flex-direction: column;
            gap: 0.5rem; /* Jarak antar elemen di header */
        }

        .card-header h1 {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.75rem; /* Ukuran h1 */
            margin-bottom: 0;
        }

        .card-header p {
            color: var(--text-muted);
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        /* Search Input Styling */
        .input-group {
            margin-top: 1.5rem; /* Jarak dari deskripsi */
            margin-bottom: 1rem;
        }

        .input-group-text {
            background-color: var(--white-bg);
            border-right: none;
            border-color: var(--border-color);
            border-radius: 0.5rem 0 0 0.5rem; /* Membulatkan hanya di kiri */
            padding: 0.75rem 1rem;
            color: var(--secondary-color);
        }

        .form-control {
            border-left: none;
            border-color: var(--border-color);
            border-radius: 0 0.5rem 0.5rem 0; /* Membulatkan hanya di kanan */
            padding: 0.75rem 1rem;
            font-size: 1rem;
            box-shadow: none !important; /* Hapus shadow default focus */
        }
        .form-control:focus {
            border-color: var(--primary-color); /* Warna border saat focus */
        }


        .card-body {
            padding: 2rem; /* Padding lebih besar */
        }

        .list-group {
            --bs-list-group-border-color: transparent; /* Hapus border default list-group */
        }

        .list-group-item-action {
            background-color: var(--white-bg);
            border-radius: 0.75rem; /* Membulatkan setiap item */
            margin-bottom: 0.75rem; /* Jarak antar item */
            transition: all 0.25s ease-in-out;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); /* Shadow ringan untuk setiap item */
            padding: 1.25rem 1.5rem; /* Padding lebih besar di dalam item */
        }

        .list-group-item-action:hover {
            background-color: var(--white-bg); /* Pastikan warna tetap putih saat hover */
            transform: translateY(-5px); /* Efek angkat */
            box-shadow: var(--list-item-hover-shadow); /* Shadow lebih kuat saat hover */
            border-color: transparent; /* Tetap tanpa border */
        }

        .list-group-item-action .bi-person-circle {
            font-size: 3rem; /* Ikon profil lebih besar */
            margin-right: 1.25rem;
            color: var(--primary-color); /* Warna ikon profil */
        }
        .list-group-item-action .bi-chevron-right {
            font-size: 1.25rem;
            color: var(--secondary-color);
        }

        .list-group-item-action h6 {
            font-size: 1.1rem; /* Ukuran nama guru */
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.2rem; /* Jarak dengan "Guru" */
        }

        .list-group-item-action small {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Empty state styling */
        .no-guru-message { /* Gunakan kelas ini untuk pesan "Tidak ada guru" */
            padding: 3rem !important;
            background-color: var(--white-bg);
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            text-align: center; /* Pastikan teks di tengah */
            /* Defaultnya display: none; akan diatur oleh JS jika perlu */
        }
        .no-guru-message i {
            font-size: 4rem !important;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        /* Pagination styling */
        .pagination-container {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }
        .pagination .page-item .page-link {
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            border-color: var(--border-color);
            color: var(--primary-color);
            transition: all 0.2s ease;
        }
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--white-bg);
        }
        .pagination .page-item .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--white-bg);
        }
        .pagination .page-item.disabled .page-link {
            color: var(--text-muted);
            pointer-events: none;
            background-color: var(--light-bg);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .navbar {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .navbar .btn-outline-secondary {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
            }
            main.container {
                padding: 1.5rem 1rem; /* Padding lebih kecil di mobile */
            }
            .card-header {
                padding: 1.25rem 1.5rem;
            }
            .card-header h1 {
                font-size: 1.5rem;
            }
            .card-header p {
                font-size: 0.85rem;
            }
            .input-group-text, .form-control {
                padding: 0.6rem 0.8rem;
                font-size: 0.95rem;
            }
            .card-body {
                padding: 1.5rem;
            }
            .list-group-item-action {
                padding: 1rem 1.25rem;
            }
            .list-group-item-action .bi-person-circle {
                font-size: 2.5rem;
                margin-right: 1rem;
            }
            .list-group-item-action h6 {
                font-size: 1rem;
            }
            .list-group-item-action small {
                font-size: 0.8rem;
            }
            .no-guru-message {
                padding: 2rem !important;
            }
            .no-guru-message i {
                font-size: 3rem !important;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.1rem !important; /* Ukuran font brand di mobile */
            }
            .card-header h1 {
                font-size: 1.35rem;
            }
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('orangtua.dashboard') }}">Portal Orang Tua</a>
            <div class="ms-auto">
                <a href="{{ route('orangtua.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-md-5">
        <div class="card">
            <div class="card-header bg-white border-0">
                <h1 class="h4 fw-bold">Mulai Konsultasi</h1>
                <p class="text-muted">Pilih guru untuk memulai atau melanjutkan percakapan.</p>
                
                {{-- Fitur Pencarian Guru --}}
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari nama guru..." aria-label="Cari guru">
                </div>
            </div>
            <div class="card-body">
                <div class="list-group" id="guruListContainer">
                    {{-- Loop untuk menampilkan daftar guru --}}
                    @forelse ($guruList as $guru)
                        <a href="{{ route('orangtua.chat.show', $guru->id) }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center guru-item">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle me-3 text-primary"></i>
                                <div>
                                    <h6 class="mb-0 fw-semibold guru-nama">{{ $guru->nama }}</h6>
                                    <small class="text-muted">Guru</small>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </a>
                    @empty
                        {{-- Pesan ini akan disembunyikan/ditampilkan oleh JS jika ada pencarian --}}
                        <div class="no-guru-message" id="noGuruFoundMessage">
                            <i class="bi bi-person-x-fill"></i>
                            <p class="mt-3 text-muted">Tidak ada data guru yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Laravel Pagination Links --}}
                <div class="pagination-container">
                    {{ $guruList->links('pagination::bootstrap-5') }}
                </div>
                
            </div>
        </div>
    </main>

    {{-- JavaScript dari CDN Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script untuk Fitur Pencarian dan Pengelolaan Pesan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const guruListContainer = document.getElementById('guruListContainer');
            
            // Dapatkan semua item guru yang *saat ini* ada di halaman
            // Penting: querySelectorAll akan mengambil hanya item di halaman ini
            const guruItems = guruListContainer.querySelectorAll('.guru-item'); 

            let noGuruFoundMessageElement = document.getElementById('noGuruFoundMessage');

            // Fungsi untuk melakukan filter pada item yang TERLIHAT di halaman saat ini
            function filterGuruList() {
                const filter = searchInput.value.toLowerCase();
                let foundItemsOnCurrentPage = 0;

                guruItems.forEach(function(item) {
                    const namaGuru = item.querySelector('.guru-nama').textContent.toLowerCase();
                    if (namaGuru.includes(filter)) {
                        item.style.display = 'flex'; // Tampilkan
                        foundItemsOnCurrentPage++;
                    } else {
                        item.style.display = 'none'; // Sembunyikan
                    }
                });

                // Mengelola visibilitas pesan "Tidak ada data guru"
                // Ini akan muncul jika tidak ada hasil pencarian di halaman saat ini
                if (noGuruFoundMessageElement) { 
                    if (foundItemsOnCurrentPage === 0) {
                        noGuruFoundMessageElement.style.display = 'block';
                    } else {
                        noGuruFoundMessageElement.style.display = 'none';
                    }
                } else { // Jika elemen pesan ini TIDAK ada (karena ada guru di awal)
                    // Kita perlu membuat pesan jika tidak ada guru yang cocok
                    // dan search input TIDAK kosong.
                    if (foundItemsOnCurrentPage === 0 && filter !== '') {
                        // Jika belum ada pesan, buat yang baru
                        if (!document.getElementById('noSearchResultsMessage')) {
                            const newNoResultsDiv = document.createElement('div');
                            newNoResultsDiv.id = 'noSearchResultsMessage';
                            newNoResultsDiv.className = 'no-guru-message'; // Gunakan kelas styling yang sama
                            newNoResultsDiv.innerHTML = `
                                <i class="bi bi-person-x-fill"></i>
                                <p class="mt-3 text-muted">Tidak ada guru yang cocok dengan pencarian Anda.</p>
                            `;
                            guruListContainer.appendChild(newNoResultsDiv);
                            noGuruFoundMessageElement = newNoResultsDiv; // Update referensi
                        }
                        noGuruFoundMessageElement.style.display = 'block';
                    } else if (document.getElementById('noSearchResultsMessage')) {
                        // Sembunyikan pesan jika sudah ada dan ada hasil
                        document.getElementById('noSearchResultsMessage').style.display = 'none';
                    }
                }
            }

            // Panggil fungsi filter saat halaman dimuat (untuk inisialisasi awal)
            filterGuruList();

            // Panggil fungsi filter setiap kali pengguna mengetik
            searchInput.addEventListener('keyup', filterGuruList);

            // Optional: Hapus pesan pencarian jika input dikosongkan
            searchInput.addEventListener('input', function() {
                if (this.value === '') {
                    filterGuruList(); // Re-run filter to show all on current page
                    if (document.getElementById('noSearchResultsMessage')) {
                        document.getElementById('noSearchResultsMessage').style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>