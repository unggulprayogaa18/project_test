<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Absensi;
use App\Models\Conversation;
use App\Models\Kuis;
use App\Models\MataPelajaran;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    //
    public function admin()
    {
        return view('admin.dashboard');
    }

   public function guru()
    {
        $guru = Auth::user();
        
        // --- MENGAMBIL DATA UNTUK KARTU STATISTIK ---

        $mataPelajaranIds = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', $guru->id)
            ->pluck('mata_pelajaran_id')
            ->unique();

        $jumlahMataPelajaran = $mataPelajaranIds->count();
        $jumlahTugas = Tugas::whereIn('mata_pelajaran_id', $mataPelajaranIds)->count();
        $jumlahMateri = Materi::whereIn('mata_pelajaran_id', $mataPelajaranIds)->count();
        $jumlahKuis = Kuis::where('guru_id', $guru->id)->count();

        // --- MENGAMBIL DATA UNTUK AKTIVITAS TERBARU ---

        // Ambil 5 data terbaru dari masing-masing model
        $tugasTerbaru = Tugas::whereIn('mata_pelajaran_id', $mataPelajaranIds)->latest()->take(5)->get();
        $materiTerbaru = Materi::whereIn('mata_pelajaran_id', $mataPelajaranIds)->latest()->take(5)->get();
        $kuisTerbaru = Kuis::where('guru_id', $guru->id)->latest()->take(5)->get();

        // Format dan gabungkan semua aktivitas menjadi satu koleksi
        $semuaAktivitas = collect([])
            ->merge($tugasTerbaru->map(function($item) {
                return (object) [
                    'deskripsi' => "Tugas baru '{$item->judul}' telah dibuat.",
                    'icon' => 'bi-card-checklist',
                    'color' => 'text-success',
                    'created_at' => $item->created_at
                ];
            }))
            ->merge($materiTerbaru->map(function($item) {
                return (object) [
                    'deskripsi' => "Materi baru '{$item->judul}' telah diunggah.",
                    'icon' => 'bi-file-earmark-text-fill',
                    'color' => 'text-info',
                    'created_at' => $item->created_at
                ];
            }))
            ->merge($kuisTerbaru->map(function($item) {
                return (object) [
                    'deskripsi' => "Kuis baru '{$item->judul_kuis}' telah dibuat.",
                    'icon' => 'bi-patch-check-fill',
                    'color' => 'text-primary',
                    'created_at' => $item->created_at
                ];
            }));

        // Urutkan semua aktivitas berdasarkan tanggal pembuatan dan ambil 5 teratas
        $aktivitasTerbaru = $semuaAktivitas->sortByDesc('created_at')->take(5);


        // --- LOGIKA NOTIFIKASI PESAN (SUDAH ADA) ---
        
        $conversationIds = Conversation::where('participant_one_id', $guru->id)
            ->orWhere('participant_two_id', $guru->id)
            ->pluck('id');

        $unreadMessages = Message::whereIn('conversation_id', $conversationIds)
            ->where('user_id', '!=', $guru->id)
            ->whereNull('read_at')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
            
        $unreadMessagesCount = Message::whereIn('conversation_id', $conversationIds)
            ->where('user_id', '!=', $guru->id)
            ->whereNull('read_at')
            ->count();

        // Kirim semua data yang sudah dikumpulkan ke view
        return view('guru.dashboard', [
            'guru' => $guru,
            'jumlahMataPelajaran' => $jumlahMataPelajaran,
            'jumlahTugas' => $jumlahTugas,
            'jumlahMateri' => $jumlahMateri,
            'jumlahKuis' => $jumlahKuis,
            'aktivitasTerbaru' => $aktivitasTerbaru, // Data baru untuk aktivitas
            'unreadMessages' => $unreadMessages,
            'unreadMessagesCount' => $unreadMessagesCount
        ]);
    }
    
     public function siswa()
    {
        // 1. Dapatkan ID siswa yang sedang login
        $siswaId = Auth::id();

        // 2. Ambil data siswa LENGKAP dengan relasi kelas dan mata pelajaran
        // Ini menggantikan Auth::user() dan ->load() dengan satu query yang efisien
        $siswa = User::with('kelas.mataPelajarans')->find($siswaId);

        // --- PERBAIKAN UTAMA DI SINI ---
        // 3. Validasi bahwa pengguna adalah siswa dan terdaftar di sebuah kelas.
        // Jika tidak, tampilkan view khusus, JANGAN redirect ke login.
        if (!$siswa || !$siswa->kelas_id || !$siswa->kelas) {
            // Tampilkan halaman yang memberitahu siswa bahwa mereka perlu menunggu penempatan kelas.
            // Kita kirim user dari Auth::user() di sini karena $siswa bisa jadi null.
            return view('siswa.tunggu_kelas', ['user' => Auth::user()]);
        }

        // Relasi sudah di-load dengan 'with()', jadi baris "$siswa->load(...)" tidak diperlukan lagi.

        // 4. Dapatkan ID semua mata pelajaran dari kelas siswa
        $mapelIds = $siswa->kelas->mataPelajarans->pluck('id');

        // --- MENGHITUNG KARTU RINGKASAN ---

        // 5. Hitung Tugas Belum Selesai
        $tugasBelumSelesaiCount = Tugas::whereIn('mata_pelajaran_id', $mapelIds)
            ->where('batas_waktu', '>=', now())
            ->whereDoesntHave('pengumpulan', function ($query) use ($siswa) {
                $query->where('user_id', $siswa->id);
            })
            ->count();

        // 6. Hitung Materi Baru (dalam 7 hari terakhir)
        $materiBaruCount = Materi::whereIn('mata_pelajaran_id', $mapelIds)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // 7. Hitung Persentase dan Rekap Kehadiran Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $absensiBulanIni = Absensi::where('siswa_id', $siswa->id)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get();

        $rekapPresensi = [
            'hadir' => $absensiBulanIni->where('status', 'Hadir')->count(),
            'izin' => $absensiBulanIni->where('status', 'Izin')->count(),
            'sakit' => $absensiBulanIni->where('status', 'Sakit')->count(),
            'alpha' => $absensiBulanIni->where('status', 'Alpha')->count(),
        ];

        $jumlahHadir = $rekapPresensi['hadir'];
        $totalHariEfektif = 20; // Asumsi, bisa dibuat dinamis
        $kehadiranPercentage = ($totalHariEfektif > 0) ? round(($jumlahHadir / $totalHariEfektif) * 100) : 0;

        // --- MENGAMBIL DATA UNTUK TABEL DAN LIST ---

        // 8. Dapatkan Daftar Tugas & Ujian Mendatang
        $tugasMendatang = Tugas::with(['mataPelajaran', 'pengumpulan' => fn($query) => $query->where('user_id', $siswa->id)])
            ->whereIn('mata_pelajaran_id', $mapelIds)
            ->where('batas_waktu', '>=', now()->subDays(3))
            ->orderBy('batas_waktu', 'asc')
            ->limit(5)
            ->get();

        // 9. Dapatkan Materi Pembelajaran Terbaru
        $materiTerbaru = Materi::with('mataPelajaran')
            ->whereIn('mata_pelajaran_id', $mapelIds)
            ->latest()
            ->limit(3)
            ->get();

        // 10. Kirim semua data yang dibutuhkan ke view
        return view('siswa.dashboard', [
            'user' => $siswa,
            'tugasBelumSelesaiCount' => $tugasBelumSelesaiCount,
            'materiBaruCount' => $materiBaruCount,
            'kehadiranPercentage' => $kehadiranPercentage,
            'tugasMendatang' => $tugasMendatang,
            'rekapPresensi' => $rekapPresensi,
            'materiTerbaru' => $materiTerbaru,
        ]);
    }
    // public function siswa()
    // {
    //     // 1. Dapatkan data siswa yang sedang login
    //     $siswa = Auth::user();

    //     // Validasi bahwa pengguna adalah siswa dan terdaftar di sebuah kelas
    //     if (!$siswa || !$siswa->kelas_id) {
    //         return redirect()->route('login')->with('error', 'Anda harus login sebagai siswa untuk mengakses halaman ini.');
    //     }

    //     // Eager load relasi untuk efisiensi query.
    //     $siswa = User::with('kelas.mataPelajarans')->find(Auth::id());

    //     if (!$siswa->kelas) {
    //         return redirect()->back()->with('error', 'Data kelas Anda tidak ditemukan. Silakan hubungi administrator.');
    //     }

    //     // 2. Dapatkan ID semua mata pelajaran dari kelas siswa
    //     $mapelIds = $siswa->kelas->mataPelajarans->pluck('id');

    //     // --- MENGHITUNG KARTU RINGKASAN ---

    //     // 3. Hitung Tugas Belum Selesai
    //     $tugasBelumSelesaiCount = Tugas::whereIn('mata_pelajaran_id', $mapelIds)
    //         ->where('batas_waktu', '>=', now())
    //         ->whereDoesntHave('pengumpulan', function ($query) use ($siswa) {
    //             $query->where('user_id', $siswa->id);
    //         })
    //         ->count();

    //     // 4. Hitung Materi Baru (dalam 7 hari terakhir)
    //     $materiBaruCount = Materi::whereIn('mata_pelajaran_id', $mapelIds)
    //         ->where('created_at', '>=', now()->subDays(7))
    //         ->count();

    //     // 5. Hitung Persentase dan Rekap Kehadiran Bulan Ini
    //     $startOfMonth = Carbon::now()->startOfMonth();
    //     $endOfMonth = Carbon::now()->endOfMonth();

    //     $absensiBulanIni = Absensi::where('siswa_id', $siswa->id)
    //         ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
    //         ->get();

    //     $rekapPresensi = [
    //         'hadir' => $absensiBulanIni->where('status', 'Hadir')->count(),
    //         'izin' => $absensiBulanIni->where('status', 'Izin')->count(),
    //         'sakit' => $absensiBulanIni->where('status', 'Sakit')->count(),
    //         'alpha' => $absensiBulanIni->where('status', 'Alpha')->count(),
    //     ];

    //     $jumlahHadir = $rekapPresensi['hadir'];
    //     $totalHariEfektif = 20; // Asumsi, bisa dibuat dinamis
    //     $kehadiranPercentage = ($totalHariEfektif > 0) ? round(($jumlahHadir / $totalHariEfektif) * 100) : 0;

    //     // --- MENGAMBIL DATA UNTUK TABEL DAN LIST ---

    //     // 6. Dapatkan Daftar Tugas & Ujian Mendatang
    //     $tugasMendatang = Tugas::with(['mataPelajaran', 'pengumpulan' => fn($query) => $query->where('user_id', $siswa->id)])
    //         ->whereIn('mata_pelajaran_id', $mapelIds)
    //         ->where('batas_waktu', '>=', now()->subDays(3))
    //         ->orderBy('batas_waktu', 'asc')
    //         ->limit(5)
    //         ->get();

    //     // 7. Dapatkan Materi Pembelajaran Terbaru
    //     $materiTerbaru = Materi::with('mataPelajaran')
    //         ->whereIn('mata_pelajaran_id', $mapelIds)
    //         ->latest()
    //         ->limit(3)
    //         ->get();

    //     // 8. Kirim semua data yang dibutuhkan ke view
    //     return view('siswa.dashboard', [
    //         'user' => $siswa,
    //         'tugasBelumSelesaiCount' => $tugasBelumSelesaiCount,
    //         'materiBaruCount' => $materiBaruCount,
    //         'kehadiranPercentage' => $kehadiranPercentage,
    //         'tugasMendatang' => $tugasMendatang,
    //         'rekapPresensi' => $rekapPresensi,
    //         'materiTerbaru' => $materiTerbaru,
    //     ]);
    // }

    
    // public function siswa()
    // {
    //     // 1. Dapatkan data siswa yang sedang login
    //     $siswa = Auth::user();

    //     // Validasi bahwa pengguna adalah siswa dan terdaftar di sebuah kelas
    //     if (!$siswa || !$siswa->kelas_id) {
    //         return redirect()->route('login')->with('error', 'Anda harus login sebagai siswa untuk mengakses halaman ini.');
    //     }

    //     // Eager load relasi untuk efisiensi query.
    //     // Cara ini lebih eksplisit dan menghindari peringatan linter.
    //     $siswa = User::with('kelas.mataPelajarans')->find(Auth::id());

    //     if (!$siswa->kelas) {
    //         return redirect()->back()->with('error', 'Data kelas Anda tidak ditemukan. Silakan hubungi administrator.');
    //     }

    //     // 2. Dapatkan ID semua mata pelajaran yang diikuti siswa di kelasnya
    //     $mapelIds = $siswa->kelas->mataPelajarans->pluck('id');

    //     // --- MENGHITUNG KARTU RINGKASAN ---

    //     // 3. Hitung Tugas Belum Selesai
    //     $tugasBelumSelesaiCount = Tugas::whereIn('mata_pelajaran_id', $mapelIds)
    //         ->where('batas_waktu', '>=', now())
    //         ->whereDoesntHave('pengumpulan', function ($query) use ($siswa) {
    //             $query->where('user_id', $siswa->id);
    //         })
    //         ->count();

    //     // 4. Hitung Materi Baru (dalam 7 hari terakhir)
    //     $materiBaruCount = Materi::whereIn('mata_pelajaran_id', $mapelIds)
    //         ->where('created_at', '>=', now()->subDays(7))
    //         ->count();

    //     // 5. Hitung Persentase dan Rekap Kehadiran Bulan Ini
    //     $startOfMonth = Carbon::now()->startOfMonth();
    //     $endOfMonth = Carbon::now()->endOfMonth();

    //     $absensiBulanIni = Absensi::where('siswa_id', $siswa->id)
    //         ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
    //         ->get();

    //     $rekapPresensi = [
    //         'hadir' => $absensiBulanIni->where('status', 'Hadir')->count(),
    //         'izin' => $absensiBulanIni->where('status', 'Izin')->count(),
    //         'sakit' => $absensiBulanIni->where('status', 'Sakit')->count(),
    //         'alpha' => $absensiBulanIni->where('status', 'Alpha')->count(),
    //     ];

    //     $jumlahHadir = $rekapPresensi['hadir'];
    //     $totalHariEfektif = 20; // Asumsi, bisa dibuat dinamis atau diambil dari kalender akademik
    //     $kehadiranPercentage = ($totalHariEfektif > 0) ? round(($jumlahHadir / $totalHariEfektif) * 100) : 0;

    //     // --- MENGAMBIL DATA UNTUK TABEL DAN LIST ---

    //     // 6. Dapatkan Daftar Tugas & Ujian Mendatang
    //     $tugasMendatang = Tugas::with([
    //         'mataPelajaran',
    //         'kuis',
    //         'pengumpulan' => fn($query) => $query->where('user_id', $siswa->id)
    //     ])
    //         ->whereIn('mata_pelajaran_id', $mapelIds)
    //         ->where('batas_waktu', '>=', now()->subDays(3))
    //         ->orderBy('batas_waktu', 'asc')
    //         ->limit(5)
    //         ->get();

    //     // 7. Dapatkan Materi Pembelajaran Terbaru
    //     $materiTerbaru = Materi::with('mataPelajaran')
    //         ->whereIn('mata_pelajaran_id', $mapelIds)
    //         ->latest()
    //         ->limit(3)
    //         ->get();

    //     // 8. Kirim semua data yang dibutuhkan ke view
    //     return view('siswa.dashboard', [
    //         'user' => $siswa,
    //         'tugasBelumSelesaiCount' => $tugasBelumSelesaiCount,
    //         'materiBaruCount' => $materiBaruCount,
    //         'kehadiranPercentage' => $kehadiranPercentage,
    //         'tugasMendatang' => $tugasMendatang,
    //         'rekapPresensi' => $rekapPresensi,
    //         'materiTerbaru' => $materiTerbaru,
    //     ]);
    // }

    public function materiformguru()
    {
        // Pastikan Anda membuat file view ini: resources/views/siswa/dashboard.blade.php
        return view('guru.hal_materi');
    }
}
