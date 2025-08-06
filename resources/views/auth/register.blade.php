@extends('layouts.auth')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .iti {
            width: 100%;
            display: block;
        }
    </style>
@endpush

@section('content')
<div class="main-wrapper">
    <div class="login-content">
        <div class="row">

            <div class="col-md-6 login-bg d-none d-lg-flex">
                <div class="login-carousel">
                    <div>
                        <div class="login-carousel-section mb-3">
                            <div class="login-banner">
                                <img src="/frontpage/assets/img/auth/auth-1.svg" class="img-fluid" alt="Logo">
                            </div>
                            <div class="mentor-course text-center">
                                <h3 class="mb-2">Join a Community of <br>Lifelong <span class="text-secondary">Learners.</span></h3>
                                <p>Create your account to start your journey with thousands of courses, expert instructors, and a vibrant community.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 login-wrap-bg">
                <div class="login-wrapper">
                    <div class="loginbox">
                        <div class="w-100">
                            <div class="d-flex align-items-center justify-content-between login-header">
                                <a href="{{ url('/') }}">
                                    <img src="/frontpage/assets/img/logo.svg" class="img-fluid" alt="Logo">
                                </a>
                                <a href="{{ url('/') }}" class="link-1">Back to Home</a>
                            </div>

                            <h1 class="fs-32 fw-bold topic">Create Your Account</h1>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3 position-relative">
                                    <label class="form-label">Full Name<span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name') }}" required autofocus>
                                        <span><i class="isax isax-user input-icon text-gray-7 fs-14"></i></span>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required>
                                        <span><i class="isax isax-sms input-icon text-gray-7 fs-14"></i></span>
                                    </div>
                                </div>
                                
                                <div class="mb-3 position-relative">
                                    <label class="form-label">Phone Number<span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="tel" id="phone" class="form-control form-control-lg" required>
                                        <input type="hidden" name="phone" id="phone_full">
                                    </div>
                                </div>
                                
                                <div class="mb-3 position-relative">
                                    <label class="form-label">Register As<span class="text-danger ms-1">*</span></label>
                                    <select name="account_type" class="form-select form-select-lg" required>
                                        <option value="">Choose an option...</option>
                                        <option value="student" @selected(old('account_type') == 'student')>Student</option>
                                        <option value="parent" @selected(old('account_type') == 'parent')>Parent</option>
                                    </select>
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label">Password <span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative" id="passwordInput">
                                        <input type="password" name="password" class="pass-inputs form-control form-control-lg" required>
                                        <span class="isax toggle-passwords isax-eye-slash fs-14"></span>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label">Confirm Password <span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" name="password_confirmation" class="pass-inputs form-control form-control-lg" required>
                                        <span class="isax toggle-passwords isax-eye-slash fs-14"></span>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="remember-me d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label ms-2" for="terms">
                                            I agree to the <a href="#" class="link-2">Terms & Conditions</a>
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">Sign Up <i class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                            </form>

                            <div class="fs-14 fw-normal d-flex align-items-center justify-content-center mt-4">
                                Already have an account?
                                <a href="{{ route('login') }}" class="link-2 ms-1"> Login</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInputField = document.querySelector("#phone");
            const phoneFullField = document.querySelector("#phone_full");
            
            if (phoneInputField && phoneFullField) {
                const phoneInput = window.intlTelInput(phoneInputField, {
                    initialCountry: "id",
                    separateDialCode: true,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                });
    
                function updateHiddenInput() {
                    const fullNumber = phoneInput.getNumber(); 
                    phoneFullField.value = fullNumber; 
                }
    
                phoneInputField.addEventListener('keyup', updateHiddenInput);
                phoneInputField.addEventListener('change', updateHiddenInput);
    
                updateHiddenInput();
            }
        });
    </script>
@endpush