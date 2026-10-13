<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Memastikan permintaan hanya diteruskan jika pengguna sudah terautentikasi.
 */
class IsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // memperbolehkan melakukan aksi yg diminta
            return $next($request);
        } else {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu!');
        }
    }
}
