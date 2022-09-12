<?php

namespace Devixel;

use Illuminate\Support\ServiceProvider;

/**
 * Class PasswordServiceProvider
 */
class DevixelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hmac', HMAC::class);
    }
}