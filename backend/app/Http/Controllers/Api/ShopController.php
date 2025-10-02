<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $shops = Shop::query();

        if ($search) {
            $shops->where(function ($q) use($search){
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        $result = $shops->paginate($request->limit ?? 10);

        // Transform shop data to include full image URLs and product count
        $transformedShops = collect($result->items())->map(function ($shop) {
            $shopArray = $shop->toArray();
            
            // Transform profile_pic to full URL if it exists
            if ($shop->profile_pic) {
                // Check if it's already a full URL or needs transformation
                if (!str_starts_with($shop->profile_pic, 'http')) {
                    // Remove 'storage/' prefix if it exists to avoid duplication
                    $imagePath = str_starts_with($shop->profile_pic, 'storage/') 
                        ? substr($shop->profile_pic, 8) 
                        : $shop->profile_pic;
                    
                    $shopArray['logo'] = url('storage/' . $imagePath);
                } else {
                    $shopArray['logo'] = $shop->profile_pic;
                }
            } else {
                $shopArray['logo'] = null;
            }
            
            // Add product count
            $shopArray['productCount'] = $shop->products()->count();
            
            return $shopArray;
        });

        return response()->json([
            'shops' => $transformedShops,
            'total' => $result->total(),
            'page' => $result->currentPage(),
            'limit' => $result->perPage()
        ], 200);
    }

    public function show($id)
    {
        $shop = Shop::with(['products.category', 'categories'])->findOrFail($id);
        $shopArray = $shop->toArray();
        
        // Transform profile_pic to full URL if it exists
        if ($shop->profile_pic) {
            // Check if it's already a full URL or needs transformation
            if (!str_starts_with($shop->profile_pic, 'http')) {
                // Remove 'storage/' prefix if it exists to avoid duplication
                $imagePath = str_starts_with($shop->profile_pic, 'storage/') 
                    ? substr($shop->profile_pic, 8) 
                    : $shop->profile_pic;
                
                $shopArray['logo'] = url('storage/' . $imagePath);
            } else {
                $shopArray['logo'] = $shop->profile_pic;
            }
        } else {
            $shopArray['logo'] = null;
        }
        
        // Add product and category counts
        $shopArray['productCount'] = $shop->products()->count();
        $shopArray['categoryCount'] = $shop->categories()->count();
        
        // Transform products with proper image URLs
        $shopArray['products'] = $shop->products->map(function ($product) {
            $productArray = $product->toArray();
            
            // Transform product images
            if ($product->pics) {
                $pics = json_decode($product->pics, true);
                if (is_array($pics)) {
                    $productArray['images'] = array_map(function ($pic) {
                        return url('storage/' . $pic);
                    }, $pics);
                } else {
                    $productArray['images'] = [];
                }
            } else {
                $productArray['images'] = [];
            }
            
            return $productArray;
        });
        
        return response()->json($shopArray, 200);
    }

    public function byUser($userId)
    {
        $shop = Shop::where('user_id', $userId)->firstOrFail();
        $shopArray = $shop->toArray();
        
        // Transform profile_pic to full URL if it exists
        if ($shop->profile_pic) {
            // Check if it's already a full URL or needs transformation
            if (!str_starts_with($shop->profile_pic, 'http')) {
                // Remove 'storage/' prefix if it exists to avoid duplication
                $imagePath = str_starts_with($shop->profile_pic, 'storage/') 
                    ? substr($shop->profile_pic, 8) 
                    : $shop->profile_pic;
                
                $shopArray['logo'] = url('storage/' . $imagePath);
            } else {
                $shopArray['logo'] = $shop->profile_pic;
            }
        } else {
            $shopArray['logo'] = null;
        }
        
        return response()->json($shopArray, 200);
    }
}
