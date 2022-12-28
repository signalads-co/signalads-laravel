<?php

namespace Signalads\Laravel;

use Signalads\SignaladsApi as SignaladsApi;
use Illuminate\Support\Facades\Notification;
use Signalads\Laravel\Channel\SignaladsChannel;

class ServiceProviderLaravel8 extends \Illuminate\Support\ServiceProvider
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
        Notification::resolved( function ( $service ) {
            $service->extend( 'signalads', function ( $app ) {
                return new SignaladsChannel( $app->make( 'signalads' ) );
            } );
        } );
    }
}
