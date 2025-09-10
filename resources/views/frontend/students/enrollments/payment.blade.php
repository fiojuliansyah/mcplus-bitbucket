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
                    <h1 class="text-4xl font-bold tracking-tight text-white">Payment</h1>
                </div>
            </div>
            <div class="flex items-center gap-1 mb-3 text-sm">
                <span class="text-gray-910">My Profile</span>
                <span class="text-white">> Payment</span>
            </div>
        </div>

        <div class="pt-10 grid grid-cols-12 gap-10">

            <!-- PAYMENT SUMMARY -->
            <div class="col-span-12 lg:col-span-6">
                <div class="flex flex-col gap-5 bg-gray-990 rounded-[21px] py-10 px-8">
                    <h3 class="text-lg font-semibold text-gray-50 mb-4">Payment Summary</h3>
                    @php
                        $totalDiscountNormal = 0;
                        $totalDiscountPlusian = 0;
                    @endphp

                    @foreach($subscriptions as $sub)
                        @php $coupons = json_decode($sub->coupon_id, true) ?? []; @endphp
                        <div class="flex justify-between border-b border-[#1F1F1F] py-2">
                            <div>
                                <div class="font-semibold">{{ $sub->liveClass->subject->name ?? 'Class' }} - {{ $sub->plan->name }}</div>
                                <div class="text-sm text-gray-400">
                                    {{ ucfirst($sub->liveClass->class_day ?? '') }},
                                    {{ \Carbon\Carbon::parse($sub->liveClass->start_time)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($sub->liveClass->start_time)->addMinutes($sub->liveClass->duration ?? 120)->format('h:i A') }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold">RM{{ number_format($sub->price, 2) }}</div>
                                <div class="text-sm text-gray-400">{{ $sub->liveClass->user->current_profile->name ?? $sub->liveClass->user->name ?? '' }}</div>
                            </div>
                        </div>

                        @if(isset($coupons['normal'])) @php $totalDiscountNormal += $coupons['normal']['amount']; @endphp @endif
                        @if(isset($coupons['plusian_preneur'])) @php $totalDiscountPlusian += $coupons['plusian_preneur']['amount']; @endphp @endif
                    @endforeach

                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-[#868484]">Subtotal</span>
                        <span class="text-gray-50">RM{{ number_format($subscriptions->sum('price'), 2) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-[#868484]">Normal Coupon Discount</span>
                        <span class="text-gray-50">- RM{{ number_format($totalDiscountNormal, 2) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-[#868484]">Plusian Preneur Discount</span>
                        <span class="text-gray-50">- RM{{ number_format($totalDiscountPlusian, 2) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-[#868484]">Tax (11%)</span>
                        <span class="text-gray-50">RM{{ number_format($subscriptions->sum('tax'), 2) }}</span>
                    </div>
                    <div class="flex justify-between bg-black rounded-[21px] text-gray-75 px-5 py-6 mt-5">
                        <span class="text-[24px] font-semibold">Total Payable</span>
                        <span class="text-[24px] font-semibold">RM{{ number_format($subscriptions->sum('total_amount'), 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- PAYMENT OPTIONS -->
            <div class="col-span-12 lg:col-span-6 flex flex-col gap-6">
                <h3 class="text-lg font-semibold text-gray-50">Payment Options</h3>

                <form id="payment_form" action="{{ route('user.enrollment.processPayment', $transaction) }}" method="POST">
                    @csrf
                    <input type="hidden" name="selected_gateway" id="selected_gateway" value="">

                    @foreach($paymentGateways as $type => $gateways)
                        @if($gateways->isNotEmpty())
                            <div class="flex flex-col gap-3 mt-2">
                                <span class="font-semibold text-gray-50">{{ $type }}</span>
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach($gateways as $gateway)
                                        <button type="button" class="gateway_btn flex items-center gap-3 px-4 py-3 rounded bg-gray-50 text-black hover:bg-gray-200 font-semibold"
                                            data-code="{{ $gateway['extras']['code'] ?? $gateway['extras']['name'] ?? $type }}">
                                            <img src="{{ $gateway['extras']['icon'] ?? asset('frontend/assets/images/sample/fpx.png') }}" alt="{{ $gateway['extras']['name'] ?? $type }}" class="w-12">
                                            <span>Pay with {{ $gateway['extras']['name'] ?? $type }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <button type="submit" class="mt-6 bg-green-500 hover:bg-green-600 rounded-full px-6 py-3 font-semibold text-white w-full">
                        Proceed to Pay
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const gatewayButtons = document.querySelectorAll('.gateway_btn');
    const selectedInput = document.getElementById('selected_gateway');
    const paymentForm = document.getElementById('payment_form');

    gatewayButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            gatewayButtons.forEach(b => b.classList.remove('border-4','border-green-500'));
            btn.classList.add('border-4','border-green-500');
            selectedInput.value = btn.dataset.code;
        });
    });

    paymentForm.addEventListener('submit', function(e){
        if(!selectedInput.value){
            e.preventDefault();
            alert('Please select a payment gateway.');
        }
    });
});
</script>
@endpush
