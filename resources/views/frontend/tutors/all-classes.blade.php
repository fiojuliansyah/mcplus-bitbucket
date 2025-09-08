@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto pb-10">
        <!-- HEADER -->
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10 pb-5">
            <!-- LEFT SECTION -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('frontend/assets/images/student-profile-vector.svg') }}" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Tutor Dashboard</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">Manage Classes</h1>
                </div>
            </div>
            <!-- RIGHT SECTION - BREADCRUMB -->
            <div class="flex items-center gap-1 mb-3">
                <a href="{{ route('tutor.dashboard') }}" class="text-gray-400 text-[15px] font-medium hover:text-white">Home</a>
                <span class="text-white text-[15px] font-medium">> All Classes</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="space-y-10 divide-y divide-zinc-700">
            <!-- FILTER SECTION -->
            <div class="pt-10">
                <form action="{{ url()->current() }}" method="GET" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-end">
                    <div class="col-span-3 flex items-center gap-10 mb-5">
                        <a href="{{ url()->previous() }}" class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer flex-shrink-0">
                            <img src="{{ asset('frontend/assets/icons/arrow-left.svg') }}" alt="Icon" class="size-4">
                        </a>
                        <h6 class="text-[20px] text-gray-75 font-semibold">
                            @if($selectedSubject)
                                Class Details: {{ $selectedSubject->name }}
                            @else
                                All Classes
                            @endif
                        </h6>
                    </div>

                    <div class="col-span-3 lg:col-span-1">
                         <label for="grade_id" class="block mb-2 text-[15px] font-medium text-gray-200">Filter by Form</label>
                         <div class="relative">
                             <select name="grade_id" id="grade_id" class="appearance-none pr-10 bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3">
                                 <option value="">All Forms</option>
                                 @foreach($grades as $grade)
                                     <option value="{{ $grade->id }}" @selected(request('grade_id') == $grade->id)>
                                         {{ $grade->name }}
                                     </option>
                                 @endforeach
                             </select>
                             <div class="pointer-events-none absolute right-5 top-1/2 transform -translate-y-1/2 text-white">
                                 <img src="{{ asset('frontend/assets/icons/angle-down.svg') }}" alt="Icon">
                             </div>
                         </div>
                    </div>
                    <div class="col-span-3 lg:col-span-2 flex items-end">
                        <button type="submit" class="bg-gray-50 hover:bg-gray-200 text-black font-semibold rounded-full px-8 py-3 w-full lg:w-auto">Apply Filter</button>
                    </div>
                </form>
            </div>

            <!-- CLASS LIST -->
            <div class="w-full pt-10">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 mb-8">
                    <div class="flex flex-col">
                        <h6 class="text-[15px] text-gray-75 font-semibold">Classes Lists</h6>
                        <span class="text-gray-400">{{ $subjects->total() }} Classes Found</span>
                    </div>
                    <!-- SEARCH FORM -->
                     @if(!$selectedSubject)
                    <form action="{{ url()->current() }}" method="GET" class="flex items-center w-full lg:w-[350px] bg-white border border-gray-280 rounded-full px-2 py-2">
                        <input type="hidden" name="grade_id" value="{{ request('grade_id') }}">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-black text-white mr-3">
                            <img src="{{ asset('frontend/assets/icons/search.svg') }}" alt="Icon">
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="flex-1 bg-transparent text-gray-700 placeholder:text-[#A6A1A1] focus:outline-none" placeholder="Search by class name..." />
                    </form>
                    @endif
                </div>

                <!-- START : TABLE -->
                <div class="overflow-x-auto border border-[#424242] rounded-[12px] mb-10">
                    <table class="min-w-full border-collapse text-sm text-left">
                        <thead class="bg-gray-800 text-gray-200">
                            <tr>
                                <th class="p-4 border-b border-[#424242]">No</th>
                                <th class="p-4 border-b border-[#424242]">Class Name</th>
                                <th class="p-4 border-b border-[#424242]">Form</th>
                                <th class="p-4 border-b border-[#424242]">Total Students</th>
                                <th class="p-4 border-b border-[#424242]">Latest Topic</th>
                                <th class="p-4 border-b border-[#424242]">Live Schedule URL</th>
                                <th class="p-4 border-b border-[#424242]">Replay Upload</th>
                                <th class="p-4 border-b border-[#424242]">Notes Upload</th>
                                <th class="p-4 border-b border-[#424242]">Quiz Upload</th>
                                <th class="p-4 border-b border-[#424242]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-900 divide-y divide-[#424242] text-gray-50">
                            @forelse ($subjects as $subject)
                            <tr class="hover:bg-gray-800">
                                <td class="p-4">{{ $subjects->firstItem() + $loop->index }}</td>
                                <td class="p-4 font-semibold">{{ $subject->name }}</td>
                                <td class="p-4">{{ $subject->grade->name }}</td>
                                <td class="p-4">{{ $subject->users->count() }}</td>
                                <td class="p-4">{{ $subject->latestTopic?->name ?? 'N/A' }}</td>
                                <td class="p-4 truncate max-w-xs">
                                    @if($subject->latestLiveClass?->zoom_join_url)
                                        <a href="{{ $subject->latestLiveClass->zoom_join_url }}" target="_blank" class="text-cyan-400 hover:underline">
                                            {{ $subject->latestLiveClass->zoom_join_url }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="p-4">{{ $subject->latestReplay?->created_at?->format('d M Y') ?? 'N/A' }}</td>
                                <td class="p-4">{{ $subject->latestNote?->created_at?->format('d M Y') ?? 'N/A' }}</td>
                                <td class="p-4">{{ $subject->latestQuizz?->created_at?->format('d M Y') ?? 'N/A' }}</td>
                                <td class="p-4">
                                    <a href="{{ route('tutor.classes.show', ['subjectSlug' => $subject->slug]) }}" class="block bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-6 py-2 cursor-pointer w-full text-black font-semibold">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="p-8 text-center text-gray-400">
                                    No classes found matching your criteria.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- END : TABLE -->
                
                <!-- START : TABLE PAGINATION -->
                @if ($subjects->hasPages())
                <div class="pt-4">
                    {{ $subjects->appends(request()->query())->links('vendor.pagination.tailwind') }}
                </div>
                @endif
                <!-- END : TABLE PAGINATION -->
            </div>
        </div>
    </div>
</section>
@endsection