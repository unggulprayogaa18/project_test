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
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_materi', ['file', 'link'])->default('file');
            $table->string('file_path'); // Will contain a file path or URL

            // Foreign key to 'mata_pelajarans' table (required)
            $table->foreignId('mata_pelajaran_id')
                  ->constrained('mata_pelajarans')
                  ->onDelete('cascade');

            // The foreign key to the quiz table has been removed.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
