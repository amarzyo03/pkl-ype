<?php

namespace App\Http\Middleware;

use App\Models\pendaftaranModel;
use App\Models\userModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprovedPendaftaranMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = userModel::query()->findOrFail(session('auth_id'));
        $pendaftaran = pendaftaranModel::query()
            ->where('id_siswa', $user->id_user)
            ->first(['id', 'status']);

        if ($pendaftaran?->status !== 'disetujui') {
            return redirect()
                ->route($pendaftaran ? 'userSiswa.pendaftaran.status' : 'userSiswa.pendaftaran')
                ->with('failed', 'Akses tersedia setelah pendaftaran PKL disetujui.');
        }

        return $next($request);
    }
}
