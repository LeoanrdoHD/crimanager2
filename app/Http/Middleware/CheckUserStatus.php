<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Verificar si el usuario está inactivo
        if ($user && !$user->estado) {
            Auth::logout();  // Cerrar sesión si está inactivo
            return redirect('/'); // Redirigir a la página de inicio
        }

        return $next($request);
    }
}
