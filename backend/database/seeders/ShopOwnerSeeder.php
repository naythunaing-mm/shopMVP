<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ShopOwnerSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Ensure admin role exists
        Role::firstOrCreate(['name' => 'admin']);

        // Create a shop owner user
        $shopOwner = User::firstOrCreate(
            ['email' => 'shopowner@example.com'],
            [
                'name' => 'Shop Owner',
                'email' => 'shopowner@example.com',
                'password' => bcrypt('password123'),
                'phone' => '1234567890',
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role
        if (!$shopOwner->hasRole('admin')) {
            $shopOwner->assignRole('admin');
        }

        // Create a shop for this owner
        $shop = Shop::firstOrCreate(
            ['user_id' => $shopOwner->id],
            [
                'name' => 'Demo Shop',
                'description' => 'A demo shop for testing purposes',
                'address' => '123 Main Street',
                'street' => 'Main Street',
                'unit' => 'Unit 1',
                'postal_code' => '12345',
                'phone' => '1234567890',
                'social_links' => 'https://facebook.com/demoshop',
                'user_id' => $shopOwner->id,
            ]
        );

        echo "Shop owner created:\n";
        echo "Email: shopowner@example.com\n";
        echo "Password: password123\n";
        echo "Shop: {$shop->name}\n";
    }
}
