@extends('frontend.layouts.app')

@section('content')
<div class="subscription-page section-padding-top">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="main-title text-capitalize">Choose Your Subscription Plan</h2>
      <p class="text-muted">Unlock all features and enjoy unlimited access.</p>
    </div>

    <div class="row justify-content-center">
      @foreach ($plans as $plan)
      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-lg h-100 {{ $plan['recommended'] ? 'bg-primary text-white' : '' }}">
          <div class="card-body text-center d-flex flex-column justify-content-between">
            <div>
              <h4 class="fw-bold">{{ $plan['duration'] }}</h4>
              <h2 class="display-5 fw-bold">{{ $plan['price'] }}</h2>
              <p class="{{ $plan['recommended'] ? 'text-white-50' : 'text-muted' }}">
                Full access to all features for {{ strtolower($plan['duration']) }}.
              </p>
            </div>
            <div>
              <a href="#" class="btn btn-outline-light w-100 mt-3 {{ $plan['recommended'] ? '' : 'btn-primary' }}">
                Subscribe Now
              </a>
            </div>
          </div>
          @if($plan['recommended'])
            <div class="position-absolute top-0 end-0 bg-warning text-dark px-3 py-1 fw-bold rounded-bottom-start">
              Recommended
            </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
