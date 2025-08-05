<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tugas
            $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade');
            
            // Relasi ke user (siswa)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Upload file tugas (opsional, bisa kosong saat belum dikumpulkan)
            $table->string('file_path')->nullable();

            // Status pengerjaan
            $table->enum('status', ['belum', 'dikerjakan'])->default('belum');

            // Nilai dari guru
            $table->integer('nilai')->nullable();

            // Catatan / komentar dari guru
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
