@extends('frontend.layouts.app2')

@push('styles')
<style>
    .score-card {
        background-color: #f8f9fa;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
    }
    .score-value {
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--bs-primary);
    }
    .accordion-button:not(.collapsed) {
        box-shadow: none;
    }
    .accordion-item.correct-answer {
        border-left: 5px solid var(--bs-success);
    }
    .accordion-item.incorrect-answer {
        border-left: 5px solid var(--bs-danger);
    }
    .answer-block {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
    }
    .user-answer.incorrect {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
    }
    .correct-answer-key {
        background-color: rgba(25, 135, 84, 0.1);
        border: 1px solid rgba(25, 135, 84, 0.2);
    }
    .bi-check-circle-fill { color: var(--bs-success); }
    .bi-x-circle-fill { color: var(--bs-danger); }
</style>
@endpush

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="card shadow-sm p-4 mb-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-3">Test Result: {{ $test->name }}</h3>
                    <p class="mb-1"><strong>Subject:</strong> {{ $subject->name }} ({{ $grade->name }})</p>
                    <p class="mb-0"><strong>Tutor:</strong> {{ $test->user->name ?? '-' }}</p>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <div class="score-card">
                        <h6 class="text-muted mb-0">YOUR SCORE</h6>
                        <div class="score-value">{{ $testResult->score }}</div>
                        <div class="fw-bold">{{ $testResult->correct_answers }} / {{ $testResult->total_questions }} Correct</div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-4">📋 Your Review Answer</h4>

        <div class="accordion" id="resultAccordion">
            @foreach ($answers as $index => $answer)
                @php
                    $question = $answer->question;
                    $choices = json_decode($question->answer, true);
                    $studentAnswer = $answer->answer;
                    $isCorrect = $answer->is_correct;
                    $correctOption = null;

                    if ($question->type === 'multiple') {
                        $correctOption = collect($choices)->firstWhere('is_correct', true)['answer'] ?? 'Kunci jawaban tidak ditemukan';
                    } elseif ($question->type === 'essay') {
                        $expectedEssay = json_decode($question->answer, true);
                        $correctOption = $expectedEssay['essay_answer'] ?? '-';
                    }
                @endphp

                <div class="accordion-item mb-3 shadow-sm {{ $isCorrect ? 'correct-answer' : 'incorrect-answer' }}">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                            @if ($isCorrect)
                                <i class="bi bi-check-circle-fill me-2"></i>
                            @else
                                <i class="bi bi-x-circle-fill me-2"></i>
                            @endif
                            Question #{{ $loop->iteration }}: {{ Str::limit($question->question, 80) }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#resultAccordion">
                        <div class="accordion-body">
                            <p class="mb-3"><strong>Question:</strong><br>{{ $question->question }}</p>
                            
                            @if ($isCorrect)
                                <div class="answer-block correct-answer-key">
                                    <strong>Your Answer (Correct):</strong>
                                    <p class="mb-0">{{ $studentAnswer }}</p>
                                </div>
                            @else
                                <div class="answer-block user-answer incorrect">
                                    <strong>Your Answer (Wrong):</strong>
                                    <p class="mb-0">{{ $studentAnswer ?? 'Tidak dijawab' }}</p>
                                </div>
                                <div class="answer-block correct-answer-key">
                                    <strong>Key Answer:</strong>
                                    <p class="mb-0">{{ $correctOption }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5 mb-4">
            <a href="{{ route('user.my-assignment') }}" class="btn btn-primary">Kembali ke Daftar Tugas</a>
        </div>
    </div>
</section>
@endsection