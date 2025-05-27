@extends('frontend.layouts.app')

@section('content')
<div class="container section-padding-top">
  <div class="text-center mb-5">
    <h2 class="main-title text-capitalize">Our Courses</h2>
    <p class="text-muted">Browse through our free and premium courses, grouped by school level.</p>
  </div>

  {{-- Free Courses --}}
  <div class="mb-5">
    <h4 class="mb-3">Free Courses</h4>
    <div class="row">
      @foreach($freeCourses as $course)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset($course['image']) }}" class="card-img-top object-cover" style="height: 200px;" alt="{{ $course['title'] }}">
          <div class="card-body">
            <h5 class="card-title">{{ $course['title'] }}</h5>
            <p class="text-muted mb-0">Form: {{ $course['form'] }}</p>
            <span class="badge bg-success mt-2">Free</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- Paid Courses --}}
  <div class="mb-5">
    <h4 class="mb-3">Paid Courses</h4>
    <div class="row">
      @foreach($paidCourses as $course)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset($course['image']) }}" class="card-img-top object-cover" style="height: 200px;" alt="{{ $course['title'] }}">
          <div class="card-body">
            <h5 class="card-title">{{ $course['title'] }}</h5>
            <p class="text-muted mb-0">Form: {{ $course['form'] }}</p>
            <span class="badge bg-primary mt-2">Paid</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
