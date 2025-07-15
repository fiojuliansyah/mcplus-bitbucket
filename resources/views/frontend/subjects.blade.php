@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/subjects.png);">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <nav aria-label="breadcrumb" class="text-center">
                        <h2 class="title">Subjects</h2>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item">Subjects</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div> 
     <section class="section-padding">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-6">
                @foreach ($grades as $grade)
                    <div class="col">
                        <a href="#section-{{ $grade->id }}" class="iq-tag-box">
                            <span class="iq-tag">
                                {{ $grade->name }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @foreach ($subjects->groupBy('grade_id') as $gradeId => $subjectGroup)
        <section id="section-{{ $subjectGroup->first()->grade->id }}" class="section-padding">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="main-title text-capitalize mb-0">{{ $subjectGroup->first()->grade->name }}</h4>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                    @foreach ($subjectGroup as $subject)
                    <div class="col mb-4">
                        <div class="iq-card-geners card-hover-style-two">
                            <div class="block-images position-relative w-100">
                                <div class="img-box rounded position-relative">
                                    {{-- <img src="{{ asset('storage/' . $subject->thumbnail) }}" alt="geners-img" class="img-fluid object-cover w-100 rounded"> --}}
                                    <img src="/frontend/assets/images/subjects/{{ $subject->thumbnail }}" alt="geners-img" class="img-fluid object-cover w-100 rounded">
                                    <div class="blog-description">
                                        <h6 class="mb-0 iq-title">
                                            <a href="{{ route('user.home.subjectDetail', ['slugGrade' => $subject->grade->slug, 'slugSubject' => $subject->slug]) }}" class="text-decoration-none text-capitalize line-count-2 p-2">
                                                {{ $subject->name }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endsection