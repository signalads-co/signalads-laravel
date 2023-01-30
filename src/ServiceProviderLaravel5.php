<?php
namespace Signalads\Laravel;
use Signalads\Laravel\Facade\Signalads;
use Signalads\Laravel\Service\SignaladsService;

class ServiceProviderLaravel5 extends \Illuminate\Support\ServiceProvider
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
    }
}
