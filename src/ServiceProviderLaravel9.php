<?php

namespace Signalads\Laravel;

use Illuminate\Support\Facades\Notification;
use Signalads\Laravel\Channel\SignaladsChannel;
use Signalads\Laravel\Facade\Signalads;
use Signalads\Laravel\Service\SignaladsService;

class ServiceProviderLaravel9 extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/Config/config.php' => config_path('signalads.php')], 'signalads-laravel');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/config.php', 'signalads');

        Signalads::shouldProxyTo(SignaladsService::class);

        Notification::resolved(function ($service) {
            $service->extend('signalads', function ($app) {
                return new SignaladsChannel($app->make('signalads'));
            });
        });
    }
}
