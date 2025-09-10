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
                    <h1 class="text-4xl font-bold tracking-tight text-white">Checkout</h1>
                </div>
            </div>
        </div>

        <div class="pt-10 grid grid-cols-12 gap-10">
            <!-- CLASS LIST + SUMMARY -->
            <div class="col-span-12 lg:col-span-6">
                <div class="flex flex-col gap-5 bg-gray-990 rounded-[21px] py-10 px-8">
                    <h3 class="text-lg font-semibold text-gray-50 mb-4">Selected Classes</h3>

                    @foreach($subscriptions as $subscription)
                        @php $lc = $subscription->liveClass; @endphp
                        <div class="flex justify-between py-2 border-b border-[#1F1F1F]">
                            <div>
                                <div class="font-semibold">{{ $lc->subject->name ?? $lc->title ?? 'Class' }}</div>
                                <div class="text-sm text-gray-400">
                                    {{ ucfirst($lc->class_day ?? '') }},
                                    {{ \Carbon\Carbon::parse($lc->start_time)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($lc->start_time)->addMinutes($lc->duration ?? 120)->format('h:i A') }}
                                </div>
                                <div class="text-sm text-gray-400">{{ $lc->user->current_profile->name ?? $lc->user->name ?? '' }}</div>
                            </div>
                            <div class="text-right font-semibold">
                                RM<span class="class_price" data-original="{{ $subscription->price }}">{{ number_format($subscription->price,2) }}</span>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-between bg-black rounded-[21px] text-gray-75 px-5 py-6 mt-5">
                        <span class="text-[24px] font-semibold">Total Amount</span>
                        <span class="text-[24px] font-semibold" id="total_text">RM{{ number_format($totalPrice,2) }}</span>
                    </div>
                </div>
            </div>

            <!-- COUPONS + PAYMENT FORM -->
            <div class="col-span-12 lg:col-span-6 flex flex-col gap-6">
                <div class="bg-gray-990 rounded-[21px] p-6">
                    <h3 class="text-lg font-semibold text-gray-50">Plusian Preneur Code (Optional)</h3>
                    <div class="flex gap-3 mt-3">
                        <input type="text" id="plusian_coupon_input" placeholder="Enter Plusian Preneur Code" class="flex-1 px-4 py-3 rounded bg-gray-1000 text-gray-75" />
                        <button type="button" id="apply_plusian_coupon_btn" class="px-4 py-3 bg-gray-50 text-black rounded font-semibold">Apply</button>
                    </div>
                </div>

                <div class="bg-gray-990 rounded-[21px] p-6">
                    <h3 class="text-lg font-semibold text-gray-50">Coupon</h3>
                    <div class="flex gap-3 mt-3">
                        <input type="text" id="coupon_code_input" placeholder="Enter Coupon Code" class="flex-1 px-4 py-3 rounded bg-gray-1000 text-gray-75" />
                        <button type="button" id="apply_coupon_btn" class="px-4 py-3 bg-gray-50 text-black rounded font-semibold">Apply</button>
                    </div>
                    <span id="coupon_message" class="text-sm mt-2"></span>

                    <div id="discount_rows" class="flex flex-col gap-1 mt-4 hidden">
                        <div class="flex justify-between">
                            <span>Normal Coupon Discount</span>
                            <span id="normal_discount_text">- RM0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Plusian Preneur Discount</span>
                            <span id="plusian_discount_text">- RM0</span>
                        </div>
                    </div>

                    <div class="flex justify-between mt-4">
                        <span>Subtotal</span>
                        <span id="subtotal_text">RM{{ number_format($totalPrice,2) }}</span>
                    </div>
                    <div class="flex justify-between mt-3">
                        <span>Tax (11%)</span>
                        <span id="tax_text">RM0.00</span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg mt-3">
                        <span>Total</span>
                        <span id="checkout_total_text">RM{{ number_format($totalPrice,2) }}</span>
                    </div>
                </div>

                <form id="payment_form" action="{{ route('user.enrollment.proceedToPayment', $transactionCode) }}" method="POST">
                    @csrf
                    <input type="hidden" id="applied_coupon_code_normal" name="applied_coupon_code_normal" value="">
                    <input type="hidden" id="applied_coupon_code_plusian" name="applied_coupon_code_plusian" value="">
                    <input type="hidden" id="normal_discount_input" name="normal_discount" value="0">
                    <input type="hidden" id="plusian_discount_input" name="plusian_discount" value="0">
                    <button type="submit" id="payment_button" class="bg-gray-50 hover:bg-gray-200 rounded-full text-center text-sm px-5 py-3 mt-2 w-full">
                        <span id="payment_text" class="text-black text-[16px] font-semibold">Pay RM{{ number_format($totalPrice,2) }}</span>
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
    const applyNormal = document.getElementById('apply_coupon_btn');
    const applyPlusian = document.getElementById('apply_plusian_coupon_btn');
    const inputNormal = document.getElementById('coupon_code_input');
    const inputPlusian = document.getElementById('plusian_coupon_input');
    const message = document.getElementById('coupon_message');

    const discountRows = document.getElementById('discount_rows');
    const normalText = document.getElementById('normal_discount_text');
    const plusianText = document.getElementById('plusian_discount_text');

    const subtotalText = document.getElementById('subtotal_text');
    const taxText = document.getElementById('tax_text');
    const totalText = document.getElementById('checkout_total_text');
    const paymentText = document.getElementById('payment_text');

    const appliedNormal = document.getElementById('applied_coupon_code_normal');
    const appliedPlusian = document.getElementById('applied_coupon_code_plusian');
    const normalDiscountInput = document.getElementById('normal_discount_input');
    const plusianDiscountInput = document.getElementById('plusian_discount_input');

    const classPrices = document.querySelectorAll('.class_price');

    const subtotal = Number(@json($totalPrice));
    const taxRate = 0.11;
    let discounts = { normal: 0, plusian: 0 };

    function formatCurrency(value) {
        return new Intl.NumberFormat('ms-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
    }

    function updateTotal() {
        const totalDiscount = discounts.normal + discounts.plusian;
        const newSubtotal = subtotal - totalDiscount;
        const tax = newSubtotal * taxRate;
        const total = newSubtotal + tax;

        discountRows.style.display = totalDiscount > 0 ? 'flex' : 'none';
        normalText.textContent = `- RM${formatCurrency(discounts.normal)}`;
        plusianText.textContent = `- RM${formatCurrency(discounts.plusian)}`;
        subtotalText.textContent = `RM${formatCurrency(newSubtotal)}`;
        taxText.textContent = `RM${formatCurrency(tax)}`;
        totalText.textContent = `RM${formatCurrency(total)}`;
        paymentText.textContent = `Pay RM${formatCurrency(total)}`;

        normalDiscountInput.value = discounts.normal;
        plusianDiscountInput.value = discounts.plusian;
        appliedNormal.value = discounts.normal ? inputNormal.value.trim() : '';
        appliedPlusian.value = discounts.plusian ? inputPlusian.value.trim() : '';

        classPrices.forEach(el => {
            const original = parseFloat(el.dataset.original);
            const proportion = original / subtotal;
            const newPrice = original - (totalDiscount * proportion);
            el.textContent = formatCurrency(newPrice);
        });
    }

    function applyCoupon(code, type) {
        if (!code) {
            message.textContent = 'Please enter a coupon code.';
            return;
        }
        message.textContent = 'Applying...';
        fetch('{{ route("api.enrollment.applyCoupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ coupon_code: code, plan_price: subtotal, type: type })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                message.textContent = data.message;
                if (type === 'plusian_preneur') discounts.plusian = Number(data.discount_amount);
                else discounts.normal = Number(data.discount_amount);
                updateTotal();
            } else {
                message.textContent = data.message;
            }
        })
        .catch(err => {
            console.error(err);
            message.textContent = 'An error occurred.';
        });
    }

    applyNormal.addEventListener('click', () => applyCoupon(inputNormal.value.trim(), 'normal'));
    applyPlusian.addEventListener('click', () => applyCoupon(inputPlusian.value.trim(), 'plusian_preneur'));

    updateTotal();
});
</script>
@endpush
