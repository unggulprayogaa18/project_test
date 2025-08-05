<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) { // Changed table name to 'nilais' for Laravel convention
            $table->id(); // Ini akan menjadi 'id_nilai' (primary key)

            // Foreign key untuk menunjuk siswa (user) yang mendapatkan nilai
            $table->foreignId('siswa_id') // Menggunakan 'siswa_id' untuk kejelasan
                  ->constrained('users') // Merujuk ke tabel 'users'
                  ->onDelete('cascade'); // Jika siswa dihapus, nilai terkait juga dihapus

            // Foreign key untuk menunjuk tugas yang dinilai
            $table->foreignId('tugas_id')
                  ->constrained('tugas') // Merujuk ke tabel 'tugas' (dari immersive tugas-migration)
                  ->onDelete('cascade'); // Jika tugas dihapus, nilai terkait juga dihapus

            $table->float('nilai'); // Kolom untuk menyimpan nilai (contoh: 85.5, 90.0)

            $table->timestamps(); // created_at dan updated_at

            // Menambahkan unique constraint agar satu siswa hanya bisa memiliki satu nilai per tugas
            $table->unique(['siswa_id', 'tugas_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilais'); // Changed table name to 'nilais'
    }
};
