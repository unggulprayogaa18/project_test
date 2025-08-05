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
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Foreign key ke tabel users itu sendiri, untuk menandai anak dari user orangtua
            $table->foreignId('anak_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
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
            // Menambahkan logika untuk menghapus kolom jika migrasi di-rollback
            $table->dropForeign(['anak_id']);
            $table->dropColumn('anak_id');
        });
    }
};
