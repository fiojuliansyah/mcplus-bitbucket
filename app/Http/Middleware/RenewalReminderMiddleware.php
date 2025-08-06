<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Notifications\RenewalReminder;

class RenewalReminderMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $subscription = Subscription::where('user_id', $user->id)->first();

            if ($subscription) {
                $daysRemaining = $subscription->end_date->diffInDays(now());

                if ($daysRemaining == 7 || $daysRemaining == 1) {
                    $user->notify(new RenewalReminder($subscription));
                }
            }
        }

        return $next($request);
    }
}
