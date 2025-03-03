<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSession;
use Carbon\Carbon;

class CloseInactiveSessions extends Command
{
    protected $signature = 'sessions:close-inactive';
    protected $description = 'Cerrar sesiones inactivas después de 15 minutos';

    public function handle()
    {
        $threshold = Carbon::now()->subMinutes(15); // Si pasan 30 min sin actividad, cerramos la sesión

        UserSession::whereNull('logout_at')
            ->where('last_activity', '<', $threshold)
            ->update(['logout_at' => Carbon::now()]);

        $this->info('Sesiones inactivas cerradas.');
    }
}
