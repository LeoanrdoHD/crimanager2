<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\UserSession;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_session()
    {
        // Obtener todas las sesiones
        $sessions = UserSession::all();

        // Pasar las sesiones a la vista
        return view('admin_users.user_sessions', compact('sessions'));
    }
    public function index()
    {
        $usuarios = User::all();
        return view('admin_users.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin_users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validación
            $request->validate([
                'name' => 'required|string|max:150',
                'email' => 'required|email|unique:users,email',
                'password' => 'nullable',
                'phone' => 'nullable|string',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'roles' => 'nullable|array',
                'estado' => 'nullable|boolean', // Cambié esto para que sea nullable, ya que puede no enviarse
                'ci_police' => [
                    'required',
                    'string',
                    'max:20',
                    'unique:criminals,identity_number',
                    'regex:/^\d{1,15}-[A-Z]{1,3}$/',
                ],
                'escalafon' => 'nullable|string|max:15',
                'grade' => 'string|max:20',
            ]);

            // Generar la contraseña con el formato CI + 'daci'
            $password = preg_replace('/\D/', '', $request->ci_police) . 'daci';

            // Asignar el valor de 'estado'. Si no se envía, se asigna 0 por defecto.
            $estado = $request->has('estado') ? $request->estado : 0;

            // Guardar usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'phone' => $request->phone,
                'estado' => $estado, // Asignar el valor de 'estado'
                'ci_police' => $request->ci_police,
                'escalafon' => $request->escalafon,
                'grade' => $request->grade,
            ]);

            // Guardar foto de perfil si existe
            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $user->profile_photo_path = $path;
                $user->save();
            }

            // Asignar roles
            if ($request->roles) {
                $user->roles()->sync($request->roles);
            }

            // Redireccionar con mensaje de éxito
            return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, redirigir de vuelta al formulario con los datos antiguos y mensaje de error
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al crear el usuario: ' . $e->getMessage()]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin_users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin_users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Buscar el usuario por ID
        $user = User::findOrFail($id);

        // Validar que el usuario existe (FindOrFail ya maneja esto automáticamente)
        if (!$user) {
            return back()->withErrors(['error' => 'Usuario no encontrado.']);
        }
        $validated = $request->validate([
            'phone' => 'nullable|string|max:15',
            'escalafon' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:50',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // Agrega las validaciones de imagen si es necesario
        ]);

        // Actualiza los campos normales (phone, escalafon, grade)
        $user->phone = $request->phone;
        $user->escalafon = $request->escalafon;
        $user->grade = $request->grade;
        // Verificar si se necesita actualizar la contraseña
        if ($request->has('reestablecer_password') && $request->reestablecer_password == true) {
            // Generar la contraseña con el formato CI + 'daci'
            $password = preg_replace('/\D/', '', $request->ci_police) . 'daci';

            // Actualizar la contraseña del usuario
            $user->password = Hash::make($password);
        }

        // Verifica si se ha subido una nueva foto de perfil
        if ($request->hasFile('profile_photo')) {
            // Elimina la foto de perfil anterior si existe
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Guarda la nueva foto de perfil
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->estado = $request->has('estado') ? 1 : 0;

        // Actualiza el usuario en la base de datos
        $user->save();

        // Validar que los roles seleccionados son válidos
        if ($request->has('roles')) {
            $roles = \Spatie\Permission\Models\Role::whereIn('id', $request->roles)
                ->where('guard_name', 'web') // Asegurarse de que los roles pertenecen al guard correcto
                ->pluck('name')
                ->toArray();

            if (count($roles) !== count($request->roles)) {
                return back()->withErrors(['error' => 'Uno o más roles no son válidos.']);
            }

            // Sincronizar roles
            $user->syncRoles($roles);
        } else {
            // Si no hay roles, eliminar todos los roles del usuario
            $user->syncRoles([]);
        }

        // Redirigir con el parámetro correcto
        return redirect()->route('admin.users.show', ['admin_user' => $user->id])
            ->with('info', 'Se actualizaron los datos correctamente.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
