<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Grade;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\TestResult;
use App\Models\QuizzAnswer;
use App\Models\QuizzResult;

use App\Models\ReplayClass;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\UserAttendSubject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserPageController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $user = Auth::user();
        return view('frontend.students.dashboard', compact('user','title'));
    }

    public function orderHistory(Request $request)
    {
        $title = 'Order History';
        $user = Auth::user();
        $query = Subscription::where('user_id', $user->id)
                            ->with(['profile', 'plan', 'subject'])
                            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('transaction_code', 'like', '%' . $searchTerm . '%');
        }

        $subscriptions = $query->paginate(10);

        return view('frontend.students.order-history', compact('subscriptions','user','title'));
    }

    public function enrolledSubjects(Request $request)
    {
        $title = 'Enrolled Subjects';
        $user = Auth::user();
        $currentProfile = $user->current_profile;

        $query = Subscription::where('profile_id', $currentProfile->id)
                            ->where('status', 'success') 
                            ->with(['plan', 'subject','subject.grade', 'subject.users.current_profile'])
                            ->latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('subject', function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        $subscriptions = $query->paginate(10);

        return view('frontend.students.enrolled-subjects', compact('subscriptions', 'user', 'title')); 
    }

    public function topicsSubject($subjectSlug, $replayId = null)
    {
        $subject = Subject::where('slug', $subjectSlug)->firstOrFail();
        $topics = $subject->topics()->with([
            'replayClasses' => function ($query) {
                $query->where('status', 'publish');
            },
            'notes' => function ($query) {
                $query->where('status', 'publish');
            }
        ])->get(); 

        $activeReplay = null;
        if ($replayId) {
            $activeReplay = ReplayClass::where('id', $replayId)
                                    ->where('status', 'publish')
                                    ->firstOrFail();
        } else {
            $activeReplay = $topics->first()?->replayClasses->first();
        }

        return view('frontend.students.classes.index', compact('subject', 'topics', 'activeReplay'));
    }

    public function settings()
    {
        $title = 'Settings';
        $user = Auth::user();

        return view('frontend.students.settings', compact('user','title')); 
    }

    public function settingsStore(Request $request)
    {
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function quiz(Request $request)
    {
        $title = 'My Quizzes';
        $user = Auth::user();
        $currentProfile = $user->current_profile->id;

        $query = Subscription::where('profile_id', $currentProfile)
                            ->with(['subject.topics.quizzes'])
                            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('transaction_code', 'like', '%' . $searchTerm . '%');
        }

        $subscriptions = $query->get();

        $topicsWithQuizzes = collect();
        $processedTopicIds = [];

        foreach ($subscriptions as $subscription) {
            if ($subscription->subject && $subscription->subject->topics) {
                foreach ($subscription->subject->topics as $topic) {
                    if ($topic->quizzes->isNotEmpty() && !in_array($topic->id, $processedTopicIds)) {
                        $topicsWithQuizzes->push($topic);
                        $processedTopicIds[] = $topic->id;
                    }
                }
            }
        }

        if ($topicsWithQuizzes->isNotEmpty()) {
            $topicIds = $topicsWithQuizzes->pluck('id');
            
            $results = QuizzResult::where('user_id', $user->id)
                                ->whereIn('topic_id', $topicIds)
                                ->get()
                                ->keyBy('topic_id');

            $topicsWithQuizzes->each(function ($topic) use ($results) {
                $topic->result = $results->get($topic->id);
                $topic->has_attempt = !is_null($topic->result);
            });
        }

        return view('frontend.students.my-quiz', compact('user', 'title', 'topicsWithQuizzes'));
    }

    public function showResult($id)
    {
        $title = 'Quiz Result';
        $result = QuizzResult::with('topic')->findOrFail($id);
        $answers = QuizzAnswer::with('quizz')->where('user_id', auth()->id())
        ->whereIn('quizz_id', function ($query) use ($result) {
            $query->select('id')
                ->from('quizzes')
                ->where('topic_id', $result->topic_id);
        })->get();

        return view('frontend.students.result', compact('result', 'answers', 'title'));
    }

    public function assignment(Request $request)
    {
        $title = 'My Assignments';
        $user = Auth::user();
        $currentProfile = $user->current_profile->id;

        $query = Subscription::where('profile_id', $currentProfile)
                            ->with(['subject.tests'])
                            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('transaction_code', 'like', '%' . $searchTerm . '%');
        }

        $subscriptions = $query->get();

        $subjectsWithTests = collect();
        $processedSubjectIds = [];

        foreach ($subscriptions as $subscription) {
            if ($subscription->subject && $subscription->subject->tests) {
                foreach ($subscription->subject->tests as $test) {
                    if ($test->status === 'publish' && !in_array($test->subject_id, $processedSubjectIds)) {
                        $subjectsWithTests->push($test);
                        $processedSubjectIds[] = $test->subject_id;
                    }
                }
            }
        }

        if ($subjectsWithTests->isNotEmpty()) {
            $testIds = $subjectsWithTests->pluck('id');

            $results = TestResult::where('user_id', $user->id)
                                ->whereIn('test_id', $testIds)
                                ->get()
                                ->keyBy('test_id');

            $subjectsWithTests->each(function ($test) use ($results) {
                $test->result = $results->get($test->id);
                $test->has_attempt = !is_null($test->result);
            });
        }

        return view('frontend.students.my-assignment', compact('user', 'title', 'subjectsWithTests'));
    }
}
