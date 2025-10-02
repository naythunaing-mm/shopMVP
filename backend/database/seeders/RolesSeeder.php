<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $roles = [
            ['name' => 'shop-owner', 'guard_name' => 'web'],
            ['name' => 'user', 'guard_name' => 'web'],
            ['name' => 'customer', 'guard_name' => 'web'],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']]
            );
        }


        $permissions = [
            'manage categories',
            'manage products',
            'view orders',
            'place orders',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web']
            );
        }

        // Assign permissions to roles
        $admin = Role::where('name', 'shop-owner')->first();
        $customer = Role::where('name', 'customer')->first();

        if ($admin) {
            $admin->givePermissionTo(Permission::all());
        }

        if ($customer) {
            $customer->givePermissionTo([
                'view orders',
                'place orders',
            ]);
        }
    }
}
