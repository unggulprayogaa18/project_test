<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran; // Import model MataPelajaran
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MataPelajaranController extends Controller
{
    /**
     * Tampilkan daftar semua mata pelajaran.
     */
    public function index(Request $request)
    {
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

    /**
     * Tampilkan form untuk membuat mata pelajaran baru.
     */
    public function create()
    {
        return view('guru.mata_pelajaran.create');
    }

    /**
     * Simpan mata pelajaran baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajarans,nama_mapel',
            'kode_mapel' => 'nullable|string|max:255|unique:mata_pelajarans,kode_mapel',
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id', // pastikan valid
        ]);

        // Buat mata pelajaran
        $mataPelajaran = MataPelajaran::create($request->only([
            'nama_mapel',
            'kode_mapel',
            'deskripsi'
        ]));

        // Masukkan ke tabel pivot
        DB::table('kelas_mata_pelajaran')->insert([
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $mataPelajaran->id,
            'guru_id' => Auth::id(), // guru yang sedang login
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect
        return redirect()->route('guru.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail mata pelajaran tertentu.
     */
    public function show(MataPelajaran $mataPelajaran)
    {
        return view('guru.mata_pelajaran.show', compact('mataPelajaran'));
    }

    /**
     * Tampilkan form untuk mengedit mata pelajaran yang ada.
     */
    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('guru.mata_pelajaran.edit', compact('mataPelajaran'));
    }

    /**
     * Perbarui mata pelajaran di database.
     */
    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        // Validasi input
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajarans,nama_mapel,' . $mataPelajaran->id,
            'kode_mapel' => 'nullable|string|max:255|unique:mata_pelajarans,kode_mapel,' . $mataPelajaran->id,
            'deskripsi' => 'nullable|string',
        ]);

        // Perbarui mata pelajaran
        $mataPelajaran->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('guru.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    /**
     * Hapus mata pelajaran dari database.
     */
    public function destroy(MataPelajaran $mataPelajaran)
    {
        // Hapus dulu entri di tabel pivot
        DB::table('kelas_mata_pelajaran')
            ->where('mata_pelajaran_id', $mataPelajaran->id)
            ->delete();

        // Lalu hapus mapel-nya
        $mataPelajaran->delete();

        return redirect()->route('guru.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}

