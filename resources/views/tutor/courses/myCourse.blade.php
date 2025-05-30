@extends('frontend.layouts.app')

@section('content')
<div class="container section-padding-top">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="main-title">My Courses</h2>
    <a href="{{ route('tutor.upload-course') }}" class="btn btn-success">Upload New Course</a>
  </div>

  @if(count($myCourses))
    <div class="row">
      @foreach($myCourses as $course)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset($course['image']) }}" class="card-img-top object-cover" style="height: 200px;" alt="{{ $course['title'] }}">
          <div class="card-body">
            <h5 class="card-title">{{ $course['title'] }}</h5>
            <p class="text-muted mb-0">Subject: {{ $course['subject'] }}</p>
            <p class="text-muted mb-0">Form: {{ $course['form'] }}</p>
            <p class="text-muted">Tutor: {{ $course['tutor'] }}</p>
            <a href="{{ $course['video_url'] }}" class="btn btn-sm btn-primary" target="_blank">Watch Video</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @else
    <p>No courses found.</p>
  @endif
</div>
@endsection
