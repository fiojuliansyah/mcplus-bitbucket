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
@endsection --}}


@section('content')
<header class="relative w-full md:max-h-[900px] flex items-center font-inter overflow-hidden px-4 py-48 md:py-56">
    <img src="/frontend/assets/images/header-bg.svg" alt="" class="w-full absolute top-0 right-0 -z-10" />
    <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center space-y-3">
        <form  method="POST" action="{{ route('password.store') }}" class="w-full max-w-lg mx-auto bg-white text-black text-center shadow-lg rounded-2xl md:rounded-3xl px-5 py-8 md:p-10 lg:p-20">
            @csrf
            <h1 class="text-xl md:text-3xl">Reset Your Password</h1>
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="w-full space-y-3 py-3 pt-5">
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
                <div class="w-full text-left">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" class="w-full text-white bg-black rounded-md p-3" />
                </div>
                <div class="w-full text-left">
                    <label for="password">Confirm Password</label>
                    <input type="password" id="password" name="password_confirmation" class="w-full text-white bg-black rounded-md p-3" />
                </div>
                <div class="mt-12">
                    <button type="submit" class="w-full flex justify-center items-center text-sm md:text-base transition-all duration-300 bg-zinc-200 hover:bg-zinc-300 rounded-lg hover:cursor-pointer p-3">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
</header>
@endsection
