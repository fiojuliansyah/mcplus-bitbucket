<?php

namespace App\Http\Controllers\Tutor;

use App\Models\Grade;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\ReplayClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TutorReplayClassController extends Controller
{
    public function create($subjectSlug)
    {
        $user = Auth::user();

        $subject = Subject::where('slug', $subjectSlug)
            ->with(['grade', 'topics'])
            ->firstOrFail();

        $subjects = $user->subjects()->with(['grade', 'topics'])->get();

        $topics = $subject->topics;

        return view('frontend.tutors.replay-classes.create', compact(
            'subject',
            'subjects',
            'topics'
        ));
    }

    public function store(Request $request, $subjectSlug)
    {
        $subject = Subject::where('slug', $subjectSlug)
            ->with('grade')
            ->firstOrFail();

        $request->validate([
            'topic_id'        => 'required|exists:topics,id',
            'description'     => 'nullable|string',
            'replay_url'      => 'nullable|string',
            'replay_public_id'=> 'nullable|string',
            'duration'        => 'nullable|string',
            'status'          => 'in:draft,publish'
        ]);

        ReplayClass::create([
            'grade_id'         => $subject->grade_id,
            'subject_id'       => $subject->id,
            'topic_id'         => $request->topic_id,
            'description'      => $request->description,
            'user_id'          => Auth::id(),
            'replay_url'       => $request->replay_url,
            'replay_public_id' => $request->replay_public_id,
            'duration'         => $request->duration,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'status'           => $request->status ?? 'publish',
        ]);

        return redirect()->route('tutor.dashboard')
            ->with('success', 'Replay class successfully saved.');
    }
}
