<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah pengguna sudah login DAN rolenya ada di dalam daftar role yang diizinkan
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // Jika tidak, tolak akses dengan halaman 403 Forbidden.
            abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI HAK UNTUK MENGAKSES HALAMAN INI.');
        }

        // Jika lolos, lanjutkan ke request berikutnya.
        return $next($request);
    }
}
