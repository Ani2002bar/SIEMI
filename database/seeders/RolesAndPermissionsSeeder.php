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

        // Definir roles y permisos
        $rolesWithPermissions = [
            'Administrador' => [
                'crear usuarios',
                'editar usuarios',
                'ver reportes',
            ],
            'Usuario' => [
                'ver reportes',
            ],
        ];

        // Crear permisos y roles
        foreach ($rolesWithPermissions as $roleName => $permissions) {
            // Crear o buscar rol
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Crear permisos y asignarlos al rol
            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permission);
            }

            $this->command->info("Rol '{$roleName}' actualizado con permisos.");
        }

        // Mensaje final
        $this->command->info('Roles y permisos creados o actualizados correctamente.');
    }
}
