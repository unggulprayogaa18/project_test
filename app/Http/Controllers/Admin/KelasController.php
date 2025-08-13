<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    /**
     * [PERBAIKAN] Menambahkan method index() yang hilang.
     * Method ini menampilkan halaman daftar kelas.
     */
    public function index()
    {
        // Mengambil semua data kelas, diurutkan dari yang terbaru, dengan pagination
        $kelas = Kelas::latest()->paginate(10); 
        
        // Menampilkan view dan mengirimkan data kelas ke dalamnya
        return view('admin.hal_kelas', compact('kelas'));
    }

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
                Rule::unique('kelas')->where(function ($query) use ($request) {
                    return $query->where('tahun_ajaran', $request->tahun_ajaran);
                }),
            ],
            'tahun_ajaran' => 'required|string|regex:/^\d{4}\/\d{4}$/',
            'tingkat' => 'required|string|max:5',
        ]);

        Kelas::create($request->only('nama_kelas', 'tahun_ajaran', 'tingkat'));

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
                Rule::unique('kelas')->ignore($kela->id)->where(function ($query) use ($request) {
                    return $query->where('tahun_ajaran', $request->tahun_ajaran);
                }),
            ],
            'tahun_ajaran' => 'required|string|regex:/^\d{4}\/\d{4}$/',
            'tingkat' => 'required|string|max:5',
        ]);

        $kela->update($request->only('nama_kelas', 'tahun_ajaran', 'tingkat'));

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data kelas dari database.
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}