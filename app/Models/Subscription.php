<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_code',
        'profile_id',
        'plan_id',
        'subject_id',
        'duration',
        'payment_method',
        'start_date',
        'end_date',
        'price',
        'coupon_id',
        'coupon_discount',
        'tax',
        'total_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_discount');
    }
}
