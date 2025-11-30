<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserCategory;
use App\Models\Organization;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->q ?? $request->adminlteSearch;

        if (!$q) {
            return response()->json([]);
        }

        $organizations = Organization::where('name', 'LIKE', "%$q%")
            ->get(['id', 'name'])
            ->map(function ($org) {
                $org->type = 'organizations';
                return $org;
            });

        $system_users = User::where('name', 'LIKE', "%$q%")
            ->orWhere('username', 'LIKE', "%$q%")
            ->orWhere('email', 'LIKE', "%$q%")
            ->get(['id', 'name', 'username', 'email'])
            ->map(function ($u) {
                $u->type = 'system_users';
                return $u;
            });

        return response()->json($organizations
            ->merge($system_users)
            ->merge($system_users));
    }
}
