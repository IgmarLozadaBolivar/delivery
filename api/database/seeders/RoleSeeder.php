<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleCamionero = Role::create(['name' => 'camionero']);

        // Permisos
        Permission::create(['name' => 'ver paquetes']);
        Permission::create(['name' => 'listar paquetes']);

        // Asignación de permisos
        $roleAdmin->givePermissionTo(Permission::all());
        $roleCamionero->givePermissionTo(['ver paquetes', 'listar paquetes']);
    }
}
