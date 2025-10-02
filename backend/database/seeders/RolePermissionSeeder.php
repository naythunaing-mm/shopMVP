<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $shopOwnerRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Create permissions if needed
        $permissions = [
            'manage_shop',
            'manage_products',
            'manage_orders',
            'view_dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to admin role
        $shopOwnerRole->syncPermissions($permissions);
    }
}
