<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'judul',
        'deskripsi',
        'batas_waktu',
        'kuis_id',
        'mata_pelajaran_id',
        'materi_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'batas_waktu' => 'datetime',
    ];

    public function kuis(): BelongsTo
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }

    public function materi(): BelongsTo
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class, 'tugas_id');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }

    /**
     * Accessor untuk menentukan status tugas bagi user yang login.
     *
     * @return string
     */
    public function getStatusDisplayAttribute(): string
    {
        // Cek apakah ada pengumpulan dari user yang sedang login
        $sudahMengumpulkan = $this->pengumpulan->where('user_id', Auth::id())->isNotEmpty();

        if ($sudahMengumpulkan) {
            return 'sudah_dikumpulkan';
        }

        if ($this->batas_waktu->isPast()) {
            return 'terlambat';
        }

        return 'belum_dikerjakan';
    }

    /**
     * Accessor untuk menampilkan sisa waktu dalam format yang mudah dibaca.
     *
     * @return string
     */
    public function getSisaWaktuDisplayAttribute(): string
    {
        if ($this->batas_waktu->isPast()) {
            return 'Waktu habis';
        }
        return $this->batas_waktu->diffForHumans(null, true, false, 2);
    }
}
