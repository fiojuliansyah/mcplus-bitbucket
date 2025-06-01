<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        // $user = Auth::user();

        $user = (object) [
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => 'student123',
            'phone' => '0856735783',
            'phone_verified' => 'Verified'
        ];

        return view('frontend.profile', compact('user'));
    }

    public function update()
    {

    }
}