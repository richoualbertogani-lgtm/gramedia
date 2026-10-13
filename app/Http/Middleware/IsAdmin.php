<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Membatasi akses rute agar hanya dapat dilanjutkan oleh pengguna admin.
 */
class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Tolak pengguna non-admin sebelum permintaan mencapai tujuan rute.
        if ($request->user()->role !== 'admin') {
            return redirect('/')->with(
                'error',
                'Anda tidak memiliki izin akses'
            );
        }
        return $next($request);
    }
}
