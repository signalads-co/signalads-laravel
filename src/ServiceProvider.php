<?php

namespace Signalads\Laravel;

use RuntimeException;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = false;

    /**
     * The actual provider.
     */
    protected \Illuminate\Support\ServiceProvider $provider;

    /**
     * Instantiate the service provider.
     *
     * @param mixed $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->provider = $this->getProvider();
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->provider->boot();
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register(): void
    {
        $this->provider->register();
    }

    /**
     * Return the service provider for the particular Laravel version.
     *
     * @return mixed
     */
    private function getProvider(): mixed
    {
        $app = $this->app;

        $version = intval($app::VERSION);

        switch ($version) {
            case 4:
                return new ServiceProviderLaravel4($app);
            case 5:
                return new ServiceProviderLaravel5($app);
            case 6:
                return new ServiceProviderLaravel6($app);
            case 7:
                return new ServiceProviderLaravel7($app);
            case 8:
                return new ServiceProviderLaravel8($app);
            case 9:
                return new ServiceProviderLaravel9($app);
            default:
                throw new RuntimeException('Your version of Laravel is not supported');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['signalads'];
    }
}
