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

    // public function processSubscription(Request $request)
    // {
    //     $request->validate([
    //         'plan_id' => 'required|exists:plans,id',
    //         'grade_id' => 'required|exists:grades,id',
    //         'subject_id' => 'required|exists:subjects,id',
    //         'coupon_code' => 'nullable|string|exists:coupons,code',
    //         'bank_code' => 'required|string',
    //     ]);

    //     $plan = Plan::find($request->plan_id);
    //     $user = auth()->user();
    //     $coupon = null;

    //     $price = $plan->price;
    //     $discount = 0;

    //     if ($request->filled('coupon_code')) {
    //         $now = now();
    //         $coupon = Coupon::where('code', $request->coupon_code)
    //                         ->where('status', 'active')
    //                         ->where(function ($query) use ($now) {
    //                             $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
    //                         })
    //                         ->where(function ($query) use ($now) {
    //                             $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
    //                         })
    //                         ->first();
            
    //         if ($coupon) {
    //             if ($coupon->discount_type === 'percentage') {
    //                 $discount = ($price * $coupon->amount) / 100;
    //             } else {
    //                 $discount = $coupon->amount;
    //             }
    //             $discount = min($price, $discount);
    //         }
    //     }
        
    //     $tax = ($price - $discount) * 0.11;
    //     $totalAmount = ($price - $discount) + $tax;

    //     $subscription = Subscription::create([
    //         'transaction_code' => 'TRX-' . time() . $user->id,
    //         'user_id' => $user->id,
    //         'profile_id' => $user->current_profile->id,
    //         'plan_id' => $plan->id,
    //         'subject_id' => $request->subject_id,
    //         'coupon_id' => $coupon ? $coupon->id : null,
    //         'coupon_discount' => $discount,
    //         'duration' => $plan->duration_value,
    //         'start_date' => null,
    //         'end_date' => null, 
    //         'price' => $plan->price,
    //         'tax' => $tax,
    //         'total_amount' => $totalAmount,
    //         'payment_method' => 'billplz',
    //         'status' => 'pending',
    //     ]);

    //     try {
    //         $apiKey = env('BILLPLZ_API_KEY');
    //         $collectionId = env('BILLPLZ_COLLECTION_ID');

    //         $response = Http::asForm()->withBasicAuth($apiKey, '')
    //             ->post(env('BILLPLZ_API_BASE_URL', 'https://www.billplz-sandbox.com').'/api/v3/bills', [
    //                 'collection_id' => $collectionId,
    //                 'email' => $user->email,
    //                 'name' => $user->name,
    //                 'amount' => $totalAmount * 100,
    //                 'description' => 'Payment Plan: ' . $plan->name,
    //                 'callback_url' => route('billplz.webhook'),
    //                 'redirect_url' => route('payment.success'),
    //                 'reference_1_label' => 'Bank',
    //                 'reference_1' => $request->bank_code,
    //                 'passthrough' => [
    //                     'subscription_id' => $subscription->id,
    //                 ],
    //             ]);

    //         if ($response->successful()) {
    //             $bill = $response->json();
    //             $subscription->update(['payment_gateway_bill_id' => $bill['id']]);
                
    //             return redirect()->away($bill['url']);
    //         } else {
    //             $subscription->delete();
    //             Log::error('Gagal membuat Bill Billplz: ' . $response->body());
    //             return back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
    //         }

    //     } catch (\Exception $e) {
    //         $subscription->delete();
    //         Log::error('Error saat proses checkout Billplz: ' . $e->getMessage());
    //         return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
    //     }
    // }

    public function handleWebhook(Request $request)
    {
        $xSignatureKey = env('BILLPLZ_X_SIGNATURE_KEY');
        $signatureData = 'billplzid'.$request->input('id').'|billplzpaid_at'.$request->input('paid_at').'|billplzpaid'.$request->input('paid');
        $signed = hash_hmac('sha256', $signatureData, $xSignatureKey);

        if ($request->header('X-Signature') !== $signed) {
            Log::warning('Webhook signature validation failed.', ['request_signature' => $request->header('X-Signature'), 'generated_signature' => $signed]);
            return response('Invalid Signature', 400);
        }
        
        $subscriptionId = $request->input('passthrough.subscription_id');
        $isPaid = $request->input('paid') === 'true';

        $subscription = Subscription::find($subscriptionId);

        if ($subscription && $subscription->status === 'pending' && $isPaid) {
            $subscription->update([
                'status' => 'active',
                'paid_at' => now(),
                'start_date' => now(),
                'end_date' => now()->addDays($subscription->plan->duration),
                'payment_gateway_payload' => json_encode($request->all())
            ]);
            
            Log::info("Langganan #{$subscriptionId} berhasil diaktifkan melalui webhook.");
        } else {
            Log::warning("Webhook diterima untuk langganan #{$subscriptionId} tetapi tidak diproses.");
        }

        return response('OK', 200);
    }

    // public function paymentSuccess(Request $request)
    // {
    //     $billplzData = $request->query('billplz', []);
    //     $isVerified = false;

    //     if (!empty($billplzData) && isset($billplzData['x_signature'])) {
    //         $xSignatureKey = env('BILLPLZ_X_SIGNATURE_KEY');
    //         $signatureFromUrl = $billplzData['x_signature'];

    //         $dataToSign = $billplzData;
    //         unset($dataToSign['x_signature']);

    //         $sourceStrings = [];
    //         foreach ($dataToSign as $key => $value) {
    //             $sourceStrings[] = 'billplz' . $key . $value;
    //         }

    //         sort($sourceStrings, SORT_STRING | SORT_FLAG_CASE);

    //         $finalString = implode('|', $sourceStrings);
            
    //         $generatedSignature = hash_hmac('sha256', $finalString, $xSignatureKey);

    //         if (hash_equals($generatedSignature, $signatureFromUrl)) {
    //             $isVerified = true;
    //         } else {
    //             Log::warning('Redirect signature validation failed.', ['billplz_data' => $billplzData]);
    //         }
    //     }
        
    //     return view('frontend.payment-success', [
    //         'billplz' => $billplzData,
    //         'isVerified' => $isVerified,
    //     ]);
    // }

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

        // Ambil unique IDs dan ubah semua menjadi string
        $subjectIds = $selectedClasses->pluck('subject_id')->unique()->map(fn($id) => (string)$id)->values()->all();
        $tutorIds = $selectedClasses->pluck('user_id')->unique()->map(fn($id) => (string)$id)->values()->all();
        $liveClassIds = $selectedClasses->pluck('id')->unique()->map(fn($id) => (string)$id)->values()->all();

        $totalPrice = $plan->price * count($request->live_classes);
        $endDate = now()->addMonths($plan->duration_value ?? 1);

        $subscription = Subscription::create([
            'transaction_code' => 'SUB-' . strtoupper(Str::random(10)),
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'tutor_id' => $tutorIds,       // otomatis disimpan sebagai JSON
            'subject_id' => $subjectIds,   // otomatis disimpan sebagai JSON
            'live_class_id' => $liveClassIds, // array string JSON
            'duration' => $plan->duration_value ?? 1,
            'start_date' => now(),
            'end_date' => $endDate,
            'price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.enrollment.reviewTimetable', ['subscription' => $subscription->id])
            ->with('success', 'Your classes have been selected. Please review your timetable.');
    }

    public function reviewTimetable(Subscription $subscription)
    {
        $liveClassIds = $subscription->live_class_id ?? [];
        $liveClasses = LiveClass::with(['user', 'subject'])
            ->whereIn('id', $liveClassIds)
            ->get();

        $calendarEvents = [];
        $colors = ['#FFE172', '#FFAD72', '#72B2FF', '#A772FF', '#72FFB5', '#FF728F'];
        $subjectColorMap = [];
        $colorIndex = 0;

        $dayMap = [
            'sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3,
            'thursday' => 4, 'friday' => 5, 'saturday' => 6
        ];

        foreach ($liveClasses as $class) {
            if (!$class->start_time) continue;

            $subjectId = $class->subject_id;
            if (!isset($subjectColorMap[$subjectId])) {
                $subjectColorMap[$subjectId] = $colors[$colorIndex % count($colors)];
                $colorIndex++;
            }

            $duration = $class->duration ?? 120; // dalam menit
            $startTime = Carbon::parse($class->start_time)->format('H:i:s');
            $endTime = Carbon::parse($class->start_time)->addMinutes($duration)->format('H:i:s');

            $dayNumber = $dayMap[strtolower($class->class_day ?? 'monday')] ?? 1;

            $calendarEvents[] = [
                'title' => $class->subject->name ?? 'No Subject',
                'daysOfWeek' => [$dayNumber],   // recurring day
                'startTime' => $startTime,
                'endTime' => $endTime,
                'backgroundColor' => '#ffffff',
                'borderColor' => $subjectColorMap[$subjectId],
                'textColor' => '#0B0B0B',
                'extendedProps' => [
                    'name' => $class->user->current_profile->name ?? 'N/A',
                    'classes' => $class->subject->name ?? 'No Subject',
                    'group' => $class->group_name ?? 'Group A',
                ],
                'startRecur' => Carbon::parse($subscription->start_date)->toDateString(),
                'endRecur'   => Carbon::parse($subscription->end_date)->toDateString(),
            ];
        }

        return view('frontend.students.enrollments.timetable', [
            'subscription' => $subscription,
            'events' => json_encode($calendarEvents),
            'totalClasses' => $liveClasses->count()
        ]);
    }

    public function checkout(Subscription $subscription)
    {
        return view('frontend.students.enrollments.checkout', [
            'subscription' => $subscription
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'plan_price' => 'required|numeric',
            'type' => 'nullable|string', // 'normal' or 'plusian_preneur'
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

        if($request->type === 'plusian_preneur'){
            $coupon->where('coupon_type', 'plusian_preneur');
        } else {
            $coupon->where('coupon_type', 'normal');
        }

        $coupon = $coupon->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }

        $originalPrice = $request->plan_price;
        $discountAmount = 0;

        if ($coupon->discount_type === 'percentage') {
            $discountAmount = ($originalPrice * $coupon->amount) / 100;
        } else {
            $discountAmount = $coupon->amount;
        }

        $discountAmount = min($originalPrice, $discountAmount);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount_amount' => $discountAmount,
            'coupon_code' => $coupon->code,
            'type' => $coupon->coupon_type,
        ]);
    }

    public function proceedToPayment(Request $request, Subscription $subscription)
    {
        $normalDiscount = floatval($request->input('normal_discount', 0));
        $plusianDiscount = floatval($request->input('plusian_discount', 0));

        $totalDiscount = $normalDiscount + $plusianDiscount;
        $subtotal = floatval($subscription->price);
        $newSubtotal = $subtotal - $totalDiscount;
        $taxRate = 0.11;
        $taxAmount = $newSubtotal * $taxRate;
        $totalAmount = $newSubtotal + $taxAmount;

        // Simpan coupon code dan nominal per jenis
        $coupons = [];

        if ($normalDiscount > 0 && $request->filled('applied_coupon_code_normal')) {
            $coupons['normal'] = [
                'code' => $request->input('applied_coupon_code_normal'),
                'amount' => $normalDiscount
            ];
        }

        if ($plusianDiscount > 0 && $request->filled('applied_coupon_code_plusian')) {
            $coupons['plusian_preneur'] = [
                'code' => $request->input('applied_coupon_code_plusian'),
                'amount' => $plusianDiscount
            ];
        }

        $subscription->coupon_id = json_encode($coupons); // JSON berisi kode + nominal
        $subscription->coupon_discount = $totalDiscount; // total discount
        $subscription->tax = $taxAmount;
        $subscription->total_amount = $totalAmount;
        $subscription->status = 'pending';
        $subscription->save();

        return redirect()->route('user.enrollment.payment', $subscription->id);
    }
    
    public function showPaymentPage(Subscription $subscription)
    {
        $subtotal = $subscription->price - $subscription->coupon_discount;
        $taxRate = 0.11;
        $tax = $subscription->tax ?? ($subtotal * $taxRate);
        $total = $subscription->total_amount ?? ($subtotal + $tax);

        $fpxBanks = collect();  
        $eWallets = collect();
        $cards = collect();

        try {
            $apiKey = env('BILLPLZ_API_KEY');
            $xSignatureKey = env('BILLPLZ_X_SIGNATURE_KEY');

            if ($apiKey && $xSignatureKey) {
                $epoch = time();
                $checksum = hash_hmac('sha512', $epoch, $xSignatureKey);

                $url = env('BILLPLZ_URL'); // endpoint v5 sandbox/production

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

        return view('frontend.students.enrollments.payment', compact(
            'subscription', 'subtotal', 'tax', 'total', 'fpxBanks', 'eWallets', 'cards'
        ));
    }

    public function processPayment(Subscription $subscription, Request $request)
    {
        $request->validate([
            'bank_code' => 'required|string',
        ]);

        $user = $subscription->user;

        try {
            $apiKey = env('BILLPLZ_API_KEY');
            $collectionId = env('BILLPLZ_COLLECTION_ID');

            $totalAmount = $subscription->total_amount;

            $response = Http::asForm()->withBasicAuth($apiKey, '')
                ->post(env('BILLPLZ_API_BASE_URL', 'https://www.billplz-sandbox.com') . '/api/v3/bills', [
                    'collection_id' => $collectionId,
                    'email' => $user->email,
                    'name' => $user->name,
                    'amount' => $totalAmount * 100,
                    'description' => 'Payment for Subscription: ' . $subscription->plan->name,
                    'callback_url' => route('billplz.webhook'),
                    'redirect_url' => route('payment.success'),
                    'reference_1_label' => 'Bank',
                    'reference_1' => $request->bank_code,
                    'passthrough' => [
                        'subscription_id' => $subscription->id,
                    ],
                ]);

            if ($response->successful()) {
                $bill = $response->json();
                $subscription->update(['payment_gateway_bill_id' => $bill['id']]);

                return redirect()->away($bill['url']);
            } else {
                Log::error('Gagal membuat Bill Billplz: ' . $response->body());
                return back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
            }

        } catch (\Exception $e) {
            Log::error('Error saat proses checkout Billplz: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    // public function showCheckoutForm(Plan $plan)
    // {
    //     $grades = Grade::all();
    //     $user = Auth::user();
    //     $subtotal = $plan->price;
    //     $tax = $subtotal * 0.11;
    //     $total = $subtotal + $tax;

    //     $fpxBanks = collect();
    //     $eWallets = collect();
    //     $cards = collect();

    //     try {
    //         $apiKey = env('BILLPLZ_API_KEY');
    //         $xSignatureKey = env('BILLPLZ_X_SIGNATURE_KEY');

    //         if (!$apiKey || !$xSignatureKey) {
    //             Log::error('Kunci Billplz v5 tidak ditemukan di file .env');
    //             return view('frontend.subscription-checkout', compact('plan', 'grades', 'user', 'subtotal', 'tax', 'total', 'fpxBanks', 'eWallets', 'cards'));
    //         }

    //         $epoch = time();
    //         $checksum = hash_hmac('sha512', $epoch, $xSignatureKey);

    //         $url = env('BILLPLZ_URL');

    //         $response = Http::withBasicAuth($apiKey, '')
    //                         ->get($url, [
    //                             'epoch' => $epoch,
    //                             'checksum' => $checksum,
    //                         ]);

    //         if ($response->successful()) {
    //             $allGateways = collect($response->json()['payment_gateways']);
    //             $activeGateways = $allGateways->filter(fn($gateway) => $gateway['active'] && $gateway['extras']['visibility']);
                
    //             $fpxBanks = $activeGateways->filter(fn($gateway) => $gateway['extras']['isFpx']);
    //             $eWallets = $activeGateways->filter(fn($gateway) => $gateway['extras']['isObw'] && !$gateway['extras']['isFpx']);
    //             $cards = $activeGateways->filter(fn($gateway) => str_contains($gateway['extras']['name'] ?? '', 'Visa') || str_contains($gateway['extras']['name'] ?? '', 'Mastercard'));

    //         } else {
    //             Log::error('Gagal mengambil daftar gateway v5 dari SANDBOX: ' . $response->body());
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Error koneksi ke API Billplz v5 SANDBOX: ' . $e->getMessage());
    //     }
        
    //     return view('frontend.students.enrollments.payment', compact('plan', 'grades', 'user', 'subtotal', 'tax', 'total', 'fpxBanks', 'eWallets', 'cards'));
    // }

}