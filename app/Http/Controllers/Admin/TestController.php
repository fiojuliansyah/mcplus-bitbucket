<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Test;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\DataTables\TestDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(TestDataTable $dataTable, string $formSlug, string $subjectSlug)
    {
        // form = grade slug
        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();

        return $dataTable->render('admin.tests.index', compact('grade', 'subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_id' => 'required',
            'subject_id' => 'required',
            'user_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        Test::create([
            'grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Test created successfully.');
    }

    public function update(Request $request, $id)
    {

        $test = Test::findOrFail($id);

        $test->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Test updated successfully.');
    }

    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();

        return redirect()->back()->with('success', 'Test deleted successfully.');
    }
}