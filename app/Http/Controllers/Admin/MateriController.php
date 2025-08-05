<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // [TAMBAH] Import Auth facade
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MateriController extends Controller
{
    /**
     * Display a listing of all materials for the admin.
     */
    public function index()
    {
        // [UBAH] Eager load relasi mataPelajaran, tidak perlu user lagi untuk tampilan tabel
        $materis = Materi::with('mataPelajaran')
            ->latest()
            ->paginate(10);

        // [UBAH] Hanya perlu daftar mata pelajaran untuk modal
        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();

        return view('admin.hal_materi', compact('materis', 'mataPelajaranList'));
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tipe_materi' => ['required', Rule::in(['file', 'link'])],
            'file_path' => 'required_if:tipe_materi,file|file|mimes:pdf,doc,docx,ppt,pptx,mp4,mov,zip|max:20480', // Max 20MB
            'file_path_link' => 'required_if:tipe_materi,link|nullable|url'
        ]);

        $filePath = null;
        if ($validated['tipe_materi'] === 'file' && $request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('materi', 'public');
        } elseif ($validated['tipe_materi'] === 'link') {
            $filePath = $validated['file_path_link'];
        }

        Materi::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
            'tipe_materi' => $validated['tipe_materi'],
            'file_path' => $filePath,
            'user_id' => Auth::id() // [TAMBAH] Set user_id ke admin yang sedang login
        ]);

        return redirect()->route('admin.hal_materi')->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tipe_materi' => ['required', Rule::in(['file', 'link'])],
            // [UBAH] File path tidak required saat update, hanya divalidasi jika ada file baru
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,mov,zip|max:20480',
            'file_path_link' => 'nullable|url'
        ]);

        $filePath = $materi->file_path;
        $newType = $validated['tipe_materi'];

        // Logic untuk mengganti dari link ke file atau sebaliknya
        if ($newType !== $materi->tipe_materi && $materi->tipe_materi === 'file' && $materi->file_path) {
            if (Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
        }
        
        if ($newType === 'link' && !empty($validated['file_path_link'])) {
            $filePath = $validated['file_path_link'];
        } elseif ($newType === 'file' && $request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
            // Simpan file baru
            $filePath = $request->file('file_path')->store('materi', 'public');
        }

        $materi->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
            'tipe_materi' => $newType,
            'file_path' => $filePath,
            // [HAPUS] Tidak mengupdate user_id saat admin mengedit materi
        ]);

        return redirect()->route('admin.hal_materi')->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy(Materi $materi)
    {
        if ($materi->tipe_materi === 'file' && $materi->file_path) {
            if (Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
        }
        $materi->delete();
        return redirect()->route('admin.hal_materi')->with('success', 'Materi berhasil dihapus.');
    }
}