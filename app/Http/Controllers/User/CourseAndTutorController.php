<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseAndTutorController extends Controller
{
    public function index()
    {
        $tutors = [
            [
                'id' => 1,
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'subjects' => [1, 2], // subject IDs
            ],
            [
                'id' => 2,
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'subjects' => [2, 3],
            ]
        ];

        // Hardcoded subjects
        $subjects = [
            ['id' => 1, 'name' => 'Mathematics', 'tutors' => [1]],
            ['id' => 2, 'name' => 'Science', 'tutors' => [1, 2]],
            ['id' => 3, 'name' => 'History', 'tutors' => [2]],
        ];

        // Hardcoded courses
        $courses = [
            [
                'title' => 'Basic Algebra',
                'subject_id' => 1,
                'tutor_id' => 1,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'form' => 1
            ],
            [
                'title' => 'Physics 101',
                'subject_id' => 2,
                'tutor_id' => 2,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'form' => 2
            ],
            [
                'title' => 'World History',
                'subject_id' => 3,
                'tutor_id' => 2,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'form' => 3
            ],
        ];


        // Send to view
        return view('frontend.courseAndTutor', compact('tutors', 'subjects', 'courses'));
    }
}