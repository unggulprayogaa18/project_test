<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MataPelajaran[] $mataPelajaran
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'username',
        'password',
        'role',
        'nomor_induk',
        'kelas_id', // Pastikan tidak ada spasi di akhir nama kolom
        'orang_tua_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mendefinisikan relasi bahwa seorang User (siswa) dimiliki oleh satu Kelas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mataPelajarans()
    {
        return $this->belongsToMany(MataPelajaran::class, 'kelas_mata_pelajaran', 'guru_id', 'mata_pelajaran_id')
            ->withPivot('kelas_id')
            ->withTimestamps();
    }

    public function siswas()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
    public function presensi(): HasMany
    {
        // Pastikan 'siswa_id' adalah nama foreign key di tabel 'absensi'
        // yang menunjuk ke 'id' dari tabel 'users' (siswa).
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }// Di dalam class User
    public function nilai(): HasMany
    {
        // Pastikan 'siswa_id' adalah nama foreign key di tabel 'nilai'
        // yang menunjuk ke 'id' dari tabel 'users' (siswa).
        return $this->hasMany(Nilai::class, 'siswa_id');
    }
    public function anak(): HasMany // <-- PENTING: Menggunakan HasMany untuk banyak anak
    {
        // 'orang_tua_id' adalah foreign key di tabel `users` (anak/siswa) yang menunjuk ke `id` user orang tua.
        // `id` adalah local key dari user orang tua saat ini.
        return $this->hasMany(User::class, 'orang_tua_id', 'id');
    }
    /**
     * Mendapatkan semua kuis yang dibuat oleh user (guru) ini.
     */
    public function kuis(): HasMany
    {
        return $this->hasMany(Kuis::class, 'guru_id');
    }
}