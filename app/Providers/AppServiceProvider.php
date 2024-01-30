<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {


    }

    /**
     * Bootstrap any application services.
     */
    public function boot() {
        Gate::after(function ($user, $permission) {
            if($user->hasRole('Super Admin')) {
                return true;
            }
        });
    }
}