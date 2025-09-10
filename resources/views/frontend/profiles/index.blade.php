@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
        <div class="w-full max-w-screen-xl mx-auto">
            <!-- HEADER -->
            <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
                <!-- LEFT SECTION -->
                <div class="flex items-center gap-3">
                    <img src="/frontend/assets/images/student-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
                    <div>
                        <span class="text-gray-250">Student</span>
                        <h1 class="text-4xl font-bold tracking-tight text-white">My Profile</h1>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="space-y-10 divide-y divide-zinc-700">
                <!-- FORM -->
                <div class="w-full pt-10">
                    <form action="{{ route('user.profile.update', $user->current_profile->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-12">
                            <div class="col-span-12">
                                <div class="flex items-center gap-3 mb-6">
                                    <img src="/frontend/assets/icons/student.svg" alt="Icon" class="size-6" />
                                    <h6 class="text-[20px] text-gray-75 font-semibold">Basic Profile</h6>
                                </div>

                                <div class="grid grid-cols-12 gap-5">
                                    <!-- AVATAR -->
                                    <div class="col-span-12 lg:col-span-2">
                                        <div class="flex flex-col gap-3 items-center">
                                            <div id="avatar-preview"
                                                class="bg-gray-50 rounded-full w-[138px] h-[138px] flex items-center justify-center overflow-hidden">
                                                @if ($user->current_profile?->avatar)
                                                    <img src="{{ asset('storage/' . $user->current_profile->avatar) }}"
                                                        alt="Avatar"
                                                        class="w-full h-full object-cover rounded-full" />
                                                @else
                                                    <img src="/frontend/assets/icons/student-black.svg"
                                                        alt="Default Icon"
                                                        class="w-3/4 h-3/4 object-contain" />
                                                @endif
                                            </div>

                                            <!-- Upload Button -->
                                            <label
                                                class="bg-gray-50 rounded-full w-[31px] h-[31px] flex items-center justify-center cursor-pointer">
                                                <img src="/frontend/assets/icons/pencil.svg" alt="Icon" class="size-4 text-black" />
                                                <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*">
                                            </label>
                                        </div>
                                    </div>

                                    <!-- PROFILE FORM -->
                                    <div class="col-span-12 lg:col-span-10">
                                        <div class="grid grid-cols-12 gap-10">
                                            <!-- Full Name -->
                                            <div class="col-span-12">
                                                <div class="w-full">
                                                    <label class="block mb-2 text-[15px] font-medium text-gray-200">Full Name</label>
                                                    <input type="text" name="name" value="{{ old('name', $user->current_profile->name) }}"
                                                        class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 
                                                        rounded-[14px] w-full px-4 py-3"
                                                        placeholder="Full Name" required />
                                                </div>
                                            </div>

                                            <!-- NRIC -->
                                            <div class="col-span-12 lg:col-span-6">
                                                <div class="w-full">
                                                    <label class="block mb-2 text-[15px] font-medium text-gray-200">NRIC</label>
                                                    <input type="text" name="ic_number"
                                                        value="{{ old('ic_number', $user->current_profile?->ic_number) }}"
                                                        class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 
                                                        rounded-[14px] w-full px-4 py-3"
                                                        placeholder="NRIC" required />
                                                </div>
                                            </div>
                                            
                                            <!-- Phone Number -->
                                            <div class="col-span-12 lg:col-span-6">
                                                <div class="w-full">
                                                    <label class="block mb-2 text-[15px] font-medium text-gray-200">Phone Number</label>
                                                    <div class="flex rounded-[14px] overflow-hidden border border-gray-950 bg-gray-1000">
                                                        <span class="px-4 py-3 bg-gray-950 text-gray-300 flex items-center">+60</span>
                                                        <input type="text" name="phone"
                                                            value="{{ old('phone', ltrim(str_replace('+60', '', $user->phone), '0')) }}"
                                                            class="flex-1 bg-gray-1000 text-gray-75 placeholder:text-gray-500 px-4 py-3 focus:outline-none"
                                                            placeholder="123456789" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-span-12 lg:col-span-6">
                                                <div class="w-full">
                                                    <label class="block mb-2 text-[15px] font-medium text-gray-200">Email Address</label>
                                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                        class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 
                                                        rounded-[14px] w-full px-4 py-3"
                                                        placeholder="Email Address" required />
                                                </div>
                                            </div>

                                            <!-- Postcode -->
                                            <div class="col-span-12 lg:col-span-6">
                                                <div class="w-full">
                                                    <label class="block mb-2 text-[15px] font-medium text-gray-200">Postcode</label>
                                                    <input type="text" name="postcode"
                                                        value="{{ old('postcode', $user->current_profile?->postcode) }}"
                                                        class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 
                                                        rounded-[14px] w-full px-4 py-3"
                                                        placeholder="NRIC" required />
                                                </div>
                                            </div>

                                            <!-- Password -->
                                            <div class="col-span-12 lg:col-span-6">
                                                <div class="w-full">
                                                    <label class="block mb-2 text-[15px] font-medium text-gray-200">Password</label>
                                                    <input type="password" name="password"
                                                        class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 
                                                        rounded-[14px] w-full px-4 py-3"
                                                        placeholder="Leave blank if not changing" />
                                                </div>
                                            </div>

                                            <!-- Language -->
                                            <div class="col-span-12 lg:col-span-6">
                                                <div class="w-full">
                                                    <label class="block mb-2 text-[15px] font-medium text-gray-200">Preferred language</label>
                                                    <div class="relative">
                                                        <select name="language"
                                                            class="appearance-none pr-10 bg-gray-1000 border border-gray-950 text-gray-75 
                                                            placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3">
                                                            <option value="">Choose</option>
                                                            <option value="English"
                                                                {{ old('language', $user->current_profile?->language) == 'English' ? 'selected' : '' }}>
                                                                English</option>
                                                            <option value="Bahasa"
                                                                {{ old('language', $user->current_profile?->language) == 'Bahasa' ? 'selected' : '' }}>
                                                                Bahasa</option>
                                                        </select>
                                                        <div
                                                            class="pointer-events-none absolute right-5 top-1/2 transform -translate-y-1/2 text-white">
                                                            <img src="/frontend/assets/icons/angle-down.svg" alt="Icon">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Save Button -->
                                            <div class="col-span-12 lg:col-span-6 flex items-end">
                                                <button type="submit"
                                                    class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-8 py-3 w-full lg:w-auto">
                                                    <span class="text-black text-[16px] font-semibold">Save Change</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <!-- SUBJECT ENROLLMENT -->
                <div class="w-full pt-10">
                    <div class="grid grid-cols-12">
                        <div class="col-span-12 md:col-span-12 lg:col-span-12">
                            <!-- HEADING -->
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/frontend/assets/icons/books.svg" alt="Icon" class="size-6" />
                                <h6 class="text-[20px] text-gray-75 font-semibold">
                                    Subjects Enrolled
                                </h6>
                            </div>
                            <!-- CONTENT -->
                            <div class="grid grid-cols-12 gap-5">
                                <div class="col-span-12 lg:col-span-7">
                                    <div class="h-[60vh] lg:h-[90vh] overflow-y-auto bg-gray-975 rounded-[21px]">
                                        <div class="flex flex-col gap-5 p-10">
                                            @forelse($subscriptions->where('status', 'paid') as $item)
                                                <div class="flex flex-col border-b border-gray-510 pb-5">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div class="flex flex-col">
                                                            <span class="text-white text-[15px] font-bold">{{ $item->liveClass->subject->name ?? 'Unknown Subject' }}</span>
                                                            <span class="text-gray-75 text-[12px]">{{ $item->plan->name }}</span>
                                                        </div>
                                                        <span class="w-[150px] inline-flex items-center justify-center bg-green-900 text-green-100 px-2 py-2 font-medium rounded-full">
                                                            @if ($item->status === 'paid')
                                                                Active
                                                            @endif
                                                        </span>
                                                    </div>

                                                    <div class="flex gap-3 mb-5">
                                                        <span class="text-gray-275">Tutor:</span>
                                                        <span class="text-white">{{ $item->liveClass->user->current_profile->name ?? '-' }}</span>
                                                    </div>

                                                    <div class="flex justify-between items-center">
                                                        <div>
                                                            <div class="flex items-center gap-8 mb-2">
                                                                <div class="flex items-center gap-2">
                                                                    <img src="/frontend/assets/icons/calendar.svg" class="size-5" />
                                                                    <span class="text-gray-275 text-[15px]">Start Date:</span>
                                                                    <span class="text-white text-[15px]">{{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}</span>
                                                                </div>
                                                                <div class="flex items-center gap-2">
                                                                    <img src="/frontend/assets/icons/calendar.svg" class="size-5" />
                                                                    <span class="text-gray-275 text-[15px]">Expired Date:</span>
                                                                    <span class="text-white text-[15px]">{{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <img src="/frontend/assets/icons/replay.svg" class="size-5" />
                                                                <span class="text-gray-275 text-[15px]">Replay Access:</span>
                                                                <span class="text-white text-[15px]">
                                                                    {{ \Carbon\Carbon::parse($item->start_date)->addDays(15)->format('d M') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-col items-end justify-end">
                                                            <span class="text-white text-[15px] mb-3">Progress: 65%</span>
                                                            <button type="button" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-5 py-3 w-[195px]">
                                                                <span class="text-black text-[16px] font-semibold">View More</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-gray-300">No active subscriptions found.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-5">
                                    <div class="h-[90vh] overflow-y-auto border-2 border-red-100 rounded-[21px]">
                                        <div class="flex flex-col gap-5 p-10 h-full">
                                            @forelse($subscriptions->where('status', 'expired') as $item)
                                                <div class="flex flex-col gap-5 pb-8 border-b border-gray-510">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex flex-col">
                                                            <span class="text-white text-[15px] font-bold">{{ $item->liveClass->subject->name ?? 'Unknown Subject' }}</span>
                                                            <span class="text-gray-75 text-[12px]">{{ $item->plan->name }}</span>
                                                        </div>
                                                        <span class="w-[150px] inline-flex items-center justify-center bg-red-900 px-2 py-2 font-medium text-red-100 rounded-full">
                                                            Expired
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <img src="/frontend/assets/icons/calendar.svg" class="size-5" />
                                                        <span class="text-gray-275 text-[15px]">Expired Date:</span>
                                                        <span class="text-white text-[15px]">{{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}</span>
                                                    </div>
                                                    <button type="button" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-5 py-3 w-full">
                                                        <span class="text-black text-[16px] font-semibold">Renew Now</span>
                                                    </button>
                                                </div>
                                            @empty
                                                <p class="text-gray-300">No expired subscriptions.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full pt-10">
                    <!-- HEADING -->
                    <div class="flex items-center gap-3 mb-6">
                        <img src="/frontend/assets/icons/books.svg" alt="Icon" class="size-6" />
                        <h6 class="text-[20px] text-gray-75 font-semibold">
                            Subscribe To New Subjects
                        </h6>
                    </div>
                    <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 pt-5 pb-20">
                        <!-- SINGLE -->
                        @forelse($classes as $class)
                        <a href="{{ route('user.subscription-type') }}">
                            <div class="w-full rounded-lg bg-gray-secondary">
                                <div class="relative">
                                    <div class="w-full h-48 rounded-lg overflow-hidden">
                                        <img src="/frontend/assets/images/person-card-example.png" alt=""
                                            class="w-full object-cover" />
                                        <div class="w-full absolute bottom-0 left-0 flex flex-col justify-end py-4 px-8">
                                            <h2 class="text-lg uppercase font-semibold font-bebas">
                                                {{ $class->topic->name }}
                                            </h2>
                                            <p class="text-xs">{{ $class->subject->name }} - {{ $class->grade->name }} ({{ $class->start_time->format('Y') }})</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="p-3 pb-7">
                                        <p class="text-white">{{ $class->user->current_profile?->name }}</p>
                                        <div class="flex items-center space-x-2">
                                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10.3944 2.41211H11.7088C12.4312 2.41211 13.0233 3.16802 13.0233 4.09192V12.7597C13.0233 13.6836 12.2674 14.4395 11.3435 14.4395H2.67987C1.75597 14.4395 1.00006 13.6836 1.00006 12.7597V4.09192C1.00006 3.16802 1.67618 2.41211 2.50349 2.41211H4.00692"
                                                    stroke="white" stroke-width="1.3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M9.25211 14.4387V12.2423C9.25211 11.3184 10.008 10.5625 10.9319 10.5625H13.0233"
                                                    stroke="white" stroke-width="1.3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M5.19531 2.41211H9.20586" stroke="white" stroke-width="1.3"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M1.00006 5.57422H13.0275" stroke="white" stroke-width="1.3"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M4.60418 1C4.93174 1 5.20051 1.26457 5.20051 1.59633V3.19635C5.20051 3.52391 4.93594 3.79268 4.60418 3.79268C4.27661 3.79268 4.00784 3.52811 4.00784 3.19635V1.59633C4.00784 1.26877 4.27241 1 4.60418 1Z"
                                                    stroke="white" stroke-width="1.3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M9.80144 3.78848C9.47388 3.78848 9.20511 3.52391 9.20511 3.19215V1.59633C9.20511 1.26877 9.46968 1 9.80144 1C10.129 1 10.3978 1.26457 10.3978 1.59633V3.19635C10.3978 3.52391 10.1332 3.79268 9.80144 3.79268V3.78848Z"
                                                    stroke="white" stroke-width="1.3" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M13.0288 10.5625L9.14847 14.4387" stroke="white" stroke-width="1.3"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M1.62803 5.99414H12.6034V10.3843H10.4083L9.15397 11.6386V14.1472H2.56878L1.31445 13.2065L1.62803 5.99414Z"
                                                    fill="white" stroke="white" />
                                            </svg>
                                            <span class="text-sm">{{ $class->start_time->format('M d') }} | 14 day replay</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1 bg-[#202020] rounded-b-lg p-3">
                                        <h1 class="text-lg">RM{{ $plan->price }}</h1>
                                        <span class="text-zinc-500">/ month</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @empty
                            <p class="text-gray-400">No subjects available at the moment.</p>
                        @endforelse
                        <div class="w-full flex flex-col justify-center items-center space-y-3">
                            <button class="w-12 h-12 flex justify-center items-center bg-white rounded-full">
                                <svg width="8" height="11" viewBox="0 0 5 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L4 4.5L1 8" stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                            <span class="text-sm">View More</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
<script>
    document.getElementById('avatar-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('avatar-preview');
                preview.innerHTML = `<img src="${event.target.result}" 
                    class="w-full h-full object-cover rounded-full" />`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
