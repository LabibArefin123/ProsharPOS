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

    public function username()
    {
        return 'login';
    }

    protected function attemptLogin(Request $request)
    {
        $loginInput = $request->input($this->username());
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $password = $request->input('password');

        $user = User::where($field, $loginInput)->first();

        // Maintenance check
        $globalMaintenance = User::where('is_maintenance', 1)->first();
        if ($globalMaintenance && !$user?->hasRole('admin')) {
            session()->flash('error', $globalMaintenance->maintenance_message);
            return false;
        }

        return Auth::attempt([$field => $loginInput, 'password' => $password], $request->filled('remember'));
    }

    /**
     * ALWAYS runs after successful login.
     * This is the correct place to flash login_success.
     */
    protected function sendLoginResponse(Request $request)
    {
        logger('LOGIN_DEBUG: sendLoginResponse executed');
        logger('LOGIN_DEBUG: User = ' . Auth::user()->name);

        $request->session()->regenerate();

        session()->flash('login_success', 'Welcome back, ' . Auth::user()->name . '!');

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }


    protected function authenticated(Request $request, $user)
    {
        // You may keep this or leave empty — it's optional now
    }

    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('logout_success', 'Goodbye, ' . $userName . '! You have logged out successfully.');

        return redirect('/login');
    }
}
