@extends('layouts.guest')

@section('content')
<header class="relative w-full md:max-h-[900px] flex items-center font-inter overflow-hidden px-4 py-48 md:py-56">
    <img src="/frontend/assets/images/header-bg.svg" alt="" class="w-full absolute top-0 right-0 -z-10" />
    <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center space-y-3">
        <div class="w-full max-w-lg mx-auto bg-white text-black text-center shadow-lg rounded-2xl md:rounded-3xl px-5 py-8 md:p-10 lg:p-20">
            <div class="flex justify-center mb-4 mt-4">
                <img src="/frontend/assets/images/success-reset-password.svg" alt="" class="h-20" />
            </div>
            <h1 class="text-xl md:text-3xl">Your password has been changed successfully</h1>
            <p class="text-sm md:text-base mt-8">Only one click to explore online education.</p>
            <div class="w-full space-y-3 py-3 pt-5">
                <a href="{{ route('choose.login') }}" class="w-full flex justify-center items-center text-sm md:text-base transition-all duration-300 bg-zinc-200 hover:bg-zinc-300 rounded-lg p-3">Login Now</a>
            </div>
        </div>
    </div>
</header>
@endsection