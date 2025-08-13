<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PengumpulanTugas;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman Laporan yang berisi:
     * 1. Form untuk generate rapor siswa.
     * 2. Hasil rapor jika siswa dipilih.
     * 3. Tabel daftar semua pengguna.
     */
    public function index(Request $request)
    {
        // --- Bagian 1: Logika untuk Daftar Pengguna ---
        $userQuery = User::query()->with('kelas');
        if ($request->filled('role')) {
            $userQuery->where('role', $request->role);
        }
        $users = $userQuery->latest()->get();

        // --- Bagian 2: Data untuk Form Rapor ---
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        // --- Bagian 3: Logika untuk Generate Rapor ---
        $raportData = null;
        $siswa = null;
        $kelas = null;

        if ($request->filled('siswa_id')) {
            $request->validate(['siswa_id' => 'exists:users,id']);

            $siswa = User::with(['kelas.waliKelas'])->findOrFail($request->siswa_id);
            $kelas = $siswa->kelas;

            if ($kelas) {
                $mataPelajarans = $kelas->mataPelajarans()->get();
                $allSubmissions = PengumpulanTugas::with('tugas')
                    ->where('user_id', $siswa->id)
                    ->whereNotNull('nilai')
                    ->get();

                $processedData = [];
                foreach ($mataPelajarans as $mapel) {
                    $submissionsForMapel = $allSubmissions->filter(function ($submission) use ($mapel) {
                        return optional($submission->tugas)->mata_pelajaran_id == $mapel->id;
                    });

                    $totalNilai = $submissionsForMapel->sum('nilai');
                    $jumlahTugas = $submissionsForMapel->count();
                    $rataRata = $jumlahTugas > 0 ? $totalNilai / $jumlahTugas : 0;
                    $guru = User::find($mapel->pivot->guru_id);

                    $processedData[] = [
                        'nama_mapel' => $mapel->nama_mapel,
                        'nama_guru' => $guru->nama ?? 'N/A',
                        'nilai_akhir' => round($rataRata, 2),
                    ];
                }
                $raportData = $processedData;
            }
        }

        // Kirim semua data ke satu view
        return view('admin.laporan.index', compact(
            'users',
            'kelasList',
            'raportData',
            'siswa',
            'kelas'
        ));
    }

    /**
     * Mengambil daftar siswa berdasarkan kelas_id (untuk AJAX).
     * (Method ini tidak perlu diubah)
     */
    public function getSiswaByKelas(Request $request)
    {
        $siswa = User::where('kelas_id', $request->kelas_id)
            ->where('role', 'siswa')
            ->orderBy('nama')
            ->get(['id', 'nama', 'nomor_induk']);
        return response()->json($siswa);
    }
}