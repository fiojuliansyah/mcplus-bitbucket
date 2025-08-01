@extends('admin.layouts.master')

@section('content')
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div class="card mt-4">
        <div class="card-header">
            <h4>Answers for {{ $result->user->name }} - Test: {{ $result->test->name }}</h4>
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm mt-2">Back</a>
        </div>
        <div class="card-body">
            @foreach ($answers as $answer)
                @php
                    $question = $answer->question;
                    $choices = json_decode($question->answer, true);
                    $studentAnswer = $answer->answer;
                    $isCorrect = $answer->is_correct;
                    $correctOption = null;

                    if ($question->type === 'multiple') {
                        $correctOption = collect($choices)->firstWhere('is_correct', true)['answer'] ?? '-';
                    } elseif ($question->type === 'essay') {
                        $expectedEssay = json_decode($question->essay_answer, true);
                        $correctOption = $expectedEssay['essay_answer'] ?? '-';
                    }
                @endphp

                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h6><strong>Q:</strong> {{ $question->question }}</h6>
                        <p><strong>Your Answer:</strong> {{ $studentAnswer }}</p>
                        <p><strong>Correct Answer:</strong> {{ $correctOption }}</p>
                        
                        @if($question->type == 'multiple')
                        <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }}">
                            {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                        </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
