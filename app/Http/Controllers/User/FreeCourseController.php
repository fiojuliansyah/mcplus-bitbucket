<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FreeCourseController extends Controller
{
    public function index()
    {
        $freeCourses = [
        [
            'id' => 0,
            'title' => 'Math Basics',
            'subject' => 'Mathematics',
            'form' => 1,
            'image' => 'frontend/assets/images/courses/basic-math.png',
            'tutor' => 'Mr. John Doe',
            'description' => 'Learn the basics of math including addition, subtraction, multiplication and division.',
            'video_url' => 'https://youtu.be/ClXirO-pqp4?si=ewWNq_Ft8_AZgrna'
        ],
        [
            'id' => 1,
            'title' => 'Intro to Science',
            'subject' => 'Science',
            'form' => 1,
            'image' => 'frontend/assets/images/courses/intro-science.jpg',
            'tutor' => 'Ms. Jane Smith',
            'description' => 'An introduction to scientific concepts and methods through fun examples.',
            'video_url' => 'https://youtu.be/ClXirO-pqp4?si=ewWNq_Ft8_AZgrna'
        ],
        [
            'id' => 2,
            'title' => 'English Grammar',
            'subject' => 'English',
            'form' => 1,
            'image' => 'frontend/assets/images/courses/english-grammar.png',
            'tutor' => 'Mrs. Mary Johnson',
            'description' => 'Understand sentence structure, tenses, punctuation and more.',
            'video_url' => 'https://youtu.be/ClXirO-pqp4?si=ewWNq_Ft8_AZgrna'
        ],
    ];

        return view('frontend.freeCourses', compact('freeCourses'));
    }

    public function show($id)
    {
        $freeCourses = [
        [
            'id' => 0,
            'title' => 'Math Basics',
            'subject' => 'Mathematics',
            'form' => 1,
            'image' => 'frontend/assets/images/courses/basic-math.png',
            'tutor' => 'Mr. John Doe',
            'description' => 'Learn the basics of math including addition, subtraction, multiplication and division.',
            'video_url' => 'https://youtu.be/ClXirO-pqp4?si=ewWNq_Ft8_AZgrna'
        ],
        [
            'id' => 1,
            'title' => 'Intro to Science',
            'subject' => 'Science',
            'form' => 1,
            'image' => 'frontend/assets/images/courses/intro-science.jpg',
            'tutor' => 'Ms. Jane Smith',
            'description' => 'An introduction to scientific concepts and methods through fun examples.',
            'video_url' => 'https://youtu.be/ClXirO-pqp4?si=ewWNq_Ft8_AZgrna'
        ],
        [
            'id' => 2,
            'title' => 'English Grammar',
            'subject' => 'English',
            'form' => 1,
            'image' => 'frontend/assets/images/courses/english-grammar.png',
            'tutor' => 'Mrs. Mary Johnson',
            'description' => 'Understand sentence structure, tenses, punctuation and more.',
            'video_url' => 'https://youtu.be/ClXirO-pqp4?si=ewWNq_Ft8_AZgrna'
        ],
    ];

        if (!isset($freeCourses[$id])) {
            abort(404);
        }

        $course = $freeCourses[$id];
        return view('frontend.freeCoursesDetail', compact('course'));
    }


}