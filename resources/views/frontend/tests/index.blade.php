@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/subjects.png);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">Tests - {{ $subject->name }}</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.home.subjects') }}">Subjects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tests</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <h4 class="text-center mb-4">All Tests for {{ $subject->name }}</h4>

        @if($tests->count())
            @foreach($tests as $test)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5>{{ $test->name }}</h5>
                        <p class="mb-1"><strong>Time:</strong> {{ $test->start_time }} - {{ $test->end_time }}</p>
                        <p class="mb-1"><strong>Tutor:</strong> {{ $test->user->name ?? '-' }}</p>
                        <a href="{{ route('user.test.show', [$grade->slug, $subject->slug, $test->slug]) }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-play me-1"></i> Start Test
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted text-center">No tests available for this subject.</p>
        @endif
    </div>
</section>
@endsection
