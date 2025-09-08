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
            <div class="flex items-center gap-1 mb-3 text-sm">
                <span class="text-gray-910">My Profile</span>
                <span class="text-white">> Checkout</span>
            </div>
        </div>

        <!-- PAYMENT CONTENT -->
        <div class="pt-10 grid grid-cols-12 gap-10">

            <!-- PAYMENT SUMMARY -->
            <div class="col-span-12 lg:col-span-6">
                <div class="flex flex-col gap-5 bg-gray-990 rounded-[21px] py-10 px-8">
                    <h3 class="text-lg font-semibold text-gray-50 mb-4">Payment Summary</h3>

                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-[#868484]">Subtotal</span>
                        <span class="text-gray-50">RM{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                        <span class="text-[#868484]">Tax (11%)</span>
                        <span class="text-gray-50">RM{{ number_format($tax, 2) }}</span>
                    </div>

                    @php
                        $couponsUsed = json_decode($subscription->coupon_id, true) ?? [];
                    @endphp

                    @if(isset($couponsUsed['normal']))
                        <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                            <span class="text-[#868484]">Normal Coupon ({{ $couponsUsed['normal']['code'] }})</span>
                            <span class="text-gray-50">- RM{{ number_format($couponsUsed['normal']['amount'], 2) }}</span>
                        </div>
                    @endif

                    @if(isset($couponsUsed['plusian_preneur']))
                        <div class="flex justify-between border-b border-[#1F1F1F] py-3">
                            <span class="text-[#868484]">Plusian Preneur Coupon ({{ $couponsUsed['plusian_preneur']['code'] }})</span>
                            <span class="text-gray-50">- RM{{ number_format($couponsUsed['plusian_preneur']['amount'], 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between bg-black rounded-[21px] text-gray-75 px-5 py-6 mt-5">
                        <span class="text-[24px] font-semibold">Total Payable</span>
                        <span class="text-[24px] font-semibold">RM{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- PAYMENT OPTIONS -->
            <div class="col-span-12 lg:col-span-6 flex flex-col gap-6">
                <h3 class="text-lg font-semibold text-gray-50">Payment Options</h3>

                @php
                    $paymentGateways = [
                        'FPX Banks' => $fpxBanks,
                        'E-Wallets' => $eWallets,
                        'Card' => $cards,
                    ];
                @endphp

                @foreach($paymentGateways as $type => $gateways)
                    @if($gateways->isNotEmpty())
                        <div class="flex flex-col gap-3 mt-2">
                            <span class="font-semibold text-gray-50">{{ $type }}</span>
                            <div class="grid grid-cols-1 gap-3">
                                @foreach($gateways as $gateway)
                                    <form action="{{ route('subscription.processPayment', $subscription->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="bank_code" value="{{ $gateway['extras']['code'] ?? '' }}">
                                        <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded bg-gray-50 text-black hover:bg-gray-200 font-semibold">
                                            <img src="{{ $gateway['extras']['icon'] ?? asset('frontend/assets/images/sample/fpx.png') }}" alt="{{ $gateway['extras']['name'] ?? $type }}" class="w-12">
                                            <span>Pay with {{ $gateway['extras']['name'] ?? $type }}</span>
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                @if($fpxBanks->isEmpty() && $eWallets->isEmpty() && $cards->isEmpty())
                    <div class="text-gray-50 mt-5">
                        No payment gateways available at the moment. Please try again later.
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
