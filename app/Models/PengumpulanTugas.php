<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'tugas_id',
        'user_id',
        'file_path',
        'status',
        'nilai',
        'catatan',
    ];

    // Relasi ke model Tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    // Relasi ke model User (siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
