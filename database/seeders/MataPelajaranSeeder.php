<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data mata pelajaran.
     *
     * @return void
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi saat seeder dijalankan ulang
        DB::table('mata_pelajarans')->delete();

        // Data contoh mata pelajaran
        $mataPelajaran = [
            [
                'nama_mapel' => 'Matematika Wajib',
                'kode_mapel' => 'MTK-X',
                'deskripsi' => 'Mata pelajaran Matematika untuk tingkat dasar kejuruan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_mapel' => 'Bahasa Indonesia',
                'kode_mapel' => 'IND-X',
                'deskripsi' => 'Keterampilan berbahasa, sastra, dan literasi Indonesia.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_mapel' => 'Bahasa Inggris',
                'kode_mapel' => 'ENG-X',
                'deskripsi' => 'Keterampilan berbahasa Inggris untuk komunikasi global.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_mapel' => 'Dasar-dasar Kejuruan RPL',
                'kode_mapel' => 'DK-RPL',
                'deskripsi' => 'Pengenalan algoritma, pemrograman dasar, dan konsep dasar rekayasa perangkat lunak.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_mapel' => 'Pemrograman Berorientasi Objek',
                'kode_mapel' => 'PBO-XI',
                'deskripsi' => 'Konsep dan implementasi pemrograman berorientasi objek menggunakan Java atau C++.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_mapel' => 'Basis Data',
                'kode_mapel' => 'DB-XI',
                'deskripsi' => 'Perancangan, implementasi, dan manajemen database relasional menggunakan SQL.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'kode_mapel' => 'PJOK-X',
                'deskripsi' => 'Aktivitas fisik, kesehatan, dan kebugaran jasmani.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Masukkan data ke dalam tabel
        DB::table('mata_pelajarans')->insert($mataPelajaran);
    }
}
