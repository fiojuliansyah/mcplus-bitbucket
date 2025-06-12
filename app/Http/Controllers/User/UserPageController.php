<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\UserAttendSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

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

    public function subjects()
    {
        $grades = Grade::all();
        $subjects = Subject::all();
        return view('frontend.subjects', compact('subjects','grades'));
    }

    public function subjectDetail($slugGrade, $slugSubject)
    {
        $grade = Grade::where('slug', $slugGrade)->firstOrFail();
        $subject = Subject::where('slug', $slugSubject)
                    ->where('grade_id', $grade->id)
                    ->firstOrFail();

        $topics = Topic::where('subject_id', $subject->id)
                    ->where('grade_id', $grade->id)
                    ->with('grades')
                    ->get();

        return view('frontend.subjectDetail', compact('grade', 'subject', 'topics'));
    }

    public function myClass()
    {
        $userId = Auth::id();

        // Get all grades for filter navigation
        $grades = Grade::all();

        // Get subjects joined through user_has_class using Eloquent
        $subjects = Subject::with('grade') // eager load grade relationship
            ->whereIn('id', function ($query) use ($userId) {
                $query->select('subject_id')
                    ->from('user_has_subjects')
                    ->where('user_id', $userId);
            })
            ->get();

        return view('frontend.myClass', compact('subjects', 'grades'));
    }

    public function mySubject($slugGrade, $slugSubject)
    {
        $userId = Auth::id();

        $grade = Grade::where('slug', $slugGrade)->firstOrFail();

        $subject = Subject::where('slug', $slugSubject)
                    ->where('grade_id', $grade->id)
                    ->firstOrFail();

        // Get attended topic IDs using the model
        $attendedSubjectIds = UserAttendSubject::where('user_id', $userId)
            ->where('subject_id', $subject->id)
            ->pluck('topic_id')
            ->toArray();

        // Fetch all topics and mark them as attended or not
        $topics = Topic::where('subject_id', $subject->id)
                    ->where('grade_id', $grade->id)
                    ->with('grades')
                    ->get()
                    ->map(function ($topic) use ($attendedSubjectIds) {
                        $topic->attended = in_array($topic->id, $attendedSubjectIds);
                        return $topic;
                    });

        return view('frontend.mySubject', compact('grade', 'subject', 'topics'));
    }


    public function tutors()
    {
        $tutors = User::where('account_type', 'tutor')->get();
        return view('frontend.tutors', compact('tutors'));
    }
}
