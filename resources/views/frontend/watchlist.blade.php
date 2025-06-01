@extends('frontend.layouts.app')

@section('content')
<div class="watchlist-page section-padding-top">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="main-title text-capitalize">My Watchlist</h2>
      <p class="text-muted">Here are the subjects you've saved to learn later.</p>
    </div>

    <div class="row justify-content-center">
      @foreach($subjects as $item)
      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-lg h-100">
          <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" class="card-img-top" style="object-fit: cover; height: 200px;">
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <h6 class="text-primary mb-1">{{ $item['subject'] }}</h6>
              <h5 class="fw-bold">{{ $item['title'] }}</h5>
              <p class="text-muted">{{ \Illuminate\Support\Str::limit($item['description'], 100) }}</p>
            </div>
            <div class="mt-3 d-flex justify-content-between align-items-center">
              <a href="#" class="btn btn-primary btn-sm">
                View
              </a>
              <button class="btn btn-outline-danger btn-sm" onclick="alert('This will be removed from your watchlist.')">
                Remove
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
