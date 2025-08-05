<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    /**
     * Menampilkan halaman daftar materi.
     * (Untuk halaman halaman_materi.blade.php)
     */
    public function hal_matapelajaran(Request $request)
    {
        // Ambil semua mata pelajaran dengan pagination
        // Query dasar untuk mengambil mata pelajaran
        $query = MataPelajaran::query()
            ->leftJoin('kelas_mata_pelajaran', 'mata_pelajarans.id', '=', 'kelas_mata_pelajaran.mata_pelajaran_id')
            ->leftJoin('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id')
            ->select(
                'mata_pelajarans.*', // Ambil semua kolom dari tabel mata pelajaran
                'kelas.nama_kelas'   // Ambil kolom nama_kelas dari tabel kelas
            );

        // Fitur Pencarian (Opsional, tapi sangat direkomendasikan)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('mata_pelajarans.nama_mapel', 'like', '%' . $search . '%')
                    ->orWhere('mata_pelajarans.kode_mapel', 'like', '%' . $search . '%')
                    ->orWhere('kelas.nama_kelas', 'like', '%' . $search . '%');
            });
        }

        // Ambil data dengan pagination
        $mataPelajaran = $query->paginate(10);

        // Ambil semua kelas untuk dropdown di modal
        $kelasList = Kelas::all();

        // Kirim data ke view
        return view('guru.hal_matapelajaran', compact('mataPelajaran', 'kelasList'));
    }
    public function hal_tugas(Request $request)
    {
          $search = $request->input('search');
        $guruId = Auth::id();

        // Ambil semua ID mata pelajaran yang diajar oleh guru ini
        $mapelIds = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', $guruId)
            ->pluck('mata_pelajaran_id')
            ->unique() // Ensure unique IDs
            ->toArray();

        // Query tugas-tugas berdasarkan mata pelajaran yang diajar oleh guru
        $tugasQuery = Tugas::whereIn('mata_pelajaran_id', $mapelIds)
            ->with(['mataPelajaran', 'kuis', 'materi']); // Eager load relationships

        if ($search) {
            $tugasQuery->where('judul', 'like', '%' . $search . '%');
        }

        $tugas = $tugasQuery->latest()->paginate(10);

        // Ambil daftar mata pelajaran yang diajar untuk dropdown/modal
        $mataPelajaranList = MataPelajaran::whereIn('id', $mapelIds)->orderBy('nama_mapel')->get();
        $kuisList = \App\Models\Kuis::orderBy('judul_kuis')->get();
        
        // Materi list is not passed directly, it will be fetched via AJAX.

        return view('guru.hal_tugas', compact('tugas', 'mataPelajaranList', 'kuisList'));
    }

    /**
     * Menampilkan form untuk menambah materi baru.
     * (Untuk halaman tambah_materi.blade.php)
     */



    public function hal_nilai(Request $request)
    {
        $request->validate([
            'kelas_id' => 'nullable|integer|exists:kelas,id',
            'mapel_id' => 'nullable|integer|exists:mata_pelajarans,id',
        ]);

        $selectedKelasId = $request->input('kelas_id');
        $selectedMapelId = $request->input('mapel_id');

        $kelas = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaran = collect();
        $siswas = collect();
        $tugas = null;

        if ($selectedKelasId) {
            $selectedKelas = Kelas::find($selectedKelasId);
            $mataPelajaran = $selectedKelas->mataPelajarans()->orderBy('nama_mapel')->get();
        }

        if ($selectedKelasId && $selectedMapelId) {
            $tugas = Tugas::where('mata_pelajaran_id', $selectedMapelId)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->latest()
                ->first();

            $siswas = User::where('kelas_id', $selectedKelasId)
                ->where('role', 'siswa')
                ->with([
                    'nilais' => function ($query) use ($tugas) {
                        if ($tugas) {
                            $query->where('tugas_id', $tugas->id);
                        }
                    },
                    'pengumpulanTugas' => function ($query) use ($tugas) {
                        if ($tugas) {
                            $query->where('tugas_id', $tugas->id);
                        }
                    }
                ])
                ->orderBy('nama')
                ->paginate(10);
        } else {
            $siswas = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        return view('guru.hal_nilai', [
            'kelas' => $kelas,
            'mataPelajaran' => $mataPelajaran,
            'siswas' => $siswas,
            'tugas' => $tugas,
            'selectedKelasId' => $selectedKelasId,
            'selectedMapelId' => $selectedMapelId,
        ]);
    }




    // Ganti nama view jika berbeda. Misal: 'guru.materi.create'
    public function hal_absensi(Request $request)
    {
        // Ambil data untuk filter
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();

        $siswaList = collect(); // Default koleksi kosong
        $selectedKelasId = $request->input('kelas_id');
        $selectedTanggal = $request->input('tanggal');

        // Jika filter kelas dan tanggal dipilih, tampilkan siswa
        if ($selectedKelasId && $selectedTanggal) {
            $kelas = Kelas::findOrFail($selectedKelasId);

            // Ambil siswa yang terdaftar di kelas tersebut
            // dan eager load absensi mereka pada tanggal dan mapel yang dipilih
            $siswaList = $kelas->siswas()->orderBy('nama')
                ->with([
                    'absensi' => function ($query) use ($selectedTanggal) {
                        $query->where('tanggal', $selectedTanggal);
                    }
                ])->get();
        }

        return view('guru.hal_absensi', compact(
            'kelasList',
            'mataPelajaranList',
            'siswaList',
            'selectedKelasId',
            'selectedTanggal'
        ));
    }
    public function halamanMataPelajaran()
    {
        // Bisa ambil data pelajaran dari database, kalau ada
        // $mataPelajaran = MataPelajaran::all();
        return view('guru.hal_matapelajaran'); // Buat view-nya nanti
    }
    public function halamanTugas()
    {
        // Bisa ambil data pelajaran dari database, kalau ada
        // $mataPelajaran = MataPelajaran::all();
        return view('guru.hal_tugas'); // Buat view-nya nanti
    }
    public function halamanUjian()
    {
        // Bisa ambil data pelajaran dari database, kalau ada
        // $mataPelajaran = MataPelajaran::all();
        return view('guru.hal_ujian_kuis'); // Buat view-nya nanti
    }

    public function hal_buat_kuis(Request $request)
    {
        $query = Kuis::query()->with(['mataPelajaran', 'guru']); // Eager load relasi

        // Fitur pencarian
        if ($search = $request->input('search')) {
            $query->where('judul_kuis', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%')
                ->orWhereHas('mataPelajaran', function ($q) use ($search) {
                    $q->where('nama_mapel', 'like', '%' . $search . '%');
                })
                ->orWhereHas('guru', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                });
        }

        // Paginate hasil
        $kuis = $query->paginate(10); // 10 item per halaman

        // Ambil data mata pelajaran dan guru untuk dropdown di modal
        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();
        // Hanya ambil user dengan role 'guru'
        $guruList = User::where('role', 'guru')->orderBy('nama')->get();

        return view('guru.hal_kuis', compact('kuis', 'mataPelajaranList', 'guruList'));
    }

    // Bisa ambil data pelajaran dari database, kalau ada
    // $mataPelajaran = MataPelajaran::all();
    public function hal_materi(Request $request)
    {
        // Query dasar dengan eager loading untuk relasi yang dibutuhkan
        $query = Materi::with(['mataPelajaran', 'kuis']);

        // Filter pencarian
        if ($search = $request->input('search')) {
            $query->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhereHas('mataPelajaran', function ($q) use ($search) {
                    $q->where('nama_mapel', 'like', "%{$search}%");
                });
        }

        // Ambil hanya materi yang dibuat oleh guru yang sedang login
        $materis = $query->paginate(10);

        // Ambil data untuk dropdown di modal
        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();
        $kuisList = Kuis::where('guru_id', Auth::id())->orderBy('judul_kuis')->get();

        // Arahkan ke view guru yang benar dan kirim semua data yang diperlukan
        return view('guru.hal_materi', compact('materis', 'mataPelajaranList', 'kuisList'));
    }



    // Fungsi-fungsi lain seperti store, edit, update, destroy akan diisi nanti
    // ...
}