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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom orang_tua_id sebagai foreign key
            // Menggunakan nullable() karena tidak semua user adalah siswa dengan orang tua
            // constrained('users') menunjuk ke tabel users itu sendiri (self-referencing)
            // onDelete('set null') berarti jika orang tua dihapus, orang_tua_id di anak menjadi null
            $table->foreignId('orang_tua_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['orang_tua_id']); // Hapus foreign key constraint
            $table->dropColumn('orang_tua_id');    // Hapus kolom
        });
    }
};