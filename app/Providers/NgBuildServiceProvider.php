<?php

namespace App\Providers;

use App\Helpers\Angular;
use Illuminate\Support\ServiceProvider;

class NgBuildServiceProvider extends ServiceProvider
{
    /**
     * Register Helpers.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap Helpers.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Helpers\Angular', function ($app) {
            return new Angular();
        });
    }
}
