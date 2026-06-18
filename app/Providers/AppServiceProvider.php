<?php

namespace App\Providers;

use App\Models\BusinessProfile;
use App\Models\Contact;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') || env('VERCEL')) {
            URL::forceScheme('https');
        }

        View::composer(['public.*', 'layouts.public', 'layouts.admin', 'admin.auth.login'], function ($view) {
            $view->with('businessProfile', BusinessProfile::first());
            $view->with('contact', Contact::first());
        });
    }
}
