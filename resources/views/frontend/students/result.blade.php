@extends('frontend.layouts.app2')

@section('content')
<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                <div class="text-center mb-5">
                    <h1 class="fs-32 fw-bold topic">Quiz Result</h1>
                    <p class="fs-18 text-muted">Topic: {{ $result->topic->name }}</p>
                </div>

                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body p-4">
                        <div class="row align-items-center text-center">
                            <div class="col-md-4">
                                <div class="result-stat">
                                    <h5 class="text-muted mb-2">Final Score</h5>
                                    <h2 class="fw-bold display-4 text-primary">{{ number_format($result->score) }}</h2>
                                </div>
                            </div>
                            <div class="col-md-4 border-start border-end">
                                <div class="result-stat">
                                    <h5 class="text-muted mb-2">Correct Answers</h5>
                                    <h2 class="fw-bold display-4 text-success">{{ $result->correct_answers }}</h2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="result-stat">
                                    <h5 class="text-muted mb-2">Total Questions</h5>
                                    <h2 class="fw-bold display-4 text-info">{{ $result->total_questions }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="fw-bold mb-4">Review Your Answers</h3>

                <div class="answer-review-list">
                    @foreach ($answers as $index => $answer)
                        @php
                            $options = json_decode($answer->quizz->multiple_choice, true);
                            $correctIndex = -1;
                            $correctAnswerText = 'N/A';
                            foreach ($options as $optIndex => $opt) {
                                if (isset($opt['is_correct']) && $opt['is_correct']) {
                                    $correctIndex = $optIndex;
                                    $correctAnswerText = $opt['answer'];
                                    break;
                                }
                            }
                        @endphp
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body p-4">
                                <p class="fw-bold fs-16 mb-3">
                                    {{ $index + 1 }}. {{ $answer->quizz->question }}
                                </p>
                                
                                <div class="user-answer mb-2">
                                    @if ($answer->is_correct)
                                        <span class="text-success me-2"><i class="isax isax-tick-circle"></i></span>
                                        <strong>Your Answer:</strong> {{ $answer->answer ?? 'No Answer' }}
                                    @else
                                        <span class="text-danger me-2"><i class="isax isax-close-circle"></i></span>
                                        <strong class="text-danger">Your Answer:</strong> 
                                        <span class="text-danger text-decoration-line-through">{{ $answer->answer ?? 'No Answer' }}</span>
                                    @endif
                                </div>
                                
                                @if (!$answer->is_correct)
                                <div class="correct-answer">
                                    <span class="text-success me-2"><i class="isax isax-tick-circle"></i></span>
                                    <strong>Correct Answer:</strong> {{ $correctAnswerText }}
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- /Daftar Jawaban --}}

                <div class="text-center mt-5">
                    <a href="{{ route('user.my-quiz') }}" class="btn btn-primary">Back to My Quiz <i class="isax isax-arrow-right-3 ms-1"></i></a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection