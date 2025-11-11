<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Verificar si la cuenta está inactiva ANTES de intentar autenticar
        $this->ensureAccountIsActive();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Registrar intento fallido
            $this->recordFailedAttempt();

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Las credenciales proporcionadas son incorrectas.',
            ]);
        }

        // Login exitoso - limpiar intentos
        $this->clearFailedAttempts();
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Verificar si la cuenta está activa
     */
    protected function ensureAccountIsActive(): void
    {
        $user = \App\Models\User::where('email', $this->input('email'))->first();

        if ($user && !$user->estado) {
            throw ValidationException::withMessages([
                'email' => 'Tu cuenta está inactiva. Contacta al administrador para su reactivación.',
            ]);
        }
    }

    /**
     * Registrar intento fallido en cache personalizado
     */
    protected function recordFailedAttempt(): void
    {
        $email = $this->input('email');
        $key = "custom_login_attempts:{$email}";
        $attempts = Cache::get($key, []);
        $attempts[] = Carbon::now()->timestamp;

        // Mantener solo intentos de los últimos 15 minutos
        $attempts = collect($attempts)->filter(function ($timestamp) {
            return Carbon::createFromTimestamp($timestamp)->gt(Carbon::now()->subMinutes(15));
        })->values()->toArray();

        Cache::put($key, $attempts, Carbon::now()->addMinutes(15));

        // Si alcanza 5 intentos, crear bloqueo personalizado
        if (count($attempts) >= 5) {
            $this->createCustomBlock($email);
        }
    }

    /**
     * Crear bloqueo personalizado de 15 minutos
     */
    protected function createCustomBlock(string $email): void
    {
        $blockKey = "custom_login_block:{$email}";
        $expiresAt = Carbon::now()->addMinutes(15);

        Cache::put($blockKey, [
            'email' => $email,
            'blocked_at' => Carbon::now(),
            'expires_at' => $expiresAt,
            'attempts' => 5
        ], $expiresAt);
    }

    /**
     * Limpiar intentos fallidos
     */
    protected function clearFailedAttempts(): void
    {
        $email = $this->input('email');
        Cache::forget("custom_login_attempts:{$email}");
        Cache::forget("custom_login_block:{$email}");
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        // Primero verificar nuestro sistema personalizado
        $this->ensureNotCustomBlocked();

        // Luego verificar el rate limiter original de Laravel
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => 'Demasiados intentos de acceso. Por favor intente nuevamente en ' . ceil($seconds / 60) . ' minutos.',
        ]);
    }

    /**
     * Verificar bloqueo personalizado
     */
    protected function ensureNotCustomBlocked(): void
    {
        $email = $this->input('email');
        $blockKey = "custom_login_block:{$email}";
        $blockData = Cache::get($blockKey);

        if ($blockData && Carbon::now()->lt($blockData['expires_at'])) {
            $remainingSeconds = Carbon::now()->diffInSeconds($blockData['expires_at'], false);
            $minutes = floor($remainingSeconds / 60);
            $seconds = $remainingSeconds % 60;

            $timeMessage = '';
            if ($minutes > 0) {
                $timeMessage = "{$minutes} minutos y {$seconds} segundos";
            } else {
                $timeMessage = "{$seconds} segundos";
            }

            throw ValidationException::withMessages([
                'email' => "Demasiados intentos de acceso. Su cuenta está bloqueada temporalmente por {$timeMessage}.",
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
