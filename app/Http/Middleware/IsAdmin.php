<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Logika: User harus Login DAN Role-nya ADMIN
        if (Auth::check() && Auth::user()->role === 'ADMIN') {
            return $next($request);
        }

        // Kalau gagal, lempar ke dashboard
        return redirect('/dashboard')->with('error', 'Akses ditolak. Khusus Admin.');
    }
}