<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // --- PERUBAHAN DI SINI ---
            // 1. Definisikan kolom dengan tipe data yang sama persis dengan 'id' di tabel 'users' (unsignedBigInteger)
            $table->unsignedBigInteger('user_id')->unique();

            // 2. Terapkan foreign key constraint secara eksplisit
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // --- AKHIR PERUBAHAN ---

            // Kolom-kolom untuk data profil
            $table->text('alamat')->nullable();
            $table->text('nis')->nullable();
            $table->string('no_telepon')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('foto_profil')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};