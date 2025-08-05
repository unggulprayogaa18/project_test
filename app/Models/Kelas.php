<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel secara eksplisit.
     *
     * @var string
     */


    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kelas',
        'wali_kelas_id',
        'tahun_ajaran',
        'tingkat',
    ];

    /**
     * Mendefinisikan relasi "hasMany" ke model Materi.
     *
     * Satu kelas bisa memiliki banyak materi pembelajaran.
     * Method ini memungkinkan Anda untuk mengambil semua materi dari sebuah kelas,
     * contoh: $kelas->materis
     */
    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class);
    }
    public function siswas()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mata_pelajaran', 'mata_pelajaran_id', 'kelas_id')
            ->withPivot('guru_id')
            ->withTimestamps();
    }
    // app/Models/Kelas.php
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }
    public function mataPelajarans()
    {
        return $this->belongsToMany(MataPelajaran::class, 'kelas_mata_pelajaran', 'kelas_id', 'mata_pelajaran_id')
            ->withPivot('guru_id')
            ->withTimestamps();
    }
}
