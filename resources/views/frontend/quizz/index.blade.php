@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/subjects.png);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">{{ $topic->name }} - Quiz</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.home.subjects') }}">Subjects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $topic->name }} Quiz</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="card shadow-lg border-1 border-white rounded-lg mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0 fw-bold">Take the Quiz</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('user.quizzes.submit', ['grade'=>$grade->slug, 'subject'=>$subject->slug, 'topic'=>$topic->slug]) }}" method="POST">
                {{-- <form action="" method="POST"> --}}
                    @csrf

                    @forelse ($quizzes as $index => $quiz)
                        @php
                            $options = json_decode($quiz->multiple_choice, true);
                        @endphp

                        <div class="mb-4">
                            <h5 class="fw-bold">{{ $index + 1 }}. {{ $quiz->question }}</h5>
                            @foreach ($options as $optIndex => $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="answers[{{ $quiz->id }}]"
                                        id="quiz_{{ $quiz->id }}_option_{{ $optIndex }}"
                                        value="{{ $optIndex }}">
                                    <label class="form-check-label" for="quiz_{{ $quiz->id }}_option_{{ $optIndex }}">
                                        {{ $option['answer'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p>No quiz questions available for this topic.</p>
                    @endforelse

                    @if($quizzes->count())
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-send-check me-1"></i> Submit Answers
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
