@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.student-breadcrumb')

    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.student-header')
            <div class="row">

                @include('frontend.layouts.partials.student-navbar')

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>My Quiz Attempts</h5>
                    </div>
                    @foreach ($topicsWithQuizzes as $topic)   
                        <div class="d-flex align-items-center justify-content-between border p-3 mb-3 rounded-2">
                            <div>
                                <h6 class="mb-1"><a href="{{ route('user.quizzes.show', $topic->slug) }}" target="_blank" >{{ $topic->name }}</a>
                                </h6>
                                <p class="fs-14">Number of Questions : {{ $topic->quizzes->count() }}</p>
                            </div>
                            <div>
                                @if ($topic->has_attempt)
                                    <a href="{{ route('user.quiz.result', $topic->result->id) }}" class="btn btn-sm btn-secondary">Show Result</a>
                                @else
                                    <a href="{{ route('user.quizzes.show', $topic->slug) }}" class="btn btn-sm btn-primary">Start Quiz</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
