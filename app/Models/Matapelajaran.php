<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model untuk tabel 'MataPelajaran'.
 * Merepresentasikan mata pelajaran yang diajarkan.
 */
class MataPelajaran extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini
    protected $table = 'mata_pelajarans';

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
        'deskripsi',
    ];

    /**
     * Dapatkan kelas-kelas yang memiliki mata pelajaran ini.
     * Hubungan Many-to-Many dengan model Kelas melalui tabel pivot 'kelas_mata_pelajaran'.
     */
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mata_pelajaran', 'mata_pelajaran_id', 'kelas_id')
                    ->withPivot('guru_id') // Jika Anda ingin mengakses guru_id dari tabel pivot
                    ->withTimestamps();
    }

    /**
     * Dapatkan guru-guru yang mengajar mata pelajaran ini di kelas tertentu.
     * Hubungan Many-to-Many dengan model User (guru) melalui tabel pivot 'kelas_mata_pelajaran'.
     */
    public function gurus(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'kelas_mata_pelajaran', 'mata_pelajaran_id', 'guru_id')
                    ->withPivot('kelas_id') // Jika Anda ingin mengakses kelas_id dari tabel pivot
                    ->withTimestamps();
    }

    /**
     * Dapatkan semua materi yang terkait dengan mata pelajaran ini.
     * Hubungan One-to-Many (MataPelajaran memiliki banyak Materi).
     * CATATAN: Migrasi 'materis' yang Anda berikan tidak memiliki foreign key 'mata_pelajaran_id'.
     * Jika Anda ingin hubungan ini, Anda perlu menambahkan 'mata_pelajaran_id' ke tabel 'materis'.
     */
    public function materis(): HasMany
    {
        // Asumsi: 'materis' memiliki kolom 'mata_pelajaran_id'
        return $this->hasMany(Materi::class, 'mata_pelajaran_id');
    }

    /**
     * Dapatkan semua tugas yang terkait dengan mata pelajaran ini.
     * Hubungan One-to-Many (MataPelajaran memiliki banyak Tugas).
     * CATATAN: Migrasi 'tugas' yang Anda berikan tidak memiliki foreign key 'mata_pelajaran_id'.
     * Jika Anda ingin hubungan ini, Anda perlu menambahkan 'mata_pelajaran_id' ke tabel 'tugas'.
     */
    public function tugas(): HasMany
    {
        // Asumsi: 'tugas' memiliki kolom 'mata_pelajaran_id'
        return $this->hasMany(Tugas::class, 'mata_pelajaran_id');
    }

    /**
     * Dapatkan semua kuis yang terkait dengan mata pelajaran ini.
     * Hubungan One-to-Many (MataPelajaran memiliki banyak Kuis).
     * CATATAN: Migrasi 'kuis_tabel' yang Anda berikan tidak memiliki foreign key 'mata_pelajaran_id'.
     * Jika Anda ingin hubungan ini, Anda perlu menambahkan 'mata_pelajaran_id' ke tabel 'kuis_tabel'.
     */
    public function kuis(): HasMany
    {
        // Asumsi: 'kuis_tabel' memiliki kolom 'mata_pelajaran_id'
        return $this->hasMany(Kuis::class, 'mata_pelajaran_id');
    }

 

}