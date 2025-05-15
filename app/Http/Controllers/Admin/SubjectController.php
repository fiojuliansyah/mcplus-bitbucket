<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\DataTables\SubjectDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    public function index(SubjectDataTable $dataTable, $slug)
    {
        $grades = Grade::all();
        $grade = Grade::where('slug', $slug)->first();
        return $dataTable->render('admin.subjects.index', compact('grades','grade'));
    }

    public function store(Request $request, $slug)
    {
        $grade = Grade::where('slug', $slug)->first();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('subjects', 'public');
        }

        $subject = Subject::create([
            'grade_id' => $grade->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'trailer' => $request->trailer,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'grade_id' => 'required|exists:grades,id',
        //     'name' => 'required|string|max:255',
        //     'slug' => 'required|string|max:255|unique:subjects,slug,' . $id,
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'trailer' => 'nullable|url',
        //     'status' => 'required|string|max:255',
        // ]);

        $subject = Subject::findOrFail($id);

        $imagePath = $subject->image;
        if ($request->hasFile('image')) {
            if ($subject->image && Storage::exists($subject->image)) {
                Storage::delete($subject->image);
            }

            $imagePath = $request->file('image')->store('subjects', 'public');
        }

        $subject->update([
            'grade_id' => $request->grade_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'trailer' => $request->trailer,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
