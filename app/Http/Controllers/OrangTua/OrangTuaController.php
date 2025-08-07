<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrangTuaController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk orang tua.
     */
    public function dashboard()
    {
        $orangTua = Auth::user();
        $anak = User::where('orang_tua_id', $orangTua->id)->with('kelas')->first();

        if (!$anak) {
            return view('orangtua.dashboard_no_anak');
        }

        return view('orangtua.dashboard', compact('orangTua', 'anak'));
    }

    /**
     * Menampilkan halaman detail perkembangan anak.
     */
    public function lihatAnak()
    {
        $orangTua = Auth::user();
        $orangTuaId = $orangTua->id;

        // Cari data anak dengan semua relasi yang dibutuhkan
        $anak = User::where('orang_tua_id', $orangTuaId)->with([
            'kelas.waliKelas',
            'nilai.mataPelajaran',
            'nilai.guru',
            'presensi.mataPelajaran',
            'pengumpulanTugas.tugas.mataPelajaran',
            'pengumpulanTugas.tugas.guru',
        ])->first();

        if (!$anak) {
            abort(404, 'Data siswa tidak ditemukan.');
        }

        // --- LOGIKA ABSENSI YANG DIPERBAIKI ---
        // 1. Ambil data presensi dalam 30 hari terakhir TERLEBIH DAHULU
        $presensiTerbaru = $anak->presensi()
            ->where('tanggal', '>=', Carbon::now()->subDays(30))
            ->orderBy('tanggal', 'desc')
            ->get();

        // 2. BUAT REKAPITULASI BERDASARKAN DATA YANG SUDAH DIFILTER (CASE-INSENSITIVE)
        $rekapAbsensi = $presensiTerbaru->groupBy(function($item) {
            return strtolower($item->status); // Mengelompokkan berdasarkan status huruf kecil
        })->map->count();
        // --- AKHIR PERBAIKAN ---

        // --- Logika untuk Ringkasan Nilai Akademik ---
        $rataRataNilaiPerMapel = $anak->nilai
            ->groupBy('mataPelajaran.nama_mapel')
            ->map(fn ($items) => $items->avg('nilai'));

        $nilaiTerbaru = $anak->nilai()->latest()->take(5)->get();

        // --- Logika untuk Rata-rata Nilai Tugas dan Grade ---
        $dinilaiTugas = $anak->pengumpulanTugas->filter(fn ($p) => !is_null($p->nilai));
        
        $jumlahTugasDinilai = $dinilaiTugas->count();
        $persentaseNilaiTugas = $jumlahTugasDinilai > 0 ? $dinilaiTugas->avg('nilai') : 0;
        
        // Tentukan Grade
        $gradeTugas = 'N/A';
        if ($jumlahTugasDinilai > 0) {
            if ($persentaseNilaiTugas >= 90) $gradeTugas = 'A';
            elseif ($persentaseNilaiTugas >= 80) $gradeTugas = 'B';
            elseif ($persentaseNilaiTugas >= 70) $gradeTugas = 'C';
            elseif ($persentaseNilaiTugas >= 60) $gradeTugas = 'D';
            else $gradeTugas = 'E';
        }

        // Ambil 5 tugas terbaru untuk ditampilkan di tabel
        $tugasTerbaru = $anak->pengumpulanTugas()->with('tugas.mataPelajaran')->latest()->take(5)->get();

        return view('orangtua.anak.show', compact(
            'orangTua',
            'anak',
            'rekapAbsensi',
            'presensiTerbaru',
            'rataRataNilaiPerMapel',
            'nilaiTerbaru',
            'tugasTerbaru',
            'persentaseNilaiTugas',
            'gradeTugas',
            'jumlahTugasDinilai'
        ));
    }
}