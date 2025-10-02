<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopStoreRequest;
use App\Http\Requests\ShopUpdateRequest;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // $shops = $user->shops;
        $shops = Shop::where('user_id', $user->id)->get();
    // dd($shops);
        return view('pages.shop_owner.shop.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.shop_owner.shop.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopStoreRequest $request)
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            
            // Check if user already has a shop
            if ($user->shop) {
                return redirect()->route('shop-owner.dashboard')
                    ->with('warning', 'You already have a shop.');
            }
            
            $fileName = null;
            if ($request->hasFile('profile_pic')) {
                $fileName = $this->storeShopImage($request->file('profile_pic'), $request->name);
            }
            
            $data = [
                ...$request->except('_token'), 
                'profile_pic' => $fileName ?? "",
                'user_id' => $user->id // Ensure user_id is set
            ];
            
            $shop = Shop::create($data);

            if ($shop) {
                // Refresh the user to load the new shop relationship
                $user->load('shop');
                // dd($user->shop);
                return redirect()->route('shop-owner.dashboard')
                    ->with('success', 'Shop created successfully! You can now manage your shop.');
            }
            
            return redirect()->back()
                ->with('error', 'Failed to create shop. Please try again.');
                
        } catch (\Exception $e) {
            Log::error('Shop creation error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while creating your shop. Please try again.');
        }
    }

    /*
     * Store Shops profile picture into the public/shops folder
     */
    private function storeShopImage($file, $shopName): string
    {
        // If request has a file then save the file and give the name to shop_name.extension and save in storage
        // Escape special characters and replace spaces with underscore
        $shopName = preg_replace('/\W+/', '', $shopName);

        $preservedFileName = $shopName . "." . $file->getClientOriginalExtension(); // shope_name.png
        // replace the request's file with the filename
        Storage::disk('public')->putFileAs('shops/' . $shopName, $file, $preservedFileName);
        return 'storage/shops/' . $shopName .'/'. $preservedFileName;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\View\View
     */
    public function show(Shop $shop)
    {
        /** @var User $user */
       
        $user = Auth::user();
        
        if ($shop->user_id !== $user->getAuthIdentifier()) {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.shop_owner.shop.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($shop->user_id !== $user->getAuthIdentifier()) {
            abort(403, 'Unauthorized');
        }
        return view('pages.shop_owner.shop.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShopUpdateRequest $request, Shop $shop)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($shop->user_id !== $user->getAuthIdentifier()) {
            abort(403, 'Unauthorized');
        }

        $fileName = null;
        // If request has a file then save the file and give the name to shop_name.extension and save in storage
        if ($request->hasFile('profile_pic')) {
            $shopName = $request->name ?? $shop->name ?? 'shop';
            $fileName = $this->storeShopImage($request->file('profile_pic'), $shopName);
        }
        
        $data = $request->except('_token', '_method');
        if ($fileName) {
            $data['profile_pic'] = $fileName;
        }
        
        $shop->update($data);
        return redirect()->route('shop.show', $shop)->with('success', 'Shop updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($shop->user_id !== $user->getAuthIdentifier()) {
            abort(403, 'Unauthorized');
        }

        // Remove storage directory for this shop
        $sanitized = preg_replace('/\W+/', '', $shop->name);

        $shop->delete();
        return redirect()->route('shop.index')->with('success', 'Shop deleted successfully');
    }
}
