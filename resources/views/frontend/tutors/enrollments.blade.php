@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto pb-10">
        <!-- HEADER -->
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
            <!-- LEFT SECTION -->
            <div class="flex items-center gap-3">
                <img src="/frontend/assets/images/student-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Tutor Dashboard</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">Students Subscription</h1>
                </div>
            </div>
            <!-- RIGHT SECTION - BREADCRUMB -->
            <div class="flex items-center gap-1 mb-3">
                <a href="{{ route('tutor.dashboard') }}" class="text-gray-400 text-[15px] font-medium hover:text-white">Home</a>
                <span class="text-gray-400 text-[15px] font-medium">></span>
                <span class="text-white text-[15px] font-medium">Students Subscription</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="space-y-10 pt-10">
            <!-- BACK -->
            <div class="flex items-center gap-10 mb-10">
                <a href="{{ url()->previous() }}"
                    class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                    <img src="/frontend/assets/icons/arrow-left.svg" alt="Icon" class="size-4">
                </a>
                <h6 class="text-[20px] text-gray-75 font-semibold">Students Subscription {{ $subject->name }}</h6>
            </div>

            <!-- STUDENT LIST -->
            <div class="w-full grid grid-cols-3 gap-8">
                <div class="col-span-3">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 mb-6">
                        <div class="flex flex-col">
                            <h6 class="text-[15px] text-gray-75 font-semibold">Students Lists</h6>
                            <span class="text-gray-400">{{ $subscriptions->total() }} Students</span>
                        </div>

                        <!-- SEARCH -->
                        <form method="GET" class="flex items-center w-full lg:w-[350px] bg-white border border-gray-280 rounded-full px-2 py-2">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-black text-white mr-3">
                                <img src="/frontend/assets/icons/search.svg" alt="Icon">
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="flex-1 bg-transparent text-gray-700 placeholder:text-[#A6A1A1] focus:outline-none"
                                placeholder="Search student name..." />
                        </form>
                    </div>
                </div>

                <div class="col-span-3">
                    <!-- START : TABLE -->
                    <div class="overflow-x-auto border border-[#424242] rounded-[12px] mb-10">
                        <table class="min-w-full border-collapse text-sm text-left">
                            <thead class="bg-gray-800 text-gray-200">
                                <tr>
                                    <th class="p-4 border border-[#424242]">No</th>
                                    <th class="p-4 border border-[#424242]">Student Name</th>
                                    <th class="p-4 border border-[#424242]">Subscription Plan</th>
                                    <th class="p-4 border border-[#424242]">Start Date</th>
                                    <th class="p-4 border border-[#424242]">End Date</th>
                                    <th class="p-4 border border-[#424242]">Status</th>
                                    <th class="p-4 border border-[#424242]">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-900 divide-y divide-[#424242] text-gray-50">
                                @forelse($subscriptions as $i => $sub)
                                    <tr class="hover:bg-gray-800">
                                        <td class="p-4 border border-gray-700">{{ $subscriptions->firstItem() + $i }}</td>
                                        <td class="p-4 border border-gray-700">{{ $sub->user->name }}</td>
                                        <td class="p-4 border border-gray-700">{{ $sub->plan_name ?? '-' }}</td>
                                        <td class="p-4 border border-gray-700">{{ $sub->start_date->format('d M Y') }}</td>
                                        <td class="p-4 border border-gray-700">{{ $sub->end_date->format('d M Y') }}</td>
                                        <td class="p-4 border border-gray-700">
                                            @if($sub->end_date->isFuture())
                                                @if($sub->end_date->diffInDays(now()) <= 7)
                                                    <span class="text-[#FDBA10]">Expiring Soon</span>
                                                @else
                                                    <span class="text-green-100">Active</span>
                                                @endif
                                            @else
                                                <span class="text-red-100">Expired</span>
                                            @endif
                                        </td>
                                        <td class="p-4 border border-gray-700">
                                            <a href="{{ route('tutor.subscription.show', $sub->id) }}"
                                                class="block bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-8 py-3 cursor-pointer w-full text-black text-[16px] font-semibold">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-6 text-center text-gray-400">
                                            No students enrolled yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- END : TABLE -->

                    <!-- PAGINATION -->
                    <div class="flex items-center justify-center lg:justify-end">
                        {{ $subscriptions->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
