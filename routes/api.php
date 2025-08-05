<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- CONTROLLER UMUM & API ---
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController as ControllersUserController;

// --- CONTROLLER ADMIN ---
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MateriController as AdminMateriController;
use App\Http\Controllers\AdminController;

// --- CONTROLLER GURU ---
use App\Http\Controllers\Guru\AbsensiController;
use App\Http\Controllers\Guru\BuatKuisController;
use App\Http\Controllers\Guru\ChatOrtuController;
use App\Http\Controllers\Guru\KuisController;
use App\Http\Controllers\Guru\MataPelajaranController;
use App\Http\Controllers\Guru\MateriController as GuruMateriController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\TugasController;
use App\Http\Controllers\GuruController;

// --- CONTROLLER SISWA ---
use App\Http\Controllers\Siswa\SiswaKuisController;
use App\Http\Controllers\SiswaController;

// --- CONTROLLER ORANG TUA ---
use App\Http\Controllers\OrangTua\ChatController;
use App\Http\Controllers\OrangTua\OrangTuaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute API untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "api".
|
*/

// --- RUTE PUBLIK ---
// Rute ini tidak memerlukan token autentikasi.
Route::post('/login', [AuthController::class, 'login']);

// --- RUTE TERLINDUNGI ---
// Semua rute di dalam grup ini memerlukan token 'Bearer' yang valid.
Route::middleware('auth:sanctum')->group(function () {
    
    // Rute untuk mendapatkan data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rute untuk logout (menghapus token saat ini)
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- RUTE KHUSUS ADMIN ---
    Route::middleware('role:admin')->prefix('admin')->name('api.admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/halaman_pengguna', [AdminController::class, 'hal_pengguna'])->name('hal_pengguna');
        Route::get('/halaman_kelas', [AdminController::class, 'hal_kelas'])->name('hal_kelas');
        Route::get('/halaman_materi', [AdminController::class, 'hal_materi'])->name('hal_materi');
        Route::get('/halaman_matapelajaran', [AdminController::class, 'hal_matapelajaran'])->name('hal_matapelajaran');
        Route::resource('users', ControllersUserController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('mata-pelajaran', MataPelajaranController::class);
        Route::resource('materis', AdminMateriController::class);
    });

    // --- RUTE KHUSUS GURU ---
    Route::middleware('role:guru')->prefix('guru')->name('api.guru.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
        Route::get('/halaman_matapelajaran', [GuruController::class, 'hal_matapelajaran'])->name('hal_matapelajaran');
        Route::get('/halaman_buat_kuis', [GuruController::class, 'hal_buat_kuis'])->name('hal_buat_kuis');
        Route::get('/halaman_materi', [GuruController::class, 'hal_materi'])->name('hal_materi');
        Route::get('/halaman_tugas', [GuruController::class, 'hal_tugas'])->name('hal_tugas');
        Route::get('/halaman_absensi', [GuruController::class, 'hal_absensi'])->name('hal_absensi');
        Route::get('/halaman_nilai', [GuruController::class, 'hal_nilai'])->name('hal_nilai');
        Route::get('/get-materi-by-mapel', [TugasController::class, 'getMateriByMapel'])->name('tugas.getMateriByMapel');
        Route::resource('mata-pelajaran', MataPelajaranController::class);
        Route::resource('materi', GuruMateriController::class);
        Route::resource('tugas', TugasController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::resource('nilai', NilaiController::class);
        Route::resource('buatkuis', BuatKuisController::class);
        Route::get('/konsultasi', [ChatOrtuController::class, 'index'])->name('chat.index');
        Route::get('/konsultasi/{orangtua}', [ChatOrtuController::class, 'show'])->name('chat.show');
        Route::post('/konsultasi', [ChatOrtuController::class, 'store'])->name('chat.store');
        Route::post('/konsultasi/baca-semua', [ChatOrtuController::class, 'markAllRead'])->name('chat.markAllRead');
    });

    // --- RUTE KHUSUS SISWA ---
    Route::middleware('role:siswa')->prefix('siswa')->name('api.siswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');
        Route::get('/kuis/{kuis}/hasil', [KuisController::class, 'lihatHasil'])->name('kuis.hasil');
        Route::get('/tugas/{tugas}/hasil', [SiswaController::class, 'hasilTugas'])->name('tugas.hasil');
        Route::get('/presensi', [SiswaController::class, 'indexPresensi'])->name('presensi.index');
        Route::get('/tugas/{tugas}', [SiswaController::class, 'showTugas'])->name('tugas.show');
        Route::get('/tugas/{tugas}/kerjakan', [SiswaController::class, 'kerjakanTugas'])->name('tugas.kerjakan');
        Route::post('/tugas/{tugas}/kumpulkan', [SiswaController::class, 'kumpulkanTugas'])->name('tugas.kumpulkan');
        Route::get('/tugas', [SiswaController::class, 'indexTugas'])->name('tugas.index');
        Route::get('/materi', [SiswaController::class, 'indexMateri'])->name('materi.index');
        Route::get('/nilai', [SiswaController::class, 'indexNilai'])->name('nilai.index');
        Route::get('/kelas', [SiswaController::class, 'showKelas'])->name('kelas.index');
        Route::get('/materi/{materi}', [SiswaController::class, 'showMateri'])->name('materi.show');
        Route::get('/profil', [SiswaController::class, 'showProfil'])->name('profil.show');
        Route::put('/updateProfil', [SiswaController::class, 'updateProfil'])->name('profil.update');
        Route::get('/kuis/{kuis}/kerjakan', [SiswaKuisController::class, 'kerjakanKuis'])->name('kuis.kerjakan');
        Route::post('/kuis/{kuis}/simpan', [SiswaKuisController::class, 'simpanJawaban'])->name('kuis.simpan');
    });

    // --- RUTE KHUSUS ORANG TUA ---
    Route::middleware('role:orangtua')->prefix('orangtua')->name('api.orangtua.')->group(function () {
        Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('dashboard');
        Route::get('/anak', [OrangTuaController::class, 'lihatAnak'])->name('anak.show');
        Route::get('/konsultasi', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/konsultasi/{guru}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/konsultasi', [ChatController::class, 'store'])->name('chat.store');
    });
});
