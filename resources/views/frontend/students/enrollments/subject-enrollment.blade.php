@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto">
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
            <div class="flex items-center gap-3">
                <img src="/frontend/assets/images/student-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
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
                        <div class="flex items-center gap-10">
                            <a href="#" class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                                <img src="/frontend/assets/icons/arrow-left.svg" alt="Icon" class="size-4">
                            </a>
                            <h6 class="text-[20px] text-gray-75 font-semibold">Normal Class</h6>
                        </div>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 gap-10">
                        <div class="col-span-12 lg:col-span-8">
                            <div class="bg-gray-990 rounded-[21px] py-5 px-8">
                                <div class="flex items-end mb-3">
                                    <h6 class="text-[15px] text-purple-100 font-bold">Important Notes</h6>
                                </div>
                                <div class="flex flex-col mb-3">
                                    <span class="text-white font-bold">What is “Join Waitlist”?</span>
                                    <p class="text-[#494949] text-[12px]">
                                        If a class is full, you can still enrol by joining the waitlist.
                                        You'll be added automatically when a slot becomes available.
                                    </p>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-white font-bold">Joining Late? No Problem! (Pro Rated)</span>
                                    <p class="text-[#494949] text-[12px]">
                                        Even if you join halfway (Pro Rated), you’ll still get full access to all
                                        video recordings, notes, and learning materials from earlier classes.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-span-12 lg:col-span-4">
                            <div class="bg-gray-990 rounded-[21px] py-5 px-8 h-full">
                                <h6 class="text-[15px] text-purple-100 font-bold mb-5">Your Subscription Includes:</h6>
                                <div id="subscription-features" class="grid grid-cols-12 gap-5">
                                    <div class="col-span-6 flex items-center gap-5 hidden" data-feature="live_classes">
                                        <img src="/frontend/assets/icons/play.svg" alt="Icon" class="size-5">
                                        <span class="text-white text-[9px]">Weekly Live Classes</span>
                                    </div>
                                    <div class="col-span-6 flex items-center gap-5 hidden" data-feature="materials">
                                        <img src="/frontend/assets/icons/folder-solid.svg" alt="Icon" class="size-5">
                                        <span class="text-white text-[9px]">Notes And Materials</span>
                                    </div>
                                    <div class="col-span-6 flex items-center gap-5 hidden" data-feature="replay">
                                        <img src="/frontend/assets/icons/playback.svg" alt="Icon" class="size-5">
                                        <span id="replay-day-text" class="text-white text-[9px]"></span>
                                    </div>
                                    <div class="col-span-6 flex items-center gap-5 hidden" data-feature="quizzes">
                                        <img src="/frontend/assets/icons/quiz.svg" alt="Icon" class="size-5">
                                        <span class="text-white text-[9px]">Quizzes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('user.subject-enrollment.store') }}" method="POST">
                @csrf
                <div class="pt-10">
                    <div class="grid grid-cols-12 gap-10">
                        <div class="col-span-12 lg:col-span-8 pr-5 border-r border-[#1F1F1F]">
                            <section class="flex flex-col gap-5 mb-8">
                                <div class="flex gap-3">
                                    <span class="text-gray-100 font-semibold">Select Total Subjects</span>
                                    <span class="text-gray-250">How many live classes do you want weekly?</span>
                                </div>
                                <select id="total-classes" class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full lg:w-[50%] px-4 py-3">
                                    <option value="0" selected>Choose</option>
                                    <option value="1">1 Class</option>
                                    <option value="2">2 Classes</option>
                                    <option value="3">3 Classes</option>
                                    <option value="4">4 Classes</option>
                                </select>
                                <small id="subject-limit-info" class="text-gray-400 text-sm hidden">
                                    You can select up to <span id="limit-count">0</span> subjects.
                                </small>
                            </section>

                            <section class="flex flex-col gap-5 border-b border-[#1F1F1F] pb-10 mb-10">
                                <div class="flex gap-3">
                                    <span class="text-gray-100 font-semibold">Choose Your Plan</span>
                                    <span class="text-gray-250">How long do you want to subscribe?</span>
                                </div>
                                <div class="grid grid-cols-12 gap-8">
                                    @foreach ($plans as $plan)
                                        <div class="col-span-6 lg:col-span-4">
                                            <label class="flex items-center gap-3 bg-gray-925 text-white rounded-[15px] py-3 px-6 cursor-pointer">
                                                <input type="radio" name="plan_id" value="{{ $plan->id }}" 
                                                    data-price="{{ $plan->price }}" 
                                                    data-has-live-classes="{{ $plan->is_weekly_live_classes }}"
                                                    data-has-materials="{{ $plan->is_materials }}"
                                                    data-has-quizzes="{{ $plan->is_quizzes }}"
                                                    data-replay-day="{{ $plan->replay_day }}"
                                                    class="hidden peer plan-radio" required />
                                                <span class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-white peer-checked:bg-white">
                                                    <span class="w-3 h-3 rounded-full bg-black peer-checked:bg-black"></span>
                                                </span>
                                                <span class="text-base">{{ $plan->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </section>

                            <section class="flex flex-col gap-5 mb-5">
                                <div class="flex flex-col lg:flex-row gap-3">
                                    <span class="text-gray-100 font-semibold">Choose Subjects & Tutors</span>
                                    <span class="text-gray-250">You can choose multiple tutors & groups as long as the timing doesn’t clash</span>
                                </div>
                                <div class="grid grid-cols-12 gap-10">
                                    @foreach($liveClasses as $class)
                                        <div class="col-span-12 lg:col-span-4">
                                            <label class="block cursor-pointer">
                                                <input type="checkbox" name="live_classes[]" value="{{ $class->id }}" 
                                                    class="peer hidden class-checkbox"
                                                    data-tutor="{{ $class->user->current_profile->name ?? 'N/A' }}"
                                                    data-subject="{{ $class->subject->name ?? 'No Subject' }}"
                                                    data-schedule="{{ \Carbon\Carbon::parse($class->start_time)->format('D, h:i A') }}"
                                                    />

                                                <div class="bg-gray-900 rounded-[21px] text-white flex flex-col h-full transition">
                                                    <div class="relative w-full h-[200px] overflow-hidden rounded-t-[13px]">
                                                        <img src="/frontend/assets/images/sample/image-1.png" alt="Image" class="w-full h-full object-cover object-top">
                                                        <div class="absolute bottom-0 p-2 w-full">
                                                            <div class="flex items-center justify-between">
                                                                <span class="text-gray-75 text-[20px] font-bebas">{{ $class->subject->name ?? 'No Subject' }}</span>
                                                                <div class="flex flex-col items-end text-[12px]">
                                                                    <span>Students</span>
                                                                    <span>70 / 82</span>
                                                                </div>
                                                            </div>
                                                            <span
                                                                class="w-full inline-flex items-center justify-center bg-green-900 px-2 py-2 font-medium text-green-100 rounded-full">Available</span>
                                                        </div>
                                                        {{-- <div class="absolute bottom-0 p-2 w-full">
                                                            <span class="text-gray-75 text-[20px] font-bebas">{{ $class->subject->name ?? 'No Subject' }}</span>
                                                        </div> --}}
                                                    </div>
                                                    <div class="px-3 pt-4 pb-5 flex-1">
                                                        <span class="block text-[15px] text-gray-50">{{ $class->user->current_profile->name ?? 'N/A' }}</span>
                                                        <div class="flex items-center gap-2 text-sm text-gray-50 mt-1">
                                                            @php
                                                                $days = [
                                                                    'monday'    => 'Mon',
                                                                    'tuesday'   => 'Tue',
                                                                    'wednesday' => 'Wed',
                                                                    'thursday'  => 'Thu',
                                                                    'friday'    => 'Fri',
                                                                    'saturday'  => 'Sat',
                                                                    'sunday'    => 'Sun',
                                                                ];
                                                            @endphp

                                                            <div class="flex items-center gap-2 text-sm text-gray-50 mt-1">
                                                                <img src="/frontend/assets/icons/calendar.svg" alt="Icon" class="size-4">
                                                                <span class="text-gray-50">
                                                                    {{ $days[strtolower($class->class_day)] ?? $class->class_day }}, 
                                                                    {{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer w-full flex items-center justify-between rounded-b-[21px] bg-gray-300 text-white peer-checked:bg-white peer-checked:text-black py-4 px-3 transition-colors duration-200">
                                                        <span class="text-lg font-semibold class-price" data-base="0"></span>
                                                        <span class="w-6 h-6 flex items-center justify-center rounded-md border border-white bg-black transition relative">
                                                            <svg class="checkmark-svg hidden w-4 h-4 text-white peer-checked:block absolute" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        </div>

                        <div class="col-span-12 lg:col-span-4">
                            <div class="flex items-center justify-between gap-3 mb-6">
                                <h6 class="text-[20px] text-gray-75 font-semibold">Payment Details</h6>
                                <span class="text-gray-75">{{ now()->format('d M | D') }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3 border-b border-white mb-6 pb-5">
                                <span class="text-[#868484]">Subject Details</span>
                                <span id="classes-count" class="text-[#868484]">Classes: 0</span>
                            </div>
                            <div id="payment-details-list" class="flex flex-col gap-3 mb-5">
                                </div>
                            <div class="flex items-center justify-between bg-black rounded-[21px] text-gray-75 px-5 py-7 mb-5">
                                <span>Total</span>
                                <span id="total-price">RM0.00</span>
                            </div>
                            <button type="submit" class="block bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-5 py-3 w-full cursor-pointer">
                                <span class="text-black text-[16px] font-semibold">Continue</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const planRadios = document.querySelectorAll(".plan-radio");
    const totalClassesSelect = document.getElementById("total-classes");
    const totalPriceEl = document.getElementById("total-price");
    const classPriceEls = document.querySelectorAll(".class-price");
    const checkboxes = document.querySelectorAll(".class-checkbox");
    const subjectLimitInfo = document.getElementById('subject-limit-info');
    const limitCountSpan = document.getElementById('limit-count');
    const paymentDetailsList = document.getElementById('payment-details-list');
    const classesCountEl = document.getElementById('classes-count');

    let selectedPlanPrice = 0;
    let maxAllowed = 0;

    function updateSubscriptionFeatures(selectedRadio) {
        const features = {
            live_classes: selectedRadio.dataset.hasLiveClasses,
            materials: selectedRadio.dataset.hasMaterials,
            quizzes: selectedRadio.dataset.hasQuizzes,
            replay: selectedRadio.dataset.replayDay
        };

        document.querySelectorAll('#subscription-features [data-feature]').forEach(el => {
            const featureName = el.dataset.feature;
            if (features[featureName] && features[featureName].length > 0) {
                el.classList.remove('hidden');
                if (featureName === 'replay') {
                    document.getElementById('replay-day-text').textContent = `${features.replay} Days Replay Access`;
                }
            } else {
                el.classList.add('hidden');
            }
        });
    }

    function updateClassPrices() {
        classPriceEls.forEach(el => {
            const newPrice = selectedPlanPrice > 0 ? selectedPlanPrice.toFixed(2) : "0.00";
            el.textContent = "RM" + newPrice;
            el.dataset.base = selectedPlanPrice;
        });
        updatePaymentDetailsList();
    }

    function updateTotal() {
        const checkedCount = document.querySelectorAll(".class-checkbox:checked").length;
        const total = checkedCount * selectedPlanPrice;
        totalPriceEl.textContent = "RM" + total.toFixed(2);
    }

    function updatePaymentDetailsList() {
        paymentDetailsList.innerHTML = '';
        const checkedBoxes = document.querySelectorAll(".class-checkbox:checked");
        checkedBoxes.forEach(cb => {
            const tutor = cb.dataset.tutor;
            const subject = cb.dataset.subject;
            const schedule = cb.dataset.schedule;
            const price = parseFloat(selectedPlanPrice).toFixed(2);
            const itemHTML = `
                <div class="flex justify-between border-b border-[#1F1F1F] pb-3">
                    <div class="flex flex-col text-gray-75">
                        <h6 class="text-[20px] font-semibold">${tutor}</h6>
                        <span class="text-sm mb-2">${subject}</span>
                        <span class="text-sm">${schedule}</span>
                    </div>
                    <div class="flex flex-col items-end gap-3 text-gray-75">
                        <span class="font-semibold">RM${price}</span>
                    </div>
                </div>`;
            paymentDetailsList.innerHTML += itemHTML;
        });
    }

    function updateCheckboxStates() {
        maxAllowed = parseInt(totalClassesSelect.value) || 0;
        const checkedCount = document.querySelectorAll(".class-checkbox:checked").length;
        
        if (maxAllowed > 0) {
            limitCountSpan.textContent = maxAllowed;
            subjectLimitInfo.classList.remove('hidden');
        } else {
            subjectLimitInfo.classList.add('hidden');
        }
        
        classesCountEl.textContent = `Classes: ${checkedCount}`;
        
        checkboxes.forEach(cb => {
            if (!cb.checked) {
                cb.disabled = (checkedCount >= maxAllowed);
            }
            const cardFooter = cb.closest('label').querySelector('.card-footer');
            const checkmarkSvg = cb.closest('label').querySelector('.checkmark-svg');
            if (cb.checked) {
                cardFooter.classList.add('bg-white', 'text-black');
                cardFooter.classList.remove('bg-gray-300', 'text-white');
                checkmarkSvg.classList.remove('hidden');
            } else {
                cardFooter.classList.remove('bg-white', 'text-black');
                cardFooter.classList.add('bg-gray-300', 'text-white');
                checkmarkSvg.classList.add('hidden');
            }
        });
        
        updatePaymentDetailsList();
        updateTotal();
    }

    planRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            selectedPlanPrice = parseFloat(this.dataset.price) || 0;
            updateClassPrices();
            updateTotal();
            updateSubscriptionFeatures(this);
        });
    });

    totalClassesSelect.addEventListener("change", updateCheckboxStates);

    checkboxes.forEach(cb => {
        cb.addEventListener("change", updateCheckboxStates);
    });

    updateCheckboxStates();
});
</script>
@endpush