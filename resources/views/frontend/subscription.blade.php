@extends('frontend.layouts.app2')

@section('content')

    <div class="breadcrumb-bar text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Pricing Plan</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pricing Plan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="pricing-plan-sec">
        <div class="container">
           <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="text-center">
                        <p class="fw-medium text-secondary mb-2">Invest in Your Knowledge</p>
                        <h2 class="main-title mb-2">Unlock Your Future</h2>
                        <p>Explore our programs designed to help you master new skills, expand your horizons, and take the next step on your educational journey.</p>
                        <div class="text-end">
                            <img src="/frontpage/assets/img/icons/save-10.svg" alt="img">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pricing-cover">
                @foreach ($plans as $plan)
                    <div class="col-xl-3 col-md-6 px-2 d-flex">
                        <div class="pricing-item flex-fill">
                            <h5 class="mb-2">{{ $plan->name }}</h5>
                            <h1 class="mb-2"><sup class="fs-24 me-1">RM</sup>{{ $plan->price }}</h1>
                            <p>{{ $plan->description }}</p>
                            <div class="border-top pt-3 mt-3">
                                @if ($plan->device_limit)
                                <p class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-circle fs-5 me-2"></i>{{ $plan->device_limit }} Device Limit
                                </p>
                                @endif

                                @if ($plan->profile_limit)
                                <p class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-circle fs-5 me-2"></i>{{ $plan->profile_limit }} Profile Limit
                                </p>
                                @endif
                                
                                <a href="{{ route('subscription.checkout', $plan->id) }}" class="btn btn-start-free w-100">Choose Plan</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-xl-3 col-md-6 px-2 d-flex">
                    <div class="pricing-item flex-fill">
                        <h5 class="fw-bold mb-2 pb-2">Benefits</h5>
                        <p class="d-flex align-items-center mb-3"><i class="fa-solid fa-circle fs-5 me-2"></i>Access to slack community</p>
                        <p class="d-flex align-items-center mb-3"><i class="fa-solid fa-circle fs-5 me-2"></i>Access to support team</p>
                        <p class="d-flex align-items-center mb-3"><i class="fa-solid fa-circle fs-5 me-2"></i>Algorithmic bidding</p>
                        <p class="d-flex align-items-center mb-3"><i class="fa-solid fa-circle fs-5 me-2"></i>Keyword and ASIN harvesting</p>
                        <h5 class="fw-bold mb-2 pb-2 mt-4">Features</h5>
                        <p class="d-flex align-items-center mb-3"><i class="fa-solid fa-circle fs-5 me-2"></i>Search term isolation</p>
                        <p class="d-flex align-items-center mb-3"><i class="fa-solid fa-circle fs-5 me-2"></i>Total Sales Analytics</p> 
                        <a href="#" class="btn btn-start-free w-100">Start For Free</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection