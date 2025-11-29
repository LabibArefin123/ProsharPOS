<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('setting_management.system_user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('setting_management.system_user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Validate input
        $request->validate([
            'name'      => 'required|string|max:50',
            'username'  => 'required|string|max:255|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|max:15',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|string|exists:roles,name',
            'current_password' => 'required|string',
        ]);

        // ✅ Check if the logged-in admin’s current password is correct
        $admin = Auth::user();
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।',
            ])->withInput();
        }

        // ✅ Create the new user
        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
        ]);

        // ✅ Assign role
        $role = Role::where('name', $request->role)->first();
        if ($role) {
            $user->assignRole($role->name);
        }

        return redirect()
            ->route('system_users.index')
            ->with('success', 'User added successfully!');
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
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('setting_management.system_user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // ✅ Validate
        $request->validate([
            'name'      => 'required|string|max:50',
            'username'  => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'phone'     => 'required|string|max:15',
            'role'      => 'required|string|exists:roles,name',
            'current_password' => 'required|string',
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        // ✅ Check the admin’s current password before allowing update
        $admin = Auth::user();
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।',
            ])->withInput();
        }

        // ✅ If new password is provided, update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // ✅ Update user info
        $user->update([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'phone'     => $request->phone,
        ]);

        // ✅ Update user role
        $role = Role::where('name', $request->role)->first();
        if ($role) {
            $user->syncRoles([$role->name]);
        }

        return redirect()->route('system_users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('system_users.index')->with('success', 'User deleted successfully!');
    }
}
