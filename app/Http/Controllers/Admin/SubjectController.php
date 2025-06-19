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

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('subjects', 'public');
        }

        $subject = Subject::create([
            'grade_id' => $grade->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'thumbnail' => $thumbnailPath,
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
        //     'thumbnail' => 'nullable|thumbnail|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'trailer' => 'nullable|url',
        //     'status' => 'required|string|max:255',
        // ]);

        $subject = Subject::findOrFail($id);

        $thumbnailPath = $subject->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($subject->thumbnail && Storage::exists($subject->thumbnail)) {
                Storage::delete($subject->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('subjects', 'public');
        }

        $subject->update([
            'grade_id' => $request->grade_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'thumbnail' => $thumbnailPath,
            'trailer' => $request->trailer,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->back()->with('success', 'Subject deleted successfully.');
    }
}
