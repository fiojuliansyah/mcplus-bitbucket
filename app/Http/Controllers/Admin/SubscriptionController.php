<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\User;
use App\Models\Subject;
use App\Models\Coupon;
use App\Models\Profile;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\SubscriptionDataTable;

class SubscriptionController extends Controller
{
    public function index(SubscriptionDataTable $dataTable)
    {
        $users = User::all();
        $profiles = Profile::all();
        $plans = Plan::all();
        $subjects = Subject::all();
        return $dataTable->render('admin.subscriptions.index', compact('users','profiles','plans','subjects'));
    }

    public function store(Request $request)
    {
        Subscription::create([
            'user_id' => $request->user_id,
            'profile_id' => $request->profile_id,
            'plan_id' => $request->plan_id,
            'subject_id' => $request->subject_id,
            'duration' => $request->duration,
            'payment_method' => $request->payment_method,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price' => $request->price,
            'coupon_discount' => $request->coupon_discount,
            'tax' => $request->tax,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->update([
            'user_id' => $request->user_id,
            'profile_id' => $request->profile_id,
            'plan_id' => $request->plan_id,
            'subject_id' => $request->subject_id,
            'duration' => $request->duration,
            'payment_method' => $request->payment_method,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price' => $request->price,
            'coupon_discount' => $request->coupon_discount,
            'tax' => $request->tax,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }
}
