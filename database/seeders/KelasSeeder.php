<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\User;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Baris ini dihapus karena proses truncate sudah dipindahkan
        // ke DatabaseSeeder.php untuk menghindari error foreign key.
        // Kelas::truncate();

        // Ambil ID guru yang ada untuk dijadikan wali kelas
        $guru1 = User::where('username', 'budi.guru')->first();
        $guru2 = User::where('username', 'citra.guru')->first();

        // Buat data kelas dengan wali kelas
        if ($guru1) {
            Kelas::create([
                'nama_kelas' => 'X RPL 1',
                'wali_kelas_id' => $guru1->id,
                'tahun_ajaran' => '2024/2025',
                'tingkat' => 'X',
            ]);
        }

        if ($guru2) {
            Kelas::create([
                'nama_kelas' => 'XI TKJ 2',
                'wali_kelas_id' => $guru2->id,
                'tahun_ajaran' => '2024/2025',
                'tingkat' => 'XI',
            ]);
        }

        // Buat data kelas TANPA wali kelas (nullable)
        Kelas::create([
            'nama_kelas' => 'XII MM 1',
            'wali_kelas_id' => null, // Ini menunjukkan kolomnya nullable
            'tahun_ajaran' => '2024/2025',
            'tingkat' => 'XII',
        ]);
    }
}
