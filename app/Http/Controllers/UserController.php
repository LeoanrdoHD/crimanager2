<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('admin_users.index', compact('usuarios'));
    }

    public function index_session()
    {
        $sessions = UserSession::with('user')
            ->orderBy('login_at', 'desc')
            ->get();

        return view('admin_users.user_sessions', compact('sessions'));
    }

    public function getSessionStats()
    {
        try {
            $sessions = UserSession::all();
            
            $stats = [
                'total' => $sessions->count(),
                'active' => $sessions->whereNull('logout_at')->count(),
                'unique' => $sessions->pluck('user_id')->unique()->count(),
                'today' => $sessions->where('login_at', '>=', today())->count()
            ];

            return response()->json($stats);
            
        } catch (\Exception $e) {
            Log::error('Error getting session stats: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function terminateSession(Request $request, $sessionId)
    {
        try {
            $userSession = UserSession::where('id', $sessionId)
                ->whereNull('logout_at')
                ->first();

            if (!$userSession) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesión no encontrada o ya está cerrada'
                ], 404);
            }

            $userSession->logout_at = now();
            $userSession->last_activity = now();
            $userSession->save();

            DB::table('sessions')
                ->where('user_id', $userSession->user_id)
                ->delete();

            Log::info('Session terminated by admin', [
                'session_id' => $sessionId,
                'terminated_user_id' => $userSession->user_id,
                'admin_user_id' => Auth::id(),
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sesión terminada exitosamente',
                'session_id' => $sessionId,
                'logout_at' => $userSession->logout_at->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            Log::error('Error terminating session: ' . $e->getMessage(), [
                'session_id' => $sessionId,
                'admin_user_id' => Auth::id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin_users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:150',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'roles' => 'nullable|array',
                'estado' => 'nullable|boolean',
                'ci_police' => [
                    'required',
                    'string',
                    'max:20',
                    'unique:users,ci_police',
                    'regex:/^\d{1,15}-[A-Z]{1,3}$/',
                ],
                'escalafon' => 'nullable|string|max:15',
                'grade' => 'required|string|max:20',
            ]);

            $password = preg_replace('/\D/', '', $validated['ci_police']) . 'daci';

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($password),
                'phone' => $validated['phone'] ?? null,
                'estado' => $request->has('estado') ? 1 : 0,
                'ci_police' => $validated['ci_police'],
                'escalafon' => $validated['escalafon'] ?? null,
                'grade' => $validated['grade'],
            ]);

            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $user->profile_photo_path = $path;
                $user->save();
            }

            if ($request->filled('roles')) {
                $user->roles()->sync($validated['roles']);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'Usuario creado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Ocurrió un error al crear el usuario.']);
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin_users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin_users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'phone' => 'nullable|string|max:15',
                'escalafon' => 'nullable|string|max:50',
                'grade' => 'nullable|string|max:50',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'roles' => 'nullable|array',
            ]);

            $user->phone = $validated['phone'] ?? null;
            $user->escalafon = $validated['escalafon'] ?? null;
            $user->grade = $validated['grade'] ?? null;
            $user->estado = $request->has('estado') ? 1 : 0;

            if ($request->boolean('reestablecer_password') && $request->filled('ci_police')) {
                $password = preg_replace('/\D/', '', $request->ci_police) . 'daci';
                $user->password = Hash::make($password);
            }

            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }
                
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $user->profile_photo_path = $path;
            }

            $user->save();

            if ($request->filled('roles')) {
                $roleNames = Role::whereIn('id', $validated['roles'])
                    ->where('guard_name', 'web')
                    ->pluck('name')
                    ->toArray();
                    
                $user->syncRoles($roleNames);
            } else {
                $user->syncRoles([]);
            }

            return redirect()->route('admin.users.show', ['admin_user' => $user->id])
                ->with('info', 'Usuario actualizado correctamente.');

        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar el usuario.']);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            
            $user->delete();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'Usuario eliminado correctamente.');
                
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar el usuario.']);
        }
    }
}