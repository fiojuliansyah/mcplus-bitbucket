@extends('frontend.layouts.app')

@section('content')
    <div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/tutors.png);">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <nav aria-label="breadcrumb" class="text-center">
                        <h2 class="title">Tutors</h2>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item">Tutors</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div> <!--bread-crumb-->

    <section class="section-padding">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-6">
                @foreach ($tutors as $tutor)   
                    <div class="col">
                        <div class="iq-cast">
                            @if($tutor->current_profile->avatar)
                                <img src="/frontend/assets/images/cast/01.webp" class="img-fluid" alt="castImg" />
                            @else
                                <div class="bg-warning text-white d-flex align-items-center justify-content-center" style="width: 240px; height: 240px; border-radius: 5px">
                                    <span style="font-size: 70px">
                                        @foreach(explode(' ', $tutor->current_profile->name) as $word)
                                            {{ strtoupper($word[0]) }}
                                        @endforeach
                                    </span>
                                </div>
                            @endif
                            <div class="card-img-overlay iq-cast-body">
                                <h6 class="cast-title fw-500">
                                    <a href="./person-detail.html">
                                        {{ $tutor->current_profile->name }}
                                    </a>
                                </h6>
                                <span class="cast-subtitle">
                                    @foreach ($tutor->subjects->unique('name')->take(2) as $subject)
                                        {{ $subject->name }}
                                        <br>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
