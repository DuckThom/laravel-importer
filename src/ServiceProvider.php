<?php

namespace Luna\Importer;

use \Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Import service provider
 *
 * @package     Luna\Importer
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('importer.php'),
        ], 'config');
    }

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('importer', function () {
            return new Importer;
        });
    }
}
