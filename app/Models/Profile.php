<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * Properti ini penting untuk keamanan, hanya kolom yang disebutkan di sini
     * yang bisa diisi menggunakan metode create() atau update() secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'alamat',
        'nis',
        'no_telepon',
        'tanggal_lahir',
        'foto_profil',
    ];

    /**
     * The attributes that should be cast.
     *
     * Casting 'tanggal_lahir' ke tipe 'date' akan secara otomatis mengubahnya
     * menjadi objek Carbon, sehingga memudahkan manipulasi tanggal.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     *
     * Setiap Profile dimiliki oleh satu User.
     * Method ini memungkinkan Anda untuk mengakses data user dari sebuah profile,
     * contoh: $profile->user->name
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
