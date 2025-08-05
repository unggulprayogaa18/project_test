<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Menampilkan halaman absensi dengan filter dan daftar siswa.
     */
    public function index(Request $request)
    {
        // Ambil data untuk filter
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();

        $siswaList = collect(); // Default koleksi kosong
        $selectedKelasId = $request->input('kelas_id');
        $selectedTanggal = $request->input('tanggal');

        // Jika filter kelas dan tanggal dipilih, tampilkan siswa
        if ($selectedKelasId && $selectedTanggal) {
            $kelas = Kelas::findOrFail($selectedKelasId);

            // Ambil siswa yang terdaftar di kelas tersebut
            // dan eager load absensi mereka pada tanggal dan mapel yang dipilih
            $siswaList = $kelas->siswas()->orderBy('nama')
                ->with([
                    'absensi' => function ($query) use ($selectedTanggal) {
                        $query->where('tanggal', $selectedTanggal);
                    }
                ])->get();
        }

        return view('guru.hal_absensi', compact(
            'kelasList',
            'mataPelajaranList',
            'siswaList',
            'selectedKelasId',
            'selectedTanggal'
        ));
    }

    /**
     * Menyimpan data absensi (bisa untuk banyak siswa sekaligus).
     * Ini lebih efisien daripada modal per siswa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'absensi.*.siswa_id' => 'required|exists:users,id',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        foreach ($request->absensi as $data) {
            // Gunakan updateOrCreate untuk membuat atau memperbarui absensi
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $data['siswa_id'],
                    'tanggal' => $request->tanggal,
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                ],
                [
                    'status' => $data['status'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan!');
    }

    /**
     * Menghapus data absensi spesifik.
     */
    public function destroy(Absensi $absensi)
    {
        try {
            $absensi->delete();
            return redirect()->back()->with('success', 'Data absensi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data absensi.');
        }
    }
}