<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * Redirect route based on the user's role
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return view('home');
        }
        
        // Check if user has any roles
        if ($user->roles->isEmpty()) {
            return view('home'); // Default view for users without roles
        }

        // Get the first role name
        $roleName = $user->roles->first()->name;

        switch ($roleName) {
            case 'admin':
                // Redirect to admin dashboard if needed
                break;
                
            case 'admin':
                // For shop owners, check if they have a shop
                $shop = $user->shop;
                
                // If user is a shop owner with a shop, redirect to dashboard
                if ($shop) {
                    return redirect()->route('shop-owner.dashboard');
                }
                // If shop owner doesn't have a shop, redirect to shop creation
                return redirect()->route('shop.create');
                
            case 'customer':
                // Handle customer redirection
                break;
                
            default:
                // Handle other roles or guest users
                break;
        }
        
        // Default fallback
        return view('home');
    }
}
