<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class ShopOwnerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }


    /**
     * Display the shop owner's profile
     */
    public function index()
    {
        $user = Auth::user();
        $shop = $user->shop; // Using the hasOne relationship

        return view('pages.shop_owner.profile.index', compact('user', 'shop'));
    }

    /**
     * Show the form for editing the profile
     */
    public function edit()
    {
        $user = Auth::user();
        $shop = $user->shop;

        return view('pages.shop_owner.profile.edit', compact('user', 'shop'));
    }

    /**
     * Update the shop owner's profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Shop fields
            'shop_name' => 'nullable|string|max:255',
            'shop_description' => 'nullable|string|max:1000',
            'shop_address' => 'nullable|string|max:255',
            'shop_street' => 'nullable|string|max:255',
            'shop_unit' => 'nullable|string|max:50',
            'shop_postal_code' => 'nullable|string|max:20',
            'shop_phone' => 'nullable|string|max:20',
            'shop_social_links' => 'nullable|string|max:500',
            'shop_profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user information
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Handle password update
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $userData['password'] = Hash::make($request->password);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $userData['profile_image'] = $imagePath;
        }

        // Update user data using the User model's update method
        User::where('id', $user->id)->update($userData);

        // Update or create shop information
        if ($request->filled('shop_name')) {
            $shopData = [
                'name' => $request->shop_name,
                'description' => $request->shop_description,
                'address' => $request->shop_address,
                'street' => $request->shop_street,
                'unit' => $request->shop_unit,
                'postal_code' => $request->shop_postal_code,
                'phone' => $request->shop_phone,
                'social_links' => $request->shop_social_links,
                'user_id' => $user->id,
            ];

            // Get or create the user's shop
            $shop = $user->shop;

            if ($shop) {
                // Update existing shop
                $shop->update($shopData);
            } else {
                // Create new shop using the relationship
                $shop = $user->shop()->create($shopData);
            }

            // Handle shop profile picture upload
            if ($request->hasFile('shop_profile_pic') && $shop) {
                // Delete old shop image if exists
                if ($shop->profile_pic && Storage::disk('public')->exists($shop->profile_pic)) {
                    Storage::disk('public')->delete($shop->profile_pic);
                }

                $shopImagePath = $request->file('shop_profile_pic')->store('shop_images', 'public');
                $shop->update(['profile_pic' => $shopImagePath]);
            }
        }

        return redirect()->route('shop-owner.profile.index')->with('success', 'Profile updated successfully!');
    }

    /**
     * Display shop owner dashboard
     */
    public function dashboard()
    {
        try {
            // Get authenticated user with necessary relationships
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('No authenticated user');
            }

            // Initialize default stats
            $stats = [
                'total_products' => 0,
                'total_orders' => 0,
                'pending_orders' => 0,
                'completed_orders' => 0,
                'total_revenue' => 0,
            ];

            // Get the user's shop using the hasOne relationship
            $shop = $user->shop;

            if ($shop) {
                $stats['total_products'] = $shop->products()->count();
                $ordersQuery = $shop->orders();
                $stats['total_orders'] = $ordersQuery->count();
                $stats['pending_orders']   = (int) (clone $ordersQuery)->where('status', 'processing')->count();
                $stats['completed_orders'] = (int) (clone $ordersQuery)->where('status', 'completed')->count();

                $stats['total_revenue'] = (float) (clone $ordersQuery)
                    ->where('status', 'completed')
                    ->sum('total_amount');
            }


            return view('pages.shop_owner.dashboard', compact('user', 'shop', 'stats'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Dashboard error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            // Return error response
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load dashboard. Please try again.'
                ], 500);
            }

            return response()->view('errors.500', [
                'message' => 'An error occurred while loading the dashboard.'
            ], 500);
        }
    }
}
