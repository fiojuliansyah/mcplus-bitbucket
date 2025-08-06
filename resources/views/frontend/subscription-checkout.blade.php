@extends('frontend.layouts.app2')

@section('content')
    <div class="breadcrumb-bar text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Checkout</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pricing-plans') }}">Pricing</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container">
            <form action="{{ route('subscription.process') }}" method="POST">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <input type="hidden" name="coupon_code" id="applied_coupon_code">
                <div class="checkout-content">
                    <div class="row">
                        <div class="col-lg-8">
                            
                            <div class="checkout-item-1">
                                <div class="border-bottom pb-3 mb-3">
                                    <h5>1. Select Grade & Subject</h5>
                                </div>
                                <div class="mb-4">
                                    <label for="grade_id" class="form-label fw-bold">Select Your Grade</label>
                                    <select name="grade_id" id="grade_id" class="form-select form-select-lg" required>
                                        <option value="">-- Choose Grade --</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="subject_id" class="form-label fw-bold">Select Subject</label>
                                    <select name="subject_id" id="subject_id" class="form-select form-select-lg" required disabled>
                                        <option value="">-- Please select a grade first --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="checkout-item-1 mt-4">
                                <div class="border-bottom pb-3 mb-3">
                                    <h5>2. Billing Address</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label class="form-label">First Name<span class="text-danger ms-1">*</span></label>
                                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', explode(' ', $user->name)[0]) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label class="form-label">Last Name<span class="text-danger ms-1">*</span></label>
                                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', explode(' ', $user->name)[1] ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-item-1 mt-4">
                                <div class="border-bottom pb-3 mb-3">
                                    <h5>3. Pilih Metode Pembayaran</h5>
                                </div>
                                
                                <div class="payment-card-select"> {{-- Tambahkan wrapper ini --}}

                                    @if ($fpxBanks->isNotEmpty())
                                        <h6 class="mt-4 mb-3 text-secondary">Perbankan Online (FPX)</h6>
                                        <div class="row g-3">
                                            @foreach ($fpxBanks as $bank)
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bank_code" value="{{ $bank['code'] }}" id="payment-{{ $bank['code'] }}" required>
                                                        <label class="form-check-label payment-card" for="payment-{{ $bank['code'] }}">
                                                            <img src="/frontpage/assets/img/payment/{{ $bank['extras']['name'] }}.png" alt="{{ $bank['extras']['name'] ?? '' }}">
                                                            <span>{{ $bank['extras']['name'] ?? $bank['code'] }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($eWallets->isNotEmpty())
                                        <h6 class="mt-4 mb-3 text-secondary">E-Wallet & Duitnow QR</h6>
                                        <div class="row g-3">
                                            @foreach ($eWallets as $wallet)
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bank_code" value="{{ $wallet['code'] }}" id="payment-{{ $wallet['code'] }}" required>
                                                        <label class="form-check-label payment-card" for="payment-{{ $wallet['code'] }}">
                                                            <img src="/frontpage/assets/img/payment/{{ $wallet['extras']['name'] }}.png" alt="{{ $wallet['extras']['name'] ?? '' }}">
                                                            <span>{{ $wallet['extras']['name'] ?? $wallet['code'] }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($cards->isNotEmpty())
                                        <h6 class="mt-4 mb-3 text-secondary">Kartu Kredit / Debit</h6>
                                        <div class="row g-3">
                                            @foreach ($cards as $card)
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bank_code" value="{{ $card['code'] }}" id="payment-{{ $card['code'] }}" required>
                                                        <label class="form-check-label payment-card" for="payment-{{ $card['code'] }}">
                                                            <img src="/frontpage/assets/img/payment/{{ $card['extras']['name'] }}.png" alt="{{ $card['extras']['name'] ?? '' }}">
                                                            <span>{{ $card['extras']['name'] ?? $card['code'] }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                </div> {{-- Akhir dari wrapper .payment-card-select --}}


                                {{-- Tombol Bayar --}}
                                @if ($fpxBanks->isEmpty() && $eWallets->isEmpty() && $cards->isEmpty())
                                    <div class="alert alert-warning mt-4">
                                        Payment methods are currently unavailable. Please try again later.
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button type="submit" class="btn btn-secondary rounded-pill" id="payment_button">Pay RM{{ number_format($total, 2, '.', ',') }}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="checkout-item-2">
                                <div class="pb-3 border-bottom mb-3">
                                    <h5 class="mb-0">Order Summary</h5>
                                </div>
                                <div class="checkout-item-3 bg-light p-3 rounded-3 border mb-3">
                                    <h6>Plan Details</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="mb-0">{{ $plan->name }}</p>
                                        <p class="fw-medium mb-0">RM{{ number_format($plan->price) }}</p>
                                    </div>
                                    <small class="text-muted">{{ $plan->duration_in_days }} Days Access</small>
                                </div>

                                <div class="pb-3 border-bottom mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter Coupon Code" id="coupon_code_input">
                                        <button class="btn btn-outline-secondary" type="button" id="apply_coupon_btn">Apply</button>
                                    </div>
                                    <div id="coupon_message" class="mt-2"></div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Sub Total</p>
                                    <p class="text-gray-9 fw-medium mb-0" id="subtotal_text">RM{{ number_format($subtotal, 2, ',', '.') }}</p>
                                </div>
                            
                                <div class="d-flex align-items-center justify-content-between mb-2" id="discount_row" style="display: none;">
                                    <p class="mb-0">Discount</p>
                                    <p class="text-gray-9 fw-medium mb-0 text-success" id="discount_text">- RM0</p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                    <p class="mb-0">Tax (11%)</p>
                                    <p class="text-gray-9 fw-medium mb-0" id="tax_text">RM{{ number_format($tax, 2, ',', '.') }}</p>
                                </div>
                                <div class="total d-flex align-items-center justify-content-between">
                                    <h6 class="mb-0">Total</h6>
                                    <h4 class="mb-0" id="total_text">RM{{ number_format($total, 2, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const gradesData = @json($grades->mapWithKeys(function($grade) {
            return [$grade->id => $grade->subjects];
        }));

        document.addEventListener('DOMContentLoaded', function () {
            const gradeSelect = document.getElementById('grade_id');
            const subjectSelect = document.getElementById('subject_id');

            gradeSelect.addEventListener('change', function () {
                const gradeId = this.value;
                
                subjectSelect.innerHTML = '';
                subjectSelect.disabled = true;

                if (!gradeId) {
                    subjectSelect.innerHTML = '<option value="">-- Please select a grade first --</option>';
                    return;
                }

                const subjects = gradesData[gradeId] || [];

                if (subjects.length === 0) {
                    subjectSelect.innerHTML = '<option value="">-- No subjects found for this grade --</option>';
                } else {
                    subjectSelect.disabled = false;
                    subjectSelect.innerHTML = '<option value="">-- Choose Subject --</option>';
                    
                    subjects.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.name;
                        subjectSelect.appendChild(option);
                    });
                }
            });
        });
    </script>
   <script>
        document.addEventListener('DOMContentLoaded', function() {
            const applyBtn = document.getElementById('apply_coupon_btn');
            const couponInput = document.getElementById('coupon_code_input');
            const couponMessage = document.getElementById('coupon_message');
            const hiddenCouponInput = document.getElementById('applied_coupon_code');
            
            const discountRow = document.getElementById('discount_row');
            const discountText = document.getElementById('discount_text');
            const taxText = document.getElementById('tax_text');
            const totalText = document.getElementById('total_text');
            const paymentButton = document.getElementById('payment_button');

            const subtotal = {{ $subtotal }};
            const taxRate = 0.11;

            applyBtn.addEventListener('click', function() {
                const couponCode = couponInput.value;
                if (!couponCode) {
                    couponMessage.innerHTML = `<span class="text-danger">Please enter a coupon code.</span>`;
                    return;
                }

                couponMessage.innerHTML = `<span class="text-muted">Applying...</span>`;

                fetch('{{ route("api.coupon.apply") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        coupon_code: couponCode,
                        plan_price: subtotal
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        couponMessage.innerHTML = `<span class="text-success">${data.message}</span>`;
                        hiddenCouponInput.value = data.coupon_code;

                        const discount = parseFloat(data.discount_amount);
                        const newSubtotalAfterDiscount = subtotal - discount;
                        const newTax = newSubtotalAfterDiscount * taxRate;
                        const newTotal = newSubtotalAfterDiscount + newTax;

                        discountRow.style.display = 'flex';
                        discountText.textContent = `- RM${curencyFormat(discount)}`;
                        taxText.textContent = `RM${curencyFormat(newTax)}`;
                        totalText.textContent = `RM${curencyFormat(newTotal)}`;
                        paymentButton.textContent = `Pay RM${curencyFormat(newTotal)}`;
                        
                    } else {
                        couponMessage.innerHTML = `<span class="text-danger">${data.message}</span>`;
                        hiddenCouponInput.value = ''; 
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    couponMessage.innerHTML = `<span class="text-danger">An error occurred.</span>`;
                });
            });

            function curencyFormat(angka) {
                return new Intl.NumberFormat('ms-MY', {
                    maximumFractionDigits: 0 
                }).format(angka);
            }
        });
    </script>
@endpush