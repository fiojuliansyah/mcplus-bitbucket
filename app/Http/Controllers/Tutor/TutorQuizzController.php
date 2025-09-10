<?php

namespace App\Http\Controllers\Tutor;

use Carbon\Carbon;
use App\Models\Quizz;
use App\Models\Topic;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\QuizzQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TutorQuizzController extends Controller
{
    public function index($slug)
    {
        $title = 'Manage Quiz';
        $user = Auth::user();
        $topic = Topic::where('slug', $slug)->firstOrFail();
        $quizzes = $topic->quizzes()->where('user_id', $user->id)->get();

        return view('frontend.tutors.courses.quizz', compact('quizzes', 'title', 'user', 'topic'));
    }

    public function create($subjectSlug)
    {
        $user = Auth::user();

        $subject = Subject::where('slug', $subjectSlug)
            ->with(['grade', 'topics'])
            ->firstOrFail();

        $topics = $subject->topics;

        return view('frontend.tutors.quizzes.create', compact(
            'subject',
            'topics'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|exists:topics,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'estimate_time' => 'required|integer|min:1',
            'attempts_time' => 'required|integer|min:1',
            'max_score' => 'required|integer|min:1',
            'total_question' => 'required|integer|min:1',
            'auto_mark' => 'required|in:yes,no',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $topic = Topic::with(['subject.grade'])->findOrFail($request->topic_id);
        $subject = $topic->subject;
        $grade = $subject->grade;

        $quiz = Quizz::create([
            'user_id' => Auth::id(),
            'topic_id' => $topic->id,
            'subject_id' => $subject->id,
            'grade_id' => $grade->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'estimate_time' => $request->estimate_time,
            'attempts_time' => $request->attempts_time,
            'max_score' => $request->max_score,
            'total_question' => $request->total_question,
            'auto_mark' => $request->auto_mark,
        ]);

        return redirect()->route('tutor.quizzes.add-questions', $quiz->id)
            ->with('success', 'Quiz details saved successfully! Now, add questions.');
    }

    public function update(Request $request, $topic_id, $quizz_id)
    {
        $quizz = Quizz::findOrFail($quizz_id);
        $topic = Topic::findOrFail($topic_id);

        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $answers = [];
        
        foreach ($request['options'] as $index => $optionText) {
            $answers[] = [
                'answer'     => $optionText,
                'is_correct' => $index == $request['correct_option'],
            ];
        };

        $quizz->grade_id            = $topic->grade_id;
        $quizz->subject_id          = $topic->subject_id;
        $quizz->topic_id            = $topic->id;
        $quizz->user_id             = Auth::id();
        $quizz->question            = $request->question;
        $quizz->multiple_choice     = json_encode($answers);
        $quizz->save();

        return redirect()->back()->with('success', 'Quizz updated successfully.');
    }

    public function destroy($id)
    {
        $quizz = Quizz::findOrFail($id);
        $quizz->delete();

        return redirect()->back()->with('success', 'Quizz deleted successfully.');
    }

    public function addQuestions($quizzId)
    {
        $quizz = Quizz::with(['topic', 'questions'])->findOrFail($quizzId);

        return view('frontend.tutors.quizzes.add-questions', compact('quizz'));
    }

    public function storeQuestion(Request $request, Quizz $quizz)
    {
        $validator = Validator::make($request->all(), [
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string|max:2000',
            'questions.*.media_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4|max:20480',
            'questions.*.score' => 'required|integer|min:1',
            'questions.*.answer_type' => 'required|in:single_choice,multiple_choice,true_false,text',
            'questions.*.options' => 'required_if:questions.*.answer_type,single_choice,multiple_choice',
            'questions.*.correct_option' => 'required_unless:questions.*.answer_type,text',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $quizz->questions()->delete();

            foreach ($request->questions as $questionData) {
                
                $options = null;
                $correctAnswer = null;

                switch ($questionData['answer_type']) {
                    case 'single_choice':
                        $options = collect($questionData['options'] ?? [])->map(fn($opt) => ['text' => $opt])->all();
                        $correctAnswer = isset($questionData['correct_option']) ? [$questionData['correct_option']] : [];
                        break;
                    case 'multiple_choice':
                        $options = collect($questionData['options'] ?? [])->map(fn($opt) => ['text' => $opt])->all();
                        $correctAnswer = isset($questionData['correct_option']) ? (array)$questionData['correct_option'] : [];
                        break;
                    case 'true_false':
                        $options = [['text' => 'True'], ['text' => 'False']];
                        $correctAnswer = isset($questionData['correct_option']) ? [$questionData['correct_option']] : [];
                        break;
                    case 'text':
                        $options = isset($questionData['options']) ? [['text' => $questionData['options']]] : null;
                        $correctAnswer = null;
                        break;
                }

                $mediaUrl = null;
                $mediaType = null;
                if (isset($questionData['media_file'])) {
                    $file = $questionData['media_file'];
                    $path = $file->store("quizzes/{$quizz->id}", 'public');
                    $mediaUrl = $path;
                    $mime = $file->getMimeType();
                    if (str_starts_with($mime, 'image/')) $mediaType = 'image';
                    elseif (str_starts_with($mime, 'video/')) $mediaType = 'video';
                }

                QuizzQuestion::create([
                    'quizz_id' => $quizz->id,
                    'question_text' => $questionData['question_text'],
                    'answer_type' => $questionData['answer_type'],
                    'score' => $questionData['score'],
                    'options' => $options,
                    'correct_answer' => $correctAnswer,
                    'media_url' => $mediaUrl,
                    'media_type' => $mediaType,
                ]);
            }

            DB::commit();
            return redirect()->route('tutor.quizzes.preview', $quizz->id)->with('success', 'All questions have been saved! Please review and publish.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error saving quiz questions for quizz ID {$quizz->id}: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return back()->withInput()->with('error', 'An error occurred while saving the questions. Please check your inputs and try again.');
        }
    }

    public function previewQuestions(Quizz $quizz)
    {
        $quizz->load(['questions', 'subject', 'grade', 'topic']);
        return view('frontend.tutors.quizzes.preview-questions', compact('quizz'));
    }

    public function publishQuizz(Request $request, Quizz $quizz)
    {
        $request->validate([
            'action' => 'required|in:publish,save_draft',
            'published_at' => 'required_if:action,publish|date|after_or_equal:today',
        ]);

        if ($request->action === 'publish') {
            $quizz->status = 'published';
            $quizz->published_at = Carbon::parse($request->published_at);
            $message = 'Quiz has been successfully published!';
        } else {
            $quizz->status = 'draft';
            $quizz->published_at = null;
            $message = 'Quiz has been saved as a draft.';
        }

        $quizz->save();
        return redirect()->route('tutor.dashboard')->with('success', $message);
    }
}
