@extends('layouts.guest')

@section('content')
    <header class="relative w-full md:max-h-[900px] flex items-center font-inter overflow-hidden px-4 py-48 md:py-56">
        <img src="/frontend/assets/images/header-bg.svg" alt="" class="w-full absolute top-0 right-0 -z-10" />
        <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center space-y-3">
            <form  action="{{ route('login') }}" method="POST" class="w-full max-w-lg mx-auto bg-white text-black text-center shadow-lg rounded-2xl md:rounded-3xl px-5 py-8 md:p-10 lg:p-20">
                @csrf
                <h1 class="text-xl md:text-3xl">Welcome back!</h1>
                <div class="w-full space-y-3 py-3 pt-5">
                    <div class="w-full text-left">
                        <label for="login">Email or Phone Number</label>
                        <input type="text" id="login" name="login" class="w-full text-white bg-black rounded-md p-3" />
                    </div>
                    <div class="w-full text-left">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="w-full text-white bg-black rounded-md p-3" />
                    </div>
                    @error('login')
                    <p class="font-bold text-red-500 text-xs text-left">{{ $message }}</p>
                    @enderror
                    @error('password')
                    <p class="font-bold text-red-500 text-xs text-left">{{ $message }}</p>
                    @enderror
                    <div class="pt-5">
                        <button type="submit" class="w-full flex justify-center items-center text-sm md:text-base transition-all duration-300 bg-zinc-200 hover:bg-zinc-300 rounded-lg hover:cursor-pointer p-3">Log In</button>
                    </div>
                    <p class="text-sm md:text-base"><a href="{{ route('password.request') }}" class="underline hover:text-zinc-500">Forgot Password?</a></p>
                </div>
            </form>
        </div>
    </header>
@endsection