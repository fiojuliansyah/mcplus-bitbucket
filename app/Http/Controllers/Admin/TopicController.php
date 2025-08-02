<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\DataTables\TopicDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
{
    public function index(TopicDataTable $dataTable, string $formSlug, string $subjectSlug)
    {
        // form = grade slug
        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();

        return $dataTable->render('admin.topics.index', compact('grade', 'subject'));
    }

    public function store(Request $request, $formSlug, $subjectSlug)
    {
        // form = grade slug
        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();


        $subject = Topic::create([
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->back()->with('success', 'Topic created successfully.');
    }

    public function update(Request $request, $id)
    {

        $topic = Topic::findOrFail($id);

        $topic->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->back()->with('success', 'Topic updated successfully.');
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->back()->with('success', 'Topic deleted successfully.');
    }
<<<<<<< HEAD

    public function bySubject($gradeId, $subjectId)
    {
        $topics = Topic::where('grade_id', $gradeId)
                    ->where('subject_id', $subjectId)
                    ->get(['id', 'name']);
        return response()->json($topics);
    }

=======
>>>>>>> 304dd22 (Add Datatable & CRUD for Topics)
}