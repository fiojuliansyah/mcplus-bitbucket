@extends('frontend.layouts.app')

@section('content')
<div class="my-courses-page section-padding-top">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="main-title text-capitalize">Course and Tutor</h2>
      <p class="text-muted">Courses assigned along with subjects and tutors.</p>
    </div>

    @if(count($courses))
    <div class="row justify-content-center">
      @foreach ($courses as $course)
        @php
          $subject = collect($subjects)->firstWhere('id', $course['subject_id']);
          $tutor = collect($tutors)->firstWhere('id', $course['tutor_id']);
        @endphp

        <div class="col-md-4 mb-4">
            <div class="card border shadow-sm rounded-2">

                @if(isset($course['image']))
                <img src="{{ asset($course['image']) }}" class="card-img-top" alt="{{ $course['title'] }}">
                @endif

                <div class="card-body text-center d-flex flex-column justify-content-between">
                <div>
                    <h4 class="fw-bold">{{ $subject['name'] }}</h4>
                    <p class="text-muted mb-1">Tutor: <strong>{{ $tutor['name'] }}</strong></p>
                    <p class="text-muted">Email: <strong>{{ $tutor['email'] }}</strong></p>
                    <p class="text-muted mb-1">Form: <strong>{{ $course['form'] }}</strong></p>
                </div>
                <div>
                    <a href="./course-and-tutor/{{ $course['id'] }}" class="btn btn-primary w-100 mt-3">View Course</a>
                </div>
                </div>
            </div>
        </div>
      @endforeach
    </div>
    @else
    <div class="text-center">
      <p class="text-muted">You are not enrolled in any courses.</p>
      <a href="#" class="btn btn-outline-primary mt-3">Browse Courses</a>
    </div>
    @endif
  </div>
</div>
@endsection
