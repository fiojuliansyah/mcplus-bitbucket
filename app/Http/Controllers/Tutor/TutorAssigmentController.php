<?php

namespace App\Http\Controllers\Tutor;

use App\Models\Test;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TutorAssigmentController extends Controller
{

    public function assignments(Request $request)
    {
        $title = 'Assignments';
        $user = Auth::user();

        $subjects = $user->subjects()->with('grade')->orderBy('name')->get();

        $query = Test::where('user_id', $user->id)
                    ->with(['subject.grade'])
                    ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $tests = $query->paginate(10);

        return view('frontend.tutors.assignments.index', compact('user', 'title', 'tests', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:draft,publish',
        ]);

        $subject = Subject::find($validated['subject_id']);

        Test::create([
            'user_id' => Auth::id(),
            'subject_id' => $validated['subject_id'],
            'grade_id' => $subject->grade_id,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']), 
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Assignment created successfully.');
    }


    public function update(Request $request, Test $test) 
    {
        if ($test->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:draft,publish',
        ]);

        $subject = Subject::find($validated['subject_id']);

        $test->update([
            'subject_id' => $validated['subject_id'],
            'grade_id' => $subject->grade_id,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . uniqid(),
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Assignment updated successfully.');
    }

    public function destroy(Test $test)
    {
        if ($test->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $test->delete();

        return redirect()->back()->with('success', 'Assignment deleted successfully.');
    }
}
