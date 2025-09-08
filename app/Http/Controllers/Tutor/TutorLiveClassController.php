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
            'topic_name' => 'required|string|max:255',
            'agenda'     => 'required|string|max:1000',
            'class_day'  => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'start_time' => ['required', 'date_format:H:i'], // input type="time"
            'duration'   => 'required|integer|min:1',
            'status'     => 'nullable|in:draft,scheduled,pending,approved',
        ]);

        try {
            $tutor = Auth::user();

            $subject = Subject::findOrFail($request->subject_id);
            $gradeId = $subject->grade_id;

            // Buat topic jika belum ada
            $topic = Topic::firstOrCreate(
                ['name' => $request->topic_name, 'subject_id' => $subject->id],
                ['slug' => Str::slug($request->topic_name), 'grade_id' => $gradeId, 'status' => 'active']
            );

            // Default Zoom settings
            $defaultSettings = [
                'host_video'        => false,
                'participant_video' => false,
                'join_before_host'  => false,
                'mute_upon_entry'   => false,
                'waiting_room'      => false,
                'audio'             => 'both',
                'auto_recording'    => 'none',
                'approval_type'     => 0,
            ];

            $rawSettings = $request->input('settings', []);
            $processedSettings = array_merge($defaultSettings, $rawSettings);

            foreach ($processedSettings as $key => $value) {
                if (array_key_exists($key, $defaultSettings)) {
                    $processedSettings[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ?: $value;
                }
            }

            LiveClass::create([
                'grade_id'   => $gradeId,
                'subject_id' => $subject->id,
                'topic_id'   => $topic->id,
                'user_id'    => $tutor->id,
                'agenda'     => $request->agenda,
                'type'       => 1,
                'duration'   => $request->duration,
                'class_day'  => $request->class_day,
                'start_time' => $request->start_time, // simpan sebagai TIME
                'password'   => $request->password ?? Str::random(8),
                'timezone'   => 'Asia/Jakarta',
                'status'     => $request->input('status', 'draft'),
                'settings'   => $processedSettings,
            ]);

            return redirect()->route('tutor.dashboard')
                            ->with('success', 'Live Class successfully saved (not created in Zoom yet).');

        } catch (\Exception $e) {
            \Log::error('LiveClass store error: '.$e->getMessage());
            return back()->withInput()->with('error', 'There is an error: ' . $e->getMessage());
        }
    }

    public function edit(LiveClass $liveClass)
    {

        $title = 'Edit Live Class';

        $liveClass->load(['subject.grade', 'topic']);

        return view('frontend.tutors.live-classes.edit', compact('liveClass', 'title'));
    }

    public function update(Request $request, LiveClass $liveClass)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
            'agenda'     => 'required|string|max:1000',
            'start_time' => 'required|date',
            'duration'   => 'required|integer|min:1',
            'status'     => 'nullable|in:draft,scheduled,pending,approved',
        ]);

        try {
            $subject = $liveClass->subject;
            $gradeId = $subject->grade_id;

            $topic = Topic::firstOrCreate(
                [
                    'name'       => $request->topic_name,
                    'subject_id' => $subject->id,
                ],
                [
                    'slug'       => Str::slug($request->topic_name),
                    'grade_id'   => $gradeId,
                    'status'     => 'active',
                ]
            );
            
            $defaultSettings = [
                'host_video'        => false, 'participant_video' => false,
                'join_before_host'  => false, 'mute_upon_entry'   => false,
                'waiting_room'      => false,
            ];
            $rawSettings = $request->input('settings', []);
            $processedSettings = array_merge($defaultSettings, $rawSettings);
            foreach ($processedSettings as $key => $value) {
                if (array_key_exists($key, $defaultSettings)) {
                    $processedSettings[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
            }

            $liveClassData = [
                'topic_id'   => $topic->id,
                'agenda'     => $request->agenda,
                'duration'   => $request->duration,
                'start_time' => Carbon::parse($request->start_time, 'Asia/Jakarta'),
                'status'     => $request->input('status', $liveClass->status),
                'settings'   => $processedSettings,
            ];

            $liveClass->update($liveClassData);

            return redirect()->route('tutor.dashboard')->with('success', 'Live Class updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function destroy(LiveClass $liveClass)
    {
        try {
            $tutor = Auth::user();
            $liveClass = LiveClass::where('user_id', $tutor->id)->firstOrFail();
            $liveClass->delete();

            return redirect()->back()->with('success', 'Live Class successfully deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}
