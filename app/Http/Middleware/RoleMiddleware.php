<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Jika user tidak login, biarkan middleware 'auth' yang menangani.
        if (! $request->user()) {
            return $next($request);
        }

        // Jika role user tidak cocok dengan role yang diizinkan untuk rute ini.
        if ($request->user()->role->value !== $role) {
            // Alihkan ke dashboard mereka masing-masing.
            $redirectRoute = $request->user()->role === UserRole::ADMIN 
                ? '/admin/dashboard' 
                : '/dashboard';
            
            return redirect($redirectRoute);
        }

        return $next($request);
    }
}
