<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerjakan Kuis: {{ $kuis->judul_kuis }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.comcom/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-blue: #0A2B7A;
            --light-blue: #e7f1ff;
            --border-color: #dee2e6;
            --success-green: #198754;
            --gray-bg: #f8f9fa;
        }

        body {
            background-color: #f4f7fc;
            font-family: 'Inter', sans-serif;
        }

        .quiz-main-content {
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px_12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .quiz-sticky-header {
            position: sticky;
            top: 0;
            z-index: 1020;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            margin: -1.5rem -1.5rem 0 -1.5rem;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }

        .question-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            /* Memberi ruang untuk anchor scrolling dari navigasi */
            padding-top: 70px;
            margin-top: -70px;
            scroll-margin-top: 80px;
            /* Jarak tambahan saat scroll ke anchor */
        }

        .option-label {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s, box-shadow 0.2s;
        }

        .option-label:hover {
            background-color: var(--light-blue);
            border-color: var(--primary-blue);
        }

        .form-check-input {
            display: none;
        }

        .form-check-input:checked+.option-label {
            background-color: var(--light-blue);
            border-color: var(--primary-blue);
            font-weight: 600;
            color: var(--primary-blue);
            box-shadow: 0 0 0 2px var(--light-blue);
        }

        .form-check-input:checked+.option-label::before {
            content: '\F26E';
            /* Bootstrap Icon: check-circle-fill */
            font-family: 'bootstrap-icons';
            margin-right: 10px;
            color: var(--primary-blue);
        }

        .question-nav-container {
            position: sticky;
            top: 1rem;
        }

        .question-nav {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
            gap: 0.5rem;
        }

        .nav-item-quiz {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            text-decoration: none;
            color: #495057;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item-quiz:hover {
            background-color: var(--light-blue);
            border-color: var(--primary-blue);
        }

        .nav-item-quiz.answered {
            background-color: var(--success-green);
            color: white;
            border-color: var(--success-green);
        }

        /* {{-- Tombol navigasi mobile --}} */
        .mobile-nav-fab {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1030;
        }
    </style>
</head>

