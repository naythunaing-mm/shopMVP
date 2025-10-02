<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categoriesMap = [
            'Electronic' => ['Mobile Phones', 'Laptops', 'Headphones', 'Smart Watches', 'Tablets'],
            'Shopfinity' => ['Fashion', 'Home & Garden', 'Sports', 'Books', 'Toys'],
            'SwiftBuy' => ['Groceries', 'Personal Care', 'Health', 'Beverages', 'Snacks'],
            'Velocity Auto Hub' => ['Car Parts', 'Motorcycles', 'Accessories', 'Tools', 'Maintenance'],
            'TechMart' => ['Gadgets', 'Computers', 'Gaming', 'Wearables', 'Audio'],
            'QuickShop' => ['Everyday Items', 'Home Supplies', 'Clothing', 'Electronics', 'Books'],
            'GadgetZone' => ['Smart Devices', 'Wearables', 'Audio', 'Accessories'],
            'MegaStore' => ['Furniture', 'Appliances', 'Decor', 'Sports', 'Toys'],
            'TrendHub' => ['Fashion', 'Accessories', 'Footwear', 'Beauty', 'Jewelry'],
            'UrbanMarket' => ['Groceries', 'Household', 'Personal Care', 'Organic', 'Snacks']
        ];

        foreach ($categoriesMap as $shopName => $categories) {
            $shop = Shop::where('name', $shopName)->first();

            if (!$shop) {
                $this->command->warn("Shop {$shopName} not found. Skipping.");
                continue;
            }

            foreach ($categories as $categoryName) {
                Category::firstOrCreate([
                    'name' => $categoryName,
                    'shop_id' => $shop->id
                ]);

                $this->command->info("Category '{$categoryName}' created for Shop '{$shopName}'");
            }
        }
    }
}
