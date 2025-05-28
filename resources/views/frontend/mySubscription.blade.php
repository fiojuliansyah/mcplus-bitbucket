@extends('frontend.layouts.app')

@section('content')
<div class="my-subscription-page section-padding-top">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="main-title text-capitalize">My Subscription</h2>
    </div>

    @if($subscription)
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card border-0 shadow-lg">
          <div class="card-body text-center">
            <h4 class="fw-bold text-success">You are subscribed!</h4>
            <p class="text-muted mb-1">Plan: <strong>{{ $subscription['plan_name'] }}</strong></p>
            <p class="text-muted mb-1">Price: <strong>{{ $subscription['price'] }}</strong></p>
            <p class="text-muted mb-1">Duration: <strong>{{ $subscription['duration'] }}</strong></p>
            <p class="text-muted">Expires on: <strong>{{ \Carbon\Carbon::parse($subscription['expires_at'])->format('F j, Y') }}</strong></p>

            <a href="#" class="btn btn-danger mt-3">Cancel Subscription</a>
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="text-center">
      <p class="text-muted">You do not have an active subscription.</p>
      <a href="/subscription" class="btn btn-primary mt-3">View Subscription Plans</a>
    </div>
    @endif
  </div>
</div>
@endsection
