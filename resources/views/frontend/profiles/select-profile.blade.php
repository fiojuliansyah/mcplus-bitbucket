@extends('layouts.guest')

@section('content')
<header class="relative w-full min-h-screen flex items-center justify-center font-inter overflow-hidden px-4 py-16 sm:py-24">
    <img src="/frontend/assets/images/header-bg.svg" alt="Background" class="w-full h-full object-cover absolute top-0 left-0 -z-10" />
    <div class="w-full max-w-2xl mx-auto">

        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-black">Select Your Profile</h1>
            <p class="text-base text-gray-600 mt-2">Choose a profile to continue.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-center mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="w-full space-y-4">
            
            @foreach ($user->profiles as $profile)
                @if ($profile->pin != null)
                    <button type="button" data-modal-toggle="pinModal-{{ $profile->id }}" class="w-full flex items-center gap-4 bg-white hover:bg-gray-100 border border-gray-200 rounded-xl p-4 shadow-sm transition">
                        <div class="w-16 h-16 rounded-full flex-shrink-0 flex items-center justify-center overflow-hidden shadow-inner">
                            @if($profile->avatar)
                                <img src="{{ asset('storage/' . $profile->avatar) }}" class="w-full h-full object-cover" alt="{{ $profile->name }} Avatar">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-black text-white text-2xl font-bold">
                                    <span>
                                        @php
                                            $words = explode(' ', $profile->name);
                                            $initials = '';
                                            foreach (array_slice($words, 0, 2) as $word) {
                                                if (!empty($word)) {
                                                    $initials .= strtoupper($word[0]);
                                                }
                                            }
                                        @endphp
                                        {{ $initials }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col items-start text-left">
                            <h2 class="text-lg font-semibold text-gray-900">{{ $profile->name }}</h2>
                        </div>
                    </button>
                @else
                    <form action="{{ route('user.change-profile', $profile->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                        <button type="submit" class="w-full flex items-center gap-4 bg-white hover:bg-gray-100 border border-gray-200 rounded-xl p-4 shadow-sm transition">
                            <div class="w-16 h-16 rounded-full flex-shrink-0 flex items-center justify-center overflow-hidden shadow-inner">
                                @if($profile->avatar)
                                    <img src="{{ asset('storage/' . $profile->avatar) }}" class="w-full h-full object-cover" alt="{{ $profile->name }} Avatar">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-black text-white text-2xl font-bold">
                                        <span>
                                            @php
                                                $words = explode(' ', $profile->name);
                                                $initials = '';
                                                foreach (array_slice($words, 0, 2) as $word) {
                                                    if (!empty($word)) {
                                                        $initials .= strtoupper($word[0]);
                                                    }
                                                }
                                            @endphp
                                            {{ $initials }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col items-start text-left">
                                <h2 class="text-lg font-semibold text-gray-900">{{ $profile->name }}</h2>
                            </div>
                        </button>
                    </form>
                @endif
            @endforeach

             <button type="button" data-modal-toggle="addProfileModal" class="w-full flex items-center gap-4 bg-white hover:bg-gray-100 border-2 border-dashed border-gray-300 rounded-xl p-4 transition group">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-gray-200">
                     <svg xmlns="http://www.w.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" /></svg>
                </div>
                <div class="flex flex-col items-start text-left">
                    <h2 class="text-lg font-semibold text-gray-700">Add New Profile</h2>
                </div>
            </button>
        </div>

    </div>
</header>

@foreach ($user->profiles as $profile)
    @if ($profile->pin != null)
    <div id="pinModal-{{ $profile->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4">
        
        <div class="relative w-full max-w-md">
        
            <div class="relative bg-white rounded-2xl shadow">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="pinModal-{{ $profile->id }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                
                <div class="p-6 text-center">
                    <h3 class="mb-2 text-xl font-semibold text-gray-900">Enter PIN for {{ $profile->name }}</h3>
                    <form method="POST" action="{{ route('user.change-profile', $profile->id) }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                        <input type="password" name="pin" class="bg-gray-50 border border-gray-300 text-gray-900 text-2xl text-center rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="••••" required autofocus maxlength="4" pattern="[0-9]*" inputmode="numeric">
                        <button type="submit" class="w-full mt-4 text-white bg-black hover:bg-zinc-800 font-medium rounded-lg text-sm px-5 py-3 text-center">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<div id="addProfileModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4">
    <div class="relative w-full max-w-md">
        <div class="relative bg-white rounded-2xl shadow">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="addProfileModal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            <div class="py-6 px-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900">Add New Profile</h3>
                <form class="space-y-6" method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="profile_name" class="block mb-2 text-sm font-medium text-gray-900">Profile Name</label>
                        <input type="text" name="name" id="profile_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>
                    <div>
                        <label for="profile_avatar" class="block mb-2 text-sm font-medium text-gray-900">Avatar (Optional)</label>
                        <input type="file" name="avatar" id="profile_avatar" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none">
                    </div>
                    <button type="submit" class="w-full text-white bg-black hover:bg-zinc-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-modal-toggle]').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const modalId = toggle.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
                modal.classList.toggle('flex');
            }
        });
    });
});
</script>
@endpush