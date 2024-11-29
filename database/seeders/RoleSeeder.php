<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1= Role::create(['name'=>'Admin']);
        $role2= Role::create(['name'=>'Investigador']);
        $role3= Role::create(['name'=>'Invitado']);
        
       permission::create(['name'=>'Ver.Usuarios'])->syncRoles([$role1]);
        permission::create(['name'=>'Ver.Nuevo'])->syncRoles([$role1,$role2]);
        permission::create(['name'=>'Ver.Agregar'])->syncRoles([$role1,$role2]);
        permission::create(['name'=>'Ver.Editar'])->syncRoles([$role1]);
        permission::create(['name'=>'Ver.Historial'])->syncRoles([$role1,$role2,$role3]);
        permission::create(['name'=>'Ver.Criminal'])->syncRoles([$role1,$role2,$role3]);
        permission::create(['name'=>'Ver.ReporteR'])->syncRoles([$role1,$role2,$role3]);
    }
}
