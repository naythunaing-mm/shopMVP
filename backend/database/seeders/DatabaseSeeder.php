<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call([
            RolePermissionSeeder::class,
            RolesSeeder::class,
            AdminUserSeeder::class,
            ShopSeeder::class,
            CategorySeeder::class,
            ShopProductSeeder::class,
        ]);

        // Create admin user first
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'phone' => '1234567890',
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Create fake 10 users
        User::factory(10)->create(); // running database > factories > UserFactory.php
        $users = User::where('email', '!=', 'admin@example.com')->get();

        // Assign random roles to created users (excluding admin)
        $users->each(function ($user) {
            $roles = ['admin', 'customer'];
            $user->assignRole($roles[array_rand($roles)]);
        });
    }
}
