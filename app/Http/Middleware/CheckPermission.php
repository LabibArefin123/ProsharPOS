<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $routeName = $request->route()->getName();

        // ✅ Always allowed routes
        $alwaysAllowed = [
            'dashboars',
            'user_profile_show',
            'user_profile_edit',
            'user_profile_update',
            'profile_picture_edit',
            'profile_picture_update',
            'user_password_edit',
            'user_password_update',
            'user_password_reset',
        ];

        // ✅ User Type 2 - restrict to profile-only
        if ($user->user_type == 2 && !in_array($routeName, $alwaysAllowed)) {
            abort(403, 'Access restricted to profile only');
        }

        // ✅ Allow access to always allowed routes
        if (in_array($routeName, $alwaysAllowed)) {
            return $next($request);
        }

        // ✅ Users with no role can only access basic routes
        if ($user->roles->isEmpty()) {
            abort(403, 'Access denied. No role assigned.');
        }

        // ✅ If specific permissions passed to middleware
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                if ($user->hasPermissionTo($permission)) {
                    return $next($request);
                }
            }
            abort(403, 'Permission denied.');
        }

        // ✅ If no permission passed, fallback to check by route name
        if ($routeName && $user->hasPermissionTo($routeName)) {
            return $next($request);
        }

        abort(403, 'Permission denied.');
    }
}
