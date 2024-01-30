<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $users = User::all();
            $unreadNotifications = optional($user)->unreadNotifications; // Fetch notifications or any necessary data
            $readNotifications = optional($user)->readNotifications;

            $view->with([
                'readNotifications' => $readNotifications,
                'unreadNotifications' => $unreadNotifications,
                'user' => $user,
                'users' => $users,
            ]);
        });
    }
}
