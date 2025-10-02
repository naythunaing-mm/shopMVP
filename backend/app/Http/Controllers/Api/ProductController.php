<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $sort = $request->sort; // newest, price_low, price_high, name_asc, name_desc
        $category = $request->category;
        $shop = $request->shop;
        
        // Get all products with relationships
        $products = Product::with(['category', 'shop']);
            
        if($category){
            $products->where('category_id', $category);
        }
        if($shop){
            $products->where('shop_id', $shop);
        }
        if ($search) {
            $products->where(function ($q) use($search){
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }
        switch ($sort) {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $products->orderBy('price');
                break;
            case 'price_high':
                $products->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $products->orderBy('name');
                break;
            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;
        }
        $response = new ProductCollection($products->paginate($request->limit ?? 40));
        return $response;
    }

    public function show($id)
    {
        $product = Product::with(['category', 'shop'])->findOrFail($id);
        return new \App\Http\Resources\Api\ProductResource($product);
    }

    public function byCategory(Request $request, $categoryId)
    {
        $search = $request->search;
        $sort = $request->sort;
        $products = Product::where('category_id', $categoryId);

        if ($search) {
            $products->where(function ($q) use($search){
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        switch ($sort) {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $products->orderBy('price');
                break;
            case 'price_high':
                $products->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $products->orderBy('name');
                break;
            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;
        }

        $response = new ProductCollection($products->paginate($request->limit ?? 40));
        return $response;
    }

    public function byShop(Request $request, $shopId)
    {
        $search = $request->search;
        $sort = $request->sort;
        $products = Product::where('shop_id', $shopId);

        if ($search) {
            $products->where(function ($q) use($search){
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        switch ($sort) {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $products->orderBy('price');
                break;
            case 'price_high':
                $products->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $products->orderBy('name');
                break;
            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;
        }

        $response = new ProductCollection($products->paginate($request->limit ?? 40));
        return $response;
    }
}
