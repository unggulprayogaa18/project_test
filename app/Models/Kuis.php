<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kuis extends Model
{
    use HasFactory;

    protected $table = 'kuis_tabel';

    protected $fillable = [
        'judul_kuis',
        'deskripsi',
        'guru_id',
        'mata_pelajaran_id',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kuis_id');
    }

    /**
     * Relasi baru: Kuis ini memiliki banyak Soal.
     */
    public function soal(): HasMany
    {
        return $this->hasMany(SoalKuis::class);
    }
}
