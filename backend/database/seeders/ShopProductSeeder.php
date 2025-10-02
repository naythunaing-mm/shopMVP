<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;

class ShopProductSeeder extends Seeder
{
    public function run()
    {
        $shops = Shop::all();

        foreach ($shops as $shop) {
            $categories = Category::where('shop_id', $shop->id)->get();

            foreach ($categories as $category) {
                $this->createProductsForCategory($shop, $category);
            }
        }
    }

    private function createProductsForCategory($shop, $category)
    {
        $productNames = $this->getProductNamesByCategory($category->name);

        foreach ($productNames as $product) {
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'discount' => rand(0, 20),
                'stock' => rand(10, 100),
                'category_id' => $category->id,
                'shop_id' => $shop->id,
                'status' => 'active',
                'is_featured' => rand(0, 1) === 1,
                'pics' => json_encode([$product['pic']]),
                'types' => json_encode(['Standard', 'Premium']),
                'colors' => json_encode(['Black', 'White', 'Blue']),
            ]);

            $this->command->info("Product '{$product['name']}' created for Category '{$category->name}' in Shop '{$shop->name}'");
        }
    }

    private function getProductNamesByCategory($categoryName)
    {
        $map = [
            'Mobile Phones' => [
                ['name' => 'iPhone 15 Pro', 'price' => 999.99, 'description' => 'Latest iPhone with advanced camera system', 'pic' => 'product_pics/mobile_iphone.jpg'],
                ['name' => 'Samsung Galaxy S24', 'price' => 899.99, 'description' => 'Flagship Android smartphone', 'pic' => 'product_pics/mobile_samsung.jpg'],
            ],
            'Laptops' => [
                ['name' => 'MacBook Pro M3', 'price' => 1999.99, 'description' => 'Professional laptop with M3 chip', 'pic' => 'product_pics/laptop_macbook.jpg'],
                ['name' => 'Dell XPS 13', 'price' => 1299.99, 'description' => 'Ultra-portable Windows laptop', 'pic' => 'product_pics/laptop_dell.jpg'],
            ],
            'Headphones' => [
                ['name' => 'Sony WH-1000XM5', 'price' => 349.99, 'description' => 'Industry-leading noise cancelling headphones', 'pic' => 'product_pics/headphones_sony.jpg'],
            ],
            'Fashion' => [
                ['name' => 'Designer Jacket', 'price' => 149.99, 'description' => 'Stylish winter jacket', 'pic' => 'product_pics/fashion_jacket.jpg'],
                ['name' => 'Running Shoes', 'price' => 89.99, 'description' => 'Comfortable athletic footwear', 'pic' => 'product_pics/fashion_shoes.jpg'],
            ],
            'Home & Garden' => [
                ['name' => 'Garden Tool Set', 'price' => 79.99, 'description' => 'Complete gardening toolkit', 'pic' => 'product_pics/garden_tools.jpg'],
            ],
            'Groceries' => [
                ['name' => 'Organic Apples', 'price' => 4.99, 'description' => 'Fresh organic apples (1kg)', 'pic' => 'product_pics/groceries_apples.jpg'],
                ['name' => 'Whole Grain Bread', 'price' => 3.49, 'description' => 'Healthy whole grain bread', 'pic' => 'product_pics/groceries_bread.jpg'],
            ],
            'Personal Care' => [
                ['name' => 'Shampoo & Conditioner', 'price' => 12.99, 'description' => 'Hair care combo pack', 'pic' => 'product_pics/personal_shampoo.jpg'],
            ],
            'Car Parts' => [
                ['name' => 'Brake Pads Set', 'price' => 89.99, 'description' => 'High-performance brake pads', 'pic' => 'product_pics/car_brake.jpg'],
            ],
            'Accessories' => [
                ['name' => 'LED Headlights', 'price' => 129.99, 'description' => 'Bright LED headlight kit', 'pic' => 'product_pics/car_headlight.jpg'],
            ],
            'General' => [
                ['name' => 'Generic Product', 'price' => 19.99, 'description' => 'Default product description', 'pic' => 'product_pics/default.jpg'],
            ]
        ];

        return $map[$categoryName] ?? $map['General'];
    }
}
