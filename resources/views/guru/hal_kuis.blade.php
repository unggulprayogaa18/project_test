<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kuis - SMK Otista Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            --card-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            --biru-sekunder: #5e72ad;
        }

        body {
            background-color: var(--latar-utama);
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
        
        /* Card & Other Styles */
        .btn-primary {
            background-color: var(--biru-otista);
            border-color: var(--biru-otista);
        }
        
        .modal-header {
            background: linear-gradient(90deg, var(--biru-otista), var(--biru-sekunder));
            color: white;
        }
        
        .modal-header .btn-close {
            filter: invert(1) brightness(2);
        }
        
        .kuis-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .kuis-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        .kuis-card .card-body {
            flex-grow: 1;
        }
        
        .kuis-card .card-footer {
            background-color: transparent;
            border-top: 1px solid var(--border-color);
        }
        
        #addKuisModal .modal-dialog, .modal-xl {
             max-height: calc(100vh - 4rem);
        }
        #addKuisModal .modal-content, .modal-xl .modal-content {
            height: 100%; display: flex; flex-direction: column;
        }
        #addKuisModal .modal-body, .modal-xl .modal-body {
            overflow: hidden; display: flex; flex-direction: column;
        }
        #questions-container-wrapper, .questions-container-wrapper-edit {
            flex-grow: 1; overflow-y: auto; padding: 0.5rem; margin: -0.5rem;
        }
        
        .question-block {
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background-color: #fff;
            position: relative;
        }
        
        .question-block .btn-close {
            position: absolute; top: 1rem; right: 1rem;
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
                    <a class="nav-link active" href="{{ route('guru.buatkuis.index') }}">
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
                    <a class="nav-link position-relative" href="{{ route('guru.chat.index') }}">
                        <i class="bi bi-chat-left-dots-fill"></i>Konsultasi Ortu
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
                        <li class="breadcrumb-item active" aria-current="page">Kelola Kuis</li>
                    </ol>
                </nav>
            </header>

            <main>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-0">Manajemen Kuis</h2>
                        <p class="text-muted">Buat, edit, dan kelola kuis untuk siswa Anda.</p>
                    </div>
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addKuisModal">
                        <i class="bi bi-plus-circle-fill me-2"></i> Buat Kuis Baru
                    </button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button
                            type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    @forelse ($kuis as $item)
                        <div class="col">
                            <div class="card kuis-card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <span class="badge rounded-pill text-bg-primary bg-opacity-10 text-primary-emphasis fw-semibold">{{ $item->mataPelajaran->nama_mapel ?? 'Umum' }}</span>
                                    </div>
                                    <h5 class="card-title fw-bold">{{ $item->judul_kuis }}</h5>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 100) }}
                                    </p>
                                </div>
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-card-text"></i> Kelola Soal</a>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editKuisModal-{{ $item->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('guru.buatkuis.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus kuis ini?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center p-5 bg-white rounded-3">
                                <i class="bi bi-journal-x fs-1 text-muted"></i>
                                <h4 class="mt-3">Belum Ada Kuis</h4>
                                <p class="text-muted">Klik tombol "Buat Kuis Baru" untuk memulai.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="mt-4 d-flex justify-content-center">{{ $kuis->links() }}</div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="addKuisModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Kuis Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('guru.buatkuis.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-4 h-100">
                            <div class="col-lg-4">
                                <h6 class="fw-bold">Informasi Kuis</h6>
                                <p class="text-muted small">Masukkan detail dasar untuk kuis Anda.</p>
                                <hr>
                                <div class="mb-3"><label class="form-label">Judul Kuis</label><input type="text"
                                        class="form-control" name="judul_kuis" required></div>
                                <div class="mb-3"><label class="form-label">Deskripsi</label><textarea
                                        class="form-control" name="deskripsi" rows="3"></textarea></div>
                                <div class="mb-3"><label class="form-label">Mata Pelajaran</label><select
                                        class="form-select" name="mata_pelajaran_id" required>
                                        <option value="">Pilih...</option>@foreach ($mataPelajaranList as $mapel)<option
                                        value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>@endforeach
                                    </select></div>
                                <div class="mb-3">
                                    <label class="form-label">Guru Pembuat</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->nama }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-8 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Daftar Soal</h6>
                                    <button type="button" id="add-question-btn" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Soal
                                    </button>
                                </div>
                                <hr>
                                <div id="questions-container-wrapper">
                                    <div id="questions-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Kuis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($kuis as $item)
        <div class="modal fade" id="editKuisModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kuis: {{ $item->judul_kuis }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('guru.buatkuis.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row g-4 h-100">
                                <div class="col-lg-4">
                                    <h6 class="fw-bold">Informasi Kuis</h6>
                                    <p class="text-muted small">Ubah detail dasar untuk kuis Anda.</p>
                                    <hr>
                                    <div class="mb-3">
                                        <label class="form-label">Judul Kuis</label>
                                        <input type="text" class="form-control" name="judul_kuis" value="{{ old('judul_kuis', $item->judul_kuis) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mata Pelajaran</label>
                                        <select class="form-select" name="mata_pelajaran_id" required>
                                            @foreach ($mataPelajaranList as $mapel)
                                                <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id', $item->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                                                    {{ $mapel->nama_mapel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Guru Pembuat</label>
                                        <input type="text" class="form-control" value="{{ $item->guru->nama ?? 'N/A' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-8 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0">Daftar Soal</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-question-btn-edit" data-kuis-id="{{ $item->id }}">
                                            <i class="bi bi-plus-circle me-1"></i> Tambah Soal
                                        </button>
                                    </div>
                                    <hr>
                                    <div class="questions-container-wrapper-edit" id="questions-container-wrapper-edit-{{ $item->id }}">
                                        <div class="questions-container-edit" id="questions-container-edit-{{ $item->id }}">
                                            @foreach ($item->soal as $soalIndex => $soal)
                                                <div class="question-block" id="question-{{ $item->id }}-{{ $soal->id }}">
                                                    <input type="hidden" name="questions[{{ $soalIndex }}][id]" value="{{ $soal->id }}">
                                                    <button type="button" class="btn-close" onclick="removeExistingQuestion(this)"></button>
                                                    <h6 class="mb-3 text-muted">Soal Nomor <span class="question-number">{{ $soalIndex + 1 }}</span></h6>
                                                    <div class="mb-3">
                                                        <textarea class="form-control" name="questions[{{ $soalIndex }}][pertanyaan]" rows="2" placeholder="Tulis pertanyaan di sini..." required>{{ $soal->pertanyaan }}</textarea>
                                                    </div>
                                                    <div>
                                                        @foreach ($soal->opsiJawaban as $optionIndex => $opsi)
                                                            <div class="input-group mb-2">
                                                                <input type="hidden" name="questions[{{ $soalIndex }}][options][{{ $optionIndex }}][id]" value="{{ $opsi->id }}">
                                                                <div class="input-group-text">
                                                                    <input class="form-check-input mt-0" type="radio" value="{{ $opsi->id }}" name="questions[{{ $soalIndex }}][jawaban_benar]" {{ $opsi->is_benar ? 'checked' : '' }} required>
                                                                </div>
                                                                <input type="text" class="form-control" name="questions[{{ $soalIndex }}][options][{{ $optionIndex }}][text]" placeholder="Opsi {{ chr(65 + $optionIndex) }}" value="{{ $opsi->opsi_jawaban }}" required>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Perbarui Kuis</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

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

            // === FUNGSI UNTUK MODAL TAMBAH KUIS ===
            const addKuisModal = document.getElementById('addKuisModal');
            if (addKuisModal) {
                const questionsContainer = document.getElementById('questions-container');
                const addQuestionBtn = document.getElementById('add-question-btn');
                let questionIndex = 0;

                function addQuestion() {
                    const questionId = `new-${questionIndex}`;
                    const newQuestionBlock = document.createElement('div');
                    newQuestionBlock.classList.add('question-block');
                    newQuestionBlock.setAttribute('id', `question-${questionId}`);

                    const questionHtml = `
                        <button type="button" class="btn-close" onclick="removeQuestion('${questionId}')"></button>
                        <h6 class="mb-3 text-muted">Soal Nomor <span class="question-number">${questionsContainer.children.length + 1}</span></h6>
                        <div class="mb-3">
                            <textarea class="form-control" name="questions[${questionIndex}][pertanyaan]" rows="2" placeholder="Tulis pertanyaan di sini..." required></textarea>
                        </div>
                        <div>
                            ${[0, 1, 2, 3].map(optionIndex => `
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" type="radio" value="${optionIndex}" name="questions[${questionIndex}][jawaban_benar]" required>
                                    </div>
                                    <input type="text" class="form-control" name="questions[${questionIndex}][options][${optionIndex}]" placeholder="Opsi ${String.fromCharCode(65 + optionIndex)}" required>
                                </div>
                            `).join('')}
                        </div>`;
                    newQuestionBlock.innerHTML = questionHtml;
                    questionsContainer.appendChild(newQuestionBlock);
                    questionIndex++;
                    updateQuestionNumbers(questionsContainer);
                }

                addQuestionBtn.addEventListener('click', addQuestion);

                addKuisModal.addEventListener('show.bs.modal', function () {
                    questionsContainer.innerHTML = '';
                    questionIndex = 0;
                    addQuestion();
                });
            }

            // === FUNGSI UNTUK MODAL EDIT KUIS ===
            document.querySelectorAll('.add-question-btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const kuisId = this.getAttribute('data-kuis-id');
                    addQuestionToEditModal(kuisId);
                });
            });

            function addQuestionToEditModal(kuisId) {
                const container = document.getElementById(`questions-container-edit-${kuisId}`);
                const existingQuestionsCount = container.querySelectorAll('.question-block').length;
                const newQuestionIndex = Date.now();
                const newQuestionBlock = document.createElement('div');
                newQuestionBlock.classList.add('question-block');
                newQuestionBlock.id = `question-new-${newQuestionIndex}`;
                
                const newOptionIds = [`newopt-a-${newQuestionIndex}`, `newopt-b-${newQuestionIndex}`, `newopt-c-${newQuestionIndex}`, `newopt-d-${newQuestionIndex}`];
                const questionHtml = `
                    <input type="hidden" name="questions[${newQuestionIndex}][id]" value="">
                    <button type="button" class="btn-close" onclick="removeExistingQuestion(this)"></button>
                    <h6 class="mb-3 text-muted">Soal Nomor <span class="question-number">${existingQuestionsCount + 1}</span></h6>
                    <div class="mb-3">
                        <textarea class="form-control" name="questions[${newQuestionIndex}][pertanyaan]" rows="2" placeholder="Tulis pertanyaan baru di sini..." required></textarea>
                    </div>
                    <div>
                        ${[0, 1, 2, 3].map(optionIndex => `
                            <div class="input-group mb-2">
                                <input type="hidden" name="questions[${newQuestionIndex}][options][${optionIndex}][id]" value="${newOptionIds[optionIndex]}">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" value="${newOptionIds[optionIndex]}" name="questions[${newQuestionIndex}][jawaban_benar]" required>
                                </div>
                                <input type="text" class="form-control" name="questions[${newQuestionIndex}][options][${optionIndex}][text]" placeholder="Opsi ${String.fromCharCode(65 + optionIndex)}" required>
                            </div>
                        `).join('')}
                    </div>`;
                newQuestionBlock.innerHTML = questionHtml;
                container.appendChild(newQuestionBlock);
                updateQuestionNumbers(container);
            }

            // === FUNGSI GLOBAL YANG DIGUNAKAN KEDUA MODAL ===
            window.removeQuestion = function (questionId) {
                const elementToRemove = document.getElementById(`question-${questionId}`);
                const container = elementToRemove.parentElement;
                elementToRemove.remove();
                updateQuestionNumbers(container);
            }

            window.removeExistingQuestion = function (button) {
                const questionBlock = button.closest('.question-block');
                const container = questionBlock.parentElement;
                questionBlock.remove();
                updateQuestionNumbers(container);
            }

            window.updateQuestionNumbers = function (container) {
                const allQuestions = container.querySelectorAll('.question-block');
                allQuestions.forEach((question, index) => {
                    const numberSpan = question.querySelector('.question-number');
                    if (numberSpan) {
                        numberSpan.textContent = index + 1;
                    }
                });
            }

            // Jika ada error validasi di form edit, buka kembali modal yang error
            @if ($errors->any() && session('error_kuis_id'))
                const errorModalId = 'editKuisModal-{{ session('error_kuis_id') }}';
                const errorModal = new bootstrap.Modal(document.getElementById(errorModalId));
                errorModal.show();
            @endif
        });
    </script>
</body>

</html>