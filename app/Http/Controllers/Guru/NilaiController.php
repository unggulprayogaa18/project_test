<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Make sure this is imported

class NilaiController extends Controller
{
    /**
     * Menampilkan halaman utama untuk mengelola nilai.
     */
    public function index(Request $request)
    {
        $request->validate([
            'kelas_id' => 'nullable|integer|exists:kelas,id',
            'mapel_id' => 'nullable|integer|exists:mata_pelajarans,id',
        ]);

        $selectedKelasId = $request->input('kelas_id');
        $selectedMapelId = $request->input('mapel_id');

        $kelas = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaran = collect();
        $siswas = collect();
        $tugas = null;

        if ($selectedKelasId) {
            $selectedKelas = Kelas::find($selectedKelasId);
            $mataPelajaran = $selectedKelas->mataPelajarans()->orderBy('nama_mapel')->get();
        }

        if ($selectedKelasId && $selectedMapelId) {
            $tugas = Tugas::where('mata_pelajaran_id', $selectedMapelId)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->latest()
                ->first();

            $siswas = User::where('kelas_id', $selectedKelasId)
                ->where('role', 'siswa')
                ->with([
                    'pengumpulanTugas' => function ($query) use ($tugas) {
                        if ($tugas) {
                            $query->where('tugas_id', $tugas->id);
                        }
                    }
                ])
                ->orderBy('nama')
                ->paginate(10);
        } else {
            $siswas = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        return view('guru.hal_nilai', [
            'kelas' => $kelas,
            'mataPelajaran' => $mataPelajaran,
            'siswas' => $siswas,
            'tugas' => $tugas,
            'selectedKelasId' => $selectedKelasId,
            'selectedMapelId' => $selectedMapelId,
        ]);
    }

    /**
     * Menyimpan nilai baru langsung ke tabel pengumpulan_tugas.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pengumpulan_tugas_id' => 'required|integer|exists:pengumpulan_tugas,id',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $pengumpulanTugas = PengumpulanTugas::find($request->pengumpulan_tugas_id);
        if ($pengumpulanTugas) {
            $pengumpulanTugas->update(['nilai' => $request->nilai]);
            return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
        }

        // This case should ideally not happen if validation 'exists' works,
        // but adding it for robustness.
        return redirect()->back()->with('error', 'Data pengumpulan tugas tidak ditemukan. Gagal menyimpan nilai.');
    }

    /**
     * Memperbarui data nilai yang sudah ada di tabel pengumpulan_tugas.
     * Menggunakan Route Model Binding untuk PengumpulanTugas.
     */
    public function update(Request $request, PengumpulanTugas $pengumpulanTugas = null) // Added '= null' for robust check
    {
        // Log: Record attempt to update score
        Log::info('Percobaan update nilai:', [
            'pengumpulan_tugas_id_from_route' => $pengumpulanTugas ? $pengumpulanTugas->id : 'NULL (not found)',
            'nilai_baru_dari_request' => $request->nilai,
            'nilai_lama_sebelum_update' => $pengumpulanTugas ? $pengumpulanTugas->nilai : 'N/A',
            'user_id_guru' => auth()->id(),
            'request_url' => $request->fullUrl(), // Log the full URL for debugging
        ]);

        // IMPORTANT: Handle cases where Route Model Binding fails to find the model
        if (!$pengumpulanTugas) {
            Log::error('Gagal memperbarui nilai: Objek PengumpulanTugas tidak ditemukan oleh Route Model Binding.', [
                'request_path' => $request->path(),
                'request_id_parameter' => $request->route('nilai'), // Get the ID parameter from the route
            ]);
            return redirect()->back()->with('error', 'Data pengumpulan tugas tidak ditemukan. Gagal memperbarui nilai.');
        }

        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        // Perform the update
        $updated = $pengumpulanTugas->update(['nilai' => $request->nilai]);

        if ($updated) {
            // Log: If update is successful
            Log::info('Nilai berhasil diperbarui.', [
                'pengumpulan_tugas_id' => $pengumpulanTugas->id,
                'nilai_baru' => $pengumpulanTugas->fresh()->nilai, // Get fresh value after update
            ]);
            return redirect()->back()->with('success', 'Nilai berhasil diperbarui!');
        } else {
            // Log: If update fails (even if validation passes)
            Log::warning('Nilai gagal diperbarui di database.', [
                'pengumpulan_tugas_id' => $pengumpulanTugas->id,
                'nilai_yang_dicoba_update' => $request->nilai,
                'pesan' => 'Metode update() mengembalikan false.',
            ]);
            return redirect()->back()->with('error', 'Gagal memperbarui nilai. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus data nilai (mengaturnya menjadi null).
     * Menggunakan Route Model Binding untuk PengumpulanTugas.
     */
    public function destroy(PengumpulanTugas $pengumpulanTugas)
    {
        // Instead of deleting, it's better to set the value to null
        $pengumpulanTugas->update(['nilai' => null]);
        return redirect()->back()->with('success', 'Nilai berhasil dihapus.');
    }
}