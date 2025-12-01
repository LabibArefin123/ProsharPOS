<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect users after login.
     */
    protected $redirectTo = '/home';

    /**
     * Custom login field (username or email).
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Handle login using either email or username.
     */
    protected function attemptLogin(Request $request)
    {
        $loginInput = $request->input($this->username());
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $password = $request->input('password');

        $user = User::where($field, $loginInput)->first();

        $globalMaintenance = User::where('is_maintenance', 1)->first();

        if ($globalMaintenance && !$user->hasRole('admin')) {
            session()->flash('error', $globalMaintenance->maintenance_message);
            return false;
        }

        return Auth::attempt([$field => $loginInput, 'password' => $password], $request->filled('remember'));
    }

    /**
     * Handle actions after successful login.
     */
    protected function authenticated(Request $request, $user)
    {
        // Flash a session variable for SweetAlert
        session()->flash('login_success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Flash message for logout
        session()->flash('logout_success', 'Goodbye, ' . $userName . '! You have logged out successfully.');

        return redirect('/login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
