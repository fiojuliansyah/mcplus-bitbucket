<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Grade;
use App\Models\Coupon;
use App\Models\Subject;
use App\Models\LiveClass;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Notifications\RenewalReminder;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('frontend.subscription', compact('plans'));
    }

    public function renewalReminderNotification()
    {
        $user = Auth::user();

        $subscription = Subscription::where('user_id', $user->id)->first();

        if ($user && $subscription) {
            $daysRemaining = $subscription->end_date->diffInDays(now());

            if ($daysRemaining == 7 || $daysRemaining == 1) {
                $user->notify(new RenewalReminder($subscription));
                return 'Notification sent!';
            }          
            return 'No reminder needed yet.';
        }
        return 'User or subscription not found.';
    }

    public function subscriptionType()
    {
        return view('frontend.students.enrollments.subscription-type');
    }

    public function subjectEnrollment()
    {
        $plans = Plan::all();
        $liveClasses = LiveClass::with(['subject', 'user'])->get();

        return view('frontend.students.enrollments.subject-enrollment', compact('plans', 'liveClasses'));
    }

    public function storeEnrollment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'live_classes' => 'required|array|min:1',
            'live_classes.*' => 'exists:live_classes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $plan = Plan::findOrFail($request->plan_id);
        $selectedClasses = LiveClass::whereIn('id', $request->live_classes)->get();

        $transactionCode = 'SUB-' . strtoupper(Str::random(10));

        $subscriptions = collect();

        foreach ($selectedClasses as $class) {
            $subscription = Subscription::create([
                'transaction_code' => $transactionCode,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'live_class_id' => $class->id,
                'subject_id' => $class->subject_id,
                'tutor_id' => $class->tutor_id,
                'duration' => $plan->duration_value ?? 1,
                'start_date' => now(),
                'end_date' => now()->addMonths($plan->duration_value ?? 1),
                'price' => $plan->price,
                'status' => 'pending',
            ]);

            $subscriptions->push($subscription);
        }

        $subscriptionIds = $subscriptions->pluck('id')->toArray();

        return redirect()
            ->route('user.enrollment.reviewTimetable', [
                'transaction' => $transactionCode,
            ])
            ->with('success', 'Your classes have been selected. Please review your timetable.');
    }

    public function reviewTimetable($transactionCode)
    {
        $subscriptions = Subscription::with('liveClass.user')
            ->where('transaction_code', $transactionCode)
            ->get();

        if ($subscriptions->isEmpty()) {
            return redirect()->route('user.dashboard')
                ->with('error', 'No subscription found.');
        }

        $startDateRaw = $subscriptions->min('start_date');
        $endDateRaw   = $subscriptions->max('end_date');

        $startDate = $startDateRaw ? Carbon::parse($startDateRaw) : Carbon::today();
        $endDate   = $endDateRaw   ? Carbon::parse($endDateRaw)   : $startDate;
        $endDatePlusOne = $endDate->copy()->addDay()->toDateString();

        $calendarEvents = [];

        foreach ($subscriptions as $subscription) {
            $class = $subscription->liveClass;

            if (!$class) continue;

            $startTime = Carbon::parse($class->start_time);
            if (!empty($class->end_time)) {
                $endTime = Carbon::parse($class->end_time);
            } else {
                $endTime = $startTime->copy()->addMinutes($class->duration ?? 120);
            }

            if (!empty($class->schedule_date)) {
                $dayNumber = Carbon::parse($class->schedule_date)->dayOfWeek;
            } elseif (!empty($class->class_day)) {
                $dayMap = [
                    'sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3,
                    'thursday' => 4, 'friday' => 5, 'saturday' => 6
                ];
                $dayNumber = $dayMap[strtolower($class->class_day)] ?? Carbon::parse($class->start_time)->dayOfWeek;
            } else {
                $dayNumber = Carbon::parse($class->start_time)->dayOfWeek;
            }

            $calendarEvents[] = [
                'title'      => $class->title ?? ($class->subject->name ?? 'Class'),
                'daysOfWeek' => [$dayNumber],
                'startTime'  => $startTime->format('H:i:s'),
                'endTime'    => $endTime->format('H:i:s'),
                'startRecur' => $startDate->toDateString(),
                'endRecur'   => $endDate->toDateString(),
                'extendedProps' => [
                    'name'    => $class->user->current_profile->name ?? $class->user->name ?? 'N/A',
                    'classes' => $class->title ?? ($class->subject->name ?? 'Class'),
                    'group'   => $class->group_name ?? $class->group ?? 'General',
                ],
            ];
        }

        return view('frontend.students.enrollments.review-timetable', [
            'subscriptions'   => $subscriptions,
            'events'          => json_encode($calendarEvents),
            'totalClasses'    => $subscriptions->count(),
            'transactionCode' => $transactionCode,
            'startDate'       => $startDate->toDateString(),
            'endDate'         => $endDate->toDateString(),
            'endDatePlusOne'  => $endDatePlusOne,
        ]);
    }

    public function checkout($transactionCode)
    {
        $subscriptions = Subscription::with(['liveClass.user','plan'])
            ->where('transaction_code', $transactionCode)
            ->get();

        if ($subscriptions->isEmpty()) {
            return redirect()->route('user.dashboard')
                ->with('error', 'No subscription found for checkout.');
        }

        $totalPrice = $subscriptions->sum('price');

        return view('frontend.students.enrollments.checkout', [
            'subscriptions'   => $subscriptions,
            'transactionCode' => $transactionCode,
            'totalPrice'      => $totalPrice
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'plan_price' => 'required|numeric',
            'type' => 'nullable|string',
        ]);

        $now = now();

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('status', 'active')
            ->where(function ($query) use ($now) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
            });

        if ($request->type === 'plusian_preneur') {
            $coupon->where('coupon_type', 'plusian_preneur');
        } else {
            $coupon->where('coupon_type', 'normal');
        }

        $coupon = $coupon->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code.'
            ]);
        }

        $discountAmount = $coupon->discount_type === 'percentage'
            ? ($request->plan_price * $coupon->amount) / 100
            : $coupon->amount;

        $discountAmount = min($discountAmount, $request->plan_price);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount_amount' => $discountAmount,
            'coupon_code' => $coupon->code,
            'type' => $coupon->coupon_type,
        ]);
    }

    public function proceedToPayment(Request $request, $transaction)
    {
        $request->validate([
            'normal_discount' => 'nullable|numeric',
            'plusian_discount' => 'nullable|numeric',
            'applied_coupon_code_normal' => 'nullable|string',
            'applied_coupon_code_plusian' => 'nullable|string',
        ]);

        $normalDiscount = floatval($request->input('normal_discount', 0));
        $plusianDiscount = floatval($request->input('plusian_discount', 0));
        $totalDiscount = $normalDiscount + $plusianDiscount;

        $subscriptions = Subscription::where('transaction_code', $transaction)->get();
        if ($subscriptions->isEmpty()) {
            return redirect()->back()->with('error', 'No subscriptions found to proceed.');
        }

        $taxRate = 0.11;
        $totalPrice = $subscriptions->sum('price');

        foreach ($subscriptions as $sub) {
            $proportion = $totalPrice > 0 ? ($sub->price / $totalPrice) : 0;
            $subDiscount = round($totalDiscount * $proportion, 2);
            $newSubtotal = max(0, $sub->price - $subDiscount);
            $taxAmount = round($newSubtotal * $taxRate, 2);
            $totalAmount = round($newSubtotal + $taxAmount, 2);

            $coupons = [];
            if ($normalDiscount > 0 && $request->filled('applied_coupon_code_normal')) {
                $coupons['normal'] = [
                    'code' => $request->input('applied_coupon_code_normal'),
                    'amount' => round($normalDiscount * $proportion, 2),
                ];
            }
            if ($plusianDiscount > 0 && $request->filled('applied_coupon_code_plusian')) {
                $coupons['plusian_preneur'] = [
                    'code' => $request->input('applied_coupon_code_plusian'),
                    'amount' => round($plusianDiscount * $proportion, 2),
                ];
            }

            $sub->coupon_id = json_encode($coupons);
            $sub->coupon_discount = $subDiscount;
            $sub->tax = $taxAmount;
            $sub->total_amount = $totalAmount;
            $sub->status = 'pending';
            $sub->save();
        }

        return redirect()->route('user.enrollment.payment', $transaction);
    }

    public function showPaymentPage($transaction)
    {
        $subscriptions = Subscription::where('transaction_code', $transaction)->get();
        if ($subscriptions->isEmpty()) {
            return redirect()->route('user.dashboard')->with('error', 'No subscription found.');
        }

        $subtotal = $subscriptions->sum('price') - $subscriptions->sum('coupon_discount');
        $tax = $subscriptions->sum('tax') ?? ($subtotal * 0.11);
        $total = $subscriptions->sum('total_amount') ?? ($subtotal + $tax);

        $fpxBanks = collect();  
        $eWallets = collect();
        $cards = collect();

        try {
            $apiKey = env('BILLPLZ_API_KEY');
            $xSignatureKey = env('BILLPLZ_X_SIGNATURE_KEY');

            if ($apiKey && $xSignatureKey) {
                $epoch = time();
                $checksum = hash_hmac('sha512', $epoch, $xSignatureKey);
                $url = env('BILLPLZ_URL');

                $response = Http::withBasicAuth($apiKey, '')
                                ->get($url, [
                                    'epoch' => $epoch,
                                    'checksum' => $checksum,
                                ]);

                if ($response->successful()) {
                    $allGateways = collect($response->json()['payment_gateways']);
                    $activeGateways = $allGateways->filter(fn($g) => $g['active'] && $g['extras']['visibility']);

                    $fpxBanks = $activeGateways->filter(fn($g) => $g['extras']['isFpx']);
                    $eWallets = $activeGateways->filter(fn($g) => $g['extras']['isObw'] && !$g['extras']['isFpx']);
                    $cards = $activeGateways->filter(fn($g) => str_contains($g['extras']['name'] ?? '', 'Visa') || str_contains($g['extras']['name'] ?? '', 'Mastercard'));
                }
            }
        } catch (\Exception $e) {
            Log::error('Error koneksi ke API Billplz: ' . $e->getMessage());
        }

        $paymentGateways = [
            'FPX Banks' => $fpxBanks,
            'E-Wallets' => $eWallets,
            'Card' => $cards,
        ];

        return view('frontend.students.enrollments.payment', [
            'transaction' => $transaction,
            'subscriptions' => $subscriptions,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'paymentGateways' => $paymentGateways,
        ]);
    }

    public function processPayment(Request $request, $transaction)
    {
        $request->validate([
            'selected_gateway' => 'required|string'
        ]);

        $subscriptions = Subscription::with('user', 'plan')
            ->where('transaction_code', $transaction)
            ->get();

        if ($subscriptions->isEmpty()) {
            return redirect()->back()->with('error', 'No subscriptions found.');
        }

        $user = $subscriptions->first()->user;
        $totalAmount = $subscriptions->sum('total_amount');

        $apiKey = env('BILLPLZ_API_KEY');
        $collectionId = env('BILLPLZ_COLLECTION_ID');
        $billUrl = env('BILLPLZ_BILL_URL', 'https://www.billplz-sandbox.com/api/v3/bills');

        $description = 'Payment for subscriptions: ' . $subscriptions->pluck('id')->join(', ');

        try {
            $response = Http::asForm()->withBasicAuth($apiKey, '')
                ->post($billUrl, [
                    'collection_id' => $collectionId,
                    'email' => $user->email,
                    'name' => $user->current_profile->name,
                    'amount' => $totalAmount * 100,
                    'description' => $description,
                    'callback_url' => route('user.subscription.paymentCallback', $transaction),
                    'redirect_url' => route('user.subscription.paymentSuccess', $transaction),
                    'payment_channel' => $request->selected_gateway
                ]);

            if ($response->successful()) {
                $billData = $response->json();

                foreach ($subscriptions as $sub) {
                    $sub->payment_gateway_bill_id = $billData['id'];
                    $sub->status = 'pending';
                    $sub->save();
                }

                return redirect($billData['url']);
            }

            Log::error('Billplz payment failed: ' . $response->body());
            return redirect()->back()->with('error', 'Failed to generate payment link.');
            
        } catch (\Exception $e) {
            Log::error('Billplz payment exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing payment.');
        }
    }

    public function billplzWebhook(Request $request)
    {
        $data = $request->all();
        $transactionCode = $data['bill']['passthrough']['transaction_code'] ?? null;
        $status = $data['bill']['paid'] ?? false;

        if ($transactionCode) {
            $subscriptions = Subscription::where('transaction_code', $transactionCode)->get();
            foreach ($subscriptions as $sub) {
                $sub->status = $status ? 'paid' : 'failed';
                $sub->save();
            }
        }

        return response()->json(['status'=>'ok']);
    }


    public function paymentCallback(Request $request, $transactionCode)
    {
        $paid = $request->query('paid', false);
        $subscriptions = Subscription::where('transaction_code', $transactionCode)->get();
        foreach($subscriptions as $sub){
            $sub->status = $paid ? 'paid' : 'failed';
            $sub->save();
        }

        return redirect()->route('user.dashboard')->with($paid ? 'success':'error', $paid ? 'Payment successful!' : 'Payment failed.');
    }

    public function paymentSuccess($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $transactionCode = $subscription->transaction_code;

        $subscriptions = Subscription::where('transaction_code', $transactionCode)->get();
        foreach($subscriptions as $sub){
            $sub->status = 'paid';
            $sub->save();
        }

        return redirect()->route('user.dashboard')->with('success', 'Payment successful!');
    }

}