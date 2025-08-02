@extends('layouts.auth')

@section('content')

<style>
    .otp-input {
        width: 45px;
        height: 50px;
        text-align: center;
        font-size: 1.5rem;
        border-radius: 5px !important;
    }
</style>

<div class="vh-100" style="background: url('/frontend/assets/images/pages/bg-auth.jpg'); background-size: cover; background-repeat: no-repeat; position: relative;min-height:500px">
  <div class="container">
    <div class="row justify-content-center align-items-center height-self-center vh-100">
        <div class="col-lg-8 col-md-6 align-self-center">
            <div class="user-login-card bg-body">
                <div class="text-center">
                    <div class="logo-default">
                        <a class="navbar-brand text-primary" href="./index.html">
                            <img class="img-fluid logo" src="/frontend/assets/images/logo-example.png"
                                loading="lazy" alt="Mcplus Premium" />
                        </a>
                    </div>
                </div>
                <form method="POST" action="{{ route('verify.otp.submit', $userId) }}"> 
                    @csrf
                    <h4 class="text-center mb-3">Verify Your Phone Number</h4>
                    
                    <div class="mb-3 text-center" id="otp-container">
                        <label for="otp" class="form-label text-white">Enter OTP sent to your phone</label>
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
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="row text-center mt-4">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <div class="full-button">
                                <div class="iq-button">
                                    <button type="submit" class="btn text-uppercase position-relative">
                                        <span class="button-text">Verify OTP</span>
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const otpContainer = document.getElementById('otp-container');
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
            const pasteData = e.clipboardData.getData('text').slice(0, inputs.length);
            pasteData.split('').forEach((char, i) => {
                if (inputs[index + i]) {
                    inputs[index + i].value = char;
                }
            });
            const lastFilledIndex = Math.min(index + pasteData.length, inputs.length) - 1;
            inputs[lastFilledIndex].focus();
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

@endsection