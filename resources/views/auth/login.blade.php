@extends('layouts.auth')

@section('content')
   <div class="vh-100"
        style="background: url('/frontend/assets/images/pages/bg-auth.jpg'); background-size: cover; background-repeat: no-repeat; position: relative;min-height:500px">
        <div class="container">
            <div class="row justify-content-center align-items-center height-self-center vh-100">
                <div class="col-lg-5 col-md-12 align-self-center">
                    <div class="user-login-card bg-body">
                        <div class="text-center">
                            <!--Logo -->
                            <div class="logo-default">
                                <a class="navbar-brand text-primary" href="./index.html">
                                    <img class="img-fluid logo" src="/frontend/assets/images/logo-example.png"
                                        loading="lazy" alt="Mcplus Premium" />
                                </a>
                            </div>
                        </div>

                        <!-- Form -->
                        <form id="email-login-form" action="{{ route('login') }}" method="POST">
                            @csrf
                            <!-- Email Login Form -->
                            <div id="email-login-form">
                                <div class="mb-3">
                                    {{-- <label class="text-white fw-500 mb-2">Email or mobile number</label> --}}
                                    <input type="text" name="email" class="form-control rounded-0" placeholder="Email or mobile number">
                                </div>
                                <div class="mb-3">
                                    {{-- <label class="text-white fw-500 mb-2">Password</label> --}}
                                    <input type="password" name="password" class="form-control rounded-0" placeholder="Password">
                                </div>
                                <div class="text-end mb-3">
                                    <a href="reset-password.html" class="text-primary fw-semibold fst-italic">Forgot
                                        Password?</a>
                                </div>
                                <label
                                    class="list-group-item d-flex align-items-center mb-3 font-size-14 text-white fw-500"><input
                                        class="form-check-input m-0 me-2" type="checkbox">Remember Me</label>
                                <div class="full-button">
                                    <div class="iq-button">
                                        <button type="submit" class="btn text-uppercase position-relative">
                                            <span class="button-text">Log In</span>
                                            <i class="fa-solid fa-play"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="full-button mt-4">
                                    <a href="javascript:void(0)" id="use-otp-btn" class="btn btn-secondary text-uppercase position-relative">
                                        <span class="button-text">Use OTP Code</span>
                                        <i class="fa-solid fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <form id="otp-login-form" action="POST">
                            <!-- OTP Login Form -->
                            <div id="otp-login-form">
                                <div class="mb-3">
                                    <input type="text" class="form-control rounded-0" placeholder="Enter your phone number" required="">
                                </div>
                                <div class="full-button">
                                    <div class="iq-button">
                                        <a href="#" class="btn text-uppercase position-relative">
                                            <span class="button-text">Send Code</span>
                                            <i class="fa-solid fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="full-button mt-4">
                                    <a href="javascript:void(0)" id="use-password-btn" class="btn btn-secondary text-uppercase position-relative">
                                        <span class="button-text">Use Password</span>
                                        <i class="fa-solid fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </form>

                        <p class="my-4 text-center fw-500 text-white">New to Mcplus Premium? <a href="{{ route('register') }}"
                                class="text-primary ms-1">Register</a></p>
                        <div class="seperator d-flex justify-content-center align-items-center">
                            <span class="line"></span>
                            <span class="mx-2">OR</span>
                            <span class="line"></span>
                        </div>
                        <ul class="p-0 pt-4 m-0 list-unstyled widget_social_media text-center">
                        <li>
                            <a href="https:/www.google.com/" class="position-relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M21.8055 10.0415H21V10H12V14H17.6515C16.827 16.3285 14.6115 18 12 18C8.6865 18 6 15.3135 6 12C6 8.6865 8.6865 6 12 6C13.5295 6 14.921 6.577 15.9805 7.5195L18.809 4.691C17.023 3.0265 14.634 2 12 2C6.4775 2 2 6.4775 2 12C2 17.5225 6.4775 22 12 22C17.5225 22 22 17.5225 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z" fill="#FBC02D"/>
                                <path d="M3.15283 7.3455L6.43833 9.755C7.32733 7.554 9.48033 6 11.9998 6C13.5293 6 14.9208 6.577 15.9803 7.5195L18.8088 4.691C17.0228 3.0265 14.6338 2 11.9998 2C8.15883 2 4.82783 4.1685 3.15283 7.3455Z" fill="#E53935"/>
                                <path d="M12.0002 22.0001C14.5832 22.0001 16.9302 21.0116 18.7047 19.4041L15.6097 16.7851C14.6057 17.5456 13.3577 18.0001 12.0002 18.0001C9.39916 18.0001 7.19066 16.3416 6.35866 14.0271L3.09766 16.5396C4.75266 19.7781 8.11366 22.0001 12.0002 22.0001Z" fill="#4CAF50"/>
                                <path d="M21.8055 10.0415L21.7975 10H21H12V14H17.6515C17.2555 15.1185 16.536 16.083 15.608 16.7855C15.6085 16.785 15.609 16.785 15.6095 16.7845L18.7045 19.4035C18.4855 19.6025 22 17 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z" fill="#1565C0"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Get references to the forms and buttons
    const emailLoginForm = document.getElementById('email-login-form');
    const otpLoginForm = document.getElementById('otp-login-form');
    const useOtpButton = document.getElementById('use-otp-btn');
    const usePasswordButton = document.getElementById('use-password-btn');

    // Initially hide OTP form
    otpLoginForm.style.display = 'none'; // Ensure OTP form is hidden initially

    // Switch to OTP form
    useOtpButton.addEventListener('click', function() {
        emailLoginForm.style.display = 'none'; // Hide email/password form
        otpLoginForm.style.display = 'block'; // Show OTP form
    });

    // Switch back to email/password form
    usePasswordButton.addEventListener('click', function() {
        emailLoginForm.style.display = 'block'; // Show email/password form
        otpLoginForm.style.display = 'none'; // Hide OTP form
    });
</script>
@endpush

