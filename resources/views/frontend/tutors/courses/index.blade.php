@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.tutor-breadcrumb')
    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.tutor-header')

            <div class="row">
                @include('frontend.layouts.partials.tutor-navbar')
                
                <div class="col-lg-9">

                    <div class="page-title">
                        <h5>My Subjects</h5>
                    </div>
                    <div class="tab-list course-tab">
                        <ul class="nav mb-2" role="tablist">
                            @foreach($grades as $index => $grade)
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0);" class="{{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#grade-{{ $grade->id }}"  aria-selected="true" role="tab">{{ $grade->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-content">
                        @foreach($grades as $index => $grade)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="grade-{{ $grade->id }}" role="tabpanel">
                                
                                @forelse($grade->subjects as $subject)
                                    <div class="card p-3 p-md-4 mb-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row align-items-center gy-3">
                                                    <div class="col-xl-8">
                                                        <div>
                                                            <div class="d-sm-flex align-items-center">
                                                                <div class="quiz-img me-3 mb-2 mb-sm-0">
                                                                    <img src="{{ asset('storage/' . $subject->thumbnail) }}" alt="">
                                                                </div>
                                                                <div>
                                                                    <h5 class="mb-2"><a href="#">{{ $subject->name }}</a></h5>
                                                                    <div class="question-info d-flex align-items-center">
                                                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i class="isax isax-message-question5 text-primary-soft me-2"></i>{{ $subject->topics->count() }} Topics</p>
                                                                        <p class="d-flex align-items-center fs-14 mb-0"><i class="isax isax-clock5 text-secondary-soft me-2"></i>{{ $subject->topics->pluck('replayClasses')->flatten()->count() }} Replay Class</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="d-flex align-items-center justify-content-sm-end">
                                                            <a href="{{ route('tutor.tests', ['formSlug'=>$grade->slug, 'subjectSlug'=>$subject->slug]) }}" class="text-info text-decoration-underline fs-12 fw-medium me-3">Manage Assignments</a>
                                                            <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addTopicModal-{{ $subject->id }}">Add Topic</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('frontend.tutors.courses.modals.add-topic', ['subject' => $subject])

                                        @if($topics->has($subject->id) && $topics->get($subject->id)->isNotEmpty())
                                            @foreach($topics->get($subject->id) as $topic)
                                            <div class="border rounded-2 p-3 mb-3">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <div>
                                                            <h6 class="mb-2"><a href="instructor-quiz-questions.html">{{ $topic->name }}</a></h6>
                                                            <div class="question-info d-flex align-items-center">
                                                                <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i class="isax isax-volume-high5 text-primary-soft me-2"></i>{{ $topic->replayClasses->count() }}+ Replay Class</p>
                                                                <a href="#" class="text-info text-decoration-underline fs-12 fw-medium me-3">View Replay Class</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center justify-content-end mt-2 mt-md-0">
                                                            <a href="{{ route('tutor.topic.notes', ['slug' => $topic->slug]) }}" class="text-info text-decoration-underline fs-12 fw-medium me-3">Manage NOTES</a>
                                                            <a href="{{ route('tutor.topic.quizzes', ['slug' => $topic->slug]) }}" class="text-info text-decoration-underline fs-12 fw-medium me-3">Manage Quiz</a>
                                                            <a href="#" class="d-inline-flex fs-14 me-1 action-icon" data-bs-toggle="modal" data-bs-target="#editTopicModal-{{ $topic->id }}"><i class="isax isax-edit-2"></i></a>
                                                            <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal" data-bs-target="#deleteTopicModal-{{ $topic->id }}"><i class="isax isax-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @include('frontend.tutors.courses.modals.edit-topic', ['topic' => $topic])
                                                @include('frontend.tutors.courses.modals.delete-topic', ['topic' => $topic])
                                            </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted fst-italic">No topics available for this subject.</p>
                                        @endif
                                    </div>
                                @empty
                                    <div class="card p-4">
                                        <p class="text-muted text-center mb-0">No subjects found for this grade.</p>
                                    </div>
                                @endforelse
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection