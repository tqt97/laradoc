<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $config = config('roles_permissions');

        // Create all permissions
        $allPermissions = [];
        foreach ($config['roles'] as $roleName => $roleData) {
            if ($roleData['permissions'] === '*') {
                continue;
            }
            foreach ($roleData['permissions'] as $permission) {
                if (! in_array($permission, $allPermissions)) {
                    $allPermissions[] = $permission;
                    Permission::firstOrCreate(['name' => $permission]);
                }
            }
        }

        // Create roles and assign permissions
        foreach ($config['roles'] as $roleName => $roleData) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            if ($roleData['permissions'] === '*') {
                // Super admin gets all permissions
                // Actually Spatie recommends using a gate for super-admin bypass
            } else {
                $role->syncPermissions($roleData['permissions']);
            }
        }

        // Create Super Admin user
        $superAdminConfig = $config['super-admin'];
        $user = User::where('email', $superAdminConfig['email'])->first();

        if (! $user) {
            $user = User::create([
                'name' => $superAdminConfig['name'],
                'email' => $superAdminConfig['email'],
                'password' => Hash::make($superAdminConfig['password']),
            ]);
        }

        $user->assignRole('super-admin');
    }
}
