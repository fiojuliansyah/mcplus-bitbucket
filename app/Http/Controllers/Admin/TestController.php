<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\DataTables\TestDataTable;
use App\DataTables\TestQuestionDataTable;
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

    public function manage(TestQuestionDataTable $dataTable, string $formSlug, string $subjectSlug, string $testSlug)
    {
        // form = grade slug
        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();
        $test = Test::where('slug', $testSlug)->where('grade_id', $grade->id)->where('subject_id', $subject->id)->firstOrFail();

        return $dataTable->render('admin.tests.manage', compact('grade', 'subject', 'test'));

    }

    public function storeQuestion(Request $request, string $formSlug, string $subjectSlug, string $testSlug)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'type' => 'required|in:multiple,essay',
            'question' => 'required|string',
        ]);

        $type = $request->type;

        if ($type === 'multiple') {
            $options = $request->input('options');
            $correctIndex = $request->input('correct_option');

            // Validation: at least one option and one correct answer
            if (!$options || !is_array($options) || count($options) < 2) {
                return back()->with('error', 'Please provide at least 2 options.');
            }

            if (!isset($options[$correctIndex])) {
                return back()->with('error', 'Please mark a correct answer.');
            }

            $answer = []; // define $answer instead of $answers

            foreach ($options as $index => $optionText) {
                $answer[] = [
                    'answer'     => $optionText,
                    'is_correct' => $index == $correctIndex,
                ];
            }

        } else {
            // Essay
            $essayAnswer = $request->input('essay_answer');

            if (!$essayAnswer) {
                return back()->with('error', 'Please provide an essay answer.');
            }

            $answer = [
                'essay_answer' => $essayAnswer,
            ];
        }

        TestQuestion::create([
            'test_id' => $request->input('test_id'),
            'type' => $type,
            'question' => $request->input('question'),
            'answer' => json_encode($answer),
        ]);

        return redirect()->back()->with('success', 'Question saved successfully.');
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = TestQuestion::findOrFail($id);

        $request->validate([
            'question' => 'required|string',
            'type'     => 'required|in:multiple,essay',
        ]);

        $data = [
            'question' => $request->input('question'),
            'type'     => $request->input('type'),
        ];

        if ($request->type === 'multiple') {
            $options = $request->input('options', []);
            $correctIndex = $request->input('correct_option');

            $formattedAnswers = [];
            foreach ($options as $index => $option) {
                $formattedAnswers[] = [
                    'answer'     => $option,
                    'is_correct' => (int) $index === (int) $correctIndex,
                ];
            }

            $data['answer'] = json_encode($formattedAnswers);
        } elseif ($request->type === 'essay') {
            $data['answer'] = json_encode([
                'essay_answer' => $request->input('essay_answer', ''),
            ]);
        }

        $question->update($data);

        return redirect()->back()->with('success', 'Question updated successfully.');
    }

    public function destroyQuestion($id)
    {
        $question = TestQuestion::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully.');
    }
}