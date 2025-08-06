@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.tutor-breadcrumb')
    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.tutor-header')
            <div class="row">
                
                @include('frontend.layouts.partials.tutor-navbar')

                
            </div>
        </div>
    </div>
@endsection
