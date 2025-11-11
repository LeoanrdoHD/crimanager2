<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * NUEVOS MÉTODOS PARA API DE BLOQUEO
     */

    /**
     * Verificar estado de bloqueo para el frontend
     */
    public function checkBlockStatus(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json(['blocked' => false]);
        }
        
        // Verificar bloqueo personalizado
        $blockKey = "custom_login_block:{$email}";
        $blockData = Cache::get($blockKey);
        
        if ($blockData && Carbon::now()->lt($blockData['expires_at'])) {
            $remainingMinutes = Carbon::now()->diffInMinutes($blockData['expires_at'], false);
            $remainingSeconds = Carbon::now()->diffInSeconds($blockData['expires_at'], false);
            
            return response()->json([
                'blocked' => true,
                'type' => 'temporary_block',
                'remaining_minutes' => abs($remainingMinutes),
                'remaining_seconds' => abs($remainingSeconds),
                'expires_at' => $blockData['expires_at']->toISOString(),
                'message' => 'Cuenta bloqueada temporalmente por múltiples intentos fallidos'
            ]);
        }
        
        // Verificar intentos actuales
        $attemptsKey = "custom_login_attempts:{$email}";
        $attempts = Cache::get($attemptsKey, []);
        $recentAttempts = collect($attempts)->filter(function ($timestamp) {
            return Carbon::createFromTimestamp($timestamp)->gt(Carbon::now()->subMinutes(15));
        });
        
        // Verificar si la cuenta está inactiva
        $user = \App\Models\User::where('email', $email)->first();
        if ($user && !$user->estado) {
            return response()->json([
                'blocked' => true,
                'type' => 'account_inactive',
                'message' => 'Cuenta inactiva. Contacte al administrador.'
            ]);
        }
        
        return response()->json([
            'blocked' => false,
            'attempts' => $recentAttempts->count(),
            'remaining_attempts' => max(0, 5 - $recentAttempts->count())
        ]);
    }
    
    /**
     * Limpiar bloqueo (para testing o admin)
     */
    public function clearBlock(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json(['success' => false, 'message' => 'Email requerido']);
        }
        
        Cache::forget("custom_login_attempts:{$email}");
        Cache::forget("custom_login_block:{$email}");
        
        return response()->json(['success' => true, 'message' => 'Bloqueo eliminado']);
    }
}