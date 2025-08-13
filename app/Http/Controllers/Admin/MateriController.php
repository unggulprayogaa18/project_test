<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MateriController extends Controller
{
    /**
     * Menampilkan daftar materi.
     */
    public function index()
    {
        $materis = Materi::with('mataPelajaran')
            ->latest()
            ->paginate(10);
        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();
        return view('admin.hal_materi', compact('materis', 'mataPelajaranList'));
    }

    /**
     * Menyimpan materi baru.
     */
    public function store(Request $request)
    {
        Log::info('Mencoba menyimpan materi baru. Data yang diterima:', $request->all());

        // Aturan validasi dinamis untuk 'file_path'
        $rules = [
            'judul'             => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tipe_materi'       => ['required', Rule::in(['file', 'link'])],
        ];

        if ($request->input('tipe_materi') === 'link') {
            $rules['file_path'] = 'required|url';
        } else {
            $rules['file_path'] = 'required|file|mimes:pdf,doc,docx,ppt,pptx,mp4,mov,zip|max:20480';
        }

        $validated = $request->validate($rules);

        $filePath = null;
        if ($validated['tipe_materi'] === 'file' && $request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('materi', 'public');
        } elseif ($validated['tipe_materi'] === 'link') {
            $filePath = $validated['file_path'];
        }

        try {
            // Membuat materi baru tanpa user_id
            $materi = Materi::create([
                'judul'             => $validated['judul'],
                'deskripsi'         => $validated['deskripsi'],
                'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
                'tipe_materi'       => $validated['tipe_materi'],
                'file_path'         => $filePath
            ]);
            Log::info('Materi berhasil dibuat dengan ID: ' . $materi->id);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan materi ke database: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data ke database.');
        }

        return redirect()->route('admin.materis.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Memperbarui materi yang ada.
     */
    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'judul'             => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tipe_materi'       => ['required', Rule::in(['file', 'link'])],
            'file_path'         => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,mov,zip|max:20480',
            'file_path_link'    => 'nullable|url'
        ]);

        $filePath = $materi->file_path;
        $newType = $validated['tipe_materi'];

        if ($newType !== $materi->tipe_materi && $materi->tipe_materi === 'file' && $materi->file_path) {
            if (Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
        }
        
        if ($newType === 'link' && !empty($validated['file_path_link'])) {
            $filePath = $validated['file_path_link'];
        } elseif ($newType === 'file' && $request->hasFile('file_path')) {
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $filePath = $request->file('file_path')->store('materi', 'public');
        }

        $materi->update([
            'judul'             => $validated['judul'],
            'deskripsi'         => $validated['deskripsi'],
            'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
            'tipe_materi'       => $newType,
            'file_path'         => $filePath,
        ]);

        return redirect()->route('admin.materis.index')->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Menghapus materi.
     */
    public function destroy(Materi $materi)
    {
        if ($materi->tipe_materi === 'file' && $materi->file_path) {
            if (Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
        }
        $materi->delete();

        return redirect()->route('admin.materis.index')->with('success', 'Materi berhasil dihapus.');
    }
}