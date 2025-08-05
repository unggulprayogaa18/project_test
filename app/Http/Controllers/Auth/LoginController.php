<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Constants\Role;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman/form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'username' => 'Username atau password yang diberikan salah.',
        ])->onlyInput('username');
    }

    /**
     * Method untuk mengarahkan pengguna berdasarkan role mereka.
     */
    protected function redirectBasedOnRole()
    {
        $user = Auth::user();
        Log::info('Login sebagai role: ' . $user->role);

        switch ($user->role) {
            case Role::ADMIN:
                return redirect()->route('admin.dashboard');
            case Role::GURU:
                return redirect()->route('guru.dashboard');
            case Role::SISWA:
                return redirect()->route('siswa.dashboard');
            case Role::ORANG_TUA:
                return redirect()->route('orangtua.dashboard');
            default:
                Auth::logout();
                return redirect('/login')->withErrors(['username' => 'Role tidak valid.']);
        }
    }

    /**
     * Menangani permintaan logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // --- PERBAIKAN DI SINI ---
        // Langsung arahkan ke halaman login untuk menghindari redirect tambahan.
        return redirect()->route('login');
    }
}
