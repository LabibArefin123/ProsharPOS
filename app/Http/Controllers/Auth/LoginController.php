<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     */
    protected string $redirectTo = '/dashboard';


    /**
     * Show login page
     */
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    /**
     * Handle login (Crypt-based)
     */

    public function login(LoginRequest $request, AuthService $authService)
    {
        $request->ensureIsNotRateLimited();

        $user = $authService->findUser($request->input('login'));

        if ($response = $authService->checkMaintenance($user)) {
            return $response;
        }

        if (!$user) {
            return $authService->failedLogin();
        }

        if ($response = $authService->checkUserBan($user)) {
            return $response;
        }

        if (!$authService->validatePassword($request->input('password'), $user)) {
            return $authService->failedLogin();
        }

        $authService->performLogin($request, $user);

        // ✅ ROLE BASED REDIRECT
        if ($user->hasRole('admin')) {
            return redirect()->intended('/dashboard');
        }

        if ($user->hasRole('manager')) {
            return redirect()->intended('/dashboard');
        }

        if ($user->hasRole('inventory_manager')) {
            return redirect()->intended('/products'); // ✅ YOUR REQUIREMENT
        }

        if ($user->hasRole('cashier')) {
            return redirect()->intended('/pos');
        }

        if ($user->hasRole('accountant')) {
            return redirect()->intended('/payments');
        }

        // fallback
        return redirect()->intended('/dashboard');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            activity('User')
                ->causedBy($user)
                ->log('User logged out');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
