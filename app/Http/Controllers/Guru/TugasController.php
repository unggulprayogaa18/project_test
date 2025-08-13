<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Kuis;
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

        $mapelIds = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', $guruId)
            ->pluck('mata_pelajaran_id')
            ->unique()
            ->toArray();

        $tugasQuery = Tugas::whereIn('mata_pelajaran_id', $mapelIds)
            ->with(['mataPelajaran', 'kuis', 'materi']);

        if ($search) {
            $tugasQuery->where('judul', 'like', '%' . $search . '%');
        }

        $tugas = $tugasQuery->latest()->paginate(10);
        
        $mataPelajaranList = MataPelajaran::whereIn('id', $mapelIds)->orderBy('nama_mapel')->get();
        
        // [PERBAIKAN 1] Ambil ID kuis yang sudah terpakai
        $usedKuisIds = Tugas::whereNotNull('kuis_id')->pluck('kuis_id');
        
        // Ambil daftar kuis yang dibuat guru, KECUALI yang sudah terpakai
        $kuisList = Kuis::where('guru_id', $guruId)
                        ->whereNotIn('id', $usedKuisIds)
                        ->orderBy('judul_kuis')
                        ->get();

        return view('guru.hal_tugas', compact('tugas', 'mataPelajaranList', 'kuisList'));
    }

    public function getMateriByMapel(Request $request)
    {
        $mapelId = $request->input('mata_pelajaran_id');
        if (!$mapelId) {
            return response()->json([]);
        }

        // [PERBAIKAN 2] Ambil ID materi yang sudah terpakai
        $usedMateriIds = Tugas::whereNotNull('materi_id')->pluck('materi_id');

        // Ambil materi berdasarkan mapel, KECUALI yang sudah terpakai
        $materi = Materi::where('mata_pelajaran_id', $mapelId)
                        ->whereNotIn('id', $usedMateriIds)
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
            // Validasi unik: pastikan materi_id belum ada di tabel tugas
            'materi_id' => 'nullable|exists:materis,id|unique:tugas,materi_id',
            // Validasi unik: pastikan kuis_id belum ada di tabel tugas
            'kuis_id' => 'nullable|exists:kuis_tabel,id|unique:tugas,kuis_id',
        ], [
            'materi_id.unique' => 'Materi ini sudah terhubung dengan tugas lain.',
            'kuis_id.unique' => 'Kuis ini sudah terhubung dengan tugas lain.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('guru.tugas.index')
                ->withErrors($validator)
                ->withInput();
        }

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
        $tugas = Tugas::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'batas_waktu' => 'required|date',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            // Validasi unik, abaikan tugas yang sedang diedit
            'materi_id' => 'nullable|exists:materis,id|unique:tugas,materi_id,' . $tugas->id,
            'kuis_id' => 'nullable|exists:kuis_tabel,id|unique:tugas,kuis_id,' . $tugas->id,
        ], [
            'materi_id.unique' => 'Materi ini sudah terhubung dengan tugas lain.',
            'kuis_id.unique' => 'Kuis ini sudah terhubung dengan tugas lain.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('guru.tugas.index')
                ->withErrors($validator)
                ->withInput();
        }

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