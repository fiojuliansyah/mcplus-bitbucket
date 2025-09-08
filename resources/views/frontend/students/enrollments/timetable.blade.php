@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto">
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
            <div class="flex items-center gap-3">
                <img src="{{ asset('frontend/assets/images/student-profile-vector.svg') }}" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Student</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">Subject Enrollment</h1>
                </div>
            </div>
            <div class="flex items-center gap-1 mb-3">
                <span class="text-gray-910 text-[15px] font-medium">My Profile </span>
                <span class="text-white text-[15px font-medium]">> Subject Enrolment</span>
            </div>
        </div>

        <div class="space-y-10 divide-y divide-zinc-700">
            <div class="pt-10">
                <div class="grid grid-cols-12 gap-10 mb-10">
                    <div class="col-span-12">
                        <div class="flex flex-col lg:flex-row justify-between gap-10">
                            <div class="flex items-center gap-10">
                                <a href="{{ url()->previous() }}" class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                                    <img src="{{ asset('frontend/assets/icons/arrow-left.svg') }}" alt="Icon" class="size-4">
                                </a>
                                <div>
                                    <h6 class="text-[20px] text-gray-75 font-semibold">Review Your Timetable</h6>
                                    <span class="text-[#F2F2F2BF]">You can choose multiple tutors & groups as long as the timing doesn’t clash</span>
                                </div>
                            </div>
                            <div class="flex flex-col lg:items-end">
                                <div class="text-[#868484] mb-5">
                                    <span class="mr-10">Subjects: {{ count($subscription->subject_id) }}</span>
                                    <span>Classes: {{ $totalClasses }}</span>
                                </div>
                                <a href="{{ route('user.enrollment.checkout', ['subscription' => $subscription->id]) }}"
                                class="block bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-5 py-3 w-full lg:w-[20rem] cursor-pointer">
                                    <span class="text-black text-[16px] font-semibold">Confirm & Proceed to Payment</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Hilangkan garis slot */
    .fc-col-header, 
    .fc-timegrid-slots td, 
    .fc-timegrid-slot {
        border: none !important;
    }

    /* Opsional: hilangkan garis hari */
    .fc-daygrid-day, 
    .fc-daygrid-body {
        border: none !important;
    }
</style>
@endpush


@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.19/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.19/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: false,
        initialView: 'timeGridWeek',
        timeZone: 'Asia/Jakarta',
        allDaySlot: false,
        hiddenDays: [0],
        slotMinTime: "07:00:00",
        slotMaxTime: "22:00:00",
        slotDuration: '00:30:00',
        events: {!! $events !!},
        eventContent: function(arg) {
            const { name, classes, group } = arg.event.extendedProps;
            return {
                html: `<div style="padding:0.4rem; font-size:0.75rem; line-height:1.2;">
                        <span style="font-weight:bold;">${classes}</span>
                        <br>
                        <br>
                        <span>${name}</span>
                        <br>
                        <br>
                        <span>${group}</span>
                       </div>`
            }
        }
    });

    calendar.render();
});
</script>
@endpush

