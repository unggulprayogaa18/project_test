<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Materi extends Model
    {
        use HasFactory;

        protected $table = 'materis'; // Table name

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'judul',
            'deskripsi',
            'tipe_materi',
            'file_path',
            'mata_pelajaran_id', // kuis_id has been removed
        ];

        /**
         * Get the class that the material belongs to.
         */
        public function kelas(): BelongsTo
        {
            return $this->belongsTo(Kelas::class, 'kelas_id');
        }

        /**
         * Get the user (teacher) who created the material.
         */
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }

        /**
         * Get the subject that the material belongs to.
         */
        public function mataPelajaran(): BelongsTo
        {
            return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
        }
    }
