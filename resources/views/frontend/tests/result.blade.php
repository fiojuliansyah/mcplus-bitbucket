@extends('frontend.layouts.app')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="card shadow-sm p-4 mb-4">
            <h4 class="mb-3">Test Result: {{ $test->name }}</h4>
            <p><strong>Grade:</strong> {{ $grade->name }}</p>
            <p><strong>Subject:</strong> {{ $subject->name }}</p>
            <p><strong>Tutor:</strong> {{ $test->user->name ?? '-' }}</p>
            <p><strong>Score:</strong> {{ $testResult->score }} / 100</p>
            <p><strong>Total Questions:</strong> {{ $testResult->total_questions }}</p>
            <p><strong>Correct Answers:</strong> {{ $testResult->correct_answers }}</p>
        </div>

        @foreach ($answers as $answer)
            @php
                $question = $answer->question;
                $choices = json_decode($question->answer, true); // for multiple choice
                $studentAnswer = $answer->answer;
                $isCorrect = $answer->is_correct;
                $correctOption = null;

                if ($question->type === 'multiple') {
                    $correctOption = collect($choices)->firstWhere('is_correct', true)['answer'] ?? null;
                } elseif ($question->type === 'essay') {
                    $expectedEssay = json_decode($question->answer, true);
                    $correctOption = $expectedEssay['essay_answer'] ?? '-';
                }
            @endphp

            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3"><strong>Q:</strong> {{ $question->question }}</h6>

                    @if ($question->type === 'multiple')
                        <p><strong>Your Answer:</strong> {{ $studentAnswer }}</p>
                        <p><strong>Correct Answer:</strong> {{ $correctOption }}</p>
                    @else
                        <p><strong>Your Answer:</strong></p>
                        <p class="p-2">{{ $studentAnswer }}</p>
                        <p><strong>Expected Answer:</strong></p>
                        <p class="p-2">{{ $correctOption }}</p>
                    @endif

                    @if ($isCorrect)
                        <span class="badge bg-success">Correct</span>
                    @else
                        <span class="badge bg-danger">Incorrect</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
