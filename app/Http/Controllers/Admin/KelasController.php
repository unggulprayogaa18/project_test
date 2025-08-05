<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    /**
     * Menampilkan halaman utama untuk mengelola kelas.
     */
 

    /**
     * Menyimpan data kelas baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                // Pastikan kombinasi nama_kelas dan tahun_ajaran unik
                Rule::unique('kelas')->where(function ($query) use ($request) {
                    return $query->where('tahun_ajaran', $request->tahun_ajaran);
                }),
            ],
            'tahun_ajaran' => 'required|string|regex:/^\d{4}\/\d{4}$/', // Format YYYY/YYYY
            'tingkat' => 'required|string|max:5', // Contoh: X, XI, XII
        ]);

        // Membuat record baru di tabel 'kelas'
        Kelas::create($request->only('nama_kelas', 'tahun_ajaran', 'tingkat')); // Ambil semua field yang diperlukan

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Memperbarui data kelas yang ada di database.
     */
    public function update(Request $request, Kelas $kela)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                // Pastikan kombinasi nama_kelas dan tahun_ajaran unik, kecuali untuk kelas yang sedang diupdate
                Rule::unique('kelas')->ignore($kela->id)->where(function ($query) use ($request) {
                    return $query->where('tahun_ajaran', $request->tahun_ajaran);
                }),
            ],
            'tahun_ajaran' => 'required|string|regex:/^\d{4}\/\d{4}$/',
            'tingkat' => 'required|string|max:5',
        ]);

        // Update record kelas
        $kela->update($request->only('nama_kelas', 'tahun_ajaran', 'tingkat'));

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data kelas dari database.
     */
    public function destroy(Kelas $kela)
    {
        // Hapus record kelas
        $kela->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}