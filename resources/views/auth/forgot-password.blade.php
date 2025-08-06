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
                                    <h3 class="mb-2">Welcome to <br>MCPlus<span class="text-secondary"> Premium</span> Courses.
                                    </h3>
                                    <p>Platform designed to help organizations, educators, and learners manage, deliver, and
                                        track learning and training activities.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="login-carousel-section mb-3">
                                <div class="login-banner">
                                    <img src="/frontpage/assets/img/auth/auth-1.svg" class="img-fluid" alt="Logo">
                                </div>
                                <div class="mentor-course text-center">
                                    <h3 class="mb-2">Welcome to <br>MCPlus<span class="text-secondary"> Premium</span> Courses.
                                    </h3>
                                    <p>Platform designed to help organizations, educators, and learners manage, deliver, and
                                        track learning and training activities.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="login-carousel-section mb-3">
                                <div class="login-banner">
                                    <img src="/frontpage/assets/img/auth/auth-1.svg" class="img-fluid" alt="Logo">
                                </div>
                                <div class="mentor-course text-center">
                                    <h3 class="mb-2">Welcome to <br>MCPlus<span class="text-secondary"> Premium</span> Courses.
                                    </h3>
                                    <p>Platform designed to help organizations, educators, and learners manage, deliver, and
                                        track learning and training activities.</p>
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
                                    <h1 class="fs-32 fw-bold mb-3">Forgot Password</h1>
                                    <p class="fs-14 fw-normal mb-0">Enter your email to reset your password.</p>
                                    @if (session('status'))
                                        <p style="color: green">
                                            {{ session('status') }}
                                        </p>
                                    @endif
                                </div>
                                <form class="mb-3 pb-3" id="email-login-form" action="{{ route('password.email') }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                                        <div class="position-relative">
                                            <input type="email" name="email" class="form-control form-control-lg">
                                            <span><i class="isax isax-sms input-icon text-gray-7 fs-14"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-secondary btn-lg" type="submit">Submit<i
                                                class="isax isax-arrow-right-3 ms-1"></i></button>
                                    </div>
                                </form>

                                <p class="fs-14 fw-normal d-flex align-items-center justify-content-center">
                                    Remember Password?<a href="{{ route('login') }}" class="link-2 ms-1"> Sign In</a>
                                </p>

                                <!-- /Login -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
