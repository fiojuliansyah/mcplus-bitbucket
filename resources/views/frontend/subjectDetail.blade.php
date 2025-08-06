@extends('frontend.layouts.app2')

@section('content')

    {{-- Breadcrumb Dinamis --}}
    <div class="breadcrumb-bar text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">{{ $subject->name }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('home.subjects') }}">Courses</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $subject->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="course-resume">
        <div class="container">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="course-resume-details-1 d-lg-flex align-items-center mb-3">
                        <div class="position-relative cou-resume-image">
                            <img class="img-fluid" src="{{ $subject->thumbnail ? asset('storage/' . $subject->thumbnail) : 'https://via.placeholder.com/300' }}" alt="{{ $subject->name }}">
                        </div>
                        <div class="cou-resume-content w-100 ps-lg-4">
                            <h3 class="mb-2">{{ $subject->name }}</h3>
                            <p class="mb-3 fs-14">{{ $subject->description }}</p>
                            <div class="d-flex align-items-center cou-lesson">
                                @php
                                    $totalLessons = $topics->sum(function($topic) {
                                        return $topic->notes->count() + $topic->quizzes->count();
                                    });
                                @endphp
                                <p class="d-flex align-items-center"><img class="img-fluid" src="/frontpage/assets/img/icons/book3.svg" alt="img">{{ $totalLessons }}+ Lessons</p>
                                @if($subject->category)
                                <span class="badge badge-sm fs-12 rounded-pill bg-warning">{{ $subject->category->name }}</span>
                                @endif
                            </div>
                            <a href="#" class="btn btn-secondary d-inline-flex align-items-center"><i class="isax isax-pause-circle5 me-1"></i> Subscribe This!</a>
                        </div>
                    </div>

                    <div class="course-resume-details-2">
                        <h5>Course Curriculum</h5>
                        <div class="accordion accordion-customicon1 accordions-items-seperate" id="courseCurriculumAccordion">
                            
                            @forelse ($topics as $topic)
                                @php
                                    $activities = collect()
                                        ->concat($topic->notes)
                                        ->concat($topic->quizzes)
                                        ->sortBy('created_at');
                                    
                                    $progressPercent = $progress[$topic->id]['percentage'] ?? 0;
                                    $progressText = ($progress[$topic->id]['completed'] ?? 0) . '/' . ($progress[$topic->id]['total'] ?? $activities->count());
                                @endphp

                                <div class="accordion-item" data-aos="fade-up">
                                    <h2 class="accordion-header" id="headingTopic{{ $topic->id }}">
                                        <a href="#" class="accordion-button @if(!$loop->first) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#collapseTopic{{ $topic->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapseTopic{{ $topic->id }}">
                                            <span>{{ $topic->name }} <small class="d-flex fs-14 text-gray-7 fw-normal mt-1">No of Lectures : {{ $activities->count() }}</small></span> <i class="isax isax-arrow-circle-up4"></i>
                                        </a>
                                    </h2>
                                    <div id="collapseTopic{{ $topic->id }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="headingTopic{{ $topic->id }}" data-bs-parent="#courseCurriculumAccordion">
                                        <div class="accordion-body pb-0">
                                            <p class="mb-2 fs-16">{{ $progressText }} Completed <span class="float-end text-gray-9 fw-medium">{{ round($progressPercent) }}%</span></p>
                                            <div class="progress mb-3 progress-xs progress-animate border-radius-0" role="progressbar" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-secondary" style="width: {{ $progressPercent }}%">
                                                </div>
                                            </div>
                                            <ul>
                                                @foreach ($activities as $activity)
                                                    <li>
                                                        @if ($activity instanceof \App\Models\Note)
                                                            <a href="#">
                                                                <h6 class="d-flex align-items-center">
                                                                    <i class="isax isax-note-2 fs-24 text-info me-2"></i> {{ $activity->name }}
                                                                </h6>
                                                            </a>
                                                        @elseif ($activity instanceof \App\Models\Quizz)
                                                            <a href="#">
                                                                <h6 class="d-flex align-items-center">
                                                                    <i class="isax isax-play-circle5 fs-24 text-success me-2"></i> {{ $activity->question }}
                                                                </h6>
                                                            </a>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center p-5">
                                    <p class="text-muted">No curriculum available for this course yet.</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection