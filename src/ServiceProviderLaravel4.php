<?php

namespace Signalads\Laravel;

use Signalads\Laravel\Service\SignaladsService;
use Signalads\Laravel\Facade\Signalads;

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
        Signalads::shouldProxyTo(SignaladsService::class);
    }
}
