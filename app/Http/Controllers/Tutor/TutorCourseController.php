<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorCourseController extends Controller
{
    public function index(Request $request)
    {
        $teacherName = 'Mr. John Doe'; // Replace this with the actual authenticated teacher's name

        $allCourses = [
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
        ];

        $myCourses = array_filter($allCourses, function ($course) use ($teacherName) {
            return $course['tutor'] === $teacherName;
        });

        return view('tutor.courses.myCourse', ['myCourses' => $myCourses]);
    }

    public function create()
    {
        return view('tutor.courses.uploadCourse');
    }

    public function store(Request $request)
    {
        // Dummy handler, replace with actual logic to save course
        return redirect()->route('tutor.my-course')->with('success', 'Course uploaded (demo)');
    }
}