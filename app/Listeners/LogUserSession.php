<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Torann\GeoIP\Facades\GeoIP;  // La declaración 'use' debe estar aquí

class LogUserSession
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event)
    {
        $user = $event->user;

        $location = 'Desconocido';

        try {
            $locationData = GeoIP::getLocation(request()->ip());
            $location = $locationData->city ?? 'Desconocido';
        } catch (\Exception $e) {
            Log::error("Error al obtener la ubicación: " . $e->getMessage());
        }

        UserSession::create([
            'user_id'    => $user->id,
            'ip_address' => request()->ip(),
            'system'     => PHP_OS,
            'device'     => request()->header('User-Agent'),
            'location'   => $location,
            'login_at'   => now(),
        ]);
    }
}
