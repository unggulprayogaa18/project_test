<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman daftar materi.
     * (Untuk halaman halaman_materi.blade.php)
     */


    public function hal_matapelajaran()
    {
        $mataPelajaran = MataPelajaran::latest()->paginate(10);
        return view('admin.hal_mata_pelajaran', compact('mataPelajaran'));
    }

    public function hal_pengguna(Request $request)
    {
        // Ambil data pengguna dengan urutan terbaru dan paginasi
        // Mulai query dasar
        $query = User::query();

        // Terapkan filter berdasarkan role jika ada
        if ($request->filled('role') && in_array($request->role, ['admin', 'guru', 'siswa'])) {
            $query->where('role', $request->role);
        }

        // Terapkan filter pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('nomor_induk', 'like', "%{$search}%");
            });
        }

        // Ambil hasil dengan paginasi
        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk menambah materi baru.
     * (Untuk halaman tambah_materi.blade.php)
     */
    public function hal_kelas()
    {
        // Ganti nama view jika berbeda. Misal: 'guru.materi.create'
        $kelas = Kelas::latest()->paginate(10);

        // Mengembalikan view dengan data kelas.
        return view('admin.hal_kelas', compact('kelas'));
    }

    public function hal_materi(Request $request)
    {
        // Ambil semua materi beserta relasi kelas dan user (guru) untuk ditampilkan
        // Ambil semua materi beserta relasi
        $search = $request->input('search');

        // Fetch all materials, not just for one user.
        // Eager load relationships for efficiency.
        $materiQuery = Materi::with('mataPelajaran', 'user');

        if ($search) {
            $materiQuery->where('judul', 'like', '%' . $search . '%');
        }

        $materis = $materiQuery->latest()->paginate(10);

        // Fetch all subjects and all teachers for the modal dropdowns
        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();
        $guruList = User::where('role', 'guru')->orderBy('nama')->get(); // Assuming 'nama' is the name column

        return view('admin.hal_materi', compact('materis', 'mataPelajaranList', 'guruList'));

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

  public function laporanPengguna(Request $request)
    {
        // Memulai query builder
        $query = User::query()->with('kelas'); // Eager load relasi kelas

        // Menerapkan filter jika ada
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Mengambil semua data yang sudah difilter (tanpa paginasi)
        $users = $query->orderBy('nama', 'asc')->get();

        // Mengirim data ke view
        return view('admin.laporan.pengguna', compact('users'));
    }
    // Fungsi-fungsi lain seperti store, edit, update, destroy akan diisi nanti
    // ...
}