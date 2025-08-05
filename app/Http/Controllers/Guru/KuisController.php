<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kuis;
use App\Models\MataPelajaran;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import Log untuk debugging
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class KuisController extends Controller
{
    /**
     * Menampilkan daftar kuis.
     */
    public function index(Request $request)
    {
        // [MODIFIKASI] Eager load relasi soal dan opsi jawabannya juga
        $query = Kuis::query()->with(['mataPelajaran', 'guru', 'soal.opsiJawaban']);

        if ($search = $request->input('search')) {
            $query->where('judul_kuis', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%')
                ->orWhereHas('mataPelajaran', fn($q) => $q->where('nama_mapel', 'like', '%' . $search . '%'))
                ->orWhereHas('guru', fn($q) => $q->where('nama', 'like', '%' . $search . '%'));
        }

        // Ambil kuis milik guru yang sedang login
        $kuis = $query->where('guru_id', Auth::id())->orderBy('created_at', 'desc')->paginate(9);

        $mataPelajaranList = MataPelajaran::orderBy('nama_mapel')->get();

        return view('guru.hal_kuis', compact('kuis', 'mataPelajaranList'));
    }

    /**
     * Menyimpan kuis baru beserta soalnya.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_kuis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'questions' => 'required|array|min:1',
            'questions.*.pertanyaan' => 'required|string',
            'questions.*.options' => 'required|array|size:4',
            'questions.*.options.*' => 'required|string',
            'questions.*.jawaban_benar' => 'required|in:0,1,2,3',
        ], [
            'questions.required' => 'Kuis harus memiliki minimal satu soal.',
            'questions.*.pertanyaan.required' => 'Setiap soal harus diisi.',
            'questions.*.options.*.required' => 'Setiap opsi jawaban harus diisi.',
            'questions.*.jawaban_benar.required' => 'Pilih satu jawaban yang benar untuk setiap soal.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $kuis = Kuis::create([
                'judul_kuis' => $request->judul_kuis,
                'deskripsi' => $request->deskripsi,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'guru_id' => Auth::id(),
            ]);

            foreach ($request->questions as $questionData) {
                $soal = $kuis->soal()->create([
                    'pertanyaan' => $questionData['pertanyaan'],
                ]);

                foreach ($questionData['options'] as $optionIndex => $optionText) {
                    $soal->opsiJawaban()->create([
                        'opsi_jawaban' => $optionText,
                        'is_benar' => ($optionIndex == $questionData['jawaban_benar']),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('guru.buatkuis.index')->with('success', 'Kuis dan soal berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan kuis: ' . $e->getMessage()); // Log error untuk debug
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan kuis. Silakan coba lagi.')->withInput();
        }
    }
    public function lihatHasil(Kuis $kuis)
    {
        // Langkah 1: Cari record 'tugas' yang terhubung dengan kuis ini.
        $tugas = Tugas::where('kuis_id', $kuis->id)->firstOrFail();

        // Langkah 2: Cari data pengumpulan berdasarkan 'tugas_id' dari langkah 1 dan user_id siswa.
        $pengumpulan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Langkah 3: Kirim data yang relevan ke view
        return view('siswa.hasil_kuis', [
            'kuis' => $kuis,
            'tugas' => $tugas,
            'pengumpulan' => $pengumpulan, // Ini yang berisi skor (`nilai`) dan status
        ]);
    }
    /**
     * [MODIFIKASI BESAR] Memperbarui kuis dan soalnya.
     */
    public function update(Request $request, Kuis $buatkui)
    {
        $validator = Validator::make($request->all(), [
            'judul_kuis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|exists:soal_kuis,id', // ID soal yang sudah ada
            'questions.*.pertanyaan' => 'required|string',
            'questions.*.options' => 'required|array|size:4',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.id' => 'nullable|exists:opsi_jawaban_kuis,id', // ID opsi yang sudah ada
            'questions.*.jawaban_benar' => 'required|string', // Bisa berupa ID opsi atau index
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_kuis_id', $buatkui->id);
        }

        DB::beginTransaction();
        try {
            // 1. Update info kuis
            $buatkui->update($request->only('judul_kuis', 'deskripsi', 'mata_pelajaran_id'));

            $soalIdsYangAda = [];

            // 2. Loop melalui soal yang dikirim dari form
            foreach ($request->questions as $questionData) {
                // Tentukan apakah ini soal baru atau update soal lama
                $soal = $buatkui->soal()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null], // Kondisi pencarian
                    ['pertanyaan' => $questionData['pertanyaan']] // Data untuk update/create
                );

                $soalIdsYangAda[] = $soal->id;
                $opsiIdsYangAda = [];

                // 3. Loop melalui opsi jawaban untuk soal ini
                foreach ($questionData['options'] as $optionIndex => $optionData) {
                    // Tentukan jawaban yang benar. Nilai 'jawaban_benar' adalah ID dari opsi yang benar.
                    $isBenar = ($optionData['id'] == $questionData['jawaban_benar']);

                    $opsi = $soal->opsiJawaban()->updateOrCreate(
                        ['id' => $optionData['id'] ?? null], // Kondisi pencarian
                        [
                            'opsi_jawaban' => $optionData['text'],
                            'is_benar' => $isBenar
                        ] // Data untuk update/create
                    );
                    $opsiIdsYangAda[] = $opsi->id;
                }

                // 4. Hapus opsi lama yang tidak ada di request (jika ada)
                $soal->opsiJawaban()->whereNotIn('id', $opsiIdsYangAda)->delete();
            }

            // 5. Hapus soal lama yang tidak ada di request (jika ada)
            $buatkui->soal()->whereNotIn('id', $soalIdsYangAda)->delete();

            DB::commit();
            return redirect()->route('guru.buatkuis.index')->with('success', 'Kuis berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating kuis #{$buatkui->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kuis: ' . $e->getMessage())->with('error_kuis_id', $buatkui->id);
        }
    }

    /**
     * Menghapus kuis.
     */
    public function destroy(Kuis $buatkui)
    {
        try {
            // Transaksi database tidak wajib di sini, tapi bagus untuk konsistensi
            DB::transaction(function () use ($buatkui) {
                // Relasi di database (ON DELETE CASCADE) akan menghapus soal dan opsi secara otomatis
                $buatkui->delete();
            });
            return redirect()->route('guru.buatkuis.index')->with('success', 'Kuis berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error("Gagal hapus kuis #{$buatkui->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kuis.');
        }
    }
}