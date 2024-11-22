<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cache de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            'crear usuarios',
            'editar usuarios',
            'ver reportes',
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Crear roles
        if (!Role::where('name', 'Administrador')->exists()) {
            $adminRole = Role::create(['name' => 'Administrador']);
        } else {
            $adminRole = Role::where('name', 'Administrador')->first();
        }

        if (!Role::where('name', 'Usuario')->exists()) {
            $userRole = Role::create(['name' => 'Usuario']);
        } else {
            $userRole = Role::where('name', 'Usuario')->first();
        }

        // Asignar permisos a roles
        $adminRole->givePermissionTo($permissions);

        if ($userRole) {
            $userRole->givePermissionTo(['ver reportes']);
        }

        $this->command->info('Roles y permisos creados o actualizados correctamente.');
    }
}
