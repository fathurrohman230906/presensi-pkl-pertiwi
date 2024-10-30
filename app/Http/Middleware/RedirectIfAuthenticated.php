<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Jika tidak ada guard yang ditentukan, gunakan default guards
        $guards = empty($guards) ? ['admin', 'pembimbing', 'wali_kelas', 'siswa'] : $guards;

        foreach ($guards as $guard) {
            // Memeriksa apakah pengguna terautentikasi untuk setiap guard
            if (auth($guard)->check()) {
                // Redirect ke dashboard yang sesuai berdasarkan guard
                switch ($guard) {
                    case 'admin':
                        return redirect('/admin-dashboard'); // Redirect ke dashboard admin
                    case 'pembimbing':
                        return redirect('/pembimbing-dashboard'); // Redirect ke dashboard pembimbing
                    case 'wali_kelas':
                        return redirect('/wali-kelas-dashboard'); // Redirect ke dashboard wali kelas
                    case 'siswa':
                        return redirect('/siswa-dashboard'); // Redirect ke dashboard siswa
                }
            }
        }

        return $next($request); // Lanjutkan permintaan jika tidak ada yang terautentikasi
    }
}
