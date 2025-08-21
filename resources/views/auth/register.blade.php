@extends('layouts.guest')

@section('content')
    <header class="relative w-full md:max-h-[900px] flex items-center font-inter overflow-hidden px-4 py-48 md:py-56">
        <img src="./asset/images/header-bg.svg" alt="" class="w-full absolute top-0 right-0 -z-10" />
        <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center space-y-3">
            <!-- FORM -->
            <form method="POST" action="{{ route('register') }}" class="w-full max-w-lg mx-auto bg-white text-black text-center shadow-lg rounded-2xl md:rounded-3xl px-5 py-8 md:p-10 lg:p-20">
                @csrf
                <h1 class="text-xl md:text-3xl">Create an Account</h1>
                <div class="w-full space-y-3 py-3 pt-5">
                    <div class="w-full text-left">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" class="w-full text-white bg-black rounded-md p-3" />
                    </div>
                    <div class="w-full text-left">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="w-full text-white bg-black rounded-md p-3" />
                    </div>
                    <div class="w-full text-left">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full text-white bg-black rounded-md p-3" />
                    </div>
                    <!-- BUTTON -->
                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center items-center text-sm md:text-base transition-all duration-300 bg-zinc-200 hover:bg-zinc-300 rounded-lg hover:cursor-pointer p-3">Continue</button>
                        <p class="text-sm md:text-base">Already have an account? <a href="{{ route('choose.login') }}" class="underline hover:text-zinc-500">Login</a></p>
                    </div>
                </div>
            </form>
        </div>
    </header>
@endsection