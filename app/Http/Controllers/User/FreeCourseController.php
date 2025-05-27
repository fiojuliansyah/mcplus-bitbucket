<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FreeCourseController extends Controller
{
    public function index()
    {
        $freeCourses = [
            ['title' => 'Math Basics', 'subject' => 'Mathematics' ,'form' => 1, 'image' => 'frontend/assets/images/courses/basic-math.png'],
            ['title' => 'Intro to Science', 'subject' => 'Science' ,'form' => 1, 'image' => 'frontend/assets/images/courses/intro-science.jpg'],
            ['title' => 'English Grammar', 'subject' => 'English' ,'form' => 1, 'image' => 'frontend/assets/images/courses/english-grammar.png'],
        ];

        return view('frontend.freeCourses', compact('freeCourses'));
    }
}