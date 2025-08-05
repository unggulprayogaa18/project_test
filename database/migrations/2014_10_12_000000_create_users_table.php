<?php

use App\Constants\Role;
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
        // Perintah ini membuat tabel 'users' di database Anda.
        Schema::create('users', function (Blueprint $table) {
            // id() akan membuat kolom 'id' sebagai BIGINT, auto-increment, dan primary key.
            $table->id();
            // Kolom untuk nama lengkap pengguna.
            $table->string('nama');
            // Kolom untuk email, harus unik (tidak boleh ada yang sama).
            $table->string('email')->unique();
            // Kolom untuk username, juga harus unik.
            $table->string('username')->unique();
            // Kolom untuk Nomor Induk (NIS/NIP). Unik dan boleh kosong (nullable) untuk admin.
            $table->string('nomor_induk')->unique()->nullable();
            // Kolom standar Laravel untuk verifikasi email.
            $table->timestamp('email_verified_at')->nullable();
            // Kolom untuk menyimpan password yang sudah di-hash.
            $table->string('password');
            // Kolom untuk menentukan peran/role pengguna.
            // Menggunakan ENUM untuk membatasi nilai hanya pada 'admin', 'guru', atau 'siswa'.
            $table->enum('role', [
                Role::ADMIN,
                Role::GURU,
                Role::SISWA,
                Role::ORANG_TUA // Menambahkan role baru
            ]);
            // Kolom standar Laravel untuk fitur "Remember Me".
            $table->rememberToken();
            // timestamps() akan membuat kolom 'created_at' dan 'updated_at' secara otomatis.
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
        Schema::dropIfExists('users');
    }
};
