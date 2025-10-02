<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateShopOwnerUser extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'customer']);
        Role::firstOrCreate(['name' => 'admin']);

        // Create shop owner user
        $shopOwner = User::firstOrCreate(
            ['email' => 'shopowner@test.com'],
            [
                'name' => 'Test Shop Owner',
                'email' => 'shopowner@test.com',
                'password' => bcrypt('password'),
                'phone' => '1234567890',
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role
        if (!$shopOwner->hasRole('admin')) {
            $shopOwner->assignRole('admin');
        }

        // Create a demo shop
        if (!$shopOwner->shop) {
            Shop::create([
                'name' => 'Demo Electronics Store',
                'description' => 'Your one-stop shop for electronics and gadgets',
                'address' => '123 Tech Street, Silicon Valley',
                'street' => 'Tech Street',
                'unit' => '123',
                'postal_code' => '94000',
                'phone' => '555-0123',
                'social_links' => 'https://facebook.com/demoshop',
                'user_id' => $shopOwner->id,
            ]);
        }

        $this->command->info('Shop owner created successfully!');
        $this->command->info('Email: shopowner@test.com');
        $this->command->info('Password: password');
    }
}
