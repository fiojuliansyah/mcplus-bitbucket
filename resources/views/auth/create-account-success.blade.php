@extends('layouts.guest')

@section('content')
@if ($user->account_type === 'parent')
  <header class="relative w-full md:max-h-[900px] flex items-center font-inter overflow-hidden px-4 py-48 md:py-56">
    <img src="/frontend/assets/images/parent-banner.png" alt="" class="w-full absolute top-0 right-0 -z-10 opacity-30" />
    <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center space-y-3">
        <!-- FORM -->
        <div class="w-full max-w-lg mx-auto bg-white text-black text-center shadow-lg rounded-2xl md:rounded-3xl px-5 py-8 md:p-10 lg:p-20">
            <div class="flex justify-center mb-4 mt-4">
                <img src="/frontend/assets/images/parent-account-success.svg" alt="" class="h-20" />
            </div>
            <h1 class="text-xl md:text-3xl">Welcome, parent!</h1>
            <p class="text-sm md:text-base py-2">Join Malaysia's biggest online tuition biggest online tuition</p>

            <div class="w-full space-y-5 md:space-y-8 text-left py-5">
                <!-- SINGLE ITEM -->
                <div class="w-full flex items-center gap-5">
                    <div class="w-12 flex justify-center items-center">
                        <svg class="w-10" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.2622 15.8823L27.5433 12.6658V28.9472H20.2622V15.8823Z" stroke="#262626" stroke-opacity="0.75" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.1606 11.8616L15.7114 18.2947L20.2622 15.8823V28.9444H11.1606V11.8616Z" stroke="#262626" stroke-opacity="0.75" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M3.87939 15.0781L11.1606 11.8616V28.947H3.87939V15.0781Z" stroke="#262626" stroke-opacity="0.75" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M29.348 4.05713L17.8075 11.4344L12.5015 5.23006L3.00781 10.1079" stroke="#262626" stroke-opacity="0.75" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.6104 3.08154L29.3478 4.03778L28.3917 9.77523" stroke="#262626" stroke-opacity="0.75" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>                         
                    </div>
                    <p class="text-sm text-zinc-500">Keep track of your children’s progress and performance.</p>
                </div>
                <!-- SINGLE ITEM -->
                <div class="w-full flex items-center gap-5">
                    <div class="w-12 flex justify-center items-center">
                        <svg class="w-10" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.666 21.75L15.5751 24L20.666 18" stroke="#262626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.0784 5.38818C4.55177 5.38818 4.04673 5.6118 3.67435 6.00981C3.30197 6.40784 3.09277 6.94767 3.09277 7.51056V27.6732C3.09277 28.236 3.30197 28.776 3.67435 29.1739C4.04673 29.5719 4.55177 29.7956 5.0784 29.7956H26.9203C27.4469 29.7956 27.9521 29.5719 28.3244 29.1739C28.6967 28.776 28.9059 28.236 28.9059 27.6732V7.51056C28.9059 6.94767 28.6967 6.40784 28.3244 6.00981C27.9521 5.6118 27.4469 5.38818 26.9203 5.38818H23.838" stroke="#262626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M3.09277 12.8167H28.9059" stroke="#262626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.57129 2.20459V8.57173" stroke="#262626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.4277 2.20459V8.57173" stroke="#262626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.57129 5.38818H19.1832" stroke="#262626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>                            
                    </div>
                    <p class="text-sm text-zinc-500">View live class schedules and their attendances.</p>
                </div>
                <!-- SINGLE ITEM -->
                <div class="w-full flex items-center gap-5">
                    <div class="w-12 flex justify-center items-center">
                        <svg class="w-10" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.7751 10.7554C22.1674 10.7554 24.4617 11.7057 26.1533 13.3973C27.8448 15.0889 28.7952 17.3832 28.7952 19.7755C28.8009 21.5511 28.2761 23.2878 27.2883 24.7631L28.7952 28.7956L23.7227 27.883C22.5028 28.4779 21.1644 28.7899 19.8072 28.7956C18.45 28.8013 17.109 28.5006 15.8841 27.9161C14.6592 27.3316 13.5821 26.478 12.7329 25.4193C11.8836 24.3607 11.2843 23.124 10.9795 21.8013C10.6747 20.4788 10.6722 19.1045 10.9723 17.7809C11.2724 16.4573 11.8674 15.2184 12.7128 14.1567C13.5582 13.095 14.6324 12.2377 15.8552 11.6488C17.078 11.0599 18.4179 10.7545 19.7751 10.7554Z" stroke="#262626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M21.0696 5.47068C19.6404 3.65195 17.6796 2.32414 15.4602 1.67213C13.2408 1.02013 10.8734 1.07637 8.68753 1.83302C6.50165 2.58968 4.60611 4.00908 3.26479 5.89363C1.92348 7.77815 1.20317 10.0341 1.20415 12.3472C1.19757 14.546 1.84794 16.6966 3.07184 18.5233L1.20415 23.4896L5.70359 22.6831" stroke="#262626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>                            
                    </div>
                    <p class="text-sm text-zinc-500">Communicate directly with teachers wxhen necessary</p>
                </div>
            </div>
            <div class="w-full space-y-3 py-3 pt-5">
                <a href="{{ route('user.dashboard') }}" class="w-full flex justify-center items-center text-sm md:text-base transition-all duration-300 bg-zinc-200 hover:bg-zinc-300 rounded-lg p-3">Back To Home</a>
            </div>
        </div>
    </div>
