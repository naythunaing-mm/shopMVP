<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|string|in:customer,admin'
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials!'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Check if user has the required role if specified
        $requiredRole = $request->input('role');
        if ($requiredRole && !$user->hasRole($requiredRole)) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            return response()->json(['message' => 'You are not authorized to access this area.'], 403);
        }
        
        // Ensure user is active
        if (isset($user->status) && $user->status !== 'active') {
            // Invalidate the current session
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json(['message' => 'Your account is not active. Please contact support.'], 403);
        }
        
        // Start transaction for role assignment
        DB::beginTransaction();
        
        try {
            // First, try to find if user is a shop owner by checking if they have a shop
            $shop = Shop::where('user_id', $user->id)->first();
            $isShopOwner = $shop !== null;
            
            // Remove all existing roles to prevent duplicates
            $user->syncRoles([]);
            
            // Set role based on shop ownership
            $roleName = $isShopOwner ? 'admin' : 'customer';
            
            // Ensure the role exists
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['guard_name' => 'web']
            );
            
            // Assign role to user
            $user->assignRole($role);
            
            // If shop owner, make sure the shop is loaded in the relationship
            if ($isShopOwner && $shop) {
                $user->setRelation('shop', $shop);
            }
            
            // Commit transaction
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Login error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing your request. Please try again.'], 500);
        }
        
        // Create token for the user
        $token = $user->createToken('auth_token')->plainTextToken;
        
        // Reload the user with relationships
        $user->load(['roles:name', 'permissions:name']);
        
        // Get role names
        $roleNames = $user->roles->pluck('name');
        $isShopOwner = $roleNames->contains('admin');
        
        // If shop owner, load the shop relationship
        if ($isShopOwner) {
            $user->load('shop');
        }
        
        // Prepare user data
        $userData = $user->only(['id', 'name', 'email', 'phone']);
        
        // Initialize the response data
        $responseData = [
            'user' => $userData,
            'roles' => $roleNames,
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'token' => $token,
            'is_admin' => $isShopOwner,
            'has_shop' => $user->shop ? true : false
        ];
        
        // Add shop info if user is a shop owner and has a shop
        if ($isShopOwner && $user->shop) {
            $responseData['shop'] = [
                'id' => $user->shop->id,
                'name' => $user->shop->name,
                'description' => $user->shop->description,
                'phone' => $user->shop->phone,
                'address' => $user->shop->address,
                'postal_code' => $user->shop->postal_code
            ];
        }
        
        // Check if user is a shop owner
        if ($roleNames->contains('admin')) {
            // Ensure the shop exists for the shop owner
            if (!$user->shop) {
                $shop = new Shop([
                    'name' => $user->name . "'s Shop",
                    'description' => 'Welcome to my shop!',
                    'address' => 'Update your shop address',
                    'street' => '',
                    'unit' => '',
                    'postal_code' => '',
                    'phone' => $user->phone ?? '',
                    'social_links' => '[]',
                ]);
                $user->shop()->save($shop);
                $user->load('shop');
            }
            
            // Add shop info to the response
            $responseData['shop'] = $user->shop;
        }
        
        return response()->json($responseData);
    }

    public function logout(Request $request)
    {
        try {
            // Revoke the current access token
            if ($request->user()) {
                $request->user()->currentAccessToken()?->delete();
            }
            
            // Logout from web guard if needed
            auth('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json(['message' => 'Error during logout. Please try again.'], 500);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|string|in:customer,admin' // Optional role parameter
        ]);
        
        $userData = $request->only(['name', 'email', 'password']);
        $userData['password'] = bcrypt($userData['password']);
        
        // Start database transaction
        \DB::beginTransaction();
        
        try {
            $user = User::create($userData);
            
            if (!$user) {
                throw new \Exception('Failed to create user');
            }
            
            // Determine role (default to 'customer' if not specified)
            $roleName = $request->input('role', 'customer');
            
            // Ensure the role exists
            $role = \Spatie\Permission\Models\Role::firstOrCreate(
                ['name' => $roleName],
                ['guard_name' => 'web']
            );
            
            // Assign role to user
            $user->assignRole($role);
            
            // If it's a shop owner, create a default shop
            if ($roleName === 'admin') {
                $shop = new Shop([
                    'name' => $user->name . "'s Shop",
                    'description' => 'Welcome to my shop!',
                    'address' => 'Update your shop address',
                    'street' => '',
                    'unit' => '',
                    'postal_code' => '',
                    'phone' => $user->phone ?? '',
                    'social_links' => '[]',
                ]);
                $user->shop()->save($shop);
            }
            
        } catch (\Exception $e) {
            // Rollback the transaction on error
            \DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            return response()->json(['message' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }

    public function getUser(Request $request)
    {
        $user = $request->user();
        
        if ($user->hasRole('admin') && $user->shop) {
            $user->load('shop');
        }
        
        return $user;
    }
}
