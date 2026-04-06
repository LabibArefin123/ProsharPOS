<?php

namespace App\Services;

use App\Models\User;
use App\Models\BanUser;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class AuthService
{
    // 🔐 FIND USER
    public function findUser(string $loginInput): ?User
    {
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        return User::where($field, $loginInput)->first();
    }

    // 🚧 CHECK GLOBAL MAINTENANCE
    public function checkMaintenance(?User $user)
    {
        $globalMaintenance = User::where('is_maintenance', 1)->first();

        if ($globalMaintenance && (!$user || !$user->hasRole('admin'))) {
            return back()->with('maintenance', $globalMaintenance->maintenance_message);
        }

        return null;
    }

    // ❌ FAILED LOGIN RESPONSE
    public function failedLogin()
    {
        return back()->withErrors([
            'login' => trans('auth.failed'),
        ]);
    }

    // ⛔ CHECK USER BAN
    public function checkUserBan(User $user)
    {
        if ($user->is_banned) {
            $ban = BanUser::where('user_id', $user->id)
                ->where('is_banned', true)
                ->latest('banned_at')
                ->first();

            return back()->with(
                'banned',
                $ban?->ban_reason ?? 'Your account has been banned. Please contact support.'
            );
        }

        return null;
    }

    // 🔑 VALIDATE PASSWORD
    public function validatePassword(string $password, User $user): bool
    {
        return Hash::check($password, $user->password);
    }

    // ✅ PERFORM LOGIN
    public function performLogin(Request $request, User $user): string
    {
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // ✅ FIRST check device
        $this->checkDeviceBan($request, $user);

        // ✅ THEN log activity
        activity('User')->causedBy($user)->log('User logged in');

        // Track device
        $this->trackUserDevice($request, $user);

        return 'Welcome back, ' . $user->name . '!';
    }
    
    // ✅ PERFORM LOGOUT
    public function performLogout(Request $request): string
    {
        $user = Auth::user();

        if ($user) {
            activity('User')->causedBy($user)->log('User logged out');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return 'You have successfully logged out.';
    }

    // -----------------------------
    // PRIVATE METHODS
    // -----------------------------
    private function checkDeviceBan(Request $request, User $user)
    {
        $banned = UserDevice::where('user_id', $user->id)
            ->where('ip_address', $request->ip())
            ->where('user_agent', $request->userAgent())
            ->where('is_banned', true)
            ->first();

        if ($banned) {
            Auth::logout();
            abort(403, 'Your device is banned. Contact admin.');
        }
    }

    private function trackUserDevice(Request $request, User $user)
    {
        $agent = new Agent();

        UserDevice::updateOrCreate(
            [
                'user_id'    => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
            [
                'device_name'   => $agent->device() ?: 'Desktop',
                'device_type'   => $agent->platform() . ' - ' . $agent->browser(),
                'last_login_at' => now(),
            ]
        );
    }
}
