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
                    <h1 class="text-4xl font-bold tracking-tight text-white">Class Details</h1>
                </div>
            </div>
            <!-- RIGHT SECTION - BREADCRUMB -->
            <div class="flex items-center gap-1 mb-3">
                <a href="{{ route('tutor.dashboard') }}" class="text-gray-400 text-[15px] font-medium hover:text-white">Home</a>
                <span class="text-gray-400 text-[15px] font-medium">></span>
                <a href="{{ route('tutor.all-classes') }}" class="text-gray-400 text-[15px] font-medium hover:text-white">All Classes</a>
                <span class="text-white text-[15px] font-medium">> View Class</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="space-y-10 pt-10">
            <!-- CLASS SUMMARY -->
            <div class="grid grid-cols-12">
                <div class="col-span-12 flex items-center gap-10 mb-10">
                    <a href="{{ route('tutor.all-classes') }}" class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer flex-shrink-0">
                        <img src="{{ asset('frontend/assets/icons/arrow-left.svg') }}" alt="Icon" class="size-4">
                    </a>
                    <h6 class="text-[20px] text-gray-75 font-semibold">View Class</h6>
                </div>
                <div class="col-span-12">
                    <div class="border border-gray-700 rounded-[21px] p-5 flex flex-col lg:flex-row items-center gap-5 shadow-1">
                        <div class="bg-gray-50 rounded-full w-[109px] h-[109px] flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('frontend/assets/icons/presentation.svg') }}" alt="Icon" class="w-10 text-black">
                        </div>
                        <div class="flex flex-col justify-between h-full w-full">
                            <div class="flex flex-col mb-5 text-center lg:text-left">
                                <span class="text-gray-200">Class Name</span>
                                <span class="text-white text-xl font-semibold">{{ $subject->name }}</span>
                            </div>
                            <div class="flex items-center justify-center lg:justify-start py-2 px-6 bg-[#181818] rounded-[13px]">
                                <span class="font-bebas">{{ $subject->grade->name }}</span>
                                <div class="text-[#4C4C4C] px-8">
                                    Total Students: {{ $subject->users_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOPIC LIST -->
            <div class="w-full pt-10">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 mb-8">
                    <div class="flex flex-col">
                        <h6 class="text-[15px] text-gray-75 font-semibold">Topic Lists</h6>
                        <span class="text-gray-400">{{ $subject->topics->count() }} Topics</span>
                    </div>
                </div>

                <!-- START : TABLE -->
                <div class="overflow-x-auto border border-[#424242] rounded-[12px] mb-10">
                    <table class="min-w-full border-collapse text-sm text-left">
                        <thead class="bg-gray-800 text-gray-200">
                            <tr>
                                <th class="p-4 border-b border-[#424242]">No</th>
                                <th class="p-4 border-b border-[#424242]">Topic</th>
                                <th class="p-4 border-b border-[#424242]">Replay Video Upload</th>
                                <th class="p-4 border-b border-[#424242]">Notes Upload</th>
                                <th class="p-4 border-b border-[#424242]">Quiz Upload</th>
                                <th class="p-4 border-b border-[#424242]">Live Schedule URL</th>
                                <th class="p-4 border-b border-[#424242]">Schedule Date | Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-900 divide-y divide-[#424242] text-gray-50">
                            @php $counter = 1; @endphp
                            @forelse ($subject->topics as $topic)
                                <tr class="hover:bg-gray-800">
                                    <td class="p-4">{{ $counter++ }}</td>
                                    <td class="p-4 font-semibold">{{ $topic->name }}</td>

                                    {{-- Replay Video (ambil tanggal upload terakhir atau kosong) --}}
                                    <td class="p-4">
                                        @if($topic->replayClasses->isNotEmpty())
                                            {{ $topic->replayClasses->last()->created_at->format('d M Y, H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Notes --}}
                                    <td class="p-4">
                                        @if($topic->notes->isNotEmpty())
                                            {{ $topic->notes->last()->created_at->format('d M Y, H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Quiz --}}
                                    <td class="p-4">
                                        @if($topic->quizzes->isNotEmpty())
                                            {{ $topic->quizzes->last()->created_at->format('d M Y, H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Live Class URL --}}
                                    <td class="p-4 truncate max-w-xs">
                                        @if($topic->liveClasses->isNotEmpty() && $topic->liveClasses->last()->zoom_join_url)
                                            <a href="{{ $topic->liveClasses->last()->zoom_join_url }}" target="_blank" class="text-cyan-400 hover:underline">
                                                {{ $topic->liveClasses->last()->zoom_join_url }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    {{-- Live Schedule Date --}}
                                    <td class="p-4">
                                        @if($topic->liveClasses->isNotEmpty())
                                            {{ $topic->liveClasses->last()->start_time->format('d M Y, H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400">
                                        This class doesn't have any topics yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- END : TABLE -->
            </div>
        </div>
    </div>
</section>
@endsection 