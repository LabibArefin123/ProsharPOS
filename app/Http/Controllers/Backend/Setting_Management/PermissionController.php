<?php

namespace App\Http\Controllers\Backend\Setting_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('backend.setting_management.roles_and_permission.permission.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['required', 'string', 'max:255', 'distinct'],
        ]);

        $savedPermissions = [];
        $existingPermissions = [];

        try {
            DB::transaction(function () use (
                $validated,
                &$savedPermissions,
                &$existingPermissions
            ) {
                foreach ($validated['permissions'] as $permissionName) {

                    $permissionName = trim($permissionName);

                    if ($permissionName === '') {
                        continue;
                    }

                    $permission = Permission::firstOrCreate([
                        'name' => $permissionName,
                        'guard_name' => 'web',
                    ]);

                    if ($permission->wasRecentlyCreated) {
                        $savedPermissions[] = $permission->name;
                    } else {
                        $existingPermissions[] = $permission->name;
                    }
                }
            });

            app(\Spatie\Permission\PermissionRegistrar::class)
                ->forgetCachedPermissions();

            return response()->json([
                'success' => true,
                'message' => count($savedPermissions) > 0
                    ? 'Permissions created successfully.'
                    : 'All selected permissions already exist.',
                'permissions' => $savedPermissions,
                'existing' => $existingPermissions,
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to create permissions.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }


    public function assignPermissionToRole(Request $request)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::findOrFail($validated['role_id']);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->back()->with(
            'success',
            'Permissions updated for the role.'
        );
    }
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.setting_management.roles_and_permission.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'guard_name' => 'nullable|in:web,api',
        ]);

        $permission->update($request->only('name', 'guard_name'));
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        Permission::destroy($id);
        return back()->with('success', 'Permission deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:permissions,id'
        ]);

        Permission::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Selected permission deleted successfully.']);
    }
}
