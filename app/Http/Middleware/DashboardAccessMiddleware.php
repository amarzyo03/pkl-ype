<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('auth_id')) {
            return redirect()->route('auth')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return match ($request->session()->get('auth_role')) {
            'admin' => $next($request),
            'guru' => redirect()->route('userGuru.dashboard'),
            'siswa' => redirect()->route('userSiswa.dashboard'),
            default => redirect()->route('auth')->with('error', 'Anda tidak memiliki akses ke halaman ini'),
        };
    }
}
