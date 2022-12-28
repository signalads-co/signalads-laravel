<?php

namespace Signalads\Laravel;

class ServiceProviderLaravel4 extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('signalads/laravel', null, __DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	$this->app['signalads'] = $this->app->share(function ($app) {
            return new \Kavenegar\KavenegarApi($app['config']->get('signalads::apikey'));
        });
    }
}
