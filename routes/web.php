<?php

use App\Constants\Role;
use App\Http\Controllers\Guru\MataPelajaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Guru\AbsensiController;
use App\Http\Controllers\Guru\BuatKuisController;
use App\Http\Controllers\Guru\ChatOrtuController;
use App\Http\Controllers\Guru\KuisController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\TugasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrangTua\ChatController;
use App\Http\Controllers\OrangTua\OrangTuaController;
use App\Http\Controllers\Siswa\SiswaKuisController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController as ControllersUserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web".
|
*/
// --- RUTE UNTUK TAMU (GUEST) ---
// Hanya bisa diakses jika pengguna BELUM login.
// --- RUTE UNTUK TAMU (GUEST) ---
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role) {
            case Role::ADMIN:
                return redirect()->route('admin.dashboard');
            case Role::GURU:
                return redirect()->route('guru.dashboard');
            case Role::SISWA:
                return redirect()->route('siswa.dashboard');
            case Role::ORANG_TUA:
                return redirect()->route('orangtua.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login');
        }
    }
    return redirect()->route('login');
})->name('home');

// --- RUTE UNTUK TAMU (GUEST) ---
// Hanya bisa diakses jika pengguna BELUM login.
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


// --- RUTE UMUM UNTUK PENGGUNA TERAUTENTIKASI ---
Route::middleware('auth')->group(function () {
    // HANYA SATU RUTE LOGOUT GLOBAL YANG DIPERLUKAN
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/force-logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    });
});



// --- RUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::get('/halaman_pengguna', [AdminController::class, 'hal_pengguna'])->name('hal_pengguna');
    Route::get('/halaman_kelas', [AdminController::class, 'hal_kelas'])->name('hal_kelas');
    Route::get('/halaman_materi', [AdminController::class, 'hal_materi'])->name('hal_materi');
    Route::get('/halaman_matapelajaran', [AdminController::class, 'hal_matapelajaran'])->name('hal_matapelajaran');
    Route::resource('users', ControllersUserController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('mata-pelajaran', MataPelajaranController::class);
    Route::resource('materis', App\Http\Controllers\Admin\MateriController::class);
    Route::get('/laporan/pengguna', [AdminController::class, 'laporanPengguna'])->name('laporan.pengguna');

});


// --- RUTE KHUSUS GURU ---
// Hanya bisa diakses oleh pengguna dengan role 'guru'.
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    // Dashboard Guru
    Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');

    Route::get('/halaman_matapelajaran', [GuruController::class, 'hal_matapelajaran'])->name('hal_matapelajaran');
    Route::get('/halaman_buat_kuis', [GuruController::class, 'hal_buat_kuis'])->name('hal_buat_kuis');
    Route::get('/halaman_materi', [GuruController::class, 'hal_materi'])->name('hal_materi');
    Route::get('/halaman_tugas', [GuruController::class, 'hal_tugas'])->name('hal_tugas');
    Route::get('/halaman_absensi', [GuruController::class, 'hal_absensi'])->name('hal_absensi');
    Route::get('/halaman_nilai', [GuruController::class, 'hal_nilai'])->name('hal_nilai');
    Route::get('/get-materi-by-mapel', [TugasController::class, 'getMateriByMapel'])->name('tugas.getMateriByMapel');

    Route::resource('mata-pelajaran', MataPelajaranController::class);
    Route::resource('materi', App\Http\Controllers\Guru\MateriController::class);
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
// Hanya bisa diakses oleh pengguna dengan role 'siswa'.
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');
    // !! TAMBAHKAN ROUTE BARU INI UNTUK HASIL KUIS !!
    Route::get('/kuis/{kuis}/hasil', [KuisController::class, 'lihatHasil'])->name('kuis.hasil');
    Route::get('/tugas/{tugas}/hasil', [SiswaController::class, 'hasilTugas'])->name('tugas.hasil');
    Route::get('/presensi', [SiswaController::class, 'indexPresensi'])->name('presensi.index');
    Route::get('/tugas/{tugas}', [SiswaController::class, 'showTugas'])->name('tugas.show');
    // Route untuk menampilkan halaman pengerjaan tugas (sudah ada)
    Route::get('/tugas/{tugas}/kerjakan', [SiswaController::class, 'kerjakanTugas'])->name('tugas.kerjakan');

    // !! TAMBAHKAN ROUTE BARU INI UNTUK MENGUMPULKAN TUGAS !!
    Route::post('/tugas/{tugas}/kumpulkan', [SiswaController::class, 'kumpulkanTugas'])->name('tugas.kumpulkan');


    Route::get('/tugas', [SiswaController::class, 'indexTugas'])->name('tugas.index');
    Route::get('/materi', [SiswaController::class, 'indexMateri'])->name('materi.index');
    Route::get('/nilai', [SiswaController::class, 'indexNilai'])->name('nilai.index');
    Route::get('/kelas', [SiswaController::class, 'showKelas'])->name('kelas.index');
    Route::get('/materi/{materi}', [SiswaController::class, 'showMateri'])->name('materi.show');
    Route::get('/tugas/{tugas}/kerjakan', [SiswaController::class, 'kerjakanTugas'])->name('tugas.kerjakan');
    Route::get('/profil', [SiswaController::class, 'showProfil'])->name('profil.show');
    Route::put('/updateProfil', [SiswaController::class, 'updateProfil'])->name('profil.update');
    Route::get('/kuis/{kuis}/kerjakan', [SiswaKuisController::class, 'kerjakanKuis'])->name('kuis.kerjakan');
    Route::post('/kuis/{kuis}/simpan', [SiswaKuisController::class, 'simpanJawaban'])->name('kuis.simpan');
});



// --- RUTE BARU KHUSUS ORANG TUA ---
Route::middleware(['auth', 'role:orangtua'])->prefix('orangtua')->name('orangtua.')->group(function () {
    Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('dashboard');
    Route::get('/anak', [OrangTuaController::class, 'lihatAnak'])->name('anak.show');
    Route::get('/konsultasi', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/konsultasi/{guru}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/konsultasi', [ChatController::class, 'store'])->name('chat.store');
    Route::delete('/chat/conversations/{conversation}/clear', [ChatController::class, 'clear'])->name('chat.clear');
});
