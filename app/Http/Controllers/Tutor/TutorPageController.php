<?php

namespace App\Http\Controllers\Tutor;

use App\Models\Test;
use App\Models\User;
use App\Models\Profile;
use App\Models\Subject;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\UserHasSubject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TutorPageController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $user = Auth::user();
        return view('frontend.tutors.dashboard', compact('user','title'));
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
}
