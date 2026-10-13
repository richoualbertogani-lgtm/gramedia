<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mengarahkan pengguna yang sudah masuk agar tidak membuka halaman tamu.
 */
class IsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return redirect()->route('home')->with('error', 'Anda sudah login!');
        } else {
            return $next($request);
        }
    }
}
