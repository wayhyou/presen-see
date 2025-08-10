<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['Admin', 'HRD', 'Atasan', 'Karyawan'];

        $permissions = [
            'manage users',
            'manage attendances',
            'view reports',
            'request leave',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            switch ($roleName) {
                case 'Admin':
                    $role->syncPermissions($permissions);
                    break;
                case 'HRD':
                    $role->syncPermissions(['manage attendances', 'view reports']);
                    break;
                case 'Atasan':
                    $role->syncPermissions(['view reports']);
                    break;
                case 'Karyawan':
                    $role->syncPermissions(['request leave']);
                    break;
            }
        }
    }
}
