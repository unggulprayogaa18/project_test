<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Kuis; // Pastikan model Kuis di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $guruId = Auth::id();

        // Ambil semua ID mata pelajaran yang diajar oleh guru ini
        $mapelIds = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', $guruId)
            ->pluck('mata_pelajaran_id')
            ->unique()
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
        
        // Ambil daftar kuis yang dibuat oleh guru yang bersangkutan
        $kuisList = Kuis::where('guru_id', $guruId)->orderBy('judul_kuis')->get();
        
        // Materi list is not passed directly, it will be fetched via AJAX.

        return view('guru.hal_tugas', compact('tugas', 'mataPelajaranList', 'kuisList'));
    }

    /**
     * Fetch materials based on the selected subject ID.
     */
    public function getMateriByMapel(Request $request)
    {
        $mapelId = $request->input('mata_pelajaran_id');
        if (!$mapelId) {
            return response()->json([]);
        }

        $materi = Materi::where('mata_pelajaran_id', $mapelId)
                            ->orderBy('judul')
                            ->get(['id', 'judul']);

        return response()->json($materi);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'batas_waktu' => 'required|date',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'materi_id' => 'nullable|exists:materis,id',
            // [FIX] Menggunakan nama tabel yang benar: 'kuis_tabel'
            'kuis_id' => 'nullable|exists:kuis_tabel,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('guru.tugas.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Validasi otorisasi: apakah guru ini mengajar mata pelajaran tersebut
        $guruMapelIds = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', Auth::id())
            ->pluck('mata_pelajaran_id')
            ->toArray();

        if (!in_array($request->mata_pelajaran_id, $guruMapelIds)) {
            return redirect()->route('guru.tugas.index')
                ->with('error', 'Anda tidak berwenang menambah tugas untuk mata pelajaran ini.');
        }

        Tugas::create($request->all());

        return redirect()->route('guru.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'batas_waktu' => 'required|date',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'materi_id' => 'nullable|exists:materis,id',
            // [FIX] Menggunakan nama tabel yang benar: 'kuis_tabel'
            'kuis_id' => 'nullable|exists:kuis_tabel,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('guru.tugas.index')
                ->withErrors($validator)
                ->withInput();
        }

        $tugas = Tugas::findOrFail($id);
        $guruMapelIds = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', Auth::id())
            ->pluck('mata_pelajaran_id')
            ->toArray();

        if (!in_array($tugas->mata_pelajaran_id, $guruMapelIds)) {
            return redirect()->route('guru.tugas.index')
                ->with('error', 'Anda tidak berwenang memperbarui tugas ini.');
        }

        $tugas->update($request->all());

        return redirect()->route('guru.tugas.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $guruMapelIds = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', Auth::id())
            ->pluck('mata_pelajaran_id')
            ->toArray();

        if (!in_array($tugas->mata_pelajaran_id, $guruMapelIds)) {
            return redirect()->route('guru.tugas.index')
                ->with('error', 'Anda tidak berwenang menghapus tugas ini.');
        }

        $tugas->delete();

        return redirect()->route('guru.tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
