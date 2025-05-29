<?php

namespace App\Http\Controllers\User;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('frontend.subscription', compact('plans'));
    }
}