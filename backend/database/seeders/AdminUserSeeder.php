<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $customerRole = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Create the first main admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'phone' => '1234567890',
                'email_verified_at' => now(),
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: admin123');

        // Create Admin 1 to Admin 5
        for ($i = 1; $i <= 5; $i++) {
            $adminUser = User::firstOrCreate(
                ['email' => "admin{$i}@gmail.com"],
                [
                    'name' => "Admin {$i}",
                    'email' => "admin{$i}@gmail.com",
                    'password' => Hash::make('admin123'),
                    'phone' => '100000000' . $i,
                    'email_verified_at' => now(),
                ]
            );

            if (!$adminUser->hasRole('admin')) {
                $adminUser->assignRole('admin');
            }

            $this->command->info("Admin {$i} created successfully! Email: admin{$i}@gmail.com, Password: admin123");
        }

        // Create 5 customer users
        for ($i = 1; $i <= 5; $i++) {
            $customer = User::firstOrCreate(
                ['email' => "customer{$i}@gmail.com"],
                [
                    'name' => "Customer {$i}",
                    'email' => "customer{$i}@gmail.com",
                    'password' => Hash::make('password123'),
                    'phone' => '987654321' . $i,
                    'email_verified_at' => now(),
                ]
            );

            if (!$customer->hasRole('customer')) {
                $customer->assignRole('customer');
            }

            $this->command->info("Customer {$i} created successfully! Email: customer{$i}@gmail.com, Password: password123");
        }
    }
}
