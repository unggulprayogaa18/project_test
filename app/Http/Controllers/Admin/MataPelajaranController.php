<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    /**
     * Menampilkan daftar semua mata pelajaran.
     */
    public function index()
    {
        $mataPelajaran = MataPelajaran::latest()->paginate(10);
        return view('admin.hal_mata_pelajaran', compact('mataPelajaran'));
    }

    /**
     * Menyimpan mata pelajaran baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajarans,nama_mapel',
            'kode_mapel' => 'required|string|max:50|unique:mata_pelajarans,kode_mapel',
            'deskripsi' => 'nullable|string',
        ]);

        MataPelajaran::create($request->all());

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    /**
     * Memperbarui mata pelajaran yang ada.
     */
    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajarans,nama_mapel,' . $mataPelajaran->id,
            'kode_mapel' => 'required|string|max:50|unique:mata_pelajarans,kode_mapel,' . $mataPelajaran->id,
            'deskripsi' => 'nullable|string',
        ]);

        $mataPelajaran->update($request->all());

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus mata pelajaran.
     */
    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}