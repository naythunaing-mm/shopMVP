<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Shop;
use App\Models\Category;

try {
    // Create test shop
    $shop = Shop::firstOrCreate(
        ['id' => 1],
        [
            'name' => 'Test Shop',
            'description' => 'A test shop for demo purposes',
            'address' => '123 Test Street',
            'phone' => '123-456-7890',
            'email' => 'test@shop.com',
            'user_id' => 1
        ]
    );
    echo "Shop created/found with ID: " . $shop->id . PHP_EOL;

    // Create test category
    $category = Category::firstOrCreate(
        ['id' => 1],
        [
            'name' => 'Electronics',
            'description' => 'Electronic products'
        ]
    );
    echo "Category created/found with ID: " . $category->id . PHP_EOL;

    echo "Test data creation completed successfully!" . PHP_EOL;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
