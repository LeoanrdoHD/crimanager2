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
            ['name' => 'Juan Perez', 'role' => 'Admin', 'email_prefix' => 'admin'],
            ['name' => 'Ana López', 'role' => 'Admin', 'email_prefix' => 'admin'],
            ['name' => 'Carlos Gómez', 'role' => 'Admin', 'email_prefix' => 'admin'],
            ['name' => 'María Díaz', 'role' => 'Investigador', 'email_prefix' => 'investigador'],
            ['name' => 'Luis Sánchez', 'role' => 'Investigador', 'email_prefix' => 'investigador'],
            ['name' => 'Gabriela Torres', 'role' => 'Investigador', 'email_prefix' => 'investigador'],
            ['name' => 'Fernando Rojas', 'role' => 'Invitado', 'email_prefix' => 'invitado'],
            ['name' => 'Carmen Vargas', 'role' => 'Invitado', 'email_prefix' => 'invitado'],
            ['name' => 'José Hernández', 'role' => 'Invitado', 'email_prefix' => 'invitado'],
            ['name' => 'Lucía Castillo', 'role' => 'Invitado', 'email_prefix' => 'invitado'],
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
                'email' => "{$usuario['email_prefix']}{$indices[$usuario['email_prefix']]}@example.com",
                'password' => bcrypt('12345678'), // Contraseña cifrada
                'ci_police' => fake()->numerify('########'), // CI aleatorio
                'estado' => rand(0, 1), // Estado aleatorio entre 0 y 1
            ]);

            // Asignar rol
            $user->assignRole($usuario['role']);

            // Incrementar índice del correo
            $indices[$usuario['email_prefix']]++;
        }
    }
}
