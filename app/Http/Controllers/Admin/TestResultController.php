<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\TestAnswer;
use Illuminate\Http\Request;
use App\DataTables\TestResultDataTable;

class TestResultController extends Controller
{
    public function index(TestResultDataTable $dataTable, $formSlug, $subjectSlug, $testSlug)
    {
        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();
        $test = Test::where('slug', $testSlug)
                    ->where('grade_id', $grade->id)
                    ->where('subject_id', $subject->id)
                    ->firstOrFail();

        return $dataTable->render('admin.tests.results', compact('test', 'grade', 'subject'));
    }

    public function showAnswers($resultId)
    {
        $result = TestResult::with('test', 'user')->findOrFail($resultId);

        // Get all question IDs for the test
        $questionIds = $result->test->testQuestions()->pluck('id');

        // Find answers by this student for those testQuestions
        $answers = TestAnswer::with('question')
            ->whereIn('test_question_id', $questionIds)
            ->where('user_id', $result->user_id)
            ->get();

        return view('admin.tests.student_answer', compact('result', 'answers'));
    }
}
