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
        <h4 class="main-title text-capitalize mb-4 text-center">What You'll Learn in {{ $subject->name }}</h4>

        <div class="timeline">
            @forelse ($topics as $index => $topic)
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <button class="btn btn-dark w-100 text-start fw-bold shadow-sm topic-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#topic{{ $index }}">
                            {{ $topic->name }}
                            <span class="float-end"><i class="bi bi-chevron-down"></i></span>
                        </button>
                        <div id="topic{{ $index }}" class="collapse mt-2">
                            <div class="card card-body">
                                <p>This section will cover: <strong>{{ $topic->name }}</strong>. You can customize this description.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No topics available for this subject.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Optional: Add Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Timeline Styles -->
<style>
    .timeline {
        position: relative;
        margin-left: 30px;
        padding-left: 22px;
        border-left: 3px solid #8E0692; /* Orange line */
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-icon {
        position: absolute;
        left: -32px;
        /* top: 5px; */
        width: 16px;
        height: 16px;
        background-color: #8E0692;
        border: 1px solid #ffe1d6;
        border-radius: 50%;
        z-index: 1;
    }

    .topic-toggle {
        /* background-color: #f0f0f0; */
        border-radius: 12px;
        transition: all 0.3s ease;
        border: none;
        padding: 12px 16px;
    }

    .topic-toggle[aria-expanded="true"] {
        background-color: #8E0692; /* Your primary color when active */
        color: white;
    }

    .topic-toggle:hover {
        background-color: #262626;
    }

    .timeline .card-body {
        background-color: #777777;
        border-radius: 10px;
        border: 1px solid #939393;
    }
</style>

@endsection
