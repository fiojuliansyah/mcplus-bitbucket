<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('frontend.layouts.partials.header', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $view->with([
                    'unreadNotifications' => $user->unreadNotifications,
                    'notifications' => $user->notifications()->limit(5)->get()
                ]);
            }
        });
    }
}
