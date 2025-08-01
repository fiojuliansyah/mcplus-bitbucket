<?php

namespace App\Http\Controllers\Tutor;

use App\Models\Topic;
use App\Models\Quizz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TutorQuizzController extends Controller
{
    public function index($id)
    {
        $userId = Auth::id();
        $topic = Topic::findOrFail($id);
        $quizzes = $topic->quizzes()->where('user_id', $userId)->get();

        return view('tutor.courses.quizz', compact('topic', 'quizzes'));
    }

    public function store(Request $request, $topic_id)
    {

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

        Quizz::create([
            'grade_id'   => $request['grade_id'],
            'subject_id' => $request['subject_id'],
            'topic_id'   => $request['topic_id'],
            'user_id'    => Auth::id(),
            'question'   => $request['question'],
            'multiple_choice'    => json_encode($answers),
        ]);

        return redirect()->back()->with('success', 'Quiz created successfully!');
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
}
