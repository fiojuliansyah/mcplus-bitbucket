@extends('frontend.layouts.app')

@section('content')
  <div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/pricing-plan.png);">
      <div class="container-fluid">
        <div class="row align-items-center">
              <div class="col-sm-12">
                  <nav aria-label="breadcrumb" class="text-center">
                      <h2 class="title">Pricing Plan</h2>
                      <ol class="breadcrumb justify-content-center">
                          <li class="breadcrumb-item"><a href="/">Home</a></li> 
                          <li class="breadcrumb-item">Pricing Plan</li>
                      </ol>
                  </nav>
              </div>
          </div> 
      </div>
  </div>

  <div class="section-padding">
      <div class="container">
          <div class="row">
            @foreach ($plans as $plan)   
              <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                  <div class="pricing-plan-wrapper">
                      {{-- <div class="pricing-plan-discount bg-primary p-2 text-center">
                          <span class="text-white">Best deal</span>
                      </div> --}}
                      <div class="pricing-plan-header">
                          <h4 class="plan-name text-capitalize text-body">{{ $plan->name }}</h4>
                          <span class="main-price text-primary">{{ $plan->price }}RM</span>
                          <span class="font-size-18">/ {{ $plan->duration_value }} Month</span>
                          <h6 class="text-capitalize text-body pt-3">{{ $plan->description }}</h6>
                      </div>
                      <div class="pricing-details">
                          <div class="pricing-plan-description">
                              <ul class="list-inline p-0">
                                @if ($plan->device_limit != null)
                                  <li>
                                      <i class="fas fa-check text-primary"></i>
                                      <span class="font-size-18 fw-500">{{ $plan->device_limit }} Device Limit</span>
                                  </li>
                                @else
                                  
                                @endif
                                @if ($plan->profile_limit != null)
                                  <li>
                                      <i class="fas fa-check text-primary"></i>
                                      <span class="font-size-18 fw-500">{{ $plan->profile_limit }} Profile Limit</span>
                                  </li>
                                @else

                                @endif
                              </ul>
                          </div>
                          <div class="pricing-plan-footer">
                              <div class="iq-button">
                                  <a href="javascript:void(0)" class="btn text-uppercase position-relative">
                                      <span class="button-text">select {{ $plan->name }}</span>
                                      <i class="fa-solid fa-play"></i>
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            @endforeach
          </div>
      </div>
  </div>
@endsection
