<?php

namespace App\Http\Controllers\Tutor;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\LiveClass;
<<<<<<< HEAD
use Illuminate\Support\Str;
=======
>>>>>>> e9bf435 (Add Live Class management for tutor)
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TutorCourseController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Get subject IDs assigned to this tutor
        $subjectIds = DB::table('model_has_subjects')
            ->where('user_id', $userId)
            ->pluck('subject_id');

        // Load grades with subjects and topics
        $grades = Grade::with(['subjects' => function ($subjectQuery) use ($subjectIds) {
                $subjectQuery->whereIn('id', $subjectIds)
                    ->with(['topics' => function ($topicQuery) {
                        $topicQuery->where('status', 'active');
                    }]);
            }])
            ->whereHas('subjects', function ($query) use ($subjectIds) {
                $query->whereIn('id', $subjectIds);
            })
            ->get();

        // Load LiveClasses grouped by subject_id
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> parent of ad55921 (update some bug)
            // $liveClasses = LiveClass::whereIn('subject_id', $subjectIds)
            //     ->get()
            //     ->groupBy('subject_id');

        $topics = Topic::whereIn('subject_id', $subjectIds)
=======
        $liveClasses = LiveClass::whereIn('subject_id', $subjectIds)
>>>>>>> e9bf435 (Add Live Class management for tutor)
            ->get()
            ->groupBy('subject_id');

        // Load the user if needed
        $user = Auth::user()->load('current_profile');

<<<<<<< HEAD
<<<<<<< HEAD
        return view('tutor.courses.myCourse', compact('grades', 'topics', 'user'));
=======
        return view('tutor.courses.myCourse', compact('grades', 'liveClasses', 'user'));
>>>>>>> e9bf435 (Add Live Class management for tutor)
=======
        return view('tutor.courses.myCourse', compact('grades', 'topics', 'user'));
>>>>>>> parent of ad55921 (update some bug)
    }


    public function create()
    {
        return view('tutor.courses.uploadCourse');
    }

    public function store(Request $request)
    {
<<<<<<< HEAD
        Topic::create([
            'grade_id'      => $request->grade_id,
            'subject_id'    => $request->subject_id,
            'name'          => $request->topic,
            'slug'          => Str::slug($request->topic),
            'status'        => $request->status

        ]);

        return redirect()->back()->with('success', 'Topic added successfully.');
=======
        LiveClass::create([
            'grade_id'         => $request->grade_id,
            'subject_id'       => $request->subject_id,
            'topic'            => $request->topic,
            'agenda'           => $request->agenda,
            'type'             => $request->type ?? 2,
            'duration'         => $request->duration,
            'timezone'         => $request->timezone,
            'password'         => $request->password,
            'start_time'       => $request->start_time,
            'settings'         => $request->settings ?? 'tbd',
            'zoom_meeting_id'  => $request->zoom_meeting_id,
            'zoom_join_url'    => $request->zoom_join_url,
            'status'           => $request->status,
        ]);

        return redirect()->back()->with('success', 'Live class added successfully.');
>>>>>>> e9bf435 (Add Live Class management for tutor)
    }

    public function update(Request $request, $id)
    {

        $topic = Topic::findOrFail($id);
        $topic->name = $request->name;
        $topic->status = $request->status;
        $topic->save();

        return redirect()->back()->with('success', 'Topic updated successfully.');
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->back()->with('success', 'Topic deleted successfully.');
    }

    public function showClass($id)
    {
       $topic = Topic::with('grade', 'subject')->findOrFail($id);
        return view('tutor.courses.showClass', compact('topic'));
    }

}