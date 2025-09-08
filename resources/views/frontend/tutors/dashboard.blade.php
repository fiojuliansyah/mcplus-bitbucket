@extends('frontend.layouts.app')

@section('content')
    <section class="w-full bg-primary text-white px-4 py-10">
        <div class="w-full max-w-screen-xl mx-auto">
            <!-- HEADER -->
            <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
                <!-- LEFT SECTION -->
                <div class="flex items-center gap-3">
                    <img src="/frontend/assets/images/tutor-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
                    <div>
                        <span class="text-gray-250">Tutor Dashboard</span>
                        <h1 class="text-4xl font-bold tracking-tight text-white">Welcome Back!</h1>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="space-y-10 divide-y divide-zinc-700">
                <!-- MY SUBJECT -->
                <div class="pt-10">
                    <!-- HEADING -->
                    <div class="flex items-center gap-3 mb-6">
                        <img src="/frontend/assets/icons/books.svg" alt="Icon" class="size-6">
                        <h6 class="text-[20px] text-gray-75 font-semibold">My Subject</h6>
                    </div>
                    <div class="flex flex-col lg:flex-row lg:items-center gap-5 mb-10">
                        <form method="GET" action="{{ route('tutor.dashboard') }}"
                            class="flex flex-col lg:flex-row lg:items-center gap-5 w-full">
                            <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                                <div class="text-gray-200 w-[120px]">Subject Name:</div>
                                <div class="w-full lg:w-[300px]">
                                    <select name="subject_id" required
                                        class="bg-gray-1000 border border-gray-950 text-white placeholder:text-gray-500 rounded-[14px] block w-full lg:w-[250px] px-4 py-3"
                                        onchange="this.form.submit()">
                                        <option value="" disabled {{ request('subject_id') ? '' : 'selected' }}>Select Subject</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }} - {{ $subject->grade->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if (request('subject_id'))
                            <a href="{{ route('tutor.schedule.create', ['subjectSlug' => $selectedSubject->slug]) }}"
                                class="bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-5 py-3 cursor-pointer w-full lg:w-[300px]">
                                    <span class="text-black text-[16px] font-semibold">Schedule New Class</span>
                                </a>
                            @else

                            @endif
                        </form>
                    </div>

                    @if (request('subject_id'))
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-2">
                            <img src="/frontend/assets/icons/slideshow.svg" alt="Icon" class="size-6">
                            <h6 class="text-[20px] text-gray-75 font-semibold">My Class</h6>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-10">
                        <div class="col-span-12 lg:col-span-7">
                            <div class="grid grid-cols-12 gap-5 bg-gray-800 rounded-[21px] p-6 h-full">
                                <div class="col-span-12 lg:col-span-5">
                                    <div class="flex items-center gap-3 mb-6">
                                        <img src="/frontend/assets/icons/calendar.svg" alt="Icon" class="size-6">
                                        <h6 class="text-[20px] text-gray-100 font-semibold">Class Calendar</h6>
                                    </div>

                                    <div class="rounded-[21px] border border-black w-auto">
                                        <div class="px-5 py-3 rounded-t-[21px] bg-black">
                                            <span class="text-white text-[15px]">Class Status</span>
                                        </div>
                                        <div class="grid grid-cols-12 p-5 gap-5">
                                            <div class="col-span-6">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-5 h-5 bg-green-100 rounded-full"></div>
                                                    <span class="text-green-100 text-[15px]">Live</span>
                                                </div>
                                            </div>
                                            <div class="col-span-6">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-5 h-5 bg-blue-200 rounded-full"></div>
                                                    <span class="text-blue-200 text-[15px]">Upcoming</span>
                                                </div>
                                            </div>
                                            <div class="col-span-6">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-5 h-5 bg-white rounded-full"></div>
                                                    <span class="text-white text-[15px]">Completed</span>
                                                </div>
                                            </div>
                                            <div class="col-span-6">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-5 h-5 bg-red-100 rounded-full"></div>
                                                    <span class="text-red-100 text-[15px]">Cancelled</span>
                                                </div>
                                            </div>
                                            <div class="col-span-6">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-5 h-5 bg-[#424242] rounded-full"></div>
                                                    <span class="text-[#424242] text-[15px]">No Class</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-7">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-5">
                            <div>
                                <div class="flex items-center justify-between mb-5">
                                    <span class="text-white font-semibold">Class Details ({{ $upcomingClasses->count() }} Upcoming)</span>
                                    <span class="text-gray-400">{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
                                </div>
                                @forelse ($upcomingClasses as $class)
                                    <div class="flex flex-col border-b border-white/10 pb-5 mb-5">
                                        <div>
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center gap-3">
                                                    <span class="font-semibold">{{ $class->subject->name }}</span>
                                                    @php
                                                        $status = strtolower(trim($class->status));
                                                        if ($status === 'live' || $status === 'approved') { $statusText = 'Live'; $statusClass = 'bg-green-100 text-black'; }
                                                        elseif ($status === 'upcoming' || $status === 'scheduled') { $statusText = 'Upcoming'; $statusClass = 'bg-blue-200 text-black'; }
                                                        elseif ($status === 'completed') { $statusText = 'Completed'; $statusClass = 'bg-white text-black'; }
                                                        elseif ($status === 'cancelled') { $statusText = 'Cancelled'; $statusClass = 'bg-red-100 text-white'; }
                                                        else { $statusText = 'Draft'; $statusClass = 'bg-gray-500 text-white'; }
                                                    @endphp
                                                    <span class="w-[120px] inline-flex items-center justify-center px-2 py-1 font-medium rounded-full text-sm {{ $statusClass }}">{{ $statusText }}</span>
                                                </div>
                                                <span class="text-gray-300">{{ $class->subject->grade->name }}</span>
                                            </div>
                                            <div class="w-full flex items-center gap-3 mb-3">
                                                <img src="/frontend/assets/icons/clock.svg" alt="Icon" class="size-4">
                                                <span class="text-gray-200 text-[13px]">{{ \Carbon\Carbon::parse($class->start_time)->format('d M Y · h:i A') }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="truncate pr-4">Topic: {{ $class->topic->name }}</span>
                                                <div class="flex items-center gap-2 flex-shrink-0">
                                                    <a href="{{ route('tutor.live-classes.edit', $class->id) }}" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-5 py-3 cursor-pointer w-auto text-center">
                                                        <span class="text-black text-[16px] font-semibold">Edit</span>
                                                    </a>
                                                    {{-- Tombol ini sekarang memicu modal --}}
                                                    <button type="button" class="delete-button bg-red-500 hover:bg-red-600 text-white rounded-full text-sm px-5 py-3 cursor-pointer w-auto text-center"
                                                            data-action="{{ route('tutor.live-classes.destroy', $class->id) }}">
                                                        <span class="text-[16px] font-semibold">Delete</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10 text-gray-400">
                                        <p>No classes scheduled yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @else
                    
                    @endif
                </div>

                @if (request('subject_id'))
                <div class="w-full pt-10 space-y-10">
                    <section>
                        <!-- HEADING -->
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="/frontend/assets/icons/calendar.svg" alt="Icon" class="size-6">
                                <h6 class="text-[20px] text-gray-75 font-semibold">Manage Class</h6>
                            </div>
                            <span class="text-gray-910 text-[15px]">Choose an action to begin</span>
                        </div>
                        <!-- CONTENT -->
                        <div class="grid grid-cols-12 gap-10 bg-gray-990 rounded-[21px] p-8">
                            <!-- Item -->
                            <div class="col-span-12 lg:col-span-4">
                                <a href="{{ route('tutor.replay-classes.create', ['subjectSlug' => $selectedSubject->slug]) }}"
                                    class="bg-gray-700 rounded-[21px] p-5 flex flex-col items-center gap-5 shadow-1">
                                    <div
                                        class="bg-gray-50 rounded-full w-[92px] h-[92px] flex items-center justify-center">
                                        <img src="/frontend/assets/icons/video-upload.svg" alt="Icon"
                                            class="size-10 text-black">
                                    </div>
                                    <span class="text-white">Upload Replay Video</span>
                                </a>
                            </div>
                            <div class="col-span-12 lg:col-span-4">
                                <a href="{{ route('tutor.notes.create', ['subjectSlug' => $selectedSubject->slug]) }}"
                                    class="bg-gray-700 rounded-[21px] p-5 flex flex-col items-center gap-5 shadow-1">
                                    <div
                                        class="bg-gray-50 rounded-full w-[92px] h-[92px] flex items-center justify-center">
                                        <img src="/frontend/assets/icons/archive.svg" alt="Icon" class="size-10 text-black">
                                    </div>
                                    <span class="text-white">Upload Study Notes And Reference Materials</span>
                                </a>
                            </div>
                            <div class="col-span-12 lg:col-span-4">
                                <a href="{{ route('tutor.quizzes.create', ['subjectSlug' => $selectedSubject->slug]) }}"
                                    class="bg-gray-700 rounded-[21px] p-5 flex flex-col items-center gap-5 shadow-1">
                                    <div
                                        class="bg-gray-50 rounded-full w-[92px] h-[92px] flex items-center justify-center">
                                        <img src="/frontend/assets/icons/notification.svg" alt="Icon"
                                            class="size-10 text-black">
                                    </div>
                                    <span class="text-white">Create Quizzes</span>
                                </a>
                            </div>
                            <div class="col-span-12">
                                <a href="{{ route('tutor.all-classes', ['subjectSlug' => $selectedSubject->slug]) }}"
                                    class="block bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-5 py-3 w-full cursor-pointer">
                                    <span class="text-black text-[16px] font-semibold">View All Classes</span>
                                </a>
                            </div>
                        </div>
                    </section>

                    <section class="w-full py-10">
                        <div class="grid grid-cols-12 gap-10">
                            <div class="col-span-12 lg:col-span-6">
                                <div class="rounded-[21px] border border-white h-full">
                                    <div class="rounded-t-[21px] bg-[#2C2C2C] p-5 text-center">
                                        <span>Students Performance Overview</span>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex items-center justify-between py-6 px-5">
                                            <div class="flex flex-col">
                                                <span class="text-gray-200">Average Quiz Score:</span>
                                                <span class="text-[#EAEAEA]">78%</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-gray-200">Average Attendance:</span>
                                                <span class="text-[#EAEAEA]">78%</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-gray-200">Replay Views:</span>
                                                <span class="text-[#EAEAEA]">78%</span>
                                            </div>
                                        </div>
                                        <a href="student-performance-1.2.html"
                                            class="block bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-5 py-3 w-full cursor-pointer">
                                            <span class="text-black text-[16px] font-semibold">View Detailed
                                                Report</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 lg:col-span-6">
                                <div class="rounded-[21px] border border-white">
                                    <div class="rounded-t-[21px] bg-[#2C2C2C] p-5 text-center">
                                        <span>Students Subscription Overview</span>
                                    </div>
                                    <div class="grid grid-cols-12 gap-5 p-4">
                                        <div class="col-span-5 border-r border-white/10">
                                            <div class="flex flex-col items-center justify-center text-center px-5 p-4">
                                                <span class="text-white">Total Students Enrolled</span>
                                                <span class="text-white text-[60px]">{{ $subscriptionStats['total'] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-span-7">
                                            <div class="flex flex-col justify-between h-full">
                                                <div class="flex items-center justify-between py-6 px-5">
                                                    <div class="flex flex-col">
                                                        <span class="text-gray-200">Active:</span>
                                                        <span class="text-green-100">{{ $subscriptionStats['active'] }}</span>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span class="text-gray-200">Expired:</span>
                                                        <span class="text-red-100">{{ $subscriptionStats['expired'] }}</span>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span class="text-gray-200">Expiring Soon:</span>
                                                        <span class="text-[#FDBA10]">{{ $subscriptionStats['expiring_soon'] }}</span>
                                                    </div>
                                                </div>
                                                <a href="{{ route('tutor.subscriptions', ['subjectSlug' => $selectedSubject->slug]) }}"
                                                    class="block bg-gray-50 hover:bg-gray-200 rounded-full text-center text-center text-sm px-5 py-3 w-full cursor-pointer">
                                                    <span class="text-black text-[16px] font-semibold">View Enrolment List</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                @else

                @endif
            </div>
        </div>
    </section>
    <form id="deleteForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="bg-gray-800 rounded-2xl shadow-xl w-full max-w-md mx-4 p-6 text-white border border-gray-700">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-900 border border-red-700">
                    <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                </div>
                <h3 class="mt-5 text-lg font-semibold leading-6" id="modal-title">Delete Class</h3>
                <div class="mt-2"><p class="text-sm text-gray-400">Are you sure you want to delete this class? This action cannot be undone.</p></div>
            </div>
            <div class="mt-6 flex justify-center gap-4">
                <button type="button" id="cancelButton" class="rounded-full bg-gray-700 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600">Cancel</button>
                <button type="button" id="confirmDeleteButton" class="rounded-full bg-red-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Confirm Delete</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .vanilla-calendar-day__popup-dot {
        width: 8px !important;
        height: 8px !important;
        border-radius: 50%;
    }

    .vanilla-calendar-day__popup-dot.dot.status-live { background-color: #4caf50 !important; }
    .vanilla-calendar-day__popup-dot.dot.status-upcoming { background-color: #00bcd4 !important; }
    .vanilla-calendar-day__popup-dot.dot.status-cancelled { background-color: #f44336 !important; }
    .vanilla-calendar-day__popup-dot.dot.status-completed { background-color: #9E9E9E !important; }
    .vanilla-calendar-day__popup-dot.dot.status-draft { background-color: #FFC107 !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const confirmDeleteButton = document.getElementById('confirmDeleteButton');
    const cancelButton = document.getElementById('cancelButton');
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const actionUrl = this.getAttribute('data-action');
            deleteForm.setAttribute('action', actionUrl);
            deleteModal.classList.remove('hidden');
        });
    });

    cancelButton.addEventListener('click', () => {
        deleteModal.classList.add('hidden');
    });

    deleteModal.addEventListener('click', (event) => {
        if (event.target === deleteModal) {
            deleteModal.classList.add('hidden');
        }
    });

    confirmDeleteButton.addEventListener('click', () => {
        deleteForm.submit();
    });

    const classEvents = @json($calendarEvents);
    const classPopups = {};
    Object.entries(classEvents).forEach(([date, status]) => {
        classPopups[date] = {
            modifier: `dot status-${status}`,
            html: `Ada kelas dengan status: ${status}`,
        };
    });

    const { Calendar } = window.VanillaCalendarPro;
    const calendar = new Calendar('#calendar', {
        type: 'default',
        settings: {
            popups: classPopups,
        },
        actions: {
            clickDay: (event, self) => {
                const clickedDate = self.selectedDates[0];
                if (classPopups[clickedDate]) {
                    console.log(`Detail untuk tanggal ${clickedDate}:`, classPopups[clickedDate]);
                }
            },
        },
    });
    calendar.init();
});
</script>
@endpush
