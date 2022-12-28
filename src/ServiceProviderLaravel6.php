<?php

namespace Signalads\Laravel;

use Signalads\SignaladsApi as SignaladsApi;
use Signalads\Laravel\Channel\SignaladsChannel;
use Illuminate\Support\Facades\Notification;

class ServiceProviderLaravel6 extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/config.php' => config_path('signalads.php')]);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'signalads');
        $this->app->singleton('signalads', function ($app) {
            return new SignaladsApi($app['config']->get('signalads.apikey'));
        });
        Notification::resolved(function ($service) {
            $service->extend('signalads', function ($app) {
                return new \Signalads\Laravel\Channel\SignaladsChannel($app->make('signalads'));
            });
        });
    }
}
