<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = [
            [
                'duration' => '3 Months',
                'price' => 'RM30',
                'recommended' => false,
            ],
            [
                'duration' => '6 Months',
                'price' => 'RM58',
                'recommended' => true,
            ],
            [
                'duration' => '12 Months',
                'price' => 'RM100',
                'recommended' => false,
            ],
        ];

        return view('frontend.subscription', compact('plans'));
    }
}