<body>

    <div class="container py-4">
        <form action="{{ route('siswa.kuis.simpan', ['kuis' => $kuis->id]) }}" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin mengumpulkan jawaban? Jawaban tidak dapat diubah setelahnya.')">
            @csrf
            <input type="hidden" name="tugas_id" value="{{ $tugas->id }}">

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="quiz-main-content p-4">
                        <div class="quiz-sticky-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">{{ $kuis->judul_kuis }}</h4>
                                    <small
                                        class="text-muted">{{ $tugas->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}</small>
                                </div>
                                <div class="text-end">
                                    <h5 id="countdown-timer" class="mb-0 text-danger fw-bold">--:--:--</h5>
                                    <small class="text-muted">Sisa Waktu</small>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 10px;" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100">
                                <div id="progress-bar" class="progress-bar bg-success"></div>
                            </div>
                        </div>

                        <div class="alert alert-warning d-flex align-items-center mt-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                            <div>
                                Jangan sampai terlewat! Batas waktumu adalah
                                <strong>{{ $tugas->batas_waktu->isoFormat('dddd, D MMMM YYYY') }}</strong>, tepat pukul
                                <strong>{{ $tugas->batas_waktu->isoFormat('HH:mm') }}</strong>.
                            </div>
                        </div>

                        <hr class="my-4">

                        @foreach($kuis->soal as $index => $soal)
                            <div class="question-card" id="soal-{{ $soal->id }}">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Soal {{ $index + 1 }}</h5>
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill"
                                        id="status-badge-{{ $soal->id }}">Belum Dijawab</span>
                                </div>

                                <div class="p-4">
                                    <div class="fs-5 mb-4">{!! $soal->pertanyaan !!}</div>
                                    <div class="options-group">
                                        @foreach($soal->opsiJawaban as $opsi)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="answers[{{ $soal->id }}]"
                                                    id="opsi-{{ $opsi->id }}" value="{{ $opsi->id }}"
                                                    data-soal-id="{{ $soal->id }}" data-soal-index="{{ $index + 1 }}" required>
                                                <label class="option-label"
                                                    for="opsi-{{ $opsi->id }}">{!! $opsi->opsi_jawaban !!}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="card-footer bg-white d-flex justify-content-between">
                                    <a href="#soal-{{ $kuis->soal[$index - 1]->id ?? $soal->id }}"
                                        class="btn btn-outline-secondary {{ $index == 0 ? 'disabled' : '' }}">
                                        <i class="bi bi-arrow-left"></i> Sebelumnya
                                    </a>
                                    <a href="#soal-{{ $kuis->soal[$index + 1]->id ?? $soal->id }}"
                                        class="btn btn-primary {{ $loop->last ? 'disabled' : '' }}">
                                        Berikutnya <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4 d-none d-lg-block">
                    <div class="question-nav-container">
                        <div class="card">
                            <div class="card-header fw-bold">
                                <i class="bi bi-compass-fill me-2"></i> Navigasi Soal
                            </div>
                            <div class="card-body">
                                <div class="question-nav" id="desktop-question-nav">
                                    @foreach($kuis->soal as $index => $soal)
                                        <a href="#soal-{{ $soal->id }}" class="nav-item-quiz"
                                            id="nav-item-{{ $index + 1 }}">{{ $index + 1 }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle-fill me-2"></i> Kumpulkan Jawaban
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="d-lg-none">
        <button class="btn btn-primary btn-lg rounded-circle shadow-lg mobile-nav-fab" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-controls="offcanvasNav">
            <i class="bi bi-list-ul"></i>
        </button>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavLabel"><i class="bi bi-compass-fill me-2"></i> Navigasi Soal
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p class="text-muted small">Klik nomor untuk melompat ke soal. Hijau menandakan sudah dijawab.</p>
            <div class="question-nav" id="mobile-question-nav">
                @foreach($kuis->soal as $index => $soal)
                    <a href="#soal-{{ $soal->id }}" class="nav-item-quiz" id="mobile-nav-item-{{ $index + 1 }}"
                        data-bs-dismiss="offcanvas">{{ $index + 1 }}</a>
                @endforeach
            </div>
            <hr>
            <div class="d-grid mt-3">
                <button type="submit" form="quiz-form" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle-fill me-2"></i> Kumpulkan Jawaban
                </button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Variabel Dinamis dari Blade ---
            const deadlineString = "{{ $tugas->batas_waktu->toIso8601String() }}";
            const totalQuestions = {{ $kuis->soal->count() }}; // {{-- Jumlah soal dinamis --}}

            // --- Elemen DOM ---
            const countdownElement = document.getElementById('countdown-timer');
            const progressBar = document.getElementById('progress-bar');
            const radioButtons = document.querySelectorAll('.form-check-input');
            const answeredQuestions = new Set();

            // --- FUNGSI PENGHITUNG MUNDUR ---
            const deadline = new Date(deadlineString).getTime();
            if (!isNaN(deadline)) {
                const timerInterval = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = deadline - now;
                    if (distance < 0) {
                        clearInterval(timerInterval);
                        countdownElement.innerHTML = "WAKTU HABIS";
                        // Auto-submit form atau disable
                        document.querySelector('form').submit();
                        return;
                    }
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    countdownElement.innerHTML = ('0' + hours).slice(-2) + ":" + ('0' + minutes).slice(-2) + ":" + ('0' + seconds).slice(-2);
                }, 1000);
            } else {
                countdownElement.innerHTML = "Error Waktu";
            }

            // --- FUNGSI UPDATE UI SAAT JAWABAN DIPILIH ---
            function updateUIAfterAnswer(soalIndex, soalId) {
                // Update Navigasi
                document.getElementById(`nav-item-${soalIndex}`).classList.add('answered');
                document.getElementById(`mobile-nav-item-${soalIndex}`).classList.add('answered');

                // Update Status Badge
                const statusBadge = document.getElementById(`status-badge-${soalId}`);
                statusBadge.textContent = 'Sudah Dijawab';
                statusBadge.classList.remove('bg-secondary-subtle', 'text-secondary-emphasis');
                statusBadge.classList.add('bg-success-subtle', 'text-success-emphasis');

                // Update Progress Bar
                answeredQuestions.add(soalIndex);
                const progressPercentage = (answeredQuestions.size / totalQuestions) * 100;
                progressBar.style.width = progressPercentage + '%';
                progressBar.setAttribute('aria-valuenow', progressPercentage);
            }

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function () {
                    const soalIndex = this.dataset.soalIndex;
                    const soalId = this.dataset.soalId;
                    updateUIAfterAnswer(soalIndex, soalId);
                });
            });

            // --- FUNGSI SMOOTH SCROLL ---
            document.querySelectorAll('a[href^="#soal-"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // SweetAlert
            @if(session('sweet_success'))
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('sweet_success') }}", timer: 2500, showConfirmButton: false });
            @endif
            @if(session('sweet_error'))
                Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('sweet_error') }}", confirmButtonColor: '#0A2B7A' });
            @endif
            @if(session('sweet_info'))
                Swal.fire({ icon: 'info', title: 'Informasi', text: "{{ session('sweet_info') }}", confirmButtonColor: '#0A2B7A' });
            @endif
        });
    </script>
</body>

</html>