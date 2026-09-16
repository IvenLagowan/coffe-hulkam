<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect('login');
        }

        if (\Illuminate\Support\Facades\Auth::user()->role !== $role) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
