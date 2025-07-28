<?php

namespace App\Http\Controllers\Tutor;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Http\Controllers\Controller;

class TutorTestQuestionController extends Controller
{
    public function store(Request $request, string $formSlug, string $subjectSlug, string $testSlug)
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

        return back()->with('success', 'Question added!');
    }
}