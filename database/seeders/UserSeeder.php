<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de usuarios con roles específicos
        $usuarios = [
            ['name' => 'Super Admin', 'role' => 'Admin', 'email_prefix' => 'admin'],
        ];

        // Contador para generar correos únicos
        $indices = [
            'admin' => 1,
            'investigador' => 1,
            'invitado' => 1,
        ];

        foreach ($usuarios as $usuario) {
            // Crear usuario
            $user = User::create([
                'name' => $usuario['name'],
                'email' => "{$usuario['email_prefix']}{$indices[$usuario['email_prefix']]}@gmail.com",
                'password' => bcrypt('12345678'), // Contraseña cifrada
                'ci_police' => fake()->numerify('########'), // CI aleatorio
                'estado' => 1, // Estado aleatorio entre 0 y 1
            ]);

            // Asignar rol
            $user->assignRole($usuario['role']);

            // Incrementar índice del correo
            $indices[$usuario['email_prefix']]++;
        }
    }
}
