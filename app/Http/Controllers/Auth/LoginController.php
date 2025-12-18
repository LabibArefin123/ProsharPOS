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

    protected $redirectTo = '/home';

    /**
     * Login field name
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Custom login logic
     */
    protected function attemptLogin(Request $request)
    {
        $loginInput = $request->input('login');
        $password   = $request->input('password');

        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $user = User::where($field, $loginInput)->first();

        // Maintenance check
        $maintenance = User::where('is_maintenance', 1)->first();
        if ($maintenance && (!$user || !$user->hasRole('admin'))) {
            session()->flash('login_error', $maintenance->maintenance_message);
            return false;
        }

        return Auth::attempt(
            [$field => $loginInput, 'password' => $password],
            $request->filled('remember')
        );
    }

    /**
     * ✅ THIS is where login success MUST be handled
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        session()->flash(
            'login_success',
            'Welcome back, ' . Auth::user()->name . '!'
        );

        $this->clearLoginAttempts($request);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $name = Auth::user()->name ?? 'User';

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash(
            'logout_success',
            'Goodbye, ' . $name . '! You have logged out successfully.'
        );

        return redirect('/login');
    }
}
