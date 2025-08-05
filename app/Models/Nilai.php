<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (opsional jika sudah sesuai konvensi)
    protected $table = 'nilais';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'siswa_id',
        'tugas_id',
        'nilai',
    ];

    /**
     * Relasi: Nilai dimiliki oleh satu siswa (User)
     */
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    /**
     * Relasi: Nilai dimiliki oleh satu tugas
     */
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
}