</header>  
@elseif($user->account_type === 'student')
<header class="relative w-full md:max-h-[900px] flex items-center font-inter overflow-hidden px-4 py-48 md:py-56">
    <img src="/frontend/assets/images/header-bg.svg" alt="" class="w-full absolute top-0 right-0 -z-10" />
    <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center space-y-3">
        <!-- FORM -->
        <div class="w-full max-w-lg mx-auto bg-white text-black text-center shadow-lg rounded-2xl md:rounded-3xl px-5 py-8 md:p-10 lg:p-20">
            <div class="flex justify-center py-5">
                <div class="w-20 h-20 flex justify-center items-center bg-black rounded-full ring-8 ring-zinc-300">
                    <svg width="40" height="48" viewBox="0 0 40 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M36.1375 10.874L30.5827 12.9299C30.3918 15.4722 30.8415 17.9679 30.0666 20.4415C27.0982 29.921 13.2252 30.0323 10.0825 20.5982C9.24247 18.0778 9.70883 15.5272 9.51647 12.9299L1.57183 9.8997C0.351275 9.24694 0.426002 7.46317 1.72958 6.96433L19.5286 0.328125L20.6523 0.348739L38.7239 7.12649C39.2484 7.50028 39.4075 7.93042 39.4615 8.55569C39.2262 12.3665 39.7618 16.5194 39.4615 20.2903C39.3521 21.6549 38.1953 22.7818 36.8681 21.927C36.691 21.813 36.1361 21.1712 36.1361 21.0063V10.874H36.1375ZM33.0224 8.4059L20.006 3.67852L7.07537 8.45675L20.0849 13.3188C24.1852 11.6628 28.4295 10.3381 32.5312 8.68762C32.6709 8.63128 32.9989 8.56119 33.0238 8.4059H33.0224ZM27.2117 14.1653C24.79 14.9349 22.4706 16.0645 20.0157 16.6981L12.8889 14.1653V18.332C12.8889 18.8886 13.5352 20.3645 13.8438 20.884C16.6363 25.5976 23.6386 25.5289 26.3316 20.7521C26.6111 20.256 27.2117 18.8529 27.2117 18.3334V14.1667V14.1653Z" fill="white"/><path d="M36.5887 46.9438C36.3437 46.7143 36.1735 46.3351 36.1375 46.0025C35.9728 44.4922 36.2538 42.7084 36.1417 41.1638C35.8787 37.5317 32.79 34.8409 29.6694 33.3829C29.0716 33.1039 27.2878 32.3467 26.7177 32.2848C26.6015 32.2725 26.5157 32.2725 26.4299 32.3645C25.1207 33.5038 23.9223 35.1007 22.5897 36.1753C21.7829 36.8253 20.7395 37.1977 19.6878 37.1029C17.2453 36.883 15.3854 33.6742 13.5421 32.2848C9.40719 33.3004 4.31603 36.4378 3.96453 41.0662C3.85244 42.549 4.21778 44.8632 3.93963 46.1853C3.62826 47.6653 1.27849 47.8934 0.776158 46.2815C0.395601 45.0639 0.635006 40.7323 0.897937 39.3635C1.84864 34.4328 7.70091 30.2221 12.4074 29.1694C15.8933 28.3889 17.3463 31.8478 19.6809 33.714C19.8967 33.868 20.2067 33.8666 20.4198 33.714C21.7289 32.5721 22.926 30.9862 24.2517 29.9005C25.85 28.5923 27.2546 28.9812 29.0301 29.5927C33.7767 31.2267 38.7087 34.9825 39.3536 40.2431C39.5307 41.6901 39.6013 44.2462 39.4449 45.6809C39.2788 47.2146 37.7538 48.0405 36.5887 46.9438Z" fill="white"/></svg>                            
                </div>
            </div>
            <h1 class="text-xl md:text-3xl font-bold">Welcome, <br> {{ $user->current_profile->name }}</h1>
            <p class="text-sm md:text-base py-2">{{ $grade->name }} ({{ $user->current_profile->created_at->format('Y') }})</p>
            <div class="w-full space-y-3 py-3 pt-5">
                <a href="{{ route('home') }}" class="w-full flex justify-center items-center text-sm md:text-base transition-all duration-300 bg-zinc-200 hover:bg-zinc-300 rounded-lg p-3">Continue</a>
            </div>
        </div>
    </div>
</header>
@else
    
@endif

@endsection