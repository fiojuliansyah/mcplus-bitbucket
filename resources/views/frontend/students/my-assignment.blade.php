@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.student-breadcrumb')

    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.student-header')
            <div class="row">

                @include('frontend.layouts.partials.student-navbar')

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>My Assignment Attempts</h5> 
                    </div>
                    @foreach ($subjectsWithTests as $test) 
                        <div class="d-flex align-items-center justify-content-between border p-3 mb-3 rounded-2">
                            <div>
                                <h6 class="mb-1"><a href="#" target="_blank">{{ $test->name }} - {{ $test->subject->name }}</a> 
                                </h6>
                                <p class="fs-14">
                                    Test Deadline: {{ \Carbon\Carbon::parse($test->start_time)->format('d M Y H:i') }} - 
                                    {{ \Carbon\Carbon::parse($test->end_time)->format('d M Y H:i') }}
                                </p>
                            </div>
                            <div>
                                @if ($test->has_attempt)
                                    <a href="{{ route('user.test.result', $test->result->id) }}" class="btn btn-sm btn-secondary">Show Result</a>
                                @else
                                    <a href="#" class="btn btn-sm btn-primary">Start Test</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
