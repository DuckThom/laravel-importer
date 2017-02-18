<?php

namespace Luna\Importer;

use Luna\Importer\Contracts\Runner;
use Luna\Importer\Contracts\Importer;
use \Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Import service provider
 *
 * @package     Luna\Importer
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ServiceProvider extends LaravelServiceProvider
{
    protected function boot()
    {
        $this->app->bind(Runner::class);

        $this->app->bind(Importer::class);
    }

    protected function register()
    {

    }
}