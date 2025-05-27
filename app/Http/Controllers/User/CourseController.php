<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
{
    $freeCourses = [
        ['title' => 'Math Basics', 'form' => 1, 'image' => 'frontend/assets/images/courses/basic-math.png'],
        ['title' => 'Intro to Science', 'form' => 2, 'image' => 'frontend/assets/images/courses/intro-science.jpg'],
        ['title' => 'English Grammar', 'form' => 3, 'image' => 'frontend/assets/images/courses/english-grammar.png'],
    ];

    $paidCourses = [
        ['title' => 'Advanced Algebra', 'form' => 4, 'image' => 'frontend/assets/images/courses/advance-algebra.png'],
        ['title' => 'Physics Principles', 'form' => 5, 'image' => 'frontend/assets/images/courses/physics.jpg'],
        ['title' => 'Creative Writing', 'form' => 3, 'image' => 'frontend/assets/images/courses/creative-writing.png'],
    ];

    return view('frontend.courses', compact('freeCourses', 'paidCourses'));
}
}