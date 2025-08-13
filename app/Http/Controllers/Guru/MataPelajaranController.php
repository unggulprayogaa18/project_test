<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $guruId = Auth::id();
        
        // [PERBAIKAN 1] Mengambil kelas.id sebagai kelas_id agar bisa dibaca di view
        $query = MataPelajaran::query()
            ->leftJoin('kelas_mata_pelajaran', function($join) use ($guruId) {
                $join->on('mata_pelajarans.id', '=', 'kelas_mata_pelajaran.mata_pelajaran_id')
                     ->where('kelas_mata_pelajaran.guru_id', $guruId);
            })
            ->leftJoin('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id')
            ->select(
                'mata_pelajarans.*',
                'kelas.nama_kelas',
                'kelas.id as kelas_id' // Ambil ID kelas dan beri alias 'kelas_id'
            );

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('mata_pelajarans.nama_mapel', 'like', '%' . $search . '%')
                  ->orWhere('mata_pelajarans.kode_mapel', 'like', '%' . $search . '%')
                  ->orWhere('kelas.nama_kelas', 'like', '%' . $search . '%');
            });
        }

        $mataPelajaran = $query->latest('mata_pelajarans.created_at')->paginate(10);
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('guru.hal_matapelajaran', compact('mataPelajaran', 'kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'kode_mapel' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        DB::transaction(function () use ($request) {
            $mataPelajaran = MataPelajaran::create($request->only(['nama_mapel', 'kode_mapel', 'deskripsi']));
            
            DB::table('kelas_mata_pelajaran')->insert([
                'kelas_id' => $request->kelas_id,
                'mata_pelajaran_id' => $mataPelajaran->id,
                'guru_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('guru.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajarans,nama_mapel,' . $mataPelajaran->id,
            'kode_mapel' => 'nullable|string|max:255|unique:mata_pelajarans,kode_mapel,' . $mataPelajaran->id,
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        DB::transaction(function () use ($request, $mataPelajaran) {
            $mataPelajaran->update($request->only('nama_mapel', 'kode_mapel', 'deskripsi'));

            // [PERBAIKAN 2] Menggunakan updateOrInsert untuk menangani kasus jika relasi belum ada
            DB::table('kelas_mata_pelajaran')
                ->updateOrInsert(
                    [
                        'mata_pelajaran_id' => $mataPelajaran->id,
                        'guru_id' => Auth::id()
                    ],
                    [
                        'kelas_id' => $request->kelas_id,
                        'updated_at' => now()
                    ]
                );
        });

        return redirect()->route('guru.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete(); // Relasi di pivot table akan terhapus otomatis karena onDelete('cascade')

        return redirect()->route('guru.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}