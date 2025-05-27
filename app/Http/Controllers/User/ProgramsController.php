<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function index()
    {
        $newPrograms = [
            [
                'title' => 'Summer Reading Challenge',
                'description' => 'A fun and engaging reading program for students during the summer break.',
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'date' => '2025-06-10'
            ],
            [
                'title' => 'Science Explorers Week',
                'description' => 'A hands-on science exploration program for curious young minds.',
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'date' => '2025-06-01'
            ],
        ];

        $popularPrograms = [
            [
                'title' => 'Math Enrichment Program',
                'description' => 'Our most popular program to boost math skills from grades 1 to 5.',
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'date' => '2025-04-15'
            ],
            [
                'title' => 'Art & Creativity Club',
                'description' => 'Loved by students for encouraging creativity through painting, crafts, and design.',
                'image' => 'frontend/assets/images/continue-watch/01.webp',
                'date' => '2025-03-20'
            ],
        ];

        return view('frontend.programs', compact('newPrograms', 'popularPrograms'));
    }
}