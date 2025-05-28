<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserSubscriptionController extends Controller
{
    public function index()
    {
        // Case 1: User has a subscription
        $subscription = [
            'plan_name' => '3 Month',
            'price' => 'RM30',
            'duration' => '3 Month',
            'expires_at' => Carbon::now()->addDays(20), // You can change the date
        ];

        // Case 2: No subscription (uncomment this line to test it)
        // $subscription = null;

        return view('frontend.mySubscription', compact('subscription'));
    }
}