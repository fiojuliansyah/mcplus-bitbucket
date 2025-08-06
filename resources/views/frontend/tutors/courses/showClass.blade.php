@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/my-account.png);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">My Courses</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li> 
                        <li class="breadcrumb-item active">My Courses</li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
</div>

<div class="section-padding service-details">
    <div class="container">
        <div class="card shadow-lg border-1 border-white rounded-lg mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0 text-uppercase fw-bold py-2" style="font-size: 1.75rem;">
                    {{ $topic->name }} - Live Class
                </h2>
                
                <a href="{{ route('tutor.topic.quizzes', ['topicId' => $topic->id]) }}"
                class="btn btn-outline-light btn-sm">
                    <i class="bi bi-gear-fill me-1"></i> Manage Quiz
                </a>
            </div>
            <div class="card-body p-4">
                <p class="mb-3">Welcome to the live session for this topic. Click below to join the class or take the quiz when you're ready!</p>
                
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#" class="btn btn-primary btn-lg">
                        <i class="bi bi-camera-video-fill me-1"></i> Join Class
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
</div>
@endsection
