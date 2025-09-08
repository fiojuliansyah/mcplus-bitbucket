@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10 pb-5">
            <div class="flex items-center gap-3">
                <img src="{{ asset('frontend/assets/images/student-profile-vector.svg') }}" alt="Student Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Student</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">Subject Enrollment</h1>
                </div>
            </div>
            <div class="flex items-center gap-1 mb-3 text-sm">
                <span class="text-gray-910">My Profile</span>
                <span class="text-white">> Subject Enrollment</span>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="grid grid-cols-12 gap-10 mt-10">

            {{-- LEFT COLUMN: Subscription Summary & Live Classes --}}
            <div class="col-span-12 lg:col-span-6 flex flex-col gap-6">

                {{-- Subscription Summary Card --}}
                <div class="bg-gray-990 rounded-[21px] p-6 flex flex-col gap-4">
                    <h3 class="text-lg font-semibold text-gray-50">Subscription Summary</h3>

                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-gray-400">Type</span>
                        <span class="text-gray-50">{{ $subscription->plan->name ?? 'Normal Classes' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-gray-400">Duration</span>
                        <span class="text-gray-50">{{ $subscription->duration ?? 1 }} month(s)</span>
                    </div>
                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-gray-400">Classes</span>
                        <span class="text-gray-50">{{ count($subscription->live_class_id ?? []) }} Classes per week</span>
                    </div>
                    <div class="flex justify-between bg-black rounded-[21px] text-gray-75 px-5 py-4 mt-4">
                        <span class="text-xl font-semibold">Total Amount</span>
                        <span class="text-xl font-semibold">RM{{ number_format($subscription->price,2) }}</span>
                    </div>
                </div>

                {{-- Live Classes Card --}}
                <div class="bg-gray-990 rounded-[21px] p-6 flex flex-col gap-4">
                    <h3 class="text-lg font-semibold text-gray-50">Selected Classes</h3>

                    @php
                        $liveClassIds = $subscription->live_class_id ?? [];
                        $liveClasses = \App\Models\LiveClass::with(['user','subject','grade'])
                                            ->whereIn('id', $liveClassIds)
                                            ->get();
                    @endphp

                    @foreach($liveClasses as $class)
                        <div class="flex justify-between items-center border-b border-[#1F1F1F] py-3">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-50">{{ $class->subject->name ?? 'No Subject' }}</span>
                                <span class="text-gray-400 text-sm">
                                    {{ ucfirst(substr($class->class_day,0,3)) }}, 
                                    {{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($class->start_time)->addMinutes($class->duration ?? 120)->format('h:i A') }}
                                </span>
                                <span class="text-gray-400 text-sm">{{ $class->user->current_profile->name ?? 'N/A' }}</span>
                            </div>
                            <span class="text-gray-50 font-semibold">{{ $class->grade->name ?? 'Group A' }}</span>
                        </div>
                    @endforeach
                </div>

            </div>

            {{-- RIGHT COLUMN: Coupon & Payment --}}
            <div class="col-span-12 lg:col-span-6 flex flex-col gap-6">

                {{-- Plusian Code --}}
                <div class="bg-gray-990 rounded-[21px] p-6 flex flex-col gap-4">
                    <h3 class="text-lg font-semibold text-gray-50">Plusian Preneur Code (Optional)</h3>
                    <div class="flex gap-3">
                        <input type="text" id="plusian_coupon_input" placeholder="Enter Plusian Preneur Code" class="flex-1 px-4 py-3 rounded bg-gray-1000 text-gray-75 placeholder-gray-500 focus:outline-none" />
                        <button type="button" id="apply_plusian_coupon_btn" class="px-4 py-3 bg-gray-50 text-black rounded font-semibold">Apply</button>
                    </div>
                </div>

                {{-- Coupon & Total --}}
                <div class="bg-gray-990 rounded-[21px] p-6 flex flex-col gap-3">
                    <h3 class="text-lg font-semibold text-gray-50">Coupon</h3>
                    <div class="flex gap-3">
                        <input type="text" id="coupon_code_input" placeholder="Enter Coupon Code" class="flex-1 px-4 py-3 rounded bg-gray-1000 text-gray-75 placeholder-gray-500 focus:outline-none" />
                        <button type="button" id="apply_coupon_btn" class="px-4 py-3 bg-gray-50 text-black rounded font-semibold">Apply</button>
                    </div>
                    <span id="coupon_message" class="text-sm mt-1"></span>

                    <div id="discount_rows" class="flex flex-col gap-1 mt-2 hidden">
                        <div class="flex justify-between">
                            <span>Normal Coupon Discount</span>
                            <span id="normal_discount_text">- RM0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Plusian Preneur Discount</span>
                            <span id="plusian_discount_text">- RM0</span>
                        </div>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span>Subtotal</span>
                        <span id="subtotal_text">RM{{ number_format($subscription->price,2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax (11%)</span>
                        <span id="tax_text">RM0</span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Total</span>
                        <span id="total_text">RM{{ number_format($subscription->price,2) }}</span>
                    </div>
                </div>

                {{-- Proceed to Payment --}}
                <form action="{{ route('user.enrollment.proceedToPayment', $subscription->id) }}" method="POST">
                    @csrf
                    <input type="hidden" id="applied_coupon_code_input" name="applied_coupon_code" value="">
                    <input type="hidden" id="applied_coupon_code_normal" name="applied_coupon_code_normal" value="">
                    <input type="hidden" id="applied_coupon_code_plusian" name="applied_coupon_code_plusian" value="">
                    <input type="hidden" id="normal_discount_input" name="normal_discount" value="0">
                    <input type="hidden" id="plusian_discount_input" name="plusian_discount" value="0">
                    <button type="submit" id="payment_button" class="bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-5 py-3 mt-2">
                        <span id="payment_text" class="text-black text-[16px] font-semibold">Pay RM{{ number_format($subscription->price,2) }}</span>
                    </button>
                </form>

            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyBtn = document.getElementById('apply_coupon_btn');
    const plusianBtn = document.getElementById('apply_plusian_coupon_btn');
    const couponInput = document.getElementById('coupon_code_input');
    const plusianInput = document.getElementById('plusian_coupon_input');
    const couponMessage = document.getElementById('coupon_message');

    const discountRows = document.getElementById('discount_rows');
    const normalText = document.getElementById('normal_discount_text');
    const plusianText = document.getElementById('plusian_discount_text');

    const subtotalText = document.getElementById('subtotal_text');
    const taxText = document.getElementById('tax_text');
    const totalText = document.getElementById('total_text');
    const paymentText = document.getElementById('payment_text');

    const appliedCouponInput = document.getElementById('applied_coupon_code_input');
    const appliedCouponNormal = document.getElementById('applied_coupon_code_normal');
    const appliedCouponPlusian = document.getElementById('applied_coupon_code_plusian');
    const normalDiscountInput = document.getElementById('normal_discount_input');
    const plusianDiscountInput = document.getElementById('plusian_discount_input');

    const subtotal = parseFloat({{ $subscription->price }});
    const taxRate = 0.11;
    let discounts = { normal: 0, plusian: 0 };

    function updateTotal() {
        const totalDiscount = discounts.normal + discounts.plusian;
        const newSubtotal = subtotal - totalDiscount;
        const newTax = newSubtotal * taxRate;
        const newTotal = newSubtotal + newTax;

        discountRows.style.display = totalDiscount > 0 ? 'flex' : 'none';
        normalText.textContent = `- RM${formatCurrency(discounts.normal)}`;
        plusianText.textContent = `- RM${formatCurrency(discounts.plusian)}`;
        subtotalText.textContent = `RM${formatCurrency(newSubtotal)}`;
        taxText.textContent = `RM${formatCurrency(newTax)}`;
        totalText.textContent = `RM${formatCurrency(newTotal)}`;
        paymentText.textContent = `Pay RM${formatCurrency(newTotal)}`;

        // Update hidden inputs
        normalDiscountInput.value = discounts.normal;
        plusianDiscountInput.value = discounts.plusian;
        appliedCouponInput.value = JSON.stringify({
            normal: appliedCouponNormal.value || null,
            plusian_preneur: appliedCouponPlusian.value || null
        });
    }

    function applyCoupon(couponCode, type) {
        if (!couponCode) {
            couponMessage.innerHTML = `<span class="text-danger">Please enter a coupon code.</span>`;
            return;
        }

        couponMessage.innerHTML = `<span class="text-muted">Applying...</span>`;

        fetch('{{ route("api.enrollment.applyCoupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                coupon_code: couponCode,
                plan_price: subtotal,
                type: type
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                couponMessage.innerHTML = `<span class="text-success">${data.message}</span>`;
                if(type === 'plusian_preneur'){
                    discounts.plusian = parseFloat(data.discount_amount);
                    appliedCouponPlusian.value = data.coupon_code;
                } else {
                    discounts.normal = parseFloat(data.discount_amount);
                    appliedCouponNormal.value = data.coupon_code;
                }
                updateTotal();
            } else {
                couponMessage.innerHTML = `<span class="text-danger">${data.message}</span>`;
            }
        })
        .catch(err => {
            console.error(err);
            couponMessage.innerHTML = `<span class="text-danger">An error occurred.</span>`;
        });
    }

    applyBtn.addEventListener('click', () => applyCoupon(couponInput.value, 'normal'));
    plusianBtn.addEventListener('click', () => applyCoupon(plusianInput.value, 'plusian_preneur'));

    function formatCurrency(amount){
        return new Intl.NumberFormat('ms-MY', { maximumFractionDigits: 2 }).format(amount);
    }
});
</script>
@endpush
