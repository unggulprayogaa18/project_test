<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kuis;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BuatKuisController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen kuis.
     */
  
    public function index()
    {
        $guruId = Auth::id();

        // Bagian ini tetap sama
        $kuis = Kuis::where('guru_id', $guruId)
            ->with('mataPelajaran')
            ->latest()
            ->paginate(9);

        // Alternatif untuk mengambil daftar mata pelajaran
        // 1. Ambil ID mata pelajaran yang diajar guru ini dari tabel pivot
        $mapelIds = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', $guruId)
            ->pluck('mata_pelajaran_id') // Hanya ambil kolom mata_pelajaran_id
            ->unique();                  // Pastikan tidak ada duplikat

        // 2. Ambil data lengkap mata pelajaran berdasarkan ID yang didapat
        $mataPelajaranList = MataPelajaran::whereIn('id', $mapelIds)
            ->orderBy('nama_mapel')
            ->get();

        return view('guru.hal_kuis', compact('kuis', 'mataPelajaranList'));
    }
    /**
     * Menyimpan kuis baru beserta soal dan opsinya.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'judul_kuis' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
                'questions' => 'required|array|min:1',
                'questions.*.pertanyaan' => 'required|string',
                'questions.*.options' => 'required|array|size:4',
                'questions.*.options.*' => 'required|string',
                'questions.*.jawaban_benar' => 'required|numeric|between:0,3',
            ]);

            DB::beginTransaction();

            $kuis = Kuis::create([
                'judul_kuis' => $validatedData['judul_kuis'],
                'deskripsi' => $validatedData['deskripsi'],
                'mata_pelajaran_id' => $validatedData['mata_pelajaran_id'],
                'guru_id' => Auth::id(),
            ]);

            foreach ($validatedData['questions'] as $dataSoal) {
                $soal = $kuis->soal()->create([
                    'pertanyaan' => $dataSoal['pertanyaan'],
                    'tipe_soal' => 'pilihan_ganda',
                ]);

                foreach ($dataSoal['options'] as $indexOpsi => $teksOpsi) {
                    $soal->opsiJawaban()->create([
                        'opsi_jawaban' => $teksOpsi,
                        'is_benar' => ($indexOpsi == $dataSoal['jawaban_benar']),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('guru.buatkuis.index')->with('success', 'Kuis baru berhasil dibuat!');

        } catch (ValidationException $e) {
            // Jika validasi gagal, kembali dengan error dan input lama
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat kuis: ' . $e->getMessage());
            // Sertakan pesan error yang lebih spesifik untuk debugging jika mode DEBUG aktif
            $errorMessage = config('app.debug') ? 'Terjadi kesalahan: ' . $e->getMessage() : 'Terjadi kesalahan saat menyimpan kuis. Silakan coba lagi.';
            return redirect()->back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Memperbarui informasi dasar kuis.
     * Nama parameter '$buatkui' HARUS sama dengan nama resource di route.
     */
    public function update(Request $request, Kuis $buatkui)
    {
        if ($buatkui->guru_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $validatedData = $request->validate([
            'judul_kuis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        ]);

        $buatkui->update($validatedData);

        return redirect()->route('guru.buatkuis.index')->with('success', 'Kuis berhasil diperbarui.');
    }

    /**
     * Menghapus kuis.
     * Nama parameter '$buatkui' HARUS sama dengan nama resource di route.
     */
    public function destroy(Kuis $buatkui)
    {
        if ($buatkui->guru_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $buatkui->delete();

        return redirect()->route('guru.buatkuis.index')->with('success', 'Kuis berhasil dihapus.');
    }
}