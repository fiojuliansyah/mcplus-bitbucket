<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['name', 'slug', 'code', 'start_date', 'end_date', 'type', 'amount', 'status', 'coupon_type'];

    protected $dates = ['start_date', 'end_date'];
}
