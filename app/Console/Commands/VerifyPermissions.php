<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VerifyPermissions extends Command
{
    protected $signature = 'permissions:verify {user_id?}';
    protected $description = 'Verificar permisos de usuarios';

    public function handle()
    {
        $userId = $this->argument('user_id');

        if ($userId) {
            // Verificar un usuario específico
            $user = User::find($userId);
            if (!$user) {
                $this->error("Usuario con ID {$userId} no encontrado");
                return;
            }
            $this->showUserPermissions($user);
        } else {
            // Mostrar todos los usuarios
            $this->showAllUsers();
        }
    }

    private function showUserPermissions($user)
    {
        $this->info("=== Usuario: {$user->name} ({$user->email}) ===");
        
        // Mostrar roles
        $roles = $user->getRoleNames();
        if ($roles->count() > 0) {
            $this->line("Roles: " . $roles->implode(', '));
        } else {
            $this->error("❌ No tiene roles asignados");
        }

        // Mostrar permisos
        $permissions = $user->getAllPermissions();
        if ($permissions->count() > 0) {
            $this->line("Permisos:");
            foreach ($permissions as $permission) {
                $this->line("  ✅ {$permission->name}");
            }
        } else {
            $this->error("❌ No tiene permisos");
        }
        
        $this->line("");
    }

    private function showAllUsers()
    {
        $this->info("=== VERIFICACIÓN DE PERMISOS ===\n");
        
        // Mostrar roles y permisos disponibles
        $this->info("Roles disponibles:");
        foreach (Role::all() as $role) {
            $this->line("  - {$role->name}");
        }
        
        $this->line("");
        $this->info("Permisos disponibles:");
        foreach (Permission::all() as $permission) {
            $this->line("  - {$permission->name}");
        }
        
        $this->line("\n" . str_repeat("=", 50));
        
        // Mostrar usuarios
        $users = User::with('roles', 'permissions')->get();
        
        foreach ($users as $user) {
            $this->showUserPermissions($user);
        }
    }
}