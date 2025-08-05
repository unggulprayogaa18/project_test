<?php

namespace App\Http\Controllers;

use App\Constants\Role;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('nomor_induk', 'like', '%' . $search . '%');
            });
        }

        $users = $query->with(['kelas', 'anak'])->latest()->paginate(10);
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        // Ambil siswa yang belum punya orang tua, atau anak dari user yang sedang diedit
        $siswaTanpaOrtu = User::where('role', Role::SISWA)
            ->whereNull('orang_tua_id')
            ->with('kelas')
            ->orderBy('nama')
            ->get();

        return view('admin.hal_pengguna', compact('users', 'kelasList', 'siswaTanpaOrtu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // --- Aturan Validasi ---
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
            'role' => ['required', Rule::in([Role::ADMIN, Role::GURU, Role::SISWA, Role::ORANG_TUA])],
            'nomor_induk' => [
                'nullable',
                'string',
                'max:255',
                // Cek keunikan hanya jika nilainya BUKAN null atau '-'
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('nomor_induk', '!=', '-');
                })
            ],
            'kelas_id' => 'nullable|exists:kelas,id',
            'anak_id' => 'nullable|exists:users,id',
        ];

        // --- Aturan Kondisional Berdasarkan Role ---
        if ($request->role == Role::SISWA || $request->role == Role::GURU) {
            $rules['kelas_id'] = 'required|exists:kelas,id';
            $rules['nomor_induk'][0] = 'required'; // Ganti nullable menjadi required
        }

        if ($request->role == Role::ORANG_TUA) {
            $rules['anak_id'] = [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', Role::SISWA)->whereNull('orang_tua_id');
                }),
            ];
        }

        $validatedData = $request->validate($rules);

        // --- Proses Pembuatan User ---
        $userData = $request->only(['nama', 'email', 'username', 'role', 'nomor_induk']);
        $userData['password'] = Hash::make($request->password);

        // PERBAIKAN DI SINI: Ubah '-' menjadi NULL sebelum menyimpan
        if (isset($userData['nomor_induk']) && $userData['nomor_induk'] === '-') {
            $userData['nomor_induk'] = null;
        }

        if ($validatedData['role'] == Role::SISWA || $validatedData['role'] == Role::GURU) {
            $userData['kelas_id'] = $validatedData['kelas_id'];
        }

        $user = User::create($userData);

        if ($user->role == Role::ORANG_TUA && isset($validatedData['anak_id'])) {
            User::where('id', $validatedData['anak_id'])->update(['orang_tua_id' => $user->id]);
        }

        Log::info('Pengguna baru ditambahkan', ['admin_id' => auth()->id(), 'user_id' => $user->id]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        Log::info('Memulai proses update untuk pengguna.', ['user_id' => $user->id, 'admin_id' => auth()->id()]);
        Log::debug('Data request yang masuk:', $request->all());

        // --- Aturan Validasi ---
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in([Role::ADMIN, Role::GURU, Role::SISWA, Role::ORANG_TUA])],
            'nomor_induk' => [
                'nullable',
                'string',
                'max:255',
                // Cek keunikan, abaikan user saat ini dan nilai '-'
                Rule::unique('users')->ignore($user->id)->where(function ($query) use ($request) {
                    return $query->where('nomor_induk', '!=', '-');
                })
            ],
            'kelas_id' => 'nullable|exists:kelas,id',
            'anak_id' => 'nullable|exists:users,id',
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', PasswordRule::min(8)];
        }

        if ($request->role == Role::SISWA || $request->role == Role::GURU) {
            $rules['kelas_id'] = 'required|exists:kelas,id';
            $rules['nomor_induk'][0] = 'required';
        }

        if ($request->role == Role::ORANG_TUA) {
            $rules['anak_id'] = [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) use ($user) {
                    $query->where('role', Role::SISWA)
                          ->where(function($q) use ($user) {
                              $q->whereNull('orang_tua_id')
                                ->orWhere('orang_tua_id', $user->id);
                          });
                }),
            ];
        }

        try {
            $validatedData = $request->validate($rules);
            Log::info('Validasi berhasil.', ['validated_data' => $validatedData]);
        } catch (ValidationException $e) {
            Log::error('Validasi GAGAL saat update pengguna.', ['user_id' => $user->id, 'errors' => $e->errors(), 'request_data' => $request->all()]);
            throw $e;
        }

        // --- Proses Update ---
        DB::beginTransaction();
        try {
            $oldAnakId = $user->role == Role::ORANG_TUA ? optional($user->anak->first())->id : null;

            $userData = $request->only(['nama', 'email', 'username', 'role', 'nomor_induk']);

            // PERBAIKAN DI SINI: Ubah '-' menjadi NULL sebelum menyimpan
            if (isset($userData['nomor_induk']) && $userData['nomor_induk'] === '-') {
                $userData['nomor_induk'] = null;
            }

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $userData['kelas_id'] = ($request->role == Role::SISWA || $request->role == Role::GURU) ? $validatedData['kelas_id'] : null;
            $user->update($userData);
            Log::info('Data utama pengguna berhasil diupdate.', ['user_id' => $user->id]);

            // Logika untuk mengelola relasi anak dan orang tua
            if ($request->role == Role::ORANG_TUA) {
                $newAnakId = $validatedData['anak_id'];
                if ($oldAnakId && $oldAnakId != $newAnakId) {
                    User::where('id', $oldAnakId)->update(['orang_tua_id' => null]);
                    Log::info('Relasi orang tua lama dilepaskan.', ['anak_id' => $oldAnakId]);
                }
                User::where('id', $newAnakId)->update(['orang_tua_id' => $user->id]);
                Log::info('Relasi orang tua baru dikaitkan.', ['anak_id' => $newAnakId, 'orang_tua_id' => $user->id]);

            } elseif ($oldAnakId) {
                User::where('id', $oldAnakId)->update(['orang_tua_id' => null]);
                Log::info('Role diubah dari orang tua, relasi anak dilepaskan.', ['anak_id' => $oldAnakId]);
            }

            DB::commit();
            Log::info('Update pengguna berhasil.', ['user_id' => $user->id]);
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Error kritis saat update pengguna.', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Gagal memperbarui pengguna.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $deletedUserData = $user->toArray();
        DB::beginTransaction();
        try {
            if ($user->role == Role::ORANG_TUA && $user->anak->isNotEmpty()) {
                $user->anak()->update(['orang_tua_id' => null]);
            }
            $user->delete();
            DB::commit();
            Log::warning('Pengguna dihapus.', ['admin_id' => auth()->id(), 'deleted_user' => $deletedUserData]);
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus pengguna.', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->route('admin.users.index')->with('error', 'Gagal menghapus pengguna.');
        }
    }
}
