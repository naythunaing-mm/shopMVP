<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AssignProductImages extends Seeder
{
    public function run()
    {
        // Get all available images from storage
        $images = collect(Storage::disk('public')->files('product_pics'))
            ->map(function ($path) {
                return basename($path);
            })
            ->values()
            ->toArray();

        if (empty($images)) {
            $this->command->info('No images found in storage/product_pics/');
            return;
        }

        // Get all products
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->info('No products found in database');
            return;
        }

        // Assign random images to products
        foreach ($products as $product) {
            // Randomly assign 1-3 images per product
            $numImages = rand(1, min(3, count($images)));
            $selectedImages = collect($images)->random($numImages)->toArray();
            
            // Convert array to comma-separated string for database storage
            $product->pics = implode(',', $selectedImages);
            $product->save();
            
            $this->command->info("Assigned images to product: {$product->name}");
        }

        $this->command->info('Successfully assigned images to all products!');
    }
}
