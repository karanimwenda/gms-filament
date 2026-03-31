<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
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
        $this->forceHttps();
    }

    public function forceHttps(): void
    {
        /* Use https links instead http links */
        if (
            Request::server('HTTP_X_FORWARDED_PROTO') == 'https' ||
            app()->environment('production')
        ) {
            URL::forceScheme('https');
            $this->app->get('request')->server->set('HTTPS', true);
        }
    }
}
