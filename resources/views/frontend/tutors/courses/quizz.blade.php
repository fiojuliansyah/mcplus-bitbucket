@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.tutor-breadcrumb')
    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.tutor-header')

            <div class="row">
                @include('frontend.layouts.partials.tutor-navbar')

                <div class="col-lg-9">
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row align-items-center gy-3">
                                <div class="col-xl-8">
                                    <div>
                                        <div class="d-sm-flex align-items-center">
                                            <div>
                                                <h5 class="mb-2"><a href="#">{{ $topic->name }}</a></h5>
                                                <div class="question-info d-flex align-items-center">
                                                    <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i class="isax isax-message-question5 text-primary-soft me-2"></i>{{ $topic->quizzes->count() }} Questions</p>
                                                    <small>{{ $topic->subject->name }} - {{ $topic->subject->grade->name }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="d-flex align-items-center justify-content-sm-end">
                                        <a href="#" class="text-info text-decoration-underline fs-12 fw-medium me-3">View Results</a>
                                        <a href="#" class="btn btn-secondary"  data-bs-toggle="modal" data-bs-target="#createQuizModal">Add Question</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($quizzes->isEmpty())
                        <div class="alert alert-info">No quizzes created yet.</div>
                    @else
                    @foreach($quizzes as $index => $quiz)
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6>{{ $index + 1 }}. {{ $quiz->question }}</h6>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <a href="#" class="d-inline-flex fs-14 me-2 action-icon" data-bs-toggle="modal" data-bs-target="#editQuizModal-{{ $quiz->id }}"><i class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal" data-bs-target="#deleteQuizModal-{{ $quiz->id }}"><i class="isax isax-trash"></i></a>
                                    </div>
                                </div>
                                <div>
                                    @php
                                        $choices = json_decode($quiz->multiple_choice, true);
                                        $letters = range('A', 'Z');
                                    @endphp

                                    @foreach ($choices as $i => $choice)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="qusetion-1" id="Radio-sm-1" @if($choice['is_correct']) checked @endif disabled>
                                            <label class="form-check-label" for="Radio-sm-1">
                                                {{ $letters[$i] }}.</strong> {{ $choice['answer'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @include('frontend.tutors.courses.modals.edit-quiz', ['quiz' => $quiz])
                        @include('frontend.tutors.courses.modals.delete-quiz', ['quiz' => $quiz])
                    @endforeach
                    @endif
                </div> 
            </div>
        </div>
    </div>
    @include('frontend.tutors.courses.modals.add-quiz', ['topic' => $topic])
    <script src="{{ asset('frontend/assets/js/quizz.js') }}"></script>
    <script>
        $(document).on('draw.dt', function () {
            if (typeof bindUpdateQuizz === 'function') {
                bindUpdateQuizz();
            }
        });
    </script>
@endsection
