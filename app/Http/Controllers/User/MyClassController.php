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
                'id' => 1,
                'subject' => 'Mathematics',
                'form' => 1,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'progress' => 60,
                'topics' => [
                    ['title' => 'Algebra Basics', 'done' => true],
                    ['title' => 'Geometry Fundamentals', 'done' => false],
                    ['title' => 'Number Theory', 'done' => true],
                ],
            ],
            [
                'id' => 2,
                'subject' => 'Science',
                'form' => 1,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'progress' => 40,
                'topics' => [
                    ['title' => 'Introduction to Biology', 'done' => true],
                    ['title' => 'Basic Chemistry', 'done' => false],
                    ['title' => 'Physics: Motion and Force', 'done' => false],
                ],
            ],
            [
                'id' => 3,
                'subject' => 'History',
                'form' => 2,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'progress' => 80,
                'topics' => [
                    ['title' => 'World War I', 'done' => true],
                    ['title' => 'Ancient Civilizations', 'done' => true],
                    ['title' => 'Modern History Overview', 'done' => false],
                ],
            ],
        ]);

        return view('frontend.myClass', compact('enrolledSubjects'));
    }

    public function showDetail($id)
    {
        $enrolledSubjects = collect([
            [
                'id' => 1,
                'subject' => 'Mathematics',
                'form' => 1,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'progress' => 60,
                'topics' => [
                    ['title' => 'Algebra Basics', 'done' => true],
                    ['title' => 'Geometry Fundamentals', 'done' => false],
                    ['title' => 'Number Theory', 'done' => true],
                ],
            ],
            [
                'id' => 2,
                'subject' => 'Science',
                'form' => 1,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'progress' => 40,
                'topics' => [
                    ['title' => 'Introduction to Biology', 'done' => true],
                    ['title' => 'Basic Chemistry', 'done' => false],
                    ['title' => 'Physics: Motion and Force', 'done' => false],
                ],
            ],
            [
                'id' => 3,
                'subject' => 'History',
                'form' => 2,
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'progress' => 80,
                'topics' => [
                    ['title' => 'World War I', 'done' => true],
                    ['title' => 'Ancient Civilizations', 'done' => true],
                    ['title' => 'Modern History Overview', 'done' => false],
                ],
            ],
        ]);

        $class = $enrolledSubjects->firstWhere('id', $id);

        if (!$class) {
            abort(404);
        }

        return view('frontend.myClassDetail', compact('class'));
    }

}