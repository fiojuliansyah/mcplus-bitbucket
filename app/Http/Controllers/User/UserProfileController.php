<?php

namespace App\Http\Controllers\User;

use App\Models\Plan;
use App\Models\Profile;
use App\Models\Subject;
use App\Models\LiveClass;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        $title = 'Profile';
        $user = Auth::user();
        $plan = Plan::first();

        $classes = LiveClass::paginate(5); 

        $subscriptions = Subscription::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->get();
        
        return view('frontend.profiles.index', compact('user', 'title', 'subscriptions', 'plan', 'classes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pin' => 'nullable|string|max:255',
        ]);

        $profile = new Profile;
        $profile->user_id = Auth::id();
        $profile->name = $request->name;
        $profile->pin = $request->pin;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = $avatarPath;
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profile added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required|string|max:15',
            'password'  => 'nullable|string|min:6',
            'avatar'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = Profile::findOrFail($id);
        $user = $profile->user;

        $profile->name      = $request->name;
        $profile->ic_number = $request->ic_number;
        $profile->postcode  = $request->postcode;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = $avatarPath;
        }
        $profile->save();

        $user->email = $request->email;
        $user->phone = '+60' . ltrim($request->phone, '0');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePin(Request $request, $id)
    {
        $request->validate([
            'pin' => 'required|string|digits:4|confirmed',
        ]);

        $profile = Profile::findOrFail($id);
        $profile->pin = $request->pin;
        $profile->save();

        return redirect()->back()->with('success', 'PIN updated successfully!');
    }

    public function selectProfile()
    {
        $user = Auth::user();
        $profiles = $user->profiles;
        return view('frontend.profiles.select-profile', compact('user', 'profiles'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $profiles = $user->profiles;
        return view('frontend.profiles.edit-profile', compact('user', 'profiles'));
    }


    public function changeProfile(Request $request)
    {
        
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'pin' => 'required_if:profile_id,!=,null|numeric', 
        ]);

        $user = Auth::user();

        
        $profile = Profile::findOrFail($request->profile_id);

        
        if ($profile->pin && $request->pin !== $profile->pin) {
            return redirect()->back()->with('error', 'Incorrect PIN!');
        }

        
        $user->profile_id = $profile->id;
        $user->save();

        
        return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully!');
    }

}
