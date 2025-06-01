<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorProfileController extends Controller
{
    public function index()
    {
        // $user = Auth::user();

        $tutor = (object) [
            'name' => 'Tutor',
            'email' => 'tutor@gmail.com',
            'password' => 'password',
            'phone' => '0856735783',
            'phone_verified' => 'Verified'
        ];

        return view('tutor.profile.tutorProfile', compact('tutor'));
    }

    public function update()
    {

    }
}