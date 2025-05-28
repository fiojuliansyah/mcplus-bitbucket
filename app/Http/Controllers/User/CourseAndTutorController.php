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
                'id' => 1,
                'title' => 'Basic Algebra',
                'subject_id' => 1,
                'tutor_id' => 1,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'form' => 1
            ],
            [
                'id' => 2,
                'title' => 'Physics 101',
                'subject_id' => 2,
                'tutor_id' => 2,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'form' => 2
            ],
            [
                'id' => 3,
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

    public function showCourse($id)
    {
        // Hardcoded tutors
        $tutors = [
            ['id' => 1, 'name' => 'Alice Johnson', 'email' => 'alice@example.com', 'subjects' => [1, 2]],
            ['id' => 2, 'name' => 'Bob Smith', 'email' => 'bob@example.com', 'subjects' => [2, 3]],
        ];

        // Hardcoded subjects with topics
        $subjects = [
            ['id' => 1, 'name' => 'Mathematics', 'topics' => ['Fractions', 'Algebra', 'Geometry']],
            ['id' => 2, 'name' => 'Science', 'topics' => ['Physics Basics', 'Chemistry', 'Biology']],
            ['id' => 3, 'name' => 'History', 'topics' => ['Ancient Civilizations', 'World Wars', 'Modern Politics']],
        ];

        // Courses
        $courses = [
            [
                'id' => 1,
                'subject_id' => 1,
                'tutor_id' => 1,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'form' => 1,
            ],
            [
                'id' => 2,
                'subject_id' => 2,
                'tutor_id' => 2,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'form' => 2,
            ],
            [
                'id' => 3,
                'subject_id' => 3,
                'tutor_id' => 2,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'form' => 3,
            ],
        ];

        $course = collect($courses)->firstWhere('id', (int) $id);

        if (!$course) {
            abort(404);
        }

        $subject = collect($subjects)->firstWhere('id', $course['subject_id']);
        $tutor = collect($tutors)->firstWhere('id', $course['tutor_id']);

        return view('frontend.courseAndTutorDetail', compact('course', 'subject', 'tutor'));
    }

}