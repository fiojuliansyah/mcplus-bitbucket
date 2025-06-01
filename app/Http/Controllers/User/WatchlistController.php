<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        $subjects = [
            [
                'id' => 1,
                'title' => 'Algebra',
                'subject' => 'Mathematics',
                'description' => 'The study of numbers, quantities, shapes, and patterns, including algebra, geometry, and calculus.',
                'image' => 'frontend/assets/images/continue-watch/01.webp',
            ],
            [
                'id' => 2,
                'title' => 'Cell Structure and Function',
                'subject' => 'Science',
                'description' => 'A subject that explores the natural world through biology, chemistry, and physics.',
                'image' => 'frontend/assets/images/continue-watch/01.webp',
            ],
            [
                'id' => 3,
                'title' => 'World War II',
                'subject' => 'History',
                'description' => 'The study of past events, civilizations, and important figures that shaped the world.',
                'image' => 'frontend/assets/images/continue-watch/01.webp',
            ],
        ];

        return view('frontend.watchlist', compact('subjects'));
    }
}
