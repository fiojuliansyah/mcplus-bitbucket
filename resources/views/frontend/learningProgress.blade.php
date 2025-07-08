@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/my-account.png);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">My Learning Progress</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="../index.html">Home</a></li> 
                        <li class="breadcrumb-item active">Learning Progress</li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
</div> <!--bread-crumb-->

<div class="section-padding service-details">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="acc-left-menu p-4 mb-5 mb-lg-0 mb-md-0">
                    <div class="product-menu">
                        <ul class="list-inline m-0 nav nav-tabs flex-column bg-transparent border-0" role="tablist">
                            <li class="pb-0 nav-item">
                                <button class="nav-link p-0 bg-transparent">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                                    </svg>
                                    <span class="ms-2">Learning Progress</span>
                                </button>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Learning Progress Report -->
            <div class="col-lg-9 col-md-8">
                <div class="card p-4">
                    <h4 class="mb-4">Learning Progress</h4>

                    @foreach($progress as $subject)
                        @php
                            $scores = array_column($subject['topics'], 'score');
                            $average = count($scores) > 0 ? round(array_sum($scores) / count($scores), 2) : 0;
                        @endphp

                        <div class="mb-5">
                            <h5 class="fw-bold">{{ $subject['subject'] }}</h5>
                            <ul class="list-group mb-2">
                                @foreach($subject['topics'] as $topic)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $topic['name'] }}
                                        <span class="fw-bold">{{ $topic['score'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="text-muted fst-italic">
                                Average score: <strong>{{ $average }}</strong> from {{ count($scores) }} topic{{ count($scores) > 1 ? 's' : '' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
