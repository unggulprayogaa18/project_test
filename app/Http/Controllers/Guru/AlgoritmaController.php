// Di dalam SiswaController.php (contoh)
public function kerjakanKuis(Kuis $kuis)
{
    // 1. Ambil semua soal dari kuis ini, beserta opsi jawabannya
    $semuaSoal = $kuis->soal()->with('opsiJawaban')->get();

    // 2. Acak urutan soal menggunakan Fisher-Yates pada koleksi Laravel
    $soalAcak = $semuaSoal->shuffle();

    // 3. Untuk setiap soal yang sudah diacak, acak juga urutan opsi jawabannya
    $soalAcak->each(function ($soal) {
        // Mengacak relasi 'opsiJawaban'
        $soal->setRelation('opsiJawaban', $soal->opsiJawaban->shuffle());
    });
    
    // 4. Kirim data soal dan opsi yang sudah teracak sepenuhnya ke view
    return view('siswa.halaman_pengerjaan_kuis', [
        'kuis' => $kuis,
        'soalList' => $soalAcak,
    ]);
}