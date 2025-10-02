<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductVisibilityController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'shop'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.products.visibility', compact('products'));
    }

    public function toggleStatus(Product $product)
    {
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        $message = $product->status === 'active' 
            ? "Product '{$product->name}' is now visible on frontend"
            : "Product '{$product->name}' is now hidden from frontend";

        return redirect()->back()->with('success', $message);
    }

    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();

        $message = $product->is_featured 
            ? "Product '{$product->name}' is now featured"
            : "Product '{$product->name}' is no longer featured";

        return redirect()->back()->with('success', $message);
    }
}
