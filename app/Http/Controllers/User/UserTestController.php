<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestAnswer;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserTestController extends Controller
{
    public function index($gradeSlug, $subjectSlug)
    {
        // Find the grade and subject based on the slugs
        $grade = Grade::where('slug', $gradeSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();

        // Get tests for this subject
        $tests = Test::where('subject_id', $subject->id)
                    ->with('user') // Assuming test has a tutor (user) relationship
                    ->orderBy('start_time', 'desc')
                    ->get();

        return view('frontend.tests.index', compact('grade', 'subject', 'tests'));
    }

    public function show($gradeSlug, $subjectSlug, $testSlug)
    {
        $grade = Grade::where('slug', $gradeSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();
        $test = Test::where('slug', $testSlug)->where('subject_id', $subject->id)->firstOrFail();

        $questions = $test->testQuestions()->orderBy('type', 'desc')->get(); // Assuming relation is defined

        return view('frontend.tests.show', compact('grade', 'subject', 'test', 'questions'));
    }

    public function submit(Request $request, $testId)
    {
        $user = auth()->user();
        $test = Test::findOrFail($testId);

        $data = $request->input('questions', []);
        $total = 0;
        $correct = 0;

        DB::beginTransaction();

        try {
            foreach ($data as $questionId => $details) {
                $question = TestQuestion::find($questionId);

                if (!$question) {
                    continue;
                }

                $answerValue = $details['answer'];
                $isCorrect = null;

                if ($question->type === 'multiple') {
                    $decoded = json_decode($question->answer, true);

                    $matched = collect($decoded)->firstWhere('answer', $answerValue);
                    $isCorrect = $matched['is_correct'] ?? false;

                    if ($isCorrect) {
                        $correct++;
                    }
                    $total++;
                } else {
                    // essay, save answer only, wait for manual grading
                    $isCorrect = null;
                    $total++;
                }

                TestAnswer::create([
                    'user_id' => $user->id,
                    'test_question_id' => $question->id,
                    'answer' => is_string($answerValue) ? $answerValue : (string) $answerValue,
                    'is_correct' => $isCorrect,
                ]);
            }

            $score = $total > 0 ? intval(($correct / $total) * 100) : 0;

            TestResult::create([
                'user_id' => $user->id,
                'test_id' => $test->id,
                'total_questions' => $total,
                'correct_answers' => $correct,
                'score' => $score,
            ]);

            DB::commit();

            return redirect()->route('user.test.result', [
                'gradeSlug' => $test->grade->slug,
                'subjectSlug' => $test->subject->slug,
                'testSlug' => $test->slug,
            ])->with('success', 'Test submitted successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong while submitting the test.');
        }
    }

    public function result($gradeSlug, $subjectSlug, $testSlug)
    {
        $user = Auth::user();

        // Load test with related data
        $test = Test::where('slug', $testSlug)->with('testQuestions', 'user')->firstOrFail();
        $grade = Grade::where('slug', $gradeSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->firstOrFail();

        // Find user's test result
        $testResult = TestResult::where('user_id', $user->id)
            ->where('test_id', $test->id)
            ->firstOrFail();

        // Get all answers for this user and this test's questions
        $answers = TestAnswer::with('question')
            ->where('user_id', $user->id)
            ->whereIn('test_question_id', $test->testQuestions->pluck('id'))
            ->get();

        return view('frontend.tests.result', compact(
            'test',
            'grade',
            'subject',
            'testResult',
            'answers'
        ));
    }
}
