@extends('frontend.layouts.app')

@section('content')

<!-- Inline CSS for dot style -->
<style>
  .dot {
    display: inline-block;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background-color: #8a8a8a; /* Bootstrap primary */
  }

  .dot-number {
    display: inline-block;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: #bebebe;
    color: #fff;
    text-align: center;
    line-height: 24px;
    font-weight: bold;
  }
</style>

<div class="course-detail-page section-padding-top">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="main-title">{{ $subject['name'] }}</h2>
      <p class="text-muted">Learn with expert guidance from {{ $tutor['name'] }}.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card border-0 shadow-lg">
          @if(isset($course['image']))
            <img src="{{ asset($course['image']) }}" class="card-img-top" alt="{{ $subject['name'] }}">
          @endif
          <div class="card-body">
            <h5 class="fw-bold">Tutor</h5>
            <p class="mb-1">Name: <strong>{{ $tutor['name'] }}</strong></p>
            <p class="mb-3">Email: <strong>{{ $tutor['email'] }}</strong></p>

            <h5 class="fw-bold">Form</h5>
            <p>{{ $course['form'] }}</p>

            <h5 class="fw-bold mb-4">Topics to Learn</h5>
            <div class="d-flex flex-column align-items-start gap-3">
              @foreach ($subject['topics'] as $topic)
                <div class="d-flex align-items-center">
                  <span class="dot me-3"></span>
                  <span class="fw-semibold text-light">{{ $topic }}</span>
                </div>
              @endforeach
            </div>

            <div class="text-center mt-4">
              <a href="/course-and-tutor" class="btn btn-outline-primary">← Back to My Courses</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
