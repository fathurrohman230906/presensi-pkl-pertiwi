<?php

namespace App\Http\Middleware\Multiuser;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PembimbingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('pembimbing')->check()) {
            return redirect('/pembimbing-dashboard');
        }

        return $next($request);
    }
}
