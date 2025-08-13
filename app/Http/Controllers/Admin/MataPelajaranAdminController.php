<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranAdminController extends Controller
{
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

        // DIPERBAIKI: Menggunakan nama route 'admin.mata-pelajaran-admin.index' yang benar.
        return redirect()->route('admin.mata-pelajaran-admin.index')
            ->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    /**
     * Memperbarui mata pelajaran yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MataPelajaran  $mata_pelajaran_admin Karena nama resource di web.php adalah 'mata-pelajaran-admin',
     * variabelnya harus sesuai agar Route Model Binding bekerja.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MataPelajaran $mata_pelajaran_admin)
    {
        // DIPERBAIKI: Menggunakan variabel $mata_pelajaran_admin yang di-inject oleh Laravel.
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajarans,nama_mapel,' . $mata_pelajaran_admin->id,
            'kode_mapel' => 'required|string|max:50|unique:mata_pelajarans,kode_mapel,' . $mata_pelajaran_admin->id,
            'deskripsi' => 'nullable|string',
        ]);

        $mata_pelajaran_admin->update($request->all());

        // DIPERBAIKI: Menggunakan nama route 'admin.mata-pelajaran-admin.index' yang benar.
        return redirect()->route('admin.mata-pelajaran-admin.index')
            ->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus mata pelajaran.
     *
     * @param  \App\Models\MataPelajaran  $mata_pelajaran_admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(MataPelajaran $mata_pelajaran_admin)
    {
        // DIPERBAIKI: Menggunakan variabel $mata_pelajaran_admin yang di-inject oleh Laravel.
        $mata_pelajaran_admin->delete();

        // DIPERBAIKI: Menggunakan nama route 'admin.mata-pelajaran-admin.index' yang benar.
        return redirect()->route('admin.mata-pelajaran-admin.index')
            ->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}