<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\DataTables\GradeDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GradeController extends Controller
{
    public function index(GradeDataTable $dataTable)
    {
        $tutors = User::where('account_type', 'tutor')->get();
        return $dataTable->render('admin.grades.index', compact('tutors'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'name' => 'required|string|max:255',
        //     'slug' => 'required|string|max:255|unique:grades,slug',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('grades', 'public');
        }

        Grade::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.grades.index')->with('success', 'Grade created successfully.');
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'name' => 'required|string|max:255',
        //     'slug' => 'required|string|max:255|unique:grades,slug,' . $id,
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        $grade = Grade::findOrFail($id);

        // Handle Image Upload
        $imagePath = $grade->image;
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($grade->image && Storage::exists($grade->image)) {
                Storage::delete($grade->image);
            }
            $imagePath = $request->file('image')->store('grades', 'public');
        }

        $grade->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);

        if ($grade->image && Storage::exists($grade->image)) {
            Storage::delete($grade->image);
        }

        $grade->delete();

        return redirect()->route('admin.grades.index')->with('success', 'Grade deleted successfully.');
    }
}

