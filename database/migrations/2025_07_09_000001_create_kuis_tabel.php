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
        Schema::create('kuis_tabel', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kuis');
            $table->text('deskripsi')->nullable();

            $table->foreignId('guru_id')
                ->constrained('users')
                ->onDelete('cascade');

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
        Schema::dropIfExists('kuis_tabel');
    }
};