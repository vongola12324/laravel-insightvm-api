<?php

namespace Vongola\InsightVmApi;

use Illuminate\Support\ServiceProvider;
use Vongola\InsightVmApi\Models\Base\Client;
use \Illuminate\Container\Container as Container;
use \Illuminate\Support\Facades\Facade as Facade;

class InsightVmApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/insightvm.php' => config_path('insightvm.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/insightvm.php', 'insightvm'
        );
        $this->app->singleton('Nexpose', function($app)
        {
            return new Client;
        });
        $this->app->singleton('Insightvm', function($app)
        {
            return new Client;
        });
    }
}