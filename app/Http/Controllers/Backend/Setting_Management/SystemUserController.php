<?php

namespace App\Http\Controllers\Backend\Setting_Management;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SystemUserController extends Controller
{
    /**
     * Display all system users.
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return view(
            'backend.setting_management.user_management.system_user.index',
            compact('users')
        );
    }

    /**
     * Show the create user form.
     */
    public function create()
    {
        $roles = Role::all();

        return view(
            'backend.setting_management.user_management.system_user.create',
            compact('roles')
        );
    }


    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'phone_2' => $validated['phone_2'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // Assign user role
        $user->assignRole($validated['role']);

        return redirect()
            ->route('system_users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display a specific user.
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return view(
            'backend.setting_management.user_management.system_user.show',
            compact('user')
        );
    }

    /**
     * Show the edit user form.
     */

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);

        $roles = Role::all();

        return view(
            'backend.setting_management.user_management.system_user.edit',
            compact('user', 'roles')
        );
    }

    /**
     * Update an existing user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Update user information
        $user->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'phone_2' => $validated['phone_2'] ?? null,
        ]);

        // Synchronize user role
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('system_users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Show the change password page.
     */
    public function editPassword(User $user)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        return view(
            'backend.system_users.change_password',
            compact('user')
        );
    }

    /**
     * Update a user's password.
     */
    public function updatePassword(Request $request, User $user)
    {
        // Only administrators can change user passwords
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Hash password using Laravel Hash
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('system_users.index')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Delete a system user.
     */
    public function destroy($id)
    {
        // Only administrators can delete users
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $user = User::findOrFail($id);

        // Prevent deleting the authenticated account
        if ((int) $user->id === (int) auth()->id()) {
            return redirect()
                ->route('system_users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Remove assigned Spatie roles
        $user->syncRoles([]);

        // Delete user
        $user->delete();

        return redirect()
            ->route('system_users.index')
            ->with('success', 'System user deleted successfully.');
    }
}
