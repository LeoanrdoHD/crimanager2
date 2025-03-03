<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\UserSession;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $lastActivity = session('last_activity');
            $session = UserSession::where('user_id', $userId)->latest()->first();

            if ($lastActivity) {
                $inactiveTime = Carbon::now()->diffInMinutes(Carbon::parse($lastActivity));

                // Si el usuario supera el tiempo de inactividad permitido
                if ($inactiveTime >= config('session.lifetime')) {
                    if ($session) {
                        $session->update(['logout_at' => Carbon::now()]);
                    }

                    // Cierra completamente la sesión
                    Auth::logout();
                    Session::flush();
                    Session::invalidate(); // Invalida la sesión actual
                    Session::regenerateToken(); // Regenera el token CSRF

                    return redirect('/')->with('message', 'Tu sesión ha expirado por inactividad.');
                }
            }

            // Actualizar la última actividad en la sesión y en la base de datos
            session(['last_activity' => Carbon::now()]);

            if ($session) {
                $session->update(['last_activity' => Carbon::now()]);
            }
        }

        return $next($request);
    }
}
