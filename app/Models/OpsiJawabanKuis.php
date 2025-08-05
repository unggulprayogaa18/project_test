<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpsiJawabanKuis extends Model
{
    use HasFactory;

    protected $table = 'opsi_jawaban_kuis';

    protected $fillable = [
        'soal_kuis_id',
        'opsi_jawaban',
        'is_benar',
    ];

    /**
     * Relasi: Opsi ini dimiliki oleh satu SoalKuis.
     */
    public function soalKuis(): BelongsTo
    {
        return $this->belongsTo(SoalKuis::class, 'soal_kuis_id');
    }
}
