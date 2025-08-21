@extends('layouts.guest')

@section('content')
    <header class="relative w-full flex items-center justify-center font-inter overflow-hidden px-4 py-24 md:py-32">
        <img src="/frontend/assets/images/header-bg.svg" alt="" class="w-full h-full object-cover absolute top-0 left-0 -z-10" />
        <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center">
            
            <form method="POST" action="{{ route('verify.otp.submit', ['userId' => $userId]) }}" class="w-full max-w-lg mx-auto bg-white text-black text-center shadow-lg rounded-2xl md:rounded-3xl px-5 py-8 md:p-10 lg:p-12">
                @csrf <h1 class="text-xl md:text-3xl font-bold">Verify your email address</h1>
                
                <p class="font-medium pt-3">We’ve sent a verification code to <br class="sm:hidden"> <strong class="font-bold">{{ $user->email }}</strong>. <br>Please enter this code to continue.</p>

                <p class="text-zinc-500 text-sm mt-2">Haven't received the email? Check your spam folder or resend the code.</p>

                @error('otp')
                    <div class="mt-4 text-red-600 bg-red-100 border border-red-400 rounded-md p-3 text-sm">
                        {{ $message }}
                    </div>
                @enderror

                @if (session('status'))
                    <div class="mt-4 text-green-600 bg-green-100 border border-green-400 rounded-md p-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif
                
                <div class="w-full space-y-3 py-3 pt-5">
                    <div id="otp-inputs" class="w-full grid grid-cols-6 gap-2 md:gap-3">
                        <input type="text" maxlength="1" class="otp-input w-full aspect-square text-center text-lg md:text-2xl font-bold border border-black rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        <input type="text" maxlength="1" class="otp-input w-full aspect-square text-center text-lg md:text-2xl font-bold border border-black rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        <input type="text" maxlength="1" class="otp-input w-full aspect-square text-center text-lg md:text-2xl font-bold border border-black rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        <input type="text" maxlength="1" class="otp-input w-full aspect-square text-center text-lg md:text-2xl font-bold border border-black rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        <input type="text" maxlength="1" class="otp-input w-full aspect-square text-center text-lg md:text-2xl font-bold border border-black rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        <input type="text" maxlength="1" class="otp-input w-full aspect-square text-center text-lg md:text-2xl font-bold border border-black rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>

                    <input type="hidden" name="otp" id="otp_full" />

                    <div id="countdown-timer" class="w-full flex justify-center items-center font-mono py-2 text-lg">
                        <span id="minutes">01</span>
                        <span>:</span>
                        <span id="seconds">00</span>
                    </div>
                    
                    <button type="submit" class="w-full flex justify-center items-center text-base md:text-lg transition-all duration-300 bg-black hover:bg-zinc-800 text-white rounded-lg p-3 font-semibold">Verify</button>
                    
                    <p class="text-sm md:text-base pt-2">
                        Didn’t receive code? 
                        <a href="{{-- route('otp.resend', ['userId' => $userId]) --}}" id="resend-link" class="underline text-zinc-400 pointer-events-none">Resend code</a>
                    </p>
                </div>
            </form>
        </div>
    </header>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const otpInputs = document.querySelectorAll('.otp-input');
    const hiddenOtpInput = document.getElementById('otp_full');
    const otpContainer = document.getElementById('otp-inputs');

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            updateHiddenInput();
            if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });

    otpContainer.addEventListener('paste', (e) => {
        e.preventDefault();
        const pasteData = e.clipboardData.getData('text').slice(0, 6);
        pasteData.split('').forEach((char, index) => {
            if (otpInputs[index]) {
                otpInputs[index].value = char;
            }
        });
        updateHiddenInput();
        otpInputs[pasteData.length -1]?.focus();
    });

    function updateHiddenInput() {
        let otpValue = '';
        otpInputs.forEach(input => {
            otpValue += input.value;
        });
        hiddenOtpInput.value = otpValue;
    }

    const minutesEl = document.getElementById('minutes');
    const secondsEl = document.getElementById('seconds');
    const resendLink = document.getElementById('resend-link');
    let timeLeft = 60; 

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;

        seconds = seconds < 10 ? '0' + seconds : seconds;
        
        minutesEl.textContent = minutes < 10 ? '0' + minutes : minutes;
        secondsEl.textContent = seconds;

        if (timeLeft > 0) {
            timeLeft--;
        } else {
            clearInterval(timerInterval);
            resendLink.classList.remove('text-zinc-400', 'pointer-events-none');
            resendLink.classList.add('hover:text-zinc-700', 'text-black');
        }
    }

    const timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
});
</script>
@endpush