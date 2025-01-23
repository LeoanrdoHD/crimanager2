<?php

namespace App\Providers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('unique_identity_number', function ($attribute, $value, $parameters, $validator) {
            // Verificar si el valor contiene un guion
            if (strpos($value, '-') !== false) {
                // Extraer la parte numérica antes del guion
                $number = explode('-', $value)[0];
            } else {
                // Si no contiene guion, usar el número completo
                $number = $value;
            }
        
            // Verificar si ya existe un registro con el mismo número
            return !DB::table('criminals')
                ->whereRaw("IF(LOCATE('-', identity_number) > 0, LEFT(identity_number, LOCATE('-', identity_number) - 1), identity_number) = ?", [$number])
                ->exists();
        }, 'El número de identidad ya existe en el sistema.');
        
    }
}
