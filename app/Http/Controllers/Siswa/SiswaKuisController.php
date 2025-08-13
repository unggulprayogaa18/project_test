<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kuis;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiswaKuisController extends Controller
{

    public function showProfil()
{
    // [ALTERNATIF] Ambil user dan relasi 'profile' dalam satu query
    $user = User::with('profile')->find(Auth::id());

    // Jika user tidak ditemukan (meskipun jarang terjadi jika sudah login), arahkan ke halaman login
    if (!$user) {
        return redirect()->route('login')->with('sweet_error', 'Sesi tidak valid, silakan login kembali.');
    }
    
    return view('siswa.profil', compact('user'));
}
    /**
     * Memperbarui data profil siswa.
     */
   public function updateProfil(Request $request)
{
    // [PERBAIKAN 1] Ambil user dari model User secara langsung.
    // Ini memastikan variabel $user dikenali sebagai instance Eloquent Model oleh editor.
    $user = User::find(Auth::id());

    // Validasi input form (tetap sama)
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'alamat' => 'nullable|string|max:255',
        'no_telepon' => 'nullable|string|max:15',
        'tanggal_lahir' => 'nullable|date',
        'password' => ['nullable', 'confirmed', Password::min(8)],
        'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // [PERBAIKAN 2] Menggunakan metode update() yang lebih ringkas.
    $userData = $request->only(['nama', 'email']);
    if ($request->filled('password')) {
        $userData['password'] = Hash::make($request->password);
    }
    $user->update($userData);

    // [PERBAIKAN 3] Logika untuk data profil dan foto disederhanakan.
    $profileData = $request->only(['alamat', 'no_telepon', 'tanggal_lahir']);

    if ($request->hasFile('foto_profil')) {
        // Hapus foto lama jika ada
        if ($user->profile && $user->profile->foto_profil) {
            Storage::disk('public')->delete($user->profile->foto_profil);
        }
        // Simpan foto baru dan tambahkan path ke data profil
        $profileData['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
    }

    // [PERBAIKAN 4] Metode updateOrCreate tetap cara terbaik untuk tabel profile.
    $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);

    return redirect()->route('siswa.profil.show')
        ->with('sweet_success', 'Profil Anda berhasil diperbarui!');
}


        private function fisherYatesShuffle($items)
    {
        // Konversi ke array jika input adalah Collection
        $array = is_array($items) ? $items : $items->all();
        $count = count($array);

        for ($i = $count - 1; $i > 0; $i--) {
            $j = random_int(0, $i); // Pilih indeks acak dari 0 sampai $i
            
            // Tukar elemen pada indeks $i dengan elemen pada indeks acak $j
            $temp = $array[$i];
            $array[$i] = $array[$j];
            $array[$j] = $temp;
        }

        // Kembalikan ke tipe data semula (Collection atau array)
        return is_a($items, 'Illuminate\Support\Collection') ? collect($array) : $array;
    }

    /**
     * Menampilkan halaman pengerjaan kuis untuk siswa.
     */
    public function kerjakanKuis(Kuis $kuis)
    {
        // Eager load relasi yang dibutuhkan
        $kuis->load('soal.opsiJawaban');

        // ================== LOGIKA PENGACAKAN DIMULAI DI SINI ==================

        // 1. Acak urutan soal menggunakan Fisher-Yates
        $soalDiacak = $this->fisherYatesShuffle($kuis->soal);
        
        // 2. Untuk setiap soal yang sudah diacak, acak juga opsi jawabannya
        $soalDiacak->each(function ($soal) {
            $opsiDiacak = $this->fisherYatesShuffle($soal->opsiJawaban);
            // Ganti relasi opsi jawaban pada soal dengan yang sudah diacak
            $soal->setRelation('opsiJawaban', $opsiDiacak);
        });

        // 3. Ganti relasi soal pada kuis dengan yang sudah diacak
        $kuis->setRelation('soal', $soalDiacak);

        // ================== LOGIKA PENGACAKAN SELESAI ==================

        // Logika validasi Anda (tetap sama dan sudah benar)
        $tugas = Tugas::where('kuis_id', $kuis->id)->first();
        $siswaId = Auth::id();

        if (!$tugas) {
            return redirect()->route('siswa.dashboard')->with('sweet_error', 'Tugas tidak ditemukan.');
        }

        $pengumpulan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('user_id', $siswaId)
            ->first();

        if ($pengumpulan) {
            return redirect()->route('siswa.dashboard')->with('sweet_info', 'Anda sudah mengerjakan kuis ini.');
        }

        if ($tugas->batas_waktu->isPast()) {
            return redirect()->route('siswa.dashboard')
                ->with('sweet_error', 'Waktu pengerjaan untuk kuis ini telah berakhir!');
        }

        Log::info("Siswa ID: {$siswaId} mengakses halaman pengerjaan untuk Kuis ID: {$kuis->id}.");
        
        // Kirim data kuis yang soalnya sudah teracak ke view
        return view('siswa.kuis_kerjakan', compact('kuis', 'tugas'));
    }
    /**
     * Menyimpan jawaban kuis dari siswa.
     */
    public function simpanJawaban(Request $request, Kuis $kuis)
    {
        $siswaId = Auth::id();
        $validator = Validator::make($request->all(), [
            'tugas_id' => 'required|exists:tugas,id',
            'answers' => 'required|array',
            'answers.*' => 'required|exists:opsi_jawaban_kuis,id',
        ], [
            'answers.required' => 'Anda harus menjawab semua pertanyaan.',
            'answers.*.required' => 'Setiap pertanyaan harus dijawab.',
        ]);

        if ($validator->fails()) {
            // LOG: Mencatat kegagalan validasi saat siswa mengirimkan jawaban.
            Log::warning("Validasi Gagal: Siswa ID: {$siswaId} gagal menyimpan jawaban Kuis ID: {$kuis->id}.", $validator->errors()->toArray());

            $kuis->load('soal.opsiJawaban');
            $tugas = Tugas::find($request->tugas_id);

            if (!$tugas) {
                // LOG: Mencatat error kritis jika tugas tidak ditemukan setelah validasi gagal.
                Log::error("FATAL: Tugas ID: {$request->tugas_id} tidak ditemukan setelah validasi gagal untuk Siswa ID: {$siswaId}.");
                return redirect()->route('siswa.tugas.index')->with('error', 'Terjadi kesalahan: Tugas tidak dapat ditemukan saat validasi.');
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(compact('kuis', 'tugas'));
        }

        $tugas = Tugas::findOrFail($request->tugas_id);

        $pengumpulanExist = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('user_id', $siswaId)
            ->exists();
        if ($pengumpulanExist || $tugas->batas_waktu->isPast()) {
            // LOG: Mencatat percobaan pengumpulan ganda atau terlambat.
            Log::warning("Submit Ditolak: Percobaan submit ganda/terlambat untuk Tugas ID: {$tugas->id} oleh Siswa ID: {$siswaId}.");
            return redirect()->route('siswa.tugas.index')->with('error', 'Tidak dapat menyimpan jawaban. Kuis sudah dikerjakan atau waktu telah habis.');
        }

        DB::beginTransaction();
        try {
            $soalDenganJawabanBenar = $kuis->soal()->with('opsiJawaban')->get();
            $jawabanBenarMap = [];
            foreach ($soalDenganJawabanBenar as $soal) {
                $jawabanBenar = $soal->opsiJawaban->firstWhere('is_benar', true);
                if ($jawabanBenar) {
                    $jawabanBenarMap[$soal->id] = $jawabanBenar->id;
                }
            }

            $jawabanSiswa = $request->answers;
            $skor = 0;
            foreach ($jawabanSiswa as $soalId => $opsiId) {
                if (isset($jawabanBenarMap[$soalId]) && $jawabanBenarMap[$soalId] == $opsiId) {
                    $skor++;
                }
            }

            $totalSoal = $soalDenganJawabanBenar->count();
            $nilaiAkhir = ($totalSoal > 0) ? ($skor / $totalSoal) * 100 : 0;

            PengumpulanTugas::create([
                'tugas_id' => $tugas->id,
                'user_id' => $siswaId,
                'status' => 'dikerjakan',
                'nilai' => $nilaiAkhir,
                'catatan' => 'Kuis dikerjakan secara online.',
            ]);

            DB::commit();

            // LOG: Mencatat keberhasilan pengumpulan kuis.
            Log::info("Submit Berhasil: Siswa ID: {$siswaId} berhasil mengumpulkan Tugas ID: {$tugas->id} dengan nilai {$nilaiAkhir}.");
            return redirect()->route('siswa.tugas.index')->with('success', 'Kuis berhasil dikumpulkan! Nilai Anda: ' . round($nilaiAkhir));

        } catch (\Exception $e) {
            DB::rollBack();
            // LOG: Mencatat error tak terduga saat proses penyimpanan.
            Log::error("Gagal Simpan Jawaban: Terjadi exception untuk Siswa ID: {$siswaId} pada Tugas ID: {$tugas->id}. Pesan: " . $e->getMessage());

            $kuis->load('soal.opsiJawaban');

            if (!$tugas) {
                return redirect()->route('siswa.tugas.index')->with('error', 'Terjadi kesalahan fatal: Tugas tidak dapat ditemukan saat terjadi error server.');
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan internal saat menyimpan jawaban. Silakan coba lagi.')
                ->withInput()
                ->with(compact('kuis', 'tugas'));
        }
    }
   
}
