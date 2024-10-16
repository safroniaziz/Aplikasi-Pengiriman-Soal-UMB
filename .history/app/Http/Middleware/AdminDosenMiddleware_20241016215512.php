<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminDosenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'dosen') {
                return $next($request); // Lanjutkan ke request berikutnya jika user adalah admin
            }
            else{
                return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
            }
        }

        // Jika bukan admin, arahkan ke /dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}
