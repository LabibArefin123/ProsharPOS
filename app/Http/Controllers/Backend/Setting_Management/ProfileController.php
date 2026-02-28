<?php

namespace App\Http\Controllers\Backend\Setting_Management;

use App\Http\Controllers\Controller;
use App\Models\BankBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function user_profile_show()
    {
        $user = Auth::user();

        // Get bank balance for current user, if not exists show 0
        $bankBalance = BankBalance::where('user_id', $user->id)->first();
        if (!$bankBalance) {
            $bankBalance = (object)[
                'balance' => 0,
                'balance_in_dollars' => 0,
            ];
        }

        return view('backend.setting_management.profile_page.show', compact('user', 'bankBalance'));
    }
    /**
     * Display the user's profile form.
     */


    public function user_profile_edit()
    {
        $user = Auth::user();
        return view('backend.setting_management.profile_page.edit', compact('user'));
    }

    public function user_profile_update(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
        ]);

        // Update user fields
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Profile picture handling
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imagePath = $image->store('profile_pictures', 'public');

            // Delete old picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->profile_picture = $imagePath;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
