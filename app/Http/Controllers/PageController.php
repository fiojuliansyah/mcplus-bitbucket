<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\LiveClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function chooseRegister()
    {
        return view('auth.choose-register');
    }

    public function chooseLogin()
    {
        return view('auth.choose-login');
    }

    public function chooseAccount()
    {
        if (Auth::user()->account_type) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.choose-account-type');
    }

    public function chooseAccountStore(Request $request)
    {
        $request->validate([
            'account_type' => ['required', Rule::in(['parent', 'tutor', 'student', 'admin'])],
        ]);

        $user = Auth::user();

        $user->account_type = $request->account_type;
        $user->save();

        return redirect()->route('user.dashboard')->with('status', 'Account type selected successfully!');
    }

    public function createAccount()
    {
        $user = Auth::user();
        return view('auth.create-account', compact('user'));
    }

    public function createAccountStore(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'ic_number' => ['required', 'string', 'min:12', 'max:12', Rule::unique('profiles', 'ic_number')->ignore($user->profile->id ?? null)],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'grade' => [Rule::requiredIf($user->account_type === 'student')],
            'phone' => ['required', 'string', 'min:9', 'max:15'],
            'postcode' => ['nullable', 'string', 'digits:5'],
        ]);

        DB::beginTransaction();
        try {
            
            $profileData = [
                'name' => $validated['name'],
                'ic_number' => $validated['ic_number'],
                'gender' => $validated['gender'],
            ];

            if (isset($validated['postcode'])) {
                $profileData['postcode'] = $validated['postcode'];
            }
            if (isset($validated['grade'])) {
                $profileData['grade'] = $validated['grade'];
            }
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('avatars', 'public');
                $profileData['avatar'] = $path;
            }

            $profile = $user->profiles()->updateOrCreate(['user_id' => $user->id], $profileData);

            $user->phone = $validated['phone'];
            $user->profile_id = $profile->id;
            $user->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat profil user.', [
                'user_id' => $user->id, 'email' => $user->email,
                'error_message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine(),
            ]);
            return back()->with('error', 'Failed to create profile. Please try again.')->withInput();
        }

        return redirect()->route('create.account.success')->with('status', 'Your profile has been created successfully!');
    }

    public function createAccountSuccess()
    {
        $user = Auth::user();
        
        $grade = null;

        if ($user->current_profile && $user->current_profile->grade !== null) {
            $grade = Grade::where('slug', $user->current_profile->grade)->first();
        }

        return view('auth.create-account-success', compact('user', 'grade'));
    }

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
                        ->with([
                            'topics.notes', 
                            'topics.quizzes'
                        ])
                        ->firstOrFail();

        $topics = $subject->topics;

        $progress = [];
        foreach ($topics as $topic) {
            $completedCount = 2; 
            $totalActivities = $topic->notes->count() + $topic->quizzes->count();
            $progress[$topic->id] = [
                'completed' => $completedCount,
                'total' => $totalActivities,
                'percentage' => $totalActivities > 0 ? ($completedCount / $totalActivities) * 100 : 0,
            ];
        }
        
        return view('frontend.subjectDetail', compact('grade', 'subject', 'topics', 'progress'));
    }

    public function tutors(Request $request)
    {
        $query = User::where('account_type', 'tutor');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('current_profile', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('subjects')) {
            $subjectIds = $request->input('subjects');
            $query->whereHas('subjects', function ($q) use ($subjectIds) {
                $q->whereIn('subjects.id', $subjectIds);
            });
        }

        if ($request->filled('grades')) {
            $gradeIds = $request->input('grades');
            $query->whereHas('subjects.grade', function ($q) use ($gradeIds) {
                $q->whereIn('grades.id', $gradeIds);
            });
        }

        if ($request->get('sort') == 'newest') {
            $query->latest();
        } else {
            $query->latest();
        }

        $tutors = $query->paginate(9);

        $allSubjects = Subject::orderBy('name')->get()->unique('name');
        $allGrades = Grade::orderBy('name')->get();

        return view('frontend.tutors', [
            'tutors' => $tutors,
            'allSubjects' => $allSubjects,
            'allGrades' => $allGrades,
            'selectedSubjects' => $request->input('subjects', []),
            'selectedGrades' => $request->input('grades', [])
        ]);
    }

    public function joinMeeting($id)
    {
        $liveClass = LiveClass::findOrFail($id);
        return view('frontend.zoom-embed', compact('liveClass'));
    }
}
