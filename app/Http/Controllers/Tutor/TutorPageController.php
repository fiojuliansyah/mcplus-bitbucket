<?php

namespace App\Http\Controllers\Tutor;

use Carbon\Carbon;
use App\Models\Test;
use App\Models\User;
use App\Models\Grade;
use App\Models\Topic;
use App\Models\Profile;
use App\Models\Subject;
use App\Models\LiveClass;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\UserHasSubject;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TutorPageController extends Controller
{
    public function dashboard(Request $request)
    {
        $title = 'Dashboard';
        $user = Auth::user();
        
        // Mengambil semua subject yang diajar oleh tutor
        $subjects = $user->subjects()->with('grade')->get();

        // Inisialisasi variabel
        $upcomingClasses = collect();
        $calendarEvents = [];
        $selectedSubject = null;
        $subscriptionStats = [
            'total' => 0,
            'active' => 0,
            'expired' => 0,
            'expiring_soon' => 0,
        ];

        if ($request->filled('subject_id')) {
            $subjectId = $request->subject_id;
            $selectedSubject = $subjects->find($subjectId);

            if ($selectedSubject) {
                // --- Mengambil data Jadwal Kelas ---
                $upcomingClasses = LiveClass::where('user_id', $user->id)
                    ->where('subject_id', $subjectId)
                    ->with(['topic', 'subject.grade'])
                    ->where('start_time', '>=', now())
                    ->orderBy('start_time', 'asc')
                    ->take(5)
                    ->get();

                // --- Mempersiapkan data untuk Kalender ---
                $allClassesForCalendar = LiveClass::where('user_id', $user->id)
                    ->where('subject_id', $subjectId)
                    ->whereNotNull('start_time')
                    ->get(['start_time', 'status']);

                foreach ($allClassesForCalendar as $class) {
                    $date = Carbon::parse($class->start_time)->format('Y-m-d');
                    $statusMap = [
                        'live'      => 'live', 'approved'  => 'live',
                        'scheduled' => 'upcoming', 'upcoming'  => 'upcoming',
                        'completed' => 'completed', 'cancelled' => 'cancelled',
                        'draft'     => 'draft',
                    ];
                    $calendarEvents[$date] = $statusMap[strtolower($class->status)] ?? 'draft';
                }

                // --- BARU: Menghitung Statistik Langganan ---
                $baseStatsQuery = Subscription::where('subject_id', $subjectId)->where('tutor_id', $user->id);
                $now = Carbon::now();
                
                $subscriptionStats = [
                    'total' => (clone $baseStatsQuery)->count(),
                    'active' => (clone $baseStatsQuery)->where('end_date', '>', $now)->count(),
                    'expired' => (clone $baseStatsQuery)->where('end_date', '<=', $now)->count(),
                    'expiring_soon' => (clone $baseStatsQuery)->whereBetween('end_date', [$now, $now->copy()->addDays(7)])->count(),
                ];
            }
        }

        return view('frontend.tutors.dashboard', compact(
            'user',
            'title',
            'subjects',
            'upcomingClasses',
            'calendarEvents',
            'selectedSubject',
            'subscriptionStats' // Variabel baru untuk view
        ));
    }

    public function redirectSchedule(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $subject = Subject::with('grade')->findOrFail($request->subject_id);

        return redirect()->route('tutor.schedule.create', [
            'subjectSlug' => $subject->slug,
            'gradeId' => $subject->grade->id,
        ]);
    }

    public function create($subjectSlug)
    {
        $subject = Subject::where('slug', $subjectSlug)->firstOrFail();

        $title = 'Schedule New Class';

        return view('frontend.tutors.live-classes.create', compact('subject', 'title'));
    }

    public function settings()
    {
        $title = 'Settings';
        $user = Auth::user();

        return view('frontend.tutors.settings', compact('user','title')); 
    }

    public function settingsStore(Request $request)
    {
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function students(Request $request)
    {
        $title = 'My Students';
        $tutor = Auth::user();

        $tutorSubjectIds = $tutor->subjects()->pluck('subjects.id');

        $studentsQuery = Profile::query()
            ->whereHas('user', function ($query) {
                $query->where('account_type', 'student');
            })
            ->whereHas('subscriptions', function ($query) use ($tutorSubjectIds) {
                $query->whereIn('subject_id', $tutorSubjectIds)
                    ->where('status', 'success');
            })
            ->with(['user', 'subscriptions' => function ($query) use ($tutorSubjectIds) {
                $query->whereIn('subject_id', $tutorSubjectIds)
                    ->where('status', 'success')
                    ->oldest();
            }]);

        $students = $studentsQuery->paginate(10);

        return view('frontend.tutors.students', [
            'user' => $tutor,
            'title' => $title,
            'students' => $students
        ]);
    }

    public function allClasses(Request $request, $subjectSlug = null)
    {
        $user = Auth::user();
        $grades = Grade::orderBy('name')->get();
        
        $query = $user->subjects()->with([
            'grade', 
            'users', 
            'latestTopic', 
            'latestReplay', 
            'latestNote', 
            'latestQuizz',
            'latestLiveClass'
        ]);

        if ($subjectSlug) {
            $query->where('slug', $subjectSlug);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('grade_id')) {
            $query->where('grade_id', $request->grade_id);
        }

        $subjects = $query->latest()->paginate(10);
        $selectedSubject = $subjectSlug ? Subject::where('slug', $subjectSlug)->first() : null;

        return view('frontend.tutors.all-classes', compact('subjects', 'grades', 'selectedSubject'));
    }

    public function showClassDetail($subjectSlug)
    {
        $user = Auth::user();

        $subject = $user->subjects()
            ->where('slug', $subjectSlug)
            ->withCount('users')
            ->with([
                'grade',
                'topics' => function ($query) {
                    $query->with([
                        'replayClasses',
                        'notes',
                        'quizzes',
                        'liveClasses'
                    ])->orderBy('name');
                }
            ])
            ->firstOrFail();

        return view('frontend.tutors.class-detail', compact('subject'));
    }

    public function subscriptions(Request $request, $subjectSlug)
    {
        $subject = Subject::where('slug', $subjectSlug)->firstOrFail();

        $query = Subscription::with(['user', 'subject'])
            ->whereHas('subject', function ($q) {
                $q->where('tutor_id', auth()->id());
            });

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $subscriptions = $query->orderByDesc('start_date')->paginate(10);

        return view('frontend.tutors.enrollments', compact('subscriptions','subject'));
    }
}
