<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Quizz;
use App\Models\ModelHasSubject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\DataTables\QuizzDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class QuizzController extends Controller
{
    public function index(QuizzDataTable $dataTable, string $formSlug, string $subjectSlug, string $topicSlug)
    {
        // form = grade slug
        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();
        $topic = Topic::where('slug', $topicSlug)->where('grade_id', $grade->id)->where('subject_id', $subject->id)->firstOrFail();
        $tutors = ModelHasSubject::with('user')
                    ->where('subject_id', $subject->id)
                    ->get(); // 👈 now it's a Collection
        return $dataTable->render('admin.quizzes.index', compact('grade', 'subject', 'topic', 'tutors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question'       => 'required|string|max:255',
            'options'        => 'required|array|min:2',
            'options.*'      => 'required|string|max:255',
            'correct_option' => 'required|integer',
            'grade_id'       => 'required|exists:grades,id',
            'subject_id'     => 'required|exists:subjects,id',
            'topic_id'       => 'required|exists:topics,id',
            'user_id'        => 'required|exists:users,id',
        ]);

        $answers = [];

        foreach ($validated['options'] as $index => $optionText) {
            $answers[] = [
                'answer'     => $optionText,
                'is_correct' => $index == $validated['correct_option'],
            ];
        }

        Quizz::create([
            'user_id'    => $validated['user_id'], // 👈 get the currently authenticated user ID
            'question'   => $validated['question'],
            'multiple_choice'    => json_encode($answers),
            'grade_id'   => $validated['grade_id'],
            'subject_id' => $validated['subject_id'],
            'topic_id'   => $validated['topic_id'],
        ]);

        return redirect()->back()->with('success', 'Quiz created successfully!');
    }

    public function update(Request $request, $id)
    {
        $quizz = Quizz::findOrFail($id);

        $validated = $request->validate([
            'question'       => 'required|string|max:255',
            'options'        => 'required|array|min:2',
            'options.*'      => 'required|string|max:255',
            'correct_option' => 'required|integer',
            'grade_id'       => 'required|exists:grades,id',
            'subject_id'     => 'required|exists:subjects,id',
            'topic_id'       => 'required|exists:topics,id',
            'user_id'        => 'required|exists:users,id',
        ]);

        // Prepare answers as JSON
        $answers = [];
        foreach ($request->options as $index => $optionText) {
            $answers[] = [
                'answer'     => $optionText,
                'is_correct' => $index == $request->correct_option,
            ];
        }

        $quizz->update([
            'question'          => $request->question,
            'multiple_choice'   => json_encode($answers),
            'user_id'           => $request->user_id,
        ]);

        return redirect()->back()->with('success', 'Quizz updated successfully.');
    }
    
    public function destroy(Request $request, $id)
    {
        $quizz = Quizz::findOrFail($id);
        $quizz->delete();
        return redirect()->back()->with('success', 'Quizz deleted successfully.');
    }
}