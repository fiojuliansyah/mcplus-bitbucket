<?php

namespace App\Http\Controllers\Tutor;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Http\Controllers\Controller;

class TutorTestController extends Controller
{
    public function index($formSlug, $subjectSlug)
    {
        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();

        $tests = Test::where('subject_id', $subject->id)->get();

        return view('tutor.tests.index', compact('grade', 'subject', 'tests'));
    }

    public function store(Request $request, $formSlug, $subjectSlug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();

        Test::create([
            'grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Test created successfully!');
    }

    public function update(Request $request, Test $test)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $test->update([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Test updated successfully!');
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->back()->with('success', 'Test deleted successfully!');
    }

    public function show($gradeSlug, $subjectSlug, $testSlug)
    {
        $grade = Grade::where('slug', $gradeSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->firstOrFail();
        $test = Test::where('slug', $testSlug)->where('grade_id', $grade->id)->where('subject_id', $subject->id)->firstOrFail();

        $test->load(['user']);
        $questions = TestQuestion::where('test_id', $test->id)->orderBy('type', 'desc')->get();

        return view('tutor.tests.show', compact('test', 'grade', 'subject', 'questions'));
    }

}
