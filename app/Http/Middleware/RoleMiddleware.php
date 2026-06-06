<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user ada dalam daftar role yang diizinkan
        if (!in_array(auth()->user()->role, $roles)) {
            // JANGAN redirect ke dashboard di sini untuk menghindari loop
            // Gunakan abort(403) agar muncul pesan "Forbidden" yang jelas
            abort(403, 'Anda tidak memiliki akses ke halaman ini.'); 
        }

        return $next($request);
    }
}