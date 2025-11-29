<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SystemUserController extends Controller
{
    /**
     * Display a listing of system users.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('setting_management.system_user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('setting_management.system_user.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'current_password' => 'required|string|min:8', // just for create form requirement
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('system_users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $system_user)
    {
        $roles = Role::all();
        return view('setting_management.system_user.edit', compact('system_user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $system_user)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $system_user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $system_user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $system_user->id,
            'current_password' => 'required|string|min:8', // must provide current password
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $system_user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $system_user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $system_user->password,
        ]);

        $system_user->syncRoles([$request->role]);

        return redirect()->route('system_users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $system_user)
    {
        $system_user->delete();

        return redirect()->route('system_users.index')
            ->with('success', 'User deleted successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('setting_management.system_user.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
}
