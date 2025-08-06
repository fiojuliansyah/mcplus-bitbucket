@extends('layouts.auth')

@section('content')
<div class="main-wrapper">
    <div class="login-content">
        <div class="row">

            <!-- Login Banner -->
            <div class="col-md-6 login-bg d-none d-lg-flex">
                <div class="login-carousel">
                    <div>
                        <div class="login-carousel-section mb-3">
                            <div class="login-banner">
                                <img src="/frontpage/assets/img/auth/auth-1.svg" class="img-fluid" alt="Logo">
                            </div>
                            <div class="mentor-course text-center">
                                <h3 class="mb-2">Welcome to <br>MCPlus<span class="text-secondary"> Premium</span> Courses.</h3>
                                <p>Platform designed to help organizations, educators, and learners manage, deliver, and track learning and training activities.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Login Banner -->

            <div class="col-md-6 login-wrap-bg">
                <!-- Login -->
                <div class="login-wrapper">
                    <div class="loginbox">
                        <div class="w-100">
                            <div class="d-flex align-items-center justify-content-between login-header">
                                <img src="/frontpage/assets/img/logo.svg" class="img-fluid" alt="Logo">
                                <a href="/" class="link-1">Back to Home</a>
                            </div>
                            <div class="topic">
                                <h1 class="fs-32 fw-bold mb-3">Set a New Password</h1>
                                <p class="fs-14 fw-normal mb-0">Create a new, strong password that you don’t use on other websites.</p>
                            </div>

                            <!-- Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="mb-3 pb-3" method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                
                                <!-- Email Address -->
                                <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                                <!-- Password Field -->
                                <div class="mb-3 position-relative">
                                    <label class="form-label">Password<span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                                        <span><i class="isax isax-key input-icon text-gray-7 fs-14"></i></span>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="mb-3 position-relative">
                                    <label class="form-label">Confirm Password<span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
                                        <span><i class="isax isax-key input-icon text-gray-7 fs-14"></i></span>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">Reset Password<i class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                            </form>

                            <p class="fs-14 fw-normal d-flex align-items-center justify-content-center">
                                Remember Password?<a href="{{ route('login') }}" class="link-2 ms-1"> Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>
</div>
@endsection
