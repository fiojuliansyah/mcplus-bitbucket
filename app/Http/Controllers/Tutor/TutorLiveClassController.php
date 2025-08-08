<?php

namespace App\Http\Controllers\Tutor;

use Carbon\Carbon;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\LiveClass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TutorLiveClassController extends Controller
{
    public function getTopics(Request $request)
    {
        $user = Auth::user();
        $subjectId = $request->subject_id;

        $subject = $user->subjects()->where('subjects.id', $subjectId)->first();

        if (!$subject) {
            return response()->json(['topics' => []]);
        }

        $topics = $subject->topics()->select('id', 'name')->get();

        return response()->json(['topics' => $topics]);
    }

    public function index(Request $request)
    {
        $title = 'Live Classes';
        $user = Auth::user();

        $subjects = $user->subjects()->with('grade')->orderBy('name')->get();

        $subjectIds = $subjects->pluck('id');
        $topics = Topic::whereIn('subject_id', $subjectIds)->get();

        $query = LiveClass::where('user_id', $user->id)
                    ->with(['subject','grade','topic'])
                    ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $liveClasses = $query->paginate(10);

        return view('frontend.tutors.live-classes.index', compact('user', 'title', 'liveClasses', 'subjects', 'topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'topic_id'   => 'required|exists:topics,id',
            'agenda'     => 'required|string|max:1000',
            'start_time' => 'required|date',
            'duration'   => 'required|integer|min:1',
            'status'     => 'nullable|in:draft,scheduled,pending,approved',
        ]);

        try {
            $tutor = Auth::user();

            if (!$tutor->email) {
                return back()->withInput()->with('error', 'Tutor does not have an email address.');
            }

            $defaultSettings = [
                'host_video'        => false,
                'participant_video' => false,
                'join_before_host'  => false,
                'mute_upon_entry'   => false,
                'waiting_room'      => false,
            ];

            $rawSettings = $request->input('settings', []);
            $processedSettings = array_merge($defaultSettings, $rawSettings);

            foreach ($processedSettings as $key => $value) {
                if (array_key_exists($key, $defaultSettings)) {
                    $processedSettings[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
            }

            $subject = Subject::findOrFail($request->subject_id);
            $gradeId = $subject->grade_id;

            if (!$gradeId) {
                return back()->withInput()->with('error', 'Subject has no associated grade.');
            }

            $liveClassData = [
                'grade_id'   => $gradeId,
                'subject_id' => $subject->id,
                'topic_id'   => $request->topic_id,
                'user_id'    => $tutor->id,
                'agenda'     => $request->agenda,
                'type'       => 1,
                'duration'   => $request->duration,
                'start_time' => Carbon::parse($request->start_time, 'Asia/Jakarta'),
                'timezone'   => 'Asia/Jakarta',
                'status'     => $request->input('status', 'draft'),
                'settings'   => $processedSettings,
            ];

            $liveClass = LiveClass::create($liveClassData);

            return redirect()->back()->with('success', 'Live Class successfully saved (not created in Zoom yet).');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'There is an error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'topic_id'   => 'required|exists:topics,id',
            'agenda'     => 'required|string|max:1000',
            'start_time' => 'required|date',
            'duration'   => 'required|integer|min:1',
            'status'     => 'nullable|in:draft,scheduled,pending,approved',
        ]);

        try {
            $tutor = Auth::user();
            $liveClass = LiveClass::where('id', $id)->where('user_id', $tutor->id)->firstOrFail();

            $subject = Subject::findOrFail($request->subject_id);
            $gradeId = $subject->grade_id;

            if (!$gradeId) {
                return back()->withInput()->with('error', 'Subject has no associated grade.');
            }

            $defaultSettings = [
                'host_video'        => false,
                'participant_video' => false,
                'join_before_host'  => false,
                'mute_upon_entry'   => false,
                'waiting_room'      => false,
            ];

            $rawSettings = $request->input('settings', []);
            $processedSettings = array_merge($defaultSettings, $rawSettings);

            foreach ($processedSettings as $key => $value) {
                if (array_key_exists($key, $defaultSettings)) {
                    $processedSettings[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
            }

            $liveClass->update([
                'grade_id'   => $gradeId,
                'subject_id' => $subject->id,
                'topic_id'   => $request->topic_id,
                'agenda'     => $request->agenda,
                'duration'   => $request->duration,
                'start_time' => Carbon::parse($request->start_time, 'Asia/Jakarta'),
                'status'     => $request->input('status', 'draft'),
                'settings'   => $processedSettings,
            ]);

            return redirect()->back()->with('success', 'Live Class successfully updated.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $tutor = Auth::user();
            $liveClass = LiveClass::where('id', $id)->where('user_id', $tutor->id)->firstOrFail();

            $liveClass->delete();

            return redirect()->back()->with('success', 'Live Class successfully deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

}
