<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            // Primary Key untuk tabel kelas
            $table->id();

            // Nama kelas, contoh: "X TKJ 1", "XI Multimedia 2"
            $table->string('nama_kelas');

            // Foreign Key untuk wali kelas. Merujuk ke tabel 'users'.
            // Dibuat nullable agar kelas bisa dibuat tanpa harus langsung menunjuk wali kelas.
            $table->unsignedBigInteger('wali_kelas_id')->nullable();

            // Tahun Ajaran, contoh: "2024/2025"
            $table->string('tahun_ajaran', 9);

            // Tingkat atau Jenjang kelas, contoh: "X", "XI", "XII"
            $table->string('tingkat', 5);

            // Menambahkan unique constraint untuk kombinasi nama_kelas dan tahun_ajaran
            // agar tidak ada kelas dengan nama yang sama di tahun ajaran yang sama.
            $table->unique(['nama_kelas', 'tahun_ajaran']);

            $table->timestamps();

            // Mendefinisikan constraint foreign key secara eksplisit
            // Ini akan merujuk ke kolom 'id' di tabel 'users'
            $table->foreign('wali_kelas_id')
                  ->references('id')
                  ->on('users') // Merujuk ke tabel 'users'
                  ->onDelete('set null'); // Jika guru dihapus, wali_kelas_id menjadi NULL
        });
    }

    /**
     * Balikkan migrasi.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};

