<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;

// Clear existing products and categories
Product::truncate();
Category::truncate();

$shops = Shop::all();

foreach ($shops as $shop) {
    echo "Adding products to shop: " . $shop->name . "\n";
    
    // Create categories
    $categories = [];
    switch (strtolower($shop->name)) {
        case 'electronic':
            $categoryNames = ['Mobile Phones', 'Laptops', 'Headphones'];
            break;
        case 'shopfinity':
            $categoryNames = ['Fashion', 'Home & Garden', 'Sports'];
            break;
        case 'swiftbuy':
            $categoryNames = ['Groceries', 'Personal Care', 'Health'];
            break;
        case 'velocity auto hub':
            $categoryNames = ['Car Parts', 'Accessories', 'Tools'];
            break;
        default:
            $categoryNames = ['General', 'Popular'];
    }
    
    foreach ($categoryNames as $name) {
        $category = Category::create([
            'name' => $name,
            'shop_id' => $shop->id
        ]);
        $categories[] = $category;
    }
    
    // Create products
    for ($i = 1; $i <= 5; $i++) {
        $category = $categories[array_rand($categories)];
        
        Product::create([
            'name' => $shop->name . ' Product ' . $i,
            'description' => 'High quality product from ' . $shop->name,
            'price' => rand(20, 200) + 0.99,
            'discount' => rand(0, 20),
            'stock' => rand(10, 100),
            'category_id' => $category->id,
            'shop_id' => $shop->id,
            'status' => 'active',
            'is_featured' => $i <= 2,
            'pics' => null, // No images for now
            'types' => json_encode(['Standard']),
            'colors' => json_encode(['Black', 'White']),
        ]);
    }
}

echo "Created " . Product::count() . " products\n";
echo "Created " . Category::count() . " categories\n";
