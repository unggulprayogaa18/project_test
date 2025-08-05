<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel untuk menyimpan setiap soal dalam sebuah kuis
        Schema::create('soal_kuis', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke kuis induk
            $table->foreignId('kuis_id')->constrained('kuis_tabel')->onDelete('cascade');
            
            // Isi pertanyaan (bisa berupa teks atau path ke gambar)
            $table->text('pertanyaan');
            
            // Tipe pertanyaan, untuk pengembangan di masa depan (misal: pg, esai)
            $table->enum('tipe_soal', ['pilihan_ganda', 'esai'])->default('pilihan_ganda');
            
            $table->timestamps();
        });

        // Tabel untuk menyimpan opsi jawaban dari setiap soal pilihan ganda
        Schema::create('opsi_jawaban_kuis', function (Blueprint $table) {
            $table->id();

            // Foreign key ke soal induk
            $table->foreignId('soal_kuis_id')->constrained('soal_kuis')->onDelete('cascade');

            // Isi dari opsi jawaban (misal: "Jakarta", "Bandung", dll.)
            $table->text('opsi_jawaban');

            // Penanda apakah ini adalah jawaban yang benar
            $table->boolean('is_benar')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsi_jawaban_kuis');
        Schema::dropIfExists('soal_kuis');
    }
};
