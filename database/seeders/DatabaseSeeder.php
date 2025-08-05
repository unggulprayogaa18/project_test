<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // Import Schema
use App\Models\Kelas; // Import model Kelas
use App\Models\User; // Import model User
use App\Models\MataPelajaran; // Import model MataPelajaran
use App\Models\Materi; // Import model Materi
use App\Models\Kuis; // Import model Kuis

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Nonaktifkan pengecekan foreign key untuk sementara
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel dalam urutan yang benar (child dulu, baru parent)
        Materi::truncate(); // Hapus materi dulu karena punya foreign key
        Kelas::truncate();
        MataPelajaran::truncate();
        User::truncate();
        // Tambahkan truncate untuk tabel lain di sini jika perlu

        // 3. Aktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        // 4. Panggil seeder untuk mengisi data baru ke tabel yang sudah kosong
        // Pastikan urutannya logis (data master dulu, baru data transaksional)
        $this->call([
            UserSeeder::class,
            KelasSeeder::class,
            MataPelajaranSeeder::class, // Panggil seeder mata pelajaran
        ]);
    }
}
