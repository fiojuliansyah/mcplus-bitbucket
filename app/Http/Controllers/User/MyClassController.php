<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyClassController extends Controller
{
    public function index()
    {
        $enrolledSubjects = collect([
        [
            'title' => 'Mathematics Basics',
            'subject' => 'Math',
            'form' => 1,
            'image' => 'frontend/assets/images/continue-watch/01.webp',
            'progress' => 60,
        ],
        [
            'title' => 'Introduction to Biology',
            'subject' => 'Science',
            'form' => 1,
            'image' => 'frontend/assets/images/continue-watch/01.webp',
            'progress' => 40,
        ],
        [
            'title' => 'World History',
            'subject' => 'History',
            'form' => 2,
            'image' => 'frontend/assets/images/continue-watch/01.webp',
            'progress' => 80,
        ],
    ]);

        return view('frontend.my-class', compact('enrolledSubjects'));
    }

}