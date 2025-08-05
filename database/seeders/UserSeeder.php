<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Constants\Role; // Menggunakan konstanta untuk role
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Akun Admin Utama
        User::create([
            'nama' => 'Admin Sekolah',
            'username' => 'admin',
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => Role::ADMIN,
        ]);

        // Buat beberapa akun Guru
        User::create([
            'nama' => 'Budi Santoso, S.Pd.',
            'username' => 'budi.guru',
            'email' => 'budi.guru@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => Role::GURU,
        ]);

        User::create([
            'nama' => 'Citra Lestari, M.Kom.',
            'username' => 'citra.guru',
            'email' => 'citra.guru@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => Role::GURU,
        ]);

        // Buat akun Siswa dan simpan instance-nya
        $siswaAndi = User::create([
            'nama' => 'Andi Pratama',
            'username' => 'andi.siswa',
            'email' => 'andi.siswa@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => Role::SISWA,
        ]);

        // --- PENAMBAHAN AKUN ORANG TUA ---
        // Buat akun Orang Tua yang terhubung dengan siswa 'Andi Pratama'
        User::create([
            'nama' => 'Bapak Andi', // Nama orang tua
            'username' => 'bapak.andi',
            'email' => 'bapak.andi@example.com',
            'password' => Hash::make('password'),
            'role' => Role::ORANG_TUA,
            'anak_id' => $siswaAndi->id, // Menghubungkan ke ID siswa Andi
        ]);
    }
}
