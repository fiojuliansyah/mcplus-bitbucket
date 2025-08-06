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
                                    <h3 class="mb-2">Welcome to <br>MCPlus<span class="text-secondary"> Premium</span> Courses.</h3>
                                    <p>Platform designed to help organizations, educators, and learners manage, deliver, and track learning and training activities.</p>
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
                                    {{-- Menggunakan logo dari template baru, tapi link ke root --}}
                                    <a href="{{ url('/') }}">
                                        <img src="/frontpage/assets/img/logo.svg" class="img-fluid" alt="Logo">
                                    </a>
                                    <a href="{{ url('/') }}" class="link-1">Back to Home</a>
                                </div>
                                <h1 class="fs-32 fw-bold topic">Sign into Your Account</h1>

                                <form id="email-login-form" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Email or Phone Number<span class="text-danger ms-1">*</span></label>
                                        <div class="position-relative">
                                            {{-- Input disesuaikan dengan styling template baru --}}
                                            <input type="text" name="login" class="form-control form-control-lg" :value="old('login')" required autofocus>
                                            <span><i class="isax isax-sms input-icon text-gray-7 fs-14"></i></span>
                                        </div>
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Password <span class="text-danger ms-1">*</span></label>
                                        <div class="position-relative" id="passwordInput">
                                            {{-- Input disesuaikan dengan styling template baru --}}
                                            <input type="password" name="password" class="pass-inputs form-control form-control-lg">
                                            <span class="isax toggle-passwords isax-eye-slash fs-14"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="remember-me d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                            <label class="form-check-label ms-2" for="remember_me">
                                                Remember Me
                                            </label>
                                        </div>
                                        <div>
                                            <a href="{{ route('password.request') }}" class="link-2">
                                                Forgot Password ?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-secondary btn-lg" type="submit">Login <i class="isax isax-arrow-right-3 ms-1"></i></button>
                                    </div>
                                </form>
                                <form id="otp-login-form" method="POST" action="{{ route('login.otp.send') }}" style="display: none;">
                                    @csrf
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Phone Number<span class="text-danger ms-1">*</span></label>
                                        <div class="position-relative">
                                            {{-- Input telepon internasional disesuaikan gayanya --}}
                                            <input type="tel" id="phone" class="form-control form-control-lg" required>
                                            <input type="hidden" name="phone" id="phone_full">
                                            <span><i class="isax isax-call input-icon text-gray-7 fs-14"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-secondary btn-lg" type="submit">Send Code <i class="isax isax-arrow-right-3 ms-1"></i></button>
                                    </div>
                                </form>
                                <div class="d-flex align-items-center justify-content-center or fs-14 my-3">
                                    Or
                                </div>
                                
                                {{-- Tombol untuk beralih antara password dan OTP --}}
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <button id="use-password-btn" class="btn btn-light" style="display: none;">Use Password</button>
                                    <button id="use-otp-btn" class="btn btn-light">Use OTP Code</button>
                                </div>

                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <a href="#" class="btn btn-light me-2"><img src="/frontpage/assets/img/icons/google.svg" alt="img" class="me-2">Google</a>
                                    <a href="#" class="btn btn-light"><img src="/frontpage/assets/img/icons/facebook.svg" alt="img" class="me-2">Facebook</a>
                                </div>

                                <div class="fs-14 fw-normal d-flex align-items-center justify-content-center">
                                    Don't you have an account?
                                    <a href="{{ route('register') }}" class="link-2 ms-1"> Sign up</a>
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
    <script>
        const emailLoginForm = document.getElementById('email-login-form');
        const otpLoginForm = document.getElementById('otp-login-form');
        const useOtpButton = document.getElementById('use-otp-btn');
        const usePasswordButton = document.getElementById('use-password-btn');

        useOtpButton.addEventListener('click', function(e) {
            e.preventDefault();
            emailLoginForm.style.display = 'none';
            otpLoginForm.style.display = 'block';
            useOtpButton.style.display = 'none';
            usePasswordButton.style.display = 'inline-block';
        });

        usePasswordButton.addEventListener('click', function(e) {
            e.preventDefault();
            emailLoginForm.style.display = 'block';
            otpLoginForm.style.display = 'none';
            useOtpButton.style.display = 'inline-block';
            usePasswordButton.style.display = 'none';
        });

        // Initialize state
        otpLoginForm.style.display = 'none';
        usePasswordButton.style.display = 'none';
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneFullField = document.querySelector("#phone_full");

        if (phoneInputField) {
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
    </script>
@endpush