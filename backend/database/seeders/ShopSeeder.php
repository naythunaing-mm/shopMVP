<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    public function run()
    {
        $shops = [
            'Electronic',
            'Shopfinity',
            'SwiftBuy',
            'Velocity Auto Hub',
            'TechMart',
            'QuickShop',
            'GadgetZone',
            'MegaStore',
            'TrendHub',
            'UrbanMarket'
        ];

        shuffle($shops);

        $userIds = range(1, 5);

        foreach ($userIds as $index => $userId) {
            Shop::firstOrCreate([
                'name' => $shops[$index]
            ], [
                'user_id' => $userId
            ]);

            $this->command->info("Shop '{$shops[$index]}' created for User ID: {$userId}");
        }
    }
}
