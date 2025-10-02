<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        try {
            // Load the user's roles and shop relationship
            $user->load(['roles', 'shop']);
            
            // Check if user has admin role
            if ($user->hasRole('admin')) {
                // If shop exists, redirect to dashboard, otherwise to shop creation
                if ($user->shop) {
                    return redirect()->route('shop-owner.dashboard');
                }
                return redirect()->route('shop.create')
                    ->with('info', 'Please complete your shop profile to continue.');
            }

            // For other users, check if they have access to dashboard
            if ($user->can('view_dashboard')) {
                return redirect()->intended($this->redirectPath());
            }

            // Default redirect
            return redirect('/');

        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'An error occurred during login. Please try again.');
        }
    }
}
