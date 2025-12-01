<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Unauthorized'); // User not logged in
        }

        // Get the current route name as permission (you must name routes properly)
        $routeName = $request->route()->getName();

        // Check if the permission exists in the database
        if (!Permission::where('name', $routeName)->where('guard_name', 'web')->exists()) {
            abort(403, "Permission '$routeName' does not exist.");
        }

        // Check if the user has this permission
        if (!$user->hasPermissionTo($routeName)) {
            throw UnauthorizedException::forPermissions([$routeName]);
        }

        return $next($request);
    }
}
