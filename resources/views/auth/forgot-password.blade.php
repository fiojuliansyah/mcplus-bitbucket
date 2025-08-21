@extends('layouts.guest')

{{-- @section('content')
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
@endsection --}}

@section('content')
<header class="relative w-full min-h-screen flex items-center font-inter overflow-hidden px-4 py-24 md:py-32">
    <img src="/frontend/assets/images/header-bg.svg" alt="background" class="w-full h-full object-cover absolute top-0 left-0 -z-10" />
    <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center">
        <div class="w-full max-w-md mx-auto bg-white text-black text-center shadow-2xl rounded-2xl md:rounded-3xl px-6 py-10 md:p-12">
            
            <h1 class="text-2xl md:text-3xl font-bold">Forgot Password?</h1>
            <div class="flex justify-center mb-4 mt-4">
                <img src="/frontend/assets/images/forgot-password.svg" alt="" class="h-14" >
            </div>
            <p class="text-sm md:text-base text-gray-600 mt-2">Enter your registered email. We will email you a link to reset your password.</p>

            <div class="w-full space-y-4 pt-6">
                <form  action="{{ route('password.email') }}" method="POST">
                    @csrf
                    @if (session('status'))
                        <p style="color: green">
                            {{ session('status') }}
                        </p>
                    @endif
                    <input type="email" name="email" id="email" placeholder="Email" required class="w-full text-center text-sm md:text-base border border-zinc-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                    <button type="submit" class="w-full mt-4 flex justify-center items-center text-sm md:text-base transition-all duration-300 bg-black text-white hover:bg-zinc-800 rounded-lg p-3 font-semibold">
                        Send Reset Link
                    </button>
                </form>
            </div>
        </div>
    </div>
    </header>
@endsection