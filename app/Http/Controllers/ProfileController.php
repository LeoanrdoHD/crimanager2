<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserSession;

class ProfileController extends Controller
{
    /**
     * Mostrar la vista del perfil (SOLO LECTURA - estadísticas y sesiones)
     */
    public function show()
    {
        try {
            $userId = Auth::id();
            
            // Consulta directa y simple como tu vista que funciona
            $activeSessionsData = \App\Models\UserSession::where('user_id', $userId)
                ->whereNull('logout_at')
                ->with('user')
                ->orderBy('login_at', 'desc')
                ->get();
                
            $recentSessionsData = \App\Models\UserSession::where('user_id', $userId)
                ->whereNotNull('logout_at')
                ->with('user')
                ->orderBy('logout_at', 'desc')
                ->limit(5)
                ->get();
            
            // Obtener estadísticas del usuario (solo las necesarias)
            $statistics = $this->getUserStatistics($userId);
            
            // Asignar a las variables que usa la vista
            $activeSessions = $activeSessionsData;
            $recentSessions = $recentSessionsData;
            
            return view('profile.show', [
                'activeSessions' => $activeSessions,
                'recentSessions' => $recentSessions,
                'statistics' => $statistics,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en ProfileController show(): ' . $e->getMessage());
            
            // Asegurar variables vacías en caso de error
            $activeSessions = collect();
            $recentSessions = collect();
            $statistics = [];
            
            return view('profile.show', [
                'activeSessions' => $activeSessions,
                'recentSessions' => $recentSessions,
                'statistics' => $statistics,
            ]);
        }
    }

    /**
     * Mostrar la vista de EDICIÓN del perfil (formularios de edición)
     */
    public function edit()
    {
        try {
            $userId = Auth::id();
            
            // Para la vista de edición no necesitamos estadísticas ni sesiones
            // Solo mostrar los formularios de edición
            
            return view('profile.edit');
            
        } catch (\Exception $e) {
            Log::error('Error en ProfileController edit(): ' . $e->getMessage());
            return view('profile.edit');
        }
    }

    /**
     * Actualizar información del perfil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        try {
            // Validación basada en tu UserController
            $validated = $request->validate([
                'phone' => 'nullable|string|max:15',
                'escalafon' => 'nullable|string|max:50',
                'grade' => 'nullable|string|max:50',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ], [
                'photo.image' => 'El archivo debe ser una imagen.',
                'photo.mimes' => 'La imagen debe ser de tipo: jpg, jpeg, png, gif.',
                'photo.max' => 'La imagen no debe ser mayor a 2MB.',
                'phone.max' => 'El número de teléfono no debe exceder los 15 caracteres.',
                'escalafon.max' => 'El escalafón no debe exceder los 50 caracteres.',
                'grade.max' => 'El grado no debe exceder los 50 caracteres.',
            ]);

            // Usar update() en lugar de asignaciones individuales + save()
            $updateData = [
                'phone' => $request->phone,
                'escalafon' => $request->escalafon,
                'grade' => $request->grade,
            ];

            // Manejar la foto de perfil (adaptado de tu código)
            if ($request->hasFile('photo')) {
                // Eliminar la foto anterior si existe
                if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Guardar la nueva foto
                $path = $request->file('photo')->store('profile_photos', 'public');
                $updateData['profile_photo_path'] = $path;
            }

            // Actualizar usuario usando el método update()
            User::where('id', $user->id)->update($updateData);

            return redirect()->back()->with('success', 'Perfil actualizado correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al actualizar el perfil: ' . $e->getMessage()]);
        }
    }

    /**
     * Actualizar contraseña
     */
    public function updatePassword(Request $request)
    {
        try {
            // Validación de contraseña
            $request->validate([
                'current_password' => 'required|string',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],
            ], [
                'current_password.required' => 'La contraseña actual es obligatoria.',
                'password.required' => 'La nueva contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            ]);

            $user = Auth::user();

            // Verificar contraseña actual
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors([
                    'current_password' => 'La contraseña actual no es correcta.'
                ]);
            }

            // Actualizar contraseña usando update()
            User::where('id', $user->id)->update([
                'password' => Hash::make($request->password)
            ]);

            // Invalidar otras sesiones por seguridad
            $this->logoutOtherDevices($request->password);

            return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al actualizar la contraseña: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar foto de perfil
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        try {
            // Eliminar foto siguiendo tu patrón de verificación
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
                
                // Limpiar campo en base de datos usando update()
                User::where('id', $user->id)->update([
                    'profile_photo_path' => null
                ]);
                
                return redirect()->back()->with('success', 'Foto de perfil eliminada correctamente.');
            } else {
                return redirect()->back()->with('info', 'No hay foto de perfil para eliminar.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al eliminar la foto: ' . $e->getMessage()]);
        }
    }

    /**
     * Cerrar otras sesiones del navegador - CORREGIDO
     * Método principal que usa tu modelo UserSession
     */
    public function logoutOtherSessions(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
            ], [
                'password.required' => 'La contraseña es obligatoria para confirmar esta acción.',
            ]);

            $user = Auth::user();

            // Verificar contraseña
            if (!Hash::check($request->password, $user->password)) {
                return redirect()->back()->withErrors([
                    'password' => 'La contraseña no es correcta.'
                ]);
            }

            // SOLUCION: Obtener la sesión actual para excluirla
            $currentSessionId = $this->getCurrentUserSessionId();
            
            // Cerrar otras sesiones en tu modelo UserSession
            // Marcar logout_at con la fecha actual para sesiones que no son la actual
            $query = UserSession::where('user_id', Auth::id())
                ->whereNull('logout_at'); // Solo sesiones activas
            
            // Si tenemos el ID de la sesión actual, excluirla
            if ($currentSessionId) {
                $query->where('id', '!=', $currentSessionId);
            } else {
                // Fallback: usar la sesión más reciente como actual
                $mostRecentSession = UserSession::where('user_id', Auth::id())
                    ->whereNull('logout_at')
                    ->orderBy('login_at', 'desc')
                    ->first();
                
                if ($mostRecentSession) {
                    $query->where('id', '!=', $mostRecentSession->id);
                }
            }
            
            $closedSessions = $query->update([
                'logout_at' => now()
            ]);

            // También cerrar sesiones estándar de Laravel si las usas
            $this->logoutOtherDevices($request->password);

            $message = $closedSessions > 0 
                ? "Se cerraron {$closedSessions} sesiones correctamente."
                : 'No había otras sesiones activas para cerrar.';

            return redirect()->back()->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al cerrar las sesiones: ' . $e->getMessage()]);
        }
    }

    /**
     * Obtener el ID de la sesión actual del usuario
     * NUEVO METODO para identificar correctamente la sesión actual
     */
    private function getCurrentUserSessionId()
    {
        try {
            $userId = Auth::id();
            $currentIp = request()->ip();
            $currentUserAgent = request()->userAgent();
            
            // Buscar una sesión que coincida con IP y User Agent actual
            $currentSession = UserSession::where('user_id', $userId)
                ->where('ip_address', $currentIp)
                ->whereNull('logout_at')
                ->where('system', $currentUserAgent)
                ->orderBy('login_at', 'desc')
                ->first();
            
            if ($currentSession) {
                return $currentSession->id;
            }
            
            // Fallback: tomar la más reciente de la IP actual
            $fallbackSession = UserSession::where('user_id', $userId)
                ->where('ip_address', $currentIp)
                ->whereNull('logout_at')
                ->orderBy('login_at', 'desc')
                ->first();
                
            return $fallbackSession ? $fallbackSession->id : null;
            
        } catch (\Exception $e) {
            Log::error('Error al obtener sesión actual: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Eliminar cuenta de usuario (opcional)
     */
    public function deleteAccount(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
            ], [
                'password.required' => 'La contraseña es obligatoria para confirmar esta acción.',
            ]);

            $user = Auth::user();

            // Verificar contraseña
            if (!Hash::check($request->password, $user->password)) {
                return redirect()->back()->withErrors([
                    'password' => 'La contraseña no es correcta.'
                ]);
            }

            // Eliminar foto de perfil si existe (siguiendo tu patrón)
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Obtener el ID antes de cerrar sesión
            $userId = $user->id;

            // Cerrar sesión del usuario
            Auth::logout();

            // Eliminar usuario usando Query Builder en lugar del modelo
            User::where('id', $userId)->delete();

            // Invalidar sesión
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Cuenta eliminada correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al eliminar la cuenta: ' . $e->getMessage()]);
        }
    }

    /**
     * Cerrar sesiones en otros dispositivos
     * Método privado para sesiones estándar de Laravel
     */
    private function logoutOtherDevices($password)
    {
        try {
            // Verificar que la contraseña sea correcta
            if (!Hash::check($password, Auth::user()->password)) {
                return false;
            }

            // En Laravel 11, usar el método Auth::logoutOtherDevices() si existe
            if (method_exists(Auth::class, 'logoutOtherDevices')) {
                Auth::logoutOtherDevices($password);
            }

            // Si usas base de datos para sesiones estándar de Laravel
            if (config('session.driver') === 'database') {
                DB::table('sessions')
                    ->where('user_id', Auth::id())
                    ->where('id', '!=', Session::getId())
                    ->delete();
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Error al cerrar otras sesiones estándar: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si es la sesión actual - MEJORADO
     */
    private function isCurrentSession($session)
    {
        $currentSessionId = $this->getCurrentUserSessionId();
        return $currentSessionId && $currentSessionId === $session->id;
    }

    /**
     * Extraer navegador del campo system (User Agent completo)
     */
    private function extractBrowser($userAgent)
    {
        if (strpos($userAgent, 'Edg/') !== false) return 'Edge';
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) return 'Safari';
        if (strpos($userAgent, 'Opera') !== false) return 'Opera';
        return 'Navegador Desconocido';
    }

    /**
     * Extraer plataforma del campo system (User Agent completo)
     */
    private function extractPlatform($userAgent)
    {
        if (strpos($userAgent, 'Windows NT 10.0') !== false) return 'Windows 10';
        if (strpos($userAgent, 'Windows NT') !== false) return 'Windows';
        if (strpos($userAgent, 'Macintosh') !== false || strpos($userAgent, 'Mac OS') !== false) return 'macOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) return 'iOS';
        return 'Sistema Desconocido';
    }

    /**
     * Obtener tipo de dispositivo
     */
    private function getDeviceType($device)
    {
        $device = strtolower($device);
        if (strpos($device, 'mobile') !== false || strpos($device, 'phone') !== false) return 'Móvil';
        if (strpos($device, 'tablet') !== false || strpos($device, 'ipad') !== false) return 'Tablet';
        return 'Escritorio';
    }

    /**
     * Obtener estadísticas del usuario - SIMPLIFICADO
     * Solo las estadísticas necesarias: total ingresos, semana, mes, primer y último ingreso
     */
    private function getUserStatistics($userId)
    {
        try {
            // Total de sesiones (ingresos)
            $totalSessions = \App\Models\UserSession::where('user_id', $userId)->count();
            
            // Primera sesión (primer ingreso)
            $firstSession = \App\Models\UserSession::where('user_id', $userId)
                ->orderBy('login_at', 'asc')
                ->first();
            
            // Última sesión (último ingreso)
            $lastSession = \App\Models\UserSession::where('user_id', $userId)
                ->orderBy('login_at', 'desc')
                ->first();
            
            // Sesiones del mes actual
            $currentMonthSessions = \App\Models\UserSession::where('user_id', $userId)
                ->whereMonth('login_at', now()->month)
                ->whereYear('login_at', now()->year)
                ->count();
            
            // Sesiones esta semana
            $thisWeekSessions = \App\Models\UserSession::where('user_id', $userId)
                ->whereBetween('login_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();
            
            return [
                'total_sessions' => $totalSessions,
                'current_month_sessions' => $currentMonthSessions,
                'this_week_sessions' => $thisWeekSessions,
                'first_login' => $firstSession ? $firstSession->login_at : null,
                'last_login' => $lastSession ? $lastSession->login_at : null,
            ];
            
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas: ' . $e->getMessage());
            return [
                'total_sessions' => 0,
                'current_month_sessions' => 0,
                'this_week_sessions' => 0,
                'first_login' => null,
                'last_login' => null,
            ];
        }
    }
}