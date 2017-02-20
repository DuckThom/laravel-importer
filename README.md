<h1 align="center">Laravel Importer</h1>

<p align="center">
<a href="https://packagist.org/packages/luna/laravel-importer"><img src="https://poser.pugx.org/luna/laravel-importer/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/luna/laravel-importer"><img src="https://poser.pugx.org/luna/laravel-importer/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/luna/laravel-importer"><img src="https://poser.pugx.org/luna/laravel-importer/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://styleci.io/repos/82349568"><img src="https://styleci.io/repos/82349568/shield?branch=master" alt="StyleCI"></a>
<a href="https://travis-ci.org/DuckThom/laravel-importer"><img src="https://travis-ci.org/DuckThom/laravel-importer.svg?branch=master" alt="TravisCI"></a>
<a href="https://packagist.org/packages/luna/laravel-importer"><img src="https://poser.pugx.org/luna/laravel-importer/license" alt="License"></a>
</p>

<h3># Prerequisites</h3>
Before using this package, make sure you are at least running PHP 7.0 and that you have Laravel 5.4.

<h3># Setup</h3>
First, add this package to your `composer.json`:
```
    composer require luna/laravel-importer "~1.0"
```

Add the service provider and facade to `config/app.php`:
```php
    'providers' => [
        // ...
        // Package providers
        
        Luna\Importer\ServiceProvider::class,
    ],
     
    'aliases' => [
        // ...
        
        "Import" => Luna\Importer\ImporterFacade::class
    ]
```

Publish the configuration:
```
    php artisan vendor:publish --provider="Luna\Importer\ServiceProvider"
```

<h3># Features</h3>
This plugin currently only comes with a CSV runner which means it is only able to parse CSV files out of the box. There will be more info on how to add runners added later.

<h3># Documentation</h3>
http://laravel-importer.readthedocs.io/en/latest/

<h3># Example configuration</h3>
`config/importer.php`:
```php
return [
    /***********************************************************
     * Importers are used for defining specific import tasks
     * For instance, a ProductImporter could import a file with
     * products into a table.
     ***********************************************************/
    'importers' => [
        'default' => \App\Importers\ProductImporter::class
    ],

    /***********************************************************
     * Runners are used for looping through the file
     * The default is a CSV runner which will loop though
     * CSV files line-by-line. A runner uses an importer to get
     * import specific settings like the model class.
     ***********************************************************/
    'runners' => [
        'default' => \Luna\Importer\Runners\CsvRunner::class
    ]
];
```

<h3># Contributing</h3>
Pull requests for new features are welcome as long as they include tests for it as well.
