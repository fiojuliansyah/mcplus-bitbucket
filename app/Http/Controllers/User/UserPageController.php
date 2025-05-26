<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function index()
    {
        $movies = [
            [
                'title' => 'Most Mak-Mak Tutor',
                'duration' => 'Tutor',
                'image' => '/frontend/assets/images/products/pict1.jpg',
                'description' => 'Vote the tutor for the best Mak-Mak tutor'
            ],
            [
                'title' => 'Troublemaker Tutor',
                'duration' => 'Tutor',
                'image' => '/frontend/assets/images/products/pict2.jpg',
                'description' => 'Vote the tutor for the best troublemaker tutor'
            ],
            [
                'title' => 'Free Exclusive Merchandise',
                'duration' => 'Merchandise',
                'image' => '/frontend/assets/images/products/pict3.jpg',
                'description' => 'You can get free exclusive merchandise by join with mplus premium'
            ]
        ];

        $topTenSubject = [
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 1],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 2],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 3],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 4],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 5],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 6],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 7],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 8],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 9],
            ['image' => '/frontend/assets/images/movies/related/01.webp', 'rank' => 10],
        ];

        $mostLikedTutor = [
            [
                'name' => 'Tutor 01', 
                'like' => '3214 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 02', 
                'like' => '3100 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 03', 
                'like' => '3053 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 04', 
                'like' => '2574 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 05', 
                'like' => '2431 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 06', 
                'like' => '2325 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 07', 
                'like' => '2034 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 08', 
                'like' => '1953 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 09', 
                'like' => '1928 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
            [
                'name' => 'Tutor 10', 
                'like' => '1582 like', 
                'link' => '#', 
                'image' => '/frontend/assets/images/movies/related/01.webp',

            ],
        ];

        return view('frontend.home', compact('movies', 'topTenSubject', 'mostLikedTutor'));
    }

    // public function index()
    // {
    //     return view('frontend.home');
    // }
}
