<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ci_police' => ['required', 'string', 'max:20'],
            'phone' => [ 'string', 'max:15'],
            'grade' => [ 'string', 'max:50'],
            'escalafon' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Creación del usuario
        $user = User::create([
            'name' => $request->name,
            'ci_police' => $request->ci_police,
            'phone' => $request->phone,
            'grade' => $request->grade,
            'escalafon' => $request->escalafon,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Evento de registro
        event(new Registered($user));

        // Autenticación automática del usuario después del registro
        Auth::login($user);

        // Redirección al dashboard u otra ruta
        return redirect(route('dashboard', absolute: false));
    }
}
