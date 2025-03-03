<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\UserSession;
use Carbon\Carbon;

class LogUserLogout
{
    public function handle(Logout $event)
    {
        $user = $event->user;
        if ($user) {
            UserSession::where('user_id', $user->id)
                ->latest()
                ->first()
                ->update(['logout_at' => Carbon::now()]);
        }
    }
}

