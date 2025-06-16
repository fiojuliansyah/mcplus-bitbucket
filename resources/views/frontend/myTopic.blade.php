@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/subjects.png);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">{{ $topic->name }}</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.home.subjects') }}">Subjects</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.my-class.subject', [$grade->slug, $subject->slug]) }}">{{ $subject->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $topic->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="card shadow-lg border-1 border-white rounded-lg mb-4">
            <div class="card-header bg-dark text-white">
                <h2 class="mb-0 text-uppercase fw-bold py-2" style="font-size: 1.75rem;">
                    {{ $topic->name }} - Live Class
                </h2>

            </div>
            <div class="card-body p-4">
                <p class="mb-3">Welcome to the live session for this topic. Click below to join the class or take the quiz when you're ready!</p>
                
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#" class="btn btn-primary btn-lg">
                        <i class="bi bi-camera-video-fill me-1"></i> Join Class
                    </a>
                    <a href="#" class="btn btn-warning btn-lg">
                        <i class="bi bi-question-circle-fill me-1"></i> Take Quiz
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-1 border-white">
            <div class="card-body">
                <h6 class="fw-bold mb-2">Topic Description</h6>
                <p>{{ $topic->description ?? 'No description available for this topic.' }}</p>
            </div>
        </div>
    </div>
</section>
@endsection
