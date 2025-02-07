<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity');

            if ($lastActivity) {
                $inactiveTime = Carbon::now()->diffInMinutes(Carbon::parse($lastActivity));

                if ($inactiveTime > config('session.lifetime')) {
                    Auth::logout();
                    session()->flush();
                    return redirect('/')->with('message', 'Tu sesión ha expirado por inactividad.');
                }
            }

            // Actualizar la última actividad del usuario
            session(['last_activity' => Carbon::now()]);
        }

        return $next($request);
    }
}
