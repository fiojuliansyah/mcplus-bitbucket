@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto">
        <!-- HEADER -->
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
            <div class="flex items-center gap-3">
                <img src="/frontend/assets/images/student-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Student</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">{{ $liveClass->title }}</h1>
                </div>
            </div>
            <div class="flex items-center gap-1 mb-3">
                <span class="text-gray-910 text-[15px] font-medium">Student Log</span>
                <span class="text-white text-[15px] font-medium">> My Subject</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="space-y-10 divide-y divide-zinc-700 pt-10">
            <!-- LIVE CLASS -->
            <div class="grid grid-cols-12 gap-10">
                <div class="col-span-12 lg:col-span-4">
                    <div class="flex items-center justify-between px-3 mb-4">
                        <span class="text-[15px] text-gray-250">Live Class</span>
                        <span class="text-[15px] text-gray-250">{{ ucfirst($liveClass->class_day) }} · {{ \Carbon\Carbon::parse($liveClass->start_time)->format('H:i') }}</span>
                    </div>
                    <div class="grid grid-cols-12 gap-5 border border-white rounded-[21px] p-5">
                        <div class="col-span-12 lg:col-span-5">
                            <div class="relative h-full lg:h-[170px] w-full lg:w-[140px] rounded-[13px]">
                                <img src="{{ $liveClass->image ?? '/frontend/assets/images/sample/image-1.png' }}" alt="Image" class="h-full w-full lg:w-[140px] rounded-[13px]">
                                <div class="absolute w-full flex items-center gap-1 rounded-b-[13px] bg-green-100 bottom-0 py-2 px-3">
                                    <img src="/frontend/assets/icons/clock.svg" alt="Icon" class="size-4">
                                    <span class="text-white text-[11px]">{{ \Carbon\Carbon::parse($liveClass->date)->format('d M') }} · {{ \Carbon\Carbon::parse($liveClass->start_time)->format('H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-7 flex flex-col justify-between">
                            <div class="flex flex-col mb-3">
                                <span class="text-white uppercase text-[13px] font-bebas">{{ $liveClass->subject->name ?? 'Subject' }}</span>
                                <span class="text-white uppercase text-[22px] font-bebas">{{ $liveClass->topic->name ?? 'Topic Name' }}</span>
                                <span class="text-white text-[15px]">{{ $liveClass->user->current_profile->name ?? 'Tutor Name' }}</span>
                            </div>
                            @if($notes->count())
                                <div class="flex flex-col gap-2 mt-3">
                                    @foreach($notes as $note)
                                        <a href="{{ asset('storage/' . $note->file_url) }}" target="_blank"
                                        class="hover:bg-white text-white hover:text-black border border-white rounded-full text-sm px-5 py-2 inline-block text-center">
                                            <span class="text-[16px] font-semibold">Download Notes</span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-300 mt-2 block">No notes available.</span>
                            @endif  
                        </div>
                    </div>

                    <a href="{{ $liveClass->zoom_join_url }}" target="_blank" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-5 py-3 w-full mt-5 inline-block text-center">
                        <span class="text-black text-[16px] font-semibold">Join Zoom</span>
                    </a>
                </div>

                <!-- CALENDAR -->
                <div class="col-span-12 lg:col-span-8">
                    <div class="grid grid-cols-12 gap-5 bg-gray-800 rounded-[21px] p-6">
                        <div class="col-span-12 lg:col-span-5">
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/frontend/assets/icons/calendar.svg" alt="Icon" class="size-6">
                                <h6 class="text-[20px] text-gray-100 font-semibold">Calendar</h6>
                            </div>
                            <div class="rounded-[21px] border border-black w-auto">
                                <div class="px-5 py-3 rounded-t-[21px] bg-black">
                                    <span class="text-white text-[15px]">Class Status</span>
                                </div>
                                <div class="grid grid-cols-12 p-5 gap-5">
                                    @php
                                        $statuses = ['Live'=>'green-100','Upcoming'=>'blue-200','Cancelled'=>'red-100','Combined'=>'purple-100','Replacement'=>'yellow-200','Relief'=>'white'];
                                    @endphp
                                    @foreach($statuses as $status => $color)
                                        <div class="col-span-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-5 h-5 bg-{{ $color }} rounded-full"></div>
                                                <span class="text-{{ $color }} text-[15px]">{{ $status }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 lg:col-span-7">
                            <!-- FILTER -->
                            <div class="flex justify-between gap-10 mb-5">
                                <div class="w-full flex items-center gap-5">
                                    <label class="block mb-2 text-[15px] font-medium text-gray-200 mb-1">Year:</label>
                                    <select id="yearSelect" class="appearance-none pr-10 bg-gray-1000 border border-gray-950 text-gray-75 rounded-[14px] w-full px-4 py-3"></select>
                                </div>
                                <div class="w-full flex items-center gap-5">
                                    <label class="block mb-2 text-[15px] font-medium text-gray-200 mb-1">Month:</label>
                                    <select id="monthSelect" class="appearance-none pr-10 bg-gray-1000 border border-gray-950 text-gray-75 rounded-[14px] w-full px-4 py-3">
                                        @foreach(range(1,12) as $m)
                                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('M') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="calendar" class="h-[13rem]"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- UPCOMING CLASSES -->
            <div class="pt-10">
                    <div class="grid grid-cols-12">
                        <div class="col-span-12 md:col-span-12 lg:col-span-12">
                            <!-- Title -->
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/frontend/assets/icons/upcoming-classes.svg" alt="Icon" class="size-6">
                                <h6 class="text-[20px] text-gray-75 font-semibold">Upcoming Class</h6>
                            </div>

                            <div class="grid grid-cols-12 gap-10">
                                <div class="col-span-12">
                                    <div class="flex flex-col lg:flex-row gap-5">
                                        @foreach ($upcomingClasses as $upcoming)
                                            <a href="upcoming-class-1.4.html" class="bg-gray-900 rounded-[21px] text-white">
                                                <div class="flex justify-center p-2">
                                                    <img src="/frontend/assets/images/sample/image-1.png" alt="Image"
                                                        class="w-full lg:w-[225px] h-full lg:h-[192px] rounded-[13px]">
                                                </div>
                                                <div class="px-4 py-3 flex flex-col">
                                                    <span class="text-gray-200 text-[12px]">{{ $upcoming->grade->name }} ({{ $upcoming->created_at->format('Y') }})</span>
                                                    <span class="text-white text-[15px]">{{ $upcoming->user->current_profile->name }}</span>
                                                </div>
                                                <div
                                                    class="w-full flex items-center gap-3 rounded-b-[21px] bg-blue-200 bottom-0 px-4 py-3">
                                                    <img src="/frontend/assets/icons/clock.svg" alt="Icon" class="size-4">
                                                    <span class="text-black text-[12px]">{{ \Carbon\Carbon::parse($upcoming->date)->format('d M') }} · {{ \Carbon\Carbon::parse($upcoming->date)->format('H:i') }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Navigation -->
                                <div class="col-span-12 flex items-center justify-center gap-10">
                                    <button
                                        class="bg-white rounded-full w-10 h-10 flex items-center justify-center cursor-pointer">
                                        <img src="/frontend/assets/icons/angle-left.svg" alt="Icon" class="size-3">
                                    </button>
                                    <button
                                        class="bg-white rounded-full w-10 h-10 flex items-center justify-center cursor-pointer">
                                        <img src="/frontend/assets/icons/angle-right.svg" alt="Icon" class="size-3">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- REPLAY CLASSES -->
           <div class="pt-10">
                <div class="grid grid-cols-12">
                    <div class="col-span-12">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 mb-6">
                            <!-- Title -->
                            <div class="flex items-center gap-3">
                                <img src="/frontend/assets/icons/slideshow.svg" alt="Icon" class="size-6">
                                <h6 class="text-[20px] text-gray-75 font-semibold">Replay Classes</h6>
                            </div>
                            <!-- Filter -->
                            <div class="flex flex-col lg:flex-row lg:items-center gap-5">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-end gap-3">
                                    <span class="text-gray-200">Filter By Subject:</span>
                                    <div class="w-full lg:w-[300px]">
                                        <select
                                            class="bg-gray-1000 border border-gray-950 text-white placeholder:text-gray-500 rounded-[14px] block w-full px-4 py-3">
                                            <option selected>Filter</option>
                                            <option value="" selected>All</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- SEARCH -->
                                <div
                                    class="flex items-center w-full lg:w-[350px] bg-white border border-gray-280 rounded-full px-2 py-2">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-black text-white mr-3">
                                        <img src="/frontend/assets/icons/search.svg" alt="Icon">
                                    </div>
                                    <input type="text"
                                        class="flex-1 bg-transparent text-gray-700 placeholder:text-[#A6A1A1] focus:outline-none"
                                        placeholder="Search" />
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-5">
                        @foreach ($replayClasses as $replay)  
                            <a href="#"
                                class="col-span-12 lg:col-span-2 bg-gray-900 rounded-[21px] text-white">
                                <div class="flex justify-center p-2">
                                    <img src="/frontend/assets/images/sample/image-1.png" alt="Image"
                                        class="w-full lg:w-[225px] h-full lg:h-[192px] rounded-[13px]">
                                </div>
                                <div class="px-4 py-3 flex flex-col">
                                    <span class="text-gray-200 text-[12px]">{{ $replay->grade->name }} ({{ $replay->created_at->format('Y') }})</span>
                                    <span class="text-white text-[15px]">Sir Fathi</span>
                                </div>
                                <div
                                    class="w-full flex items-center gap-3 rounded-b-[21px] bg-gray-800 bottom-0 p-4">
                                    <img src="/frontend/assets/icons/clock.svg" alt="Icon" class="size-4">
                                    <span class="text-white text-[12px]">{{ \Carbon\Carbon::parse($liveClass->start_date)->format('d M') }}</span>
                                </div>
                            </a>
                        @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.19/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.19/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const yearSelect = document.getElementById('yearSelect');
    const monthSelect = document.getElementById('monthSelect');

    // Set Year Options
    const currentYear = new Date().getFullYear();
    for (let y = currentYear - 5; y <= currentYear + 5; y++) {
        let opt = document.createElement("option");
        opt.value = y;
        opt.text = y;
        if (y === currentYear) opt.selected = true;
        yearSelect.add(opt);
    }

    monthSelect.value = new Date().getMonth() + 1;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: false,
        initialView: 'dayGridMonth',
        locale: 'id',
        editable: false,
        events: function(fetchInfo, successCallback, failureCallback) {
            let year = yearSelect.value || new Date().getFullYear();
            let month = monthSelect.value || (new Date().getMonth() + 1);

            fetch(`/student/live-classes/calendar?year=${year}&month=${month}`)
                .then(res => res.json())
                .then(data => successCallback(data))
                .catch(err => failureCallback(err));
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            if (info.event.url) {
                window.location.href = info.event.url;
            }
        },
    });

    calendar.render();

    yearSelect.addEventListener("change", updateCalendar);
    monthSelect.addEventListener("change", updateCalendar);

    function updateCalendar() {
        calendar.gotoDate(new Date(yearSelect.value, monthSelect.value - 1, 1));
        calendar.refetchEvents();
    }
});
</script>
@endpush
