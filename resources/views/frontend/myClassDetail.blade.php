@extends('frontend.layouts.app')

@section('content')
<div class="container section-padding-top">

  <!-- Back Button -->
  <div class="mb-3">
    <a href="/my-class" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Back to My Class
    </a>
  </div>

  <!-- Subject Image and Info -->
  <div class="mb-4 text-center">
    <img src="{{ asset($class['image']) }}" alt="{{ $class['subject'] }}" class="img-fluid rounded shadow-sm mb-3" style="max-height: 300px; object-fit: cover;">
    <h2 class="main-title text-capitalize">{{ $class['subject'] }} - Detail</h2>
    <p class="text-muted">Form {{ $class['form'] }} | Progress: {{ $class['progress'] }}%</p>
  </div>

  <!-- Topics List -->
  <div class="row">
    @foreach($class['topics'] as $topic)
    <div class="col-md-6 mb-3">
      <div class="p-3 border rounded d-flex justify-content-between align-items-center 
        {{ $topic['done'] 
            ? 'bg-primary text-white border-primary' 
            : 'bg-white text-dark border-secondary' }} shadow-sm">
        <span>{{ $topic['title'] }}</span>
        <span>
          @if($topic['done'])
            <i class="bi bi-check-circle-fill"></i> Done
          @else
            <i class="bi bi-circle"></i> Not done
          @endif
        </span>
      </div>
    </div>
    @endforeach
  </div>

</div>
@endsection
