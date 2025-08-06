@extends('layouts.auth')

@push('styles')
    <style>
        .otp-input {
            width: 60px;
            height: 70px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 5px !important;
            background-color: #F8F9FA;
            border: 1px solid #DEE2E6;
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
                                <h3 class="mb-2">One Last Step! <br>Let's Secure Your Account.</h3>
                                <p>Enter the verification code sent to your phone to complete the process and get started on your learning journey.</p>
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
                            
                            <h1 class="fs-32 fw-bold topic">Verify Your Account</h1>
                            <p class="fs-16 mb-4">Enter the 6-digit code sent to your phone number.</p>

                            <form method="POST" action="{{ route('verify.otp.submit', $userId) }}">
                                @csrf

                                <div class="mb-3 text-center" id="otp-container">
                                    <div class="d-flex justify-content-center gap-2 mt-2">
                                        <input type="text" class="form-control otp-input" maxlength="1" required>
                                        <input type="text" class="form-control otp-input" maxlength="1" required>
                                        <input type="text" class="form-control otp-input" maxlength="1" required>
                                        <input type="text" class="form-control otp-input" maxlength="1" required>
                                        <input type="text" class="form-control otp-input" maxlength="1" required>
                                        <input type="text" class="form-control otp-input" maxlength="1" required>
                                    </div>
                                    <input type="hidden" name="otp" id="otp_hidden">
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <div class="d-grid mt-4">
                                    <button class="btn btn-secondary btn-lg" type="submit">Verify & Proceed <i class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                            </form>

                            <div class="fs-14 fw-normal d-flex align-items-center justify-content-center mt-4">
                                Didn't receive the code?
                                <a href="#" class="link-2 ms-1"> Resend Code</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        const otpContainer = document.getElementById('otp-container');
        if (!otpContainer) return;

        const inputs = otpContainer.querySelectorAll('.otp-input');
        const hiddenInput = document.getElementById('otp_hidden');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                if (e.target.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                updateHiddenInput();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, inputs.length);
                pasteData.split('').forEach((char, i) => {
                    if (inputs[index + i]) {
                        inputs[index + i].value = char;
                    }
                });
                const lastFilledIndex = Math.min(index + pasteData.length, inputs.length);
                if (inputs[lastFilledIndex]) {
                    inputs[lastFilledIndex].focus();
                } else if (inputs[inputs.length - 1]) {
                    inputs[inputs.length - 1].focus();
                }
                updateHiddenInput();
            });
        });

        function updateHiddenInput() {
            let otpValue = '';
            inputs.forEach(input => {
                otpValue += input.value;
            });
            hiddenInput.value = otpValue;
        }
    });
    </script>
@endpush