<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->timestamp('batas_waktu')->nullable();

            $table->foreignId('kuis_id')
                ->nullable()
                ->constrained('kuis_tabel')
                ->onDelete('set null');

            $table->foreignId('materi_id')
                ->nullable()
                ->constrained('materis')
                ->onDelete('set null');

            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajarans')
                ->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas'); // Changed table name to 'tugas'
    }
};
