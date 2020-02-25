<?php

namespace ExpressMakers\API;

use Illuminate\Support\ServiceProvider;

class ExpressMakersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/expressmakers.php' => config_path('expressmakers.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/expressmakers.php', 'expressmakers'
        );
        $this->app->bind('ExpressMakers\API\ExpressMakers', function () {
            return new ExpressMakers(config('expressmakers.token'));
        });
    }
}
