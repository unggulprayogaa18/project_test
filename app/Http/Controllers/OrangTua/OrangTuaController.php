<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // <-- Pastikan ini ada

class OrangTuaController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk orang tua.
     * Dashboard akan menampilkan informasi ringkas tentang anak mereka.
     */
    public function dashboard()
    {
        $orangTua = Auth::user();
        // Cari data anak secara eksplisit menggunakan model User
        $anak = User::where('orang_tua_id', $orangTua->id)->with('kelas')->first();

        if (!$anak) {
            return view('orangtua.dashboard_no_anak');
        }

        return view('orangtua.dashboard', compact('orangTua', 'anak'));
    }

    /**
     * Menampilkan halaman detail perkembangan anak.
     * Halaman ini bisa berisi nilai, absensi, dll.
     */
    public function lihatAnak()
    {
        $orangTua = Auth::user();

        // Ambil ID orang tua yang sedang login
        $orangTuaId = $orangTua->id;

        // Cari data anak menggunakan kueri statis pada model User
        $anak = User::where('orang_tua_id', $orangTuaId)->with([
            'kelas',
            'kelas.waliKelas',
            'nilai.mataPelajaran',
            'nilai.guru',
            'presensi.mataPelajaran',
            'pengumpulanTugas.tugas.mataPelajaran',
            'pengumpulanTugas.tugas.guru',
        ])->first();

        if (!$anak) {
            Log::warning('Dashboard Orang Tua: Data anak tidak ditemukan.', ['orang_tua_id' => $orangTua->id]);
            abort(404, 'Data siswa tidak ditemukan.');
        }

        Log::debug('Dashboard Orang Tua: Anak Ditemukan', ['anak_id' => $anak->id, 'anak_nama' => $anak->nama]);

        // --- Logika Tambahan untuk Ringkasan Absensi ---
        $rekapAbsensi = $anak->presensi
            ->groupBy('status')
            ->map->count();

        $tanggalMulai = Carbon::now()->subDays(30)->toDateString();
        $presensiTerbaru = $anak->presensi()
            ->whereDate('tanggal', '>=', $tanggalMulai)
            ->orderBy('tanggal', 'desc')
            ->get();

        // --- Logika Tambahan untuk Ringkasan Nilai Umum ---
        $rataRataNilaiPerMapel = $anak->nilai
            ->groupBy('mataPelajaran.nama_mapel')
            ->map(function ($items) {
                return $items->avg('nilai');
            });

        $nilaiTerbaru = $anak->nilai()->latest()->take(5)->get();


        // --- Logika Baru untuk Rata-rata Nilai Pengumpulan Tugas dan Grade ---
        $totalNilaiTugas = 0;
        $jumlahTugasDinilai = 0;
        $persentaseNilaiTugas = 0;
        $gradeTugas = 'N/A'; // Default grade

        // Dapatkan SEMUA pengumpulan tugas untuk anak ini
        $allPengumpulanTugas = $anak->pengumpulanTugas;
        Log::debug('Dashboard Orang Tua: Semua Pengumpulan Tugas', ['count' => $allPengumpulanTugas->count(), 'data' => $allPengumpulanTugas->toArray()]);


        // Filter pengumpulan tugas yang sudah dinilai dan punya nilai
        $dinilaiTugas = $allPengumpulanTugas->filter(function ($pengumpulan) {
            $isDinilai = $pengumpulan->status == 'dikerjakan';
            $hasNilai = !is_null($pengumpulan->nilai);
            Log::debug('Dashboard Orang Tua: Filtering Pengumpulan Tugas', [
                'tugas_id' => $pengumpulan->id,
                'status' => $pengumpulan->status,
                'nilai' => $pengumpulan->nilai,
                'is_dinilai_status' => $isDinilai,
                'has_nilai' => $hasNilai,
                'keep_this_task' => $isDinilai && $hasNilai
            ]);
            return $isDinilai && $hasNilai;
        });

        Log::debug('Dashboard Orang Tua: Pengumpulan Tugas yang Dinilai (Filtered)', ['count' => $dinilaiTugas->count(), 'data' => $dinilaiTugas->toArray()]);


        if ($dinilaiTugas->isNotEmpty()) {
            $totalNilaiTugas = $dinilaiTugas->sum('nilai');
            $jumlahTugasDinilai = $dinilaiTugas->count();

            // Asumsi nilai maksimal per tugas adalah 100.
            // Persentase adalah rata-rata nilai dari tugas yang dinilai.
            if ($jumlahTugasDinilai > 0) {
                $persentaseNilaiTugas = ($totalNilaiTugas / $jumlahTugasDinilai);
            }

            Log::debug('Dashboard Orang Tua: Perhitungan Nilai Tugas', [
                'total_nilai_tugas' => $totalNilaiTugas,
                'jumlah_tugas_dinilai' => $jumlahTugasDinilai,
                'persentase_nilai_tugas' => $persentaseNilaiTugas
            ]);

            // Tentukan Grade
            if ($persentaseNilaiTugas >= 90) {
                $gradeTugas = 'A';
            } elseif ($persentaseNilaiTugas >= 80) {
                $gradeTugas = 'B';
            } elseif ($persentaseNilaiTugas >= 70) {
                $gradeTugas = 'C';
            } elseif ($persentaseNilaiTugas >= 60) {
                $gradeTugas = 'D';
            } else {
                $gradeTugas = 'E';
            }
            Log::debug('Dashboard Orang Tua: Grade Tugas Ditetapkan', ['grade' => $gradeTugas]);

        } else {
            Log::debug('Dashboard Orang Tua: Tidak ada tugas yang dinilai untuk perhitungan grade.');
        }

        // Ambil 5 tugas terbaru dari SEMUA pengumpulan tugas untuk tabel di bawah (tanpa filter status)
        $tugasTerbaru = $anak->pengumpulanTugas()->with('tugas.mataPelajaran')->latest()->take(5)->get();


        return view('orangtua.anak.show', compact(
            'orangTua',
            'anak',
            'rekapAbsensi',
            'presensiTerbaru',
            'rataRataNilaiPerMapel',
            'nilaiTerbaru',
            'tugasTerbaru',
            'totalNilaiTugas',
            'persentaseNilaiTugas',
            'gradeTugas',
            'jumlahTugasDinilai'
        ));
    }
}