<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Quizz;
use App\Models\QuizzAnswer;
use App\Models\QuizzResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class UserQuizzController extends Controller
{
    public function index(Topic $topic)
    {
        $title = 'Quizzes';
        $user = Auth::user();
        $quizzes = Quizz::where('topic_id', $topic->id)->get();

        return view('frontend.students.quizz.index', compact('topic', 'quizzes','title','user'));
    }

    public function submit(Request $request, Grade $grade, Subject $subject, Topic $topic)
    {
        $user = Auth::user();
        $submittedAnswers = $request->input('answers', []);
        $quizzes = Quizz::where('topic_id', $topic->id)->get();

        $correctCount = 0;

        foreach ($quizzes as $quiz) {
            $options = json_decode($quiz->multiple_choice, true);
            $correctIndex = collect($options)->search(fn($opt) => $opt['is_correct'] === true);
            $userAnswerIndex = $submittedAnswers[$quiz->id] ?? null;

            $selectedAnswerText = $userAnswerIndex !== null && isset($options[$userAnswerIndex])
                ? $options[$userAnswerIndex]['answer']
                : null;

            $isCorrect = ((string)$userAnswerIndex === (string)$correctIndex);

            QuizzAnswer::create([
                'user_id'   => $user->id,
                'quizz_id'  => $quiz->id,
                'answer'    => $selectedAnswerText,
                'is_correct'=> $isCorrect,
            ]);

            if ($isCorrect) {
                $correctCount++;
            }
        }

        $totalQuestions = $quizzes->count();
        $score = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;

        $result = QuizzResult::create([
            'user_id'         => $user->id,
            'topic_id'        => $topic->id,
            'score'           => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctCount,
        ]);

        return redirect()->route('user.quizzes.result.show', $result->id);
    }

    public function show($id)
    {
        $result = QuizzResult::with('topic')->findOrFail($id);
        $answers = QuizzAnswer::with('quizz')->where('user_id', auth()->id())
                              ->whereIn('quizz_id', function ($query) use ($result) {
                                  $query->select('id')
                                        ->from('quizzes')
                                        ->where('topic_id', $result->topic_id);
                              })->get();

        return view('frontend.students.quizz.result', compact('result', 'answers'));
    }
}