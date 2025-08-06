@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.student-breadcrumb')

    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.student-header')
            <div class="row">
                
                @include('frontend.layouts.partials.student-navbar')

                <div class="col-lg-9">
                    <div class="page-title d-flex flex-wrap gap-3 align-items-center justify-content-between">
                        <h5>Enrolled Subjects</h5>
                        <div class="tab-list">
                            {{-- Tab navigasi dengan jumlah dinamis --}}
                            <ul class="nav mb-0 gap-2" role="tablist">
                                <li class="nav-item mb-0" role="presentation">
                                    <a href="#" class="active" data-bs-toggle="tab" data-bs-target="#enroll-courses" role="tab">
                                        Enrolled ({{ $subscriptions->total() }})
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="enroll-courses" role="tabpanel">
                            <div class="row">
                                @forelse ($subscriptions as $subscription)
                                    <div class="col-xl-4 col-md-6">
                                        <div class="course-item-two course-item mx-0">
                                            <div class="course-img">
                                                <a href="#">
                                                    <img src="{{ asset('storage/' . $subscription->subject->thumbnail) }}" alt="{{ $subscription->subject->name }}" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="course-content">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div class="d-flex align-items-center">

                                                        @php
                                                            $user = $subscription->subject->users->first();
                                                        @endphp

                                                        @if ($user && $user->current_profile)
                                                            @if ($user->current_profile->avatar)   
                                                                <a href="#" class="avatar avatar-sm">
                                                                    <img src="{{ asset('storage/' . $user->current_profile->avatar) }}" alt="User" class="img-fluid rounded-circle">
                                                                </a>
                                                            @endif
                                                            <div class="ms-2">
                                                                <a href="#" class="link-default fs-14">{{ $user->current_profile->name }}</a>
                                                            </div>
                                                        @endif
                                                        
                                                    </div>
                                                    <span class="badge badge-light rounded-pill bg-light d-inline-flex align-items-center fs-13 fw-medium mb-0">
                                                        {{ $subscription->subject->grade->name ?? 'Category' }}
                                                    </span>
                                                </div>
                                                <h6 class="title mb-2"><a href="#">{{ $subscription->subject->name }}</a></h6>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5 class="text-secondary mb-0">Subscribed</h5>
                                                    <a href="{{ route('user.classes.index', [
                                                        'subjectSlug' => $subscription->subject->slug, 
                                                        'replayId' => $subscription->subject->topics->first()?->replayClasses->first()?->id
                                                    ]) }}" target="_blank" class="btn btn-dark btn-sm d-inline-flex align-items-center">
                                                        View Topics <i class="isax isax-arrow-right-3 ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center">
                                        <p>You have not enrolled in any subjects yet.</p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    {{ $subscriptions->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection