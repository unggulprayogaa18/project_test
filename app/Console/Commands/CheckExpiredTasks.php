<?php

namespace App\Console\Commands;

use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiredTasks extends Command
{
    /**
     * Nama dan signature dari console command.
     *
     * @var string
     */
    protected $signature = 'tugas:cek-kedaluwarsa';

    /**
     * Deskripsi dari console command.
     *
     * @var string
     */
    protected $description = 'Memeriksa tugas yang sudah melewati batas waktu dan menandai siswa yang belum mengerjakan sebagai "belum"';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memulai pengecekan tugas kedaluwarsa...');
        Log::info('Scheduler: Memulai pengecekan tugas kedaluwarsa.');

        // Ambil tugas yang baru saja kedaluwarsa untuk diproses
        // Eager load relasi melalui alur yang benar: Tugas -> MataPelajaran -> Kelas -> Siswa
        $expiredTasks = Tugas::where('batas_waktu', '<', now())
                            ->where('batas_waktu', '>', now()->subDay())
                            ->with('mataPelajaran.kelas.siswas') 
                            ->get();

        if ($expiredTasks->isEmpty()) {
            $this->info('Tidak ada tugas yang baru kedaluwarsa untuk diproses.');
            Log::info('Scheduler: Tidak ada tugas kedaluwarsa baru.');
            return 0;
        }

        $this->info("Ditemukan {$expiredTasks->count()} tugas yang baru kedaluwarsa.");

        foreach ($expiredTasks as $tugas) {
            // 1. Pastikan tugas memiliki relasi ke mata pelajaran
            if (!$tugas->mataPelajaran) {
                Log::warning("Scheduler: Tugas ID {$tugas->id} tidak terhubung ke Mata Pelajaran.");
                continue;
            }

            // 2. Dari mata pelajaran, dapatkan semua kelas yang terkait
            $kelasTerkait = $tugas->mataPelajaran->kelas;

            if ($kelasTerkait->isEmpty()) {
                Log::warning("Scheduler: Mata Pelajaran ID {$tugas->mataPelajaran->id} tidak terhubung ke kelas manapun.");
                continue;
            }

            // 3. Kumpulkan semua siswa dari semua kelas terkait, dan pastikan datanya unik
            $uniqueStudents = $kelasTerkait->flatMap(function ($kelas) {
                return $kelas->siswas; // 'siswas' adalah nama relasi di model Kelas
            })->unique('id');

            if ($uniqueStudents->isEmpty()) {
                continue; // Lanjut jika tidak ada siswa di kelas-kelas tersebut
            }

            // 4. Proses setiap siswa yang unik
            foreach ($uniqueStudents as $student) {
                // Gunakan firstOrCreate: jika belum ada entri, buat baru dengan status 'belum'.
                // Jika sudah ada (karena siswa sudah mengerjakan), tidak akan melakukan apa-apa.
                PengumpulanTugas::firstOrCreate(
                    [
                        'tugas_id' => $tugas->id,
                        'user_id' => $student->id,
                    ],
                    [
                        'status' => 'belum', // Status untuk yang tidak mengerjakan
                        'nilai' => 0,
                        'catatan' => 'Tidak mengerjakan hingga batas waktu berakhir.',
                    ]
                );
            }

            $this->info("Tugas '{$tugas->judul}' (ID: {$tugas->id}) selesai diproses untuk {$uniqueStudents->count()} siswa.");
        }

        $this->info('Semua tugas kedaluwarsa berhasil diproses.');
        Log::info('Scheduler: Selesai memproses tugas kedaluwarsa.');
        return 0;
    }
}
