<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSession;
use Carbon\Carbon;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $session = UserSession::where('user_id', Auth::id())
                ->latest()
                ->first();

            if ($session) {
                $session->update(['last_activity' => Carbon::now()]);
            }
        }

        return $next($request);
    }
}
