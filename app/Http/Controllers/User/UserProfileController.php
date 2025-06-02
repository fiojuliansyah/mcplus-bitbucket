<?php

namespace App\Http\Controllers\User;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    // Show the user's profile(s)
    public function index()
    {
        $user = Auth::user();
        $profiles = $user->profiles;
        return view('frontend.profile', compact('user', 'profiles'));
    }

    // Store a new profile
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pin' => 'nullable|string|max:255',
        ]);

        $profile = new Profile();
        $profile->user_id = Auth::id();
        $profile->name = $request->name;
        $profile->pin = $request->pin;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = $avatarPath;
        }

        $profile->save();

        return redirect()->route('user.profile')->with('success', 'Profile added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pin' => 'nullable|string|max:255',
        ]);

        $profile = Profile::findOrFail($id);
        $profile->name = $request->name;
        $profile->pin = $request->pin;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = $avatarPath;
        }

        $profile->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }
}
