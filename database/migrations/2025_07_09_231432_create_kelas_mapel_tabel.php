<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('kelas_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel 'kelas'
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            // Foreign key ke tabel 'mata_pelajarans'
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            // Opsional: Foreign key ke tabel 'users' untuk guru yang mengajar mata pelajaran ini di kelas ini
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');

            // Menambahkan unique constraint untuk memastikan kombinasi kelas, mata pelajaran, dan guru unik
            $table->unique(['kelas_id', 'mata_pelajaran_id', 'guru_id'], 'unique_kelas_mapel_guru');
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_mata_pelajaran');
    }
};

