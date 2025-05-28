@extends('frontend.layouts.app')

@section('content')
<div class="container section-padding-top">
  <div class="text-center mb-5">
    <h2 class="main-title text-capitalize">My Class</h2>
    <p class="text-muted">Here are the subjects you're currently learning.</p>
  </div>

  <div class="row">
    @foreach($enrolledSubjects as $class)
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm border border-transparent transition hover:border-primary">
        <img src="{{ asset($class['image']) }}" class="card-img-top object-cover" style="height: 200px;" alt="{{ $class['title'] }}">
        <div class="card-body">
          <h5 class="card-title">
            <a href="#" class="text-decoration-none text-light">
              {{ $class['title'] }}
            </a>
          </h5>
          <div class="d-flex align-items-center justify-content-between">
            <p class="text-muted mb-0">Form: {{ $class['form'] }}</p>
            <p class="text-muted mb-0">{{ $class['subject'] }}</p>
          </div>
          <div class="mt-2">
            <span class="badge bg-info">Progress: {{ $class['progress'] }}%</span>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
