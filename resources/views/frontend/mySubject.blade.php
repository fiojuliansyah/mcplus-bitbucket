@extends('frontend.layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/subjects.png);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">{{ $subject->name }}</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.home.subjects') }}">Subjects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $subject->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Timeline Topics Section -->
<section class="section-padding">
    <div class="container">
        <h4 class="main-title text-capitalize mb-4 text-center">Attendance in Subject {{ $subject->name }}</h4>

        <div class="timeline">
            @forelse ($topics as $index => $topic)
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <a href="{{ route('user.my-class.subject.topic', [$grade->slug, $subject->slug, $topic->slug]) }}" class="btn btn-dark w-100 text-start fw-bold shadow-sm text-white">
                        {{ $topic->name }}
                        @if ($topic->attended)
                            <span class="badge bg-success float-end ms-2">Attended</span>
                        @else
                            <span class="badge bg-secondary float-end ms-2">Not Attended</span>
                        @endif
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-muted">No topics available for this subject.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
