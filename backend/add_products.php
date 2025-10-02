<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;

// Get all shops
$shops = Shop::all();

foreach ($shops as $shop) {
    echo "Processing shop: " . $shop->name . "\n";
    
    // Clear existing products and categories for this shop
    $shop->products()->delete();
    $shop->categories()->delete();
    
    // Create categories based on shop name
    $categories = [];
    switch (strtolower($shop->name)) {
        case 'electronic':
            $categoryNames = ['Mobile Phones', 'Laptops', 'Headphones', 'Smart Watches', 'Tablets'];
            $products = [
                ['name' => 'iPhone 15 Pro', 'price' => 999.99, 'category' => 'Mobile Phones'],
                ['name' => 'Samsung Galaxy S24', 'price' => 899.99, 'category' => 'Mobile Phones'],
                ['name' => 'MacBook Pro M3', 'price' => 1999.99, 'category' => 'Laptops'],
                ['name' => 'Dell XPS 13', 'price' => 1299.99, 'category' => 'Laptops'],
                ['name' => 'Sony WH-1000XM5', 'price' => 399.99, 'category' => 'Headphones'],
                ['name' => 'Apple Watch Series 9', 'price' => 399.99, 'category' => 'Smart Watches'],
                ['name' => 'iPad Pro 12.9"', 'price' => 1099.99, 'category' => 'Tablets'],
            ];
            break;
        case 'shopfinity':
            $categoryNames = ['Fashion', 'Home & Garden', 'Sports', 'Books', 'Toys'];
            $products = [
                ['name' => 'Designer Jacket', 'price' => 149.99, 'category' => 'Fashion'],
                ['name' => 'Running Shoes', 'price' => 89.99, 'category' => 'Fashion'],
                ['name' => 'Garden Tool Set', 'price' => 79.99, 'category' => 'Home & Garden'],
                ['name' => 'Yoga Mat', 'price' => 29.99, 'category' => 'Sports'],
                ['name' => 'Programming Book', 'price' => 49.99, 'category' => 'Books'],
                ['name' => 'Educational Toy', 'price' => 24.99, 'category' => 'Toys'],
            ];
            break;
        case 'swiftbuy':
            $categoryNames = ['Groceries', 'Personal Care', 'Health', 'Beverages', 'Snacks'];
            $products = [
                ['name' => 'Organic Apples', 'price' => 4.99, 'category' => 'Groceries'],
                ['name' => 'Whole Grain Bread', 'price' => 3.49, 'category' => 'Groceries'],
                ['name' => 'Shampoo & Conditioner', 'price' => 12.99, 'category' => 'Personal Care'],
                ['name' => 'Vitamin C Tablets', 'price' => 19.99, 'category' => 'Health'],
                ['name' => 'Green Tea', 'price' => 8.99, 'category' => 'Beverages'],
                ['name' => 'Mixed Nuts', 'price' => 15.99, 'category' => 'Snacks'],
            ];
            break;
        case 'velocity auto hub':
            $categoryNames = ['Car Parts', 'Motorcycles', 'Accessories', 'Tools', 'Maintenance'];
            $products = [
                ['name' => 'Brake Pads Set', 'price' => 89.99, 'category' => 'Car Parts'],
                ['name' => 'Engine Oil 5W-30', 'price' => 34.99, 'category' => 'Maintenance'],
                ['name' => 'LED Headlights', 'price' => 129.99, 'category' => 'Accessories'],
                ['name' => 'Motorcycle Helmet', 'price' => 199.99, 'category' => 'Motorcycles'],
                ['name' => 'Socket Wrench Set', 'price' => 79.99, 'category' => 'Tools'],
            ];
            break;
        default:
            $categoryNames = ['General', 'Popular', 'New Arrivals'];
            $products = [
                ['name' => 'Sample Product 1', 'price' => 29.99, 'category' => 'General'],
                ['name' => 'Sample Product 2', 'price' => 49.99, 'category' => 'Popular'],
                ['name' => 'Sample Product 3', 'price' => 19.99, 'category' => 'New Arrivals'],
            ];
    }
    
    // Create categories
    foreach ($categoryNames as $categoryName) {
        $category = Category::create([
            'name' => $categoryName,
            'shop_id' => $shop->id
        ]);
        $categories[$categoryName] = $category;
        echo "Created category: " . $categoryName . "\n";
    }
    
    // Create products
    foreach ($products as $index => $productData) {
        $category = $categories[$productData['category']] ?? $categories[array_key_first($categories)];
        
        Product::create([
            'name' => $productData['name'],
            'description' => 'High-quality ' . strtolower($productData['name']) . ' available now.',
            'price' => $productData['price'],
            'discount' => rand(0, 20),
            'stock' => rand(10, 100),
            'category_id' => $category->id,
            'shop_id' => $shop->id,
            'status' => 'active',
            'is_featured' => $index < 2,
            'pics' => json_encode(['product_pics/sample_' . ($index + 1) . '.jpg']),
            'types' => json_encode(['Standard', 'Premium']),
            'colors' => json_encode(['Black', 'White', 'Blue']),
        ]);
        echo "Created product: " . $productData['name'] . "\n";
    }
}

echo "\nCompleted! Products and categories added to all shops.\n";
echo "Total products: " . Product::count() . "\n";
echo "Total categories: " . Category::count() . "\n";
