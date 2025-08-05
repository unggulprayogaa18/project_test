<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MataPelajaran;
use App\Models\Kuis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MateriController extends Controller
{
    /**
     * Menampilkan daftar materi dengan fungsionalitas pencarian.
     */
    public function index(Request $request)
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
        $materis = $query->where('user_id', Auth::id())->latest()->paginate(10);
        
        // Ambil data untuk dropdown di modal
        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();
        $kuisList = Kuis::where('guru_id', Auth::id())->orderBy('judul_kuis')->get();

        // Arahkan ke view guru yang benar dan kirim semua data yang diperlukan
        return view('guru.hal_materi', compact('materis', 'mataPelajaranList', 'kuisList'));
    }

    /**
     * Menyimpan materi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kuis_id' => 'nullable|exists:kuis,id', // Pastikan nama tabel kuis benar
            'tipe_materi' => ['required', Rule::in(['file', 'link'])],
            'file_path' => 'required_if:tipe_materi,link|nullable|url',
            'file' => 'required_if:tipe_materi,file|nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,mp4,jpg,png|max:20480', // Maksimal 20MB
        ]);

        $path = null;
        if ($request->tipe_materi == 'file' && $request->hasFile('file')) {
            $path = $request->file('file')->store('public/materi');
        } elseif ($request->tipe_materi == 'link') {
            $path = $request->file_path;
        }

        Materi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kuis_id' => $request->kuis_id,
            'tipe_materi' => $request->tipe_materi,
            'file_path' => $path,
            'user_id' => Auth::id(), // Pastikan user_id diisi
        ]);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Memperbarui materi yang ada.
     */
    public function update(Request $request, Materi $materi)
    {
        // Pastikan guru hanya bisa mengedit materinya sendiri
        $this->authorize('update', $materi);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kuis_id' => 'nullable|exists:kuis,id',
            'tipe_materi' => ['required', Rule::in(['file', 'link'])],
            'file_path' => 'required_if:tipe_materi,link|nullable|url',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,mp4,jpg,png|max:20480',
        ]);
        
        $path = $materi->file_path;

        if ($request->tipe_materi == 'file' && $request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($materi->tipe_materi == 'file' && $materi->file_path) {
                Storage::delete($materi->file_path);
            }
            // Simpan file baru
            $path = $request->file('file')->store('public/materi');
        } elseif ($request->tipe_materi == 'link') {
            // Hapus file lama jika tipe materi berubah dari file ke link
            if ($materi->tipe_materi == 'file' && $materi->file_path) {
                Storage::delete($materi->file_path);
            }
            $path = $request->file_path;
        }

        $materi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kuis_id' => $request->kuis_id,
            'tipe_materi' => $request->tipe_materi,
            'file_path' => $path,
        ]);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Menghapus materi.
     */
    public function destroy(Materi $materi)
    {
        // Pastikan guru hanya bisa menghapus materinya sendiri
        $this->authorize('delete', $materi);
        
        if ($materi->tipe_materi == 'file' && $materi->file_path) {
            Storage::delete($materi->file_path);
        }

        $materi->delete();
        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus!');
    }
}