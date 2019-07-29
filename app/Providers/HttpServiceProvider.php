<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Client', function ($app) {
            return new GuzzleHttp\Client();
        });
    }
}
