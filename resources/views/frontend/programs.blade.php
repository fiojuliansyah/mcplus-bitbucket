@extends('frontend.layouts.app')

@section('content')
<div class="container section-padding-top">
  <div class="text-center mb-5">
    <h2 class="main-title text-capitalize">Our Programs</h2>
    <p class="text-muted">Explore our latest and most popular educational programs.</p>
  </div>

  {{-- New School Programs --}}
  <div class="mb-5">
    <h4 class="mb-3">New Programs</h4>
    <div class="row">
      @foreach($newPrograms as $program)
      <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm program-card transition">
          <img src="{{ asset($program['image']) }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $program['title'] }}">
          <div class="card-body">
            <h5 class="card-title">
              <a href="#" class="text-decoration-none text-light">{{ $program['title'] }}</a>
            </h5>
            <p class="card-text">{{ $program['description'] }}</p>
            <small class="text-muted">Starts on {{ \Carbon\Carbon::parse($program['date'])->format('F j, Y') }}</small>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- Popular School Programs --}}
  <div class="mb-5">
    <h4 class="mb-3">Popular Programs</h4>
    <div class="row">
      @foreach($popularPrograms as $program)
      <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm program-card transition">
          <img src="{{ asset($program['image']) }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $program['title'] }}">
          <div class="card-body">
            <h5 class="card-title">
              <a href="#" class="text-decoration-none text-light">{{ $program['title'] }}</a>
            </h5>
            <p class="card-text">{{ $program['description'] }}</p>
            <small class="text-muted">Started on {{ \Carbon\Carbon::parse($program['date'])->format('F j, Y') }}</small>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
