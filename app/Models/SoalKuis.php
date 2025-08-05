<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SoalKuis extends Model
{
    use HasFactory;

    protected $table = 'soal_kuis';

    protected $fillable = [
        'kuis_id',
        'pertanyaan',
        'tipe_soal',
    ];

    /**
     * Relasi: Soal ini dimiliki oleh satu Kuis.
     */
    public function kuis(): BelongsTo
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }

    /**
     * Relasi: Soal ini memiliki banyak Opsi Jawaban.
     */
    public function opsiJawaban(): HasMany
    {
        return $this->hasMany(OpsiJawabanKuis::class);
    }
}
