<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLevel
{
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        // Cek jika user sudah login dan levelnya ada di dalam daftar yang diizinkan
        if ($request->user() && in_array($request->user()->level, $levels)) {
            return $next($request);
        }

        // Jika tidak punya akses, kembalikan halaman 403 (Forbidden)
        abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}