<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\Nilai;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class SiswaController extends Controller
{
    public function hal_materiSiswa()
    {
        // Bisa ambil data pelajaran dari database, kalau ada
        // $mataPelajaran = MataPelajaran::all();
        return view('siswa.hal_materi_siswa'); // Buat view-nya nanti
    }


    public function indexPresensi(Request $request)
    {
        $user = Auth::user();

        // Query untuk mengambil data absensi siswa (ini sudah benar)
        $query = Absensi::query()
            ->where('siswa_id', $user->id)
            ->with('mataPelajaran');

        // Terapkan filter jika ada input 'mata_pelajaran_id'
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        $riwayatPresensi = $query->orderBy('tanggal', 'desc')->get();

        // --- FIX v2: Mengambil mata pelajaran dengan cara yang lebih andal ---
        // Alur: User -> Kelas -> MataPelajaran
        // 1. Ambil data kelas siswa, beserta relasi mata pelajarannya.
        $mataPelajaranOptions = MataPelajaran::orderBy('nama_mapel')->get();

        // 7. Kirim data ke view
        return view('siswa.hal_absensi', compact('user', 'riwayatPresensi', 'mataPelajaranOptions'));
    }


    /**
     * Menampilkan halaman daftar semua tugas dan ujian siswa.
     * @return \Illuminate\View\View
     */
    public function indexTugas()
    {
        $siswa = User::with('kelas.mataPelajarans')->find(Auth::id());

        // Validasi bahwa pengguna adalah siswa dan benar-benar terdaftar di sebuah kelas.
        if (!$siswa || !$siswa->kelas) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data kelas Anda tidak ditemukan. Harap hubungi administrator.');
        }

        // Ambil ID semua mata pelajaran dari relasi yang sudah di-load.
        // Tidak perlu query tambahan ke database.
        $mapelIds = $siswa->kelas->mataPelajarans->pluck('id');

        // Ambil semua tugas yang sesuai dengan mata pelajaran siswa.
        // Eager load relasi untuk mengurangi query N+1 di view.
        $tugasList = Tugas::with([
            'mataPelajaran',
            'guru',
            'pengumpulan' => function ($query) use ($siswa) {
                $query->where('user_id', $siswa->id);
            }
        ])
            ->whereIn('mata_pelajaran_id', $mapelIds)
            ->orderBy('batas_waktu', 'asc') // Urutkan berdasarkan deadline terdekat
            ->paginate(9); // Paginate untuk membatasi jumlah kartu per halaman

        // Kirim data tugas ke view.  '' => $siswa,

        $user = $siswa;
        return view('siswa.hal_tugas_siswa', compact('tugasList','user'));
    }

    /**
     * Menampilkan halaman daftar semua materi pembelajaran.
     * @return \Illuminate\View\View
     */
    public function indexMateri(Request $request)
    {
        $siswa = User::with('kelas.mataPelajarans')->find(Auth::id());

        if (!$siswa || !$siswa->kelas) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data kelas Anda tidak ditemukan.');
        }

        // Ambil daftar mata pelajaran siswa untuk dropdown filter
        $mataPelajarans = $siswa->kelas->mataPelajarans()->orderBy('nama_mapel')->get();
        $mapelIds = $mataPelajarans->pluck('id');

        // Query dasar untuk materi
        $materiQuery = Materi::with('mataPelajaran')
            ->whereIn('mata_pelajaran_id', $mapelIds);

        // Terapkan filter pencarian berdasarkan judul
        if ($request->has('search') && $request->search != '') {
            $materiQuery->where('judul', 'like', '%' . $request->search . '%');
        }

        // Terapkan filter berdasarkan mata pelajaran
        if ($request->has('mata_pelajaran_id') && $request->mata_pelajaran_id != '') {
            $materiQuery->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        // Ambil hasil dengan paginasi
        $materis = $materiQuery->latest()->paginate(12);

        return view('siswa.hal_materi_siswa', [
            'materis' => $materis,
            'mataPelajarans' => $mataPelajarans,
            'request' => $request,
            'user' => $siswa, // Kirim request untuk mempertahankan nilai filter di view
        ]);
    }

    /**
     * Menampilkan halaman rekapitulasi nilai siswa.
     * @return \Illuminate\View\View
     */
    public function indexNilai(Request $request)
    {


        $siswa = Auth::user(); // User yang sedang login adalah siswa

        // Pastikan siswa memiliki kelas
        if (!$siswa->kelas) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data kelas Anda tidak ditemukan.');
        }

        // Ambil semua mata pelajaran yang terkait dengan kelas siswa untuk filter dropdown
        $mataPelajarans = $siswa->kelas->mataPelajarans()->orderBy('nama_mapel')->get();

        // --- PERUBAHAN UTAMA DIMULAI DI SINI ---

        // Query dasar untuk mengambil pengumpulan tugas yang sudah dinilai.
        $nilaiQuery = PengumpulanTugas::query()
            ->where('user_id', $siswa->id) // Hanya untuk siswa yang login
            ->whereNotNull('nilai')      // Hanya yang sudah ada nilainya
            ->with(['tugas.mataPelajaran']); // Eager load relasi untuk efisiensi

        // Terapkan filter berdasarkan mata pelajaran jika ada
        if ($request->filled('mata_pelajaran_id')) {
            $mapelId = $request->mata_pelajaran_id;
            // Filter nilai yang tugasnya terkait dengan mata pelajaran tertentu
            $nilaiQuery->whereHas('tugas', function ($query) use ($mapelId) {
                $query->where('mata_pelajaran_id', $mapelId);
            });
        }

        // Ambil data nilai dengan paginasi, urutkan berdasarkan tanggal dinilai (updated_at)
        // Kita gunakan 'updated_at' karena ini merefleksikan kapan guru terakhir kali mengubah (memberi nilai)
        $nilais = $nilaiQuery->latest('updated_at')->paginate(15);

        // Ganti nama variabel $nilais menjadi $pengumpulanTugas agar lebih deskriptif
        return view('siswa.hal_nilai_siswa', [
            'nilais' => $nilais, // Tetap gunakan 'nilais' karena view sudah memakai variabel ini
            'mataPelajarans' => $mataPelajarans,
            'request' => $request,
            'user' => $siswa,
            // Mengirim objek request untuk mempertahankan filter di pagination
        ]);
    }


    /**
     * Menampilkan detail kelas siswa, termasuk daftar teman sekelas.
     * @return \Illuminate\View\View
     */
    public function showKelas()
    {
        $siswa = Auth::user();

        // Validasi bahwa pengguna adalah siswa dan terdaftar di sebuah kelas.
        if (!$siswa->kelas_id) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data kelas Anda tidak ditemukan. Harap hubungi administrator.');
        }

        // Ambil data kelas beserta relasi yang dibutuhkan (wali kelas, siswa, mata pelajaran, dan guru pengampu)
        $kelas = \App\Models\Kelas::with([
            'waliKelas',
            'siswas' => function ($query) {
                $query->orderBy('nama', 'asc');
            },
            'mataPelajarans.gurus'
        ])
            ->find($siswa->kelas_id);

        if (!$kelas) {
            return redirect()->route('siswa.dashboard')->with('error', 'Gagal memuat data kelas.');
        }

        // Kirim data ke view
        return view('siswa.hal_kelas_saya', [
            'kelas' => $kelas,
            'user' => $siswa,
        ]);
    }
    /**
     * Menampilkan detail satu materi pembelajaran.
     * @param  \App\Models\Materi $materi (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function showMateri(Materi $materi)
    {
        $user = Auth::user();
        return view('siswa.materi.show', compact('user', 'materi'));
    }

    /**
     * Menampilkan halaman untuk mengerjakan tugas atau kuis.
     * @param  \App\Models\Tugas $tugas (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function kerjakanTugas(Tugas $tugas)
    {
        $user = Auth::user();
        $tugas->load('pengumpulan', 'mataPelajaran');
        // ...
        // Eager load pengumpulan

        // Cek apakah siswa sudah pernah mengumpulkan tugas ini
        $pengumpulan = $tugas->pengumpulan()->where('user_id', $user->id)->first();

        // Cek apakah batas waktu sudah lewat
        if ($tugas->batas_waktu < now() && !$pengumpulan) {
            return redirect()->route('siswa.tugas.show', $tugas->id)->with('error', 'Waktu pengumpulan tugas telah berakhir.');
        }
        $jam = now('Asia/Jakarta')->format('H');
        $sapaan = "Selamat datang"; // Default greeting

        if ($jam >= 5 && $jam < 11) {
            $sapaan = "Selamat pagi";
        } elseif ($jam >= 11 && $jam < 15) {
            $sapaan = "Selamat siang";
        } elseif ($jam >= 15 && $jam < 18) {
            $sapaan = "Selamat sore";
        } else {
            $sapaan = "Selamat malam";
        }
        return view('siswa.tugas_kerjakan', compact('user', 'tugas', 'pengumpulan', 'sapaan'));
    }


    /**
     * !! FUNGSI BARU UNTUK MENYIMPAN PENGUMPULAN TUGAS !!
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\RedirectResponse
     */
      public function kumpulkanTugas(Request $request, Tugas $tugas)
    {
        $user = Auth::user();

        // 1. Otorisasi (kode ini sudah benar)
        $mapelIdsSiswa = $user->kelas->mataPelajarans()->pluck('mata_pelajarans.id')->toArray();
        if (!in_array($tugas->mata_pelajaran_id, $mapelIdsSiswa)) {
            abort(403, 'Anda tidak berhak mengumpulkan tugas ini.');
        }

        // 2. Validasi Input (kode ini sudah benar)
        $request->validate([
            'file_tugas' => 'required|file|mimes:pdf,doc,docx,zip,rar,jpg,png|max:10240', // Maks 10MB
            'catatan_siswa' => 'nullable|string|max:1000',
        ]);

        // Memulai blok try-catch untuk menangani potensi error
        try {
            // Memulai transaksi database
            DB::transaction(function () use ($request, $tugas, $user) {
                // Cari pengumpulan yang sudah ada
                $pengumpulanLama = PengumpulanTugas::where('tugas_id', $tugas->id)
                                                   ->where('user_id', $user->id)
                                                   ->first();

                // Hapus file lama jika ada pengumpulan ulang
                if ($pengumpulanLama && $pengumpulanLama->file_path) {
                    Storage::disk('public')->delete($pengumpulanLama->file_path);
                }

                // Proses upload file baru
                $file = $request->file('file_tugas');
                $namaFileBaru = \Illuminate\Support\Str::slug($user->nama . ' ' . $tugas->judul) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pengumpulan_tugas/' . $tugas->id, $namaFileBaru, 'public');

                // Simpan atau perbarui data pengumpulan tugas
                $pengumpulanBaru = PengumpulanTugas::updateOrCreate(
                    [
                        'tugas_id' => $tugas->id,
                        'user_id'  => $user->id,
                    ],
                    [
                        'file_path'         => $path,
                        'catatan'           => $request->catatan_siswa,
                        'status'            => 'dikerjakan',
                        'waktu_pengumpulan' => now(),
                        'nilai'             => null, // Reset nilai saat submit ulang
                    ]
                );

                // Buat log aktivitas (jika Anda menggunakan sistem log)
              
            });

            // Jika semua proses dalam transaksi berhasil, redirect dengan pesan sukses
            return redirect()->route('siswa.tugas.show', $tugas->id)
                             ->with('success', 'Tugas berhasil dikumpulkan!');

        } catch (\Exception $e) {
            // Jika terjadi error di dalam blok try, tangkap di sini

            // 1. Catat error detail ke file log sistem untuk developer
            Log::error('Gagal saat mengumpulkan tugas: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'tugas_id' => $tugas->id,
                'trace' => $e->getTraceAsString() // Untuk debugging mendalam
            ]);

            // 2. Kembalikan pengguna ke halaman sebelumnya dengan pesan error yang ramah
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan pada sistem. Gagal mengumpulkan tugas, silakan coba beberapa saat lagi.')
                             ->withInput(); // Mengembalikan input sebelumnya (seperti catatan)
        }
    }
    /**
     * Menampilkan hasil dari tugas atau kuis yang telah dikerjakan.
     * @param  \App\Models\Tugas $tugas (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function hasilTugas(Tugas $tugas)
    {
        $user = Auth::user();

        // Ganti baris '$pengumpulan = null;' dengan logika ini:
        // Cari data pengumpulan tugas oleh siswa yang login untuk tugas spesifik ini.
        // firstOrFail() akan menghasilkan error 404 jika data tidak ditemukan,
        // yang lebih baik daripada error 'property on null'.
        $pengumpulan = PengumpulanTugas::where('user_id', $user->id)
            ->where('tugas_id', $tugas->id)
            ->firstOrFail();

        return view('siswa.hasil_tugas', compact('user', 'tugas', 'pengumpulan'));
    }
    public function showTugas(Tugas $tugas)
    {
        $siswa = Auth::user();

        // --- Validasi Otorisasi ---
        // 1. Dapatkan daftar ID mata pelajaran yang diikuti siswa di kelasnya.
        // [FIX] Specify the table name 'mata_pelajarans.id' to avoid ambiguous column error.
        $mapelIdsSiswa = $siswa->kelas->mataPelajarans()->pluck('mata_pelajarans.id')->toArray();

        // 2. Periksa apakah mata pelajaran tugas ini ada di dalam daftar mata pelajaran siswa.
        if (!in_array($tugas->mata_pelajaran_id, $mapelIdsSiswa)) {
            // Jika tidak, siswa tidak berhak mengakses.
            // Abort dengan halaman 403 Forbidden.
            abort(403, 'ANDA TIDAK BERHAK MENGAKSES TUGAS INI.');
        }

        // Eager load relasi yang dibutuhkan untuk ditampilkan di view
        $tugas->load(['mataPelajaran', 'materi', 'kuis']);

        // Cek status pengumpulan tugas oleh siswa yang sedang login
        $pengumpulan = $tugas->pengumpulan()->where('user_id', $siswa->id)->first();

        // Kirim data ke view
        return view('siswa.hal_detail_tugas', [
            'user' => $siswa,
            'tugas' => $tugas,
            'pengumpulan' => $pengumpulan,
        ]);
    }
    /**
     * Menampilkan halaman profil siswa.
     * @return \Illuminate\View\View
     */
    public function showProfil()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('profile', 'kelas');
        return view('siswa.profil_show', compact('user'));
    }

    /**
     * Memperbarui data profil siswa.
     */
    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'tanggal_lahir' => 'nullable|date',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Update data di tabel 'users'
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->username = $request->username;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update atau buat data di tabel 'profiles'
        $profileData = [
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
        ];

        // Handle upload foto profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->profile && $user->profile->foto_profil) {
                Storage::disk('public')->delete($user->profile->foto_profil);
            }
            // Simpan foto baru dan dapatkan path-nya
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $profileData['foto_profil'] = $path;
        }

        $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);

        return redirect()->route('siswa.profil.show')->with('success', 'Profil berhasil diperbarui!');
    }

    public function hal_tugasSiswa()
    {

        $siswa = User::with('kelas.mataPelajarans')->find(Auth::id());

        // Validasi bahwa pengguna adalah siswa dan benar-benar terdaftar di sebuah kelas.
        if (!$siswa || !$siswa->kelas) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data kelas Anda tidak ditemukan. Harap hubungi administrator.');
        }

        // Ambil ID semua mata pelajaran dari relasi yang sudah di-load.
        // Tidak perlu query tambahan ke database.
        $mapelIds = $siswa->kelas->mataPelajarans->pluck('id');

        // Ambil semua tugas yang sesuai dengan mata pelajaran siswa.
        // Eager load relasi untuk mengurangi query N+1 di view.
        $tugasList = Tugas::with([
            'mataPelajaran',
            'guru',
            'pengumpulan' => function ($query) use ($siswa) {
                $query->where('user_id', $siswa->id);
            }
        ])
            ->whereIn('mata_pelajaran_id', $mapelIds)
            ->orderBy('batas_waktu', 'asc') // Urutkan berdasarkan deadline terdekat
            ->paginate(9); // Paginate untuk membatasi jumlah kartu per halaman

        // Kirim data tugas ke view.
        return view('siswa.hal_tugas_siswa', compact('tugasList'));
    }

    // Fungsi-fungsi lain seperti store, edit, update, destroy akan diisi nanti
    // ...
}