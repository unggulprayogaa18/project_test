<?php

namespace App\Http\Middleware;

use App\Constants\Role;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // --- LOGIKA BARU UNTUK REDIRECT BERDASARKAN ROLE ---
                $user = Auth::user();
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
                        // Fallback default
                        return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}
