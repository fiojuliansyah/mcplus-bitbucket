@extends('frontend.layouts.app')

@section('content')
<div class="container section-padding-top">
  <div class="text-center mb-5">
    <h2 class="main-title text-capitalize">Our Free Courses</h2>
    <p class="text-muted">Browse through our free courses, grouped by school level.</p>
  </div>

  {{-- Free Courses --}}
  <div class="mb-5">
    <h4 class="mb-3">Form 1</h4>
    <div class="row">
      @foreach($freeCourses as $course)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset($course['image']) }}" class="card-img-top object-cover" style="height: 200px;" alt="{{ $course['title'] }}">
          <div class="card-body">
            <h5 class="card-title">{{ $course['title'] }}</h5>
            <div class="d-flex align-items-center justify-content-between mb-1">
              <p class="text-muted mb-0">Form: {{ $course['form'] }}</p>
              <p class="text-muted mb-0">{{ $course['subject'] }}</p>
            </div>
            <p class="text-muted mb-1">Tutor: {{ $course['tutor'] }}</p>
            <span class="badge bg-success mt-2">Free</span>

            <div class="mt-3 d-flex justify-content-center">
              <a href="/free-course/{{ $course['id'] }}" class="btn btn-sm btn-primary">
                View
              </a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

</div>
@endsection
