@extends('frontend.layouts.app2')

@section('content')

<div class="breadcrumb-bar text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Subjects</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subjects</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="course-category">
    <div class="container">
        <h2 class="mb-1">Browse By Level</h2>
        <p>Select a grade level to see available subjects..</p>

        @if($grades->isNotEmpty())
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            @foreach ($grades as $grade)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="pills-{{ $grade->slug }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $grade->slug }}" type="button" role="tab" aria-controls="pills-{{ $grade->slug }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $grade->name }}</button>
                </li>
            @endforeach
        </ul>
        @endif

        @if(!$subjects->isEmpty())
        <div class="tab-content" id="pills-tabContent">
            @foreach ($subjects->groupBy('grade_id') as $gradeId => $subjectGroup)
                @php
                    $currentGrade = $subjectGroup->first()->grade;
                @endphp
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pills-{{ $currentGrade->slug }}" role="tabpanel" aria-labelledby="pills-{{ $currentGrade->slug }}-tab">
                    <div class="row">
                        @forelse ($subjectGroup as $subject)
                            <div class="col-lg-4 col-md-6">
                                <a href="{{ route('home.subjectDetail', ['slugGrade' => $subject->grade->slug, 'slugSubject' => $subject->slug]) }}" class="text-decoration-none">
                                    <div class="course-category-item">
                                        <div class="d-flex flex-row justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img class="img-fluid category-image" src="/frontend/assets/images/subjects/{{ $subject->thumbnail }}" alt="{{ $subject->name }}">
                                                <h6 class="pe-2 mb-0">{{ $subject->name }}</h6>
                                            </div>
                                            
                                            @if ($subject->topics->isNotEmpty())
                                                <span class="cat-count text-white fw-medium bg-dark d-inline-flex">{{ $subject->topics->count() }}</span>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center">There are no subjects for this level yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection