<?php

namespace Signalads\Laravel;

use Illuminate\Support\Facades\Notification;
use Signalads\Laravel\Facade\Signalads;
use Signalads\Laravel\Service\SignaladsService;

class ServiceProviderLaravel6 extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/config.php' => config_path('signalads.php')], 'signalads-laravel');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'signalads');

        Signalads::shouldProxyTo(SignaladsService::class);

        Notification::resolved(function ($service) {
            $service->extend('signalads', function ($app) {
                return new \Signalads\Laravel\Facade\Channel\SignaladsChannel($app->make('signalads'));
            });
        });
    }
}
