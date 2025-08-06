<?php

namespace App\Http\Controllers\Tutor;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\LiveClass;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TutorCourseController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Course Subjects';
        $userId = Auth::id();

        $subjectIds = DB::table('model_has_subjects')
            ->where('user_id', $userId)
            ->pluck('subject_id');

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
        $topics = Topic::whereIn('subject_id', $subjectIds)
            ->get()
            ->groupBy('subject_id');

        $user = Auth::user()->load('current_profile');

        return view('frontend.tutors.courses.index', compact('grades', 'topics', 'user','title'));
    }


    public function create()
    {
        return view('frontend.tutors.courses.uploadCourse');
    }

    public function store(Request $request)
    {
        Topic::create([
            'grade_id'      => $request->grade_id,
            'subject_id'    => $request->subject_id,
            'name'          => $request->topic,
            'slug'          => Str::slug($request->topic),
            'status'        => $request->status

        ]);

        return redirect()->back()->with('success', 'Topic added successfully.');
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
        return view('frontend.tutors.courses.showClass', compact('topic'));
    }

}